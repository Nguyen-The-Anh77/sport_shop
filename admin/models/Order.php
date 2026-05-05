<?php 
require_once("Model.php");

class Order extends Model {
    public $table = 'orderdetails';

    public function All() {
        // Query truc tiep khong dung view de tranh cache
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

        error_log("SO KET QUA: " . $result->num_rows);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { 
                $data[] = $row;
                error_log("ORDER DATE: " . $row['orderDate']);
            }
        }

        return $data;
    }

    public function find($id) {
        // Kiểm tra và tạo view nếu chưa tồn tại
        if (!$this->checkOrderViewExists()) {
            $this->createOrderView();
        }

        // Làm sạch và validate ID
        $id = $this->connection->real_escape_string($id);
        $id = intval($id);
        
        if ($id <= 0) {
            error_log("ID đơn hàng không hợp lệ: " . $id);
            return array(); // Trả về mảng rỗng thay vì null
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
        
        // Kiểm tra lỗi truy vấn
        if ($result === false) {
            error_log("Lỗi SQL: " . $this->connection->error);
            return array(); // Trả về mảng rỗng nếu có lỗi
        }

        $data = array();
        // Lấy tất cả các dòng kết quả
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row; // Lưu từng dòng kết quả vào mảng
            }
        }

        return $data; // Trả về mảng các sản phẩm trong đơn hàng
    }

    // Kiểm tra xem view order_view có tồn tại không
    public function checkOrderViewExists() {
        $query = "SHOW TABLES LIKE 'order_view'";
        $result = $this->connection->query($query);
        return $result && $result->num_rows > 0;
    }

    // Phương thức tạo view
    public function createOrderView() {
        // Kiểm tra và thay đổi kiểu dữ liệu cột orderDate nếu cần
        $this->updateOrderDateColumnType();
        
        // Xóa view cũ nếu tồn tại
        $this->connection->query("DROP VIEW IF EXISTS order_view");
        
        $query = "CREATE VIEW order_view AS
                 SELECT 
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
                 LEFT JOIN sales s ON s.productCode = p.productCode";
        
        $result = $this->connection->query($query);
        if ($result === false) {
            error_log("Lỗi khi tạo view order_view: " . $this->connection->error);
            return false;
        }
        return true;
    }
    
    // Phương thức cập nhật kiểu dữ liệu cột orderDate
    public function updateOrderDateColumnType() {
        // Kiểm tra kiểu dữ liệu hiện tại
        $checkQuery = "SHOW COLUMNS FROM orders WHERE Field = 'orderDate'";
        $result = $this->connection->query($checkQuery);
        
        if ($result && $result->num_rows > 0) {
            $column = $result->fetch_assoc();
            error_log("Kiểu dữ liệu orderDate hiện tại: " . $column['Type']);
            
            // Nếu là date, chuyển thành datetime
            if ($column['Type'] == 'date') {
                $alterQuery = "ALTER TABLE orders MODIFY COLUMN orderDate DATETIME NOT NULL";
                $alterResult = $this->connection->query($alterQuery);
                
                if ($alterResult) {
                    error_log("ĐÃ CHUYỂN kiểu dữ liệu orderDate từ date sang datetime THÀNH CÔNG");
                } else {
                    error_log("LỖI khi chuyển kiểu dữ liệu: " . $this->connection->error);
                }
            } else {
                error_log("orderDate đã là datetime, không cần chuyển");
            }
        } else {
            error_log("KHÔNG TÌM thấy cột orderDate");
        }
    }
    
    // Phương thức xóa đơn hàng
    public function delete($id) {
        // Làm sạch và validate ID
        $id = $this->connection->real_escape_string($id);
        $id = intval($id);
        
        if ($id <= 0) {
            error_log("ID đơn hàng không hợp lệ: " . $id);
            return false;
        }
        
        // Bắt đầu transaction
        $this->connection->begin_transaction();
        
        try {
            // Xóa các chi tiết đơn hàng trước
            $deleteDetailsQuery = "DELETE FROM orderdetails WHERE orderNumber = " . $id;
            $result1 = $this->connection->query($deleteDetailsQuery);
            
            if ($result1 === false) {
                error_log("Lỗi khi xóa orderdetails: " . $this->connection->error);
                throw new Exception("Không thể xóa chi tiết đơn hàng");
            }
            
            // Xóa đơn hàng
            $deleteOrderQuery = "DELETE FROM orders WHERE orderNumber = " . $id;
            $result2 = $this->connection->query($deleteOrderQuery);
            
            if ($result2 === false) {
                error_log("Lỗi khi xóa orders: " . $this->connection->error);
                throw new Exception("Không thể xóa đơn hàng");
            }
            
            // Commit transaction
            $this->connection->commit();
            error_log("Xóa thành công đơn hàng: " . $id);
            return true;
            
        } catch (Exception $e) {
            // Rollback transaction
            $this->connection->rollback();
            error_log("Lỗi khi xóa đơn hàng: " . $e->getMessage());
            return false;
        }
    }
    
    // Phương thức cập nhật thông tin đơn hàng
    public function updateOrder($data) {
        $id = $this->connection->real_escape_string($data['id']);
        $status = $this->connection->real_escape_string($data['status']);
        $comments = $this->connection->real_escape_string($data['comments']);
        
        $query = "UPDATE orders SET 
                    status = '$status',
                    comments = '$comments'
                  WHERE orderNumber = " . $id;
        
        $result = $this->connection->query($query);
        
        if ($result === false) {
            error_log("Lỗi khi cập nhật orders: " . $this->connection->error);
            return false;
        }
        
        error_log("Cập nhật thành công đơn hàng: " . $id);
        return true;
    }
    
    // Phương thức cập nhật chi tiết đơn hàng
    public function updateOrderDetail($data) {
        $orderNumber = $this->connection->real_escape_string($data['orderNumber']);
        $productCode = $this->connection->real_escape_string($data['productCode']);
        $quantityOrdered = $this->connection->real_escape_string($data['quantityOrdered']);
        $priceEach = $this->connection->real_escape_string($data['priceEach']);
        
        $query = "UPDATE orderdetails SET 
                    quantityOrdered = '$quantityOrdered',
                    priceEach = '$priceEach'
                  WHERE orderNumber = " . $orderNumber . " 
                  AND productCode = '$productCode'";
        
        $result = $this->connection->query($query);
        
        if ($result === false) {
            error_log("Lỗi khi cập nhật orderdetails: " . $this->connection->error);
            return false;
        }
        
        error_log("Cập nhật thành công chi tiết đơn hàng: " . $orderNumber . " - " . $productCode);
        return true;
    }
}
?>