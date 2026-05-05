<?php 
	require_once('Connection.php');
	class login{
		var $connection;

		function __construct(){
			$conn_obj = new Connection();
			$this->connection = $conn_obj->conn;
		}
        
        function find($email, $password){
        	// Cau lenh truy van co so du lieu
		    $query = "SELECT
				  *
				FROM
				  employees
				WHERE email = '".$email."' AND password = '".md5($password)."'";

		    // Thuc thi cau lenh truy van co so du lieu

		    return $data = $this->connection->query($query)->fetch_assoc();
        }

	}
 ?>