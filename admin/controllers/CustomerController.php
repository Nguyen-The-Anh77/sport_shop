<?php 
    
	require_once('models/Customer.php');
	class CustomerController{
		var $cate_model;

		function __construct(){
			$this->cate_model = new customer();
		}

		public function list(){
			$data = array();
			$customers = $this->cate_model->All();
			require_once('views/customer/customer_list.php');
		}

		public function detail(){
			$id = isset($_GET['id'])?$_GET['id']:0;

			$cus = $this->cate_model->find($id);
			require_once('views/customer/customer_detail.php');
		}

		// public function add(){
		// 	require_once('views/customer/customer_add.php');		
		// }

		// public function store(){
		// 	$data = array();
		// 	$data['customerName'] = $_POST['customerName'];
		//     $data['email'] = $_POST['email'];
		//     $data['phone'] = $_POST['phone']; 
		//     $data['addressLine'] = $_POST['addressLine'];

		//     $status = $this->cate_model->create($data);

		//     if($status == true){
		//     	setcookie('msg','Thêm mới thành công',time()+1);
		//     	header('Location: ?mod=customer');
		//     }
		//     else {
		//     	setcookie('msg','Thêm mới không thành công',time()+1);
		//     	header('Location: ?mod=customer&act=add');
		//     }
		// }

		// public function update(){
		// 	$id = isset($_GET['id'])?$_GET['id']:0;
		// 	$cus = $this->cate_model->find($id);
		// 	require_once('views/customer/customer_update.php');		
		// }

		// public function edit(){
		// 	$data = array();
		// 	$data['id'] = $_POST['id'];
		// 	$data['customerName'] = $_POST['customerName'];
		//     $data['email'] = $_POST['email'];
		//     $data['phone'] = $_POST['phone']; 
		//     $data['addressLine'] = $_POST['addressLine'];

		//     $status = $this->cate_model->edit($data);

		//     if($status == true){
		//     	setcookie('msg','Cập nhật thành công',time()+1);
		//     	header('Location: ?mod=customer');
		//     }
		//     else {
		//     	setcookie('msg','Cập nhật không thành công',time()+1);
		//     	header('Location: ?mod=customer&act=update');
		//     }
		// }

		public function delete(){
			$id = isset($_GET['id'])?$_GET['id']:0;

		    $status = $this->cate_model->delete($id);
		    if($status == true){
		    	setcookie('msg','Xóa thành công',time()+1);
		    }
		    else 
		    	setcookie('msg','Xóa không thành công',time()+1);
		    header('Location: ?mod=customer');
		}
	}
 ?>