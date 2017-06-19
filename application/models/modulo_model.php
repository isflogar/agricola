<?php
	class Modulo_model extends CI_Model{
		function __construct() {
			parent::__construct(); //llamada al constructor de Model.
			$this->load->helper('url');
			$this->load->database();
		}

		public function procesar($d)
		{
			try {
				$d['descripcion'] = ucwords(trim($d['descripcion']));
				if($d["id_modulo"]==""){
					$d["estado"]="A";
					unset($d["id_modulo"]);
					$this->db->insert('modulo', $d);
				}else{
					$this->db->where("id_modulo", $d["id_modulo"]);
					$this->db->update("modulo", $d);
				}
				return 1;
			} catch (Exception $e) {
			    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			}

		}

		public function eliminar($id)
		{
			try {
				$this->db->where("id_modulo", $id);
				$this->db->update('modulo', array("estado"=>"I"));
				return 1;
			} catch (Exception $e) {
			    echo 'Excepción capturada: ',  $e->getMessage(), "\n";
			}

		}

		function datos($id){
			if($id==""){
				$r = $this->db->from("modulo")->where("estado", "A")->get();
			}else{
				$r = $this->db->from("modulo")->where("estado", "A")->where("id_modulo", $id)->get();
			}
			return json_encode($r->result());
		}
	}
?>