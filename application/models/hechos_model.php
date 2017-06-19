<?php
	@session_start();
	class Hechos_model extends CI_Model{
		function __construct() {
			parent::__construct(); //llamada al constructor de Model.
			$this->load->helper('url');
			$this->load->database();
		}

		public function datos($id){
			if($id!=""){
				$r = $this->db->from('hechos')->where("id_hechos", $id)->get();
			}else{
				$r = $this->db->from('hechos')
				->join("tipo_hecho", "tipo_hecho.id_tipo_hecho = hechos.id_tipo_hecho", "left")
				->join("tipo_investigacion", "tipo_investigacion.id_tipo_investigacion = hechos.id_tipo_investigacion")
				->select("hechos.descripcion, tipo_hecho.descripcion as tipo_hecho, hechos.id_hechos, tipo_investigacion.descripcion_tipo_investigacion")
				->where('hechos.estado', 'A')->get();
			}

			return $r->result();
		}

		public function procesar($d){
			try {
				$d['descripcion'] = ucwords(trim($d['descripcion']));
				if($d["id_hechos"]==""){
					$d["estado"]="A";
					unset($d["id_hechos"]);
					$this->db->insert('hechos', $d);
				}else{
					$this->db->where("id_hechos", $d["id_hechos"]);
					$this->db->update("hechos", $d);
				}
				return 1;
			} catch (Exception $e) {
			    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			}
		}

		public function eliminar($id){
			$this->db->where("id_hechos", $id);
			$this->db->update("hechos", array("estado"=>"I"));
			return 1;
		}

		/*public function buscar($data){
			header('Content-Type: application/json');
			$ret_string="{ results: [ {id:'1', text:'Option 1'}, {id:'2', text:'Option 2'} ],more:false}";
			echo json_encode($ret_string);
		}*/
	}
?>