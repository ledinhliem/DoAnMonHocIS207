<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($title); ?></title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f8f4;
            color: #1f2937;
        }

        .container {
            width: 1200px;
            max-width: calc(100% - 40px);
            margin: 32px auto;
        }

        .page-title {
            text-align: center;
            font-size: 34px;
            color: #14532d;
            margin-bottom: 10px;
        }

        .page-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 32px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.25s ease;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            background: #e5e7eb;
            display: block;
        }

        .card-body {
            padding: 16px;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            color: #14532d;
            margin-bottom: 8px;
            min-height: 48px;
        }

        .meta {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
            min-height: 20px;
        }

        .desc {
            font-size: 14px;
            line-height: 1.55;
            color: #374151;
            min-height: 66px;
            margin-bottom: 12px;
        }

        .price {
            font-size: 22px;
            font-weight: bold;
            color: #2e7d32;
            margin-bottom: 10px;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 999px;
            font-size: 12px;
            margin-bottom: 12px;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            background: #2e7d32;
            color: white;
            padding: 10px 16px;
            border-radius: 10px;
            font-weight: bold;
        }

        .empty-box {
            background: white;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-title">Sản phẩm bền vững</div>
        <div class="page-subtitle">Module Product List cho dự án Sustainable E-commerce</div>

        <?php if (!empty($products)): ?>
            <div class="grid">
                <?php foreach ($products as $item): ?>
                    <?php
                        $imagePath = !empty($item['HinhAnh']) ? $item['HinhAnh'] : 'https://via.placeholder.com/500x350?text=No+Image';
                        $description = !empty($item['MoTa']) ? $item['MoTa'] : 'Chưa có mô tả sản phẩm.';
                        $shortDesc = mb_strimwidth($description, 0, 100, '...');
                    ?>
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($item['TenSanPham']); ?>">

                        <div class="card-body">
                            <div class="card-title"><?php echo htmlspecialchars($item['TenSanPham']); ?></div>

                            <div class="meta">
                                <?php echo htmlspecialchars($item['TenDanhMuc'] ?? 'Chưa có danh mục'); ?>
                                |
                                <?php echo htmlspecialchars($item['TenThuongHieu'] ?? 'Chưa có thương hiệu'); ?>
                            </div>

                            <div class="desc"><?php echo htmlspecialchars($shortDesc); ?></div>

                            <div class="price">
                                <?php echo number_format((float)($item['GiaTu'] ?? 0), 0, ',', '.'); ?> đ
                            </div>

                            <div class="badge">
                                Điểm xanh: <?php echo htmlspecialchars($item['DiemXanh'] ?? 0); ?>
                            </div>
                            <br>

                            <a class="btn" href="index.php?url=product/detail/<?php echo $item['MaSanPham']; ?>">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-box">
                Chưa có sản phẩm nào để hiển thị.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>