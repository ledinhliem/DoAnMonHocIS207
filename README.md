# IS207 - Sustainable E-commerce

## Giới thiệu
Đồ án môn Phát triển ứng dụng web - IS207  
Đề tài: Website thương mại điện tử bền vững.

## Tech Stack
- PHP MVC
- MySQL
- Bootstrap 5
- JavaScript / jQuery / AJAX

## Cấu trúc thư mục
- app/controllers
- app/models
- app/views
- config
- core
- database
- public
- routes

## Cách chạy project
1. Clone source về thư mục htdocs
2. Import file `database/sustainable_shop.sql`
3. Cấu hình `config/database.php`
4. Cấu hình `config/config.php`
5. Bật Apache và MySQL
6. Truy cập:
   `http://localhost/is207/index.php`

## Route test
- `http://localhost/is207/index.php`
- `http://localhost/is207/index.php?url=home/index`
- `http://localhost/is207/index.php?url=admin/dashboard`