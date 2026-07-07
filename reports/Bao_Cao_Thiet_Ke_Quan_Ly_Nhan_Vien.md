# BÁO CÁO THIẾT KẾ CHỨC NĂNG QUẢN LÝ NHÂN VIÊN

## 1. GIỚI THIỆU CHUNG

### 1.1 Mục đích
Báo cáo này mô tả chi tiết về thiết kế và triển khai chức năng quản lý nhân viên cho hệ thống Sport Shop, cho phép quản trị viên thực hiện các thao tác CRUD (Create, Read, Update, Delete) trên thông tin nhân viên.

### 1.2 Phạm vi
- Quản lý danh sách nhân viên
- Thêm nhân viên mới
- Cập nhật thông tin nhân viên
- Xóa nhân viên
- Xem chi tiết nhân viên
- Quản lý phân quyền (Employee/Manager)

## 2. KIẾN TRÚC HỆ THỐNG

### 2.1 Mô hình MVC
Chức năng quản lý nhân viên được xây dựng theo mô hình Model-View-Controller (MVC):

```
┌─────────────────┐
│     VIEW        │
│  (Giao diện)    │
│  - employee_list│
│  - employee_add │
│  - employee_update│
│  - employee_detail│
└────────┬────────┘
         │
┌────────▼────────┐
│  CONTROLLER     │
│ (Xử lý logic)   │
│ EmployeeController│
└────────┬────────┘
         │
┌────────▼────────┐
│     MODEL       │
│  (Dữ liệu)      │
│  - Employee     │
│  - Model (base) │
└────────┬────────┘
         │
┌────────▼────────┐
│   DATABASE      │
│  - employees    │
└─────────────────┘
```

### 2.2 Cấu trúc thư mục
```
sport_shop/admin/
├── controllers/
│   └── EmployeeController.php
├── models/
│   ├── Employee.php
│   └── Model.php (base class)
├── views/
│   └── employee/
│       ├── employee_list.php
│       ├── employee_add.php
│       ├── employee_update.php
│       └── employee_detail.php
└── database/
    └── sport_shops.sql
```

## 3. THIẾT KẾ CƠ SỞ DỮ LIỆU

### 3.1 Bảng employees (Nhân viên)
```sql
CREATE TABLE `employees` (
  `employeeNumber` int(11) NOT NULL,
  `lastName` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `firstName` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
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
- `employeeNumber`: Mã nhân viên (Khóa chính, int 11)
- `lastName`: Họ nhân viên (varchar 50)
- `firstName`: Tên nhân viên (varchar 50)
- `email`: Email đăng nhập và liên hệ (varchar 100)
- `jobTitle`: Chức vụ (varchar 50)
- `password`: Mật khẩu đăng nhập (varchar 255, đã mã hóa MD5)
- `level`: Cấp độ quyền (int: 0 = Employee, 1 = Manager)
- `age`: Tuổi (int 11)
- `startDate`: Ngày bắt đầu làm việc (date)
- `salary`: Lương (decimal 10,2)

## 4. THIẾT KẾ CHỨC NĂNG

### 4.1 Chức năng Danh sách nhân viên (List)

#### 4.1.1 Controller
**File:** `admin/controllers/EmployeeController.php`
**Method:** `list()`

**Quy trình:**
1. Gọi model để lấy tất cả nhân viên
2. Truyền dữ liệu sang view
3. Hiển thị danh sách nhân viên

**Code:**
```php
public function list(){
    $data = array();
    $data = $this->cate_model->All();
    require_once('views/employee/employee_list.php');
}
```

#### 4.1.2 Model
**File:** `admin/models/Employee.php`
**Method:** `All()` (kế thừa từ Model base class)

**Quy trình:**
1. Thực hiện truy vấn SELECT từ bảng employees
2. Fetch tất cả rows
3. Trả về array của nhân viên

#### 4.1.3 View
**File:** `admin/views/employee/employee_list.php`

**Các thành phần:**
- Sidebar navigation
- Header với user info
- Main content area:
  - Page heading: "Quản lý nhân viên"
  - Nút "Add"
  - Alert message (cookie-based)
  - Card chứa table responsive với DataTables
  - Table với các cột:
    - Name (lastName)
    - Email
    - Job (jobTitle)
    - Age
    - Start date (startDate)
    - Salary
    - Action

**Các nút chức năng:**
- **Detail:** Xem chi tiết nhân viên
- **Update:** Cập nhật thông tin nhân viên
- **Delete:** Xóa nhân viên với confirm dialog

### 4.2 Chức năng Thêm nhân viên (Create)

#### 4.2.1 Controller
**File:** `admin/controllers/EmployeeController.php`
**Methods:** `add()`, `store()`

**Method add():**
```php
public function add(){
    require_once('views/employee/employee_add.php');		
}
```

**Method store():**
```php
public function store(){
    $data = array();
    $data['employeeNumber'] = $_POST['id'];
    $data['lastName'] = $_POST['lastName'];
    $data['firstName'] = $_POST['firstName'];
    $data['email'] = $_POST['email'];
    $data['password'] = md5($_POST['password']);
    $data['jobTitle'] = $_POST['position'];
    $data['startDate'] = $_POST['startDate'];
    $data['age'] = $_POST['age'];
    $data['salary'] = $_POST['salary'];
    $data['level'] = $_POST['level'];

    // Kiểm tra employeeNumber trùng lặp
    if ($this->cate_model->checkEmployeeNumberExists($data['employeeNumber'])) {
        setcookie('msg','Mã nhân viên đã tồn tại trong hệ thống!',time()+2);
        header('Location: ?mod=employee&act=add');
        exit;
    }

    // Kiểm tra email trùng lặp
    if ($this->cate_model->checkEmailExists($data['email'])) {
        setcookie('msg','Email đã tồn tại trong hệ thống!',time()+2);
        header('Location: ?mod=employee&act=add');
        exit;
    }

    $status = $this->cate_model->create($data);

    if($status == true){
        setcookie('msg','Thêm mới thành công',time()+1);
        header('Location: ?mod=employee');
    }
    else {
        setcookie('msg','Thêm mới không thành công',time()+1);
        header('Location: ?mod=employee&act=add');
    }
}
```

**Validation:**
- Kiểm tra employeeNumber trùng lặp
- Kiểm tra email trùng lặp
- Mã hóa mật khẩu bằng MD5
- Debug logging với error_log()

#### 4.2.2 Model
**File:** `admin/models/Employee.php`
**Methods:** `create($data)`, `checkEmployeeNumberExists()`, `checkEmailExists()`

**Method create():**
```php
function create($data){
    $f = ""; // Lưu tên các cột
    $v = "";// Lưu giá trị tương ứng
    foreach ($data as $key => $value) {
        $f .= $key.",";
        $v .= "'".$value."',";
    }

    $f = trim($f,",");
    $v = trim($v,",");
    
    $query = "INSERT INTO ".$this->table."(".$f.") VALUES (".$v.");";
    
    // Debug: In ra câu SQL
    error_log("Câu SQL INSERT: " . $query);
    
    $result = $this->connection->query($query);
    
    // Debug: Kiểm tra lỗi SQL
    if (!$result) {
        error_log("Lỗi SQL: " . $this->connection->error);
    }
    
    return $result;
}
```

**Method checkEmployeeNumberExists():**
```php
function checkEmployeeNumberExists($employeeNumber){
    $query = "SELECT COUNT(*) as count FROM ".$this->table." WHERE employeeNumber = '".$employeeNumber."'";
    $result = $this->connection->query($query);
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}
```

**Method checkEmailExists():**
```php
function checkEmailExists($email){
    $query = "SELECT COUNT(*) as count FROM ".$this->table." WHERE email = '".$email."'";
    $result = $this->connection->query($query);
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}
```

**Vấn đề bảo mật:**
- Không sử dụng prepared statements
- Dễ bị SQL Injection
- Cần cải thiện bằng cách sử dụng parameterized queries

#### 4.2.3 View
**File:** `admin/views/employee/employee_add.php`

**Các thành phần:**
- Form với các trường:
  - Employee Number - text input (required)
  - Last Name - text input (required)
  - First Name - text input (required)
  - Email - text input (required)
  - Password - password input (required)
  - Job - text input (required)
  - Start_Date - datetime-local input (required)
  - Age - text input
  - Salary - text input (required)
  - Level - select dropdown (Employee/Manager)
- Nút "Create" và "Back"

### 4.3 Chức năng Cập nhật nhân viên (Update)

#### 4.3.1 Controller
**File:** `admin/controllers/EmployeeController.php`
**Methods:** `update()`, `edit()`

**Method update():**
```php
public function update(){
    $id = isset($_GET['id'])?$_GET['id']:0;
    $emp = $this->cate_model->find($id);
    require_once('views/employee/employee_update.php');		
}
```

**Method edit():**
```php
public function edit(){
    $data = array();
    $data['employeeNumber'] = $_POST['id'];
    $data['lastName'] = $_POST['lastName'];
    $data['firstName'] = $_POST['firstName'];
    $data['email'] = $_POST['email'];
    
    // Chỉ cập nhật password nếu người dùng nhập mật khẩu mới
    if(md5($_POST['password']) != 'd41d8cd98f00b204e9800998ecf8427e') {
        $data['password'] = md5($_POST['password']);
    }
    
    $data['jobTitle'] = $_POST['position'];
    $data['startDate'] = $_POST['startDate'];
    $data['age'] = $_POST['age'];
    $data['salary'] = $_POST['salary'];

    $status = $this->cate_model->edit($data);

    if($status == true){
        setcookie('msg','Cập nhật thành công',time()+1);
        header('Location: ?mod=employee');
    }
    else {
        setcookie('msg','Cập nhật không thành công',time()+1);
        header('Location: ?mod=employee&act=update');
    }
}
```

**Lưu ý đặc biệt:**
- Password chỉ được cập nhật khi người dùng nhập mật khẩu mới
- MD5 hash của chuỗi rỗng là 'd41d8cd98f00b204e9800998ecf8427e'
- Nếu password field rỗng, không cập nhật password

#### 4.3.2 Model
**File:** `admin/models/Employee.php`
**Methods:** `find($id)`, `edit($data)`

**Method find():**
```php
function find($id){
    $query = "SELECT * FROM ".$this->table." WHERE employeeNumber = ".$id;
    return $data = $this->connection->query($query)->fetch_assoc();
}
```

**Method edit():**
```php
function edit($data){
    $v = "";
    foreach ($data as $key => $value) {
        $v .= $key."='".$value."',";
    }
    $v = trim($v,",");
    
    $query = "UPDATE ".$this->table." SET ".$v." WHERE employeeNumber =".$data['employeeNumber'];
    return $this->connection->query($query);
}
```

**Vấn đề bảo mật:**
- Không sử dụng prepared statements
- Dễ bị SQL Injection
- Cần cải thiện

#### 4.3.3 View
**File:** `admin/views/employee/employee_update.php`

**Các thành phần:**
- Form với các trường (pre-filled với dữ liệu hiện tại):
  - Employee Number - hidden input
  - Last Name - text input (required)
  - First Name - text input (required)
  - Email - text input (required)
  - Password - password input (không required, placeholder "*****")
  - Position - text input (required)
  - Start_Date - text input (required)
  - Age - text input
  - Salary - number input (required)
- Nút "Update" và "Back"

### 4.4 Chức năng Xóa nhân viên (Delete)

#### 4.4.1 Controller
**File:** `admin/controllers/EmployeeController.php`
**Method:** `delete()`

**Code:**
```php
public function delete(){
    $id = isset($_GET['id'])?$_GET['id']:0;
    
    $status = $this->cate_model->delete($id);
    if($status == true){
        setcookie('msg','Xóa thành công',time()+1);
    }
    else {
        setcookie('msg','Xóa không thành công',time()+1);
    }
    header('Location: ?mod=employee');
}
```

#### 4.4.2 Model
**File:** `admin/models/Employee.php`
**Method:** `delete($id)`

**Code:**
```php
function delete($id){
    $query = "DELETE FROM ".$this->table." WHERE employeeNumber = ".$id;
    return $this->connection->query($query);
}
```

**Vấn đề:**
- Không kiểm tra ràng buộc khóa ngoại
- Có thể gây lỗi nếu nhân viên có trong đơn hàng hoặc dữ liệu liên quan
- Cần thêm soft delete hoặc kiểm tra ràng buộc

#### 4.4.3 View
Xóa được thực hiện trực tiếp từ danh sách với JavaScript confirm:
```javascript
onclick="return confirm('Bạn chắc chắn muốn xóa?');"
```

### 4.5 Chức năng Xem chi tiết nhân viên (Detail)

#### 4.5.1 Controller
**File:** `admin/controllers/EmployeeController.php`
**Method:** `detail()`

**Code:**
```php
public function detail(){
    $id = isset($_GET['id'])?$_GET['id']:0;
    $emp = $this->cate_model->find($id);
    require_once('views/employee/employee_detail.php');
}
```

#### 4.5.2 View
**File:** `admin/views/employee/employee_detail.php`

**Các thành phần:**
- Table hiển thị thông tin nhân viên:
  - Name (lastName)
  - Email
  - Position (jobTitle)
  - Age
  - Start_Date (startDate)
  - Salary (formatted with number_format)
- Nút "Back" để quay về danh sách

## 5. THIẾT KẾ GIAO DIỆN

### 5.1 Trang danh sách nhân viên
**Layout:**
- Sidebar navigation
- Header với user info
- Main content area:
  - Page heading: "Quản lý nhân viên"
  - Nút "Add"
  - Alert message (cookie-based)
  - Card chứa table responsive
  - DataTables plugin cho table
  - Table với các cột: Name, Email, Job, Age, Start date, Salary, Action

**Styling:**
- Bootstrap 4 framework
- DataTables plugin
- Responsive design
- Hover effects trên rows

### 5.2 Trang thêm nhân viên
**Layout:**
- Sidebar navigation
- Header với user info
- Main content area:
  - Page heading: "Add New Employee"
  - Alert message (nếu có)
  - Form với Bootstrap form groups

**Form fields:**
- Employee Number: Text input (required)
- Last Name: Text input (required)
- First Name: Text input (required)
- Email: Text input (required)
- Password: Password input (required)
- Job: Text input (required)
- Start_Date: datetime-local input (required)
- Age: Text input
- Salary: Text input (required)
- Level: Select dropdown (Employee/Manager)

### 5.3 Trang cập nhật nhân viên
**Layout:** Tương tự trang thêm nhân viên
**Khác biệt:**
- Form fields được pre-filled với dữ liệu hiện tại
- Employee Number là hidden field
- Password field không required, placeholder "*****"
- Nút "Update" thay vì "Create"

### 5.4 Trang chi tiết nhân viên
**Layout:**
- Sidebar navigation
- Header với user info
- Main content area:
  - Page heading: "Detail Employee"
  - Table hiển thị thông tin chi tiết
  - Nút "Back"

## 6. AN NINH VÀ BẢO MẬT

### 6.1 Các vấn đề bảo mật hiện tại

#### 6.1.1 SQL Injection
**Vấn đề:** Model không sử dụng prepared statements
**Mức độ nghiêm trọng:** Cao
**Ví dụ:**
```php
// Code hiện tại - Dễ bị SQL Injection
$query = "INSERT INTO ".$this->table."(".$f.") VALUES (".$v.");";
return $this->connection->query($query);
```

**Khuyến nghị:**
```php
// Code cải thiện - Sử dụng prepared statements
$stmt = $this->connection->prepare("INSERT INTO employees (employeeNumber, lastName, firstName, ...) VALUES (?, ?, ?, ...)");
$stmt->bind_param("isss...", $data['employeeNumber'], $data['lastName'], $data['firstName'], ...);
$stmt->execute();
```

#### 6.1.2 XSS Attack
**Vấn đề:** View không sử dụng htmlspecialchars()
**Mức độ nghiêm trọng:** Trung bình
**Ví dụ:**
```php
// Code hiện tại - Dễ bị XSS
<td><?= $emp['lastName'] ?></td>
<td><?= $emp['email'] ?></td>
```

**Khuyến nghị:**
```php
// Code cải thiện - Escape output
<td><?= htmlspecialchars($emp['lastName']) ?></td>
<td><?= htmlspecialchars($emp['email']) ?></td>
```

#### 6.1.3 CSRF Protection
**Vấn đề:** Không có CSRF token trong forms
**Mức độ nghiêm trọng:** Cao
**Khuyến nghị:** Thêm CSRF token vào tất cả forms

#### 6.1.4 Input Validation
**Vấn đề:** Validation không đủ mạnh
**Mức độ nghiêm trọng:** Trung bình
**Các thiếu sót:**
- Không validate email format
- Không validate salary là số dương
- Không validate age là số hợp lý
- Không validate jobTitle không rỗng
- Không validate startDate format

**Khuyến nghị:** Thêm validation rules trong controller

#### 6.1.5 Password Security
**Vấn đề:** Sử dụng MD5 để mã hóa mật khẩu
**Mức độ nghiêm trọng:** Cao
**Ví dụ:**
```php
$data['password'] = md5($_POST['password']);
```

**Khuyến nghị:**
```php
// Sử dụng bcrypt hoặc Argon2
$data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
// Khi kiểm tra:
password_verify($_POST['password'], $stored_password);
```

#### 6.1.6 Authorization
**Vấn đề:** Không kiểm tra quyền truy cập
**Mức độ nghiêm trọng:** Cao
**Khuyến nghị:** Thêm middleware kiểm tra admin role

### 6.2 Các biện pháp bảo mật cần thêm

#### 6.2.1 Authentication & Authorization
```php
// Thêm vào constructor của controller
function __construct(){
    if (!isset($_SESSION['isLogin']) || !isset($_SESSION['admin'])) {
        header('Location: ?mod=login&act=login');
        exit;
    }
    // Kiểm tra quyền Manager cho các thao tác nhạy cảm
    if ($_SESSION['admin']['level'] != 1) {
        // Chỉ cho phép xem, không cho phép xóa/sửa
    }
    $this->cate_model = new employee();
}
```

#### 6.2.2 Rate Limiting
Giới hạn số lượng request để prevent brute force attacks

#### 6.2.3 Audit Logging
Ghi log tất cả các thao tác CRUD:
- Ai thực hiện
- Thao tác gì
- Khi nào
- Dữ liệu thay đổi

#### 6.2.4 Soft Delete
Thay vì xóa vĩnh viễn, đánh dấu nhân viên là deleted:
```sql
ALTER TABLE employees ADD COLUMN is_deleted TINYINT DEFAULT 0;
ALTER TABLE employees ADD COLUMN deleted_at DATETIME DEFAULT NULL;
ALTER TABLE employees ADD COLUMN deleted_by INT DEFAULT NULL;
```

## 7. FLOWCHART

### 7.1 Flowchart Thêm nhân viên
```
┌──────────────┐
│ Admin click  │
│ "Add"        │
└──────┬───────┘
       │
┌──────▼───────┐
│ Hiển thị form│
│  thêm mới    │
└──────┬───────┘
       │
┌──────▼───────┐
│ Admin điền   │
│ thông tin    │
└──────┬───────┘
       │
┌──────▼───────┐
│ Click "Create"│
└──────┬───────┘
       │
┌──────▼───────┐
│ Controller   │
│ nhận dữ liệu │
└──────┬───────┘
       │
┌──────▼───────┐
│ Validate     │
│ dữ liệu      │
└──────┬───────┘
       │
   ┌───┴───┐
   │ Valid?│
   └───┬───┘
       │
  ┌────┴────┐
  │ No      │ Yes
  ▼          ▼
┌─────┐  ┌────────────┐
│ Show │  │ Check trùng │
│ Error│  │ ID & Email │
└─────┘  └─────┬──────┘
              │
         ┌────┴────┐
         │ Trùng?  │
         └────┬────┘
              │
         ┌────┴────┐
         │ Yes     │ No
         ▼         ▼
      ┌─────┐  ┌────────────┐
      │Show │  │ Model create│
      │Error│  │ employee    │
      └─────┘  └─────┬──────┘
                    │
             ┌──────▼──────┐
             │ Insert DB   │
             └──────┬──────┘
                    │
               ┌────┴────┐
               │ Success?│
               └────┬────┘
                    │
               ┌────┴────┐
               │ No      │ Yes
               ▼         ▼
            ┌─────┐  ┌──────────┐
            │Show │  │ Redirect  │
            │Error│  │ to list   │
            └─────┘  └──────────┘
```

### 7.2 Flowchart Cập nhật nhân viên
```
┌──────────────┐
│ Admin click  │
│ "Update"     │
└──────┬───────┘
       │
┌──────▼───────┐
│ Controller   │
│ load employee│
└──────┬───────┘
       │
┌──────▼───────┐
│ Model find   │
│ employee     │
└──────┬───────┘
       │
┌──────▼───────┐
│ Hiển thị form│
│  cập nhật    │
│ (pre-filled) │
└──────┬───────┘
       │
┌──────▼───────┐
│ Admin sửa    │
│ thông tin    │
└──────┬───────┘
       │
┌──────▼───────┐
│ Click "Update"│
└──────┬───────┘
       │
┌──────▼───────┐
│ Controller   │
│ nhận dữ liệu │
└──────┬───────┘
       │
┌──────▼───────┐
│ Validate     │
│ dữ liệu      │
└──────┬───────┘
       │
   ┌───┴───┐
   │ Valid?│
   └───┬───┘
       │
  ┌────┴────┐
  │ No      │ Yes
  ▼          ▼
┌─────┐  ┌────────────┐
│ Show │  │ Check pass │
│ Error│  │ rỗng?      │
└─────┘  └─────┬──────┘
              │
         ┌────┴────┐
         │ Rỗng?  │
         └────┬────┘
              │
         ┌────┴────┐
         │ Yes     │ No
         ▼         ▼
      ┌─────┐  ┌────────────┐
      │Không│  │ Hash pass  │
      │update│  │ mới        │
      └─────┘  └─────┬──────┘
                    │
             ┌──────▼──────┐
             │ Model edit  │
             └──────┬──────┘
                    │
             ┌──────▼──────┐
             │ Update DB   │
             └──────┬──────┘
                    │
               ┌────┴────┐
               │ Success?│
               └────┬────┘
                    │
               ┌────┴────┐
               │ No      │ Yes
               ▼         ▼
            ┌─────┐  ┌──────────┐
            │Show │  │ Redirect  │
            │Error│  │ to list   │
            └─────┘  └──────────┘
```

### 7.3 Flowchart Xóa nhân viên
```
┌──────────────┐
│ Admin click  │
│ "Delete"     │
└──────┬───────┘
       │
┌──────▼───────┐
│ JavaScript   │
│ confirm dialog│
└──────┬───────┘
       │
   ┌───┴───┐
   │ OK?    │
   └───┬───┘
       │
  ┌────┴────┐
  │ Cancel  │ OK
  ▼         ▼
┌─────┐  ┌────────────┐
│ Nothing│ │ Controller  │
└─────┘  │ delete()    │
         └─────┬──────┘
               │
        ┌──────▼──────┐
        │ Model delete│
        └──────┬──────┘
               │
        ┌──────▼──────┐
        │ Delete from │
        │   DB        │
        └──────┬──────┘
               │
          ┌────┴────┐
          │ Success?│
          └────┬────┘
               │
          ┌────┴────┐
          │ No      │ Yes
          ▼         ▼
       ┌─────┐  ┌──────────┐
       │Show │  │ Redirect │
       │Error│  │ to list  │
       └─────┘  └──────────┘
```

## 8. KIỂM THỬ PHẦN MỀM

### 8.1 Chiến lược kiểm thử
Chức năng quản lý nhân viên cần được kiểm thử toàn diện để đảm bảo:
- CRUD operations hoạt động đúng
- Validation hiệu quả
- Bảo mật được đảm bảo
- UI/UX tốt

### 8.2 Các loại kiểm thử

#### 8.2.1 Kiểm thử đơn vị (Unit Testing)

**Test Cases cho Model/Employee.php:**
```php
// Test 1: Kiểm tra hàm find() với ID hợp lệ
public function testFindWithValidId() {
    $employee = new employee();
    $result = $employee->find(1001);
    $this->assertIsArray($result);
    $this->assertEquals(1001, $result['employeeNumber']);
}

// Test 2: Kiểm tra hàm find() với ID không tồn tại
public function testFindWithInvalidId() {
    $employee = new employee();
    $result = $employee->find(999999);
    $this->assertNull($result);
}

// Test 3: Kiểm tra hàm create() với dữ liệu hợp lệ
public function testCreateWithValidData() {
    $employee = new employee();
    $data = [
        'employeeNumber' => 9999,
        'lastName' => 'Test',
        'firstName' => 'Employee',
        'email' => 'test@example.com',
        'password' => md5('password123'),
        'jobTitle' => 'Test Position',
        'startDate' => '2026-01-01',
        'age' => 25,
        'salary' => 10000000,
        'level' => 0
    ];
    $result = $employee->create($data);
    $this->assertTrue($result);
}

// Test 4: Kiểm tra hàm checkEmailExists()
public function testCheckEmailExists() {
    $employee = new employee();
    $result = $employee->checkEmailExists('nguyenduclong@gmail.com');
    $this->assertTrue($result);
}

// Test 5: Kiểm tra hàm checkEmployeeNumberExists()
public function testCheckEmployeeNumberExists() {
    $employee = new employee();
    $result = $employee->checkEmployeeNumberExists(1001);
    $this->assertTrue($result);
}

// Test 6: Kiểm tra hàm edit() với dữ liệu hợp lệ
public function testEditWithValidData() {
    $employee = new employee();
    $data = [
        'employeeNumber' => 9999,
        'lastName' => 'Updated',
        'firstName' => 'Employee',
        'email' => 'test@example.com',
        'jobTitle' => 'Updated Position',
        'startDate' => '2026-01-01',
        'age' => 26,
        'salary' => 12000000
    ];
    $result = $employee->edit($data);
    $this->assertTrue($result);
}

// Test 7: Kiểm tra hàm delete() với ID hợp lệ
public function testDeleteWithValidId() {
    $employee = new employee();
    $result = $employee->delete(9999);
    $this->assertTrue($result);
}
```

**Test Cases cho Controller/EmployeeController.php:**
```php
// Test 8: Kiểm tra list() trả về view đúng
public function testListReturnsView() {
    $controller = new employeeController();
    ob_start();
    $controller->list();
    $output = ob_get_clean();
    $this->assertStringContainsString('Quản lý nhân viên', $output);
}

// Test 9: Kiểm tra store() với dữ liệu hợp lệ
public function testStoreWithValidData() {
    $_POST['id'] = 9998;
    $_POST['lastName'] = 'Test';
    $_POST['firstName'] = 'Employee';
    $_POST['email'] = 'newtest@example.com';
    $_POST['password'] = 'password123';
    $_POST['position'] = 'Test Position';
    $_POST['startDate'] = '2026-01-01';
    $_POST['age'] = 25;
    $_POST['salary'] = 10000000;
    $_POST['level'] = 0;
    
    $controller = new employeeController();
    $controller->store();
    
    $this->assertStringContainsString('Thêm mới thành công', $_COOKIE['msg']);
}

// Test 10: Kiểm tra store() với email trùng
public function testStoreWithDuplicateEmail() {
    $_POST['id'] = 9997;
    $_POST['lastName'] = 'Test';
    $_POST['firstName'] = 'Employee';
    $_POST['email'] = 'nguyenduclong@gmail.com'; // Email đã tồn tại
    $_POST['password'] = 'password123';
    $_POST['position'] = 'Test Position';
    $_POST['startDate'] = '2026-01-01';
    $_POST['age'] = 25;
    $_POST['salary'] = 10000000;
    $_POST['level'] = 0;
    
    $controller = new employeeController();
    $controller->store();
    
    $this->assertStringContainsString('Email đã tồn tại', $_COOKIE['msg']);
}

// Test 11: Kiểm tra edit() với dữ liệu hợp lệ
public function testEditWithValidData() {
    $_POST['id'] = 9998;
    $_POST['lastName'] = 'Updated';
    $_POST['firstName'] = 'Employee';
    $_POST['email'] = 'newtest@example.com';
    $_POST['password'] = ''; // Password rỗng, không cập nhật
    $_POST['position'] = 'Updated Position';
    $_POST['startDate'] = '2026-01-01';
    $_POST['age'] = 26;
    $_POST['salary'] = 12000000;
    
    $controller = new employeeController();
    $controller->edit();
    
    $this->assertStringContainsString('Cập nhật thành công', $_COOKIE['msg']);
}

// Test 12: Kiểm tra delete() với ID hợp lệ
public function testDeleteWithValidId() {
    $_GET['id'] = 9998;
    
    $controller = new employeeController();
    $controller->delete();
    
    $this->assertStringContainsString('Xóa thành công', $_COOKIE['msg']);
}
```

#### 8.2.2 Kiểm thử tích hợp (Integration Testing)

**Test Cases tích hợp:**
```php
// Test 13: Kiểm thử quy trình thêm nhân viên hoàn chỉnh
public function testCompleteCreateFlow() {
    // Bước 1: Admin mở form thêm
    $controller = new employeeController();
    ob_start();
    $controller->add();
    $output = ob_get_clean();
    $this->assertStringContainsString('Add New Employee', $output);
    
    // Bước 2: Admin điền form và submit
    $_POST['id'] = 9996;
    $_POST['lastName'] = 'Integration';
    $_POST['firstName'] = 'Test';
    $_POST['email'] = 'integration@example.com';
    $_POST['password'] = 'password123';
    $_POST['position'] = 'Integration Test';
    $_POST['startDate'] = '2026-01-01';
    $_POST['age'] = 30;
    $_POST['salary'] = 15000000;
    $_POST['level'] = 0;
    
    $controller->store();
    
    // Bước 3: Kiểm tra nhân viên được thêm vào DB
    $model = new employee();
    $employee = $model->find(9996);
    $this->assertNotNull($employee);
    $this->assertEquals('Integration', $employee['lastName']);
}

// Test 14: Kiểm thử quy trình cập nhật nhân viên hoàn chỉnh
public function testCompleteUpdateFlow() {
    // Bước 1: Admin mở form cập nhật
    $_GET['id'] = 9996;
    $controller = new employeeController();
    ob_start();
    $controller->update();
    $output = ob_get_clean();
    $this->assertStringContainsString('Update Employee', $output);
    
    // Bước 2: Admin sửa và submit
    $_POST['id'] = 9996;
    $_POST['lastName'] = 'Updated Integration';
    $_POST['firstName'] = 'Test';
    $_POST['email'] = 'integration@example.com';
    $_POST['password'] = 'newpassword123';
    $_POST['position'] = 'Updated Position';
    $_POST['startDate'] = '2026-01-01';
    $_POST['age'] = 31;
    $_POST['salary'] = 18000000;
    
    $controller->edit();
    
    // Bước 3: Kiểm tra nhân viên được cập nhật
    $model = new employee();
    $employee = $model->find(9996);
    $this->assertEquals('Updated Integration', $employee['lastName']);
    $this->assertEquals(18000000, $employee['salary']);
}
```

#### 8.2.3 Kiểm thử chấp nhận (Acceptance Testing)

**Test Cases chấp nhận:**

**TC-AT-01: Xem danh sách nhân viên**
- **Mô tả:** Admin xem danh sách tất cả nhân viên
- **Điều kiện tiên quyết:** Admin đã đăng nhập
- **Bước thực hiện:**
  1. Click menu "Nhân viên"
  2. Xem danh sách nhân viên
- **Kết quả mong đợi:** Hiển thị danh sách nhân viên với đầy đủ thông tin
- **Trạng thái:** Pass/Fail

**TC-AT-02: Thêm nhân viên thành công**
- **Mô tả:** Admin thêm nhân viên mới với thông tin hợp lệ
- **Điều kiện tiên quyết:** Admin đã đăng nhập, employeeNumber và email chưa tồn tại
- **Bước thực hiện:**
  1. Click "Add"
  2. Điền đầy đủ thông tin hợp lệ
  3. Click "Create"
- **Kết quả mong đợi:** Nhân viên được thêm, hiển thị thông báo thành công, chuyển về danh sách
- **Trạng thái:** Pass/Fail

**TC-AT-03: Thêm nhân viên với mã trùng**
- **Mô tả:** Admin thêm nhân viên với employeeNumber đã tồn tại
- **Điều kiện tiên quyết:** Admin đã đăng nhập, employeeNumber đã tồn tại
- **Bước thực hiện:**
  1. Click "Add"
  2. Điền thông tin với employeeNumber trùng
  3. Click "Create"
- **Kết quả mong đợi:** Hiển thị thông báo "Mã nhân viên đã tồn tại", không thêm nhân viên
- **Trạng thái:** Pass/Fail

**TC-AT-04: Thêm nhân viên với email trùng**
- **Mô tả:** Admin thêm nhân viên với email đã tồn tại
- **Điều kiện tiên quyết:** Admin đã đăng nhập, email đã tồn tại
- **Bước thực hiện:**
  1. Click "Add"
  2. Điền thông tin với email trùng
  3. Click "Create"
- **Kết quả mong đợi:** Hiển thị thông báo "Email đã tồn tại", không thêm nhân viên
- **Trạng thái:** Pass/Fail

**TC-AT-05: Cập nhật nhân viên thành công**
- **Mô tả:** Admin cập nhật thông tin nhân viên
- **Điều kiện tiên quyết:** Admin đã đăng nhập, nhân viên tồn tại
- **Bước thực hiện:**
  1. Click "Update" trên nhân viên
  2. Sửa thông tin
  3. Click "Update"
- **Kết quả mong đợi:** Nhân viên được cập nhật, hiển thị thông báo thành công
- **Trạng thái:** Pass/Fail

**TC-AT-06: Cập nhật nhân viên không thay đổi password**
- **Mô tả:** Admin cập nhật thông tin nhân viên nhưng để password rỗng
- **Điều kiện tiên quyết:** Admin đã đăng nhập, nhân viên tồn tại
- **Bước thực hiện:**
  1. Click "Update" trên nhân viên
  2. Sửa thông tin, để password rỗng
  3. Click "Update"
- **Kết quả mong đợi:** Nhân viên được cập nhật, password không thay đổi
- **Trạng thái:** Pass/Fail

**TC-AT-07: Xóa nhân viên thành công**
- **Mô tả:** Admin xóa nhân viên
- **Điều kiện tiên quyết:** Admin đã đăng nhập, nhân viên tồn tại
- **Bước thực hiện:**
  1. Click "Delete" trên nhân viên
  2. Confirm dialog
- **Kết quả mong đợi:** Nhân viên bị xóa, hiển thị thông báo thành công
- **Trạng thái:** Pass/Fail

#### 8.2.4 Kiểm thử bảo mật (Security Testing)

**Test Cases bảo mật:**

**TC-SEC-01: SQL Injection trong employeeNumber**
- **Mô tả:** Thử inject SQL vào trường employeeNumber
- **Input:** `' OR '1'='1`
- **Kết quả mong đợi:** Query thất bại, không bị tấn công SQL injection
- **Trạng thái:** Pass/Fail

**TC-SEC-02: XSS trong lastName**
- **Mô tả:** Thử inject JavaScript vào lastName
- **Input:** `<script>alert('XSS')</script>`
- **Kết quả mong đợi:** Script không được thực thi, dữ liệu được escape
- **Trạng thái:** Pass/Fail

**TC-SEC-03: CSRF Attack**
- **Mô tả:** Thử gửi request từ external site
- **Kết quả mong đợi:** Request bị từ chối (nếu có CSRF protection)
- **Trạng thái:** Pass/Fail (Chưa triển khai)

**TC-SEC-04: Unauthorized Access**
- **Mô tả:** Thử truy cập trang quản lý nhân viên khi chưa đăng nhập
- **Kết quả mong đợi:** Chuyển hướng về trang đăng nhập
- **Trạng thái:** Pass/Fail (Chưa triển khai)

**TC-SEC-05: Password Hashing**
- **Mô tả:** Kiểm tra mật khẩu trong database
- **Kết quả mong đợi:** Mật khẩu được mã hóa, không lưu plain text
- **Trạng thái:** Pass/Fail

### 8.3 Công cụ kiểm thử

#### 8.3.1 PHPUnit
Framework kiểm thử đơn vị cho PHP

#### 8.3.2 Selenium WebDriver
Kiểm thử giao diện và chấp nhận

#### 8.3.3 Postman
Kiểm thử API endpoints

### 8.4 Kế hoạch kiểm thử

| Loại kiểm thử | Số test case | Trạng thái | Ưu tiên |
|--------------|-------------|------------|---------|
| Unit Testing | 12 | Chưa thực hiện | Cao |
| Integration Testing | 2 | Chưa thực hiện | Cao |
| Acceptance Testing | 7 | Chưa thực hiện | Trung bình |
| Security Testing | 5 | Chưa thực hiện | Cao |

## 9. KẾT LUẬN VÀ KHUYẾN NGHỊ

### 9.1 Đánh giá hiện tại
Chức năng quản lý nhân viên hiện tại đã đáp ứng được các nhu cầu cơ bản:
- Cho phép thực hiện đầy đủ CRUD operations
- Giao diện người dùng trực quan
- Sử dụng MVC pattern
- Có validation cho trùng lặp employeeNumber và email
- Có debug logging
- Hỗ trợ cập nhật mà không thay đổi password

### 9.2 Các điểm cần cải thiện

#### Ưu tiên cao:
1. **Bảo mật SQL Injection:** Thay thế string concatenation bằng prepared statements
2. **CSRF Protection:** Thêm CSRF tokens cho tất cả forms
3. **Authorization:** Thêm kiểm tra quyền truy cập admin
4. **Password Security:** Thay thế MD5 bằng bcrypt hoặc Argon2
5. **XSS Protection:** Sử dụng htmlspecialchars() cho tất cả output

#### Ưu tiên trung bình:
6. **Input Validation:** Thêm validation rules mạnh hơn (email format, salary positive, etc.)
7. **Soft Delete:** Thay thế hard delete bằng soft delete
8. **Audit Logging:** Ghi log các thao tác CRUD
9. **Error Handling:** Cải thiện thông báo lỗi
10. **Role-based Access Control:** Hạn chế quyền dựa trên level (Employee/Manager)

#### Ưu tiên thấp:
11. **Bulk Operations:** Thêm xóa/cập nhật hàng loạt
12. **Search & Filter:** Thêm tìm kiếm và lọc nhân viên
13. **Export/Import:** Thêm xuất/nhập dữ liệu
14. **Profile Picture:** Thêm upload hình ảnh nhân viên
15. **Performance Review:** Thêm chức năng đánh giá hiệu suất

### 9.3 Kế hoạch triển khai
1. **Ngắn hạn (1 tuần):** Fix SQL Injection, thêm CSRF protection, nâng cấp password hashing
2. **Trung hạn (2 tuần):** Thêm authorization, input validation, XSS protection
3. **Dài hạn (1 tháng):** Triển khai soft delete, audit logging, role-based access control

## 10. TÀI LIỆU THAM KHẢO

- PHP Manual: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- OWASP Security Guidelines: https://owasp.org/
- MVC Pattern: https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller
- Bootstrap 4 Documentation: https://getbootstrap.com/docs/4.6/
- DataTables Plugin: https://datatables.net/

---
**Người lập báo cáo:** Cascade AI Assistant  
**Ngày lập:** 23/06/2026  
**Phiên bản:** 1.0
