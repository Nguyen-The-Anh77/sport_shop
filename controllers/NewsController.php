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
            $limit = 6;
            $offset = ($page - 1) * $limit;
            
            $data = $this->news_model->getAll($limit, $offset);
            $total = $this->news_model->getTotal();
            $total_pages = ceil($total / $limit);
            
            require_once('views/news/news_list.php');
        }

        public function detail(){
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if($id <= 0){
                require_once('views/page/error-404.php');
                return;
            }
            
            $news = $this->news_model->find($id);
            
            if(!$news){
                require_once('views/page/error-404.php');
                return;
            }
            
            // Tăng view count
            $this->news_model->increaseViews($id);
            
            // Lấy tin tức liên quan
            $related_news = $this->news_model->getRelated($id, 3);
            
            require_once('views/news/news_detail.php');
        }

        public function latest(){
            $data = array();
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
            $data = $this->news_model->getLatest($limit);
            
            if(isset($_GET['ajax']) && $_GET['ajax'] == 1){
                echo json_encode($data);
                exit;
            }
            
            require_once('views/news/latest_news.php');
        }
    }
 ?>
