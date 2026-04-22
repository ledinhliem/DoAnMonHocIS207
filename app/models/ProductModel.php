<?php
class ProductModel
{
    private $products = [
        [
            'id' => 1,
            'name' => 'Honed Stone Pitcher',
            'price' => 68,
            'category' => 'kitchenware',
            'impact' => 'plastic-free',
            'rating' => 4.8,
            'image' => 'https://images.unsplash.com/photo-1610701596007-11502861dcfa?auto=format&fit=crop&w=900&q=80',
            'description' => 'Bình gốm thủ công tối giản, phù hợp decor và sử dụng hằng ngày.',
        ],
        [
            'id' => 2,
            'name' => 'Terra Ceramic Vessel',
            'price' => 185,
            'category' => 'living-room',
            'impact' => 'carbon-neutral',
            'rating' => 4.9,
            'image' => 'https://images.unsplash.com/photo-1517705008128-361805f42e86?auto=format&fit=crop&w=900&q=80',
            'description' => 'Bình gốm cao cấp theo phong cách organic, bền vững và sang trọng.',
        ],
        [
            'id' => 3,
            'name' => 'Floating Cork Plank',
            'price' => 120,
            'category' => 'bedroom',
            'impact' => 'upcycled',
            'rating' => 4.5,
            'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=900&q=80',
            'description' => 'Tấm cork thân thiện môi trường, tạo cảm giác ấm áp cho không gian.',
        ],
        [
            'id' => 4,
            'name' => 'Aegean Pendant Light',
            'price' => 480,
            'category' => 'living-room',
            'impact' => 'plastic-free',
            'rating' => 4.7,
            'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=900&q=80',
            'description' => 'Đèn thả hiện đại với chất liệu tái chế, tạo điểm nhấn nổi bật.',
        ],
        [
            'id' => 5,
            'name' => 'Honed Oak Lounge Chair',
            'price' => 1240,
            'category' => 'living-room',
            'impact' => 'carbon-neutral',
            'rating' => 5.0,
            'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=900&q=80',
            'description' => 'Ghế lounge gỗ sồi thiết kế tinh giản, phù hợp không gian xanh.',
        ],
        [
            'id' => 6,
            'name' => 'Wellness Ritual Set',
            'price' => 95,
            'category' => 'wellness',
            'impact' => 'plastic-free',
            'rating' => 4.6,
            'image' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?auto=format&fit=crop&w=900&q=80',
            'description' => 'Bộ wellness thân thiện môi trường cho sinh hoạt hằng ngày.',
        ],
    ];

    public function getAll($filters = [])
    {
        $products = $this->products;

        if (!empty($filters['keyword'])) {
            $keyword = mb_strtolower(trim($filters['keyword']));
            $products = array_filter($products, function ($product) use ($keyword) {
                return str_contains(mb_strtolower($product['name']), $keyword)
                    || str_contains(mb_strtolower($product['description']), $keyword);
            });
        }

        if (!empty($filters['category'])) {
            $category = $filters['category'];
            $products = array_filter($products, function ($p) use ($category) {
                return $p['category'] === $category;
            });
        }

        if (!empty($filters['impact'])) {
            $impact = $filters['impact'];
            $products = array_filter($products, function ($p) use ($impact) {
                return $p['impact'] === $impact;
            });
        }

        if (isset($filters['price_max']) && $filters['price_max'] !== '') {
            $priceMax = (float)$filters['price_max'];
            $products = array_filter($products, function ($p) use ($priceMax) {
                return $p['price'] <= $priceMax;
            });
        }

        $sort = $filters['sort'] ?? '';
        if ($sort === 'price_asc') {
            usort($products, fn($a, $b) => $a['price'] <=> $b['price']);
        } elseif ($sort === 'price_desc') {
            usort($products, fn($a, $b) => $b['price'] <=> $a['price']);
        } elseif ($sort === 'impact_desc') {
            usort($products, fn($a, $b) => $b['rating'] <=> $a['rating']);
        } else {
            usort($products, fn($a, $b) => $a['id'] <=> $b['id']);
        }

        return array_values($products);
    }

    public function getById($id)
    {
        foreach ($this->products as $product) {
            if ((int)$product['id'] === (int)$id) {
                return $product;
            }
        }
        return null;
    }

    public function getCategories()
    {
        return [
            'kitchenware' => 'Kitchenware',
            'living-room' => 'Living Room',
            'bedroom' => 'Bedroom',
            'wellness' => 'Wellness',
        ];
    }

    public function getImpacts()
    {
        return [
            'carbon-neutral' => 'Carbon Neutral',
            'plastic-free' => 'Plastic Free',
            'upcycled' => 'Upcycled Materials',
        ];
    }
}