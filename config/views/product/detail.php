<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['TenSanPham']); ?></title>
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

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #2e7d32;
            text-decoration: none;
            font-weight: bold;
        }

        .wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .main-image {
            width: 100%;
            height: 430px;
            object-fit: cover;
            border-radius: 16px;
            background: #e5e7eb;
            display: block;
        }

        .thumbs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
        }

        .thumbs img {
            width: 88px;
            height: 88px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            background: #e5e7eb;
        }

        .product-title {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 32px;
            color: #14532d;
        }

        .info {
            margin-bottom: 8px;
            color: #4b5563;
        }

        .price {
            font-size: 30px;
            font-weight: bold;
            color: #2e7d32;
            margin: 18px 0;
        }

        .section-title {
            margin-top: 24px;
            margin-bottom: 12px;
            font-size: 18px;
            font-weight: bold;
            color: #14532d;
        }

        .desc {
            line-height: 1.7;
            color: #374151;
        }

        .variant-list {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .variant-item {
            min-width: 180px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 12px;
            background: #f9fff9;
        }

        .variant-item div {
            margin-bottom: 6px;
        }

        .cert-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .cert-item {
            padding: 8px 12px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 999px;
            font-size: 13px;
        }

        .cert-detail {
            margin-top: 10px;
            padding: 12px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        @media (max-width: 900px) {
            .wrapper {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="back-link" href="index.php?url=product">← Quay lại danh sách sản phẩm</a>

        <?php
            $mainImage = 'https://via.placeholder.com/700x500?text=No+Image';
            if (!empty($images) && !empty($images[0]['DuongDan'])) {
                $mainImage = $images[0]['DuongDan'];
            }

            $minPrice = 0;
            if (!empty($variants)) {
                $prices = array_column($variants, 'GiaTien');
                $minPrice = min($prices);
            }
        ?>

        <div class="wrapper">
            <div>
                <img class="main-image" src="<?php echo htmlspecialchars($mainImage); ?>" alt="<?php echo htmlspecialchars($product['TenSanPham']); ?>">

                <div class="thumbs">
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $img): ?>
                            <img src="<?php echo htmlspecialchars($img['DuongDan']); ?>" alt="Ảnh sản phẩm">
                        <?php endforeach; ?>
                    <?php else: ?>
                        <img src="https://via.placeholder.com/100x100?text=No+Image" alt="No image">
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <h1 class="product-title"><?php echo htmlspecialchars($product['TenSanPham']); ?></h1>

                <div class="info"><strong>Danh mục:</strong> <?php echo htmlspecialchars($product['TenDanhMuc'] ?? 'Chưa có'); ?></div>
                <div class="info"><strong>Thương hiệu:</strong> <?php echo htmlspecialchars($product['TenThuongHieu'] ?? 'Chưa có'); ?></div>
                <div class="info"><strong>Vật liệu:</strong> <?php echo htmlspecialchars($product['TenVatLieu'] ?? 'Chưa có'); ?></div>
                <div class="info"><strong>Điểm xanh:</strong> <?php echo htmlspecialchars($product['DiemXanh'] ?? 0); ?></div>
                <div class="info"><strong>Trạng thái:</strong> <?php echo htmlspecialchars($product['TrangThai'] ?? 'Chưa xác định'); ?></div>

                <div class="price">
                    <?php echo number_format((float)$minPrice, 0, ',', '.'); ?> đ
                </div>

                <div class="section-title">Mô tả sản phẩm</div>
                <div class="desc">
                    <?php echo nl2br(htmlspecialchars($product['MoTa'] ?? 'Chưa có mô tả.')); ?>
                </div>

                <div class="section-title">Biến thể sản phẩm</div>
                <div class="variant-list">
                    <?php if (!empty($variants)): ?>
                        <?php foreach ($variants as $variant): ?>
                            <div class="variant-item">
                                <div><strong>Màu:</strong> <?php echo htmlspecialchars($variant['MauSac'] ?? 'N/A'); ?></div>
                                <div><strong>Size:</strong> <?php echo htmlspecialchars($variant['KichThuoc'] ?? 'N/A'); ?></div>
                                <div><strong>Giá:</strong> <?php echo number_format((float)($variant['GiaTien'] ?? 0), 0, ',', '.'); ?> đ</div>
                                <div><strong>Tồn kho:</strong> <?php echo htmlspecialchars($variant['SoLuongTon'] ?? 0); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>Chưa có biến thể sản phẩm.</div>
                    <?php endif; ?>
                </div>

                <div class="section-title">Chứng nhận bền vững</div>
                <div class="cert-list">
                    <?php if (!empty($certificates)): ?>
                        <?php foreach ($certificates as $cert): ?>
                            <div class="cert-item">
                                <?php echo htmlspecialchars($cert['TenChungNhan']); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>Chưa có chứng nhận.</div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($certificates)): ?>
                    <div class="section-title">Thông tin chứng nhận</div>
                    <?php foreach ($certificates as $cert): ?>
                        <div class="cert-detail">
                            <div><strong>Tên:</strong> <?php echo htmlspecialchars($cert['TenChungNhan']); ?></div>
                            <div><strong>Tổ chức cấp:</strong> <?php echo htmlspecialchars($cert['ToChucCap'] ?? 'Chưa có'); ?></div>
                            <div><strong>Mô tả:</strong> <?php echo htmlspecialchars($cert['MoTa'] ?? 'Chưa có mô tả'); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>