<?php
	@session_start();
	class Usuario_model extends CI_Model{
		function __construct() {
			parent::__construct(); //llamada al constructor de Model.
			$this->load->helper('url');
			$this->load->database();
		}

		public function validar_ingreso($user, $clave){
			$r = $this->db->from('usuario')->where("user", $user)->where("clave", md5($clave))->where('estado', 'A')->get();
			if(count($r->result())==1){
				$d = $r->result();
				$_SESSION['id'] = $d[0]->id_usuario;
				$_SESSION['nombre'] = ucwords($d[0]->nombre);
				$this->generar_accesos($d[0]->id_tipo_usuario, $d[0]->nombre);
				echo 1;
			}else{
				return 0;
			}
		}

		public function generar_accesos($id_tipo_usuario, $n){
			$r = $this->db->select("modulo.id_modulo, modulo.img,  ,modulo.descripcion, modulo.url")->from("acceso")->join("modulo", "modulo.id_modulo = acceso.id_modulo")->where("acceso.id_tipo_usuario", $id_tipo_usuario)->order_by("orden", "asc")->get();
			$menu = '<li class="header"><center><h5>MODULOS</h5></center></li><li id="option00"><a href="'.base_url().'app?option=00"><i class="fa fa-home"></i>  Inicio</a>';
			foreach ($r->result()  as $key => $value) {
				$menu.='<li id="option'.$value->id_modulo.'"><a href="'.base_url().$value->url.'?option='.$value->id_modulo.'"><i class="'.$value->img.'"></i>  '.$value->descripcion.'</a></li>';
			}

			$menu.='</ul>';
			$_SESSION['menu'] = $menu;
		}

		public function datos(){
			$r = $this->db->select("usuario.id_usuario, usuario.nombre, usuario.user, tipo_usuario.descripcion, tipo_usuario.id_tipo_usuario, usuario.clave")->from('usuario')->join('tipo_usuario', 'tipo_usuario.id_tipo_usuario = usuario.id_tipo_usuario')->where('usuario.estado', 'A')->where('tipo_usuario.estado', 'A')->get();
			return $r->result();
		}

		public function procesar($d){
			$d["nombre"] = strtoupper($d["nombre"]);
			if($d["id_usuario"]==""){
				$r = $this->db->from("usuario")->where("user", $d['user'])->get();
				$r = $r->result();

				if(count($r)>0){
					return "YA EXISTE UN REGISTRO CON EL MISMO USUARIO";
				}else{
					unset($d["id_usuario"]);
					$d["clave"] = md5($d["clave"]);
					$d["estado"] = "A";
					$this->db->insert("usuario", $d);
				}
			}else{
				if($d["clave"]!=""){
					$d["clave"] = md5($d["clave"]);
				}else{
					unset($d["clave"]);
				}

				$this->db->where("id_usuario", $d["id_usuario"]);
				$this->db->update("usuario", $d);
			}
			return 1;
		}

		public function eliminar($id){
			$this->db->where("id_usuario", $id);
			$this->db->update("usuario", array("estado"=>"I"));
			return 1;
		}
	}
?>