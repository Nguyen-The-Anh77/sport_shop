<?php 
    require_once('../models/Slider.php');
    class SliderController{
        var $slider_model;

        function __construct(){
            $this->slider_model = new Slider();
        }

        public function list(){
            $data = array();
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;
            
            $data = $this->slider_model->getAll($limit, $offset);
            $total = $this->slider_model->getTotal();
            $total_pages = ceil($total / $limit);
            
            require_once('views/slider/slider_list.php');
        }

        public function add(){
            require_once('views/slider/slider_add.php');
        }

        public function store(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $title = $_POST['title'];
                $description = $_POST['description'];
                $link = $_POST['link'];
                $status = isset($_POST['status']) ? 1 : 0;
                
                // Xử lý upload ảnh
                $image = '';
                if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
                    $image = $this->uploadImage($_FILES['image']);
                }

                $data = array(
                    'image' => $image,
                    'title' => $title,
                    'description' => $description,
                    'link' => $link,
                    'status' => $status
                );

                $result = $this->slider_model->create($data);
                
                if($result){
                    $_SESSION['success'] = 'Thêm slider thành công!';
                    header('Location: ?mod=slider&act=list');
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                    header('Location: ?mod=slider&act=add');
                }
            }
        }

        public function edit(){
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if($id <= 0){
                require_once('views/page/404.php');
                return;
            }
            
            $slider = $this->slider_model->find($id);
            
            if(!$slider){
                require_once('views/page/404.php');
                return;
            }
            
            require_once('views/slider/slider_edit.php');
        }

        public function update(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $link = $_POST['link'];
                $status = isset($_POST['status']) ? 1 : 0;
                
                // Lấy thông tin slider hiện tại
                $current_slider = $this->slider_model->find($id);
                $image = $current_slider['image'];
                
                // Xử lý upload ảnh mới nếu có
                if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
                    // Xóa ảnh cũ
                    if($image && file_exists('../public/img/slider/' . basename($image))){
                        unlink('../public/img/slider/' . basename($image));
                    }
                    $image = $this->uploadImage($_FILES['image']);
                }

                $data = array(
                    'image' => $image,
                    'title' => $title,
                    'description' => $description,
                    'link' => $link,
                    'status' => $status
                );

                $result = $this->slider_model->update($id, $data);
                
                if($result){
                    $_SESSION['success'] = 'Cập nhật slider thành công!';
                    header('Location: ?mod=slider&act=list');
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                    header('Location: ?mod=slider&act=edit&id=' . $id);
                }
            }
        }

        public function delete(){
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if($id <= 0){
                require_once('views/page/404.php');
                return;
            }
            
            $slider = $this->slider_model->find($id);
            
            if(!$slider){
                require_once('views/page/404.php');
                return;
            }
            
            // Xóa ảnh nếu có
            if($slider['image'] && file_exists('../public/img/slider/' . basename($slider['image']))){
                unlink('../public/img/slider/' . basename($slider['image']));
            }
            
            $result = $this->slider_model->delete($id);
            
            if($result){
                $_SESSION['success'] = 'Xóa slider thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
            }
            
            header('Location: ?mod=slider&act=list');
        }

        private function uploadImage($file){
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'jfif','webp');
            $max_size = 5 * 1024 * 1024; // 5MB
            
            $filename = $file['name'];
            $filesize = $file['size'];
            $filetmp = $file['tmp_name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            if(!in_array(strtolower($filetype), $allowed_types)){
                $_SESSION['error'] = 'Chỉ chấp nhận file ảnh (jpg, jpeg, png, gif, jfif, webp)';
                return '';
            }
            
            if($filesize > $max_size){
                $_SESSION['error'] = 'Kích thước file không được vượt quá 5MB';
                return '';
            }
            
            // Tạo tên file mới
            $new_filename = 'slider_' . time() . '.' . $filetype;
            $upload_path = '../public/img/slider/' . $new_filename;
            
            if(move_uploaded_file($filetmp, $upload_path)){
                return 'public/img/slider/' . $new_filename;
            } else {
                $_SESSION['error'] = 'Không thể upload file';
                return '';
            }
        }
    }
 ?>
