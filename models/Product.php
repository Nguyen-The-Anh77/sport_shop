<?php 
    require_once("Model.php");
	class product extends Model{
		function increase($data){
        	// Sử dụng prepared statement để tránh SQL injection
        	$query = "UPDATE products SET views = views + ? WHERE productCode = ?";
        	$stmt = $this->connection->prepare($query);
        	$stmt->bind_param("is", $data["views"], $data['productCode']);
		    return $stmt->execute();
        }
		public function find($id) {
        $query = "SELECT * FROM products WHERE productCode = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
	}
 ?>