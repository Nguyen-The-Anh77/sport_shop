<?php 
    
	require_once('models/product.php');
	class productController{
		var $prod_model;

		function __construct(){
			$this->prod_model = new product();
		}
		
		public function list(){
			$products = array();
			$products = $this->prod_model->All();
			require_once('views/product/product_list.php');
		}

		public function detail(){
			$id = isset($_GET['id'])?$_GET['id']:0;

			$prod = $this->prod_model->find($id);
			require_once('views/product/product_detail.php');
		}

		public function add(){
			require_once('views/product/product_add.php');		
		}

		public function store(){
			$data = array();
			$data['productCode'] = $_POST['id'];
			$data['productName'] = $_POST['productName'];
		    $data['buyPrice'] = $_POST['price'];
		    $data['productDescription'] = $_POST['productDescription'];
		    $data['quantityInStock'] = $_POST['quantityInStock'];
			$data['productLineCode'] = $_POST['productLineCode'];

		    // $target_dir = "public/img/";  // thư mục chứa file upload
		    // $thumbnail="";

		    // $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]); // link sẽ upload file lên

		    // $status_upload = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file);

		    // if ($status_upload) { // nếu upload file không có lỗi 
		    //     $thumbnail = basename( $_FILES["thumbnail"]["name"]);
		    // }
		    $data['image'] = $_POST['thumbnail'];

		    $status = $this->prod_model->create($data);

		    if($status == true){
		    	setcookie('msg','Thêm mới thành công',time()+1);
		    	header('Location: ?mod=product');
		    }
		    else {
		    	setcookie('msg','Thêm mới không thành công',time()+1);
		    	header('Location: ?mod=product&act=add');
		    }
		}

		public function update(){
			$id = isset($_GET['id'])?$_GET['id']:0;
			$product = $this->prod_model->find($id);
			require_once('views/product/product_update.php');		
		}

		public function edit(){
			$data = array();
			$data['productCode'] = $_POST['id'];
			$data['productName'] = $_POST['productName'];
		    $data['buyPrice'] = (int)$_POST['price'];
		    $data['productDescription'] = $_POST['productDescription'];
		    $data['quantityInStock'] = $_POST['quantityInStock'];
		    $data['productLineCode'] = $_POST['productLine'];
             
		    // $target_dir = "public/img/";  // thư mục chứa file upload
		    // $thumbnail="";

		    // $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]); // link sẽ upload file lên

		    // $status_upload = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file);

		    // if ($status_upload) { // nếu upload file không có lỗi 
		    //     $thumbnail = basename( $_FILES["thumbnail"]["name"]);
		    // }
		    // else $thumbnail = $_POST["thumnail"];

			//$data['image'] = $thumbnail;
            $data['image'] = $_POST['image'];

		    $status = $this->prod_model->edit($data);

		    if($status == true){
		    	setcookie('msg','Cập nhật thành công',time()+1);
		    	header('Location: ?mod=product');
		    }
		    else {
		    	setcookie('msg','Cập nhật không thành công',time()+1);
		    	header('Location: ?mod=product&act=update&id='.$data['productCode']);
		    }
		}

		public function delete(){
			$id = isset($_GET['id'])?$_GET['id']:0;

		    $status = $this->prod_model->delete($id);
		    if($status == true){
		    	setcookie('msg','Xóa thành công',time()+1);
		    }
		    else 
		    	setcookie('msg','Xóa không thành công',time()+1);
		    header('Location: ?mod=product');
		}
	}
 ?>