<?php
	@session_start();
	class Modulo extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	        $this->load->model("modulo_model");
	        $this->load->model("validateaccess_model");
	    }

		public function index()
		{
			$this->validateaccess_model->validate();
			$this->load->view("head",  array("menu"=>""));
			$this->load->view("menu_system", array("menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));
			$this->load->view("modulos/modulo");
			$this->load->view("footer",  array("js"=>"modulo.js"));
		}

		public function procesar()
		{
			$d = $this->input->post();
			$r = $this->modulo_model->procesar($d);
			echo $r;
		}

		public function eliminar(){
			$r = $this->modulo_model->eliminar($this->input->post('id_modulo'));
			echo $r;
		}

		public function datos(){
			$id = @$this->input->post("id");
			$r = $this->modulo_model->datos($id);
			echo $r;
		}
	}
?>