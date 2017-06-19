<?php
	@session_start();
	class Parcela_model extends CI_Model{
		function __construct() {
			parent::__construct(); //llamada al constructor de Model.
			$this->load->helper('url');
			$this->load->database();
		}

		public function datos($id){
			if($id==""){
				$r = $this->db->from('parcela')->where('estado', 'A')->get();
			}else{
				$r = $this->db->from('parcela')->where('id_fundo', $id)->get();
			}
			return $r->result();
		}

		public function agregar($d){
			try {
				$r = $this->db->from("parcela")->where("id_fundo", $d["id_fundo"])->count_all_results();
				if($r=="" || $r==null){
					$r=1;
				}else{
					$r++;
				}

				$d = array(
					"id_fundo" => $d["id_fundo"],
					"nro" => $r,
					"dimension" => $d["dimension"],
					"estado" => "A"
				);

				$this->db->insert("parcela", $d);

				$id = $this->db->insert_id();

				$obj = $this->db->from("parcela")->where("id_parcela", $id)->get()->result();

				$add = array("ok", $obj);
				return json_encode($add);
			} catch (Exception $e) {
			    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			}
		}

		public function eliminar($id){
			$this->db->where("id_parcela", $id);
			$this->db->update("parcela", array("estado"=>"I"));
			return "ok";
		}

		function lista_sembrio($id){
			$r = $this->db->from("parcela_conocimiento")
			->join("conocimiento", "conocimiento.id_conocimiento = parcela_conocimiento.id_conocimiento")
			->where("parcela_conocimiento.id_parcela", $id)
			->where("parcela_conocimiento.estado", "A")
			->where("conocimiento.estado", "A")
			->get();

			return $r->result();
		}

		function agregar_sembrio($d){
			$obj = $this->db->from("parcela_conocimiento")
			->where("id_parcela", $d["id_parcela"])
			->where("id_conocimiento", $d["id_conocimiento"])
			->get();

			$obj = $obj->result();

			if(count($obj)>0){
				$this->db->where("id_parcela_conocimiento", $obj[0]->id_parcela_conocimiento);
				$this->db->update("parcela_conocimiento", array("estado"=>"A"));
			}else{
				$d["estado"] = "A";
				$this->db->insert("parcela_conocimiento", $d);
			}

			return 1;
		}

		function quitar_sembrio($d){
			$this->db->where("id_parcela_conocimiento", $d);
			$this->db->update("parcela_conocimiento", array("estado"=>"I"));
			return 1;
		}

		//PROPIEDAD X PARCELA
		function lista_propiedad($id){
			$r = $this->db->from("parcela_hechos")
			->join("hechos", "hechos.id_hechos = parcela_hechos.id_hechos")
			->join("tipo_hecho", "tipo_hecho.id_tipo_hecho = hechos.id_tipo_hecho")
			->where("parcela_hechos.id_parcela", $id)
			->where("parcela_hechos.estado", "A")
			->where("hechos.estado", "A")
			->select("parcela_hechos.id_parcela_hechos, hechos.descripcion, tipo_hecho.descripcion as tipo_hecho, hechos.id_hechos")
			->get();

			return $r->result();
		}

		function agregar_propiedad($d){
			$obj = $this->db->from("parcela_hechos")
			->where("id_parcela", $d["id_parcela"])
			->where("id_hechos", $d["id_hechos"])
			->get();

			$obj = $obj->result();

			if(count($obj)>0){
				$this->db->where("id_parcela_hechos", $obj[0]->id_parcela_hechos);
				$this->db->update("parcela_hechos", array("estado"=>"A"));
			}else{
				$d["estado"] = "A";
				$this->db->insert("parcela_hechos", $d);
			}

			return 1;
		}

		function quitar_propiedad($d){
			$this->db->where("id_parcela_hechos", $d);
			$this->db->update("parcela_hechos", array("estado"=>"I"));
			return 1;
		}

		function encuesta($id){
			if($id==1){
				$r = $this->db->from("hechos")
				->select("tipo_hecho.id_tipo_hecho, tipo_hecho.pregunta_cientifica as pregunta, tipo_hecho.id_tipo_hecho, hechos.id_hechos, hechos.descripcion")
				->join("tipo_hecho", "tipo_hecho.id_tipo_hecho = hechos.id_tipo_hecho")
				->where("hechos.id_tipo_investigacion", $id)
				->where("hechos.estado", "A")
				->order_by("tipo_hecho.id_tipo_hecho", "asc")
				->order_by("hechos.id_hechos", "asc")
				->get()->result();
			}elseif($id==2){
				$r = $this->db->from("hechos")
				->select("tipo_hecho.id_tipo_hecho, tipo_hecho.pregunta_empirica as pregunta, hechos.id_hechos, hechos.descripcion")
				->join("tipo_hecho", "tipo_hecho.id_tipo_hecho = hechos.id_tipo_hecho")
				->where("hechos.id_tipo_investigacion", $id)
				->where("hechos.estado", "A")
				->order_by("tipo_hecho.id_tipo_hecho", "asc")
				->order_by("hechos.id_hechos", "asc")
				->get()->result();
				//return $r;
			}

			$encuesta = [];
			$pregunta = "";

				foreach ($r as $obj) {
					if($pregunta!=$obj->pregunta){
						$pregunta = $obj->pregunta;
						$encuesta[$pregunta] = [];
					}
						$encuesta[$pregunta][] = [
							"id_hecho"=>$obj->id_hechos,
							"descripcion"=>$obj->descripcion
						];

				}

				return $encuesta;
		}

		function registrar_encuesta($d){
			$this->db->where("id_parcela", $d["key_parcela"]);
			$this->db->update("parcela", array("id_tipo_investigacion"=>$d["key_tipo_investigacion"]));

			$hechos = $d["lista_respuestas"];

			for ($i=0; $i < count($hechos); $i++) {
				$obj = $this->db->from("parcela_hechos")->where("id_parcela", (int)$d["key_parcela"])->where("id_hechos", (int)$hechos[$i])->get()->result();

				if(count($obj)==0){
					$this->db->insert("parcela_hechos", array(
						"id_parcela" => (int)$d["key_parcela"],
						"id_hechos" => (int)$hechos[$i],
						"estado" => "A"
					));
				}else{
					$this->db->where("id_parcela_hechos", $obj[0]->id_parcela_hechos);
					$this->db->update("parcela_hechos", array("estado"=>"A"));
				}
			}

			return 1;
		}

		/*public function buscar($data){
			header('Content-Type: application/json');
			$ret_string="{ results: [ {id:'1', text:'Option 1'}, {id:'2', text:'Option 2'} ],more:false}";
			echo json_encode($ret_string);
		}*/
	}
?>