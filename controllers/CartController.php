 
 <?php
require_once('models/Cart.php');
require_once('models/Product.php'); // Thêm dòng này

class CartController {
    private $cart_model;
    private $product_model; // Thêm thuộc tính mới

    function __construct() {
        $this->cart_model = new Cart(); // Sửa tên class thành viết hoa
        $this->product_model = new Product(); // Khởi tạo Product model
    }

    public function list() {
        $data = array();
        require_once('views/cart/cart_list.php');
    }

    public function add() {
        // Lấy ID sản phẩm từ tham số URL, mặc định là 0 nếu không có
        $id = isset($_GET['id'])?$_GET['id']:0;
        
        // Lấy thông tin sản phẩm từ model
        $product = $this->product_model->find($id);
        
        // Lấy thông tin khuyến mãi từ database
        $salesQuery = "SELECT sales_percent FROM sales WHERE productCode = '$id'";
        $salesResult = $this->cart_model->connection->query($salesQuery);
        $sales_percent = 0;
        if ($salesResult && $salesResult->num_rows > 0) {
            $sales_percent = $salesResult->fetch_assoc()['sales_percent'];
        }
        
        // Thêm sales_percent vào thông tin sản phẩm
        $product['sales_percent'] = $sales_percent;

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        if (isset($_SESSION['cart'][$id])) {
            // Nếu đã có, tăng số lượng lên 1
            $_SESSION['cart'][$id]['SoLuong']++;
        } else {
            // Nếu chưa có trong giỏ hàng
            // Thêm trường SoLuong = 1 vào thông tin sản phẩm
            $product['SoLuong'] = 1;

            // Thêm sản phẩm vào giỏ hàng (lưu trong session)
            $_SESSION['cart'][$id] = $product;
        }

        // Chuyển hướng về trang xem giỏ hàng
        header('Location: ?mod=cart&act=list');
    }
    public function delete(){
			
			// B1: Lấy mã sản phẩm được chọn
			$id = isset($_GET['id'])?$_GET['id']:0;
			$del = $_GET['del'];

			// Bước 2: Kiểm tra id và Xóa sản phẩm khỏi giỏ hàng
			if($del==1){
				unset($_SESSION['cart']);
				header("Location: ?mod=page&act=home");
			}
			else 
				if($del==2){
				    unset($_SESSION['cart'][$id]);
				    header("Location: ?mod=cart&act=list");
			    }
				// Kiểm tra số lượng
				else
					if($_SESSION['cart'][$id]['SoLuong'] > 1){
						// Giảm số lượng
						$_SESSION['cart'][$id]['SoLuong']--;
						header("Location: ?mod=cart&act=list");
					}else{
						// Bước 2: Xóa sản phẩm khỏi giỏ hàng
						unset($_SESSION['cart'][$id]);
						header("Location: ?mod=cart&act=list");
					}
		}
		public function order(){
			if(isset( $_SESSION['cart']))
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
			
			// Truyền dữ liệu vào view
			require_once('views/cart/infor.php');
		}

		public function send(){
			require_once('views/cart/informail.php');
		}
}