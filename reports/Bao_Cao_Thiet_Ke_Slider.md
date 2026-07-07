# BÁO CÁO THIẾT KẾ CHỨC NĂNG SLIDER

## 1. GIỚI THIỆU CHUNG

### 1.1 Mục đích
Báo cáo này mô tả chi tiết về thiết kế cơ sở dữ liệu và triển khai chức năng Slider (Banner quảng cáo) cho hệ thống Sport Shop. Slider là thành phần quan trọng hiển thị các banner quảng cáo trên trang chủ, giúp thu hút khách hàng và giới thiệu các sản phẩm/khuyến mãi.

### 1.2 Phạm vi
- Thiết kế cơ sở dữ liệu bảng sliders
- Mô tả cấu trúc bảng và các trường dữ liệu
- Các ràng buộc và chỉ mục (indexes)
- SQL script tạo bảng

## 2. THIẾT KẾ CƠ SỞ DỮ LIỆU

### 2.1 Bảng sliders (Slider/Banner)

```sql
CREATE TABLE `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL COMMENT 'Đường dẫn hình ảnh slider',
  `title` varchar(255) DEFAULT NULL COMMENT 'Tiêu đề slider',
  `description` text COMMENT 'Mô tả chi tiết slider',
  `link` varchar(255) DEFAULT NULL COMMENT 'Link khi click vào slider',
  `status` int(1) DEFAULT 1 COMMENT 'Trạng thái: 1=Hiển thị, 0=Ẩn',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày tạo',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ngày cập nhật',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng quản lý slider/banner quảng cáo';
```

### 2.2 Mô tả các trường

| Tên trường | Kiểu dữ liệu | Mô tả | Ràng buộc | Mặc định |
|------------|--------------|-------|-----------|----------|
| `id` | INT(11) | Mã định danh slider (Khóa chính) | PRIMARY KEY, AUTO_INCREMENT | Tự tăng |
| `image` | VARCHAR(255) | Đường dẫn hình ảnh slider | NULL | NULL |
| `title` | VARCHAR(255) | Tiêu đề slider | NULL | NULL |
| `description` | TEXT | Mô tả chi tiết slider | NULL | NULL |
| `link` | VARCHAR(255) | Link khi click vào slider | NULL | NULL |
| `status` | INT(1) | Trạng thái hiển thị (1=Hiển thị, 0=Ẩn) | NULL | 1 |
| `created_at` | TIMESTAMP | Ngày giờ tạo slider | NOT NULL | CURRENT_TIMESTAMP |
| `updated_at` | TIMESTAMP | Ngày giờ cập nhật slider | NOT NULL | CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP |

### 2.3 Ràng buộc và chỉ mục (Indexes)

**Ràng buộc:**
- **PRIMARY KEY:** `id` - Đảm bảo mỗi slider có mã định danh duy nhất
- **NOT NULL:** `created_at`, `updated_at` - Bắt buộc có giá trị

**Chỉ mục (Indexes):**
- **idx_status:** Index trên trường `status` - Tối ưu hóa truy vấn lọc slider theo trạng thái
- **idx_created_at:** Index trên trường `created_at` - Tối ưu hóa truy vấn sắp xếp theo thời gian

### 2.4 Engine và Character Set
- **Engine:** InnoDB - Hỗ trợ transaction, foreign keys, row-level locking
- **Character Set:** utf8mb4 - Hỗ trợ đầy đủ Unicode (bao gồm emoji)
- **Collation:** utf8mb4_unicode_ci - So sánh chuỗi theo chuẩn Unicode

## 3. DỮ LIỆU MẪU (SAMPLE DATA)

```sql
-- Slider 1: Khuyến mãi mùa hè
INSERT INTO `sliders` (`image`, `title`, `description`, `link`, `status`) VALUES 
('public/img/slider/slider_1779244695.jfif', 'Khuyến mãi mùa hè', 'Giảm giá lên đến 50% cho tất cả sản phẩm thể thao', '?mod=product&act=list', 1);

-- Slider 2: Giày Nike mới
INSERT INTO `sliders` (`image`, `title`, `description`, `link`, `status`) VALUES 
('public/img/slider/slider_1779244907.webp', 'Bộ sưu tập Nike mới', 'Khám phá bộ sưu tập giày Nike mới nhất 2024', '?mod=product&act=detail&id=nike001', 1);

-- Slider 3: Phụ kiện thể thao
INSERT INTO `sliders` (`image`, `title`, `description`, `link`, `status`) VALUES 
('public/img/slider/slider_1779245005.jfif', 'Phụ kiện thể thao', 'Đồ bơi, mũ bảo hiểm, túi thể thao', '?mod=product&act=list&category=accessories', 1);
```

## 4. CÁC TRUY VẤN THƯỜNG DÙNG

### 4.1 Lấy tất cả slider đang hoạt động
```sql
SELECT * FROM sliders WHERE status = 1 ORDER BY id ASC;
```

### 4.2 Lấy slider theo phân trang
```sql
SELECT * FROM sliders ORDER BY id DESC LIMIT 0, 10;
```

### 4.3 Đếm tổng số slider
```sql
SELECT COUNT(*) as total FROM sliders;
```

### 4.4 Lấy slider theo ID
```sql
SELECT * FROM sliders WHERE id = ?;
```

### 4.5 Thêm slider mới
```sql
INSERT INTO sliders (image, title, description, link, status) 
VALUES (?, ?, ?, ?, ?);
```

### 4.6 Cập nhật slider
```sql
UPDATE sliders 
SET image = ?, title = ?, description = ?, link = ?, status = ? 
WHERE id = ?;
```

### 4.7 Xóa slider
```sql
DELETE FROM sliders WHERE id = ?;
```

### 4.8 Tìm kiếm slider theo tiêu đề
```sql
SELECT * FROM sliders WHERE title LIKE '%keyword%' ORDER BY id DESC;
```

## 5. TÍCH HỢP VỚI ỨNG DỤNG

### 5.1 Model (models/Slider.php)
Model Slider cung cấp các phương thức CRUD với prepared statements để bảo mật:

- `getAllActive()` - Lấy tất cả slider đang hoạt động
- `getAll($limit, $offset)` - Lấy slider theo phân trang
- `getTotal()` - Đếm tổng số slider
- `find($id)` - Tìm slider theo ID
- `create($data)` - Thêm slider mới
- `update($id, $data)` - Cập nhật slider
- `delete($id)` - Xóa slider

### 5.2 Controller (admin/controllers/SliderController.php)
Controller quản lý các thao tác:
- `list()` - Hiển thị danh sách slider với phân trang
- `add()` - Hiển thị form thêm slider
- `store()` - Xử lý thêm slider mới (bao gồm upload ảnh)
- `edit()` - Hiển thị form sửa slider
- `update()` - Xử lý cập nhật slider
- `delete()` - Xóa slider (bao gồm xóa file ảnh)
- `uploadImage($file)` - Hàm private xử lý upload ảnh

### 5.3 Xử lý upload ảnh
- **Định dạng cho phép:** jpg, jpeg, png, gif, jfif, webp
- **Kích thước tối đa:** 5MB
- **Đường dẫn lưu:** `public/img/slider/`
- **Tên file:** `slider_[timestamp].[extension]`

## 6. GIAO DIỆN QUẢN LÝ

### 6.1 Danh sách slider (slider_list.php)
- Hiển thị table với các cột: ID, Hình ảnh, Tiêu đề, Mô tả, Link, Trạng thái, Ngày tạo, Thao tác
- Nút thêm mới slider
- Phân trang
- Nút sửa và xóa từng slider

### 6.2 Form thêm/sửa slider
- Upload ảnh
- Input tiêu đề
- Textarea mô tả
- Input link
- Checkbox trạng thái (Hiển thị/Ẩn)

## 7. BẢO MẬT

### 7.1 Prepared Statements
Tất cả các truy vấn SQL đều sử dụng prepared statements để tránh SQL Injection:
```php
$stmt = $this->connection->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
```

### 7.2 Validation upload ảnh
- Kiểm tra định dạng file
- Kiểm tra kích thước file
- Tạo tên file ngẫu nhiên để tránh trùng lặp

### 7.3 Xóa file ảnh
Khi xóa hoặc cập nhật slider, file ảnh cũ được xóa khỏi server để tiết kiệm dung lượng.

## 8. TỐI ƯU HÓA

### 8.1 Indexes
- Index trên `status` giúp lọc nhanh các slider đang hoạt động
- Index trên `created_at` giúp sắp xếp theo thời gian nhanh hơn

### 8.2 Caching
Có thể implement caching cho slider đang hoạt động để giảm tải database:
```php
// Cache trong 1 giờ
$sliders = Cache::remember('active_sliders', 3600, function() {
    return Slider::getAllActive();
});
```

## 9. KẾT LUẬN

Bảng `sliders` được thiết kế với cấu trúc đơn giản nhưng đầy đủ chức năng để quản lý slider/banner quảng cáo. Các đặc điểm chính:

- Sử dụng prepared statements để bảo mật
- Có indexes để tối ưu hóa truy vấn
- Hỗ trợ upload ảnh với validation
- Có trạng thái để kiểm soát hiển thị
- Tự động quản lý ngày tạo/cập nhật

---
**Người lập báo cáo:** Cascade AI Assistant  
**Ngày lập:** 06/07/2026  
**Phiên bản:** 1.0
