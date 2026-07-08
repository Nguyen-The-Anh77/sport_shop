<?php 
    require_once("Model.php");
    class Cart extends Model {
        function insert($datas) {
            // Kiểm tra nếu không có sản phẩm nào
            if (empty($datas)) {
                return false;
            }

            try {
                // Bắt đầu giao dịch
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
                    if (!isset($data['productCode']) || trim($data['productCode']) === '') {
                        throw new Exception("Thiếu mã sản phẩm trong giỏ hàng");
                    }

                    $productCode = $this->connection->real_escape_string(trim($data['productCode']));
                    $quantity = (int)($data['SoLuong'] ?? 1);
                    $priceEach = isset($data['buyPrice']) ? $data['buyPrice'] : 0;

                    if ($quantity <= 0) {
                        throw new Exception("Số lượng đặt hàng không hợp lệ cho sản phẩm $productCode");
                    }
                    
                    // Lấy thông tin sản phẩm và tồn kho
                    $checkQuery = "SELECT quantityInStock FROM products WHERE productCode = '$productCode'";
                    $checkResult = $this->connection->query($checkQuery);
                    
                    if ($checkResult === false) {
                        throw new Exception("Lỗi khi kiểm tra tồn kho: " . $this->connection->error);
                    }

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
                    
                    // Debug log
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
    }
?>