<?php 
	require_once('models/Order.php');
	class OrderController{
		var $order_model;

		function __construct(){
			$this->order_model = new order();
		}
		
		public function list(){
			$data = array();
			// Chi refresh view khi chua ton tai, khong refresh moi lan F5
			$data = $this->order_model->All();
			require_once('views/order/order_list.php');
		}

		public function detail(){
			$id = isset($_GET['id'])?$_GET['id']:0;
			$orders = array();
			$orders = $this->order_model->find($id);
			require_once('views/order/order_detail.php');
		}

		// public function update(){
		// 	$id = isset($_GET['id'])?$_GET['id']:0;
		// 	$order = $this->order_model->find($id);
		// 	require_once('views/order/order_update.php');		
		// }

		// public function edit(){
		// 	$data = array();
		// 	$data['id'] = $_POST['id'];
		// 	$data['status'] = isset($_POST['status']) ? $_POST['status'] : 'Pending';
		// 	$data['comments'] = isset($_POST['comments']) ? $_POST['comments'] : '';

		// 	// Câp nhât thông tin don hàng chính
		// 	$status = $this->order_model->updateOrder($data);
			
		// 	// Câp nhât chi tiêt don hàng (quantity và price)
		// 	foreach($_POST as $key => $value) {
		// 		if(strpos($key, 'quantity_') === 0) {
		// 			$productCode = str_replace('quantity_', '', $key);
		// 			$priceKey = 'price_' . $productCode;
					
		// 			$updateData = array();
		// 			$updateData['orderNumber'] = $data['id'];
		// 			$updateData['productCode'] = $productCode;
		// 			$updateData['quantityOrdered'] = $value;
		// 			$updateData['priceEach'] = isset($_POST[$priceKey]) ? $_POST[$priceKey] : 0;
					
		// 			$this->order_model->updateOrderDetail($updateData);
		// 		}
		// 	}
		    
		//     if($status == true){
		//     	setcookie('msg','Câp nhât thành công',time()+1);
		//     	header('Location: ?mod=order&act=detail&id=' . $data['id']);
		//     }
		//     else {
		//     	setcookie('msg','Câp nhât không thành công',time()+1);
		//     	header('Location: ?mod=order&act=update&id=' . $data['id']);
		//     }
		// }

		public function delete(){
			$id = isset($_GET['id'])?$_GET['id']:0;

		    $status = $this->order_model->delete($id);
		    if($status == true){
		    	setcookie('msg','Xóa thành công',time()+1);
		    }
		    else 
		    	setcookie('msg','Xóa không thành công',time()+1);
		    header('Location: ?mod=order&act=list');
		}
	}
 ?>