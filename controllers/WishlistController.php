<?php
require_once('models/Product.php');

class WishlistController {
    private $product_model;

    function __construct() {
        $this->product_model = new Product();
    }

    public function list() {
        $data = array();
        if (isset($_SESSION['wishlist'])) {
            $data = $_SESSION['wishlist'];
        }
        require_once('views/wishlist/wishlist_list.php');
    }

    public function add() {
        // Lấy ID sản phẩm từ tham số URL
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        
        // Lấy thông tin sản phẩm từ model
        $product = $this->product_model->find($id);
        
        // Lấy thông tin khuyến mãi từ database
        $salesQuery = "SELECT sales_percent FROM sales WHERE productCode = '$id'";
        $salesResult = $this->product_model->connection->query($salesQuery);
        $sales_percent = 0;
        if ($salesResult && $salesResult->num_rows > 0) {
            $sales_percent = $salesResult->fetch_assoc()['sales_percent'];
        }
        
        // Thêm sales_percent vào thông tin sản phẩm
        $product['sales_percent'] = $sales_percent;

        // Kiểm tra xem sản phẩm đã có trong wishlist chưa
        if (isset($_SESSION['wishlist'][$id])) {
            // Nếu đã có, xóa khỏi wishlist
            unset($_SESSION['wishlist'][$id]);
            $message = 'Đã xóa sản phẩm yêu thích của bạn!';
            $action = 'removed';
        } else {
            // Nếu chưa có, thêm vào wishlist
            $_SESSION['wishlist'][$id] = $product;
            $message = 'Đã thêm vào danh sách yêu thích!';
            $action = 'added';
        }

        // Kiểm tra nếu là request AJAX
        if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $message,
                'action' => $action,
                'wishlist_count' => count($_SESSION['wishlist'])
            ]);
            exit;
        }

        // Lưu session trước khi redirect
        session_write_close();

        // Chuyển hướng về trang danh sách wishlist hoặc trang trước
        header('Location: ?mod=wishlist&act=list');
    }

    public function check() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $in_wishlist = isset($_SESSION['wishlist'][$id]);
        
        header('Content-Type: application/json');
        echo json_encode([
            'in_wishlist' => $in_wishlist
        ]);
        exit;
    }

    public function delete() {
        // Lấy mã sản phẩm được chọn
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $del = isset($_GET['del']) ? $_GET['del'] : 0;

        // Xóa sản phẩm khỏi wishlist
        if ($del == 1) {
            // Xóa tất cả
            unset($_SESSION['wishlist']);
            header("Location: ?mod=page&act=home");
        } else {
            // Xóa một sản phẩm
            unset($_SESSION['wishlist'][$id]);
            header("Location: ?mod=wishlist&act=list");
        }
    }
}
