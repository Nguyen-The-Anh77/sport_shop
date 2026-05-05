<?php 
    require_once("Model.php");
	class employee extends Model{
		var $table = 'employees';

	function find($id){
		// Cau lenh truy van co so du lieu
		$query = "SELECT * FROM ".$this->table." WHERE employeeNumber = ".$id;

		// Thuc thi cau lenh truy van co so du lieu

		return $data = $this->connection->query($query)->fetch_assoc();
	}

	function create($data){
		$f = ""; // Lưu tên các cột
		$v = "";// Lưu giá trị tương ứng
		foreach ($data as $key => $value) {
			$f .= $key.",";
			$v .= "'".$value."',";
		}

		$f = trim($f,",");
		$v = trim($v,",");
		
		// Cau lenh truy van co so du lieu
		$query = "INSERT INTO ".$this->table."(".$f.") VALUES (".$v.");";
		
		// Debug: In ra câu SQL
		error_log("Câu SQL INSERT: " . $query);
		
		// Thuc thi cau lenh truy van co so du lieu
		$result = $this->connection->query($query);
		
		// Debug: Kiểm tra lỗi SQL
		if (!$result) {
			error_log("Lỗi SQL: " . $this->connection->error);
		}
		
		return $result;
	}

	function edit($data){
		$v = "";
		foreach ($data as $key => $value) {
			$v .= $key."='".$value."',";
		}
		$v = trim($v,",");
		// Cau lenh truy van co so du lieu
		$query = "UPDATE ".$this->table." SET ".$v." WHERE employeeNumber =".$data['employeeNumber'];
		//print($query); die;
		// Thuc thi cau lenh truy van co so du lieu
		return $this->connection->query($query);
	}

	function delete($id){
		// Cau lenh truy van co so du lieu
		$query = "DELETE FROM ".$this->table." WHERE employeeNumber = ".$id;

		// Thuc thi cau lenh truy van co so du lieu
		return $this->connection->query($query);
	}

	function checkEmailExists($email){
		// Cau lenh truy van co so du lieu
		$query = "SELECT COUNT(*) as count FROM ".$this->table." WHERE email = '".$email."'";
		
		// Thuc thi cau lenh truy van co so du lieu
		$result = $this->connection->query($query);
		$row = $result->fetch_assoc();
		
		return $row['count'] > 0;
	}

	function checkEmployeeNumberExists($employeeNumber){
		// Cau lenh truy van co so du lieu
		$query = "SELECT COUNT(*) as count FROM ".$this->table." WHERE employeeNumber = '".$employeeNumber."'";
		
		// Thuc thi cau lenh truy van co so du lieu
		$result = $this->connection->query($query);
		$row = $result->fetch_assoc();
		
		return $row['count'] > 0;
	}
}
 ?>