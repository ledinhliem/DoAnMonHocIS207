# IS207 - Zentro Sustainable E-commerce

Đồ án môn Phát triển ứng dụng web - IS207.

Đề tài: website thương mại điện tử theo chủ đề sống xanh và sản phẩm bền vững.

Tài liệu này là file README chung cho cả nhóm, đã gộp nội dung từ:

- `README.md`
- `TONG_QUAN_PROJECT.md`
- `QUY_TAC_NGON_NGU.md`

## 1. Mục tiêu project

Zentro là website thương mại điện tử có các phần chính:

- Trang chủ.
- Danh sách sản phẩm, chi tiết sản phẩm, tìm kiếm/lọc sản phẩm.
- Blog và chi tiết bài viết.
- Giỏ hàng.
- Thanh toán, thanh toán thẻ/chuyển khoản, lịch sử đơn hàng, theo dõi đơn hàng, phản hồi.
- Đăng nhập, đăng ký, quên mật khẩu, đặt lại mật khẩu.
- Hồ sơ người dùng.
- Admin dashboard, sản phẩm, đơn hàng, tồn kho, đánh giá, blog.

## 2. Tech stack

- PHP MVC.
- MySQL.
- Tailwind CSS / CSS tùy trang.
- JavaScript.
- Session PHP cho user/cart/order flow hiện tại.

## 3. Cách chạy project

1. Clone source về thư mục `htdocs`.
2. Import file SQL trong thư mục `database/` nếu đã có.
3. Cấu hình database trong `config/database.php`.
4. Cấu hình `BASE_URL` trong `config/config.php`.
5. Bật Apache và MySQL.
6. Truy cập:

```text
http://localhost:8080/is207/index.php
```

Route test nhanh:

```text
http://localhost:8080/is207/index.php
http://localhost:8080/is207/index.php?url=product
http://localhost:8080/is207/index.php?url=cart
http://localhost:8080/is207/index.php?url=checkout
http://localhost:8080/is207/index.php?url=admin/dashboard
```

## 4. Cấu trúc thư mục

```text
is207/
├── index.php
├── config/
├── core/
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
├── public/
│   ├── assets/js/
│   └── css/
├── database/
├── routes/
├── README.md
└── LICENSE
```

Ý nghĩa chính:

- `index.php`: điểm vào của ứng dụng, nạp config/core và gọi Router.
- `config/`: cấu hình chung, ví dụ `BASE_URL`, database.
- `core/`: lớp nền của MVC như `Router`, `Controller`, `Model`, `Database`.
- `app/controllers/`: xử lý request, gọi model, truyền dữ liệu sang view.
- `app/models/`: dữ liệu và nghiệp vụ dữ liệu.
- `app/views/`: giao diện HTML/PHP.
- `public/assets/js/`: JavaScript theo từng khu vực.
- `public/css/`: CSS chung.
- `database/`: file SQL/schema/data.

## 5. Luồng MVC hiện tại

Luồng cơ bản:

```text
Browser
  -> index.php
  -> core/Router.php
  -> Controller tương ứng
  -> Model nếu cần dữ liệu
  -> View để render giao diện
```

Ví dụ:

```text
?url=product
  -> Router
  -> ProductController::index()
  -> ProductModel::getAll()
  -> app/views/product/index.php
```

Quy tắc chung:

- Router chỉ định route nào gọi controller/method nào.
- Controller không nên chứa HTML dài.
- View không nên tự xử lý nghiệp vụ phức tạp.
- Model không nên xuất HTML.
- `core/App.php` có tồn tại nhưng luồng chính hiện tại đi qua `core/Router.php`.

## 6. Controller chính

| Controller | Vai trò |
|---|---|
| `HomeController` | Trang chủ |
| `ProductController` | Danh sách, chi tiết, tìm kiếm sản phẩm |
| `BlogController` | Blog, chi tiết blog, đăng ký nhận tin |
| `CartController` | Giỏ hàng: xem, thêm, cập nhật, xóa |
| `OrderController` | Thanh toán, áp mã giảm giá, lịch sử, tracking, feedback |
| `AuthController` | Đăng nhập, đăng ký, quên/reset mật khẩu, đăng nhập mạng xã hội |
| `ProfileController` | Hồ sơ người dùng |
| `AdminController` | Các trang admin |

## 7. Model chính

| Model | Vai trò |
|---|---|
| `ProductModel` | Dữ liệu sản phẩm, danh mục, tác động môi trường |
| `BlogModel` | Dữ liệu bài viết |
| `CartModel` | Dữ liệu giỏ hàng trong session |
| `OrderModel` | Validate checkout/payment/feedback, lưu đơn hàng |
| `AdminModel` | Dữ liệu admin |
| `UserModel`, `User` | Dữ liệu người dùng |

## 8. Route quan trọng

Route public:

| URL | Controller |
|---|---|
| `?url=` | `HomeController::index()` |
| `?url=product` | `ProductController::index()` |
| `?url=product/detail&id=...` | `ProductController::detail()` |
| `?url=product/search` | `ProductController::search()` |
| `?url=blog` | `BlogController::index()` |
| `?url=blog/detail&id=...` | `BlogController::detail()` |
| `?url=cart` | `CartController::index()` |
| `?url=cart/add` | `CartController::add()` |
| `?url=cart/update` | `CartController::update()` |
| `?url=cart/remove` | `CartController::remove()` |
| `?url=checkout` | `OrderController::checkout()` |
| `?url=order/payment` | `OrderController::payment()` |
| `?url=order/process-payment` | `OrderController::processPayment()` |
| `?url=order/history` | `OrderController::history()` |
| `?url=order/tracking` | `OrderController::tracking()` |
| `?url=profile` | `ProfileController::index()` |

Route admin:

| URL | Controller |
|---|---|
| `?url=admin` | `AdminController::dashboard()` |
| `?url=admin/dashboard` | `AdminController::dashboard()` |
| `?url=admin/products` | `AdminController::products()` |
| `?url=admin/orders` | `AdminController::orders()` |
| `?url=admin/inventory` | `AdminController::inventory()` |
| `?url=admin/reviews` | `AdminController::reviews()` |
| `?url=admin/blog` | `AdminController::blog()` |

Một số route thao tác admin như `product/create`, `product/edit/...`, `blog/create`, `promotion/...`, `supplier/...` hiện được Router hứng về trang admin tương ứng để tránh 404. Khi thành viên phụ trách CRUD hoàn thiện backend, có thể tách các route này thành method riêng.

## 9. Quy tắc frontend

Layout public:

- Header public: `app/views/layouts/header.php`.
- Footer public: `app/views/layouts/footer.php`.

Layout admin:

- Header admin: `app/views/layouts/admin_header.php`.
- Sidebar admin có thể nằm trong từng trang admin hoặc dùng `admin_sidebar.php`, nhưng không được include trùng.
- Footer admin: `app/views/layouts/admin_footer.php`.

Khi làm view:

- Form phải trỏ về route đã có trong `core/Router.php`.
- Nút thêm giỏ hàng phải dùng field:
  - `ma_san_pham`
  - `so_luong`
  - `ma_bien_the` nếu có biến thể
- Link chi tiết sản phẩm dùng:
  - `?url=product/detail&id=...`
- Link chi tiết blog dùng:
  - `?url=blog/detail&id=...`

## 10. Quy tắc ngôn ngữ

### Text hiển thị cho người dùng

Tất cả chữ người dùng nhìn thấy trên giao diện phải dùng tiếng Việt:

- Tiêu đề, nút, label, placeholder, thông báo lỗi/thành công.
- Menu, footer, breadcrumb, trạng thái, confirm popup.
- Trang khách hàng và trang admin đều áp dụng cùng quy tắc này.

Ví dụ:

- Dùng `Giỏ hàng`, không dùng `Shopping Cart`.
- Dùng `Thanh toán`, không dùng `Checkout`.
- Dùng `Xóa`, không dùng `Delete`.

### Tên code nội bộ

Tên class, method, route, key dữ liệu nội bộ giữ tiếng Anh/camelCase theo code hiện tại:

- `OrderController`, `CartModel`, `ProductModel`.
- `getSubtotal()`, `validateCheckout()`, `processPayment()`.
- `payment_method`, `delivery_method`, `price_asc`.

Không dịch tên hàm/class/key kỹ thuật sang tiếng Việt vì dễ làm hỏng router, model và JavaScript.

### Tên field form giỏ hàng

Luồng giỏ hàng dùng thống nhất tên POST:

- `ma_san_pham`
- `so_luong`
- `ma_bien_the` nếu thêm từ trang chi tiết có biến thể.

Không dùng lại `product_id` hoặc `quantity` trong form mới.

### Key lọc sản phẩm

Key kỹ thuật giữ nguyên, label hiển thị dịch sang tiếng Việt:

- `kitchenware` => `Đồ bếp`
- `living-room` => `Phòng khách`
- `bedroom` => `Phòng ngủ`
- `wellness` => `Chăm sóc sức khỏe`
- `carbon-neutral` => `Trung hòa carbon`
- `plastic-free` => `Không nhựa`
- `upcycled` => `Vật liệu tái chế nâng cấp`

## 11. Quy tắc backend cần nhớ

Auth:

- Bắt buộc dùng `password_hash()` khi lưu mật khẩu.
- Bắt buộc dùng `password_verify()` khi kiểm tra đăng nhập.
- Không lưu mật khẩu plain text trong database.

Cart/Order:

- Không cho thêm/cập nhật giỏ hàng vượt quá tồn kho.
- Khi thanh toán thành công phải lưu `orders`, `order_items`.
- Khi thanh toán thành công phải trừ `products.stock`.
- Nếu stock không đủ, không cho checkout.
- Nên dùng transaction cho lưu order + order items + trừ stock nếu làm được.

## 12. Quy tắc khi thêm chức năng mới

Khi thêm một màn hoặc chức năng:

1. Thêm route trong `core/Router.php`.
2. Thêm method trong controller tương ứng.
3. Nếu cần dữ liệu, thêm method trong model.
4. Tạo view trong `app/views/...`.
5. Form/link trong view phải trỏ đúng route.
6. Test bằng trình duyệt theo URL thật.

Ví dụ thêm trang admin nhà cung cấp:

```text
Router:
?url=admin/suppliers

Controller:
AdminController::suppliers()

View:
app/views/admin/suppliers.php
```

## 13. Quy tắc phối hợp nhóm

- Mỗi thành viên nên ghi rõ mình phụ trách file nào.
- Không đổi tên biến/field của phần người khác nếu chưa báo.
- Không sửa layout chung nếu chỉ đang làm một trang con.
- Không copy nguyên sidebar/header/footer vào nhiều nơi nếu đã có layout chung.
- Trước khi push/merge, kiểm tra route bấm được không bị 404.
- Nếu thêm route mới, cập nhật README hoặc báo người tổng hợp.
- Router và SQL nên để leader tổng hợp.

## 14. Checklist trước khi nộp code

- Trang chạy được từ `index.php?url=...`.
- Không có lỗi 404 khi bấm các nút chính.
- Không còn text mojibake như `Sáº£n pháº©m`, `KhÃ´ng`, `Ä`.
- Không còn text tiếng Anh ở UI nếu không phải tên thương hiệu hoặc thuật ngữ cần giữ.
- Form gửi đúng method `GET` hoặc `POST`.
- Field form khớp với controller.
- Không có ký tự thừa ngoài `<?php ... ?>`.
- Không có BOM trước `<?php`.
- Không sửa logic của phần người khác nếu chỉ đang chỉnh giao diện.
- Auth không lưu mật khẩu plain text.
- Order thành công có trừ tồn kho.

## 15. Ghi chú hiện trạng

- Project đang dùng Router thủ công trong `core/Router.php`.
- `core/App.php` có tồn tại nhưng luồng chính hiện tại đi qua `Router`.
- Một số dữ liệu hiện vẫn là dữ liệu mẫu trong model hoặc controller.
- Một số route CRUD admin hiện mới được hứng để tránh 404, chưa phải CRUD hoàn chỉnh.
- PHP CLI trên máy hiện chưa nhận lệnh `php`, nên nếu muốn lint toàn project cần cấu hình PHP vào PATH hoặc chạy qua môi trường có PHP CLI.

