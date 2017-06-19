<?php
	@session_start();
	class Tipohecho_model extends CI_Model{
		function __construct() {
			parent::__construct(); //llamada al constructor de Model.
			$this->load->helper('url');
			$this->load->database();
		}

		public function datos($id){
			if($id==""){
				$r = $this->db->from('tipo_hecho')->where('estado', 'A')->get();
			}else{
				$r = $this->db->from('tipo_hecho')->where('id_tipo_hecho', $id)->get();
			}
			return $r->result();
		}

		public function procesar($d){
			try {
				$d['descripcion'] = ucwords(trim($d['descripcion']));
				if($d["id_tipo_hecho"]==""){
					$d["estado"]="A";
					unset($d["id_tipo_hecho"]);
					$this->db->insert('tipo_hecho', $d);
				}else{
					$this->db->where("id_tipo_hecho", $d["id_tipo_hecho"]);
					$this->db->update("tipo_hecho", $d);
				}
				return 1;
			} catch (Exception $e) {
			    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			}
		}

		public function eliminar($id){
			$this->db->where("id_tipo_hecho", $id);
			$this->db->update("tipo_hecho", array("estado"=>"I"));
			return 1;
		}

		/*public function buscar($data){
			header('Content-Type: application/json');
			$ret_string="{ results: [ {id:'1', text:'Option 1'}, {id:'2', text:'Option 2'} ],more:false}";
			echo json_encode($ret_string);
		}*/
	}
?>