<?php
	class Tipohecho extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	        $this->load->model("tipohecho_model");
	        $this->load->model("validateaccess_model");
	    }

		public function index()
		{
			$this->validateaccess_model->validate();
			$this->load->view("head",  array("menu"=>""));
			$this->load->view("menu_system", array("menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));
			$this->load->view("modulos/tipo_hecho");
			$this->load->view("footer",  array("js"=>"tipo_hecho.js"));
		}

		public function procesar()
		{
			$d = $this->input->post();
			$r = $this->tipohecho_model->procesar($d);
			echo $r;
		}

		public function eliminar(){
			$r = $this->tipohecho_model->eliminar($this->input->post('id_tipo_hecho'));
			echo $r;
		}

		public function datos(){
			$id = @$this->input->post("id");
			$r = $this->tipohecho_model->datos($id);
			echo json_encode($r);
		}

		/*public function buscar(){
			$r = $this->tipohecho_model->buscar($this->input->get("q"));
			echo json_encode($r);
		}*/
	}
?>