<?php

class FlashSaleModel extends Model
{
    public function getActiveSalesForProducts(array $productIds): array
    {
        $productIds = array_values(array_unique(array_filter($productIds)));

        if (empty($productIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($productIds), '?'));

        try {
            $stmt = $this->db->prepare("
                SELECT *
                FROM flash_sales
                WHERE status = 1
                  AND start_time <= NOW()
                  AND end_time > NOW()
                  AND sold_count < stock_limit
                  AND product_id IN ($placeholders)
                ORDER BY sale_price ASC, end_time ASC
            ");
            $stmt->execute($productIds);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return [];
        }

        $sales = [];
        foreach ($rows as $row) {
            $productId = $row['product_id'] ?? '';
            if ($productId !== '' && !isset($sales[$productId])) {
                $sales[$productId] = $this->normalizeSale($row);
            }
        }

        return $sales;
    }

    public function getActiveSaleForProduct(string $productId): ?array
    {
        $sales = $this->getActiveSalesForProducts([$productId]);
        return $sales[$productId] ?? null;
    }

    public function getActiveSaleForVariant(string $productId, string $variantId): ?array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT *
                FROM flash_sales
                WHERE status = 1
                  AND product_id = ?
                  AND (variant_id IS NULL OR variant_id = '' OR variant_id = ?)
                  AND start_time <= NOW()
                  AND end_time > NOW()
                  AND sold_count < stock_limit
                ORDER BY
                  CASE WHEN variant_id = ? THEN 0 ELSE 1 END,
                  sale_price ASC,
                  end_time ASC
                LIMIT 1
            ");
            $stmt->execute([$productId, $variantId, $variantId]);
            $sale = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            return null;
        }

        return $sale ? $this->normalizeSale($sale) : null;
    }

    public function incrementSoldCount(int $flashSaleId, int $quantity): bool
    {
        if ($flashSaleId <= 0 || $quantity <= 0) {
            return false;
        }

        try {
            $stmt = $this->db->prepare("
                UPDATE flash_sales
                SET sold_count = sold_count + ?
                WHERE id = ?
                  AND status = 1
                  AND start_time <= NOW()
                  AND end_time > NOW()
                  AND sold_count + ? <= stock_limit
            ");
            $stmt->execute([$quantity, $flashSaleId, $quantity]);
            return $stmt->rowCount() === 1;
        } catch (Throwable $e) {
            return false;
        }
    }

    private function normalizeSale(array $sale): array
    {
        $sale['id'] = (int)($sale['id'] ?? 0);
        $sale['sale_price'] = (float)($sale['sale_price'] ?? 0);
        $sale['stock_limit'] = (int)($sale['stock_limit'] ?? 0);
        $sale['sold_count'] = (int)($sale['sold_count'] ?? 0);
        $sale['remaining'] = max(0, $sale['stock_limit'] - $sale['sold_count']);
        $sale['is_flash_sale'] = $sale['remaining'] > 0;

        return $sale;
    }
}
