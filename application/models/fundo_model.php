<?php
	@session_start();
	class Fundo_model extends CI_Model{
		function __construct() {
			parent::__construct(); //llamada al constructor de Model.
			$this->load->helper('url');
			$this->load->model('conocimientos_model');
			$this->load->database();
		}

		public function datos(){
			$r = $this->db->from('fundo')->where('estado', 'A')->get();
			return $r->result();
		}

		public function agregar(){
			try {
				$r = $this->db->from("fundo")->where("id_usuario", (int)$_SESSION["id"])->count_all_results();
				if($r=="" || $r==null){
					$r=1;
				}else{
					$r++;
				}

				$d = array(
					"id_usuario" => $_SESSION['id'],
					"nro" => $r,
					"estado" => "A"
				);

				$this->db->insert("fundo", $d);

				$id = $this->db->insert_id();

				$obj = $this->db->from("fundo")->where("id_fundo", $id)->get()->result();

				$add = array("ok", $obj);
				return json_encode($add);
			} catch (Exception $e) {
			    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			}
		}

		public function eliminar($id){
			$this->db->where("id_fundo", $id);
			$this->db->update("fundo", array("estado"=>"I"));
			return "ok";
		}

		function porcentaje_fundo($id){
			$parcelas_hechos = $this->db->from("parcela_hechos")
			->join("parcela", "parcela.id_parcela = parcela_hechos.id_parcela")
			->join("fundo", "fundo.id_fundo = parcela.id_fundo")
			->where("fundo.id_usuario", $id)
			->select("parcela_hechos.id_hechos, fundo.id_fundo, parcela.dimension")
			->order_by("fundo.id_fundo", "asc")
			->order_by("parcela_hechos.id_hechos", "asc")
			->get()->result();

			$propiedades = [];

			//sacamos la cantidad de hectaraes de la lista de fundos
			$hectareas = $this->db->query("SELECT SUM(parcela.dimension) as hectareas from parcela
			inner join fundo on parcela.id_fundo = fundo.id_fundo
			where fundo.id_usuario = ".$id);
			$hectareas = $hectareas->result();
			$hectareas = $hectareas[0]->hectareas;

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
				@$result[$i]["porcentaje"] = round($result[$i]["suma"]*100/$umbral_final, 2);
			}

			return $result;
		}
	}
?>