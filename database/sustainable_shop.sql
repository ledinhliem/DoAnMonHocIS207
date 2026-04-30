-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 27, 2026 lúc 04:08 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `sustainable_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baiviet`
--

CREATE TABLE `baiviet` (
  `MaBaiViet` varchar(20) NOT NULL,
  `TieuDe` varchar(255) NOT NULL,
  `NoiDung` text NOT NULL,
  `HinhAnhBia` varchar(255) DEFAULT NULL,
  `NgayDang` datetime DEFAULT NULL,
  `MaNguoiDung` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `baiviet`
--

INSERT INTO `baiviet` (`MaBaiViet`, `TieuDe`, `NoiDung`, `HinhAnhBia`, `NgayDang`, `MaNguoiDung`) VALUES
('BL001', 'Hành trình Zero Waste: Từ ý tưởng đến lối sống bền vững mỗi ngày', '1. Cốt lõi của Zero Waste: Nguyên tắc 5R. Để bắt đầu, bạn không cần phải mua sắm những thiết bị đắt tiền. Hãy áp dụng triệt để nguyên tắc 5R: Refuse (Từ chối) những thứ không cần thiết; Reduce (Tiết giảm) mua sắm bốc đồng; Reuse (Tái sử dụng) các vật dụng như bình nước, túi vải; Recycle (Tái chế) rác vô cơ và Rot (Ủ phân) rác hữu cơ.\r\n\r\n2. 3 Bước Đơn Giản Để Bắt Đầu. Bạn có thể bắt đầu từ việc mang theo bộ dụng cụ ăn uống cá nhân và ống hút cỏ bàng Equo khi đi cà phê. Tiếp theo, hãy thay đổi không gian phòng tắm bằng bàn chải tre và mỹ phẩm thuần chay Cocoon để loại bỏ hạt vi nhựa.\r\n\r\nKết luận: Zero Waste không phải là sự hoàn hảo, mà là nỗ lực của hàng triệu người làm điều đó một cách không hoàn hảo để bảo vệ Trái Đất.', 'BL001_ZeroWaste.jpg', '2026-04-10 08:30:00', 'U001'),
('BL002', 'Công nghệ vải sợi Cà phê: Bước đột phá trong ngành thời trang tuần hoàn', 'Thời trang xanh không còn là xa xỉ. Ngành dệt may là ngành gây ô nhiễm thứ hai thế giới, nhưng sợi S.Café® đang thay đổi điều đó. Quy trình bắt đầu bằng việc thu gom bã cà phê từ các chuỗi cửa hàng, sau đó nghiền nhỏ thành bột mịn và trộn với polymer từ chai nhựa PET tái chế.\r\n\r\nƯu điểm vượt trội: Vải sợi cà phê có khả năng khử mùi tự nhiên (nhờ cấu trúc xốp của bã cafe), khô nhanh gấp 200% so với cotton và chống tia UV hiệu quả. Những chiếc áo Polo của Coolmate hay giày ShoeX tại Zentro chính là minh chứng cho việc phế phẩm nông nghiệp có thể trở thành sản phẩm thời trang cao cấp, bền bỉ và thân thiện với môi trường.', 'BL002_VaiSoiCafe.webp', '2026-04-15 14:20:00', 'U002'),
('BL003', 'Tẩy da chết thuần chay: Tại sao chúng ta nên nói không với hạt vi nhựa?', 'Hạt vi nhựa (Microbeads) - Kẻ thù thầm lặng. Hàng tỷ hạt nhựa nhỏ trong các loại kem tẩy tế bào chết công nghiệp đang trôi ra đại dương, xâm nhập vào chuỗi thức ăn và gây hại cho sức khỏe con người.\r\n\r\nGiải pháp từ nông sản Việt: Tại Zentro, chúng tôi tin dùng dòng tẩy da chết cà phê Đắk Lắk của Cocoon. Những hạt cà phê xay nhuyễn với kích thước chuẩn xác giúp loại bỏ lớp sừng già cỗi mà không gây xước da. Kết hợp cùng bơ ca cao Tiền Giang, sản phẩm không chỉ làm sạch mà còn dưỡng ẩm sâu. Quan trọng nhất, sau khi rửa trôi, hạt cà phê sẽ phân hủy hoàn toàn, trả lại sự trong lành cho nguồn nước.', 'BL003_TayDaChet.jpeg', '2026-04-24 16:45:00', 'U003'),
('BL004', 'Limloop và giấc mơ tái sinh rác thải nhựa thành nghệ thuật thủ công', 'Mỗi chiếc túi là một câu chuyện. Phải mất 500 năm để một chiếc túi nilon phân hủy, nhưng tại Limloop, chúng chỉ mất vài ngày để trở thành một phụ kiện thời trang. Quy trình \"Upcycling\" (Tái chế nâng cấp) bắt đầu bằng việc thu gom túi nilon cũ, khử trùng và cắt thành sợi.\r\n\r\nCác nghệ nhân là người khuyết tật sẽ tỉ mỉ dệt những sợi nilon này trên khung cửi truyền thống để tạo ra những tấm vải có vân màu độc bản. Mỗi chiếc túi Laptop hay túi Tote bạn mua tại Zentro không chỉ giúp \"giải cứu\" môi trường khỏi rác thải nhựa mà còn tạo ra sinh kế bền vững và sự tự tin cho những mảnh đời kém may mắn.', 'BL004_Limloop.webp', '2026-04-24 16:45:00', 'U004');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bienthesanpham`
--

CREATE TABLE `bienthesanpham` (
  `MaBienThe` varchar(20) NOT NULL,
  `MaSanPham` varchar(20) NOT NULL,
  `KichThuoc` varchar(50) DEFAULT NULL,
  `MauSac` varchar(50) DEFAULT NULL,
  `GiaTien` decimal(15,2) NOT NULL DEFAULT 0.00,
  `SoLuongTon` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bienthesanpham`
--

INSERT INTO `bienthesanpham` (`MaBienThe`, `MaSanPham`, `KichThuoc`, `MauSac`, `GiaTien`, `SoLuongTon`) VALUES
('V001', 'P001', '200ml', NULL, 130000.00, 50),
('V002', 'P002', '1000ml', NULL, 530000.00, 12),
('V003', 'P003', '50 cái/hộp', NULL, 55000.00, 99),
('V004', 'P004', '30 chiếc/hộp (mỗi loại 10 chiếc)', NULL, 70000.00, 48),
('V005', 'P005', 'Size EU 38 ', 'Xám', 1900000.00, 10),
('V006', 'P005', 'Size EU 38', 'Đen', 1900000.00, 2),
('V007', 'P006', 'Size M', 'Đen', 320000.00, 15),
('V008', 'P006', 'Size M', 'Xanh Navy', 320000.00, 40),
('V009', 'P007', '36x28', NULL, 430000.00, 5),
('V010', 'P008', 'Bộ 3 (S - M - L)', NULL, 99000.00, 45),
('V011', 'P009', '230g', 'LemonGrass&Ginger', 520000.00, 5),
('V012', 'P009', '230g', 'Lemon&Lavender', 500000.00, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaDonHang` varchar(20) NOT NULL,
  `MaBienThe` varchar(20) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaDonHang`, `MaBienThe`, `SoLuong`, `DonGia`) VALUES
('O001', 'V001', 1, 130000.00),
('O001', 'V003', 2, 55000.00),
('O002', 'V002', 1, 530000.00),
('O002', 'V010', 1, 99000.00),
('O003', 'V007', 1, 320000.00),
('O004', 'V005', 1, 1900000.00),
('O005', 'V011', 1, 520000.00),
('O005', 'V012', 1, 500000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietgiohang`
--

CREATE TABLE `chitietgiohang` (
  `MaGioHang` varchar(20) NOT NULL,
  `MaBienThe` varchar(20) NOT NULL,
  `SoLuong` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietgiohang`
--

INSERT INTO `chitietgiohang` (`MaGioHang`, `MaBienThe`, `SoLuong`) VALUES
('CRT001', 'V001', 2),
('CRT001', 'V007', 1),
('CRT001', 'V011', 1),
('CRT002', 'V003', 4),
('CRT002', 'V005', 1),
('CRT003', 'V002', 1),
('CRT003', 'V007', 1),
('CRT003', 'V008', 1),
('CRT003', 'V009', 3),
('CRT004', 'V012', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieunhap`
--

CREATE TABLE `chitietphieunhap` (
  `MaPhieuNhap` varchar(20) NOT NULL,
  `MaBienThe` varchar(20) NOT NULL,
  `SoLuongNhap` int(11) NOT NULL,
  `GiaNhap` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietphieunhap`
--

INSERT INTO `chitietphieunhap` (`MaPhieuNhap`, `MaBienThe`, `SoLuongNhap`, `GiaNhap`) VALUES
('R001', 'V001', 20, 85000.00),
('R001', 'V002', 8, 380000.00),
('R002', 'V003', 50, 32000.00),
('R002', 'V004', 30, 45000.00),
('R003', 'V005', 5, 1250000.00),
('R003', 'V006', 3, 1250000.00),
('R004', 'V007', 10, 230000.00),
('R004', 'V008', 5, 240000.00),
('R005', 'V009', 5, 300000.00),
('R005', 'V010', 25, 62000.00),
('R005', 'V011', 3, 350000.00),
('R005', 'V012', 3, 350000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chungnhan`
--

CREATE TABLE `chungnhan` (
  `MaChungNhan` varchar(20) NOT NULL,
  `TenChungNhan` varchar(100) DEFAULT NULL,
  `Logo` varchar(255) DEFAULT NULL,
  `MoTa` text DEFAULT NULL,
  `ToChucCap` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `MaDanhGia` varchar(20) NOT NULL,
  `MaNguoiDung` varchar(20) DEFAULT NULL,
  `MaSanPham` varchar(20) DEFAULT NULL,
  `SoSao` int(11) DEFAULT 5,
  `NoiDung` text DEFAULT NULL,
  `NgayDanhGia` datetime DEFAULT current_timestamp(),
  `TrangThai` int(11) DEFAULT 0,
  `PhanHoiAdmin` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`MaDanhGia`, `MaNguoiDung`, `MaSanPham`, `SoSao`, `NoiDung`, `NgayDanhGia`, `TrangThai`, `PhanHoiAdmin`) VALUES
('RV001', 'U002', 'P001', 5, 'Sản phẩm tẩy da chết thơm mùi cà phê, dùng xong da mềm hơn.', '2026-04-27 09:06:38', 1, NULL),
('RV002', 'U003', 'P002', 4, 'Dung tích lớn, tẩy trang sạch và khá dịu da.', '2026-04-27 09:06:38', 1, NULL),
('RV003', 'U004', 'P006', 5, 'Áo mặc mát, chất vải nhẹ và màu đen dễ phối.', '2026-04-27 09:06:38', 1, NULL),
('RV004', 'U005', 'P005', 4, 'Giày nhẹ, kiểu dáng đẹp, giá hơi cao nhưng chất lượng ổn.', '2026-04-27 09:06:38', 0, NULL),
('RV005', 'U002', 'P009', 3, 'Mùi nến hơi nồng hơn mong đợi.', '2026-04-27 09:06:38', -1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDanhMuc` varchar(20) NOT NULL,
  `TenDanhMuc` varchar(100) NOT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`MaDanhMuc`, `TenDanhMuc`, `HinhAnh`) VALUES
('C001', 'Zentro Kitchen', 'zentro-kitchen.jpg'),
('C002', 'Zentro Decor', 'zentro-decor.jpg'),
('C003', 'Zentro Fashion', 'zentro-fashion.jpg'),
('C004', 'Zentro Care', 'zentro-care.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi`
--

CREATE TABLE `diachi` (
  `MaDiaChi` varchar(20) NOT NULL,
  `MaNguoiDung` varchar(20) NOT NULL,
  `SoNha_Duong` varchar(255) NOT NULL,
  `PhuongXa` varchar(100) DEFAULT NULL,
  `QuanHuyen` varchar(100) DEFAULT NULL,
  `TinhThanh` varchar(100) DEFAULT NULL,
  `MacDinh` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDonHang` varchar(20) NOT NULL,
  `MaNguoiDung` varchar(20) DEFAULT NULL,
  `NgayDat` datetime DEFAULT current_timestamp(),
  `TongTien` decimal(15,2) NOT NULL,
  `TrangThai` varchar(50) DEFAULT 'Chờ Xử Lý',
  `DiaChiGiaoHang` varchar(255) NOT NULL,
  `MaPTTT` varchar(20) DEFAULT NULL,
  `MaPTVC` varchar(20) DEFAULT NULL,
  `MaCode` varchar(20) DEFAULT NULL,
  `MaDiaChi` varchar(20) DEFAULT NULL,
  `TenNguoiNhan` varchar(100) DEFAULT NULL,
  `SDTNguoiNhan` varchar(15) DEFAULT NULL,
  `SoTienGiam` decimal(15,2) DEFAULT 0.00,
  `PhiVanChuyen` decimal(15,2) DEFAULT 0.00,
  `ThanhTienCuoi` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `MaNguoiDung`, `NgayDat`, `TongTien`, `TrangThai`, `DiaChiGiaoHang`, `MaPTTT`, `MaPTVC`, `MaCode`, `MaDiaChi`, `TenNguoiNhan`, `SDTNguoiNhan`, `SoTienGiam`, `PhiVanChuyen`, `ThanhTienCuoi`) VALUES
('O001', 'U002', '2026-04-24 00:00:00', 240000.00, '0', 'Dĩ An, Bình Dương', NULL, NULL, NULL, NULL, 'Nguyễn Thị B', '911111111', 0.00, 20000.00, 260000.00),
('O002', 'U003', '2026-04-24 00:00:00', 629000.00, '1', 'TP. Thủ Đức, TP.HCM', NULL, NULL, NULL, NULL, 'Nguyễn Thị C', '922222222', 0.00, 25000.00, 654000.00),
('O003', 'U004', '2026-04-25 00:00:00', 320000.00, '2', 'Quận 7, TP.HCM', NULL, NULL, NULL, NULL, 'Nguyễn Thị D', '933333333', 0.00, 20000.00, 340000.00),
('O004', 'U005', '2026-04-25 00:00:00', 1900000.00, '3', 'Quận 1, TP.HCM', NULL, NULL, NULL, NULL, 'Nguyễn Thị E', '944444444', 0.00, 0.00, 1900000.00),
('O005', 'U002', '2026-04-26 00:00:00', 1020000.00, '4', 'Dĩ An, Bình Dương', NULL, NULL, NULL, NULL, 'Nguyễn Thị B', '911111111', 0.00, 0.00, 1020000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGioHang` varchar(20) NOT NULL,
  `MaNguoiDung` varchar(20) NOT NULL,
  `NgayTao` datetime DEFAULT current_timestamp(),
  `NgayCapNhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGioHang`, `MaNguoiDung`, `NgayTao`, `NgayCapNhat`) VALUES
('CRT001', 'U002', '2026-04-27 09:05:22', '2026-04-27 09:05:22'),
('CRT002', 'U003', '2026-04-27 09:05:22', '2026-04-27 09:05:22'),
('CRT003', 'U004', '2026-04-27 09:05:22', '2026-04-27 09:05:22'),
('CRT004', 'U005', '2026-04-27 09:05:22', '2026-04-27 09:05:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhanhsanpham`
--

CREATE TABLE `hinhanhsanpham` (
  `MaHinhAnh` varchar(20) NOT NULL,
  `MaSanPham` varchar(20) DEFAULT NULL,
  `DuongDan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hinhanhsanpham`
--

INSERT INTO `hinhanhsanpham` (`MaHinhAnh`, `MaSanPham`, `DuongDan`) VALUES
('IMG001', 'P001', 'P001_V001_TaydachetCocoon.jpg'),
('IMG002', 'P002', 'P002_V002_TaytrangCocoon.jpg'),
('IMG003', 'P003', 'P003_V003_OnghutEquo.jpg'),
('IMG004', 'P004', 'P004_V004_Bodaomuongnia.jpg'),
('IMG005', 'P005', 'P005_V005_Giayshoex_xam.png'),
('IMG006', 'P005', 'P005_V005_Giayshoex_den.png'),
('IMG007', 'P006', 'P006_V007_AopoloCafe_den.avif'),
('IMG008', 'P006', 'P006_V008_AopoloCafe_xanhnavy.avif'),
('IMG009', 'P007', 'P007_V009_TuidungLapLimloop.webp'),
('IMG010', 'P008', 'P008_V010_Bocthucpham.jpg'),
('IMG011', 'P009', 'P009_V011_Nenthom_LemonGrass&Ginger.jpg'),
('IMG012', 'P009', 'P009_V012_Nenthom_Lemon&Lavender.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `magiamgia`
--

CREATE TABLE `magiamgia` (
  `MaCode` varchar(20) NOT NULL,
  `PhamTramGiam` int(11) NOT NULL,
  `SoLuong` int(11) DEFAULT 100,
  `NgayHetHan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `magiamgia`
--

INSERT INTO `magiamgia` (`MaCode`, `PhamTramGiam`, `SoLuong`, `NgayHetHan`) VALUES
('DEALHUYDIET', 30, 30, '2026-04-30'),
('EARTHDAY26', 26, 100, '2026-05-30'),
('SAVEPLANET', 20, 50, '2026-06-30'),
('ZENTROGREEN', 10, 500, '2026-12-31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MaNguoiDung` varchar(20) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `MaQuyen` varchar(20) DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`MaNguoiDung`, `HoTen`, `Email`, `MatKhau`, `SoDienThoai`, `MaQuyen`, `NgayTao`) VALUES
('11', 'lan', 'thanhcong_final@gmail.com', '$2y$10$zMqev447OOAizg6t8oV4Cu8TnimND1isQBYGGgAHWDx8soPYMmPOW', '', '2', '2026-04-10 10:09:35'),
('12', 'lan', 'abc@gmail.com.vn', '$2y$10$ZaIEmIjWQJGckB7K5DdMAOzjuLek/xBCRsCBAA7M01i13LK1nTJ6m', '', '2', '2026-04-10 10:10:02'),
('U001', 'Nguyễn Văn A', 'admin@zentro.com', '123456', '0900000000', '1', '2026-04-27 09:03:37'),
('U002', 'Nguyễn Thị B', 'khachhang01@gmail.com.vn', '123456', '0911111111', '2', '2026-04-27 09:03:37'),
('U003', 'Nguyễn Thị C', 'khachhang02@gmail.com.vn', '123456', '0922222222', '2', '2026-04-27 09:03:37'),
('U004', 'Nguyễn Thị D', 'khachhang03@gmail.com.vn', '123456', '0933333333', '2', '2026-04-27 09:03:37'),
('U005', 'Nguyễn Thị E', 'khachhang04@gmail.com.vn', '123456', '0944444444', '2', '2026-04-27 09:03:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MaNCC` varchar(20) NOT NULL,
  `TenNCC` varchar(100) NOT NULL,
  `SoDienThoai` varchar(20) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`MaNCC`, `TenNCC`, `SoDienThoai`, `DiaChi`) VALUES
('S001', 'Cocoon Vietnam Official', '901234567', 'Quận Tân Bình, TP.HCM'),
('S002', 'Equo Vietnam', '912345678', 'Quận 1, TP.HCM'),
('S003', 'ShoeX Vietnam', '923456789', 'TP. Thủ Đức, TP.HCM'),
('S004', 'Coolmate Vietnam', '934567890', 'Quận Phú Nhuận, TP.HCM'),
('S005', 'Eco Lifestyle Partners', '945678901', 'Dĩ An, Bình Dương');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhomquyen`
--

CREATE TABLE `nhomquyen` (
  `MaQuyen` varchar(20) NOT NULL,
  `TenQuyen` varchar(50) NOT NULL COMMENT '1: Admin, 2: Khách hàng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhomquyen`
--

INSERT INTO `nhomquyen` (`MaQuyen`, `TenQuyen`) VALUES
('1', 'Admin'),
('2', 'Khách hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('24520944@gm.uit.edu.vn', '17ebe69ee7288a6f5ffb17bb6ee54f63e46482a3b350320783447143146d974e', '2026-04-22 16:22:07'),
('thnl3012@gmail.com', 'eecfb550df2566632688ee61a03783623438f656f9192aa98574f6422b4dc072', '2026-04-22 16:32:49'),
('dinhliemdk@gmail.com', '8deca89d5dd09e2efb8ace7ced2672ec83ae3dc84fa23ac8fe50cb5489d2689f', '2026-04-25 02:19:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
--

CREATE TABLE `phieunhap` (
  `MaPhieuNhap` varchar(20) NOT NULL,
  `MaNCC` varchar(20) DEFAULT NULL,
  `NgayNhap` datetime DEFAULT current_timestamp(),
  `TongTienNhap` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phieunhap`
--

INSERT INTO `phieunhap` (`MaPhieuNhap`, `MaNCC`, `NgayNhap`, `TongTienNhap`) VALUES
('R001', 'S001', '2026-04-22 00:00:00', 4740000.00),
('R002', 'S002', '2026-04-22 00:00:00', 2950000.00),
('R003', 'S003', '2026-04-23 00:00:00', 10000000.00),
('R004', 'S004', '2026-04-24 00:00:00', 3500000.00),
('R005', 'S005', '2026-04-24 00:00:00', 5875000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ptthanhtoan`
--

CREATE TABLE `ptthanhtoan` (
  `MaPTTT` varchar(20) NOT NULL,
  `TenPTTT` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ptthanhtoan`
--

INSERT INTO `ptthanhtoan` (`MaPTTT`, `TenPTTT`) VALUES
('1', 'COD'),
('2', 'Chuyển khoản'),
('3', 'Thẻ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ptvanchuyen`
--

CREATE TABLE `ptvanchuyen` (
  `MaPTVC` varchar(20) NOT NULL,
  `TenPTVC` varchar(100) NOT NULL,
  `GiaCuoc` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ptvanchuyen`
--

INSERT INTO `ptvanchuyen` (`MaPTVC`, `TenPTVC`, `GiaCuoc`) VALUES
('1', 'Giao hàng tiêu chuẩn', 15000.00),
('2', 'Giao hàng nhanh', 30000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSanPham` varchar(20) NOT NULL,
  `TenSanPham` varchar(100) NOT NULL,
  `MaDanhMuc` varchar(20) DEFAULT NULL,
  `MaThuongHieu` varchar(20) DEFAULT NULL,
  `MaVatLieu` varchar(20) DEFAULT NULL,
  `MoTa` text DEFAULT NULL,
  `DiemXanh` int(11) DEFAULT 10,
  `TrangThai` tinyint(1) DEFAULT 1,
  `NguonGoc` varchar(255) DEFAULT NULL,
  `TacDongMoiTruong` text DEFAULT NULL,
  `CoTaiChe` tinyint(1) DEFAULT 0,
  `ThanThienMoiTruong` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSanPham`, `TenSanPham`, `MaDanhMuc`, `MaThuongHieu`, `MaVatLieu`, `MoTa`, `DiemXanh`, `TrangThai`, `NguonGoc`, `TacDongMoiTruong`, `CoTaiChe`, `ThanThienMoiTruong`) VALUES
('P001', 'Cà phê Đắk Lắk\r\nlàm sạch da chết cơ thể 200ml', 'C004', 'B001', 'M001', 'Hạt cà phê nguyên chất từ Đắk Lắk kết hợp với bơ ca cao Tiền Giang giúp làm sạch da chết cơ thể hiệu quả, làm đều màu da, khơi dậy năng lượng giúp da trở nên mềm mịn và rạng rỡ.', 98, 1, 'Cocoon', '100% thuần chay, không sử dụng hạt vi nhựa, không dầu khoáng, không cồn, không sulfate và không paraben', 1, 1),
('P002', 'Nước tẩy trang bí đao 1000ml', 'C004', 'B001', 'M002', 'Làn da dầu và mụn rất nhạy cảm nên cần được thiết kế một loại nước tẩy trang phù hợp. Với công nghệ micellar và NatraGemTM S150, Nước Tẩy Trang Bí Đao giúp làm sạch hiệu quả lớp trang điểm, bụi bẩn và dầu thừa, mang lại làn da sạch hoàn toàn và mềm mịn.', 95, 1, 'Cocoon', 'Cam kết không sử dụng dầu khoáng, không cồn, không sulfate và không paraben', 1, 1),
('P003', 'Ống hút cỏ bàng', 'C001', 'B002', 'M003', 'Ống hút làm từ 100% cỏ bàng tự nhiên nguyên ống, không hóa chất, dùng được cho đồ uống nóng/lạnh.', 100, 1, 'Equo', 'Tự phân hủy sinh học hoàn toàn trong môi trường tự nhiên trong vòng 6 tháng', 1, 1),
('P004', 'Bộ dao, muỗng, nĩa cà phề', 'C001', 'B002', 'M004', 'Bộ dao, muỗng, nĩa cà phê được làm từ 100% bã cà phê tự nhiên. Sản phẩm không chứa nhựa, chất phụ gia và các chất độc hại. ', 100, 1, 'Equo', 'Có thể phân hủy hoàn toàn trong môi trường tự nhiên hoặc dùng để ủ phân sinh học', 1, 1),
('P005', 'Giày thể thao cà phê ShoeX', 'C003', 'B003', 'M005', 'Giày siêu nhẹ, chống thấm nước, kháng khuẩn và khử mùi tự nhiên từ bã cà phê.', 92, 1, 'ShoeX', 'Mỗi đôi giày tái chế từ 3 cốc bã cà phê và 12 chai nhựa PET cũ.', 1, 1),
('P006', 'Áo Polo Nam Cafe', 'C003', 'B004', 'M005', 'Áo thun mặc mát, chống tia UV, nhanh khô, khử mùi hôi cơ thể cực tốt nhờ sợi công nghệ cao', 85, 1, 'Coolmate', 'Là một sản phẩm tiên phong được tạo nên từ sự kết hợp độc đáo giữa sợi S.Café® (từ bã cà phê) và sợi PET tái chế (từ chai nhựa)', 1, 1),
('P007', 'Túi đựng Laptop dệt từ nilon tái chế', 'C003', 'B005', 'M006', 'Túi laptop bền bỉ, họa tiết độc bản được dệt thủ công bằng tay từ túi nilon cũ, tránh va đập tốt', 90, 1, 'Limloop', 'Giải cứu túi nilon khỏi bãi rác, tạo vòng đời mới và tạo việc làm cho người khuyết tật', 1, 1),
('P008', 'Bộ màng vải che thực phẩm', 'C001', 'B006', 'M007', 'Vải cotton tẩm sáp ong, nhựa thông và dầu jojoba, dùng sức nóng của tay để làm mềm và bọc kín tô/chén.', 95, 1, 'Lại Đây Refill', 'Có thể rửa bằng nước lạnh và tái sử dụng lên đến 1 năm, thay thế màng bọc màng co nilon', 1, 1),
('P009', 'Nến thơm ', 'C002', 'B007', 'M008', 'Nến thư giãn làm từ sáp ong tự nhiên và tinh dầu mộc qua, cháy êm, không tỏa khói đen độc hại.', 92, 1, 'Himalaya', 'Không dùng sáp paraffin từ dầu mỏ như nến công nghiệp. Hũ thủy tinh dùng xong có thể tái sử dụng để trồng cây sen đá', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham_chungnhan`
--

CREATE TABLE `sanpham_chungnhan` (
  `MaSanPham` varchar(20) NOT NULL,
  `MaChungNhan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuonghieu`
--

CREATE TABLE `thuonghieu` (
  `MaThuongHieu` varchar(20) NOT NULL,
  `TenThuongHieu` varchar(100) NOT NULL,
  `XuatXu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thuonghieu`
--

INSERT INTO `thuonghieu` (`MaThuongHieu`, `TenThuongHieu`, `XuatXu`) VALUES
('B001', 'Cocoon', 'Việt Nam'),
('B002', 'Equo', 'Việt Nam'),
('B003', 'ShoeX', 'Việt Nam'),
('B004', 'Coolmate', 'Việt Nam'),
('B005', 'Limloop', 'Việt Nam'),
('B006', 'Lại Đây Refill', 'Việt Nam'),
('B007', 'Himalaya', 'Việt Nam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vatlieu`
--

CREATE TABLE `vatlieu` (
  `MaVatLieu` varchar(20) NOT NULL,
  `TenVatLieu` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vatlieu`
--

INSERT INTO `vatlieu` (`MaVatLieu`, `TenVatLieu`, `MoTa`) VALUES
('M001', 'Hạt cà phê & Bơ ca cao', 'Nguyên liệu tự nhiên giàu dưỡng chất, giúp tẩy tế bào chết vật lý mà không gây hại cho nguồn nước (thay thế hạt vi nhựa)'),
('M002', 'Chiết xuất bí đao, rau má, tinh dầu tràm trà và NatraGem™ S150', 'Các loại thảo mộc như bí đao, rau má, tràm trà... được chiết xuất tinh khiết, không chứa thành phần từ động vật.'),
('M003', 'Cỏ bàng tự nhiên', 'Loại cỏ thân rỗng, bền dai tự nhiên, có khả năng phân hủy sinh học 100% trong môi trường tự nhiên.'),
('M004', 'Bã cà phê nguyên chất', 'Phế phẩm từ ngành thực phẩm được xử lý công nghệ cao để ép khuôn thành các vật dụng cứng cáp hoặc làm vật liệu sinh học'),
('M005', 'Sợi S.Café® & PET tái chế', 'Sự kết hợp đột phá giữa bã cà phê và chai nhựa cũ, tạo ra loại vải thân thiện với môi trường'),
('M006', 'Nilon tái chế', 'Túi nilon phế liệu được thu gom, làm sạch và dệt thủ công thành tấm vải bền chắc, giúp kéo dài vòng đời của nhựa'),
('M007', 'Sáp ong & Cotton hữu cơ', 'Vải cotton thấm sáp ong và nhựa thông, tạo ra lớp màng bảo quản thực phẩm có tính kháng khuẩn tự nhiên, tái sử dụng được nhiều lần'),
('M008', 'Sáp ong & Tinh dầu tự nhiên', 'Sáp lành tính thay thế hoàn toàn cho sáp paraffin (gốc dầu mỏ), kết hợp tinh dầu thực vật không gây độc hại khi đốt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `yeuthich`
--

CREATE TABLE `yeuthich` (
  `MaNguoiDung` varchar(20) NOT NULL,
  `MaSanPham` varchar(20) NOT NULL,
  `NgayThem` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  ADD PRIMARY KEY (`MaBaiViet`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`);

--
-- Chỉ mục cho bảng `bienthesanpham`
--
ALTER TABLE `bienthesanpham`
  ADD PRIMARY KEY (`MaBienThe`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaDonHang`,`MaBienThe`),
  ADD KEY `MaBienThe` (`MaBienThe`);

--
-- Chỉ mục cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD PRIMARY KEY (`MaGioHang`,`MaBienThe`),
  ADD KEY `MaBienThe` (`MaBienThe`);

--
-- Chỉ mục cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD PRIMARY KEY (`MaPhieuNhap`,`MaBienThe`),
  ADD KEY `MaBienThe` (`MaBienThe`);

--
-- Chỉ mục cho bảng `chungnhan`
--
ALTER TABLE `chungnhan`
  ADD PRIMARY KEY (`MaChungNhan`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`MaDanhGia`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MaDanhMuc`);

--
-- Chỉ mục cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD PRIMARY KEY (`MaDiaChi`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDonHang`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`),
  ADD KEY `MaPTTT` (`MaPTTT`),
  ADD KEY `MaPTVC` (`MaPTVC`),
  ADD KEY `MaCode` (`MaCode`),
  ADD KEY `MaDiaChi` (`MaDiaChi`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGioHang`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`);

--
-- Chỉ mục cho bảng `hinhanhsanpham`
--
ALTER TABLE `hinhanhsanpham`
  ADD PRIMARY KEY (`MaHinhAnh`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Chỉ mục cho bảng `magiamgia`
--
ALTER TABLE `magiamgia`
  ADD PRIMARY KEY (`MaCode`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaNguoiDung`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `MaQuyen` (`MaQuyen`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Chỉ mục cho bảng `nhomquyen`
--
ALTER TABLE `nhomquyen`
  ADD PRIMARY KEY (`MaQuyen`);

--
-- Chỉ mục cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`MaPhieuNhap`),
  ADD KEY `MaNCC` (`MaNCC`);

--
-- Chỉ mục cho bảng `ptthanhtoan`
--
ALTER TABLE `ptthanhtoan`
  ADD PRIMARY KEY (`MaPTTT`);

--
-- Chỉ mục cho bảng `ptvanchuyen`
--
ALTER TABLE `ptvanchuyen`
  ADD PRIMARY KEY (`MaPTVC`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSanPham`),
  ADD KEY `MaDanhMuc` (`MaDanhMuc`),
  ADD KEY `MaThuongHieu` (`MaThuongHieu`),
  ADD KEY `MaVatLieu` (`MaVatLieu`);

--
-- Chỉ mục cho bảng `sanpham_chungnhan`
--
ALTER TABLE `sanpham_chungnhan`
  ADD PRIMARY KEY (`MaSanPham`,`MaChungNhan`),
  ADD KEY `MaChungNhan` (`MaChungNhan`);

--
-- Chỉ mục cho bảng `thuonghieu`
--
ALTER TABLE `thuonghieu`
  ADD PRIMARY KEY (`MaThuongHieu`);

--
-- Chỉ mục cho bảng `vatlieu`
--
ALTER TABLE `vatlieu`
  ADD PRIMARY KEY (`MaVatLieu`);

--
-- Chỉ mục cho bảng `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD PRIMARY KEY (`MaNguoiDung`,`MaSanPham`),
  ADD KEY `MaSanPham` (`MaSanPham`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baiviet`
--
ALTER TABLE `baiviet`
  ADD CONSTRAINT `baiviet_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`);

--
-- Các ràng buộc cho bảng `bienthesanpham`
--
ALTER TABLE `bienthesanpham`
  ADD CONSTRAINT `bienthesanpham_ibfk_1` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`);

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDonHang`) REFERENCES `donhang` (`MaDonHang`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaBienThe`) REFERENCES `bienthesanpham` (`MaBienThe`);

--
-- Các ràng buộc cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD CONSTRAINT `chitietgiohang_ibfk_1` FOREIGN KEY (`MaGioHang`) REFERENCES `giohang` (`MaGioHang`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitietgiohang_ibfk_2` FOREIGN KEY (`MaBienThe`) REFERENCES `bienthesanpham` (`MaBienThe`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD CONSTRAINT `chitietphieunhap_ibfk_1` FOREIGN KEY (`MaPhieuNhap`) REFERENCES `phieunhap` (`MaPhieuNhap`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitietphieunhap_ibfk_2` FOREIGN KEY (`MaBienThe`) REFERENCES `bienthesanpham` (`MaBienThe`);

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`),
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`);

--
-- Các ràng buộc cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`),
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`MaPTTT`) REFERENCES `ptthanhtoan` (`MaPTTT`),
  ADD CONSTRAINT `donhang_ibfk_3` FOREIGN KEY (`MaPTVC`) REFERENCES `ptvanchuyen` (`MaPTVC`),
  ADD CONSTRAINT `donhang_ibfk_4` FOREIGN KEY (`MaCode`) REFERENCES `magiamgia` (`MaCode`),
  ADD CONSTRAINT `donhang_ibfk_5` FOREIGN KEY (`MaDiaChi`) REFERENCES `diachi` (`MaDiaChi`);

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hinhanhsanpham`
--
ALTER TABLE `hinhanhsanpham`
  ADD CONSTRAINT `hinhanhsanpham_ibfk_1` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `nguoidung_ibfk_1` FOREIGN KEY (`MaQuyen`) REFERENCES `nhomquyen` (`MaQuyen`);

--
-- Các ràng buộc cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `phieunhap_ibfk_1` FOREIGN KEY (`MaNCC`) REFERENCES `nhacungcap` (`MaNCC`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`MaDanhMuc`) REFERENCES `danhmuc` (`MaDanhMuc`),
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`MaThuongHieu`) REFERENCES `thuonghieu` (`MaThuongHieu`),
  ADD CONSTRAINT `sanpham_ibfk_3` FOREIGN KEY (`MaVatLieu`) REFERENCES `vatlieu` (`MaVatLieu`);

--
-- Các ràng buộc cho bảng `sanpham_chungnhan`
--
ALTER TABLE `sanpham_chungnhan`
  ADD CONSTRAINT `sanpham_chungnhan_ibfk_1` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`) ON DELETE CASCADE,
  ADD CONSTRAINT `sanpham_chungnhan_ibfk_2` FOREIGN KEY (`MaChungNhan`) REFERENCES `chungnhan` (`MaChungNhan`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `yeuthich`
--
ALTER TABLE `yeuthich`
  ADD CONSTRAINT `yeuthich_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`) ON DELETE CASCADE,
  ADD CONSTRAINT `yeuthich_ibfk_2` FOREIGN KEY (`MaSanPham`) REFERENCES `sanpham` (`MaSanPham`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
