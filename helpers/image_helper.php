<?php

if (!function_exists('product_image_url')) {
    function product_image_url(string $path): string
    {
        if ($path === '') {
            return '';
        }

        if (preg_match('/^https?:\/\//', $path)) {
            return $path;
        }

        if (str_starts_with($path, 'public/')) {
            return BASE_URL . ltrim($path, '/');
        }

        $fileName = basename($path);
        if ($fileName === 'P005_V005_Giayshoex_den.png') {
            $fileName = 'P005_V006_Giayshoex_den.png';
        }

        if (file_exists(ROOT_PATH . '/public/assets/images/products/' . $fileName)) {
            return BASE_URL . 'public/assets/images/products/' . $fileName;
        }

        return BASE_URL . 'public/images/Products/' . $fileName;
    }
}

if (!function_exists('blog_image_url')) {
    function blog_image_url(?string $image): string
    {
        $fallback = 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1200&q=80';

        if (empty($image)) {
            return $fallback;
        }

        if (str_starts_with($image, 'http')) {
            return $image;
        }

        if (str_starts_with($image, 'public/')) {
            return BASE_URL . ltrim($image, '/');
        }

        $imageMap = [
            'BL001_ZeroWaste.jpg' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1200&q=80',
            'BL002_VaiSoiCafe.webp' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1200&q=80',
            'BL003_HatViNhua.jpg' => 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?auto=format&fit=crop&w=1200&q=80',
        ];

        if (isset($imageMap[$image])) {
            return $imageMap[$image];
        }

        $fileName = basename($image);
        if (file_exists(ROOT_PATH . '/public/assets/images/blog/' . $fileName)) {
            return BASE_URL . 'public/assets/images/blog/' . $fileName;
        }

        return $fallback;
    }
}
