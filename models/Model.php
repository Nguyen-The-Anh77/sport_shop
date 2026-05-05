 <?php 
	require_once('Connection.php');
	class Model{
		var $connection;
        var $table = '';

		function __construct(){
			$conn_obj = new Connection();
			$this->connection = $conn_obj->conn;
		}

		function All($line, $x, $y){
		    // Cau lenh truy van co so du lieu
		    $query = "SELECT p.*, s.sales_percent, pl.productLine FROM products p LEFT JOIN productLines pl ON pl.productLineCode = p.productLineCode LEFT JOIN sales s ON s.productCode = p.productCode WHERE pl.productLineCode = '".$line."' LIMIT ".$y.",".$x;
		    //print($query); die;
		    $data = array();

		    // Thuc thi cau lenh truy van co so du lieu
		    $result = $this->connection->query($query);

		    while($row = $result->fetch_assoc()) { 
		    	$data[] = $row;
		    }

		    return $data;
		}

		function Search($data, $x, $y){
		    // Cau lenh truy van co so du lieu
		    //$query = "SELECT p.*, s.sales_percent FROM products p LEFT JOIN sales s ON s.productCode = p.productCode  Where p.productName LIKE '%".$data."%' LIMIT ".$y.",".$x;
			$query = "SELECT * FROM findProduct_view Where productName LIKE '%".$data."%' LIMIT ".$y.",".$x;
			//print($query); die;
		    $data = array();

		    // Thuc thi cau lenh truy van co so du lieu
		    $result = $this->connection->query($query);

		    while($row = $result->fetch_assoc()) { 
		    	$data[] = $row;
		    }

		    return $data;
		}
		
		function Hot($x, $y){
		    // Cau lenh truy van co so du lieu
		    //$query = "SELECT p.*, s.sales_percent FROM products p LEFT JOIN sales s ON s.productCode = p.productCode  ORDER BY p.views DESC LIMIT ".$y.",".$x;
		    $query = "SELECT * FROM hot_view LIMIT ".$y.",".$x;
		    $data = array();

		    // Thuc thi cau lenh truy van co so du lieu
		    $result = $this->connection->query($query);

		    while($row = $result->fetch_assoc()) { 
		    	$data[] = $row;
		    }

		    return $data;
		}
		
		function Sale($x, $y){
		    // Cau lenh truy van co so du lieu - lay san pham co khuyen mai
		    $query = "SELECT * FROM hot_view WHERE sales_percent > 0 LIMIT ".$y.",".$x;
		    $data = array();

		    // Thuc thi cau lenh truy van co so du lieu
		    $result = $this->connection->query($query);

		    while($row = $result->fetch_assoc()) { 
		    	$data[] = $row;
		    }

		    return $data;
		}
		
        function find($id){
        	// Cau lenh truy van co so du lieu
		    //$query = "SELECT p.*, s.sales_percent FROM products p LEFT JOIN sales s ON s.productCode = p.productCode WHERE p.productCode = '".$id."'";
			$query = "SELECT * FROM findProduct_view  WHERE productCode = '".$id."'";
		    // Thuc thi cau lenh truy van co so du lieu

		    return $data = $this->connection->query($query)->fetch_assoc();
        }
	}
 ?>