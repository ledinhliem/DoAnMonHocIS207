<?php
class CartModel
{
    public function __construct()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function add($product, $quantity = 1)
    {
        $quantity = max(1, (int)$quantity);
        $id = (int)$product['id'];

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity,
            ];
        }
    }

    public function update($id, $quantity)
    {
        $id = (int)$id;
        $quantity = (int)$quantity;

        if (!isset($_SESSION['cart'][$id])) {
            return;
        }

        if ($quantity <= 0) {
            unset($_SESSION['cart'][$id]);
            return;
        }

        $_SESSION['cart'][$id]['quantity'] = $quantity;
    }

    public function remove($id)
    {
        $id = (int)$id;
        unset($_SESSION['cart'][$id]);
    }

    public function getItems()
    {
        return array_values($_SESSION['cart']);
    }

    public function getSubtotal()
    {
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
    }
}