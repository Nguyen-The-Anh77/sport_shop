<?php
    error_reporting(E_ALL);
ini_set('display_errors', 1); 
    session_start();
	$mod = (isset($_GET['mod'])?$_GET['mod']:'page');
	$act = (isset($_GET['act'])?$_GET['act']:(isset($_POST['act'])?$_POST['act']:'list'));

	switch ($mod) {
		case 'login':
			require_once('controllers/LoginController.php');
			$controller_obj = new LoginController();
			switch ($act) {
				case 'login':
					$controller_obj->login();
					break;
				case 'login_action':
					$controller_obj->login_action();
					break;
				case 'logout':
					$controller_obj->logout();
					break;
				case 'register':
					$controller_obj->store();
					break;
				case 'edit':
					$controller_obj->edit();
					break;
				default:
					require_once('views/page/error-404.php');
					break;
			}
			break;
		case 'product':
			require_once('controllers/ProductController.php');
			$controller_obj = new ProductController();
			switch ($act) {
				case 'list':
					$controller_obj->list();
					break;
				case 'detail':
					$controller_obj->detail();
					break;
				default:
					require_once('views/page/error-404.php');
					break;
			}
			break;	
		case 'page':
			require_once('controllers/PageController.php');
			$controller_obj = new PageController();
			switch ($act) {
				case 'home':
					$controller_obj->home();
					break;
				case 'about':
					$controller_obj->about();
					break;
				case 'search':
					$controller_obj->search();
					break;
				case 'account':
					$controller_obj->account();
					break;
				default:
					require_once('views/page/error-404.php');
					break;
			}
			break;	
		case 'cart':
		    checkAuth();
			require_once('controllers/CartController.php');
			$controller_obj = new CartController();
			switch ($act) {
				case 'list':
					$controller_obj->list();
					break;
				case 'add':
					$controller_obj->add();
					break;
				case 'delete':
				    $controller_obj->delete();
					break;
				case 'order':
					$controller_obj->order();
					break;
				case 'mail':
					$controller_obj->mail();
					break;
				case 'sendMail':
					$controller_obj->send();
					break;
				default:
					require_once('views/page/error-404.php');
					break;
			}
			break;	
		case 'news':
			require_once('controllers/NewsController.php');
			$controller_obj = new NewsController();
			switch ($act) {
				case 'list':
					$controller_obj->list();
					break;
				case 'detail':
					$controller_obj->detail();
					break;
				case 'latest':
					$controller_obj->latest();
					break;
				default:
					require_once('views/page/error-404.php');
					break;
			}
			break;	
		default:
			require_once('views/page/error-404.php');
			break;
	}
    

	function checkAuth(){
    	if(empty($_SESSION['isLogin'])){
        	header('Location: ?mod=login&act=login');
    	}
    }
 ?>