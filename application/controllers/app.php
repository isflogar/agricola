<?php
	@session_start();
	class App extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	        $this->load->model("validateaccess_model");
	        $this->load->model("conocimientos_model");
	        $this->load->model("hechos_model");
	    }

	    public function index(){
	    	$this->validateaccess_model->validate();

			$this->load->view("head");
			$this->load->view("menu_system", array("menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));

			$fun = $this->db->from("fundo")->where("id_usuario", (int)$_SESSION['id'])->where("estado", "A")->get()->result();

			$sembrio = $this->conocimientos_model->datos();
			$hecho = $this->hechos_model->datos("");

			$this->load->view("app", array("fundo"=>$fun, "sembrio"=>$sembrio, "hecho"=>$hecho));

			$this->load->view("footer",  array("js"=>"inicio.js"));
		}

		public function salir(){
			unset($_SESSION);
			session_destroy();
			redirect(base_url(), "refresh");
		}
	}
?>