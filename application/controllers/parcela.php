<?php
	@session_start();
	class Parcela extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	        $this->load->model("parcela_model");
	        $this->load->model("conocimientos_model");
	        $this->load->model("validateaccess_model");
	    }

		public function index()
		{
			/*$this->validateaccess_model->validate();
			$this->load->view("head",  array("menu"=>""));
			$this->load->view("menu_system", array("menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));
			$this->load->view("modulos/parce");
			$this->load->view("footer",  array("js"=>"parce.js"));*/
		}

		public function agregar()
		{
			$d = $this->input->post();
			$r = $this->parcela_model->agregar($d);
			echo $r;
		}

		public function eliminar(){
			$r = $this->parcela_model->eliminar($this->input->post('id_parcela'));
			echo json_encode($r);
		}

		public function datos(){
			$id = @$this->input->post("id_fundo");
			$r = $this->parcela_model->datos($id);
			echo json_encode($r);
		}

		function lista_sembrio(){
			$r = $this->parcela_model->lista_sembrio($this->input->post("id_parcela"));
			echo json_encode($r);
		}

		function agregar_sembrio(){
			$r = $this->parcela_model->agregar_sembrio($this->input->post());
			echo $r;
		}

		function quitar_sembrio(){
			$r = $this->parcela_model->quitar_sembrio($this->input->post("id_parcela_conocimiento"));
			echo $r;
		}

		//PROPIEDADES X PARCELA
		function lista_propiedad(){
			$r = $this->parcela_model->lista_propiedad($this->input->post("id_parcela"));
			echo json_encode($r);
		}

		function agregar_propiedad(){
			$r = $this->parcela_model->agregar_propiedad($this->input->post());
			echo $r;
		}

		function quitar_propiedad(){
			$r = $this->parcela_model->quitar_propiedad($this->input->post("id_parcela_hechos"));
			echo $r;
		}

		//PORCENTAJE SEMBRIO X PARCELA
		function porcentaje($id){
			//CODE PARA HACER MAGIA DEL UMBRAL :v-------------------<<<<<<<<<<<<<<<<<<<
			$id_parcela = $id;

			$propiedades = [];//LISTA IDS DE HECHOS DE ACUERDO A LAS PROPIEDADES DE LA PARCELA A ESTUDIAR

			$propiedad_parcela = $this->db->from("parcela_hechos")
			->join("parcela", "parcela.id_parcela = parcela_hechos.id_parcela")
			->where("parcela_hechos.id_parcela", $id_parcela)
			->where("parcela_hechos.estado", "A")
			->get()->result();

			$hectareas = $propiedad_parcela[0]->dimension;

			foreach ($propiedad_parcela as $obj) {
				$propiedades[] = (int)$obj->id_hechos;
			}

            $data = $this->db->from("conocimiento")->where("estado", "A")->get();
            $data = $data->result();//Obtener todos los conocimientos

            $result = [];

			$umbral_parcela = 0;

			//echo $umbral;
            foreach ($data as $k) {
                $data2 = $this->conocimientos_model->hechoyconocimiento($k->id_conocimiento);//Obtener todos los hechos que tiene 1 conocimiento
                $suma = 0;
                $umbral_conocimiento = 0;
                foreach ($data2 as $j) {
                	$umbral_hecho = 0;

                    if($j->estado=="A"){
                        $umbral_hecho += $j->peso;
                        if(in_array($j->id_hechos, $propiedades)){
                            $suma += $j->peso;
                            $umbral_parcela += $j->peso;
                        }
                    }

                    $umbral_conocimiento += $j->peso;
                }

                $result[] = array(
                        "id_p"=>$k->id_conocimiento,
                        "imagen"=>$k->imagen,
                        "nombre"=>$k->conocimiento,
                        "peso"=>$suma,
                        "suma_conocimiento" => $umbral_conocimiento,
                        "color"=>$k->color,
                        "hectareas" => $hectareas
                );

            }

            for ($i=0; $i < count($result) ; $i++) {
            	$result[$i]["porcentaje"] = round($result[$i]["peso"]*100/$umbral_parcela,2);
            }

            /*echo "<pre>";
			print_r($result);
			return;*/

			$new = $this->orderMultiDimensionalArray($result, "porcentaje", true);

			return $new;
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

		function data_parcela_procentaje(){
			$id_parcela = $this->input->post("id_parcela");

			$data = $this->db->from("parcela")
			->join("fundo", "fundo.id_fundo = parcela.id_fundo")
			->join("tipo_investigacion", "tipo_investigacion.id_tipo_investigacion = parcela.id_tipo_investigacion")
			->where("parcela.id_parcela", $id_parcela)
			->select("fundo.nro as nro_fundo, parcela.nro as nro_parcela, tipo_investigacion.descripcion_tipo_investigacion as tipo_investigacion")
			->get()->result();

			$new = [];
			$new[] = $data;

			$por = $this->porcentaje($id_parcela);

			$new[] = $por;


			echo json_encode($new);
		}

		/*function view_procentaje_parcela(){
			$this->load->view("cliente/parcela_procentaje");
		}*/

		function encuesta(){
			$r = $this->parcela_model->encuesta($this->input->post("id_tipo_investigacion"));
			echo json_encode($r);
		}

		function registrar_encuesta(){
			$d = $this->input->post();
			$r = $this->parcela_model->registrar_encuesta($d);
			echo $r;
		}
	}
?>