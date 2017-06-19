<?php
	class Hechos extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	        $this->load->model("hechos_model");
	        $this->load->model("tipohecho_model");
	        $this->load->model("validateaccess_model");
	    }

		public function index()
		{
			$this->validateaccess_model->validate();
			$this->load->view("head",  array("menu"=>""));
			$this->load->view("menu_system", array("menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));

			$t_h = $this->tipohecho_model->datos("");
			$t_i = $this->db->from("tipo_investigacion")->where("estado", "A")->get()->result();

			$this->load->view("modulos/hecho", array("tipo_hecho"=>$t_h, "tipo_investigacion"=>$t_i));
			$this->load->view("footer",  array("js"=>"hecho.js"));
		}

		public function procesar()
		{
			$d = $this->input->post();
			$r = $this->hechos_model->procesar($d);
			echo $r;
		}

		public function eliminar(){
			$r = $this->hechos_model->eliminar($this->input->post('id_hechos'));
			echo $r;
		}

		public function datos(){
			$id = @$this->input->post("id");
			$r = $this->hechos_model->datos($id);
			echo json_encode($r);
		}

		/*public function buscar(){
			$r = $this->hechos_model->buscar($this->input->get("q"));
			echo json_encode($r);
		}*/
	}
?>