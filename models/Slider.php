<?php 
    require_once("Model.php");
    class Slider extends Model{
        function getAllActive(){
            $query = "SELECT * FROM sliders WHERE status = 1 ORDER BY id ASC";
            $data = array();
            $result = $this->connection->query($query);
            while($row = $result->fetch_assoc()) { 
                $data[] = $row;
            }
            return $data;
        }
        
        function getAll($limit, $offset){
            $query = "SELECT * FROM sliders ORDER BY id DESC LIMIT ".$offset.",".$limit;
            $data = array();
            $result = $this->connection->query($query);
            while($row = $result->fetch_assoc()) { 
                $data[] = $row;
            }
            return $data;
        }
        
        function getTotal(){
            $query = "SELECT COUNT(*) as total FROM sliders";
            $result = $this->connection->query($query);
            $row = $result->fetch_assoc();
            return $row['total'];
        }
        
        function find($id){
            $query = "SELECT * FROM sliders WHERE id = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        
        function create($data){
            $query = "INSERT INTO sliders (image, title, description, link, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("ssssi", $data['image'], $data['title'], $data['description'], $data['link'], $data['status']);
            return $stmt->execute();
        }
        
        function update($id, $data){
            $query = "UPDATE sliders SET image = ?, title = ?, description = ?, link = ?, status = ? WHERE id = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("ssssii", $data['image'], $data['title'], $data['description'], $data['link'], $data['status'], $id);
            return $stmt->execute();
        }
        
        function delete($id){
            $query = "DELETE FROM sliders WHERE id = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
    }
 ?>
