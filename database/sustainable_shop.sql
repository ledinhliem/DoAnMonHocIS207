-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 25, 2026 lúc 04:16 PM
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
('BL004', 'Limloop và giấc mơ tái sinh rác thải nhựa thành nghệ thuật thủ công', 'Mỗi chiếc túi là một câu chuyện. Phải mất 500 năm để một chiếc túi nilon phân hủy, nhưng tại Limloop, chúng chỉ mất vài ngày để trở thành một phụ kiện thời trang. Quy trình \"Upcycling\" (Tái chế nâng cấp) bắt đầu bằng việc thu gom túi nilon cũ, khử trùng và cắt thành sợi.\r\n\r\nCác nghệ nhân là người khuyết tật sẽ tỉ mỉ dệt những sợi nilon này trên khung cửi truyền thống để tạo ra những tấm vải có vân màu độc bản. Mỗi chiếc túi Laptop hay túi Tote bạn mua tại Zentro không chỉ giúp \"giải cứu\" môi trường khỏi rác thải nhựa mà còn tạo ra sinh kế bền vững và sự tự tin cho những mảnh đời kém may mắn.', 'BL004_Limloop.webp', '2026-04-24 16:45:00', 'U004'),
('BL005', 'Nghệ thuật mang thiên nhiên vào nhà với nội thất mây tre đan', 'Xu hướng \"mang thiên nhiên vào không gian sống\" đang ngày càng được ưa chuộng. Không cần những vật liệu đắt tiền hay kim loại lạnh lẽo, nội thất mây tre đan mang lại sự ấm cúng, mộc mạc và bình yên. Điểm nhấn không gian: Các sản phẩm như thảm cói, đèn hoa sen hay tủ mây từ Mây Tre Đan Trà không chỉ có độ bền cao mà còn mang đậm dấu ấn thủ công truyền thống. Sợi mây, cói tự nhiên giúp điều hòa không khí, tạo cảm giác thư giãn tuyệt đối. Lựa chọn nội thất mây tre cũng là cách bạn ủng hộ các làng nghề Việt và giảm thiểu rác thải công nghiệp chế tác.', 'BL005.jpg', '2026-05-05 09:00:00', 'U002'),
('BL006', 'Căn bếp \"Xanh\": Bắt đầu từ những thay đổi nhỏ nhất', 'Nhà bếp thường là nơi thải ra lượng rác thải nhựa dùng một lần lớn nhất trong gia đình. Tuy nhiên, việc chuyển đổi sang một căn bếp \"Eco-friendly\" lại dễ dàng hơn bạn nghĩ. Thay thế đồ dùng thông thường: Hãy bắt đầu bằng việc từ chối màng bọc thực phẩm nilon và chuyển sang dùng màng vải sáp ong tự nhiên. Với rác thải sinh hoạt, các loại túi rác và găng tay sinh học phân hủy hoàn toàn từ AnEco là giải pháp hoàn hảo. Chỉ mất 6-12 tháng để chúng phân hủy thành mùn hữu cơ. Một căn bếp xanh không chỉ bảo vệ sức khỏe gia đình mà còn góp phần chữa lành Trái Đất.', 'BL006.jpeg', '2026-05-08 10:30:00', 'U004'),
('BL007', 'Microplastics và sức khỏe: Vì sao nên giảm nhựa trong chăm sóc cá nhân', '1. Microplastics là gì và vì sao đáng lo? Microplastics là những mảnh nhựa siêu nhỏ được tạo ra khi các sản phẩm nhựa lớn phân rã theo thời gian. Chúng không chỉ xuất hiện trong môi trường mà còn được phát hiện trong cơ thể con người như máu, mô, sữa mẹ và các dịch sinh học khác. Điều này đặt ra nhiều lo ngại về ảnh hưởng lâu dài của nhựa đối với sức khỏe. \r\n\r\n2. Tác động tiềm ẩn đến sức khỏe. Một số nghiên cứu cho thấy microplastics có thể liên quan đến stress oxy hóa, viêm, rối loạn miễn dịch và ảnh hưởng đến hệ thần kinh hoặc sức khỏe sinh sản. Ngoài bản thân hạt nhựa, các hóa chất độc hại trong nhựa cũng có thể xâm nhập vào cơ thể và làm tăng nguy cơ gây hại cho tế bào. \r\n\r\n3. Giảm tiếp xúc với nhựa từ thói quen hằng ngày. Để hạn chế microplastics, chúng ta có thể tránh hâm nóng thức ăn trong hộp nhựa, ưu tiên thực phẩm ít bao bì, dùng bình nước thủy tinh hoặc inox, thay dụng cụ bếp nhựa bằng kim loại hoặc tre. Trong chăm sóc cá nhân, nên chọn xà phòng dạng thanh, dầu gội dạng thanh hoặc sản phẩm đóng gói bằng thủy tinh, nhôm và có thể refill. Kết luận: Giảm nhựa không chỉ giúp bảo vệ môi trường mà còn là cách chăm sóc sức khỏe chủ động hơn. Từ những lựa chọn nhỏ như đổi bao bì nhựa sang chai nhôm tái sử dụng, mỗi người đều có thể góp phần xây dựng lối sống an toàn và bền vững hơn.', 'BL007.webp', '2026-04-15 09:00:00', 'U001'),
('BL008', 'Không chỉ là chai đựng: Giữ nhựa ra khỏi sản phẩm chăm sóc cá nhân', '1. Nhựa không chỉ nằm ở bao bì. Khi nói đến giảm nhựa, nhiều người thường nghĩ đến việc thay thế chai nhựa bằng chai tái sử dụng. Tuy nhiên, trong ngành chăm sóc cá nhân, nhựa còn có thể xuất hiện bên trong chính thành phần sản phẩm. Một số chất phụ gia trong nhựa có thể thôi nhiễm vào sản phẩm và đi vào cơ thể qua thực phẩm, nước uống hoặc mỹ phẩm sử dụng hằng ngày. \r\n\r\n2. Những thành phần cần chú ý. Một số thành phần như phthalates, nhựa lỏng và polyethylene có thể gây lo ngại cho sức khỏe và môi trường. Phthalates thường ẩn dưới tên gọi “fragrance”, nhựa lỏng có thể xuất hiện trong các chất kết thúc bằng “-cone” hoặc “-siloxane”, còn polyethylene thường được dùng trong hạt vi nhựa tẩy tế bào chết. Các chất này có thể góp phần gây ô nhiễm nhựa và ảnh hưởng đến hệ sinh thái khi trôi xuống nguồn nước. \r\n\r\n3. Lựa chọn sản phẩm minh bạch và ít nhựa hơn. Người tiêu dùng có thể bắt đầu bằng cách đọc bảng thành phần, ưu tiên sản phẩm có bao bì thủy tinh, nhôm hoặc có thể refill, đồng thời chọn thương hiệu công khai rõ ràng thành phần sử dụng. Những lựa chọn như dầu gội refill, nước rửa tay refill hay sữa dưỡng thể trong chai nhôm giúp giảm nhựa dùng một lần và hỗ trợ lối sống bền vững hơn. Kết luận: Giảm nhựa không chỉ là thay đổi bao bì bên ngoài, mà còn là quan tâm đến những gì có bên trong sản phẩm. Một sản phẩm chăm sóc cá nhân xanh cần an toàn hơn cho người dùng, minh bạch về thành phần và giảm tác động tiêu cực đến môi trường.', 'BL008.webp', '2026-04-18 09:00:00', 'U001');

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
('V001', 'P001', '200ml', NULL, 130000.00, 49),
('V002', 'P002', '1000ml', NULL, 530000.00, 11),
('V003', 'P003', '50 cái/hộp', NULL, 55000.00, 99),
('V004', 'P004', '30 chiếc/hộp (mỗi loại 10 chiếc)', NULL, 70000.00, 48),
('V005', 'P005', 'Size EU 38 ', 'Xám', 1900000.00, 10),
('V006', 'P005', 'Size EU 38', 'Đen', 1900000.00, 2),
('V007', 'P006', 'Size M', 'Đen', 320000.00, 15),
('V008', 'P006', 'Size M', 'Xanh Navy', 320000.00, 40),
('V009', 'P007', '36x28', NULL, 430000.00, 5),
('V010', 'P008', 'Bộ 3 (S - M - L)', NULL, 99000.00, 45),
('V011', 'P009', '230g', 'LemonGrass&Ginger', 520000.00, 5),
('V012', 'P009', '230g', 'Lemon&Lavender', 500000.00, 4),
('V013', 'P010', '96 x 60,4 cm', NULL, 200000.00, 10),
('V014', 'P010', '45 x 43 x 13.5 cm', NULL, 200000.00, 8),
('V015', 'P011', 'Size M (cho nữ)', NULL, 99000.00, 40),
('V016', 'P011', 'Size L (cho nam)', NULL, 99000.00, 60),
('V017', 'P012', '10 cái', NULL, 35000.00, 100),
('V018', 'P013', '120 x 120 cm', NULL, 700000.00, 5),
('V019', 'P013', '150 x 150 cm', NULL, 780000.00, 4),
('V020', 'P014', '25 cm', NULL, 200000.00, 10),
('V021', 'P014', '40 cm', NULL, 250000.00, 3),
('V022', 'P014', '50 cm', NULL, 350000.00, 2),
('V023', 'P015', '1m x 1m2', NULL, 8500000.00, 2),
('V024', 'P016', 'Họa tiết tam giác', NULL, 450000.00, 15),
('V025', 'P016', 'Họa tiết hình vuông', NULL, 480000.00, 13),
('V026', 'P017', 'Họa tiết hoa sen', NULL, 100000.00, 56),
('V027', 'P017', 'Họa tiết hoa Lan', NULL, 100000.00, 35),
('V028', 'P017', 'Họa tiết cây tre', NULL, 100000.00, 40),
('V029', 'P018', NULL, NULL, 85000.00, 1),
('V030', 'P019', NULL, 'Hồng Xám', 150000.00, 13),
('V031', 'P019', NULL, 'Đỏ Đen', 180000.00, 11),
('V032', 'P020', 'Size S', 'Xám Oyster', 1590000.00, 10),
('V033', 'P020', 'Size M', 'Đen', 1590000.00, 12),
('V034', 'P021', 'Size M', 'Xanh Navy', 390000.00, 20),
('V035', 'P021', 'Size L', 'Đen', 390000.00, 18),
('V036', 'P022', 'Size M', 'Oyster', 1490000.00, 10),
('V037', 'P022', 'Size L', 'Đen', 1490000.00, 8),
('V038', 'P023', 'Size S', 'Đen', 990000.00, 9),
('V039', 'P023', 'Size M', 'Dusty Pink', 990000.00, 11),
('V042', 'P025', '475ml', NULL, 720000.00, 15),
('V043', 'P026', '475ml', NULL, 680000.00, 14),
('V044', 'P027', '475ml', NULL, 520000.00, 20),
('V045', 'P028', '120ml', NULL, 590000.00, 13),
('V046', 'P029', 'Travel set', NULL, 890000.00, 12),
('V047', 'P024', 'Size S', 'Blush Marl', 290000.00, 10),
('V048', 'P024', 'Size M', 'Blush Marl', 290000.00, 12),
('V049', 'P024', 'Size L', 'Blush Marl', 290000.00, 8),
('V050', 'P024', 'Size S', 'Dove Marl', 290000.00, 10),
('V051', 'P024', 'Size M', 'Dove Marl', 290000.00, 12),
('V052', 'P024', 'Size L', 'Dove Marl', 290000.00, 8);

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
('O005', 'V012', 1, 500000.00),
('O006', 'V002', 1, 530000.00),
('O007', 'V001', 1, 130000.00);

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
('RV005', 'U002', 'P009', 3, 'Mùi nến hơi nồng hơn mong đợi.', '2026-04-27 09:06:38', -1, NULL),
('RV006', 'U003', 'P013', 5, 'Thảm đan rất chắc tay, kích thước vừa vặn. Mùi cói tự nhiên rất thơm, lót sàn phòng khách nhìn cực mộc mạc và chill', '2026-04-27 09:06:38', 1, NULL),
('RV007', 'U004', 'P010', 5, 'Túi rác dai, đựng được nhiều đồ mà không bị rách. Thích nhất là túi tự phân hủy được nên cảm giác xài đỡ áy náy với môi trường hơn hẳn', '2026-04-27 09:06:38', 1, NULL),
('RV008', 'U005', 'P018', 4, 'Thiết kế loa bằng tre nguyên đốt quá độc lạ, để bàn làm việc ai cũng hỏi. Âm thanh nghe mộc mạc vừa đủ dùng, điểm nhấn decor tuyệt vời', '2026-04-27 09:06:38', 1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDanhMuc` varchar(20) NOT NULL,
  `TenDanhMuc` varchar(100) NOT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `TrangThai` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`MaDanhMuc`, `TenDanhMuc`, `HinhAnh`, `TrangThai`) VALUES
('C001', 'Zentro Kitchen', 'zentro-kitchen.jpg', 1),
('C002', 'Zentro Decor', 'zentro-decor.jpg', 1),
('C003', 'Zentro Fashion', 'zentro-fashion.jpg', 1),
('C004', 'Zentro Care', 'zentro-care.jpg', 1);

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
  `ThanhTienCuoi` decimal(15,2) NOT NULL,
  `DaThongBao` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = chưa thông báo, 1 = đã thông báo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `MaNguoiDung`, `NgayDat`, `TongTien`, `TrangThai`, `DiaChiGiaoHang`, `MaPTTT`, `MaPTVC`, `MaCode`, `MaDiaChi`, `TenNguoiNhan`, `SDTNguoiNhan`, `SoTienGiam`, `PhiVanChuyen`, `ThanhTienCuoi`, `DaThongBao`) VALUES
('O001', 'U002', '2026-04-24 00:00:00', 240000.00, '0', 'Dĩ An, Bình Dương', NULL, NULL, NULL, NULL, 'Nguyễn Thị B', '911111111', 0.00, 20000.00, 260000.00, 0),
('O002', 'U003', '2026-04-24 00:00:00', 629000.00, '1', 'TP. Thủ Đức, TP.HCM', NULL, NULL, NULL, NULL, 'Nguyễn Thị C', '922222222', 0.00, 25000.00, 654000.00, 0),
('O003', 'U004', '2026-04-25 00:00:00', 320000.00, '2', 'Quận 7, TP.HCM', NULL, NULL, NULL, NULL, 'Nguyễn Thị D', '933333333', 0.00, 20000.00, 340000.00, 0),
('O004', 'U005', '2026-04-25 00:00:00', 1900000.00, '3', 'Quận 1, TP.HCM', NULL, NULL, NULL, NULL, 'Nguyễn Thị E', '944444444', 0.00, 0.00, 1900000.00, 0),
('O005', 'U002', '2026-04-26 00:00:00', 1020000.00, '4', 'Dĩ An, Bình Dương', NULL, NULL, NULL, NULL, 'Nguyễn Thị B', '911111111', 0.00, 0.00, 1020000.00, 0),
('O006', 'U013', '2026-05-25 17:16:38', 530000.00, '3', 'dddd', '1', '1', NULL, NULL, 'aaaaaa', '0903642483', 0.00, 15000.00, 545000.00, 1),
('O007', 'U013', '2026-05-25 19:15:37', 130000.00, '3', 'dddd', '1', '1', NULL, NULL, 'ssss', '029307465', 0.00, 15000.00, 145000.00, 1);

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
('IMG012', 'P009', 'P009_V012_Nenthom_Lemon&Lavender.jpg'),
('IMG013', 'P010', 'P010_V013_TuiRac1.png'),
('IMG014', 'P010', 'P010_V013_TuiRac2.png'),
('IMG015', 'P010', 'P010_V014_TuiRac1.png'),
('IMG016', 'P010', 'P010_V014_TuiRac2.png'),
('IMG017', 'P011', 'P011_V015_GangTay1.png'),
('IMG018', 'P011', 'P011_V015_GangTay2.png'),
('IMG019', 'P011', 'P011_V016_GangTay1.png'),
('IMG020', 'P012', 'P012_V017_CocLanh.png'),
('IMG021', 'P013', 'P013_V018_ThamTronNho1.png'),
('IMG022', 'P013', 'P013_V018_ThamTronNho2.png'),
('IMG023', 'P013', 'P013_V019_ThamTronTo1.png'),
('IMG024', 'P013', 'P013_V019_ThamTronTo2.png'),
('IMG025', 'P014', 'P014_Anh1.png'),
('IMG026', 'P014', 'P014_Anh2.png'),
('IMG027', 'P014', 'P014_Anh3.png'),
('IMG028', 'P015', 'P015_V023_Anh1.png'),
('IMG029', 'P015', 'P015_V023_Anh2.png'),
('IMG030', 'P016', 'P016_V024_TamGiac1.jpg'),
('IMG031', 'P016', 'P016_V024_TamGiac2.jpg'),
('IMG032', 'P016', 'P016_V024_TamGiac3.jpg'),
('IMG033', 'P016', 'P016_V025_HinhVuong1.jpg'),
('IMG034', 'P016', 'P016_V025_HinhVuong2.jpg'),
('IMG035', 'P017', 'P017_V026_HoaSen1.jpg'),
('IMG036', 'P017', 'P017_V026_HoaSen2.jpg'),
('IMG037', 'P017', 'P017_V027_Lan1.jpg'),
('IMG038', 'P017', 'P017_V027_Lan2.jpg'),
('IMG039', 'P017', 'P017_V028_Tre1.jpg'),
('IMG040', 'P017', 'P017_V028_Tre2.jpg'),
('IMG041', 'P018', 'P018_V029_Loa1.jpg'),
('IMG042', 'P018', 'P018_V029_Loa2.jpg'),
('IMG043', 'P019', 'P019_V030_HongXam1.jpg'),
('IMG044', 'P019', 'P019_V030_HongXam2.jpg'),
('IMG045', 'P019', 'P019_V030_HongXam3.jpg'),
('IMG046', 'P019', 'P019_V031_DenDo1.jpg'),
('IMG047', 'P019', 'P019_V031_DenDo2.jpg'),
('IMG048', 'P019', 'P019_V031_DenDo3.jpg'),
('IMG049', 'P020', 'P020_V032_BoodyQuarterZip_Oyster_Texture.webp'),
('IMG050', 'P020', 'P020_V032_BoodyQuarterZip_Oyster_Model.webp'),
('IMG051', 'P020', 'P020_V032_BoodyQuarterZip_Oyster_Back.webp'),
('IMG052', 'P020', 'P020_V032_BoodyQuarterZip_Oyster_Front.jpg'),
('IMG053', 'P020', 'P020_V033_BoodyQuarterZip_Black_Front.webp'),
('IMG054', 'P020', 'P020_V033_BoodyQuarterZip_Black_Texture.webp'),
('IMG055', 'P021', 'P021_V034_BoodySeamfreeBoxer_Navy_Front.webp'),
('IMG056', 'P021', 'P021_V034_BoodySeamfreeBoxer_Navy_Texture.jpg'),
('IMG057', 'P021', 'P021_V034_BoodySeamfreeBoxer_Navy_Model.webp'),
('IMG058', 'P021', 'P021_V034_BoodySeamfreeBoxer_Navy_Detail.webp'),
('IMG059', 'P021', 'P021_V035_BoodySeamfreeBoxer_Black_Front.webp'),
('IMG060', 'P021', 'P021_V035_BoodySeamfreeBoxer_Black_Texture.jpg'),
('IMG061', 'P021', 'P021_V035_BoodySeamfreeBoxer_Black_Model.webp'),
('IMG062', 'P021', 'P021_V035_BoodySeamfreeBoxer_Black_Detail.webp'),
('IMG063', 'P022', 'P022_V036_BoodyCrewNeckSweater_Oyster_Front.webp'),
('IMG064', 'P022', 'P022_V036_BoodyCrewNeckSweater_Oyster_Texture.jpg'),
('IMG065', 'P022', 'P022_V036_BoodyCrewNeckSweater_Oyster_Model.webp'),
('IMG066', 'P022', 'P022_V036_BoodyCrewNeckSweater_Oyster_Detail.jpg'),
('IMG067', 'P022', 'P022_V037_BoodyCrewNeckSweater_Black_Front.webp'),
('IMG068', 'P022', 'P022_V037_BoodyCrewNeckSweater_Black_Texture.jpg'),
('IMG069', 'P022', 'P022_V037_BoodyCrewNeckSweater_Black_Model.webp'),
('IMG070', 'P022', 'P022_V037_BoodyCrewNeckSweater_Black_Detail.jpg'),
('IMG071', 'P023', 'P023_V038_BoodyGoodnightSlip_Black_Front.webp'),
('IMG072', 'P023', 'P023_V038_BoodyGoodnightSlip_Black_Texture.jpg'),
('IMG073', 'P023', 'P023_V038_BoodyGoodnightSlip_Black_Model.webp'),
('IMG074', 'P023', 'P023_V039_BoodyGoodnightSlip_DustyPink_Front.webp'),
('IMG075', 'P023', 'P023_V039_BoodyGoodnightSlip_DustyPink_Back.webp'),
('IMG076', 'P023', 'P023_V039_BoodyGoodnightSlip_DustyPink_Texture.jpg'),
('IMG077', 'P023', 'P023_V039_BoodyGoodnightSlip_DustyPink_Model.webp'),
('IMG078', 'P024', 'P024_V040_BoodyChunkyBedSocks_BlushMarl_Front.webp'),
('IMG079', 'P024', 'P024_V040_BoodyChunkyBedSocks_BlushMarl_SizeGuide.webp'),
('IMG080', 'P024', 'P024_V041_BoodyChunkyBedSocks_DoveMarl_Front.webp'),
('IMG081', 'P025', 'P025_V042_PlaineShampoo_1.webp'),
('IMG082', 'P025', 'P025_V042_PlaineShampoo_2.webp'),
('IMG083', 'P025', 'P025_V042_PlaineShampoo_3.webp'),
('IMG084', 'P025', 'P025_V042_PlaineShampoo_4.webp'),
('IMG085', 'P026', 'P026_V043_PlaineBodyLotion_1.webp'),
('IMG086', 'P026', 'P026_V043_PlaineBodyLotion_2.webp'),
('IMG087', 'P026', 'P026_V043_PlaineBodyLotion_3.webp'),
('IMG088', 'P026', 'P026_V043_PlaineBodyLotion_4.webp'),
('IMG089', 'P027', 'P027_V044_PlaineHandWash_1.webp'),
('IMG090', 'P027', 'P027_V044_PlaineHandWash_2.webp'),
('IMG091', 'P027', 'P027_V044_PlaineHandWash_3.webp'),
('IMG092', 'P027', 'P027_V044_PlaineHandWash_4.webp'),
('IMG093', 'P028', 'P028_V045_PlaineFaceToner_1.webp'),
('IMG094', 'P028', 'P028_V045_PlaineFaceToner_2.webp'),
('IMG095', 'P028', 'P028_V045_PlaineFaceToner_3.webp'),
('IMG096', 'P028', 'P028_V045_PlaineFaceToner_4.webp'),
('IMG097', 'P029', 'P029_V046_PlaineTravelSet_1.webp'),
('IMG098', 'P029', 'P029_V046_PlaineTravelSet_2.webp'),
('IMG099', 'P029', 'P029_V046_PlaineTravelSet_3.webp'),
('IMG100', 'P029', 'P029_V046_PlaineTravelSet_4.webp');

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
('ECOKITCHEN', 15, 100, '2026-08-31'),
('HEGREEN', 20, 50, '2026-07-31'),
('SAVEPLANET', 20, 50, '2026-06-30'),
('ZENTROGREEN', 10, 500, '2026-12-31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `created_at`) VALUES
(1, 'testnewsletter01@gmail.com', '2026-05-20 14:11:40'),
(2, 'dinhliemdk@gmail.com', '2026-05-20 14:33:26'),
(3, 'nguyenthanhlong281006@gmail.com', '2026-05-20 14:44:16'),
(4, 'nguyenlong281006@gmail.com', '2026-05-20 14:44:36'),
(5, 'cauvang1302@gmail.com', '2026-05-20 14:47:59'),
(6, 'quangdk27806@gmail.com', '2026-05-20 15:15:15');

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
('U005', 'Nguyễn Thị E', 'khachhang04@gmail.com.vn', '123456', '0944444444', '2', '2026-04-27 09:03:37'),
('U006', 'Admin Test 01', 'admin01@zentro.test', '123456', '0901000001', '1', '2026-05-20 13:45:00'),
('U007', 'Admin Test 02', 'admin02@zentro.test', '123456', '0901000002', '1', '2026-05-20 13:45:00'),
('U008', 'Admin Test 03', 'admin03@zentro.test', '123456', '0901000003', '1', '2026-05-20 13:45:00'),
('U009', 'User Test 01', 'user01@zentro.test', '123456', '0911000001', '2', '2026-05-20 13:45:00'),
('U010', 'User Test 02', 'user02@zentro.test', '123456', '0911000002', '2', '2026-05-20 13:45:00'),
('U011', 'User Test 03', 'user03@zentro.test', '123456', '0911000003', '2', '2026-05-20 13:45:00'),
('U012', 'salem', '24520954@gm.uit.edu.vn', '$2y$10$yf5JXmfyBRLDIRnvCDpgUurSd8EEn5SNxlXzSl0fYSvvw6TRxxhDO', NULL, '2', '2026-05-21 10:10:51'),
('U013', 'demo', 'demo@gmail.com', '$2y$10$T34qZEQCtmaz6dbIRGhaZ.478SwFHEUwiSM4ERaCKeZsR23mUJ8Ai', NULL, '2', '2026-05-23 00:33:01');

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
('P009', 'Nến thơm ', 'C002', 'B007', 'M008', 'Nến thư giãn làm từ sáp ong tự nhiên và tinh dầu mộc qua, cháy êm, không tỏa khói đen độc hại.', 92, 1, 'Himalaya', 'Không dùng sáp paraffin từ dầu mỏ như nến công nghiệp. Hũ thủy tinh dùng xong có thể tái sử dụng để trồng cây sen đá', 1, 1),
('P010', 'Túi rác phân hủy sinh học', 'C001', 'B009', 'M009', 'Được làm hoàn toàn từ nguyên liệu sinh học, túi rác AnEco có khả năng phân hủy hoàn toàn thành mùn, nước và CO2 trong vòng 6 tháng – 1 năm.', 100, 1, 'AnEco', 'Trung hòa carbon', 0, 1),
('P011', 'Găng tay nấu ăn sinh học', 'C001', 'B009', 'M009', 'Được làm từ nguyên liệu sinh học PBAT và PLA, găng tay AnEco có khả năng phân huỷ hoàn toàn thành mùn, nước và CO2 trong vòng 6 - 12 tháng.', 99, 1, 'AnEco', 'Trung hòa carbon', 0, 1),
('P012', 'Cốc lạnh AnEco', 'C001', 'B009', 'M009', 'Được làm từ nguyên liệu phân hủy hoàn toàn PLA, cốc lạnh AnEco có khả năng phân huỷ hoàn toàn thành mùn, nước và CO2 trong vòng 6 - 12 tháng.', 99, 1, 'AnEco', 'Trung hòa carbon', 0, 1),
('P013', 'Thảm cói tròn', 'C002', 'B010', 'M010', 'Được làm từ sợi cói tự nhiên.', 100, 1, 'Mây Tre Đan Trà', 'Vật liệu tự nhiên', 0, 1),
('P014', 'Đèn mây tre hoa sen', 'C002', 'B010', 'M010', 'Được làm từ chất liệu tre thật.', 95, 1, 'Mây Tre Đan Trà', 'Vật liệu tự nhiên', 0, 1),
('P015', 'Tủ mây chữ nhật cao cấp', 'C002', 'B010', 'M010', 'Được làm từ chất liệu tre thật.', 85, 1, 'Mây Tre Đan Trà', 'Vật liệu tự nhiên', 0, 1),
('P016', 'Chăn bông', 'C002', 'B008', 'M011', 'Chiếc chăn được làm từ 100% vải cotton vuông cùng tông màu, được ghép lại với nhau. Được làm thủ công bởi các nghệ nhân nữ.', 85, 1, 'Mekongquilts', 'Vật liệu tự nhiên', 0, 1),
('P017', 'Quạt cầm tay', 'C002', 'B008', 'M012', 'Quạt cầm tay truyền thống làm từ lá cọ, thêu hoa sen bằng chỉ cotton.', 90, 1, 'Mekongquilts', 'Vật liệu tự nhiên', 0, 1),
('P018', 'Loa bằng tre', 'C002', 'B008', 'M010', 'Loa được làm từ tre cao cấp nhất, mang đến chất lượng âm thanh vượt trội cùng vẻ ngoài thanh lịch.', 84, 1, 'Mekongquilts', 'Vật liệu tự nhiên', 0, 1),
('P019', 'Găng tay lò nướng', 'C001', 'B008', 'M011', 'Chất liệu 100% cotton, kích thước 16×26 cm và có móc treo để dễ dàng cất giữ. Được làm thủ công bởi các nghệ nhân nữ.', 90, 1, 'Mekongquilts', 'Vật liệu tự nhiên', 0, 1),
('P020', 'Áo sweater nam Bamboo Quarter Zip', 'C003', 'B011', 'M013', 'Áo sweater nam cổ khóa 1/4, form thoải mái, chất vải mềm và dày vừa phải, phù hợp mặc hằng ngày hoặc phối nhiều lớp.', 92, 1, 'Boody', 'Sợi tre hữu cơ, giảm phụ thuộc vào sợi tổng hợp thông thường.', 0, 1),
('P021', 'Quần boxer nam Seamfree Bamboo', 'C003', 'B011', 'M014', 'Quần boxer nam thiết kế seamfree, ôm vừa cơ thể, chất liệu mềm nhẹ và co giãn tốt, phù hợp mặc hằng ngày.', 90, 1, 'Boody', 'Sợi tre và cotton mềm nhẹ, thân thiện hơn với da và môi trường.', 0, 1),
('P022', 'Áo sweater nam cổ tròn Bamboo', 'C003', 'B011', 'M013', 'Áo sweater nam cổ tròn, thiết kế basic dễ phối đồ, chất liệu mềm mại, thoải mái và phù hợp với phong cách thời trang tối giản.', 92, 1, 'Boody', 'Sợi tre hữu cơ, hỗ trợ lựa chọn thời trang bền vững hơn.', 0, 1),
('P023', 'Đầm ngủ nữ Bamboo Goodnight Slip', 'C003', 'B011', 'M014', 'Đầm ngủ nữ dáng slip nhẹ nhàng, chất liệu mềm, thoáng và co giãn nhẹ, phù hợp cho mặc nhà hoặc nghỉ ngơi.', 89, 1, 'Boody', 'Chất liệu sợi tre phối cotton, mềm mại và dễ phân hủy hơn vật liệu tổng hợp.', 0, 1),
('P024', 'Vớ ngủ Bamboo Chunky Bed Socks', 'C003', 'B011', 'M013', 'Vớ ngủ dáng crew, chất liệu mềm và ấm nhẹ, phù hợp sử dụng trong nhà, khi ngủ hoặc trong thời tiết mát.', 91, 1, 'Boody', 'Sợi tre hữu cơ, giảm sử dụng vật liệu khó phân hủy.', 0, 1),
('P025', 'Dầu gội refill Plaine Products', 'C004', 'B012', 'M015', 'Dầu gội chăm sóc tóc trong chai nhôm có thể refill và tái sử dụng, giúp làm sạch tóc mà vẫn giảm bao bì nhựa dùng một lần.', 96, 1, 'Plaine Products', 'Chai nhôm refill giúp giảm chai nhựa dùng một lần.', 1, 1),
('P026', 'Sữa dưỡng thể refill Plaine Products', 'C004', 'B012', 'M015', 'Sữa dưỡng thể giúp cấp ẩm cho da, sử dụng bao bì chai nhôm có thể refill và tái sử dụng nhiều lần.', 95, 1, 'Plaine Products', 'Bao bì nhôm tái sử dụng giúp giảm rác thải nhựa.', 1, 1),
('P027', 'Nước rửa tay refill Plaine Products', 'C004', 'B012', 'M016', 'Nước rửa tay dùng hằng ngày, thiết kế trong chai nhôm refill, phù hợp với thói quen chăm sóc cá nhân bền vững.', 95, 1, 'Plaine Products', 'Mô hình refill giúp giảm bao bì nhựa sau mỗi lần mua.', 1, 1),
('P028', 'Toner da mặt refill Plaine Products', 'C004', 'B012', 'M016', 'Toner chăm sóc da mặt dạng chai nhôm nhỏ gọn, có thể refill và tái sử dụng, phù hợp cho quy trình skincare hằng ngày.', 94, 1, 'Plaine Products', 'Giảm bao bì nhựa trong quy trình skincare.', 1, 1),
('P029', 'Bộ travel set refill Plaine Products', 'C004', 'B012', 'M017', 'Bộ sản phẩm chăm sóc cá nhân mini gồm dầu gội, dầu xả, sữa tắm và sữa dưỡng thể, phù hợp khi đi du lịch hoặc mang theo hằng ngày.', 97, 1, 'Plaine Products', 'Bao bì refill mini, có thể tái sử dụng và giảm rác thải nhựa.', 1, 1);

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
('B007', 'Himalaya', 'Việt Nam'),
('B008', 'Mekongquilts', 'Việt Nam'),
('B009', 'AnEco', 'Việt Nam'),
('B010', 'Mây Tre Đan Trà', 'Việt Nam'),
('B011', 'Boody', 'Úc'),
('B012', 'Plaine Products', 'Hoa Kỳ');

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
('M008', 'Sáp ong & Tinh dầu tự nhiên', 'Sáp lành tính thay thế hoàn toàn cho sáp paraffin (gốc dầu mỏ), kết hợp tinh dầu thực vật không gây độc hại khi đốt'),
('M009', 'Nhựa sinh học (PLA & PBAT)', 'Nguyên liệu sinh học có nguồn gốc từ tự nhiên (như tinh bột ngô), có khả năng phân hủy hoàn toàn thành mùn, nước và CO2 trong thời gian ngắn.'),
('M010', 'Sợi cói, mây & tre tự nhiên', 'Các loại vật liệu từ thực vật phát triển nhanh, được thu hoạch và xử lý thủ công không qua hóa chất, thân thiện tuyệt đối với môi trường.'),
('M011', '100% Cotton tự nhiên', 'Sợi bông tinh khiết, thoáng khí, không sử dụng hóa chất nhuộm công nghiệp độc hại, an toàn cho da và có thể phân hủy sinh học.'),
('M012', 'Lá cọ tự nhiên', 'Tận dụng lá cọ phơi khô tự nhiên, được các nghệ nhân đan lát thủ công, mang đậm tính truyền thống và không tạo ra rác thải khó phân hủy.'),
('M013', 'Sợi tre hữu cơ', 'Sợi tre mềm, thoáng khí, có nguồn gốc từ tre trồng bền vững, phù hợp cho sản phẩm thời trang mặc hằng ngày.'),
('M014', 'Sợi tre & cotton', 'Chất liệu kết hợp giữa sợi tre và cotton, tạo cảm giác mềm mại, co giãn và thân thiện hơn với môi trường.'),
('M015', 'Chai nhôm tái sử dụng', 'Bao bì nhôm có thể tái sử dụng và refill nhiều lần, giúp giảm chai nhựa dùng một lần trong chăm sóc cá nhân.'),
('M016', 'Công thức refill không sulfate', 'Công thức chăm sóc cá nhân dạng refill, hạn chế hóa chất mạnh và giảm rác thải bao bì nhựa.'),
('M017', 'Bao bì refill thân thiện môi trường', 'Bao bì thiết kế cho mô hình refill, hỗ trợ tái sử dụng và giảm lượng bao bì thải ra sau mỗi lần mua.');

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
-- Chỉ mục cho bảng `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
