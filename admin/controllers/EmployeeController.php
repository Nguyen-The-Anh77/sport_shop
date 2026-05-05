<?php 
    
	require_once('models/Employee.php');
	class employeeController{
		var $cate_model;

		function __construct(){
			$this->cate_model = new employee();
		}

		public function list(){
			$data = array();
			$data = $this->cate_model->All();
			require_once('views/employee/employee_list.php');
		}

		public function detail(){
			$id = isset($_GET['id'])?$_GET['id']:0;

			$emp = $this->cate_model->find($id);
			require_once('views/employee/employee_detail.php');
		}

		public function add(){
			require_once('views/employee/employee_add.php');		
		}

		public function store(){
			$data = array();
			$data['employeeNumber'] = $_POST['id'];
			$data['lastName'] = $_POST['lastName'];
			$data['firstName'] = $_POST['firstName'];
		    $data['email'] = $_POST['email'];
		    $data['password'] = md5($_POST['password']);
		    $data['jobTitle'] = $_POST['position'];
		    $data['startDate'] = $_POST['startDate'];
		    $data['age'] = $_POST['age'];
		    $data['salary'] = $_POST['salary'];
		    $data['level'] = $_POST['level'];

		    // Kiểm tra employeeNumber trùng lặp
		    if ($this->cate_model->checkEmployeeNumberExists($data['employeeNumber'])) {
		    	setcookie('msg','Mã nhân viên đã tồn tại trong hệ thống!',time()+2);
		    	header('Location: ?mod=employee&act=add');
		    	exit;
		    }

		    // Kiểm tra email trùng lặp
		    if ($this->cate_model->checkEmailExists($data['email'])) {
		    	setcookie('msg','Email đã tồn tại trong hệ thống!',time()+2);
		    	header('Location: ?mod=employee&act=add');
		    	exit;
		    }

		    // Debug: In ra dữ liệu để kiểm tra
		    error_log("Dữ liệu nhân viên: " . print_r($data, true));

		    $status = $this->cate_model->create($data);

		    // Debug: Kiểm tra kết quả
		    error_log("Kết quả tạo nhân viên: " . ($status ? 'SUCCESS' : 'FAILED'));

		    if($status == true){
		    	setcookie('msg','Thêm mới thành công',time()+1);
		    	header('Location: ?mod=employee');
		    }
		    else {
		    	setcookie('msg','Thêm mới không thành công',time()+1);
		    	header('Location: ?mod=employee&act=add');
		    }
		}

		public function update(){
			$id = isset($_GET['id'])?$_GET['id']:0;
			$emp = $this->cate_model->find($id);
			require_once('views/employee/employee_update.php');		
		}

		public function edit(){
			$data = array();
			$data['employeeNumber'] = $_POST['id'];
			$data['lastName'] = $_POST['lastName'];
			$data['firstName'] = $_POST['firstName'];
		    $data['email'] = $_POST['email'];
		    if(md5($_POST['password']) != 'd41d8cd98f00b204e9800998ecf8427e') $data['password'] = md5($_POST['password']);
		    $data['jobTitle'] = $_POST['position'];
		    $data['startDate'] = $_POST['startDate'];
		    $data['age'] = $_POST['age'];
		    $data['salary'] = $_POST['salary'];

		    $status = $this->cate_model->edit($data);

		    if($status == true){
		    	setcookie('msg','Cập nhật thành công',time()+1);
		    	header('Location: ?mod=employee');
		    }
		    else {
		    	setcookie('msg','Cập nhật không thành công',time()+1);
		    	header('Location: ?mod=employee&act=update');
		    }
		}

		public function delete(){
			$id = isset($_GET['id'])?$_GET['id']:0;

		    $status = $this->cate_model->delete($id);
		    if($status == true){
		    	setcookie('msg','Xóa thành công',time()+1);
		    }
		    else 
		    	setcookie('msg','Xóa không thành công',time()+1);
		    header('Location: ?mod=employee');
		}
	}
 ?>