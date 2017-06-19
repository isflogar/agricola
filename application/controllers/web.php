<?php
	@session_start();
	class Web extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	    }

	    public function index(){
	    	$this->load->model("conocimientos_model");
	    	$r = $this->conocimientos_model->datos();

			$this->load->view("cliente/index", array("sembrios"=>$r));
		}

		public function login()
		{
			$this->load->view("head");
			$this->load->view("cliente/login");
			$this->load->view("footer", array("js"=>"login.js"));
		}
	}
?>