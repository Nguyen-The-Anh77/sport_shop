<?php 
// Báo lỗi chi tiết
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once('models/Login.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

// // Hàm ghi log
// function writeLog($message) {
//     $logFile = __DIR__ . '/../logs/error.log';
//     $dir = dirname($logFile);
//     if (!file_exists($dir)) {
//         mkdir($dir, 0777, true);
//     }
//     $message = '[' . date('Y-m-d H:i:s') . '] ' . $message . "\n";
//     file_put_contents($logFile, $message, FILE_APPEND);
// }

class LoginController {
    private $login_model;

    public function __construct() {
        $this->login_model = new Login(); // Chú ý viết hoa chữ L
    }

    public function login() {
        require_once('views/page/login.php');
    }
    //GET: Dùng để lấy/thông tin, URL hiển thị trên thanh địa chỉ
    //POST: Dùng để gửi dữ liệu nhạy cảm (password, form data), không hiển thị trên URL

    public function login_action() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage('?mod=login&act=login', 'Phương thức không hợp lệ');
            return;
        }

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

    public function logout() {
        session_unset();
        session_destroy();
        $this->redirectWithMessage('?mod=page&act=home', 'Đã đăng xuất thành công');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage('?mod=login&act=login', 'Phương thức không hợp lệ');
            return;
        }

        try {
            // Lấy customerNumber lớn nhất hiện có
            $maxCustomerNumber = $this->login_model->getMaxCustomerNumber();
            $newCustomerNumber = $maxCustomerNumber + 1;

            // Lấy dữ liệu từ form
            $data = [
                'customerNumber' => $newCustomerNumber,
                'customerName' => trim(($_POST['lastName'] ?? '') . ' ' . ($_POST['firstName'] ?? '')),
                'contactFirstName' => trim($_POST['firstName'] ?? ''),
                'contactLastName' => trim($_POST['lastName'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => md5(trim($_POST['password'] ?? '')), // Mã hóa mật khẩu
                'phone' => trim($_POST['phone'] ?? ''),
                'addressLine1' => trim($_POST['addressLine1'] ?? ''),
                'city' => trim($_POST['city'] ?? ''),
                'country' => trim($_POST['country'] ?? 'Vietnam')
            ];

            // Validate dữ liệu
            $validationResult = $this->validateRegistration($data);
            if ($validationResult !== true) {
                throw new Exception($validationResult);
            }

            // Đăng ký người dùng mới
            $userId = $this->login_model->register($data);
            
            if ($userId) {
                // Lấy thông tin người dùng vừa đăng ký
                $user = $this->login_model->findByEmail($data['email']);
                if ($user) {
                    $_SESSION['isLogin'] = true;//Đánh dấu user đã đăng nhập vào hệ thống
                    $_SESSION['customer'] = $user;//Lưu thông tin user vào session
                    $this->redirectWithMessage('?mod=page&act=home', 'Đăng ký thành công!');
                    return;
                }
            }
            
            $this->redirectWithMessage('?mod=login&act=login', 'Đăng ký không thành công. Vui lòng thử lại sau');
            
        } catch (Exception $e) {
            $this->redirectWithMessage('?mod=login&act=login', $e->getMessage());
        }
    }

    public function edit() {
        if (!isset($_SESSION['isLogin']) || !isset($_SESSION['customer'])) {
            $this->redirectWithMessage('?mod=login&act=login', 'Vui lòng đăng nhập để tiếp tục');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage('?mod=page&act=home', 'Phương thức không hợp lệ');
            return;
        }

        $data = [
            'customerNumber' => $_SESSION['customer']['customerNumber'],
            'contactFirstName' => trim($_POST['firstName'] ?? ''),
            'contactLastName' => trim($_POST['lastName'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'addressLine1' => trim($_POST['address'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'country' => trim($_POST['country'] ?? 'Vietnam')
        ];

        if ($this->login_model->edit($data)) {
            $_SESSION['customer'] = array_merge($_SESSION['customer'], $data);
            $this->redirectWithMessage('?mod=page&act=home', 'Cập nhật thông tin thành công');
        } else {
            $this->redirectWithMessage('?mod=page&act=home', 'Cập nhật không thành công');
        }
    }

    private function validateRegistration($data) {
        if (empty($data['contactFirstName'])) {
            return 'Vui lòng nhập tên';
        }
        
        if (empty($data['contactLastName'])) {
            return 'Vui lòng nhập họ';
        }
        
        if (empty($data['email'])) {
            return 'Vui lòng nhập email';
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Email không hợp lệ';
        }
        
        if (empty($data['password'])) {
            return 'Vui lòng nhập mật khẩu';
        }
        
        if (strlen($data['password']) < 6) {
            return 'Mật khẩu phải có ít nhất 6 ký tự';
        }
        
        if (empty($data['phone'])) {
            return 'Vui lòng nhập số điện thoại';
        }
        
        // Validate định dạng số điện thoại (chỉ chứa số, độ dài 10-11 số)
        if (!preg_match('/^[0-9]{10,11}$/', $data['phone'])) {
            return 'Số điện thoại phải là số và có độ dài từ 10-11 số';
        }
        
        if (empty($data['addressLine1'])) {
            return 'Vui lòng nhập địa chỉ';
        }
        
        if (empty($data['city'])) {
            return 'Vui lòng nhập thành phố';
        }

        return true;
    }

    private function generateCustomerNumber() {
        return 'CUS' . time() . rand(100, 999);
    }

    private function redirectWithMessage($url, $message) {
        setcookie('msg', $message, time() + 5, '/');
        header('Location: ' . $url);
        exit;
    }
}