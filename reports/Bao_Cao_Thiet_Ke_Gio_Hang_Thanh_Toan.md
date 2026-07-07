# BÁO CÁO THIẾT KẾ CHỨC NĂNG GIỎ HÀNG VÀ THANH TOÁN

## 1. GIỚI THIỆU CHUNG

### 1.1 Mục đích
Báo cáo này mô tả chi tiết về thiết kế và triển khai chức năng giỏ hàng và thanh toán cho hệ thống Sport Shop, cho phép khách hàng thêm sản phẩm vào giỏ hàng, quản lý giỏ hàng, và thực hiện đặt hàng với nhiều phương thức thanh toán khác nhau.

### 1.2 Phạm vi
- Quản lý giỏ hàng (thêm, xóa, cập nhật số lượng)
- Xem danh sách sản phẩm trong giỏ hàng
- Tính toán tổng tiền với khuyến mãi
- Đặt hàng và tạo đơn hàng
- Quản lý đơn hàng (xem danh sách, chi tiết, xóa)
- Hỗ trợ nhiều phương thức thanh toán

## 2. KIẾN TRÚC HỆ THỐNG

### 2.1 Mô hình MVC
Chức năng giỏ hàng và thanh toán được xây dựng theo mô hình Model-View-Controller (MVC):

```
┌─────────────────┐
│     VIEW        │
│  (Giao diện)    │
│  - cart_list    │
│  - infor        │
│  - order_list   │
│  - order_detail │
└────────┬────────┘
         │
┌────────▼────────┐
│  CONTROLLER     │
│ (Xử lý logic)   │
│  - CartController│
│  - OrderController│
└────────┬────────┘
         │
┌────────▼────────┐
│     MODEL       │
│  (Dữ liệu)      │
│  - Cart         │
│  - Order        │
│  - Product      │
└────────┬────────┘
         │
┌────────▼────────┐
│   DATABASE      │
│  - orders       │
│  - orderdetails │
│  - products     │
│  - sales        │
└─────────────────┘
```

### 2.2 Cấu trúc thư mục
```
sport_shop/
├── controllers/
│   ├── CartController.php
│   └── admin/
│       └── OrderController.php
├── models/
│   ├── Cart.php
│   ├── Product.php
│   └── admin/
│       └── Order.php
├── views/
│   ├── cart/
│   │   ├── cart_list.php
│   │   ├── infor.php
│   │   └── informail.php
│   └── admin/
│       └── order/
│           ├── order_list.php
│           ├── order_detail.php
│           └── order_update.php
└── database/
    └── sport_shops.sql
```

## 3. THIẾT KẾ CƠ SỞ DỮ LIỆU

### 3.1 Bảng orders (Đơn hàng)
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

**Mô tả các trường:**
- `orderNumber`: Mã đơn hàng (Khóa chính, int 11)
- `orderDate`: Ngày đặt hàng (datetime)
- `requiredDate`: Ngày yêu cầu giao hàng (date)
- `shippedDate`: Ngày giao hàng thực tế (date)
- `status`: Trạng thái đơn hàng (varchar 50: In Process, Shipped, Cancelled, etc.)
- `comments`: Ghi chú về đơn hàng (text)
- `customerNumber`: Mã khách hàng (Khóa ngoại tới customers, int 11)

### 3.2 Bảng orderdetails (Chi tiết đơn hàng)
```sql
CREATE TABLE `orderdetails` (
  `orderNumber` int(11) NOT NULL,
  `productCode` varchar(15) NOT NULL,
  `quantityOrdered` int(11) NOT NULL,
  `employeeNumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderNumber`,`productCode`),
  KEY `productCode` (`productCode`),
  KEY `employeeNumber` (`employeeNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Mô tả các trường:**
- `orderNumber`: Mã đơn hàng (Khóa chính, khóa ngoại tới orders)
- `productCode`: Mã sản phẩm (Khóa chính, khóa ngoại tới products)
- `quantityOrdered`: Số lượng đặt (int 11)
- `employeeNumber`: Mã nhân viên xử lý (int 11, khóa ngoại tới employees)

**Lưu ý:** Bảng này không lưu giá bán (priceEach) trong schema hiện tại, giá được tính động từ bảng products và sales.

### 3.3 Bảng sales (Khuyến mãi)
```sql
-- Schema không được hiển thị trong file SQL, nhưng được sử dụng trong code
-- Các trường thường có:
-- productCode: Mã sản phẩm
-- sales_percent: Phần trăm giảm giá
```

## 4. THIẾT KẾ CHỨC NĂNG GIỎ HÀNG

### 4.1 Chức năng Xem giỏ hàng (List)

#### 4.1.1 Controller
**File:** `controllers/CartController.php`
**Method:** `list()`

**Quy trình:**
1. Lấy giỏ hàng từ session
2. Truyền dữ liệu sang view
3. Hiển thị danh sách sản phẩm trong giỏ hàng

**Code:**
```php
public function list() {
    $data = array();
    require_once('views/cart/cart_list.php');
}
```

#### 4.1.2 View
**File:** `views/cart/cart_list.php`

**Các thành phần:**
- Breadcrumb navigation
- Page heading: "Giỏ Hàng"
- Table hiển thị sản phẩm trong giỏ hàng với các cột:
  - Sản phẩm (hình ảnh, tên, màu sắc, kích thước)
  - Đơn giá (đã áp dụng khuyến mãi)
  - Số lượng (nút +/-)
  - Thành tiền
  - Xóa
- Phần tính toán:
  - Tổng tiền giỏ hàng
  - Phí vận chuyển (30,000 VND)
  - Thuế VAT (5%)
  - Tổng cộng
- Form mã giảm giá (chưa hoạt động)
- Nút "Đặt hàng"

### 4.2 Chức năng Thêm sản phẩm vào giỏ hàng (Add)

#### 4.2.1 Controller
**File:** `controllers/CartController.php`
**Method:** `add()`

**Quy trình:**
1. Lấy ID sản phẩm từ URL
2. Lấy thông tin sản phẩm từ database
3. Lấy thông tin khuyến mãi từ bảng sales
4. Kiểm tra sản phẩm đã có trong giỏ hàng chưa
5. Nếu có: tăng số lượng hoặc trả về lỗi (cho AJAX)
6. Nếu chưa: thêm mới vào giỏ hàng với số lượng = 1
7. Lưu vào session ($_SESSION['cart'])
8. Trả về JSON response cho AJAX hoặc redirect

**Code:**
```php
public function add() {
    $id = isset($_GET['id'])?$_GET['id']:0;
    
    $product = $this->product_model->find($id);
    
    // Lấy thông tin khuyến mãi
    $salesQuery = "SELECT sales_percent FROM sales WHERE productCode = '$id'";
    $salesResult = $this->cart_model->connection->query($salesQuery);
    $sales_percent = 0;
    if ($salesResult && $salesResult->num_rows > 0) {
        $sales_percent = $salesResult->fetch_assoc()['sales_percent'];
    }
    
    $product['sales_percent'] = $sales_percent;

    if (isset($_SESSION['cart'][$id])) {
        if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $price = $item['buyPrice'] * (100 - ($item['sales_percent'] ?? 0)) / 100;
                $total += $price * $item['SoLuong'];
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Sản phẩm đã có trong giỏ hàng!',
                'cart_count' => count($_SESSION['cart']),
                'cart_total' => number_format($total)
            ]);
            exit;
        } else {
            $_SESSION['cart'][$id]['SoLuong']++;
        }
    } else {
        $product['SoLuong'] = 1;
        $_SESSION['cart'][$id] = $product;
    }

    if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $price = $item['buyPrice'] * (100 - ($item['sales_percent'] ?? 0)) / 100;
            $total += $price * $item['SoLuong'];
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'cart_count' => count($_SESSION['cart']),
            'cart_total' => number_format($total)
        ]);
        exit;
    }
    
    header('Location: ?mod=cart&act=list');
}
```

**Đặc điểm:**
- Hỗ trợ AJAX request để cập nhật giỏ hàng mà không reload trang
- Tính toán tổng tiền giỏ hàng trong real-time
- Lưu thông tin khuyến mãi vào session

### 4.3 Chức năng Xóa/Giảm số lượng (Delete)

#### 4.3.1 Controller
**File:** `controllers/CartController.php`
**Method:** `delete()`

**Quy trình:**
1. Lấy ID sản phẩm và tham số del
2. Nếu del=1: Xóa toàn bộ giỏ hàng
3. Nếu del=2: Xóa sản phẩm cụ thể
4. Nếu không có del: Giảm số lượng hoặc xóa nếu số lượng = 1
5. Redirect về trang giỏ hàng hoặc trang chủ

**Code:**
```php
public function delete(){
    $id = isset($_GET['id'])?$_GET['id']:0;
    $del = $_GET['del'];

    if($del==1){
        unset($_SESSION['cart']);
        header("Location: ?mod=page&act=home");
    }
    else if($del==2){
        unset($_SESSION['cart'][$id]);
        header("Location: ?mod=cart&act=list");
    }
    else if($_SESSION['cart'][$id]['SoLuong'] > 1){
        $_SESSION['cart'][$id]['SoLuong']--;
        header("Location: ?mod=cart&act=list");
    } else {
        unset($_SESSION['cart'][$id]);
        header("Location: ?mod=cart&act=list");
    }
}
```

### 4.4 Chức năng Đặt hàng (Order)

#### 4.4.1 Controller
**File:** `controllers/CartController.php`
**Method:** `order()`

**Quy trình:**
1. Lấy giỏ hàng từ session
2. Gọi model để tạo đơn hàng
3. Nếu thành công: xóa giỏ hàng, hiển thị thông báo thành công
4. Nếu thất bại: xóa giỏ hàng, hiển thị thông báo lỗi
5. Redirect về trang chủ

**Code:**
```php
public function order(){
    if(isset($_SESSION['cart']))
        $products = $_SESSION['cart'];
    else $products = null;

    error_log("Starting order process with products: " . print_r($products, true));
    $status = $this->cart_model->insert($products);
    error_log("Order status: " . ($status ? 'SUCCESS' : 'FAILED'));

    if($status == true){
        setcookie('msg','Đặt hàng thành công!!! Tiếp tục mua hàng nào!!!',time()+2);
        unset($_SESSION['cart']);
        unset($_SESSION['sum']);
        header('Location: ?mod=page&act=home');
    }
    else {
        setcookie('msg','Không thể đặt hàng. Vui lòng kiểm tra lại số lượng tồn kho!',time()+2);
        unset($_SESSION['cart']);
        unset($_SESSION['sum']);
        header('Location: ?mod=page&act=home');
    }
}
```

#### 4.4.2 Model
**File:** `models/Cart.php`
**Method:** `insert($datas)`

**Quy trình:**
1. Bắt đầu transaction
2. Tạo mã đơn hàng mới (MAX(orderNumber) + 1)
3. Lấy thông tin khách hàng từ session
4. Thêm đơn hàng vào bảng orders
5. Xử lý từng sản phẩm trong giỏ hàng:
   - Kiểm tra tồn kho
   - Lấy thông tin khuyến mãi
   - Áp dụng giảm giá nếu có
   - Thêm chi tiết đơn hàng vào orderdetails
   - Giảm số lượng tồn kho
6. Commit transaction nếu thành công
7. Rollback nếu có lỗi

**Code:**
```php
function insert($datas) {
    if (empty($datas)) {
        return false;
    }

    try {
        $this->connection->begin_transaction();
        
        // Tạo mã đơn hàng mới
        $result = $this->connection->query("SELECT MAX(orderNumber) as max_num FROM orders");
        $row = $result->fetch_assoc();
        $newOrderNumber = $row['max_num'] + 1;

        // Lấy thông tin khách hàng
        $customerNumber = isset($_SESSION['customer']['customerNumber']) ? 
                        $_SESSION['customer']['customerNumber'] : 
                        (isset($_SESSION['employee']['employeeNumber']) ? 
                            $_SESSION['employee']['employeeNumber'] : 0);
        
        // Ngày đặt hàng và ngày yêu cầu giao
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $orderDate = date('Y-m-d H:i:s');
        $requiredDate = date('Y-m-d', strtotime('+7 days'));
        
        // Thêm vào bảng orders
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

        // Xử lý từng sản phẩm trong giỏ hàng
        foreach ($datas as $data) {
            $productCode = $this->connection->real_escape_string($data['productCode']);
            $quantity = (int)$data['SoLuong'];
            $priceEach = isset($data['buyPrice']) ? $data['buyPrice'] : 0;
            
            // Kiểm tra tồn kho
            $checkQuery = "SELECT quantityInStock FROM products WHERE productCode = '$productCode'";
            $checkResult = $this->connection->query($checkQuery);
            
            if ($checkResult->num_rows == 0) {
                throw new Exception("Không tìm thấy sản phẩm $productCode");
            }
            
            $productInfo = $checkResult->fetch_assoc();
            $currentStock = (int)$productInfo['quantityInStock'];
            
            if ($currentStock < $quantity) {
                throw new Exception("Sản phẩm $productCode không đủ số lượng (còn: $currentStock, yêu cầu: $quantity)");
            }
            
            // Lấy thông tin khuyến mãi
            $salesQuery = "SELECT sales_percent FROM sales WHERE productCode = '$productCode'";
            $salesResult = $this->connection->query($salesQuery);
            $sales_percent = 0;
            if ($salesResult && $salesResult->num_rows > 0) {
                $sales_percent = (int)$salesResult->fetch_assoc()['sales_percent'];
            }
            
            // Áp dụng giảm giá nếu có
            if ($sales_percent > 0) {
                $priceEach = $priceEach * (100 - $sales_percent) / 100;
            }
            
            // Thêm chi tiết đơn hàng
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
                throw new Exception("Lỗi khi thêm chi tiết đơn hàng: " . $this->connection->error);
            }
            
            // Giảm số lượng tồn kho
            $updateQuery = "UPDATE products SET quantityInStock = quantityInStock - $quantity WHERE productCode = '$productCode'";
            if (!$this->connection->query($updateQuery)) {
                throw new Exception("Lỗi khi cập nhật tồn kho: " . $this->connection->error);
            }
            
            error_log("Order $newOrderNumber: Updated product $productCode, stock reduced by $quantity (from $currentStock to " . ($currentStock - $quantity) . ")");
        }
        
        // Xác nhận giao dịch
        $this->connection->commit();
        error_log("Order $newOrderNumber completed successfully");
        return true;
        
    } catch (Exception $e) {
        // Hủy bỏ giao dịch nếu có lỗi
        $this->connection->rollback();
        error_log("Order failed: " . $e->getMessage());
        return false;
    }
}
```

**Đặc điểm:**
- Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
- Kiểm tra tồn kho trước khi đặt hàng
- Tự động giảm số lượng tồn kho sau khi đặt hàng thành công
- Hỗ trợ khuyến mãi động
- Debug logging chi tiết

### 4.5 Chức năng Thông tin đặt hàng (Mail)

#### 4.5.1 Controller
**File:** `controllers/CartController.php`
**Methods:** `mail()`, `send()`

**Method mail():**
```php
public function mail(){
    $data = array();
    
    // Lấy thông tin khách hàng nếu đã đăng nhập
    $customer_info = array();
    if (isset($_SESSION['user'])) {
        $email = $_SESSION['user'];
        $query = "SELECT * FROM customers WHERE email = '$email'";
        $result = $this->cart_model->connection->query($query);
        if ($result && $result->num_rows > 0) {
            $customer_info = $result->fetch_assoc();
        }
    }
    
    // Lấy sản phẩm từ giỏ hàng
    if(isset($_SESSION['cart']))
        $products = $_SESSION['cart'];
    else $products = null;
    
    // Tính tổng tiền
    $total_amount = 0;
    if ($products != null) {
        foreach ($products as $product) {
            $price = $product['buyPrice'] ?? 0;
            $discount = $product['sales_percent'] ?? 0;
            $final_price = $price * (100 - $discount) / 100;
            $total_amount += $final_price * $product['SoLuong'];
        }
    }
    
    require_once('views/cart/infor.php');
}
```

#### 4.5.2 View
**File:** `views/cart/infor.php`

**Các thành phần:**
- Form thông tin giao hàng:
  - Tên, Họ
  - Email
  - Số điện thoại
  - Địa chỉ giao hàng
  - Thành phố/Tỉnh
  - Quốc gia
  - Ghi chú đơn hàng
- Phương thức thanh toán:
  - Thanh toán khi nhận hàng (COD)
  - Chuyển khoản ngân hàng
  - Ví điện tử VNPAY
  - Ví MoMo
  - ZaloPay
- Tùy chọn tạo tài khoản (cho khách chưa đăng nhập)
- Tóm tắt đơn hàng:
  - Danh sách sản phẩm
  - Tạm tính
  - Phí vận chuyển (Miễn phí)
  - Giảm giá
  - Tổng cộng
- Nút "Xác nhận đặt hàng"

**Đặc điểm:**
- Hỗ trợ cả khách đã đăng nhập và chưa đăng nhập
- Form được pre-filled với thông tin khách hàng nếu đã đăng nhập
- Hỗ trợ nhiều phương thức thanh toán
- Tính toán tổng tiền real-time với khuyến mãi
- Responsive design với Bootstrap

## 5. THIẾT KẾ CHỨC NĂNG QUẢN LÝ ĐƠN HÀNG (ADMIN)

### 5.1 Chức năng Danh sách đơn hàng (List)

#### 5.1.1 Controller
**File:** `admin/controllers/OrderController.php`
**Method:** `list()`

**Code:**
```php
public function list(){
    $data = array();
    $data = $this->order_model->All();
    require_once('views/order/order_list.php');
}
```

#### 5.1.2 Model
**File:** `admin/models/Order.php`
**Method:** `All()`

**Quy trình:**
1. Thực hiện truy vấn JOIN giữa orderdetails, orders, products, sales
2. Tính giá bán có áp dụng khuyến mãi
3. Sắp xếp theo ngày đặt hàng giảm dần
4. Trả về array của đơn hàng

**Code:**
```php
public function All() {
    $query = "SELECT 
                 od.*, 
                 p.productName, 
                 p.image, 
                 (p.buyPrice * (100 - IFNULL(s.sales_percent, 0)) / 100) as priceEach,
                 o.orderDate,
                 o.requiredDate,
                 o.shippedDate,
                 o.status,
                 o.comments
             FROM
                 orderdetails od 
             LEFT JOIN orders o ON od.orderNumber = o.orderNumber
             LEFT JOIN products p ON od.productCode = p.productCode
             LEFT JOIN sales s ON s.productCode = p.productCode
             ORDER BY o.orderDate DESC";
    
    error_log("QUERY ORDER ALL: " . $query);
    
    $data = [];
    $result = $this->connection->query($query);
    
    if ($result === false) {
        error_log("LÔI SQL: " . $this->connection->error);
        return $data;
    }

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { 
            $data[] = $row;
        }
    }

    return $data;
}
```

### 5.2 Chức năng Chi tiết đơn hàng (Detail)

#### 5.2.1 Controller
**File:** `admin/controllers/OrderController.php`
**Method:** `detail()`

**Code:**
```php
public function detail(){
    $id = isset($_GET['id'])?$_GET['id']:0;
    $orders = array();
    $orders = $this->order_model->find($id);
    require_once('views/order/order_detail.php');
}
```

#### 5.2.2 Model
**File:** `admin/models/Order.php`
**Method:** `find($id)`

**Quy trình:**
1. Validate và làm sạch ID
2. Thực hiện truy vấn JOIN để lấy thông tin chi tiết
3. Bao gồm thông tin khách hàng
4. Trả về array của các sản phẩm trong đơn hàng

**Code:**
```php
public function find($id) {
    $id = $this->connection->real_escape_string($id);
    $id = intval($id);
    
    if ($id <= 0) {
        error_log("ID đơn hàng không hợp lệ: " . $id);
        return array();
    }

    $query = "SELECT 
                 od.*, 
                 p.productName, 
                 p.image, 
                 (p.buyPrice * (100 - IFNULL(s.sales_percent, 0)) / 100) as priceEach,
                 o.orderDate,
                 o.requiredDate,
                 o.shippedDate,
                 o.status,
                 o.comments,
                 c.customerName,
                 c.phone,
                 c.addressLine1,
                 c.city,
                 c.country
             FROM
                 orderdetails od 
             LEFT JOIN orders o ON od.orderNumber = o.orderNumber
             LEFT JOIN products p ON od.productCode = p.productCode
             LEFT JOIN sales s ON s.productCode = p.productCode
             LEFT JOIN customers c ON o.customerNumber = c.customerNumber
             WHERE od.orderNumber = " . $id;
    $result = $this->connection->query($query);
    
    if ($result === false) {
        error_log("Lỗi SQL: " . $this->connection->error);
        return array();
    }

    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}
```

### 5.3 Chức năng Xóa đơn hàng (Delete)

#### 5.3.1 Controller
**File:** `admin/controllers/OrderController.php`
**Method:** `delete()`

**Code:**
```php
public function delete(){
    $id = isset($_GET['id'])?$_GET['id']:0;

    $status = $this->order_model->delete($id);
    if($status == true){
        setcookie('msg','Xóa thành công',time()+1);
    }
    else 
        setcookie('msg','Xóa không thành công',time()+1);
    header('Location: ?mod=order&act=list');
}
```

#### 5.3.2 Model
**File:** `admin/models/Order.php`
**Method:** `delete($id)`

**Quy trình:**
1. Validate ID
2. Bắt đầu transaction
3. Xóa chi tiết đơn hàng trước
4. Xóa đơn hàng chính
5. Commit transaction nếu thành công
6. Rollback nếu có lỗi

**Code:**
```php
public function delete($id) {
    $id = $this->connection->real_escape_string($id);
    $id = intval($id);
    
    if ($id <= 0) {
        error_log("ID đơn hàng không hợp lệ: " . $id);
        return false;
    }
    
    $this->connection->begin_transaction();
    
    try {
        // Xóa các chi tiết đơn hàng trước
        $deleteDetailsQuery = "DELETE FROM orderdetails WHERE orderNumber = " . $id;
        $result1 = $this->connection->query($deleteDetailsQuery);
        
        if ($result1 === false) {
            throw new Exception("Không thể xóa chi tiết đơn hàng");
        }
        
        // Xóa đơn hàng
        $deleteOrderQuery = "DELETE FROM orders WHERE orderNumber = " . $id;
        $result2 = $this->connection->query($deleteOrderQuery);
        
        if ($result2 === false) {
            throw new Exception("Không thể xóa đơn hàng");
        }
        
        $this->connection->commit();
        error_log("Xóa thành công đơn hàng: " . $id);
        return true;
        
    } catch (Exception $e) {
        $this->connection->rollback();
        error_log("Lỗi khi xóa đơn hàng: " . $e->getMessage());
        return false;
    }
}
```

## 6. THIẾT KẾ GIAO DIỆN

### 6.1 Trang giỏ hàng
**Layout:**
- Breadcrumb navigation
- Page heading: "Giỏ Hàng"
- Table responsive với:
  - Hình ảnh sản phẩm
  - Tên sản phẩm
  - Màu sắc, kích thước (hardcoded)
  - Đơn giá (đã giảm giá)
  - Số lượng (nút +/-)
  - Thành tiền
  - Nút xóa
- Phần tính toán:
  - Tổng tiền
  - Phí vận chuyển (30,000 VND)
  - Thuế VAT (5%)
  - Tổng cộng
- Form mã giảm giá (chưa hoạt động)
- Nút "Đặt hàng"

### 6.2 Trang thông tin đặt hàng
**Layout:**
- Breadcrumb navigation
- Page heading: "Thông tin đặt hàng"
- Form thông tin giao hàng (2 cột):
  - Cột trái: Form thông tin
  - Cột phải: Tóm tắt đơn hàng
- Phương thức thanh toán:
  - COD (mặc định)
  - Chuyển khoản ngân hàng
  - VNPAY
  - MoMo
  - ZaloPay
- Tóm tắt đơn hàng:
  - Danh sách sản phẩm với hình ảnh
  - Tạm tính
  - Phí vận chuyển (Miễn phí)
  - Giảm giá
  - Tổng cộng
- Nút "Xác nhận đặt hàng"

## 7. AN NINH VÀ BẢO MẬT

### 7.1 Các vấn đề bảo mật hiện tại

#### 7.1.1 SQL Injection
**Vấn đề:** Một số truy vấn vẫn sử dụng string concatenation
**Mức độ nghiêm trọng:** Cao
**Ví dụ:**
```php
// Code hiện tại - Dễ bị SQL Injection
$salesQuery = "SELECT sales_percent FROM sales WHERE productCode = '$id'";
```

**Khuyến nghị:**
```php
// Code cải thiện - Sử dụng prepared statements
$stmt = $this->connection->prepare("SELECT sales_percent FROM sales WHERE productCode = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
```

#### 7.1.2 XSS Attack
**Vấn đề:** View sử dụng htmlspecialchars() nhưng không nhất quán
**Mức độ nghiêm trọng:** Trung bình
**Ví dụ tốt:**
```php
<td><?= htmlspecialchars($product['productName']) ?></td>
```

**Ví dụ chưa tốt:**
```php
<td><?= $product['productName'] ?></td>
```

**Khuyến nghị:** Sử dụng `htmlspecialchars()` cho tất cả output từ database

#### 7.1.3 CSRF Protection
**Vấn đề:** Không có CSRF token trong forms
**Mức độ nghiêm trọng:** Cao
**Khuyến nghị:** Thêm CSRF token vào tất cả forms

#### 7.1.4 Session Security
**Vấn đề:** Giỏ hàng lưu trong session không được bảo vệ
**Mức độ nghiêm trọng:** Trung bình
**Khuyến nghị:**
- Sử dụng session_regenerate_id() sau khi đăng nhập
- Thiết lập session cookie parameters (secure, httponly)
- Validate session data

#### 7.1.5 Input Validation
**Vấn đề:** Validation không đủ mạnh
**Mức độ nghiêm trọng:** Trung bình
**Các thiếu sót:**
- Không validate số lượng tối đa
- Không validate tổng tiền tối đa
- Không validate thông tin giao hàng

**Khuyến nghị:** Thêm validation rules trong controller

### 7.2 Các biện pháp bảo mật cần thêm

#### 7.2.1 Rate Limiting
Giới hạn số lượng request để prevent brute force attacks

#### 7.2.2 Audit Logging
Ghi log tất cả các thao tác đặt hàng:
- Ai đặt hàng
- Đặt cái gì
- Khi nào
- Giá trị đơn hàng

#### 7.2.3 Fraud Detection
Phát hiện gian lận:
- Kiểm tra địa chỉ IP
- Giới hạn số lượng đơn hàng trong thời gian ngắn
- Kiểm tra thông tin thanh toán

## 8. FLOWCHART

### 8.1 Flowchart Thêm vào giỏ hàng
```
┌──────────────┐
│ Khách click   │
│ "Thêm vào giỏ"│
└──────┬───────┘
       │
┌──────▼───────┐
│ Controller   │
│ nhận ID SP   │
└──────┬───────┘
       │
┌──────▼───────┐
│ Model find   │
│ sản phẩm     │
└──────┬───────┘
       │
┌──────▼───────┐
│ Lấy khuyến   │
│ mãi (sales)  │
└──────┬───────┘
       │
┌──────▼───────┐
│ SP trong     │
│ giỏ chưa?    │
└──────┬───────┘
       │
   ┌───┴───┐
   │ Có?   │
   └───┬───┘
       │
  ┌────┴────┐
  │ Yes     │ No
  ▼         ▼
┌─────┐  ┌────────────┐
│Tăng │  │ Thêm mới   │
│SL+1 │  │ SL = 1     │
└─────┘  └─────┬──────┘
              │
       ┌──────▼──────┐
       │ Lưu session │
       └──────┬──────┘
              │
       ┌──────▼──────┐
       │ AJAX?       │
       └──────┬──────┘
              │
         ┌────┴────┐
         │ Yes     │ No
         ▼         ▼
      ┌─────┐  ┌──────────┐
      │JSON │  │ Redirect │
      │resp │  │ to cart  │
      └─────┘  └──────────┘
```

### 8.2 Flowchart Đặt hàng
```
┌──────────────┐
│ Khách click  │
│ "Đặt hàng"  │
└──────┬───────┘
       │
┌──────▼───────┐
│ Controller   │
│ order()      │
└──────┬───────┘
       │
┌──────▼───────┐
│ Model insert │
│ (transaction)│
└──────┬───────┘
       │
┌──────▼───────┐
│ Bắt đầu     │
│ transaction │
└──────┬───────┘
       │
┌──────▼───────┐
│ Tạo mã DH    │
│ mới          │
└──────┬───────┘
       │
┌──────▼───────┐
│ Insert orders│
└──────┬───────┘
       │
┌──────▼───────┐
│ Loop SP trong│
│ giỏ hàng     │
└──────┬───────┘
       │
┌──────▼───────┐
│ Check tồn kho│
└──────┬───────┘
       │
   ┌───┴───┐
   │ Đủ?   │
   └───┬───┘
       │
  ┌────┴────┐
  │ No      │ Yes
  ▼         ▼
┌─────┐  ┌────────────┐
│Roll │  │ Lấy khuyến │
│back │  │ mãi        │
└─────┘  └─────┬──────┘
              │
       ┌──────▼──────┐
       │ Áp dụng     │
       │ giảm giá    │
       └──────┬──────┘
              │
       ┌──────▼──────┐
       │ Insert      │
       │ orderdetails│
       └──────┬──────┘
              │
       ┌──────▼──────┐
       │ Update      │
       │ tồn kho     │
       └──────┬──────┘
              │
       ┌──────▼──────┐
       │ Commit      │
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
      │Roll │  │ Xóa giỏ │
      │back │  │ Success  │
      └─────┘  └──────────┘
```

## 9. KIỂM THỬ PHẦN MỀM

### 9.1 Chiến lược kiểm thử
Chức năng giỏ hàng và thanh toán cần được kiểm thử toàn diện để đảm bảo:
- CRUD operations trên giỏ hàng hoạt động đúng
- Đặt hàng thành công với transaction
- Tính toán giá và khuyến mãi chính xác
- Cập nhật tồn kho đúng
- Bảo mật được đảm bảo

### 9.2 Các loại kiểm thử

#### 9.2.1 Kiểm thử đơn vị (Unit Testing)

**Test Cases cho Model/Cart.php:**
```php
// Test 1: Kiểm tra insert() với giỏ hàng rỗng
public function testInsertWithEmptyCart() {
    $cart = new Cart();
    $result = $cart->insert([]);
    $this->assertFalse($result);
}

// Test 2: Kiểm tra insert() với dữ liệu hợp lệ
public function testInsertWithValidData() {
    $cart = new Cart();
    $_SESSION['customer']['customerNumber'] = 363;
    $data = [
        [
            'productCode' => 'bd_0001',
            'SoLuong' => 2,
            'buyPrice' => 150000
        ]
    ];
    $result = $cart->insert($data);
    $this->assertTrue($result);
}

// Test 3: Kiểm tra insert() với số lượng vượt quá tồn kho
public function testInsertWithInsufficientStock() {
    $cart = new Cart();
    $_SESSION['customer']['customerNumber'] = 363;
    $data = [
        [
            'productCode' => 'bd_0001',
            'SoLuong' => 999999,
            'buyPrice' => 150000
        ]
    ];
    $result = $cart->insert($data);
    $this->assertFalse($result);
}
```

**Test Cases cho Controller/CartController.php:**
```php
// Test 4: Kiểm tra add() với sản phẩm mới
public function testAddNewProduct() {
    $_GET['id'] = 'bd_0001';
    $_GET['ajax'] = 1;
    
    $controller = new CartController();
    ob_start();
    $controller->add();
    $output = ob_get_clean();
    
    $response = json_decode($output, true);
    $this->assertTrue($response['success']);
}

// Test 5: Kiểm tra add() với sản phẩm đã có trong giỏ
public function testAddExistingProduct() {
    $_SESSION['cart']['bd_0001'] = ['SoLuong' => 1];
    $_GET['id'] = 'bd_0001';
    $_GET['ajax'] = 1;
    
    $controller = new CartController();
    ob_start();
    $controller->add();
    $output = ob_get_clean();
    
    $response = json_decode($output, true);
    $this->assertFalse($response['success']);
    $this->assertEquals('Sản phẩm đã có trong giỏ hàng!', $response['message']);
}

// Test 6: Kiểm tra delete() với del=1 (xóa toàn bộ)
public function testDeleteAll() {
    $_SESSION['cart']['bd_0001'] = ['SoLuong' => 1];
    $_GET['id'] = 'bd_0001';
    $_GET['del'] = 1;
    
    $controller = new CartController();
    $controller->delete();
    
    $this->assertArrayNotHasKey('cart', $_SESSION);
}

// Test 7: Kiểm tra delete() với del=2 (xóa 1 sản phẩm)
public function testDeleteOneProduct() {
    $_SESSION['cart']['bd_0001'] = ['SoLuong' => 1];
    $_GET['id'] = 'bd_0001';
    $_GET['del'] = 2;
    
    $controller = new CartController();
    $controller->delete();
    
    $this->assertArrayNotHasKey('bd_0001', $_SESSION['cart']);
}
```

#### 9.2.2 Kiểm thử tích hợp (Integration Testing)

**Test Cases tích hợp:**
```php
// Test 8: Kiểm thử quy trình thêm vào giỏ và đặt hàng
public function testCompleteOrderFlow() {
    // Bước 1: Thêm sản phẩm vào giỏ
    $_GET['id'] = 'bd_0001';
    $controller = new CartController();
    $controller->add();
    
    // Bước 2: Kiểm tra sản phẩm trong giỏ
    $this->assertArrayHasKey('bd_0001', $_SESSION['cart']);
    $this->assertEquals(1, $_SESSION['cart']['bd_0001']['SoLuong']);
    
    // Bước 3: Đặt hàng
    $_SESSION['customer']['customerNumber'] = 363;
    $controller->order();
    
    // Bước 4: Kiểm tra đơn hàng được tạo
    $model = new Order();
    $orders = $model->All();
    $this->assertNotEmpty($orders);
    
    // Bước 5: Kiểm tra giỏ hàng bị xóa
    $this->assertArrayNotHasKey('cart', $_SESSION);
}
```

#### 9.2.3 Kiểm thử chấp nhận (Acceptance Testing)

**Test Cases chấp nhận:**

**TC-AT-01: Thêm sản phẩm vào giỏ hàng**
- **Mô tả:** Khách thêm sản phẩm vào giỏ hàng
- **Bước thực hiện:**
  1. Chọn sản phẩm
  2. Click "Thêm vào giỏ"
- **Kết quả mong đợi:** Sản phẩm được thêm vào giỏ, số lượng = 1
- **Trạng thái:** Pass/Fail

**TC-AT-02: Tăng số lượng sản phẩm**
- **Mô tả:** Khách tăng số lượng sản phẩm trong giỏ
- **Bước thực hiện:**
  1. Click nút "+" trên sản phẩm
- **Kết quả mong đợi:** Số lượng tăng lên 1
- **Trạng thái:** Pass/Fail

**TC-AT-03: Giảm số lượng sản phẩm**
- **Mô tả:** Khách giảm số lượng sản phẩm trong giỏ
- **Bước thực hiện:**
  1. Click nút "-" trên sản phẩm
- **Kết quả mong đợi:** Số lượng giảm 1 hoặc xóa nếu SL = 1
- **Trạng thái:** Pass/Fail

**TC-AT-04: Đặt hàng thành công**
- **Mô tả:** Khách đặt hàng với thông tin hợp lệ
- **Bước thực hiện:**
  1. Điền thông tin giao hàng
  2. Chọn phương thức thanh toán
  3. Click "Xác nhận đặt hàng"
- **Kết quả mong đợi:** Đơn hàng được tạo, giỏ hàng bị xóa
- **Trạng thái:** Pass/Fail

**TC-AT-05: Đặt hàng với số lượng vượt quá tồn kho**
- **Mô tả:** Khách đặt hàng với số lượng vượt quá tồn kho
- **Bước thực hiện:**
  1. Thêm sản phẩm với số lượng lớn
  2. Click "Đặt hàng"
- **Kết quả mong đợi:** Đơn hàng thất bại, hiển thị thông báo lỗi
- **Trạng thái:** Pass/Fail

#### 9.2.4 Kiểm thử bảo mật (Security Testing)

**Test Cases bảo mật:**

**TC-SEC-01: SQL Injection trong productCode**
- **Mô tả:** Thử inject SQL vào productCode khi thêm vào giỏ
- **Input:** `' OR '1'='1`
- **Kết quả mong đợi:** Query thất bại, không bị tấn công SQL injection
- **Trạng thái:** Pass/Fail

**TC-SEC-02: Session Hijacking**
- **Mô tả:** Thử truy cập giỏ hàng của người khác
- **Kết quả mong đợi:** Không thể truy cập giỏ hàng của người khác
- **Trạng thái:** Pass/Fail

**TC-SEC-03: CSRF Attack**
- **Mô tả:** Thử gửi request đặt hàng từ external site
- **Kết quả mong đợi:** Request bị từ chối (nếu có CSRF protection)
- **Trạng thái:** Pass/Fail (Chưa triển khai)

### 9.3 Công cụ kiểm thử

#### 9.3.1 PHPUnit
Framework kiểm thử đơn vị cho PHP

#### 9.3.2 Selenium WebDriver
Kiểm thử giao diện và chấp nhận

#### 9.3.3 Postman
Kiểm thử API endpoints

### 9.4 Kế hoạch kiểm thử

| Loại kiểm thử | Số test case | Trạng thái | Ưu tiên |
|--------------|-------------|------------|---------|
| Unit Testing | 7 | Chưa thực hiện | Cao |
| Integration Testing | 1 | Chưa thực hiện | Cao |
| Acceptance Testing | 5 | Chưa thực hiện | Trung bình |
| Security Testing | 3 | Chưa thực hiện | Cao |

## 10. KẾT LUẬN VÀ KHUYẾNNGHỊ

### 10.1 Đánh giá hiện tại
Chức năng giỏ hàng và thanh toán hiện tại đã đáp ứng được các nhu cầu cơ bản:
- Cho phép quản lý giỏ hàng đầy đủ (thêm, xóa, cập nhật số lượng)
- Hỗ trợ AJAX để cải thiện UX
- Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
- Kiểm tra tồn kho trước khi đặt hàng
- Tự động cập nhật tồn kho
- Hỗ trợ khuyến mãi động
- Hỗ trợ nhiều phương thức thanh toán
- Giao diện thân thiện với người dùng

### 10.2 Các điểm cần cải thiện

#### Ưu tiên cao:
1. **Bảo mật SQL Injection:** Thay thế string concatenation bằng prepared statements
2. **CSRF Protection:** Thêm CSRF tokens cho tất cả forms
3. **Session Security:** Cải thiện bảo mật session
4. **Input Validation:** Thêm validation rules mạnh hơn
5. **Error Handling:** Cải thiện thông báo lỗi

#### Ưu tiên trung bình:
6. **Payment Integration:** Triển khai tích hợp thực tế với VNPAY, MoMo, ZaloPay
7. **Coupon System:** Triển khai hệ thống mã giảm giá
8. **Order Status:** Thêm chức năng cập nhật trạng thái đơn hàng
9. **Email Notification:** Gửi email xác nhận đơn hàng
10. **Shipping Calculation:** Tính toán phí vận chuyển thực tế

#### Ưu tiên thấp:
11. **Wishlist:** Thêm chức năng danh sách yêu thích
12. **Order History:** Lịch sử đơn hàng cho khách hàng
13. **Reorder:** Đặt lại đơn hàng cũ
14. **Guest Checkout:** Cho phép khách vãng lai đặt hàng
15. **Multi-address:** Hỗ trợ nhiều địa chỉ giao hàng

### 10.3 Kế hoạch triển khai
1. **Ngắn hạn (1 tuần):** Fix SQL Injection, thêm CSRF protection
2. **Trung hạn (2 tuần):** Thêm input validation, cải thiện error handling
3. **Dài hạn (1 tháng):** Triển khai payment integration, coupon system

## 11. TÀI LIỆU THAM KHẢO

- PHP Manual: https://www.php.net/docs.php
- MySQL Documentation: https://dev.mysql.com/doc/
- OWASP Security Guidelines: https://owasp.org/
- MVC Pattern: https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller
- Bootstrap 4 Documentation: https://getbootstrap.com/docs/4.6/
- VNPAY Integration: https://vnpay.vn/
- MoMo Integration: https://developers.momo.vn/

---
**Người lập báo cáo:** Cascade AI Assistant  
**Ngày lập:** 23/06/2026  
**Phiên bản:** 1.0
