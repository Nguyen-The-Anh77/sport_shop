<?php 
require_once('Connection.php');

class Login {  // Đã sửa tên class
    var $connection;

    function __construct() {
        $conn_obj = new Connection();
        $this->connection = $conn_obj->conn;
    }
    
    function find($email, $password) {
        $email = $this->connection->real_escape_string($email);
        $password = $this->connection->real_escape_string($password);
        $query = "SELECT * FROM customers 
                 WHERE email = '$email' 
                 AND password = '$password'";
        $result = $this->connection->query($query);
        if (!$result) {
            writeLog('Lỗi truy vấn: ' . $this->connection->error);
            return false;
        }
        return $result->fetch_assoc();
    }
    
    // Thêm phương thức mới
    function findByEmail($email) {
        $email = $this->connection->real_escape_string($email);
        $query = "SELECT * FROM customers WHERE email = '".$email."' LIMIT 1";
        $result = $this->connection->query($query);
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }
    
    function findByPhone($phone) {
        $phone = $this->connection->real_escape_string($phone);
        $query = "SELECT * FROM customers WHERE phone = '".$phone."' LIMIT 1";
        $result = $this->connection->query($query);
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }
    
    function getMaxCustomerNumber() {
        $query = "SELECT MAX(customerNumber) as maxNumber FROM customers";
        $result = $this->connection->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return (int)$row['maxNumber'];
        }
        return 0; // Trả về 0 nếu không có dữ liệu
    }
    
    //     // Kiểm tra xem tất cả các trường bắt buộc đã có trong dữ liệu chưa
    //     foreach ($required_fields as $field) {
    //         if (!isset($data[$field]) || empty($data[$field])) {
    //             writeLog("Trường bắt buộc thiếu: $field");
    //             return false;
    //         }
    //     }

    //     // Tạo câu truy vấn an toàn
    //     $fields = [];
    //     $values = [];
    function register($data) {
        try {
            // Kiểm tra kết nối
            if (!$this->connection) {
                throw new Exception("Không thể kết nối đến cơ sở dữ liệu");
            }

            // Kiểm tra tất cả các trường có dữ liệu và không rỗng
            $required_fields = [
                'customerNumber' => 'Mã khách hàng',
                'customerName' => 'Tên khách hàng',
                'contactFirstName' => 'Tên',
                'contactLastName' => 'Họ',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'phone' => 'Số điện thoại',
                'addressLine1' => 'Địa chỉ',
                'city' => 'Thành phố',
                'country' => 'Quốc gia'
            ];

            foreach ($required_fields as $field => $label) {
                if (!isset($data[$field]) || trim($data[$field]) === '') {
                    throw new Exception("Vui lòng nhập " . $label);
                }
            }

            // Kiểm tra email hợp lệ
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email không hợp lệ");
            }

            // Kiểm tra email đã tồn tại chưa
            if ($this->findByEmail($data['email'])) {
                throw new Exception("Email đã được đăng ký");
            }

            // Kiểm tra số điện thoại đã tồn tại chưa
            if ($this->findByPhone($data['phone'])) {
                throw new Exception("Số điện thoại đã được đăng ký");
            }

            // Tạo câu lệnh SQL với prepared statement
            $sql = "INSERT INTO customers (
                        customerNumber, customerName, contactFirstName, 
                        contactLastName, email, password, 
                        phone, addressLine1, city, country
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi khi chuẩn bị câu lệnh: " . $this->connection->error);
            }

            // Gán giá trị và thực thi
            $result = $stmt->bind_param(
                "isssssssss",
                $data['customerNumber'],
                $data['customerName'],
                $data['contactFirstName'],
                $data['contactLastName'],
                $data['email'],
                $data['password'],
                $data['phone'],
                $data['addressLine1'],
                $data['city'],
                $data['country']
            );

            if (!$result) {
                throw new Exception("Lỗi khi ràng buộc tham số: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new Exception("Lỗi khi thực thi câu lệnh: " . $stmt->error);
            }

            $insertId = $this->connection->insert_id;
            $stmt->close();
            
            return $insertId ?: true; //Trả về ID của bản ghi vừa chèn hoặc true nếu thành công

        } catch (Exception $e) {
            // Ghi log lỗi
            error_log($e->getMessage());
            // Ném lại ngoại lệ để controller xử lý
            throw $e;
        }
    }
    function edit($data) {
        $v = "";
        foreach ($data as $key => $value) {
            if($key != 'customerNumber') { // Tránh cập nhật customerNumber
                $v .= $key."='".$this->connection->real_escape_string($value)."',";
            }
        }
        $v = rtrim($v, ",");
        $query = "UPDATE customers SET ".$v." WHERE customerNumber = ".intval($data['customerNumber']);
        return $this->connection->query($query);
    }
}