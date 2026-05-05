<?php 
    
	require_once('models/Model.php');
	class PageController{
		var $page_model;

		function __construct(){
			$this->page_model = new Model();
		}

		public function home(){
			$data_hot = array();
			$data_hot = $this->page_model->Hot(8,0);
			$data_hots = array();
			$data_hots = $this->page_model->Sale(8,0);
			require_once('views/page/home.php');
		}

		public function search(){
			$data = $_POST['data'];
			$data_search = array();
			$data_search = $this->page_model->Search($data, 8, 0);
			$data_searchs = array();
			$data_searchs = $this->page_model->Search($data, 4, 0);
			require_once('views/page/search.php');
		}

		public function about(){
			require_once('views/page/about.php');
		}
		public function account(){
			require_once('views/page/my-account.php');
		}
	}
 ?>