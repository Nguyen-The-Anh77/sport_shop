<?php 
    require_once("Model.php");
	class customer extends Model{
		var $table = 'customers';

		function find($id){
        	// Cau lenh truy van co so du lieu
		    $query = "SELECT * FROM ".$this->table." WHERE customerNumber = ".$id;

		    // Thuc thi cau lenh truy van co so du lieu

		    return $data = $this->connection->query($query)->fetch_assoc();
		}
		
		function delete($id){
        	// Cau lenh truy van co so du lieu
    		$query = "DELETE FROM ".$this->table." WHERE customerNumber = ".$id;

		    // Thuc thi cau lenh truy van co so du lieu
		    return $this->connection->query($query);
        }
	}
 ?>