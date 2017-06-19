<?php
	@session_start();
	class Usuario extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	        $this->load->model("usuario_model");
	        $this->load->model("tipousuario_model");
	    }

		public function index()
		{
			$this->load->view("head",  array("menu"=>""));
			$this->load->view("menu_system", array("menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));
			$data = $this->usuario_model->datos();
			$t_u = $this->tipousuario_model->datos();
			$this->load->view("modulos/usuario", array("data"=>$data, "t_user"=>$t_u));
			$this->load->view("footer", array("js"=>"usuarios.js"));
		}

		public function procesar()
		{
			$d = $this->input->post();
			$r = $this->usuario_model->procesar($d);
			echo $r;
		}

		public function eliminar(){
			$r = $this->usuario_model->eliminar($this->input->post('id_usuario'));
			echo $r;
		}

		public function datos(){
			$r = $this->usuario_model->datos();
			echo json_encode($r);
		}

		public function validar_acceso(){
			$r = $this->usuario_model->validar_ingreso($this->input->post('usuario'), $this->input->post('clave'));
			echo $r;
		}
	}
?>