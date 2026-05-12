<?php 
    require_once('models/News.php');
    class NewsController{
        var $news_model;

        function __construct(){
            $this->news_model = new News();
        }

        public function list(){
            $data = array();
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;
            
            $data = $this->news_model->getAllAdmin($limit, $offset);
            $total = $this->news_model->getTotalAdmin();
            $total_pages = ceil($total / $limit);
            
            require_once('views/news/news_list.php');
        }

        public function add(){
            require_once('views/news/news_add.php');
        }

        public function store(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $title = $_POST['title'];
                $slug = $this->createSlug($title);
                $description = $_POST['description'];
                $content = $_POST['content'];
                $category_id = $_POST['category_id'];
                $author = $_SESSION['admin']['firstName'] . ' ' . $_SESSION['admin']['lastName'];
                $status = isset($_POST['status']) ? 1 : 0;
                $featured = isset($_POST['featured']) ? 1 : 0;
                $tags = $_POST['tags'];
                
                // Xử lý upload ảnh
                $image = '';
                if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
                    $image = $this->uploadImage($_FILES['image']);
                }

                $data = array(
                    'title' => $title,
                    'slug' => $slug,
                    'description' => $description,
                    'content' => $content,
                    'image' => $image,
                    'category_id' => $category_id,
                    'author' => $author,
                    'status' => $status,
                    'featured' => $featured,
                    'tags' => $tags
                );

                $result = $this->news_model->create($data);
                
                if($result){
                    $_SESSION['success'] = 'Thêm tin tức thành công!';
                    header('Location: ?mod=news&act=list');
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                    header('Location: ?mod=news&act=add');
                }
            }
        }

        public function edit(){
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if($id <= 0){
                require_once('views/page/404.php');
                return;
            }
            
            $news = $this->news_model->find($id);
            
            if(!$news){
                require_once('views/page/404.php');
                return;
            }
            
            require_once('views/news/news_edit.php');
        }

        public function update(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id = $_POST['id'];
                $title = $_POST['title'];
                $slug = $this->createSlug($title);
                $description = $_POST['description'];
                $content = $_POST['content'];
                $category_id = $_POST['category_id'];
                $status = isset($_POST['status']) ? 1 : 0;
                $featured = isset($_POST['featured']) ? 1 : 0;
                $tags = $_POST['tags'];
                
                // Lấy thông tin tin tức hiện tại
                $current_news = $this->news_model->find($id);
                $image = $current_news['image'];
                
                // Xử lý upload ảnh mới nếu có
                if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
                    // Xóa ảnh cũ
                    if($image && file_exists('../public/img/news/' . $image)){
                        unlink('../public/img/news/' . $image);
                    }
                    $image = $this->uploadImage($_FILES['image']);
                }

                $data = array(
                    'title' => $title,
                    'slug' => $slug,
                    'description' => $description,
                    'content' => $content,
                    'image' => $image,
                    'category_id' => $category_id,
                    'status' => $status,
                    'featured' => $featured,
                    'tags' => $tags
                );

                $result = $this->news_model->update($id, $data);
                
                if($result){
                    $_SESSION['success'] = 'Cập nhật tin tức thành công!';
                    header('Location: ?mod=news&act=list');
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                    header('Location: ?mod=news&act=edit&id=' . $id);
                }
            }
        }

        public function delete(){
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if($id <= 0){
                require_once('views/page/404.php');
                return;
            }
            
            $news = $this->news_model->find($id);
            
            if(!$news){
                require_once('views/page/404.php');
                return;
            }
            
            // Xóa ảnh nếu có
            if($news['image'] && file_exists('../public/img/news/' . $news['image'])){
                unlink('../public/img/news/' . $news['image']);
            }
            
            $result = $this->news_model->delete($id);
            
            if($result){
                $_SESSION['success'] = 'Xóa tin tức thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
            }
            
            header('Location: ?mod=news&act=list');
        }

        public function detail(){
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if($id <= 0){
                require_once('views/page/404.php');
                return;
            }
            
            $news = $this->news_model->find($id);
            
            if(!$news){
                require_once('views/page/404.php');
                return;
            }
            
            require_once('views/news/news_detail.php');
        }

        private function createSlug($title){
            $slug = strtolower($title);
            $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
            $slug = preg_replace('/[\s-]+/', '-', $slug);
            $slug = trim($slug, '-');
            return $slug;
        }

        private function uploadImage($file){
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            $max_size = 5 * 1024 * 1024; // 5MB
            
            $filename = $file['name'];
            $filesize = $file['size'];
            $filetmp = $file['tmp_name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            if(!in_array(strtolower($filetype), $allowed_types)){
                $_SESSION['error'] = 'Chỉ chấp nhận file ảnh (jpg, jpeg, png, gif)';
                return '';
            }
            
            if($filesize > $max_size){
                $_SESSION['error'] = 'Kích thước file không được vượt quá 5MB';
                return '';
            }
            
            // Tạo tên file mới
            $new_filename = 'news_' . time() . '.' . $filetype;
            $upload_path = '../public/img/news/' . $new_filename;
            
            if(move_uploaded_file($filetmp, $upload_path)){
                return $new_filename;
            } else {
                $_SESSION['error'] = 'Không thể upload file';
                return '';
            }
        }
    }
 ?>
