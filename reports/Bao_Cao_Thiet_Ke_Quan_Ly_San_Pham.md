# BÁO CÁO THIẾT KẾ CHỨC NĂNG QUẢN LÝ SẢN PHẨM

## 1. GIỚI THIỆU CHUNG

### 1.1 Mục đích
Báo cáo này mô tả chi tiết về thiết kế và triển khai chức năng quản lý sản phẩm cho hệ thống Sport Shop, cho phép quản trị viên thực hiện các thao tác CRUD (Create, Read, Update, Delete) trên sản phẩm.

### 1.2 Phạm vi
- Quản lý danh sách sản phẩm
- Thêm sản phẩm mới
- Cập nhật thông tin sản phẩm
- Xóa sản phẩm
- Xem chi tiết sản phẩm
- Quản lý danh mục sản phẩm (Product Lines)

## 2. KIẾN TRÚC HỆ THỐNG

### 2.1 Mô hình MVC
Chức năng quản lý sản phẩm được xây dựng theo mô hình Model-View-Controller (MVC):

```
┌─────────────────┐
│     VIEW        │
│  (Giao diện)    │
│  - product_list │
│  - product_add  │
│  - product_update│
└────────┬────────┘
         │
┌────────▼────────┐
│  CONTROLLER     │
│ (Xử lý logic)   │
│ ProductController│
└────────┬────────┘
         │
┌────────▼────────┐
│     MODEL       │
│  (Dữ liệu)      │
│  - Product      │
│  - Model (base) │
└────────┬────────┘
         │
┌────────▼────────┐
│   DATABASE      │
│  - products     │
│  - productlines │
│  - product_view │
└─────────────────┘
```

### 2.2 Cấu trúc thư mục
```
sport_shop/admin/
├── controllers/
│   └── ProductController.php
├── models/
│   ├── Product.php
│   └── Model.php (base class)
├── views/
│   └── product/
│       ├── product_list.php
│       ├── product_add.php
│       └── product_update.php
└── database/
    └── sport_shops.sql
```

## 3. THIẾT KẾ CƠ SỞ DỮ LIỆU

### 3.1 Bảng products (Sản phẩm)
```sql
CREATE TABLE `products` (
  `productCode` varchar(15) NOT NULL,
  `productName` varchar(70) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `productLineCode` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `productDescription` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `quantityInStock` int(11) NOT NULL,
  `buyPrice` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  PRIMARY KEY (`productCode`),
  KEY `productLineCode` (`productLineCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Mô tả các trường:**
- `productCode`: Mã sản phẩm (Khóa chính, varchar 15)
- `productName`: Tên sản phẩm (varchar 70)
- `productLineCode`: Mã danh mục sản phẩm (Khóa ngoại tới productlines)
- `productDescription`: Mô tả chi tiết sản phẩm (text)
- `quantityInStock`: Số lượng tồn kho (int)
- `buyPrice`: Giá mua (decimal 10,2)
- `image`: Đường dẫn hình ảnh sản phẩm (varchar 255)
- `views`: Số lượt xem sản phẩm (int, default 0)

### 3.2 Bảng productlines (Danh mục sản phẩm)
```sql
CREATE TABLE `productlines` (
  `productLine` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `textDescription` varchar(4000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`productLine`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Mô tả các trường:**
- `productLine`: Mã danh mục (Khóa chính, varchar 50)
- `textDescription`: Mô tả danh mục (varchar 4000)
- `image`: Hình ảnh danh mục (varchar 255)

### 3.3 View product_view
View được tạo để tối ưu hóa truy vấn và join dữ liệu từ bảng products và productlines:

```sql
CREATE VIEW `product_view` AS
SELECT 
    p.*,
    pl.productLine,
    pl.textDescription as productLineDescription
FROM 
    products p
LEFT JOIN 
    productlines pl ON p.productLineCode = pl.productLine;
```

**Mục đích:**
- Giảm số lượng JOIN trong các truy vấn
- Tăng hiệu suất truy vấn
- Đơn giản hóa code trong Model

## 4. THIẾT KẾ CHỨC NĂNG

### 4.1 Chức năng Danh sách sản phẩm (List)

#### 4.1.1 Controller
**File:** `admin/controllers/ProductController.php`
**Method:** `list()`

**Quy trình:**
1. Gọi model để lấy tất cả sản phẩm
2. Truyền dữ liệu sang view
3. Hiển thị danh sách sản phẩm

**Code:**
```php
public function list(){
    $products = array();
    $products = $this->prod_model->All();
    require_once('views/product/product_list.php');
}
```

#### 4.1.2 Model
**File:** `admin/models/Product.php`
**Method:** `All()`

**Quy trình:**
1. Thực hiện truy vấn SELECT từ product_view
2. Fetch tất cả rows
3. Trả về array của sản phẩm

**Code:**
```php
function All(){
    $query = "SELECT * FROM product_view";
    $data = array();
    $result = $this->connection->query($query);
    
    while($row = $result->fetch_assoc()) { 
        $data[] = $row;
    }
    
    return $data;
}
```

#### 4.1.3 View
**File:** `admin/views/product/product_list.php`

**Các thành phần:**
- Breadcrumb navigation
- Nút "Thêm sản phẩm"
- Thông báo thành công/thất bại (cookie-based)
- Bảng danh sách sản phẩm với các cột:
  - Danh mục (productLine)
  - Tên sản phẩm (productName)
  - Giá (buyPrice)
  - Số lượng (quantityInStock)
  - Hình ảnh (image)
  - Thao tác (Xem, Sửa, Xóa)

**Các nút chức năng:**
- **Xem:** Chuyển đến trang chi tiết sản phẩm (frontend)
- **Sửa:** Chuyển đến trang cập nhật sản phẩm
- **Xóa:** Xóa sản phẩm với confirm dialog

### 4.2 Chức năng Thêm sản phẩm (Create)

#### 4.2.1 Controller
**File:** `admin/controllers/ProductController.php`
**Methods:** `add()`, `store()`

**Method add():**
```php
public function add(){
    require_once('views/product/product_add.php');		
}
```

**Method store():**
```php
public function store(){
    $data = array();
    $data['productCode'] = $_POST['id'];
    $data['productName'] = $_POST['productName'];
    $data['buyPrice'] = $_POST['price'];
    $data['productDescription'] = $_POST['productDescription'];
    $data['quantityInStock'] = $_POST['quantityInStock'];
    $data['productLineCode'] = $_POST['productLineCode'];
    $data['image'] = $_POST['thumbnail'];
    
    $status = $this->prod_model->create($data);
    
    if($status == true){
        setcookie('msg','Thêm mới thành công',time()+1);
        header('Location: ?mod=product');
    }
    else {
        setcookie('msg','Thêm mới không thành công',time()+1);
        header('Location: ?mod=product&act=add');
    }
}
```

#### 4.2.2 Model
**File:** `admin/models/Product.php`
**Method:** `create($data)`

**Quy trình:**
1. Nhận array dữ liệu sản phẩm
2. Xây dựng câu lệnh INSERT động
3. Thực thi truy vấn
4. Trả về kết quả (true/false)

**Code:**
```php
function create($data){
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
```

**Vấn đề bảo mật:**
- Không sử dụng prepared statements
- Dễ bị SQL Injection
- Cần cải thiện bằng cách sử dụng parameterized queries

#### 4.2.3 View
**File:** `admin/views/product/product_add.php`

**Các thành phần:**
- Load danh sách productlines cho dropdown
- Form với các trường:
  - ID (productCode) - text input
  - Product Name - text input
  - Price Each (VND) - text input
  - Description - textarea với Summernote editor
  - ProductLine - dropdown (select từ productlines)
  - Quantity In Stock - number input
  - Sale Percent - number input (không được sử dụng trong controller)
  - Image - text input (đường dẫn URL)
- Nút "Create" và "Back"
- Summernote WYSIWYG editor cho description

**Lưu ý:**
- Upload file hình ảnh đã bị comment out
- Hiện tại sử dụng text input cho đường dẫn hình ảnh
- Sale percent field không được xử lý trong controller

### 4.3 Chức năng Cập nhật sản phẩm (Update)

#### 4.3.1 Controller
**File:** `admin/controllers/ProductController.php`
**Methods:** `update()`, `edit()`

**Method update():**
```php
public function update(){
    $id = isset($_GET['id'])?$_GET['id']:0;
    $product = $this->prod_model->find($id);
    require_once('views/product/product_update.php');		
}
```

**Method edit():**
```php
public function edit(){
    $data = array();
    $data['productCode'] = $_POST['id'];
    $data['productName'] = $_POST['productName'];
    $data['buyPrice'] = (int)$_POST['price'];
    $data['productDescription'] = $_POST['productDescription'];
    $data['quantityInStock'] = $_POST['quantityInStock'];
    $data['productLineCode'] = $_POST['productLine'];
    $data['image'] = $_POST['image'];
    
    $status = $this->prod_model->edit($data);
    
    if($status == true){
        setcookie('msg','Cập nhật thành công',time()+1);
        header('Location: ?mod=product');
    }
    else {
        setcookie('msg','Cập nhật không thành công',time()+1);
        header('Location: ?mod=product&act=update&id='.$data['productCode']);
    }
}
```

#### 4.3.2 Model
**File:** `admin/models/Product.php`
**Methods:** `find($id)`, `edit($data)`

**Method find():**
```php
function find($id){
    $query = "SELECT * FROM product_view WHERE productCode = '".$id."'";
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
    
    $query = "UPDATE ".$this->table." SET ".$v." WHERE productCode ='".$data['productCode']."'";
    return $this->connection->query($query);
}
```

**Vấn đề bảo mật:**
- Không sử dụng prepared statements
- Dễ bị SQL Injection
- Cần cải thiện

#### 4.3.3 View
**File:** `admin/views/product/product_update.php`

**Các thành phần:**
- Load danh sách productlines cho dropdown
- Form với các trường (pre-filled với dữ liệu hiện tại):
  - ID (productCode) - text input (readonly)
  - Product Name - text input
  - Price Each (VND) - number input
  - Description - textarea với Summernote editor
  - ProductLine - dropdown (selected value hiện tại)
  - Quantity In Stock - number input
  - Current Thumbnail - hiển thị hình ảnh hiện tại
  - New Image - text input
- Nút "Update" và "Back"
- Summernote WYSIWYG editor

### 4.4 Chức năng Xóa sản phẩm (Delete)

#### 4.4.1 Controller
**File:** `admin/controllers/ProductController.php`
**Method:** `delete()`

**Code:**
```php
public function delete(){
    $id = isset($_GET['id'])?$_GET['id']:0;
    
    $status = $this->prod_model->delete($id);
    if($status == true){
        setcookie('msg','Xóa thành công',time()+1);
    }
    else {
        setcookie('msg','Xóa không thành công',time()+1);
    }
    header('Location: ?mod=product');
}
```

#### 4.4.2 Model
**File:** `admin/models/Product.php`
**Method:** `delete($id)`

**Code:**
```php
function delete($id){
    $query = "DELETE FROM ".$this->table." WHERE productCode = '".$id."'";
    return $this->connection->query($query);
}
```

**Vấn đề:**
- Không kiểm tra ràng buộc khóa ngoại
- Có thể gây lỗi nếu sản phẩm có trong đơn hàng
- Cần thêm soft delete hoặc kiểm tra ràng buộc

#### 4.4.3 View
Xóa được thực hiện trực tiếp từ danh sách với JavaScript confirm:
```javascript
onclick="return confirm('Xác nhận xóa?')"
```

### 4.5 Chức năng Xem chi tiết sản phẩm (Detail)

#### 4.5.1 Controller
**File:** `admin/controllers/ProductController.php`
**Method:** `detail()`

**Code:**
```php
public function detail(){
    $id = isset($_GET['id'])?$_GET['id']:0;
    $prod = $this->prod_model->find($id);
    require_once('views/product/product_detail.php');
}
```

**Lưu ý:** File `product_detail.php` không tồn tại trong codebase hiện tại.

## 5. THIẾT KẾ GIAO DIỆN

### 5.1 Trang danh sách sản phẩm
**Layout:**
- Sidebar navigation
- Header với user info
- Main content area:
  - Page heading: "Danh sách sản phẩm"
  - Nút "Thêm sản phẩm"
  - Alert message (cookie-based)
  - Card chứa table responsive
  - Table với các cột: Danh mục, Tên SP, Giá, Số lượng, Hình ảnh, Thao tác

**Styling:**
- Bootstrap 4 framework
- DataTables plugin cho table
- Responsive design
- Hover effects trên rows

### 5.2 Trang thêm sản phẩm
**Layout:**
- Sidebar navigation
- Header với user info
- Main content area:
  - Page heading: "Add Product"
  - Alert message (nếu có)
  - Form với Bootstrap form groups
  - Summernote editor cho description

**Form fields:**
- ID: Text input
- Product Name: Text input
- Price Each (VND): Text input
- Description: Textarea với Summernote
- ProductLine: Select dropdown
- Quantity In Stock: Number input
- Sale Percent: Number input
- Image: Text input

### 5.3 Trang cập nhật sản phẩm
**Layout:** Tương tự trang thêm sản phẩm
**Khác biệt:**
- Form fields được pre-filled với dữ liệu hiện tại
- Hiển thị hình ảnh hiện tại
- ID field readonly
- Nút "Update" thay vì "Create"

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
$stmt = $this->connection->prepare("INSERT INTO products (productCode, productName, buyPrice, ...) VALUES (?, ?, ?, ...)");
$stmt->bind_param("sss...", $data['productCode'], $data['productName'], $data['buyPrice'], ...);
$stmt->execute();
```

#### 6.1.2 XSS Attack
**Vấn đề:** View sử dụng `htmlspecialchars()` nhưng không nhất quán
**Mức độ nghiêm trọng:** Trung bình
**Ví dụ tốt:**
```php
<td><?= htmlspecialchars($p['productName'] ?? '') ?></td>
```

**Ví dụ chưa tốt:**
```php
<td><?= $p['productLine'] ?? 'N/A' ?></td>
```

**Khuyến nghị:** Sử dụng `htmlspecialchars()` cho tất cả output từ database

#### 6.1.3 CSRF Protection
**Vấn đề:** Không có CSRF token trong forms
**Mức độ nghiêm trọng:** Cao
**Khuyến nghị:** Thêm CSRF token vào tất cả forms

#### 6.1.4 Input Validation
**Vấn đề:** Validation không đủ mạnh
**Mức độ nghiêm trọng:** Trung bình
**Các thiếu sót:**
- Không validate productCode uniqueness
- Không validate buyPrice là số dương
- Không validate quantityInStock là số không âm
- Không validate image URL format

**Khuyến nghị:** Thêm validation rules trong controller

#### 6.1.5 File Upload
**Vấn đề:** Upload file bị comment out
**Mức độ nghiêm trọng:** Thấp
**Khuyến nghị:** Triển khai upload file an toàn với:
- Validate file type
- Validate file size
- Rename file
- Store outside web root

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
    $this->prod_model = new product();
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
Thay vì xóa vĩnh viễn, đánh dấu sản phẩm là deleted:
```sql
ALTER TABLE products ADD COLUMN is_deleted TINYINT DEFAULT 0;
```

## 7. FLOWCHART

### 7.1 Flowchart Thêm sản phẩm
```
┌──────────────┐
│ Admin click  │
│ "Thêm sản phẩm"│
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
│ Show │  │ Model create│
│ Error│  │ product    │
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

### 7.2 Flowchart Cập nhật sản phẩm
```
┌──────────────┐
│ Admin click  │
│ "Sửa" trên SP│
└──────┬───────┘
       │
┌──────▼───────┐
│ Controller   │
│ load product │
└──────┬───────┘
       │
┌──────▼───────┐
│ Model find   │
│ product      │
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
│ Show │  │ Model edit  │
│ Error│  │ product    │
└─────┘  └─────┬──────┘
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

### 7.3 Flowchart Xóa sản phẩm
```
┌──────────────┐
│ Admin click  │
│ "Xóa" trên SP│
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
Chức năng quản lý sản phẩm cần được kiểm thử toàn diện để đảm bảo:
- CRUD operations hoạt động đúng
- Validation hiệu quả
- Bảo mật được đảm bảo
- UI/UX tốt

### 8.2 Các loại kiểm thử

#### 8.2.1 Kiểm thử đơn vị (Unit Testing)

**Test Cases cho Model/Product.php:**
```php
// Test 1: Kiểm tra hàm All()
public function testAll() {
    $product = new product();
    $result = $product->All();
    $this->assertIsArray($result);
    $this->assertNotEmpty($result);
}

// Test 2: Kiểm tra hàm find() với ID hợp lệ
public function testFindWithValidId() {
    $product = new product();
    $result = $product->find('bd_0003');
    $this->assertIsArray($result);
    $this->assertEquals('bd_0003', $result['productCode']);
}

// Test 3: Kiểm tra hàm find() với ID không tồn tại
public function testFindWithInvalidId() {
    $product = new product();
    $result = $product->find('invalid_id');
    $this->assertNull($result);
}

// Test 4: Kiểm tra hàm create() với dữ liệu hợp lệ
public function testCreateWithValidData() {
    $product = new product();
    $data = [
        'productCode' => 'test_001',
        'productName' => 'Test Product',
        'buyPrice' => 100000,
        'productDescription' => 'Test description',
        'quantityInStock' => 10,
        'productLineCode' => '1',
        'image' => 'http://example.com/image.jpg'
    ];
    $result = $product->create($data);
    $this->assertTrue($result);
}

// Test 5: Kiểm tra hàm edit() với dữ liệu hợp lệ
public function testEditWithValidData() {
    $product = new product();
    $data = [
        'productCode' => 'bd_0003',
        'productName' => 'Updated Product Name',
        'buyPrice' => 200000,
        'productDescription' => 'Updated description',
        'quantityInStock' => 20,
        'productLineCode' => '1',
        'image' => 'http://example.com/new-image.jpg'
    ];
    $result = $product->edit($data);
    $this->assertTrue($result);
}

// Test 6: Kiểm tra hàm delete() với ID hợp lệ
public function testDeleteWithValidId() {
    $product = new product();
    $result = $product->delete('test_001');
    $this->assertTrue($result);
}
```

**Test Cases cho Controller/ProductController.php:**
```php
// Test 7: Kiểm tra list() trả về view đúng
public function testListReturnsView() {
    $controller = new productController();
    ob_start();
    $controller->list();
    $output = ob_get_clean();
    $this->assertStringContainsString('Danh sách sản phẩm', $output);
}

// Test 8: Kiểm tra store() với dữ liệu hợp lệ
public function testStoreWithValidData() {
    $_POST['id'] = 'test_002';
    $_POST['productName'] = 'Test Product';
    $_POST['price'] = 100000;
    $_POST['productDescription'] = 'Test description';
    $_POST['quantityInStock'] = 10;
    $_POST['productLineCode'] = '1';
    $_POST['thumbnail'] = 'http://example.com/image.jpg';
    
    $controller = new productController();
    $controller->store();
    
    $this->assertStringContainsString('Thêm mới thành công', $_COOKIE['msg']);
}

// Test 9: Kiểm tra edit() với dữ liệu hợp lệ
public function testEditWithValidData() {
    $_POST['id'] = 'bd_0003';
    $_POST['productName'] = 'Updated Product';
    $_POST['price'] = 200000;
    $_POST['productDescription'] = 'Updated description';
    $_POST['quantityInStock'] = 20;
    $_POST['productLine'] = '1';
    $_POST['image'] = 'http://example.com/image.jpg';
    
    $controller = new productController();
    $controller->edit();
    
    $this->assertStringContainsString('Cập nhật thành công', $_COOKIE['msg']);
}

// Test 10: Kiểm tra delete() với ID hợp lệ
public function testDeleteWithValidId() {
    $_GET['id'] = 'test_002';
    
    $controller = new productController();
    $controller->delete();
    
    $this->assertStringContainsString('Xóa thành công', $_COOKIE['msg']);
}
```

#### 8.2.2 Kiểm thử tích hợp (Integration Testing)

**Test Cases tích hợp:**
```php
// Test 11: Kiểm thử quy trình thêm sản phẩm hoàn chỉnh
public function testCompleteCreateFlow() {
    // Bước 1: Admin mở form thêm
    $controller = new productController();
    ob_start();
    $controller->add();
    $output = ob_get_clean();
    $this->assertStringContainsString('Add Product', $output);
    
    // Bước 2: Admin điền form và submit
    $_POST['id'] = 'test_003';
    $_POST['productName'] = 'Integration Test Product';
    $_POST['price'] = 150000;
    $_POST['productDescription'] = 'Integration test description';
    $_POST['quantityInStock'] = 15;
    $_POST['productLineCode'] = '1';
    $_POST['thumbnail'] = 'http://example.com/test.jpg';
    
    $controller->store();
    
    // Bước 3: Kiểm tra sản phẩm được thêm vào DB
    $model = new product();
    $product = $model->find('test_003');
    $this->assertNotNull($product);
    $this->assertEquals('Integration Test Product', $product['productName']);
}

// Test 12: Kiểm thử quy trình cập nhật sản phẩm hoàn chỉnh
public function testCompleteUpdateFlow() {
    // Bước 1: Admin mở form cập nhật
    $_GET['id'] = 'test_003';
    $controller = new productController();
    ob_start();
    $controller->update();
    $output = ob_get_clean();
    $this->assertStringContainsString('Update Products', $output);
    
    // Bước 2: Admin sửa và submit
    $_POST['id'] = 'test_003';
    $_POST['productName'] = 'Updated Integration Test Product';
    $_POST['price'] = 250000;
    $_POST['productDescription'] = 'Updated description';
    $_POST['quantityInStock'] = 25;
    $_POST['productLine'] = '1';
    $_POST['image'] = 'http://example.com/updated.jpg';
    
    $controller->edit();
    
    // Bước 3: Kiểm tra sản phẩm được cập nhật
    $model = new product();
    $product = $model->find('test_003');
    $this->assertEquals('Updated Integration Test Product', $product['productName']);
    $this->assertEquals(250000, $product['buyPrice']);
}
```

#### 8.2.3 Kiểm thử chấp nhận (Acceptance Testing)

**Test Cases chấp nhận:**

**TC-AT-01: Xem danh sách sản phẩm**
- **Mô tả:** Admin xem danh sách tất cả sản phẩm
- **Điều kiện tiên quyết:** Admin đã đăng nhập
- **Bước thực hiện:**
  1. Click menu "Sản phẩm"
  2. Xem danh sách sản phẩm
- **Kết quả mong đợi:** Hiển thị danh sách sản phẩm với đầy đủ thông tin
- **Trạng thái:** Pass/Fail

**TC-AT-02: Thêm sản phẩm thành công**
- **Mô tả:** Admin thêm sản phẩm mới với thông tin hợp lệ
- **Điều kiện tiên quyết:** Admin đã đăng nhập, productCode chưa tồn tại
- **Bước thực hiện:**
  1. Click "Thêm sản phẩm"
  2. Điền đầy đủ thông tin hợp lệ
  3. Click "Create"
- **Kết quả mong đợi:** Sản phẩm được thêm, hiển thị thông báo thành công, chuyển về danh sách
- **Trạng thái:** Pass/Fail

**TC-AT-03: Thêm sản phẩm với mã trùng**
- **Mô tả:** Admin thêm sản phẩm với productCode đã tồn tại
- **Điều kiện tiên quyết:** Admin đã đăng nhập, productCode đã tồn tại
- **Bước thực hiện:**
  1. Click "Thêm sản phẩm"
  2. Điền thông tin với productCode trùng
  3. Click "Create"
- **Kết quả mong đợi:** Hiển thị thông báo lỗi, không thêm sản phẩm
- **Trạng thái:** Pass/Fail

**TC-AT-04: Cập nhật sản phẩm thành công**
- **Mô tả:** Admin cập nhật thông tin sản phẩm
- **Điều kiện tiên quyết:** Admin đã đăng nhập, sản phẩm tồn tại
- **Bước thực hiện:**
  1. Click "Sửa" trên sản phẩm
  2. Sửa thông tin
  3. Click "Update"
- **Kết quả mong đợi:** Sản phẩm được cập nhật, hiển thị thông báo thành công
- **Trạng thái:** Pass/Fail

**TC-AT-05: Xóa sản phẩm thành công**
- **Mô tả:** Admin xóa sản phẩm
- **Điều kiện tiên quyết:** Admin đã đăng nhập, sản phẩm tồn tại
- **Bước thực hiện:**
  1. Click "Xóa" trên sản phẩm
  2. Confirm dialog
- **Kết quả mong đợi:** Sản phẩm bị xóa, hiển thị thông báo thành công
- **Trạng thái:** Pass/Fail

#### 8.2.4 Kiểm thử bảo mật (Security Testing)

**Test Cases bảo mật:**

**TC-SEC-01: SQL Injection trong productCode**
- **Mô tả:** Thử inject SQL vào trường productCode
- **Input:** `' OR '1'='1`
- **Kết quả mong đợi:** Query thất bại, không bị tấn công SQL injection
- **Trạng thái:** Pass/Fail

**TC-SEC-02: XSS trong productName**
- **Mô tả:** Thử inject JavaScript vào productName
- **Input:** `<script>alert('XSS')</script>`
- **Kết quả mong đợi:** Script không được thực thi, dữ liệu được escape
- **Trạng thái:** Pass/Fail

**TC-SEC-03: CSRF Attack**
- **Mô tả:** Thử gửi request từ external site
- **Kết quả mong đợi:** Request bị từ chối (nếu có CSRF protection)
- **Trạng thái:** Pass/Fail (Chưa triển khai)

**TC-SEC-04: Unauthorized Access**
- **Mô tả:** Thử truy cập trang quản lý sản phẩm khi chưa đăng nhập
- **Kết quả mong đợi:** Chuyển hướng về trang đăng nhập
- **Trạng thái:** Pass/Fail (Chưa triển khai)

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
| Unit Testing | 10 | Chưa thực hiện | Cao |
| Integration Testing | 2 | Chưa thực hiện | Cao |
| Acceptance Testing | 5 | Chưa thực hiện | Trung bình |
| Security Testing | 4 | Chưa thực hiện | Cao |

## 9. KẾT LUẬN VÀ KHUYẾN NGHỊ

### 9.1 Đánh giá hiện tại
Chức năng quản lý sản phẩm hiện tại đã đáp ứng được các nhu cầu cơ bản:
- Cho phép thực hiện đầy đủ CRUD operations
- Giao diện người dùng trực quan
- Sử dụng MVC pattern
- Có view để tối ưu truy vấn

### 9.2 Các điểm cần cải thiện

#### Ưu tiên cao:
1. **Bảo mật SQL Injection:** Thay thế string concatenation bằng prepared statements
2. **CSRF Protection:** Thêm CSRF tokens cho tất cả forms
3. **Authorization:** Thêm kiểm tra quyền truy cập admin
4. **Input Validation:** Thêm validation rules mạnh hơn

#### Ưu tiên trung bình:
5. **File Upload:** Triển khai upload file hình ảnh an toàn
6. **Soft Delete:** Thay thế hard delete bằng soft delete
7. **Audit Logging:** Ghi log các thao tác CRUD
8. **Error Handling:** Cải thiện thông báo lỗi

#### Ưu tiên thấp:
9. **Bulk Operations:** Thêm xóa/cập nhật hàng loạt
10. **Search & Filter:** Thêm tìm kiếm và lọc sản phẩm
11. **Export/Import:** Thêm xuất/nhập dữ liệu
12. **Image Optimization:** Tự động optimize hình ảnh

### 9.3 Kế hoạch triển khai
1. **Ngắn hạn (1 tuần):** Fix SQL Injection và thêm CSRF protection
2. **Trung hạn (2 tuần):** Thêm authorization và input validation
3. **Dài hạn (1 tháng):** Triển khai soft delete và audit logging

## 10. TÀI LIỆU THAM KHẢO

- PHP Manual: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- OWASP Security Guidelines: https://owasp.org/
- MVC Pattern: https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller
- Bootstrap 4 Documentation: https://getbootstrap.com/docs/4.6/
- Summernote Editor: https://summernote.org/

---
**Người lập báo cáo:** Cascade AI Assistant  
**Ngày lập:** 23/06/2026  
**Phiên bản:** 1.0
