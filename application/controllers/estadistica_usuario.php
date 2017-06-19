<?php
	@session_start();
	class Estadistica_usuario extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	        $this->load->model("validateaccess_model");
	        $this->load->model("fundo_model");
	    }

	    public function index(){
	    	$this->validateaccess_model->validate();

			$this->load->view("head");
			$this->load->view("menu_system", array("menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));

			$this->load->view("modulos/estadistica_usuario");

			$this->load->view("footer",  array("js"=>"estadistica_usuario.js"));
		}

		public function estadistica(){
			$users = $this->db->from("usuario")->where("estado", "A")->get()->result();

			$result = [];
			foreach ($users as $obj) {
				$result[$obj->nombre] = [];

				$lista_result = $this->fundo_model->porcentaje_fundo($obj->id_usuario);

				$result[$obj->nombre] = $lista_result;
			}

			$new_array = [];
			foreach ($result as $key => $obj) {
				$new_array[$key]=[];
				$obj = $this->orderMultiDimensionalArray($obj, "porcentaje", true);
				$new_array[$key] = $obj;
			}

			//$result = $this->orderMultiDimensionalArray($result, "porcentaje", true);

			echo json_encode($new_array);
		}

		function orderMultiDimensionalArray ($array, $campo, $invertir) {
		    $posicion = array();
		    $newRow = array();
		    foreach ($array as $key => $row) {
		            $posicion[$key]  = $row[$campo];
		            $newRow[$key] = $row;
		    }
		    if ($invertir) {
		        arsort($posicion);
		    }
		    else {
		        asort($posicion);
		    }
		    $arrayRetorno = array();
		    foreach ($posicion as $key => $pos) {
		        $arrayRetorno[] = $newRow[$key];
		    }
		    return $arrayRetorno;
		}
	}
?>