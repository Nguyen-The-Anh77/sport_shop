<?php 
	$mod = (isset($_GET['mod'])?$_GET['mod']:'');
	$act = (isset($_GET['act'])?$_GET['act']:'list');

	function checkAuth(){
		session_start();
    	if(empty($_SESSION['isLogin'])){
        	header('Location: ?mod=login&act=login');
    	}
    }

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
				default:
					require_once('views/page/404.php');
					break;
			}
			break;
		case 'page':
		    checkAuth();
		    require_once('controllers/PageController.php');
		    $controller_obj = new PageController();
		    switch ($act) {
		    	case 'dashboard':
		    		$controller_obj->dashboard();
		    		break;
		    	default:
		    		require_once('views/page/404.php');
		    		break;
		    }
		case 'employee':
		    checkAuth();
			require_once('controllers/EmployeeController.php');
			$controller_obj = new EmployeeController();
			switch ($act) {
				case 'list':
					$controller_obj->list();
					break;
				case 'add':
					$controller_obj->add();
					break;
				case 'store':
					$controller_obj->store();
					break;
				case 'detail':
					$controller_obj->detail();
					break;
				case 'update':
					$controller_obj->update();
					break;
				case 'edit':
					$controller_obj->edit();
					break;
				case 'delete':
					$controller_obj->delete();
					break;		
				default:
					require_once('views/page/404.php');
					break;
			}
			break;
		case 'customer':
		    checkAuth();
			require_once('controllers/CustomerController.php');
			$controller_obj = new CustomerController();
			switch ($act) {
				case 'list':
					$controller_obj->list();
					break;
				case 'add':
					$controller_obj->add();
					break;
				case 'store':
					$controller_obj->store();
					break;
				case 'detail':
					$controller_obj->detail();
					break;
				case 'update':
					$controller_obj->update();
					break;
				case 'edit':
					$controller_obj->edit();
					break;
				case 'delete':
					$controller_obj->delete();
					break;		
				default:
					require_once('views/page/404.php');
					break;
			}
			break;
		case 'order':
		    checkAuth();
			require_once('controllers/OrderController.php');
			$controller_obj = new OrderController();
			switch ($act) {
				case 'list':
					$controller_obj->list();
					break;
				case 'detail':
					$controller_obj->detail();
					break;
				case 'update':
					$controller_obj->update();
					break;
				case 'edit':
					$controller_obj->edit();
					break;
				case 'delete':
					$controller_obj->delete();
					break;		
				default:
					require_once('views/page/404.php');
					break;
			}
			break;
		case 'product':
			checkAuth();
			require_once('controllers/ProductController.php');
			$controller_obj = new ProductController();
			switch ($act) {
				case 'list':
					$controller_obj->list();
					break;
				case 'add':
					$controller_obj->add();
					break;
				case 'store':
					$controller_obj->store();
					break;
				case 'detail':
					$controller_obj->detail();
					break;
				case 'update':
					$controller_obj->update();
					break;
				case 'edit':
					$controller_obj->edit();
					break;
				case 'delete':
					$controller_obj->delete();
					break;		
				default:
					require_once('views/page/404.php');
					break;
			}
			break;
		default:
			require_once('views/page/404.php');
			break;
	}

	
 ?>