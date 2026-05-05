 <?php 
	require_once('Connection.php');
	class Model{
		var $connection;
        var $table = '';

		function __construct(){
			$conn_obj = new Connection();
			$this->connection = $conn_obj->conn;
		}

		function All(){
		    // Cau lenh truy van co so du lieu
		    $query = "SELECT * FROM ".$this->table;

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
		    $query = "SELECT * FROM ".$this->table." WHERE id=".$id;

		    // Thuc thi cau lenh truy van co so du lieu

		    return $data = $this->connection->query($query)->fetch_assoc();
        }

        function create($data){
        	$f = "";
        	$v = "";
        	foreach ($data as $key => $value) {
        		$f .= $key.",";
        		$v .= "'".$value."',";
        	}

        	$f = trim($f,",");
        	$v = trim($v,",");
        	
        	// Cau lenh truy van co so du lieu
        	$query = "INSERT INTO ".$this->table."(".$f.") VALUES (".$v.");";
		    
		    // Thuc thi cau lenh truy van co so du lieu
		    return $this->connection->query($query);
        }

        function edit($data){
        	$v = "";
            foreach ($data as $key => $value) {
            	$v .= $key."='".$value."',";
            }
            $v = trim($v,",");
        	// Cau lenh truy van co so du lieu
        	$query = "UPDATE ".$this->table." SET ".$v." WHERE id =".$data['id'];

		    // Thuc thi cau lenh truy van co so du lieu
		    return $this->connection->query($query);
        }

        function delete($id){
        	// Cau lenh truy van co so du lieu
    		$query = "DELETE FROM ".$this->table." WHERE id = ".$id;

		    // Thuc thi cau lenh truy van co so du lieu
		    return $this->connection->query($query);
		}
		
		function Count(){
		    // Cau lenh truy van co so du lieu
			$query1 = "SELECT count(*) FROM employees";
			$query2 = "SELECT count(*) FROM customers";
			$query3 = "SELECT count(*) FROM orderdetails";
			$query4 = "SELECT count(*) FROM products";

			$data = array();

		    // Thuc thi cau lenh truy van co so du lieu
		    $result1 = $this->connection->query($query1);
			$result2 = $this->connection->query($query2);
			$result3 = $this->connection->query($query3);
			$result4 = $this->connection->query($query4);

		    while($row = $result1->fetch_assoc()) { 
		    	$data[] = $row;
			}
			while($row = $result2->fetch_assoc()) { 
		    	$data[] = $row;
			}
			while($row = $result3->fetch_assoc()) { 
		    	$data[] = $row;
			}
			while($row = $result4->fetch_assoc()) { 
		    	$data[] = $row;
		    }
			//print_r($data);die;
		    return $data;
		}
	}
 ?>