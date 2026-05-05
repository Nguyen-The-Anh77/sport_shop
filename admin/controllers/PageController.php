<?php 
	require_once('models/Model.php');
	class PageController{

		var $page_model;

		function __construct(){
			$this->page_model = new Model();
		}
		public function dashboard(){
			$data = array();
			$data = $this->page_model->Count();
			require_once('views/page/dashboard.php');
		}
		
	}
 ?>