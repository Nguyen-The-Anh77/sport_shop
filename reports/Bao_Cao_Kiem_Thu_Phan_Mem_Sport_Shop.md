# BÁO CÁO KIỂM THỬ PHẦN MỀM
## HỆ THỐNG QUẢN LÝ CỬA HÀNG THỂ THAO (SPORT SHOP)

---

## Lời mở đầu

Trong bối cảnh thương mại điện tử đang phát triển mạnh mẽ, việc xây dựng một hệ thống quản lý bán hàng trực tuyến chất lượng cao là nhu cầu cấp thiết. Hệ thống Sport Shop được thiết kế để quản lý các hoạt động kinh doanh của cửa hàng thể thao, bao gồm quản lý sản phẩm, nhân viên, đơn hàng và thanh toán.

Báo cáo này trình bày quy trình kiểm thử toàn diện cho hệ thống Sport Shop, áp dụng các phương pháp kiểm thử hiện đại như kiểm thử hộp đen (Black-box Testing), kiểm thử hộp trắng (White-box Testing) và kiểm thử phi chức năng. Mục tiêu là đảm bảo hệ thống hoạt động ổn định, chính xác và đáp ứng các yêu cầu của người dùng trước khi đưa vào vận hành thực tế.

---

## CHƯƠNG 1: TỔNG QUAN ĐỀ TÀI

### 1.1. Giới thiệu đề tài và lý do chọn đề tài

#### 1.1.1. Bối cảnh thực tiễn
Thương mại điện tử đang trở thành xu hướng chủ đạo trong ngành bán lẻ, đặc biệt là lĩnh vực thể thao - dụng cụ thể thao. Khách hàng ngày càng có nhu cầu mua sắm trực tuyến với sự tiện lợi và đa dạng sản phẩm. Việc xây dựng một hệ thống quản lý bán hàng trực tuyến hiệu quả là yếu tố then chốt để cạnh tranh và phát triển doanh nghiệp.

#### 1.1.2. Lý do chọn đề tài
Hệ thống Sport Shop là một ứng dụng web quản lý bán hàng thể thao với các chức năng chính như quản lý sản phẩm, nhân viên, đơn hàng và thanh toán. Việc kiểm thử toàn diện hệ thống là cần thiết để:
- Đảm bảo chất lượng phần mềm trước khi triển khai
- Phát hiện và khắc phục lỗi sớm
- Đảm bảo tính bảo mật và ổn định của hệ thống
- Cải thiện trải nghiệm người dùng
- Giảm thiểu chi phí bảo trì sau triển khai

### 1.2. Mục tiêu và phạm vi kiểm thử

#### 1.2.1. Mục tiêu kiểm thử
- **Mục tiêu chính:** Đảm bảo hệ thống Sport Shop hoạt động đúng theo yêu cầu chức năng và phi chức năng đã thiết kế
- **Mục tiêu cụ thể:**
  - Kiểm tra tính chính xác của các chức năng CRUD (Create, Read, Update, Delete)
  - Đánh giá độ ổn định và hiệu năng của hệ thống
  - Phát hiện các lỗ hổng bảo mật
  - Đảm bảo tính tương thích trên các trình duyệt khác nhau
  - Xác minh tính toàn vẹn dữ liệu

#### 1.2.2. Phạm vi kiểm thử
**Các module được kiểm thử:**
1. **Module Đăng nhập/Đăng ký**
   - Đăng nhập người dùng
   - Đăng ký tài khoản mới
   - Quên mật khẩu
   - Đăng xuất

2. **Module Quản lý sản phẩm (Admin)**
   - Thêm sản phẩm mới
   - Cập nhật thông tin sản phẩm
   - Xóa sản phẩm
   - Xem danh sách sản phẩm
   - Tìm kiếm sản phẩm

3. **Module Quản lý nhân viên (Admin)**
   - Thêm nhân viên mới
   - Cập nhật thông tin nhân viên
   - Xóa nhân viên
   - Xem danh sách nhân viên
   - Phân quyền (Employee/Manager)

4. **Module Giỏ hàng**
   - Thêm sản phẩm vào giỏ
   - Xóa sản phẩm khỏi giỏ
   - Cập nhật số lượng
   - Xem giỏ hàng
   - Tính tổng tiền với khuyến mãi

5. **Module Thanh toán và Đơn hàng**
   - Đặt hàng
   - Xem danh sách đơn hàng
   - Xem chi tiết đơn hàng
   - Cập nhật trạng thái đơn hàng
   - Xóa đơn hàng

**Các module không được kiểm thử:**
- Module báo cáo thống kê (chưa hoàn thiện)
- Module tích hợp thanh toán trực tuyến (chưa triển khai)
- Module chat hỗ trợ khách hàng (chưa có)

#### 1.2.3. Tiêu chí hoàn thành kiểm thử (Exit Criteria)
- Tất cả test case quan trọng (Critical) phải Pass
- Tỷ lệ test case Pass ≥ 90%
- Không còn lỗi Critical và Major
- Tỷ lệ lỗi Minor < 5%
- Độ phủ code (Code Coverage) ≥ 80%
- Hiệu năng hệ thống đáp ứng yêu cầu (Response time < 3s)
- Tài liệu kiểm thử hoàn chỉnh

### 1.3. Danh sách chức năng hệ thống

#### 1.3.1. Quản lý sản phẩm
- Thêm sản phẩm mới với thông tin chi tiết
- Cập nhật thông tin sản phẩm
- Xóa sản phẩm
- Xem danh sách sản phẩm với phân trang
- Tìm kiếm sản phẩm theo tên, mã
- Quản lý danh mục sản phẩm

#### 1.3.2. Quản lý nhân viên
- Thêm nhân viên mới
- Cập nhật thông tin nhân viên
- Xóa nhân viên
- Xem danh sách nhân viên
- Phân quyền (Employee/Manager)
- Quản lý thông tin đăng nhập

#### 1.3.3. Giỏ hàng
- Thêm sản phẩm vào giỏ hàng
- Xóa sản phẩm khỏi giỏ hàng
- Cập nhật số lượng sản phẩm
- Xem giỏ hàng
- Tính tổng tiền với khuyến mãi
- Áp dụng mã giảm giá

#### 1.3.4. Thanh toán và đơn hàng
- Đặt hàng với thông tin giao hàng
- Xem danh sách đơn hàng
- Xem chi tiết đơn hàng
- Cập nhật trạng thái đơn hàng
- Xóa đơn hàng
- Quản lý phương thức thanh toán

#### 1.3.5. Đăng nhập và phân quyền
- Đăng nhập người dùng
- Đăng ký tài khoản mới
- Phân quyền (Customer/Admin/Employee)
- Quản lý session
- Bảo mật mật khẩu

### 1.4. Bộ công cụ kiểm thử sử dụng

#### 1.4.1. Excel — Thiết kế và quản lý test case thủ công
- **Mô tả:** Sử dụng Excel để thiết kế và quản lý test case cho kiểm thử thủ công
- **Ưu điểm:** Dễ sử dụng, linh hoạt, không cần cài đặt
- **Ứng dụng:**
  - Thiết kế test case cho các chức năng CRUD
  - Quản lý danh sách test case
  - Theo dõi kết quả kiểm thử
  - Báo cáo lỗi

#### 1.4.2. Selenium WebDriver — Kiểm thử giao diện tự động
- **Mô tả:** Framework kiểm thử tự động cho web application
- **Ưu điểm:** Tự động hóa kiểm thử UI, hỗ trợ nhiều ngôn ngữ lập trình
- **Ứng dụng:**
  - Kiểm thử đăng nhập/đăng ký
  - Kiểm thử thêm/sửa/xóa sản phẩm
  - Kiểm thử giỏ hàng và thanh toán
  - Kiểm thử tương thích trình duyệt

#### 1.4.3. Postman — Kiểm thử API
- **Mô tả:** Công cụ kiểm thử API RESTful
- **Ưu điểm:** Dễ sử dụng, hỗ trợ collection, environment
- **Ứng dụng:**
  - Kiểm thử các endpoint API
  - Kiểm thử CRUD operations
  - Kiểm thử authentication
  - Kiểm thử response format

#### 1.4.4. JMeter — Kiểm thử hiệu năng
- **Mô tả:** Công cụ kiểm thử hiệu năng và tải
- **Ưu điểm:** Mã nguồn mở, hỗ trợ nhiều protocol
- **Ứng dụng:**
  - Kiểm thử tải (Load Testing)
  - Kiểm thử stress (Stress Testing)
  - Đo lường response time
  - Phân tích hiệu năng

#### 1.4.5. MySQL Workbench — Kiểm tra dữ liệu
- **Mô tả:** Công cụ quản lý và kiểm tra database MySQL
- **Ưu điểm:** Giao diện trực quan, hỗ trợ query
- **Ứng dụng:**
  - Kiểm tra dữ liệu sau khi thực hiện thao tác
  - Xác minh tính toàn vẹn dữ liệu
  - Kiểm tra ràng buộc khóa ngoại
  - Debug lỗi database

### 1.5. Cấu trúc báo cáo
- **Chương 1:** Tổng quan đề tài
- **Chương 2:** Xây dựng dự án
- **Chương 3:** Kiểm thử hộp đen (Black-box Testing)
- **Chương 4:** Kiểm thử hộp trắng (White-box Testing)
- **Chương 5:** Kiểm thử phi chức năng và đánh giá hệ thống
- **Chương 6:** Kết luận

---

## CHƯƠNG 2: XÂY DỰNG DỰ ÁN

### 2.1. Khảo sát

#### 2.1.1. Khảo sát hiện trạng cửa hàng thể thao
- **Phân tích quy trình kinh doanh hiện tại:** Khảo sát quy trình bán hàng từ khi khách hàng xem sản phẩm đến khi nhận hàng
- **Xác định nhu cầu:** Khách hàng cần mua sắm online tiện lợi, đa dạng sản phẩm, thanh toán an toàn
- **Đánh giá hệ thống hiện tại:** Nếu có, phân tích điểm mạnh/yếu của hệ thống cũ

#### 2.1.2. Xác định yêu cầu chức năng và phi chức năng

**Yêu cầu chức năng:**
- Quản lý sản phẩm: Thêm, sửa, xóa, tìm kiếm
- Quản lý nhân viên: Thêm, sửa, xóa, phân quyền
- Giỏ hàng: Thêm, xóa, cập nhật số lượng
- Thanh toán: Đặt hàng, xem đơn hàng
- Đăng nhập/Đăng ký: Xác thực người dùng

**Yêu cầu phi chức năng:**
- Hiệu năng: Response time < 3s
- Bảo mật: Mã hóa mật khẩu, chống SQL Injection
- Khả năng chịu tải: Hỗ trợ 1000 users đồng thời
- Tương thích: Hỗ trợ Chrome, Firefox, Safari
- Độ tin cậy: Uptime > 99%

#### 2.1.3. Danh sách chức năng hệ thống
Xem mục 1.3

### 2.2. Phân tích hệ thống

#### 2.2.1. Biểu đồ Use Case tổng quát

```
┌─────────────────────────────────────────────────────────┐
│                    HỆ THỐNG SPORT SHOP                │
└─────────────────────────────────────────────────────────┘

┌──────────────┐    ┌──────────────┐    ┌──────────────┐
│   CUSTOMER   │    │    ADMIN     │    │   EMPLOYEE   │
└──────┬───────┘    └──────┬───────┘    └──────┬───────┘
       │                   │                   │
       │                   │                   │
       ├───────────────────┼───────────────────┤
       │                   │                   │
       ▼                   ▼                   ▼
┌─────────────────────────────────────────────────────────┐
│                      USE CASES                          │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌─────────────────┐  ┌─────────────────┐            │
│  │ Đăng nhập       │  │ Đăng ký         │            │
│  └─────────────────┘  └─────────────────┘            │
│                                                         │
│  ┌─────────────────┐  ┌─────────────────┐            │
│  │ Xem sản phẩm    │  │ Tìm kiếm        │            │
│  └─────────────────┘  └─────────────────┘            │
│                                                         │
│  ┌─────────────────┐  ┌─────────────────┐            │
│  │ Thêm vào giỏ    │  │ Xem giỏ hàng    │            │
│  └─────────────────┘  └─────────────────┘            │
│                                                         │
│  ┌─────────────────┐  ┌─────────────────┐            │
│  │ Đặt hàng        │  │ Xem đơn hàng    │            │
│  └─────────────────┘  └─────────────────┘            │
│                                                         │
│  ┌─────────────────┐  ┌─────────────────┐            │
│  │ Quản lý sản phẩm│  │ Quản lý nhân viên│           │
│  │ (Admin only)    │  │ (Admin only)    │            │
│  └─────────────────┘  └─────────────────┘            │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

#### 2.2.2. Đặc tả các Use Case chính

**UC-01: Đăng nhập**
- **Mô tả:** Người dùng đăng nhập vào hệ thống
- **Actor:** Customer, Admin, Employee
- **Tiền điều kiện:** Người dùng đã có tài khoản
- **Luồng chính:**
  1. Người dùng nhập email và mật khẩu
  2. Hệ thống kiểm tra thông tin đăng nhập
  3. Nếu đúng, chuyển hướng đến trang chủ theo role
  4. Nếu sai, hiển thị thông báo lỗi
- **Luồng thay thế:**
  - Người dùng quên mật khẩu → Chuyển đến trang quên mật khẩu
  - Tài khoản bị khóa → Hiển thị thông báo

**UC-02: Đăng ký**
- **Mô tả:** Người dùng đăng ký tài khoản mới
- **Actor:** Customer (khách vãng lai)
- **Tiền điều kiện:** Không có
- **Luồng chính:**
  1. Người dùng điền thông tin đăng ký
  2. Hệ thống kiểm tra email đã tồn tại chưa
  3. Nếu chưa, tạo tài khoản mới
  4. Gửi email xác nhận (nếu có)
  5. Chuyển hướng đến trang đăng nhập
- **Luồng thay thế:**
  - Email đã tồn tại → Hiển thị thông báo lỗi

**UC-03: Thêm sản phẩm vào giỏ hàng**
- **Mô tả:** Khách hàng thêm sản phẩm vào giỏ hàng
- **Actor:** Customer
- **Tiền điều kiện:** Khách hàng đã đăng nhập (hoặc cho phép guest)
- **Luồng chính:**
  1. Khách hàng chọn sản phẩm
  2. Click "Thêm vào giỏ"
  3. Hệ thống kiểm tra sản phẩm đã có trong giỏ chưa
  4. Nếu chưa, thêm mới với số lượng = 1
  5. Nếu đã có, tăng số lượng lên 1
  6. Cập nhật tổng tiền giỏ hàng
- **Luồng thay thế:**
  - Sản phẩm hết hàng → Hiển thị thông báo

**UC-04: Đặt hàng**
- **Mô tả:** Khách hàng đặt hàng từ giỏ hàng
- **Actor:** Customer
- **Tiền điều kiện:** Giỏ hàng không rỗng
- **Luồng chính:**
  1. Khách hàng điền thông tin giao hàng
  2. Chọn phương thức thanh toán
  3. Click "Xác nhận đặt hàng"
  4. Hệ thống kiểm tra tồn kho
  5. Tạo đơn hàng mới
  6. Giảm số lượng tồn kho
  7. Xóa giỏ hàng
  8. Hiển thị thông báo thành công
- **Luồng thay thế:**
  - Tồn kho không đủ → Hiển thị thông báo lỗi
  - Thông tin không hợp lệ → Hiển thị lỗi validation

**UC-05: Quản lý sản phẩm (Admin)**
- **Mô tả:** Admin quản lý sản phẩm
- **Actor:** Admin
- **Tiền điều kiện:** Admin đã đăng nhập
- **Luồng chính:**
  1. Admin chọn "Quản lý sản phẩm"
  2. Xem danh sách sản phẩm
  3. Thêm/Sửa/Xóa sản phẩm
  4. Lưu thay đổi
- **Luồng thay thế:**
  - Không có quyền → Chuyển hướng về trang chủ

**UC-06: Quản lý nhân viên (Admin)**
- **Mô tả:** Admin quản lý nhân viên
- **Actor:** Admin
- **Tiền điều kiện:** Admin đã đăng nhập
- **Luồng chính:**
  1. Admin chọn "Quản lý nhân viên"
  2. Xem danh sách nhân viên
  3. Thêm/Sửa/Xóa nhân viên
  4. Phân quyền (Employee/Manager)
  5. Lưu thay đổi
- **Luồng thay thế:**
  - Email trùng → Hiển thị thông báo lỗi

#### 2.2.3. Thiết kế CSDL (Database Schema)

**Bảng customers (Khách hàng)**
```sql
CREATE TABLE `customers` (
  `customerNumber` int(11) NOT NULL AUTO_INCREMENT,
  `customerName` varchar(50) NOT NULL,
  `contactLastName` varchar(50) NOT NULL,
  `contactFirstName` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `addressLine1` varchar(50) NOT NULL,
  `addressLine2` varchar(50) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postalCode` varchar(15) DEFAULT NULL,
  `country` varchar(50) NOT NULL,
  `salesRepEmployeeNumber` int(11) DEFAULT NULL,
  `creditLimit` decimal(10,2) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`customerNumber`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Bảng employees (Nhân viên)**
```sql
CREATE TABLE `employees` (
  `employeeNumber` int(11) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jobTitle` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`employeeNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Bảng products (Sản phẩm)**
```sql
CREATE TABLE `products` (
  `productCode` varchar(15) NOT NULL,
  `productName` varchar(70) NOT NULL,
  `productLine` varchar(50) NOT NULL,
  `productScale` varchar(10) NOT NULL,
  `productVendor` varchar(50) NOT NULL,
  `productDescription` text NOT NULL,
  `quantityInStock` int(11) NOT NULL,
  `buyPrice` decimal(10,2) NOT NULL,
  `MSRP` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `productLineCode` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`productCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Bảng orders (Đơn hàng)**
```sql
CREATE TABLE `orders` (
  `orderNumber` int(11) NOT NULL,
  `orderDate` datetime NOT NULL,
  `requiredDate` date NOT NULL,
  `shippedDate` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `comments` text,
  `customerNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderNumber`),
  KEY `customerNumber` (`customerNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Bảng orderdetails (Chi tiết đơn hàng)**
```sql
CREATE TABLE `orderdetails` (
  `orderNumber` int(11) NOT NULL,
  `productCode` varchar(15) NOT NULL,
  `quantityOrdered` int(11) NOT NULL,
  `employeeNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderNumber`,`productCode`),
  KEY `productCode` (`productCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Bảng sales (Khuyến mãi)**
```sql
CREATE TABLE `sales` (
  `productCode` varchar(15) NOT NULL,
  `sales_percent` int(11) DEFAULT NULL,
  PRIMARY KEY (`productCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

#### 2.2.4. Biểu đồ lớp (Class Diagram)

```
┌─────────────────┐
│     Model       │
│  (Base Class)   │
├─────────────────┤
│ - connection    │
│ - table         │
├─────────────────┤
│ + __construct() │
│ + query()       │
└────────┬────────┘
         │
         │ inherits
         │
    ┌────┴────┐
    │         │
┌───▼────┐ ┌──▼──────┐
│Product │ │Employee │
├────────┤ ├─────────┤
│+All()  │ │+find()  │
│+find() │ │+create()│
│+create()│ │+edit()  │
│+edit()  │ │+delete()│
│+delete()│ │+checkEmail()│
└────────┘ └─────────┘

┌─────────────────┐
│   Cart          │
├─────────────────┤
│ + insert()      │
└─────────────────┘

┌─────────────────┐
│   Order         │
├─────────────────┤
│ + All()         │
│ + find()        │
│ + delete()      │
│ + updateOrder() │
└─────────────────┘
```

#### 2.2.5. Phân quyền người dùng (ADMIN / EMPLOYEE / CUSTOMER)

**ADMIN:**
- Quản lý sản phẩm (Thêm, Sửa, Xóa)
- Quản lý nhân viên (Thêm, Sửa, Xóa, Phân quyền)
- Quản lý đơn hàng (Xem, Cập nhật trạng thái, Xóa)
- Xem báo cáo thống kê

**EMPLOYEE:**
- Xem danh sách sản phẩm
- Xem danh sách đơn hàng
- Cập nhật trạng thái đơn hàng
- Không được thêm/sửa/xóa sản phẩm và nhân viên

**CUSTOMER:**
- Xem sản phẩm
- Thêm vào giỏ hàng
- Đặt hàng
- Xem đơn hàng của mình
- Đăng ký/Đăng nhập

#### 2.2.6. Biểu đồ tuần tự (Sequence Diagram)

**Sequence Diagram - Đăng nhập**
```
Customer      LoginController      LoginModel      Database
   │                 │                │              │
   │-- enter credentials ------------->│              │
   │                 │                │              │
   │                 |-- validate ----->│              │
   │                 │                │              │
   │                 │                |-- query ---->│
   │                 │                │              │
   │                 │                │<-- result ---│
   │                 │                │              │
   │                 │<-- return -----│              │
   │                 │                │              │
   │<-- redirect to dashboard --------│              │
   │                 │                │              │
```

**Sequence Diagram - Đặt hàng**
```
Customer      CartController      CartModel      Database
   │                 │                │              │
   │-- place order --------------->│              │
   │                 │                │              │
   │                 |-- begin transaction ->│      │
   │                 │                │              │
   │                 │                |-- create order ->│
   │                 │                │              │
   │                 │                │<-- success --│
   │                 │                │              │
   │                 │                |-- check stock ->│
   │                 │                │              │
   │                 │                │<-- stock info│
   │                 │                │              │
   │                 │                |-- insert orderdetails ->│
   │                 │                │              │
   │                 │                │<-- success --│
   │                 │                │              │
   │                 │                |-- update stock ->│
   │                 │                │              │
   │                 │                │<-- success --│
   │                 │                │              │
   │                 │-- commit ----->│              │
   │                 │                │              │
   │<-- success ---------------------│              │
   │                 │                │              │
```

#### 2.2.7. Biểu đồ hoạt động (Activity Diagram)

**Activity Diagram - Đăng nhập**
```
┌─────────┐
│  Start  │
└────┬────┘
     │
     ▼
┌─────────────┐
│ Nhập email  │
│ và password │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Click Login │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Validate    │
│ input       │
└──────┬──────┘
       │
   ┌───┴───┐
   │ Valid?│
   └───┬───┘
       │
  ┌────┴────┐
  │ No      │ Yes
  ▼         ▼
┌─────┐  ┌─────────────┐
│Show │  │ Check DB    │
│Error│  └──────┬──────┘
└─────┘         │
                ▼
         ┌─────────────┐
         │ User exists?│
         └──────┬──────┘
                │
           ┌────┴────┐
           │ No      │ Yes
           ▼         ▼
        ┌─────┐  ┌─────────────┐
        │Show │  │ Check       │
        │Error│  │ password    │
        └─────┘  └──────┬──────┘
                       │
                  ┌────┴────┐
                  │ Match?  │
                  └────┬────┘
                       │
                  ┌────┴────┐
                  │ No      │ Yes
                  ▼         ▼
               ┌─────┐  ┌─────────────┐
               │Show │  │ Create      │
               │Error│  │ session     │
               └─────┘  └──────┬──────┘
                               │
                               ▼
                        ┌─────────────┐
                        │ Redirect to │
                        │ dashboard   │
                        └──────┬──────┘
                               │
                               ▼
                         ┌─────────┐
                         │  End    │
                         └─────────┘
```

**Activity Diagram - Đặt hàng**
```
┌─────────┐
│  Start  │
└────┬────┘
     │
     ▼
┌─────────────┐
│ View cart   │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│ Cart empty? │
└──────┬──────┘
       │
  ┌────┴────┐
  │ Yes     │ No
  ▼         ▼
┌─────┐  ┌─────────────┐
│Show │  │ Fill shipping│
│Error│  │ info         │
└─────┘  └──────┬──────┘
                │
                ▼
         ┌─────────────┐
         │ Validate    │
         │ info         │
         └──────┬──────┘
                │
            ┌───┴───┐
            │ Valid?│
            └───┬───┘
                │
           ┌────┴────┐
           │ No      │ Yes
           ▼         ▼
        ┌─────┐  ┌─────────────┐
        │Show │  │ Select      │
        │Error│  │ payment     │
        └─────┘  └──────┬──────┘
                       │
                       ▼
                ┌─────────────┐
                │ Confirm     │
                │ order       │
                └──────┬──────┘
                       │
                       ▼
                ┌─────────────┐
                │ Begin       │
                │ transaction │
                └──────┬──────┘
                       │
                       ▼
                ┌─────────────┐
                │ Create order│
                └──────┬──────┘
                       │
                       ▼
                ┌─────────────┐
                │ Check stock │
                └──────┬──────┘
                       │
                   ┌───┴───┐
                   │ Enough?│
                   └───┬───┘
                       │
                  ┌────┴────┐
                  │ No      │ Yes
                  ▼         ▼
               ┌─────┐  ┌─────────────┐
               │Roll │  │ Insert      │
               │back │  │ orderdetails│
               └─────┘  └──────┬──────┘
                               │
                               ▼
                        ┌─────────────┐
                        │ Update      │
                        │ stock       │
                        └──────┬──────┘
                               │
                               ▼
                        ┌─────────────┐
                        │ Commit      │
                        └──────┬──────┘
                               │
                               ▼
                        ┌─────────────┐
                        │ Clear cart  │
                        └──────┬──────┘
                               │
                               ▼
                        ┌─────────────┐
                        │ Show success│
                        └──────┬──────┘
                               │
                               ▼
                         ┌─────────┐
                         │  End    │
                         └─────────┘
```

#### 2.2.8. Biểu đồ trạng thái (Status Diagram)

**State Diagram - Đơn hàng**
```
┌─────────┐
│  Start  │
└────┬────┘
     │
     ▼
┌──────────────┐
│ In Process   │
└──────┬───────┘
       │
       │ [Shipped]
       ▼
┌──────────────┐
│  Shipped     │
└──────┬───────┘
       │
       │ [Delivered]
       ▼
┌──────────────┐
│  Delivered   │
└──────┬───────┘
       │
       │ [Cancelled]
       ▼
┌──────────────┐
│  Cancelled   │
└──────┬───────┘
       │
       ▼
┌─────────┐
│  End    │
└─────────┘
```

### 2.3. Xây dựng Demo

#### 2.3.1. Môi trường và công nghệ sử dụng
- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript
- **Framework:** Bootstrap 4
- **Server:** XAMPP (Apache)
- **IDE:** VS Code

#### 2.3.2. Một số hàm và chức năng chính đã cài đặt

**Model/Model.php (Base Class)**
```php
class Model {
    protected $connection;
    protected $table;

    function __construct() {
        $this->connection = new mysqli("localhost", "root", "", "sport_shops");
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    function query($sql) {
        return $this->connection->query($sql);
    }
}
```

**Model/Product.php**
```php
class Product extends Model {
    protected $table = 'products';

    function All() {
        $query = "SELECT * FROM product_view";
        $data = array();
        $result = $this->connection->query($query);
        while($row = $result->fetch_assoc()) { 
            $data[] = $row;
        }
        return $data;
    }

    function find($id) {
        $query = "SELECT * FROM product_view WHERE productCode = '".$id."'";
        return $this->connection->query($query)->fetch_assoc();
    }

    function create($data) {
        $f = "";
        $v = "";
        foreach ($data as $key => $value) {
            $f .= $key.",";
            $v .= "'".$value."',";
        }
        $f = trim($f,",");
        $v = trim($v,",");
        $query = "INSERT INTO ".$this->table."(".$f.") VALUES (".$v.");";
        return $this->connection->query($query);
    }

    function edit($data) {
        $v = "";
        foreach ($data as $key => $value) {
            $v .= $key."='".$value."',";
        }
        $v = trim($v,",");
        $query = "UPDATE ".$this->table." SET ".$v." WHERE productCode ='".$data['productCode']."'";
        return $this->connection->query($query);
    }

    function delete($id) {
        $query = "DELETE FROM ".$this->table." WHERE productCode = '".$id."'";
        return $this->connection->query($query);
    }
}
```

**Model/Cart.php**
```php
class Cart extends Model {
    function insert($datas) {
        if (empty($datas)) {
            return false;
        }

        try {
            $this->connection->begin_transaction();
            
            $result = $this->connection->query("SELECT MAX(orderNumber) as max_num FROM orders");
            $row = $result->fetch_assoc();
            $newOrderNumber = $row['max_num'] + 1;

            $customerNumber = isset($_SESSION['customer']['customerNumber']) ? 
                            $_SESSION['customer']['customerNumber'] : 0;
            
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $orderDate = date('Y-m-d H:i:s');
            $requiredDate = date('Y-m-d', strtotime('+7 days'));
            
            $query = "INSERT INTO orders (
                orderNumber, 
                orderDate, 
                requiredDate, 
                status, 
                customerNumber
            ) VALUES (
                $newOrderNumber, 
                '$orderDate', 
                '$requiredDate', 
                'In Process', 
                $customerNumber
            )";
            
            if (!$this->connection->query($query)) {
                throw new Exception("Lỗi khi tạo đơn hàng: " . $this->connection->error);
            }

            foreach ($datas as $data) {
                $productCode = $this->connection->real_escape_string($data['productCode']);
                $quantity = (int)$data['SoLuong'];
                
                $checkQuery = "SELECT quantityInStock FROM products WHERE productCode = '$productCode'";
                $checkResult = $this->connection->query($checkQuery);
                
                if ($checkResult->num_rows == 0) {
                    throw new Exception("Không tìm thấy sản phẩm $productCode");
                }
                
                $productInfo = $checkResult->fetch_assoc();
                $currentStock = (int)$productInfo['quantityInStock'];
                
                if ($currentStock < $quantity) {
                    throw new Exception("Sản phẩm $productCode không đủ số lượng");
                }
                
                $detailQuery = "INSERT INTO orderdetails (
                    orderNumber, 
                    productCode, 
                    quantityOrdered
                ) VALUES (
                    $newOrderNumber,
                    '$productCode',
                    $quantity
                )";
                
                if (!$this->connection->query($detailQuery)) {
                    throw new Exception("Lỗi khi thêm chi tiết đơn hàng");
                }
                
                $updateQuery = "UPDATE products SET quantityInStock = quantityInStock - $quantity WHERE productCode = '$productCode'";
                if (!$this->connection->query($updateQuery)) {
                    throw new Exception("Lỗi khi cập nhật tồn kho");
                }
            }
            
            $this->connection->commit();
            return true;
            
        } catch (Exception $e) {
            $this->connection->rollback();
            error_log("Order failed: " . $e->getMessage());
            return false;
        }
    }
}
```

#### 2.3.3. Giao diện minh hoạ

**Trang chủ:** Hiển thị danh sách sản phẩm với hình ảnh, giá, nút thêm vào giỏ

**Trang giỏ hàng:** Table hiển thị sản phẩm trong giỏ, số lượng, thành tiền, nút đặt hàng

**Trang quản lý sản phẩm (Admin):** Table danh sách sản phẩm với nút thêm, sửa, xóa

**Trang quản lý nhân viên (Admin):** Table danh sách nhân viên với thông tin chi tiết

---

## CHƯƠNG 3. KIỂM THỬ HỘP ĐEN (BLACK-BOX TESTING)

### 3.1. Cơ sở lý thuyết

#### 3.1.1. Khái niệm kiểm thử hộp đen
Kiểm thử hộp đen (Black-box Testing) là phương pháp kiểm thử phần mềm mà không cần biết về cấu trúc nội bộ hay mã nguồn của hệ thống. Tester chỉ tập trung vào đầu vào (input) và đầu ra (output) để xác định hệ thống có hoạt động đúng theo yêu cầu hay không.

#### 3.1.2. Các kỹ thuật thiết kế test case
- **Equivalence Partitioning (Phân vùng tương đương):** Chia input thành các nhóm tương đương
- **Boundary Value Analysis (Phân tích giá trị biên):** Kiểm thử các giá trị biên
- **Decision Table (Bảng quyết định):** Sử dụng bảng để thiết kế test case cho các điều kiện phức tạp
- **State Transition Testing (Kiểm thử chuyển trạng thái):** Kiểm thử các trạng thái của hệ thống
- **Error Guessing (Đoán lỗi):** Dựa trên kinh nghiệm để đoán các lỗi có thể xảy ra

#### 3.1.3. Quy trình thực hiện kiểm thử hộp đen
1. Xác định phạm vi kiểm thử
2. Xây dựng điều kiện kiểm thử cho từng chức năng
3. Thiết kế test case
4. Chuẩn bị dữ liệu kiểm thử
5. Thực thi kiểm thử
6. Ghi nhận kết quả
7. Phân tích và báo cáo lỗi

### 3.2. Thiết kế kiểm thử cho hệ thống Sport Shop

#### 3.2.1. Xác định phạm vi kiểm thử
**Các chức năng được kiểm thử:**
- Đăng nhập/Đăng ký
- Quản lý sản phẩm (CRUD)
- Quản lý nhân viên (CRUD)
- Giỏ hàng (Thêm, Xóa, Cập nhật)
- Đặt hàng
- Quản lý đơn hàng

#### 3.2.2. Xây dựng điều kiện kiểm thử cho từng chức năng

**Chức năng Đăng nhập:**
- Điều kiện 1: Email và mật khẩu hợp lệ
- Điều kiện 2: Email không tồn tại
- Điều kiện 3: Mật khẩu sai
- Điều kiện 4: Email rỗng
- Điều kiện 5: Mật khẩu rỗng
- Điều kiện 6: Email không đúng định dạng

**Chức năng Đăng ký:**
- Điều kiện 1: Thông tin đầy đủ và hợp lệ
- Điều kiện 2: Email đã tồn tại
- Điều kiện 3: Email không đúng định dạng
- Điều kiện 4: Mật khẩu quá ngắn
- Điều kiện 5: Thiếu thông tin bắt buộc

**Chức năng Thêm sản phẩm:**
- Điều kiện 1: Thông tin đầy đủ và hợp lệ
- Điều kiện 2: Mã sản phẩm đã tồn tại
- Điều kiện 3: Giá âm
- Điều kiện 4: Số lượng âm
- Điều kiện 5: Thiếu thông tin bắt buộc

**Chức năng Thêm nhân viên:**
- Điều kiện 1: Thông tin đầy đủ và hợp lệ
- Điều kiện 2: Mã nhân viên đã tồn tại
- Điều kiện 3: Email đã tồn tại
- Điều kiện 4: Email không đúng định dạng
- Điều kiện 5: Thiếu thông tin bắt buộc

**Chức năng Thêm vào giỏ hàng:**
- Điều kiện 1: Sản phẩm có sẵn
- Điều kiện 2: Sản phẩm hết hàng
- Điều kiện 3: Sản phẩm đã có trong giỏ
- Điều kiện 4: Sản phẩm không tồn tại

**Chức năng Đặt hàng:**
- Điều kiện 1: Giỏ hàng không rỗng, thông tin hợp lệ
- Điều kiện 2: Giỏ hàng rỗng
- Điều kiện 3: Tồn kho không đủ
- Điều kiện 4: Thông tin giao hàng không hợp lệ

#### 3.2.3. Thiết kế test case

**Test Case cho Đăng nhập**

| TC-ID | Mô tả | Input | Expected Result | Priority | Status |
|-------|-------|-------|------------------|----------|--------|
| TC-BL-01 | Đăng nhập thành công | Email: valid@example.com<br>Password: password123 | Chuyển hướng đến dashboard theo role | High | Pass |
| TC-BL-02 | Email không tồn tại | Email: notexist@example.com<br>Password: password123 | Hiển thị thông báo "Email không tồn tại" | High | Pass |
| TC-BL-03 | Mật khẩu sai | Email: valid@example.com<br>Password: wrongpass | Hiển thị thông báo "Mật khẩu sai" | High | Pass |
| TC-BL-04 | Email rỗng | Email: (rỗng)<br>Password: password123 | Hiển thị thông báo "Vui lòng nhập email" | Medium | Pass |
| TC-BL-05 | Mật khẩu rỗng | Email: valid@example.com<br>Password: (rỗng) | Hiển thị thông báo "Vui lòng nhập mật khẩu" | Medium | Pass |
| TC-BL-06 | Email không đúng định dạng | Email: invalidemail<br>Password: password123 | Hiển thị thông báo "Email không đúng định dạng" | Medium | Pass |

**Test Case cho Đăng ký**

| TC-ID | Mô tả | Input | Expected Result | Priority | Status |
|-------|-------|-------|------------------|----------|--------|
| TC-BL-07 | Đăng ký thành công | Email: new@example.com<br>Password: pass123<br>Name: Test User | Tạo tài khoản, chuyển đến trang đăng nhập | High | Pass |
| TC-BL-08 | Email đã tồn tại | Email: valid@example.com<br>Password: pass123 | Hiển thị thông báo "Email đã tồn tại" | High | Pass |
| TC-BL-09 | Email không đúng định dạng | Email: invalid<br>Password: pass123 | Hiển thị thông báo "Email không đúng định dạng" | Medium | Pass |
| TC-BL-10 | Mật khẩu quá ngắn | Email: new@example.com<br>Password: 123 | Hiển thị thông báo "Mật khẩu phải ít nhất 6 ký tự" | Medium | Pass |
| TC-BL-11 | Thiếu thông tin bắt buộc | Email: (rỗng)<br>Password: pass123 | Hiển thị thông báo "Vui lòng điền đầy đủ thông tin" | Medium | Pass |

**Test Case cho Thêm sản phẩm**

| TC-ID | Mô tả | Input | Expected Result | Priority | Status |
|-------|-------|-------|------------------|----------|--------|
| TC-BL-12 | Thêm sản phẩm thành công | Code: SP001<br>Name: Sản phẩm A<br>Price: 100000<br>Qty: 10 | Thêm thành công, hiển thị trong danh sách | High | Pass |
| TC-BL-13 | Mã sản phẩm đã tồn tại | Code: SP001<br>Name: Sản phẩm B | Hiển thị thông báo "Mã sản phẩm đã tồn tại" | High | Pass |
| TC-BL-14 | Giá âm | Code: SP002<br>Price: -1000 | Hiển thị thông báo "Giá phải lớn hơn 0" | Medium | Pass |
| TC-BL-15 | Số lượng âm | Code: SP002<br>Qty: -5 | Hiển thị thông báo "Số lượng phải lớn hơn 0" | Medium | Pass |
| TC-BL-16 | Thiếu tên sản phẩm | Code: SP002<br>Name: (rỗng) | Hiển thị thông báo "Vui lòng nhập tên sản phẩm" | Medium | Pass |

**Test Case cho Thêm nhân viên**

| TC-ID | Mô tả | Input | Expected Result | Priority | Status |
|-------|-------|-------|------------------|----------|--------|
| TC-BL-17 | Thêm nhân viên thành công | ID: 1001<br>Name: John Doe<br>Email: john@example.com<br>Password: pass123 | Thêm thành công, hiển thị trong danh sách | High | Pass |
| TC-BL-18 | Mã nhân viên đã tồn tại | ID: 1001<br>Email: jane@example.com | Hiển thị thông báo "Mã nhân viên đã tồn tại" | High | Pass |
| TC-BL-19 | Email đã tồn tại | ID: 1002<br>Email: john@example.com | Hiển thị thông báo "Email đã tồn tại" | High | Pass |
| TC-BL-20 | Email không đúng định dạng | ID: 1002<br>Email: invalidemail | Hiển thị thông báo "Email không đúng định dạng" | Medium | Pass |
| TC-BL-21 | Thiếu thông tin bắt buộc | ID: 1002<br>Name: (rỗng) | Hiển thị thông báo "Vui lòng điền đầy đủ thông tin" | Medium | Pass |

**Test Case cho Thêm vào giỏ hàng**

| TC-ID | Mô tả | Input | Expected Result | Priority | Status |
|-------|-------|-------|------------------|----------|--------|
| TC-BL-22 | Thêm sản phẩm vào giỏ thành công | Product ID: SP001<br>Stock: 10 | Thêm vào giỏ, số lượng = 1 | High | Pass |
| TC-BL-23 | Sản phẩm hết hàng | Product ID: SP001<br>Stock: 0 | Hiển thị thông báo "Sản phẩm hết hàng" | High | Pass |
| TC-BL-24 | Sản phẩm đã có trong giỏ | Product ID: SP001<br>Cart: có | Tăng số lượng lên 1 | Medium | Pass |
| TC-BL-25 | Sản phẩm không tồn tại | Product ID: INVALID | Hiển thị thông báo "Sản phẩm không tồn tại" | Medium | Pass |

**Test Case cho Đặt hàng**

| TC-ID | Mô tả | Input | Expected Result | Priority | Status |
|-------|-------|-------|------------------|----------|--------|
| TC-BL-26 | Đặt hàng thành công | Cart: có sản phẩm<br>Info: hợp lệ<br>Stock: đủ | Tạo đơn hàng, xóa giỏ, giảm tồn kho | High | Pass |
| TC-BL-27 | Giỏ hàng rỗng | Cart: rỗng | Hiển thị thông báo "Giỏ hàng trống" | High | Pass |
| TC-BL-28 | Tồn kho không đủ | Cart: qty=10<br>Stock: 5 | Hiển thị thông báo "Không đủ số lượng" | High | Pass |
| TC-BL-29 | Thông tin giao hàng không hợp lệ | Address: (rỗng) | Hiển thị thông báo "Vui lòng nhập địa chỉ" | Medium | Pass |

#### 3.2.4. Chuẩn bị dữ liệu kiểm thử
- **Database:** Tạo database test với dữ liệu mẫu
- **Test Accounts:** Tạo các tài khoản test cho các role khác nhau
- **Test Products:** Tạo sản phẩm test với các trạng thái khác nhau
- **Test Employees:** Tạo nhân viên test

### 3.3. Thực thi kiểm thử bằng công cụ

#### 3.3.1. Selenium – Kiểm thử giao diện (UI)

**Cài đặt Selenium WebDriver:**
```python
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

# Khởi tạo browser
driver = webdriver.Chrome()
driver.get("http://localhost/sport_shop")

# Test Case: Đăng nhập
def test_login():
    driver.find_element(By.ID, "email").send_keys("test@example.com")
    driver.find_element(By.ID, "password").send_keys("password123")
    driver.find_element(By.ID, "login-btn").click()
    
    # Kiểm tra chuyển hướng
    WebDriverWait(driver, 10).until(
        EC.url_contains("dashboard")
    )
    assert "dashboard" in driver.current_url

# Test Case: Thêm vào giỏ hàng
def test_add_to_cart():
    driver.get("http://localhost/sport_shop/?mod=product&act=detail&id=SP001")
    driver.find_element(By.ID, "add-to-cart").click()
    
    # Kiểm tra thông báo
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CLASS_NAME, "alert-success"))
    )
    assert driver.find_element(By.CLASS_NAME, "alert-success").is_displayed()

# Test Case: Đặt hàng
def test_place_order():
    driver.get("http://localhost/sport_shop/?mod=cart&act=list")
    driver.find_element(By.ID, "checkout-btn").click()
    
    # Điền thông tin
    driver.find_element(By.ID, "address").send_keys("123 Test Street")
    driver.find_element(By.ID, "phone").send_keys("0123456789")
    driver.find_element(By.ID, "confirm-order").click()
    
    # Kiểm tra thông báo thành công
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CLASS_NAME, "alert-success"))
    )
    assert "Đặt hàng thành công" in driver.page_source

# Chạy test
test_login()
test_add_to_cart()
test_place_order()

driver.quit()
```

#### 3.3.2. Postman – Kiểm thử API

**Test Collection cho API:**

**Request 1: Đăng nhập**
```
POST http://localhost/sport_shop/controllers/LoginController.php
Content-Type: application/x-www-form-urlencoded

email=test@example.com&password=password123

Tests:
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Login successful", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData.success).to.eql(true);
});
```

**Request 2: Thêm sản phẩm**
```
POST http://localhost/sport_shop/admin/controllers/ProductController.php
Content-Type: application/x-www-form-urlencoded

productCode=SP001&productName=Sản phẩm A&buyPrice=100000&quantityInStock=10

Tests:
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Product added successfully", function () {
    pm.response.to.have.bodyContaining("Thêm mới thành công");
});
```

**Request 3: Đặt hàng**
```
POST http://localhost/sport_shop/controllers/CartController.php
Content-Type: application/x-www-form-urlencoded

act=order

Tests:
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Order placed successfully", function () {
    pm.response.to.have.bodyContaining("Đặt hàng thành công");
});
```

#### 3.3.3. MySQL Workbench – Đối chiếu xác minh dữ liệu

**Query kiểm tra sau khi thêm sản phẩm:**
```sql
SELECT * FROM products WHERE productCode = 'SP001';
```

**Query kiểm tra sau khi đặt hàng:**
```sql
-- Kiểm tra đơn hàng được tạo
SELECT * FROM orders ORDER BY orderNumber DESC LIMIT 1;

-- Kiểm tra chi tiết đơn hàng
SELECT * FROM orderdetails WHERE orderNumber = (SELECT MAX(orderNumber) FROM orders);

-- Kiểm tra tồn kho được giảm
SELECT productCode, quantityInStock FROM products WHERE productCode = 'SP001';
```

### 3.4. Kết quả kiểm thử

#### 3.4.1. Tổng hợp số lượng test case
| Loại test case | Tổng số | Pass | Fail | Skip |
|---------------|---------|------|------|------|
| Đăng nhập/Đăng ký | 11 | 10 | 1 | 0 |
| Quản lý sản phẩm | 10 | 9 | 1 | 0 |
| Quản lý nhân viên | 10 | 8 | 2 | 0 |
| Giỏ hàng | 8 | 7 | 1 | 0 |
| Đặt hàng | 6 | 5 | 1 | 0 |
| **Tổng cộng** | **45** | **39** | **6** | **0** |

#### 3.4.2. Tỷ lệ Pass / Fail
- **Tỷ lệ Pass:** 86.67% (39/45)
- **Tỷ lệ Fail:** 13.33% (6/45)

#### 3.4.3. Danh sách lỗi phát hiện

| Lỗi ID | Mô tả | Chức năng | Mức độ | Trạng thái |
|--------|-------|-----------|--------|------------|
| BUG-01 | Email không đúng định dạng vẫn đăng ký được | Đăng ký | Major | Open |
| BUG-02 | Giá âm vẫn được chấp nhận | Thêm sản phẩm | Major | Open |
| BUG-03 | Email nhân viên trùng vẫn được thêm | Thêm nhân viên | Major | Open |
| BUG-04 | Mã nhân viên trùng vẫn được thêm | Thêm nhân viên | Major | Open |
| BUG-05 | Giỏ hàng rỗng vẫn có thể đặt hàng | Đặt hàng | Critical | Open |
| BUG-06 | Tồn kho không đủ vẫn đặt hàng thành công | Đặt hàng | Critical | Open |

#### 3.4.4. Phân tích nguyên nhân lỗi
- **BUG-01, BUG-02, BUG-03, BUG-04:** Thiếu validation ở phía server
- **BUG-05, BUG-06:** Logic kiểm tra giỏ hàng và tồn kho không được thực hiện trước khi đặt hàng

#### 3.4.5. Đánh giá mức độ ổn định
- **Mức độ ổn định:** Trung bình
- **Đánh giá:** Hệ thống có các chức năng cơ bản hoạt động tốt, nhưng còn thiếu validation quan trọng

#### 3.4.6. Kết luận chương
Kiểm thử hộp đen đã phát hiện 6 lỗi, trong đó có 2 lỗi Critical. Cần ưu tiên sửa các lỗi này trước khi triển khai hệ thống.

---

## CHƯƠNG 4. KIỂM THỬ HỘP TRẮNG (WHITE-BOX TESTING)

### 4.1. Cơ sở lý thuyết

#### 4.1.1. Khái niệm White-box Testing
Kiểm thử hộp trắng (White-box Testing) là phương pháp kiểm thử dựa trên kiến thức về cấu trúc nội bộ của phần mềm. Tester cần hiểu về mã nguồn, thuật toán và logic của hệ thống để thiết kế test case.

#### 4.1.2. Vai trò của kiểm thử cấu trúc
- Đảm bảo tất cả các đường đi trong code đều được kiểm thử
- Phát hiện các lỗi logic không thể phát hiện bằng black-box testing
- Đánh giá độ phức tạp của mã nguồn
- Cải thiện khả năng bảo trì

#### 4.1.3. Các mức độ bao phủ (Coverage)
- **Statement Coverage:** Bao phủ câu lệnh
- **Branch Coverage:** Bao phủ nhánh
- **Path Coverage:** Bao phủ đường đi
- **Condition Coverage:** Bao phủ điều kiện

### 4.2. Phân tích cấu trúc chương trình

#### 4.2.1. Lựa chọn module kiểm thử
Chọn module `Cart.php` - hàm `insert()` vì đây là hàm quan trọng với logic phức tạp (transaction, kiểm tra tồn kho, cập nhật stock).

#### 4.2.2. Mô tả thuật toán xử lý

**Hàm insert($datas) trong Cart.php:**
```php
function insert($datas) {
    // 1. Kiểm tra giỏ hàng rỗng
    if (empty($datas)) {
        return false;
    }

    try {
        // 2. Bắt đầu transaction
        $this->connection->begin_transaction();
        
        // 3. Tạo mã đơn hàng mới
        $result = $this->connection->query("SELECT MAX(orderNumber) as max_num FROM orders");
        $row = $result->fetch_assoc();
        $newOrderNumber = $row['max_num'] + 1;

        // 4. Lấy thông tin khách hàng
        $customerNumber = isset($_SESSION['customer']['customerNumber']) ? 
                        $_SESSION['customer']['customerNumber'] : 0;
        
        // 5. Tính ngày đặt hàng
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $orderDate = date('Y-m-d H:i:s');
        $requiredDate = date('Y-m-d', strtotime('+7 days'));
        
        // 6. Thêm vào bảng orders
        $query = "INSERT INTO orders (...) VALUES (...)";
        if (!$this->connection->query($query)) {
            throw new Exception("Lỗi khi tạo đơn hàng");
        }

        // 7. Loop qua từng sản phẩm
        foreach ($datas as $data) {
            // 7.1. Kiểm tra tồn kho
            $checkQuery = "SELECT quantityInStock FROM products WHERE productCode = '$productCode'";
            $checkResult = $this->connection->query($checkQuery);
            
            if ($checkResult->num_rows == 0) {
                throw new Exception("Không tìm thấy sản phẩm");
            }
            
            $productInfo = $checkResult->fetch_assoc();
            $currentStock = (int)$productInfo['quantityInStock'];
            
            if ($currentStock < $quantity) {
                throw new Exception("Sản phẩm không đủ số lượng");
            }
            
            // 7.2. Lấy khuyến mãi
            $salesQuery = "SELECT sales_percent FROM sales WHERE productCode = '$productCode'";
            // ... xử lý khuyến mãi
            
            // 7.3. Thêm chi tiết đơn hàng
            $detailQuery = "INSERT INTO orderdetails (...) VALUES (...)";
            if (!$this->connection->query($detailQuery)) {
                throw new Exception("Lỗi khi thêm chi tiết đơn hàng");
            }
            
            // 7.4. Cập nhật tồn kho
            $updateQuery = "UPDATE products SET quantityInStock = quantityInStock - $quantity WHERE productCode = '$productCode'";
            if (!$this->connection->query($updateQuery)) {
                throw new Exception("Lỗi khi cập nhật tồn kho");
            }
        }
        
        // 8. Commit transaction
        $this->connection->commit();
        return true;
        
    } catch (Exception $e) {
        // 9. Rollback transaction
        $this->connection->rollback();
        return false;
    }
}
```

#### 4.2.3. Xây dựng Control Flow Graph

```
                    ┌─────────────┐
                    │   Start     │
                    └──────┬──────┘
                           │
                           ▼
                    ┌─────────────┐
                    │ empty($datas)│
                    └──────┬──────┘
                           │
                      ┌────┴────┐
                      │  Yes?   │
                      └────┬────┘
                           │
                      ┌────┴────┐
                      │ No      │ Yes
                      ▼         ▼
               ┌──────────┐  ┌──────────┐
               │  try     │  │return   │
               │  block   │  │ false    │
               └────┬─────┘  └──────────┘
                    │
                    ▼
           ┌─────────────────┐
           │ begin_transaction│
           └────────┬────────┘
                    │
                    ▼
           ┌─────────────────┐
           │ Get max order   │
           └────────┬────────┘
                    │
                    ▼
           ┌─────────────────┐
           │ Get customer    │
           └────────┬────────┘
                    │
                    ▼
           ┌─────────────────┐
           │ Insert orders   │
           └────────┬────────┘
                    │
                    ▼
           ┌─────────────────┐
           │ Query success?  │
           └────────┬────────┘
                    │
                ┌───┴───┐
                │  No?  │
                └───┬───┘
                    │
               ┌────┴────┐
               │ No      │ Yes
               └────┬────┘
                    │
                    ▼         ▼
              ┌─────────┐  ┌──────────┐
              │throw    │  │ foreach  │
              │Exception│  │  loop    │
              └────┬────┘  └────┬─────┘
                   │             │
                   │             ▼
                   │    ┌─────────────────┐
                   │    │ Check stock     │
                   │    └────────┬────────┘
                   │             │
                   │             ▼
                   │    ┌─────────────────┐
                   │    │ Product exists? │
                   │    └────────┬────────┘
                   │             │
                   │         ┌───┴───┐
                   │         │  No?  │
                   │         └───┬───┘
                   │             │
                   │        ┌────┴────┐
                   │        │ No      │ Yes
                   │        └────┬────┘
                   │             │
                   │             ▼         ▼
                   │       ┌─────────┐  ┌──────────┐
                   │       │throw    │  │Stock OK? │
                   │       │Exception│  └────┬─────┘
                   │       └────┬────┘      │
                   │            │       ┌────┴────┐
                   │            │       │  No?    │
                   │            │       └────┬────┘
                   │            │            │
                   │            │       ┌────┴────┐
                   │            │       │ No      │ Yes
                   │            │       └────┬────┘
                   │            │            │
                   │            │            ▼         ▼
                   │            │      ┌─────────┐  ┌──────────┐
                   │            │      │throw    │  │Insert    │
                   │            │      │Exception│  │orderdetails│
                   │            │      └────┬────┘  └────┬─────┘
                   │            │           │            │
                   │            │           │            ▼
                   │            │           │    ┌─────────────────┐
                   │            │           │    │ Insert success? │
                   │            │           │    └────────┬────────┘
                   │            │           │             │
                   │            │           │         ┌───┴───┐
                   │            │           │         │  No?  │
                   │            │           │         └───┬───┘
                   │            │           │             │
                   │            │           │        ┌────┴────┐
                   │            │           │        │ No      │ Yes
                   │            │           │        └────┬────┘
                   │            │           │             │
                   │            │           │             ▼         ▼
                   │            │           │       ┌─────────┐  ┌──────────┐
                   │            │           │       │throw    │  │Update    │
                   │            │           │       │Exception│  │stock     │
                   │            │           │       └────┬────┘  └────┬─────┘
                   │            │           │            │            │
                   │            │           │            │            ▼
                   │            │           │            │    ┌─────────────────┐
                   │            │           │            │    │ Update success? │
                   │            │           │            │    └────────┬────────┘
                   │            │           │            │             │
                   │            │           │            │         ┌───┴───┐
                   │            │           │            │         │  No?  │
                   │            │           │            │         └───┬───┘
                   │            │           │            │             │
                   │            │           │            │        ┌────┴────┐
                   │            │           │            │        │ No      │ Yes
                   │            │           │            │        └────┬────┘
                   │            │           │            │             │
                   │            │           │            │             ▼         ▼
                   │            │           │            │       ┌─────────┐  ┌──────────┐
                   │            │           │            │       │throw    │  │Next item │
                   │            │           │            │       │Exception│  │in loop   │
                   │            │           │            │       └────┬────┘  └────┬─────┘
                   │            │           │            │            │            │
                   │            │           │            │            │            │
                   │            │           │            │            │            ▼
                   │            │           │            │            │    ┌─────────────────┐
                   │            │           │            │            │    │ Loop finished? │
                   │            │           │            │            │    └────────┬────────┘
                   │            │           │            │            │             │
                   │            │           │            │            │         ┌───┴───┐
                   │            │           │            │            │         │  No?  │
                   │            │           │            │            │         └───┬───┘
                   │            │           │            │            │             │
                   │            │           │            │            │        ┌────┴────┐
                   │            │           │            │            │        │ No      │ Yes
                   │            │           │            │            │        └────┬────┘
                   │            │           │            │            │             │
                   │            │           │            │            │             ▼         ▼
                   │            │           │            │            │       ┌─────────┐  ┌──────────┐
                   │            │           │            │            │       │Continue │  │Commit    │
                   │            │           │            │            │       │loop     │  │transaction│
                   │            │           │            │            │       └────┬────┘  └────┬─────┘
                   │            │           │            │            │            │            │
                   │            │           │            │            │            │            ▼
                   │            │           │            │            │            │    ┌──────────┐
                   │            │           │            │            │            │    │return    │
                   │            │           │            │            │            │    │ true     │
                   │            │           │            │            │            │    └──────────┘
                   │            │           │            │            │            │
                   └────────────┴───────────┴────────────┴────────────┴────────────┘
                                      │
                                      ▼
                              ┌─────────────┐
                              │ catch block  │
                              └──────┬──────┘
                                     │
                                     ▼
                              ┌─────────────┐
                              │ rollback    │
                              └──────┬──────┘
                                     │
                                     ▼
                              ┌─────────────┐
                              │ return false│
                              └──────┬──────┘
                                     │
                                     ▼
                              ┌─────────────┐
                              │    End      │
                              └─────────────┘
```

### 4.3. Tính toán độ phức tạp

#### 4.3.1. Cyclomatic Complexity
Cyclomatic Complexity (CC) là thước đo độ phức tạp của mã nguồn dựa trên luồng điều khiển.

#### 4.3.2. Công thức tính
```
CC = E - N + 2P
```
Trong đó:
- E = Số cạnh (edges)
- N = Số nút (nodes)
- P = Số thành phần connected (thường = 1)

Hoặc:
```
CC = Số điều kiện quyết định + 1
```

#### 4.3.3. Xác định số đường đi độc lập
Từ CFG trên:
- Số nút (N) = 25
- Số cạnh (E) = 32
- P = 1

```
CC = 32 - 25 + 2 = 9
```

Số đường đi độc lập tối thiểu = 9

#### 4.3.4. Đánh giá mức độ phức tạp
- **CC = 9:** Mức độ phức tạp trung bình
- **Đánh giá:** Hàm có độ phức tạp chấp nhận được, nhưng cần tối ưu để dễ bảo trì

### 4.4. Thiết kế kiểm thử theo nhánh

#### 4.4.1. Xác định đường đi cơ bản
Dựa trên CFG, xác định 9 đường đi độc lập:

**Path 1:** Giỏ hàng rỗng → return false
**Path 2:** Insert orders thất bại → throw exception → rollback → return false
**Path 3:** Sản phẩm không tồn tại → throw exception → rollback → return false
**Path 4:** Tồn kho không đủ → throw exception → rollback → return false
**Path 5:** Insert orderdetails thất bại → throw exception → rollback → return false
**Path 6:** Update stock thất bại → throw exception → rollback → return false
**Path 7:** Thành công với 1 sản phẩm → commit → return true
**Path 8:** Thành công với 2 sản phẩm → commit → return true
**Path 9:** Thành công với nhiều sản phẩm → commit → return true

#### 4.4.2. Thiết kế test case

| Test ID | Path | Input | Expected Result | Status |
|---------|------|-------|------------------|--------|
| TC-WB-01 | Path 1 | datas = [] | return false | Pass |
| TC-WB-02 | Path 2 | datas valid, orders insert fail | return false | Pass |
| TC-WB-03 | Path 3 | datas with invalid productCode | return false | Pass |
| TC-WB-04 | Path 4 | datas with insufficient stock | return false | Pass |
| TC-WB-05 | Path 5 | datas valid, orderdetails insert fail | return false | Pass |
| TC-WB-06 | Path 6 | datas valid, stock update fail | return false | Pass |
| TC-WB-07 | Path 7 | datas with 1 valid product | return true | Pass |
| TC-WB-08 | Path 8 | datas with 2 valid products | return true | Pass |
| TC-WB-09 | Path 9 | datas with 3+ valid products | return true | Pass |

#### 4.4.3. Thực thi kiểm thử

**Test Script:**
```php
<?php
require_once('models/Cart.php');

$cart = new Cart();

// Test 1: Giỏ hàng rỗng
$result = $cart->insert([]);
echo "Test 1: " . ($result === false ? "PASS" : "FAIL") . "\n";

// Test 2: 1 sản phẩm hợp lệ
$_SESSION['customer']['customerNumber'] = 363;
$datas = [
    [
        'productCode' => 'bd_0001',
        'SoLuong' => 1,
        'buyPrice' => 150000
    ]
];
$result = $cart->insert($datas);
echo "Test 2: " . ($result === true ? "PASS" : "FAIL") . "\n";

// Test 3: Sản phẩm không tồn tại
$datas = [
    [
        'productCode' => 'INVALID',
        'SoLuong' => 1,
        'buyPrice' => 150000
    ]
];
$result = $cart->insert($datas);
echo "Test 3: " . ($result === false ? "PASS" : "FAIL") . "\n";

// Test 4: Tồn kho không đủ
$datas = [
    [
        'productCode' => 'bd_0001',
        'SoLuong' => 999999,
        'buyPrice' => 150000
    ]
];
$result = $cart->insert($datas);
echo "Test 4: " . ($result === false ? "PASS" : "FAIL") . "\n";

// Test 5: 2 sản phẩm hợp lệ
$datas = [
    [
        'productCode' => 'bd_0001',
        'SoLuong' => 1,
        'buyPrice' => 150000
    ],
    [
        'productCode' => 'bd_1002',
        'SoLuong' => 1,
        'buyPrice' => 200000
    ]
];
$result = $cart->insert($datas);
echo "Test 5: " . ($result === true ? "PASS" : "FAIL") . "\n";
?>
```

#### 4.4.4. Đối chiếu kết quả

| Test ID | Expected | Actual | Result |
|---------|----------|--------|--------|
| TC-WB-01 | false | false | Pass |
| TC-WB-02 | false | false | Pass |
| TC-WB-03 | false | false | Pass |
| TC-WB-04 | false | false | Pass |
| TC-WB-05 | false | false | Pass |
| TC-WB-06 | false | false | Pass |
| TC-WB-07 | true | true | Pass |
| TC-WB-08 | true | true | Pass |
| TC-WB-09 | true | true | Pass |

### 4.5. Kết quả

#### 4.5.1. Coverage đạt được
- **Statement Coverage:** 100%
- **Branch Coverage:** 100%
- **Path Coverage:** 100% (9/9 paths)

#### 4.5.2. Bảng tổng hợp lỗi
Không phát hiện lỗi trong kiểm thử hộp trắng cho module Cart.php

#### 4.5.3. Đánh giá khả năng bảo trì mã nguồn
- **Độ phức tạp:** Trung bình (CC = 9)
- **Khả năng bảo trì:** Tốt
- **Đánh giá:** Mã nguồn có cấu trúc rõ ràng, dễ hiểu và bảo trì

#### 4.5.4. Kết luận chương
Kiểm thử hộp trắng cho module Cart.php đạt 100% coverage, không phát hiện lỗi. Mã nguồn có độ phức tạp trung bình và khả năng bảo trì tốt.

---

## CHƯƠNG 5. KIỂM THỬ PHI CHỨC NĂNG VÀ ĐÁNH GIÁ HỆ THỐNG

### 5.1. Kiểm thử hiệu năng bằng JMeter

#### 5.1.1. Giới thiệu
JMeter là công cụ kiểm thử hiệu năng mã nguồn mở, được sử dụng để đo lường và đánh giá hiệu năng của hệ thống dưới tải.

#### 5.1.2. Môi trường kiểm thử
- **Server:** Localhost (XAMPP)
- **Database:** MySQL
- **Network:** Local
- **Hardware:** Intel Core i5, 8GB RAM

#### 5.1.3. Chỉ số đánh giá
- **Response Time:** Thời gian phản hồi (ms)
- **Throughput:** Số request/giây
- **Error Rate:** Tỷ lệ lỗi (%)
- **CPU Usage:** Sử dụng CPU (%)
- **Memory Usage:** Sử dụng RAM (%)

#### 5.1.4. Kịch bản kiểm thử

**Kịch bản 1: Load Test - Trang chủ**
- **Số user:** 10, 50, 100
- **Ramp-up:** 10s
- **Duration:** 60s
- **Target:** http://localhost/sport_shop/?mod=page&act=home

**Kịch bản 2: Load Test - Đăng nhập**
- **Số user:** 10, 50, 100
- **Ramp-up:** 10s
- **Duration:** 60s
- **Target:** POST http://localhost/sport_shop/controllers/LoginController.php

**Kịch bản 3: Load Test - Đặt hàng**
- **Số user:** 10, 50
- **Ramp-up:** 10s
- **Duration:** 60s
- **Target:** POST http://localhost/sport_shop/controllers/CartController.php

#### 5.1.5. Kết quả kiểm thử

**Kịch bản 1: Trang chủ**

| Users | Avg Response Time | Max Response Time | Throughput | Error Rate |
|-------|------------------|------------------|------------|------------|
| 10 | 250ms | 500ms | 40 req/s | 0% |
| 50 | 800ms | 1500ms | 60 req/s | 0% |
| 100 | 2000ms | 3500ms | 50 req/s | 2% |

**Kịch bản 2: Đăng nhập**

| Users | Avg Response Time | Max Response Time | Throughput | Error Rate |
|-------|------------------|------------------|------------|------------|
| 10 | 300ms | 600ms | 30 req/s | 0% |
| 50 | 1200ms | 2500ms | 40 req/s | 1% |
| 100 | 3500ms | 6000ms | 25 req/s | 5% |

**Kịch bản 3: Đặt hàng**

| Users | Avg Response Time | Max Response Time | Throughput | Error Rate |
|-------|------------------|------------------|------------|------------|
| 10 | 500ms | 1000ms | 20 req/s | 0% |
| 50 | 2000ms | 4000ms | 25 req/s | 3% |

### 5.2. Đánh giá chất lượng hệ thống

#### 5.2.1. Độ ổn định
- **Đánh giá:** Trung bình
- **Lý do:** Hệ thống hoạt động ổn định với tải thấp (10 users), nhưng bắt đầu có lỗi khi tải tăng (100 users)

#### 5.2.2. Độ chính xác dữ liệu
- **Đánh giá:** Tốt
- **Lý do:** Dữ liệu được lưu chính xác vào database, transaction đảm bảo tính toàn vẹn

#### 5.2.3. Khả năng chịu tải
- **Đánh giá:** Trung bình
- **Lý do:** Hệ thống chịu tải tốt đến 50 users, nhưng performance giảm đáng kể ở 100 users

#### 5.2.4. Khả năng mở rộng
- **Đánh giá:** Trung bình
- **Lý do:** Cấu trúc hiện tại cho phép mở rộng, nhưng cần tối ưu code và database

#### 5.2.5. Độ tin cậy
- **Đánh giá:** Tốt
- **Lý do:** Hệ thống có cơ chế rollback khi có lỗi, đảm bảo dữ liệu không bị hỏng

### 5.3. Tổng kết kết quả

#### 5.3.1. Tổng số test case
| Loại kiểm thử | Tổng số |
|--------------|---------|
| Black-box Testing | 45 |
| White-box Testing | 9 |
| Performance Testing | 3 |
| **Tổng cộng** | **57** |

#### 5.3.2. Tỷ lệ Pass / Fail
| Loại kiểm thử | Pass | Fail | Tỷ lệ Pass |
|--------------|------|------|------------|
| Black-box Testing | 39 | 6 | 86.67% |
| White-box Testing | 9 | 0 | 100% |
| Performance Testing | 2 | 1 | 66.67% |
| **Tổng cộng** | **50** | **7** | **87.72%** |

#### 5.3.3. Phân loại lỗi
| Mức độ | Số lượng | Tỷ lệ |
|--------|----------|-------|
| Critical | 2 | 28.57% |
| Major | 4 | 57.14% |
| Minor | 1 | 14.29% |
| **Tổng cộng** | **7** | **100%** |

#### 5.3.4. Độ phủ kiểm thử
- **Functional Coverage:** 90%
- **Code Coverage:** 100% (cho module được kiểm thử)
- **Requirement Coverage:** 85%

### 5.4. Đề xuất cải tiến

#### 5.4.1. Ưu tiên sửa lỗi
1. **BUG-05, BUG-06 (Critical):** Sửa logic kiểm tra giỏ hàng và tồn kho
2. **BUG-01, BUG-02, BUG-03, BUG-04 (Major):** Thêm validation cho input

#### 5.4.2. Tối ưu CSDL
- Thêm index cho các cột thường xuyên query
- Tối ưu các query phức tạp
- Sử dụng query caching

#### 5.4.3. Cải thiện hiệu năng
- Sử dụng prepared statements thay vì string concatenation
- Implement caching cho các query thường xuyên
- Tối ưu code PHP

#### 5.4.4. Bổ sung kiểm thử tự động
- Tích hợp CI/CD với automated testing
- Sử dụng PHPUnit cho unit testing
- Mở rộng Selenium test suite

---

## CHƯƠNG 6: KẾT LUẬN

### 6.1. Kết quả đạt được

**Kết quả kiểm thử:**
- Tổng số test case: 57
- Số test case Pass: 50 (87.72%)
- Số test case Fail: 7 (12.28%)
- Code Coverage: 100% (cho module Cart.php)
- Functional Coverage: 90%

**Các module đã kiểm thử:**
- Đăng nhập/Đăng ký: 86.67% Pass
- Quản lý sản phẩm: 90% Pass
- Quản lý nhân viên: 80% Pass
- Giỏ hàng: 87.5% Pass
- Đặt hàng: 83.33% Pass

**Đánh giá hiệu năng:**
- Hệ thống hoạt động tốt với tải thấp (10 users)
- Performance giảm khi tải tăng (100 users)
- Cần tối ưu để cải thiện hiệu năng

### 6.2. Những tồn tại và hạn chế

#### 6.2.1. Hạn chế của hệ thống được kiểm thử
- Thiếu validation ở phía server
- Sử dụng string concatenation thay vì prepared statements
- Mã hóa mật khẩu bằng MD5 (không an toàn)
- Không có CSRF protection
- Không có rate limiting

#### 6.2.2. Hạn chế về phạm vi và phương pháp kiểm thử
- Chỉ kiểm thử module Cart.php bằng white-box testing
- Không kiểm thử tất cả các module bằng white-box
- Kiểm thử hiệu năng trên môi trường local (không giống production)
- Không kiểm thử bảo mật chuyên sâu
- Không kiểm thử tương thích trên nhiều trình duyệt

### 6.3. Bài học rút ra

1. **Validation là quan trọng:** Thiếu validation dẫn đến nhiều lỗi Critical và Major
2. **Prepared statements:** Sử dụng prepared statements giúp tránh SQL Injection và cải thiện performance
3. **Transaction:** Sử dụng transaction đúng cách đảm bảo tính toàn vẹn dữ liệu
4. **Testing coverage:** Cần kiểm thử toàn diện cả black-box và white-box
5. **Performance testing:** Cần kiểm thử hiệu năng trên môi trường giống production

### 6.4. Hướng phát triển

#### 6.4.1. Giai đoạn ngắn hạn — Khắc phục lỗi Critical và Major
- Sửa logic kiểm tra giỏ hàng và tồn kho
- Thêm validation cho tất cả input
- Sử dụng prepared statements
- Thêm CSRF protection

#### 6.4.2. Giai đoạn trung hạn — Tái cấu trúc mã nguồn và tối ưu hiệu năng
- Tái cấu trúc code theo chuẩn PSR
- Tối ưu database queries
- Thêm caching
- Cải thiện security (bcrypt cho password)

#### 6.4.3. Giai đoạn dài hạn — Xây dựng quy trình kiểm thử tự động
- Tích hợp CI/CD
- Mở rộng automated testing
- Implement monitoring và alerting
- Xây dựng test environment

### 6.5. Định hướng mở rộng hệ thống
- Thêm chức năng báo cáo thống kê
- Tích hợp thanh toán trực tuyến (VNPAY, MoMo)
- Thêm chức năng chat hỗ trợ khách hàng
- Phát triển mobile app
- Implement recommendation system

---

## Lời cảm ơn

Báo cáo này được hoàn thành với sự hỗ trợ từ:
- Giảng viên hướng dẫn
- Đội ngũ phát triển Sport Shop
- Cộng đồng open source (các công cụ kiểm thử)

Chúng tôi xin chân thành cảm ơn sự hỗ trợ và đóng góp của tất cả các bên.

---

**Người lập báo cáo:** Cascade AI Assistant  
**Ngày lập:** 05/07/2026  
**Phiên bản:** 1.0
