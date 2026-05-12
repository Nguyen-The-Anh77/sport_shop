<?php 
    require_once('models/Connection.php');
    class News{
        var $conn;

        function __construct(){
            $connection = new Connection();
            $this->conn = $connection->conn;
        }

        public function getAll($limit = 10, $offset = 0){
            $query = "SELECT * FROM news WHERE status = 1 ORDER BY created_at DESC LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }

        public function getTotal(){
            $query = "SELECT COUNT(*) as total FROM news WHERE status = 1";
            $result = $this->conn->query($query);
            $row = $result->fetch_assoc();
            return $row['total'];
        }

        public function find($id){
            $query = "SELECT * FROM news WHERE id = ? AND status = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows > 0){
                return $result->fetch_assoc();
            }
            return null;
        }

        public function increaseViews($id){
            $query = "UPDATE news SET views = views + 1 WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }

        public function getRelated($id, $limit = 3){
            $query = "SELECT * FROM news WHERE id != ? AND status = 1 ORDER BY created_at DESC LIMIT ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $id, $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }

        public function getLatest($limit = 5){
            $query = "SELECT * FROM news WHERE status = 1 ORDER BY created_at DESC LIMIT ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }

        public function getByCategory($category_id, $limit = 10, $offset = 0){
            $query = "SELECT * FROM news WHERE category_id = ? AND status = 1 ORDER BY created_at DESC LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iii", $category_id, $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }

        // Admin methods
        public function getAllAdmin($limit = 10, $offset = 0){
            $query = "SELECT * FROM news ORDER BY created_at DESC LIMIT ? OFFSET ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }

        public function getTotalAdmin(){
            $query = "SELECT COUNT(*) as total FROM news";
            $result = $this->conn->query($query);
            $row = $result->fetch_assoc();
            return $row['total'];
        }

        public function create($data){
            $query = "INSERT INTO news (title, slug, description, content, image, category_id, author, status, featured, tags, created_at, updated_at) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssssisiss", 
                $data['title'], 
                $data['slug'], 
                $data['description'], 
                $data['content'], 
                $data['image'], 
                $data['category_id'], 
                $data['author'], 
                $data['status'], 
                $data['featured'], 
                $data['tags']
            );
            return $stmt->execute();
        }

        public function update($id, $data){
            $query = "UPDATE news SET title = ?, slug = ?, description = ?, content = ?, image = ?, category_id = ?, status = ?, featured = ?, tags = ?, updated_at = NOW() 
                     WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssssisissi", 
                $data['title'], 
                $data['slug'], 
                $data['description'], 
                $data['content'], 
                $data['image'], 
                $data['category_id'], 
                $data['status'], 
                $data['featured'], 
                $data['tags'],
                $id
            );
            return $stmt->execute();
        }

        public function delete($id){
            $query = "DELETE FROM news WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
    }
 ?>
