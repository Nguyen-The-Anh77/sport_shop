<?php 
    require_once('models/Cart.php');
    require_once('models/Connection.php');
    
    if(isset( $_SESSION['cart']))
        $products = $_SESSION['cart'];
    else $products = null;

    // Tạo đơn hàng trong database trước
    $connection = new Connection();
    $cart_model = new Cart($connection->conn);
    
    error_log("Creating order from informail.php with products: " . print_r($products, true));
    $order_status = $cart_model->insert($products);
    error_log("Order creation status: " . ($order_status ? 'SUCCESS' : 'FAILED'));
    
    if($order_status) {
        require_once('views/cart/mail.php');

        $email = $_POST['email'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $contents = '<i>Thông tin khách hàng</i><p>Name: </p>'.$name.'<br/><p>SĐT: </p>'.$phone.'<br/><p>Email: </p>'.$email.'<br/><p>Địa chỉ: </p>'.$address.'<br/><i>Thông tin đơn hàng</i>';
        $subject = 'Chi tiết đơn hàng';
        
        $mail_status = send_email($email,$name,$contents,$subject);
        
        if($mail_status) {
            unset($_SESSION['cart']);
            unset($_SESSION['sum']);
            setcookie('msg','Đặt hàng thành công!!! Tiếp tục mua hàng nào!!!',time()+2);
        } else {
            setcookie('msg','Đơn hàng đã được tạo nhưng không gửi được email xác nhận!',time()+2);
        }
    } else {
        setcookie('msg','Không thể tạo đơn hàng. Vui lòng kiểm tra lại số lượng tồn kho!',time()+2);
    }
    
    header("Location: ?mod=page&act=home");
?>