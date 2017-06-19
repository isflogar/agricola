<?php
	@session_start();
	class Fundo extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	        $this->load->model("fundo_model");
	        $this->load->model("validateaccess_model");
	        $this->load->model("conocimientos_model");
	    }

		public function index()
		{
			/*$this->validateaccess_model->validate();
			$this->load->view("head",  array("menu"=>""));
			$this->load->view("menu_system", array("menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));
			$this->load->view("modulos/hecho");
			$this->load->view("footer",  array("js"=>"hecho.js"));*/
		}

		public function agregar()
		{
			$r = $this->fundo_model->agregar();
			echo $r;
		}

		public function eliminar(){
			$r = $this->fundo_model->eliminar($this->input->post('id_fundo'));
			echo json_encode($r);
		}

		public function datos(){
			$r = $this->fundo_model->datos();
			echo json_encode($r);
		}

		function porcentaje(){
			$id = $this->input->post("id_fundo");

			$parcelas_hechos = $this->db->from("parcela_hechos")
			->join("parcela", "parcela.id_parcela = parcela_hechos.id_parcela")
			->join("tipo_investigacion", "tipo_investigacion.id_tipo_investigacion = parcela.id_tipo_investigacion")
			->where("parcela.id_fundo", $id)
			->select("parcela_hechos.id_hechos, parcela.id_parcela, parcela.nro ,tipo_investigacion.descripcion_tipo_investigacion as tipo_investigacion")
			->order_by("parcela_hechos.id_hechos", "asc")
			->get()->result();

			$propiedades = [];

			foreach ($parcelas_hechos as $obj) {
				$propiedades[] = (int)$obj->id_hechos;
			}

			$propiedades1 = $propiedades;
			$propiedades = array_count_values($propiedades);

			$data = $this->db->from("conocimiento")->where("estado", "A")->get();
            $data = $data->result();//Obtener todos los conocimientos
            $conoci = $data;

            $result = [];
            $umbral_final = 0;

            $hectareas = $this->db->query("SELECT SUM(parcela.dimension) as hectareas from parcela
			inner join fundo on parcela.id_fundo = fundo.id_fundo
			where fundo.id_usuario = ".$id);
			$hectareas = $hectareas->result();
			$hectareas = $hectareas[0]->hectareas;

            foreach ($data as $k) {
                $data2 = $this->conocimientos_model->hechoyconocimiento($k->id_conocimiento);//Obtener todos los hechos que tiene 1 conocimiento
                $suma = 0;
                $umbral = 0;
                foreach ($data2 as $j) {
                    if($j->estado=="A"){
                        if(in_array($j->id_hechos, $propiedades1)){
                            $suma += ($propiedades[$j->id_hechos]*$j->peso);
                            $umbral_final+=($propiedades[$j->id_hechos]*$j->peso);
                        }
                    }
                }

                //$porcentaje = ($umbral!=0)?round($suma/$umbral*100, 2):0;

                $result[] = array(
                        "id_p"=>$k->id_conocimiento,
                        "imagen"=>$k->imagen,
                        "nombre"=>$k->conocimiento,
                        "color"=>$k->color,
                        "suma" => $suma,
                        "hectareas" => $hectareas
                );

            }

			for ($i=0; $i < count($result) ; $i++) {
				$result[$i]["porcentaje"] = round($result[$i]["suma"]*100/$umbral_final, 2);
			}

			$parcelas_hechos = $this->db->from("parcela_hechos")
			->join("parcela", "parcela.id_parcela = parcela_hechos.id_parcela")
			->join("tipo_investigacion", "tipo_investigacion.id_tipo_investigacion = parcela.id_tipo_investigacion")
			->where("parcela.id_fundo", $id)
			->select("parcela_hechos.id_hechos, parcela.id_parcela, parcela.nro ,tipo_investigacion.descripcion_tipo_investigacion as tipo_investigacion, parcela.dimension as hectareas")
			->order_by("parcela_hechos.id_parcela", "asc")
			->get()->result();

			$new_parcela = [];
			$parcela = [];

			//----------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			//TODA LAS PARCELAS DEL FUNDO A ESTUDIAR
			foreach ($parcelas_hechos as $obj) {
				if(!in_array($obj->id_parcela, $parcela)){
					$new_parcela[$obj->id_parcela] = $obj;
					$parcela[] = $obj->id_parcela;
				}
			}

			//HECHOS POR PARCELA
			$parcela_nuevas = [];
			foreach ($new_parcela as $key => $obj) {
				//CREARMOS ARRAY DE LA PARCELA
				$tipe_parcela = "Parcela N° <b>".$obj->nro."</b> | <b>".$obj->tipo_investigacion."</b> | <b>N° Hectareas :</b> ".$obj->hectareas;

				$hectareas = $obj->hectareas;

				$propiedad_parcela = $this->db->from("parcela_hechos")
				->where("id_parcela", $obj->id_parcela)
				->where("estado", "A")
				->get()->result();

				$propiedades = [];

				foreach ($propiedad_parcela as $obj) {
					$propiedades[] = (int)$obj->id_hechos;
				}

				//$final = [];
				$umbral_parcela = 0;

				foreach ($conoci as $k) {
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

	                $parcela_nuevas[$tipe_parcela][] = array(
	                        "id_p"=>$k->id_conocimiento,
	                        "imagen"=>$k->imagen,
	                        "nombre"=>$k->conocimiento,
	                        "peso"=>$suma,
	                        "color"=>$k->color,
	                        "suma_conocimiento" => $umbral_conocimiento,
	                        "hectareas" => $hectareas
	                );

	            }

	            for ($i=0; $i < count($parcela_nuevas[$tipe_parcela]) ; $i++) {
	            	$parcela_nuevas[$tipe_parcela][$i]["porcentaje"] = round($parcela_nuevas[$tipe_parcela][$i]["peso"]*100/$umbral_parcela,2);
	            }

			}

			$parcelas = $this->db->from("parcela")
			->where("id_fundo", $id)
			->where("estado", "A")->count_all_results();

			$this->db->select('SUM(dimension) as hectareas');
			$this->db->where('id_fundo',$id);
			$this->db->where('estado','A');
			$q = $this->db->get('parcela');
			$row = $q->row();

			$hectareas = $this->db->query("SELECT SUM(dimension) as hectareas FROM parcela WHERE id_fundo = ".$id." AND estado = 'A'");
			$hectareas = $hectareas->result();
			$hectareas = $hectareas[0]->hectareas;

			//ordenando
			$result = $this->orderMultiDimensionalArray($result, "porcentaje", true);

			$data_fundo = array($parcelas, $hectareas);

			//ordenando lista de parcelas
			$new_parcelas_nuevas = [];
			foreach ($parcela_nuevas as $key => $obj) {
				$obj = $this->orderMultiDimensionalArray($obj, "porcentaje", true);
				$new_parcelas_nuevas[$key] = $obj;
			}

			$array_final = [$result, $new_parcelas_nuevas, $data_fundo];
			echo json_encode($array_final);
		}

		function fundo_porcentaje($id_user=""){
			if($id_user==""){
				$id_user = $_SESSION["id"];
			}

			$result = $this->fundo_model->porcentaje_fundo($id_user);

			$result = $this->orderMultiDimensionalArray($result, "porcentaje", true);

			echo json_encode($result);
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

		/*public function buscar(){
			$r = $this->fundo_model->buscar($this->input->get("q"));
			echo json_encode($r);
		}*/
	}
?>