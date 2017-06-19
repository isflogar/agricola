<?php
	class Tipousuario_model extends CI_Model{
		function __construct() {
			parent::__construct(); //llamada al constructor de Model.
			$this->load->helper('url');
			$this->load->database();
		}

		function datos(){
			$r = $this->db->from("tipo_usuario")->where("estado", "A")->get();
			return $r->result();
		}

		function datos_moderador(){
			$r = $this->db->from("tipo_usuario")->where("estado", "A")->where("descripcion", "CLIENTE")->or_where("descripcion", "EMPRESA")->get();
			return $r->result();
		}
	}
?>