<?php 
    
	require_once('models/Product.php');
	class ProductController{
		var $cate_model;

		function __construct(){
			$this->cate_model = new product();
		}

		public function list(){
			$data = array();
			$line = $_GET['line'];
			$data = $this->cate_model->All($line, 12,0);
			require_once('views/product/product_list.php');
		}

		// public function detail(){
		// 	$id = isset($_GET['id'])?$_GET['id']:0;

		// 	$data = $this->cate_model->find($id);
		// 	require_once('views/product/product_detail.php');
		// }

		public function detail(){
			$productCode = isset($_GET['id'])?$_GET['id']:0;
			
			// Tăng view count trước
			$viewsData = array(
				'productCode' => $productCode,
				'views' => 1 // Tăng lên 1
			);
			$this->cate_model->increase($viewsData);
			
			// Lấy thông tin sản phẩm với views đã được cập nhật
			$data = $this->cate_model->find($productCode);
			
			require_once('views/product/product_detail.php');
		}
	}
 ?>