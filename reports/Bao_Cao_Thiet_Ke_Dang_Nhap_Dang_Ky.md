# BÁO CÁO THIẾT KẾ PHẦN MỀM ĐĂNG NHẬP ĐĂNG KÝ

## 1. GIỚI THIỆU CHUNG

### 1.1 Mục đích
Báo cáo này mô tả chi tiết về thiết kế và triển khai hệ thống đăng nhập và đăng ký cho ứng dụng Sport Shop, bao gồm cả hệ thống dành cho khách hàng và quản trị viên.

### 1.2 Phạm vi
- Hệ thống đăng nhập/đăng ký cho khách hàng
- Hệ thống đăng nhập cho quản trị viên
- Quản lý thông tin người dùng
- Xác thực và phân quyền

## 2. KIẾN TRÚC HỆ THỐNG

### 2.1 Mô hình MVC
Hệ thống được xây dựng theo mô hình Model-View-Controller (MVC):

```
┌─────────────────┐
│     VIEW        │
│  (Giao diện)    │
└────────┬────────┘
         │
┌────────▼────────┐
│  CONTROLLER     │
│ (Xử lý logic)   │
└────────┬────────┘
         │
┌────────▼────────┐
│     MODEL       │
│  (Dữ liệu)      │
└────────┬────────┘
         │
┌────────▼────────┐
│   DATABASE      │
│  (MySQL)        │
└─────────────────┘
```

### 2.2 Cấu trúc thư mục
```
sport_shop/
├── controllers/
│   ├── LoginController.php (Khách hàng)
│   └── PageController.php
├── models/
│   ├── Login.php (Khách hàng)
│   └── Connection.php
├── views/
│   └── page/
│       └── login.php
├── admin/
│   ├── controllers/
│   │   └── LoginController.php (Quản trị)
│   ├── models/
│   │   └── Login.php (Quản trị)
│   └── views/
│       └── login/
│           └── login.php
└── database/
    └── sport_shops.sql
```

## 3. THIẾT KẾ CƠ SỞ DỮ LIỆU

### 3.1 Bảng customers (Khách hàng)
```sql
CREATE TABLE `customers` (
  `customerNumber` int(11) NOT NULL,
  `customerName` varchar(50) NOT NULL,
  `contactLastName` varchar(50) NOT NULL,
  `contactFirstName` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `addressLine1` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`customerNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Mô tả các trường:**
- `customerNumber`: Mã khách hàng (Khóa chính)
- `customerName`: Tên đầy đủ khách hàng
- `contactLastName`: Họ
- `contactFirstName`: Tên
- `phone`: Số điện thoại
- `addressLine1`: Địa chỉ
- `city`: Thành phố
- `country`: Quốc gia
- `password`: Mật khẩu (đã mã hóa MD5)
- `email`: Email (dùng để đăng nhập)

### 3.2 Bảng employees (Nhân viên/Quản trị)
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

**Mô tả các trường:**
- `employeeNumber`: Mã nhân viên (Khóa chính)
- `lastName`: Họ
- `firstName`: Tên
- `email`: Email (dùng để đăng nhập)
- `jobTitle`: Chức vụ
- `password`: Mật khẩu (đã mã hóa MD5)
- `level`: Cấp độ (0: Nhân viên, 1: Quản trị)
- `age`: Tuổi
- `startDate`: Ngày bắt đầu làm việc
- `salary`: Lương

## 4. THIẾT KẾ CHỨC NĂNG

### 4.1 Chức năng Đăng nhập (Login)

#### 4.1.1 Đăng nhập khách hàng
**File:** `controllers/LoginController.php`
**Method:** `login_action()`

**Quy trình:**
1. Nhận email và mật khẩu từ form (POST method)
2. Validate dữ liệu đầu vào
3. Mã hóa mật khẩu bằng MD5
4. Tìm kiếm user trong database
5. Nếu tìm thấy:
   - Tạo session `isLogin = true`
   - Lưu thông tin user vào session `customer`
   - Chuyển hướng về trang chủ
6. Nếu không tìm thấy:
   - Hiển thị thông báo lỗi
   - Giữ lại trang đăng nhập

**Code:**
```php
public function login_action() {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $this->redirectWithMessage('?mod=login&act=login', 'Vui lòng nhập đầy đủ thông tin');
        return;
    }
    
    $user = $this->login_model->find($email, md5($password));
    
    if ($user) {
        $_SESSION['isLogin'] = true;
        $_SESSION['customer'] = $user;
        $this->redirectWithMessage('?mod=page&act=home', 'Đăng nhập thành công');
    } else {
        $this->redirectWithMessage('?mod=login&act=login', 'Email hoặc mật khẩu không đúng');
    }
}
```

#### 4.1.2 Đăng nhập quản trị viên
**File:** `admin/controllers/LoginController.php`
**Method:** `login_action()`

**Quy trình:**
1. Nhận email và mật khẩu từ form
2. Mã hóa mật khẩu bằng MD5
3. Tìm kiếm trong bảng employees
4. Nếu tìm thấy:
   - Tạo session `isLogin = true`
   - Lưu thông tin admin vào session `admin`
   - Chuyển hướng đến dashboard
5. Nếu không tìm thấy:
   - Hiển thị thông báo lỗi

### 4.2 Chức năng Đăng ký (Register)

#### 4.2.1 Đăng ký khách hàng mới
**File:** `controllers/LoginController.php`
**Method:** `store()`

**Quy trình:**
1. Lấy dữ liệu từ form đăng ký
2. Tạo customerNumber mới (MAX + 1)
3. Validate dữ liệu:
   - Kiểm tra các trường bắt buộc
   - Validate định dạng email
   - Validate độ dài mật khẩu (tối thiểu 6 ký tự)
   - Validate định dạng số điện thoại (10-11 số)
4. Kiểm tra email đã tồn tại chưa
5. Kiểm tra số điện thoại đã tồn tại chưa
6. Mã hóa mật khẩu bằng MD5
7. Lưu vào database
8. Tự động đăng nhập sau khi đăng ký thành công

**Validation Rules:**
```php
- Tên: Không được rỗng
- Họ: Không được rỗng
- Email: Không được rỗng, định dạng hợp lệ, chưa tồn tại
- Mật khẩu: Không được rỗng, tối thiểu 6 ký tự
- Số điện thoại: Không được rỗng, định dạng số (10-11 số), chưa tồn tại
- Địa chỉ: Không được rỗng
- Thành phố: Không được rỗng
```

### 4.3 Chức năng Đăng xuất (Logout)

#### 4.3.1 Đăng xuất khách hàng
**File:** `controllers/LoginController.php`
**Method:** `logout()`

**Quy trình:**
1. Hủy tất cả session variables
2. Hủy session
3. Chuyển hướng về trang chủ

#### 4.3.2 Đăng xuất quản trị viên
**File:** `admin/controllers/LoginController.php`
**Method:** `logout()`

**Quy trình:**
1. Khởi động session
2. Hủy session
3. Chuyển hướng về trang đăng nhập

### 4.4 Chức năng Cập nhật thông tin
**File:** `controllers/LoginController.php`
**Method:** `edit()`

**Quy trình:**
1. Kiểm tra user đã đăng nhập chưa
2. Nhận dữ liệu từ form
3. Cập nhật thông tin trong database
4. Cập nhật session với thông tin mới

## 5. THIẾT KẾ GIAO DIỆN

### 5.1 Trang Đăng nhập/Đăng ký
**File:** `views/page/login.php`

**Layout:**
- Hai cột song song:
  - Cột trái: Form đăng nhập cho khách hàng đã có tài khoản
  - Cột phải: Form đăng ký cho khách hàng mới

**Các thành phần:**
- Header với navigation
- Title section với breadcrumb
- Login form:
  - Input email (required)
  - Input password (required)
  - Link "Quên mật khẩu?"
  - Button "ĐĂNG NHẬP"
  - Link đến trang đăng nhập quản trị
- Register form:
  - Input firstName
  - Input lastName
  - Input email (required)
  - Input phone
  - Input password (required)
  - Input addressLine1
  - Input city
  - Input country
  - Button "ĐĂNG KÝ"
- Footer

**JavaScript validation:**
```javascript
function checkAndSubmit() {
    var email = document.querySelector('input[name="email"]').value;
    var phone = document.querySelector('input[name="phone"]').value;
    
    // Kiểm tra email và phone có trùng nhau không
    if (email && phone && email === phone) {
        alert('Email và số điện thoại không được trùng nhau!');
        return false;
    }
    
    document.getElementById('registerForm').submit();
    return true;
}
```

## 6. AN NINH VÀ BẢO MẬT

### 6.1 Các biện pháp bảo mật hiện tại

#### 6.1.1 Mã hóa mật khẩu
- Sử dụng hàm MD5 để mã hóa mật khẩu
- Mật khẩu được mã hóa trước khi lưu vào database
- Mật khẩu được mã hóa trước khi so sánh khi đăng nhập

**Vấn đề:** MD5 không còn được khuyến nghị cho mục đích bảo mật vì dễ bị tấn công bằng rainbow table.

#### 6.1.2 SQL Injection Prevention
- Sử dụng `real_escape_string()` để escape các ký tự đặc biệt
- Sử dụng Prepared Statements trong phương thức register()

**Code example:**
```php
// Sử dụng real_escape_string
$email = $this->connection->real_escape_string($email);
$password = $this->connection->real_escape_string($password);

// Sử dụng prepared statement
$stmt = $this->connection->prepare($sql);
$stmt->bind_param("isssssssss", ...);
$stmt->execute();
```

#### 6.1.3 Session Management
- Sử dụng PHP Session để quản lý trạng thái đăng nhập
- Session variables: `isLogin`, `customer`, `admin`
- Hủy session khi đăng xuất

#### 6.1.4 Input Validation
- Validate email format sử dụng `FILTER_VALIDATE_EMAIL`
- Validate độ dài mật khẩu
- Validate định dạng số điện thoại với regex
- Trim whitespace từ input

### 6.2 Các lỗ hổng bảo mật cần cải thiện

#### 6.2.1 Mã hóa mật khẩu yếu
**Vấn đề:** MD5 không an toàn
**Khuyến nghị:** Sử dụng bcrypt hoặc Argon2

```php
// Thay vì:
$password = md5($password);

// Nên dùng:
$password = password_hash($password, PASSWORD_BCRYPT);
// Và khi kiểm tra:
password_verify($input_password, $stored_password);
```

#### 6.2.2 Không có CSRF Protection
**Vấn đề:** Không có token CSRF để bảo vệ against Cross-Site Request Forgery
**Khuyến nghị:** Thêm CSRF token vào các form

#### 6.2.3 Không có Rate Limiting
**Vấn đề:** Không giới hạn số lần đăng nhập thất bại
**Khuyến nghị:** Thêm rate limiting để prevent brute force attacks

#### 6.2.4 Không có Password Recovery
**Vấn đề:** Chỉ có link "Quên mật khẩu?" nhưng không có chức năng thực tế
**Khuyến nghị:** Triển khai chức năng reset mật khẩu qua email

#### 6.2.5 Session không an toàn
**Vấn đề:** Không có session timeout, không có secure cookie settings
**Khuyến nghị:** 
- Thêm session timeout
- Sử dụng secure cookies (HTTPS only)
- Implement session regeneration

## 7. FLOWCHART

### 7.1 Flowchart Đăng nhập Khách hàng
```
┌──────────────┐
│ User mở trang │
│   login.php   │
└──────┬───────┘
       │
┌──────▼───────┐
│ Nhập email   │
│ và password  │
└──────┬───────┘
       │
┌──────▼───────┐
│ Click Đăng   │
│   Nhập       │
└──────┬───────┘
       │
┌──────▼───────┐
│ Validate     │
│  input       │
└──────┬───────┘
       │
   ┌───┴───┐
   │ Valid?│
   └───┬───┘
       │
  ┌────┴────┐
  │ No       │ Yes
  ▼          ▼
┌─────┐  ┌────────────┐
│ Show │  │ Hash password│
│ Error│  │   (MD5)     │
└─────┘  └──────┬─────┘
               │
        ┌──────▼──────┐
        │ Query user  │
        │ in database │
        └──────┬──────┘
               │
          ┌────┴────┐
          │ Found?  │
          └────┬────┘
               │
          ┌────┴────┐
          │ No      │ Yes
          ▼         ▼
       ┌─────┐  ┌──────────┐
       │Show │  │ Create    │
       │Error│  │ Session   │
       └─────┘  └─────┬────┘
                      │
               ┌──────▼──────┐
               │ Redirect to │
               │   Home      │
               └─────────────┘
```

### 7.2 Flowchart Đăng ký Khách hàng
```
┌──────────────┐
│ User mở trang │
│   login.php   │
└──────┬───────┘
       │
┌──────▼───────┐
│ Nhập thông   │
│  tin đăng ký │
└──────┬───────┘
       │
┌──────▼───────┐
│ Click Đăng   │
│   Ký         │
└──────┬───────┘
       │
┌──────▼───────┐
│ Validate     │
│  input       │
└──────┬───────┘
       │
   ┌───┴───┐
   │ Valid?│
   └───┬───┘
       │
  ┌────┴────┐
  │ No       │ Yes
  ▼          ▼
┌─────┐  ┌────────────┐
│ Show │  │ Check email │
│ Error│  │ exists?    │
└─────┘  └──────┬─────┘
               │
          ┌────┴────┐
          │ Yes     │ No
          ▼         ▼
       ┌─────┐  ┌────────────┐
       │Show │  │ Check phone │
       │Error│  │ exists?    │
       └─────┘  └──────┬─────┘
                      │
                 ┌────┴────┐
                 │ Yes     │ No
                 ▼         ▼
              ┌─────┐  ┌────────────┐
              │Show │  │ Hash password│
              │Error│  │   (MD5)     │
              └─────┘  └──────┬─────┘
                             │
                      ┌──────▼──────┐
                      │ Generate ID │
                      └──────┬──────┘
                             │
                      ┌──────▼──────┐
                      │ Insert to   │
                      │  database   │
                      └──────┬──────┘
                             │
                      ┌──────▼──────┐
                      │ Auto login  │
                      └──────┬──────┘
                             │
                      ┌──────▼──────┐
                      │ Redirect to │
                      │   Home      │
                      └─────────────┘
```

## 8. KẾT LUẬN VÀ KHUYẾN NGHỊ

### 8.1 Đánh giá hiện tại
Hệ thống đăng nhập/đăng ký hiện tại đã đáp ứng được các nhu cầu cơ bản:
- Cho phép khách hàng đăng ký tài khoản mới
- Cho phép đăng nhập với email và mật khẩu
- Phân tách rõ ràng giữa hệ thống khách hàng và quản trị
- Có validation cơ bản cho input
- Sử dụng prepared statements để prevent SQL injection

### 8.2 Các điểm cần cải thiện

#### Ưu tiên cao:
1. **Nâng cấp mã hóa mật khẩu:** Thay thế MD5 bằng bcrypt hoặc Argon2
2. **Thêm CSRF Protection:** Implement CSRF tokens cho tất cả forms
3. **Rate Limiting:** Giới hạn số lần đăng nhập thất bại
4. **Session Security:** Thêm session timeout và secure cookie settings

#### Ưu tiên trung bình:
5. **Password Recovery:** Triển khai chức năng reset mật khẩu qua email
6. **Email Verification:** Gửi email xác nhận khi đăng ký
7. **Two-Factor Authentication:** Thêm 2FA cho tài khoản admin
8. **Logging:** Ghi log các hoạt động đăng nhập/đăng ký

#### Ưu tiên thấp:
9. **Social Login:** Thêm đăng nhập qua Google, Facebook
10. **Remember Me:** Thêm chức năng "Ghi nhớ đăng nhập"
11. **Password Strength Meter:** Hiển thị độ mạnh mật khẩu khi đăng ký
12. **Account Lockout:** Khóa tài khoản sau nhiều lần đăng nhập thất bại

### 8.3 Kế hoạch triển khai
1. Ngắn hạn (1-2 tuần): Nâng cấp mã hóa mật khẩu và thêm CSRF protection
2. Trung hạn (1 tháng): Triển khai password recovery và rate limiting
3. Dài hạn (2-3 tháng): Thêm 2FA và social login

## 9. KIỂM THỬ PHẦN MỀM

### 9.1 Chiến lược kiểm thử

Hệ thống đăng nhập/đăng ký cần được kiểm thử toàn diện để đảm bảo:
- Chức năng hoạt động đúng theo yêu cầu
- Bảo mật được đảm bảo
- Trải nghiệm người dùng tốt
- Không có lỗi nghiêm trọng

### 9.2 Các loại kiểm thử

#### 9.2.1 Kiểm thử đơn vị (Unit Testing)
Kiểm thử từng thành phần riêng lẻ:

**Test Cases cho Model/Login.php:**
```php
// Test 1: Kiểm tra hàm find() với email và password đúng
public function testFindWithValidCredentials() {
    $login = new Login();
    $result = $login->find("test@example.com", md5("password123"));
    $this->assertIsArray($result);
    $this->assertArrayHasKey('customerNumber', $result);
}

// Test 2: Kiểm tra hàm find() với email sai
public function testFindWithInvalidEmail() {
    $login = new Login();
    $result = $login->find("wrong@example.com", md5("password123"));
    $this->assertFalse($result);
}

// Test 3: Kiểm tra hàm findByEmail()
public function testFindByEmail() {
    $login = new Login();
    $result = $login->findByEmail("test@example.com");
    $this->assertIsArray($result);
}

// Test 4: Kiểm tra hàm register() với dữ liệu hợp lệ
public function testRegisterWithValidData() {
    $login = new Login();
    $data = [
        'customerNumber' => 999,
        'customerName' => 'Test User',
        'contactFirstName' => 'Test',
        'contactLastName' => 'User',
        'email' => 'newuser@example.com',
        'password' => md5('password123'),
        'phone' => '0123456789',
        'addressLine1' => '123 Test Street',
        'city' => 'Ho Chi Minh',
        'country' => 'Vietnam'
    ];
    $result = $login->register($data);
    $this->assertTrue($result);
}

// Test 5: Kiểm tra hàm register() với email trùng
public function testRegisterWithDuplicateEmail() {
    $login = new Login();
    $data = [
        'customerNumber' => 1000,
        'customerName' => 'Test User 2',
        'contactFirstName' => 'Test',
        'contactLastName' => 'User',
        'email' => 'test@example.com', // Email đã tồn tại
        'password' => md5('password123'),
        'phone' => '0987654321',
        'addressLine1' => '456 Test Street',
        'city' => 'Hanoi',
        'country' => 'Vietnam'
    ];
    $this->expectException(Exception::class);
    $login->register($data);
}
```

**Test Cases cho Controller/LoginController.php:**
```php
// Test 6: Kiểm tra login_action() với dữ liệu hợp lệ
public function testLoginActionWithValidData() {
    $_POST['email'] = 'test@example.com';
    $_POST['password'] = 'password123';
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    $controller = new LoginController();
    $controller->login_action();
    
    $this->assertTrue(isset($_SESSION['isLogin']));
    $this->assertTrue($_SESSION['isLogin']);
}

// Test 7: Kiểm tra login_action() với dữ liệu rỗng
public function testLoginActionWithEmptyData() {
    $_POST['email'] = '';
    $_POST['password'] = '';
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    $controller = new LoginController();
    $controller->login_action();
    
    $this->assertFalse(isset($_SESSION['isLogin']));
}

// Test 8: Kiểm tra validateRegistration() với email không hợp lệ
public function testValidateRegistrationWithInvalidEmail() {
    $controller = new LoginController();
    $data = [
        'contactFirstName' => 'Test',
        'contactLastName' => 'User',
        'email' => 'invalid-email',
        'password' => 'password123',
        'phone' => '0123456789',
        'addressLine1' => '123 Test Street',
        'city' => 'Ho Chi Minh'
    ];
    $result = $controller->validateRegistration($data);
    $this->assertEquals('Email không hợp lệ', $result);
}

// Test 9: Kiểm tra validateRegistration() với mật khẩu quá ngắn
public function testValidateRegistrationWithShortPassword() {
    $controller = new LoginController();
    $data = [
        'contactFirstName' => 'Test',
        'contactLastName' => 'User',
        'email' => 'test@example.com',
        'password' => '12345', // Chỉ 5 ký tự
        'phone' => '0123456789',
        'addressLine1' => '123 Test Street',
        'city' => 'Ho Chi Minh'
    ];
    $result = $controller->validateRegistration($data);
    $this->assertEquals('Mật khẩu phải có ít nhất 6 ký tự', $result);
}

// Test 10: Kiểm tra validateRegistration() với số điện thoại không hợp lệ
public function testValidateRegistrationWithInvalidPhone() {
    $controller = new LoginController();
    $data = [
        'contactFirstName' => 'Test',
        'contactLastName' => 'User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'phone' => 'abc123', // Không phải số
        'addressLine1' => '123 Test Street',
        'city' => 'Ho Chi Minh'
    ];
    $result = $controller->validateRegistration($data);
    $this->assertEquals('Số điện thoại phải là số và có độ dài từ 10-11 số', $result);
}
```

#### 9.2.2 Kiểm thử tích hợp (Integration Testing)
Kiểm thử sự tương tác giữa các thành phần:

**Test Cases tích hợp:**
```php
// Test 11: Kiểm thử quy trình đăng nhập hoàn chỉnh
public function testCompleteLoginFlow() {
    // Bước 1: User điền form đăng nhập
    $loginData = [
        'email' => 'test@example.com',
        'password' => 'password123'
    ];
    
    // Bước 2: Controller xử lý
    $controller = new LoginController();
    $_POST = $loginData;
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    // Bước 3: Model truy vấn database
    $model = new Login();
    $user = $model->find($loginData['email'], md5($loginData['password']));
    
    // Bước 4: Kiểm tra session được tạo
    $this->assertNotNull($user);
    $controller->login_action();
    $this->assertTrue(isset($_SESSION['isLogin']));
}

// Test 12: Kiểm thử quy trình đăng ký hoàn chỉnh
public function testCompleteRegistrationFlow() {
    // Bước 1: User điền form đăng ký
    $registerData = [
        'firstName' => 'Test',
        'lastName' => 'User',
        'email' => 'newuser@example.com',
        'password' => 'password123',
        'phone' => '0123456789',
        'addressLine1' => '123 Test Street',
        'city' => 'Ho Chi Minh',
        'country' => 'Vietnam'
    ];
    
    // Bước 2: Controller validate và xử lý
    $controller = new LoginController();
    $_POST = $registerData;
    $_SERVER['REQUEST_METHOD'] = 'POST';
    
    // Bước 3: Model lưu vào database
    $model = new Login();
    $maxId = $model->getMaxCustomerNumber();
    $newId = $maxId + 1;
    
    $data = [
        'customerNumber' => $newId,
        'customerName' => $registerData['lastName'] . ' ' . $registerData['firstName'],
        'contactFirstName' => $registerData['firstName'],
        'contactLastName' => $registerData['lastName'],
        'email' => $registerData['email'],
        'password' => md5($registerData['password']),
        'phone' => $registerData['phone'],
        'addressLine1' => $registerData['addressLine1'],
        'city' => $registerData['city'],
        'country' => $registerData['country']
    ];
    
    // Bước 4: Kiểm tra đăng ký thành công
    $result = $model->register($data);
    $this->assertTrue($result);
    
    // Bước 5: Kiểm tra user được tự động đăng nhập
    $newUser = $model->findByEmail($registerData['email']);
    $this->assertNotNull($newUser);
}
```

#### 9.2.3 Kiểm thử chấp nhận (Acceptance Testing)
Kiểm thử từ góc độ người dùng cuối:

**Test Cases chấp nhận:**

**TC-AT-01: Đăng nhập thành công**
- **Mô tả:** Người dùng đăng nhập với email và mật khẩu đúng
- **Điều kiện tiên quyết:** User đã có tài khoản
- **Bước thực hiện:**
  1. Mở trang đăng nhập
  2. Nhập email hợp lệ
  3. Nhập mật khẩu đúng
  4. Click "ĐĂNG NHẬP"
- **Kết quả mong đợi:** Đăng nhập thành công, chuyển hướng về trang chủ, session được tạo
- **Trạng thái:** Pass/Fail

**TC-AT-02: Đăng nhập thất bại với mật khẩu sai**
- **Mô tả:** Người dùng đăng nhập với mật khẩu sai
- **Điều kiện tiên quyết:** User đã có tài khoản
- **Bước thực hiện:**
  1. Mở trang đăng nhập
  2. Nhập email hợp lệ
  3. Nhập mật khẩu sai
  4. Click "ĐĂNG NHẬP"
- **Kết quả mong đợi:** Hiển thị thông báo "Email hoặc mật khẩu không đúng"
- **Trạng thái:** Pass/Fail

**TC-AT-03: Đăng ký tài khoản mới thành công**
- **Mô tả:** Người dùng đăng ký tài khoản mới với thông tin hợp lệ
- **Điều kiện tiên quyết:** Email và số điện thoại chưa được đăng ký
- **Bước thực hiện:**
  1. Mở trang đăng ký
  2. Nhập đầy đủ thông tin hợp lệ
  3. Click "ĐĂNG KÝ"
- **Kết quả mong đợi:** Đăng ký thành công, tự động đăng nhập, chuyển hướng về trang chủ
- **Trạng thái:** Pass/Fail

**TC-AT-04: Đăng ký với email đã tồn tại**
- **Mô tả:** Người dùng đăng ký với email đã được sử dụng
- **Điều kiện tiên quyết:** Email đã tồn tại trong database
- **Bước thực hiện:**
  1. Mở trang đăng ký
  2. Nhập thông tin với email đã tồn tại
  3. Click "ĐĂNG KÝ"
- **Kết quả mong đợi:** Hiển thị thông báo "Email đã được đăng ký"
- **Trạng thái:** Pass/Fail

**TC-AT-05: Đăng ký với mật khẩu quá ngắn**
- **Mô tả:** Người dùng đăng ký với mật khẩu ít hơn 6 ký tự
- **Điều kiện tiên quyết:** Không
- **Bước thực hiện:**
  1. Mở trang đăng ký
  2. Nhập thông tin với mật khẩu 5 ký tự
  3. Click "ĐĂNG KÝ"
- **Kết quả mong đợi:** Hiển thị thông báo "Mật khẩu phải có ít nhất 6 ký tự"
- **Trạng thái:** Pass/Fail

**TC-AT-06: Đăng xuất thành công**
- **Mô tả:** Người dùng đã đăng nhập thực hiện đăng xuất
- **Điều kiện tiên quyết:** User đã đăng nhập
- **Bước thực hiện:**
  1. Click link/đăng xuất
- **Kết quả mong đợi:** Session bị hủy, chuyển hướng về trang chủ
- **Trạng thái:** Pass/Fail

#### 9.2.4 Kiểm thử bảo mật (Security Testing)

**Test Cases bảo mật:**

**TC-SEC-01: SQL Injection Attack**
- **Mô tả:** Thử inject SQL vào form đăng nhập
- **Input:** `' OR '1'='1`
- **Kết quả mong đợi:** Login thất bại, không bị tấn công SQL injection
- **Trạng thái:** Pass/Fail

**TC-SEC-02: XSS Attack**
- **Mô tả:** Thử inject JavaScript vào các trường input
- **Input:** `<script>alert('XSS')</script>`
- **Kết quả mong đợi:** Script không được thực thi, dữ liệu được escape
- **Trạng thái:** Pass/Fail

**TC-SEC-03: Brute Force Attack**
- **Mô tả:** Thử đăng nhập nhiều lần với mật khẩu sai
- **Kết quả mong đợi:** Sau N lần thất bại, tài khoản bị khóa tạm thời
- **Trạng thái:** Pass/Fail (Chưa triển khai)

**TC-SEC-04: Session Hijacking**
- **Mô tả:** Thử sử dụng session ID của user khác
- **Kết quả mong đợi:** Session không hợp lệ, buộc đăng nhập lại
- **Trạng thái:** Pass/Fail

**TC-SEC-05: Password Hashing**
- **Mô tả:** Kiểm tra mật khẩu trong database
- **Kết quả mong đợi:** Mật khẩu được mã hóa, không lưu plain text
- **Trạng thái:** Pass/Fail

### 9.3 Công cụ kiểm thử

#### 9.3.1 PHPUnit
Framework kiểm thử đơn vị cho PHP:

```bash
# Cài đặt PHPUnit
composer require --dev phpunit/phpunit

# Chạy kiểm thử
./vendor/bin/phpunit tests/
```

**Cấu trúc thư mục kiểm thử:**
```
tests/
├── unit/
│   ├── Model/
│   │   └── LoginTest.php
│   └── Controller/
│       └── LoginControllerTest.php
├── integration/
│   └── LoginFlowTest.php
└── acceptance/
    └── LoginAcceptanceTest.php
```

#### 9.3.2 Selenium WebDriver
Kiểm thử giao diện và chấp nhận:

```php
// Ví dụ test với Selenium
public function testLoginWithSelenium() {
    $this->driver->get("http://localhost/sport_shop/?mod=login&act=login");
    
    $emailInput = $this->driver->findElement(WebDriverBy::name('email'));
    $passwordInput = $this->driver->findElement(WebDriverBy::name('password'));
    $loginButton = $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
    
    $emailInput->sendKeys('test@example.com');
    $passwordInput->sendKeys('password123');
    $loginButton->click();
    
    $this->assertStringContainsString('home', $this->driver->getCurrentURL());
}
```

#### 9.3.3 Postman
Kiểm thử API:

**Test Collection:**
- Login API Test
- Register API Test
- Logout API Test
- Update Profile API Test

### 9.4 Kế hoạch kiểm thử

#### 9.4.1 Kế hoạch kiểm thử đơn vị
| Thành phần | Số test case | Trạng thái | Ngày hoàn thành |
|------------|-------------|------------|-----------------|
| Model/Login.php | 5 | Chưa thực hiện | - |
| Controller/LoginController.php | 5 | Chưa thực hiện | - |
| Model/Connection.php | 2 | Chưa thực hiện | - |

#### 9.4.2 Kế hoạch kiểm thử tích hợp
| Chức năng | Số test case | Trạng thái | Ngày hoàn thành |
|-----------|-------------|------------|-----------------|
| Login Flow | 3 | Chưa thực hiện | - |
| Register Flow | 3 | Chưa thực hiện | - |
| Update Profile | 2 | Chưa thực hiện | - |

#### 9.4.3 Kế hoạch kiểm thử chấp nhận
| Kịch bản | Số test case | Trạng thái | Ngày hoàn thành |
|----------|-------------|------------|-----------------|
| Đăng nhập | 3 | Chưa thực hiện | - |
| Đăng ký | 5 | Chưa thực hiện | - |
| Đăng xuất | 1 | Chưa thực hiện | - |

#### 9.4.4 Kế hoạch kiểm thử bảo mật
| Loại tấn công | Số test case | Trạng thái | Ngày hoàn thành |
|--------------|-------------|------------|-----------------|
| SQL Injection | 3 | Chưa thực hiện | - |
| XSS | 2 | Chưa thực hiện | - |
| Brute Force | 2 | Chưa thực hiện | - |
| Session Hijacking | 2 | Chưa thực hiện | - |

### 9.5 Kết quả kiểm thử dự kiến

#### 9.5.1 Metric kiểm thử
- **Coverage code:** Target > 80%
- **Số test case tổng cộng:** 35+
- **Thời gian thực hiện:** 2-3 tuần
- **Bug dự kiến phát hiện:** 5-10

#### 9.5.2 Các vấn đề dự kiến
1. **Mã hóa mật khẩu yếu:** MD5 cần được thay thế
2. **Thiếu rate limiting:** Dễ bị brute force attack
3. **Thiếu CSRF protection:** Dễ bị CSRF attack
4. **Validation chưa đủ mạnh:** Cần thêm validation rules
5. **Error handling chưa tốt:** Cần cải thiện thông báo lỗi

### 9.6 Báo cáo kiểm thử

Sau khi thực hiện kiểm thử, báo cáo sẽ bao gồm:
- Tổng quan kết quả kiểm thử
- Chi tiết từng test case
- Số lượng bug phát hiện
- Độ nghiêm trọng của bug
- Khuyến nghị sửa lỗi
- Tiến độ hoàn thành

---

## 10. TÀI LIỆU THAM KHẢO

- PHP Manual: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- OWASP Security Guidelines: https://owasp.org/
- MVC Pattern: https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller

---
**Người lập báo cáo:** Cascade AI Assistant  
**Ngày lập:** 22/06/2026  
**Phiên bản:** 1.0
