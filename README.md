# BTL-DBMS-2020: Shop Bán Đồ Thể Thao

<div align="center">
  <h2>Đề tài: Xây dựng trang web bán đồ thể thao</h2>
  <p><strong>Học phần: Cơ sở dữ liệu - Năm học 2020</strong></p>
</div>

---

## Nhóm 3

<div align="center">
  <table>
    <tr>
      <td align="center">
        <img src="public/img/Nguyễn_Thế_Anh.jpg" alt="Nguyễn Thế Anh" width="150" style="border-radius: 50%;">
        <h3>Nguyễn Thế Anh</h3>
        <p>Team Leader</p>
      </td>
      <td align="center">
        <img src="public/img/Phan_Anh_Duc.jpg" alt="Phan Anh Đức" width="150" style="border-radius: 50%;">
        <h3>Phan Anh Đức</h3>
        <p>Frontend Developer</p>
      </td>
      <td align="center">
        <img src="public/img/Phạm_Quốc_Dũng.jpg" alt="Phạm Quốc Dũng" width="150" style="border-radius: 50%;">
        <h3>Phạm Quốc Dũng</h3>
        <p>Database Admin</p>
      </td>
      <td align="center">
        <img src="public/img/Nguyễn_Đức_Long.jpg" alt="Nguyễn Đức Long" width="150" style="border-radius: 50%;">
        <h3>Nguyễn Đức Long</h3>
        <p>Backend Developer</p>
      </td>
    </tr>
  </table>
</div>

---

## Hướng Dẫn Cài Đặt

### Yêu cầu hệ thống
- XAMPP (Apache + MySQL + PHP)
- Trình duyệt web (Chrome, Firefox, etc.)

### Các bước thực hiện

#### **Bước 1: Tải source code**
```bash
git clone https://github.com/Nguyen-The-Anh77/sport_shop.git
```

#### **Bước 2: Di chuyển file**
- Giải nén và chuyển vào thư mục `htdocs` của XAMPP
- Đường dẫn đầy đủ: `C:/xampp/htdocs/sport_shop`

#### **Bước 3: Cấu hình cơ sở dữ liệu**
1. Khởi động XAMPP
2. Mở `http://localhost/phpmyadmin`
3. Tạo database mới với tên: `sport_shops`
4. Import file `database/sport_shops.sql`

#### **Bước 4: Khởi động ứng dụng**
1. Bật Apache và MySQL trong XAMPP
2. Mở trình duyệt và truy cập: `http://localhost/sport_shop`

---

## Tính Năng Chính

| Module | Mô tả |
|--------|-------|
| **Trang chủ** | Hiển thị sản phẩm nổi bật, khuyến mãi |
| **Đăng nhập/Đăng ký** | Xác thực người dùng |
| **Giỏ hàng** | Quản lý sản phẩm đã chọn |
| **Sản phẩm** | Danh sách, chi tiết, tìm kiếm |
| **Liên hệ** | Form gửi yêu cầu hỗ trợ |
| **Admin Panel** | Quản lý sản phẩm, đơn hàng, khách hàng |

---

## Công Nghệ Sử Dụng

<div align="center">
  <img src="https://img.shields.io/badge/PHP-7.4-blue?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0-orange?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
  <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
</div>

---

## Cấu Trúc Project

```
sport_shop/
├── admin/              # Quản trị hệ thống
├── controllers/        # Logic xử lý
├── models/            # Models và Database
├── views/             # Giao diện người dùng
├── public/            # CSS, JS, Images
├── database/          # File SQL
└── index.php          # Entry point
```

---

## Lưu Ý

> **Ứng dụng đang trong giai đoạn phát triển**
> - Có thể còn một số lỗi nhỏ
> - Chưa đầy đủ tất cả tính năng
> - Cần cải thiện giao diện UI/UX

---

## Đóng Góp

Mọi người có thể:
- Báo lỗi qua Issues
- Pull Request để cải thiện
- Đề xuất tính năng mới
- Góp ý học tập

---

## Giấy Phép

<div align="center">
  <p>Dự án phục vụ mục đích học tập</p>
  <p>Made with love by Nhóm 3</p>
</div>

---

## Cảm Ơn

Cảm ơn các bạn đã quan tâm đến dự án! 

<div align="center">
  <h3>Star repository nếu bạn thấy hữu ích!</h3>
</div>
 
