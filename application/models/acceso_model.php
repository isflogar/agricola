<?php
    class Acceso_model extends CI_Model{
        function __construct() {
            parent::__construct(); //llamada al constructor de Model.
            $this->load->helper('url');
            $this->load->database();
        }

        public function registrar($d)
        {
            try {
                $r = $this->db->from("acceso")->where("id_tipo_usuario", $d["id_tipo_usuario"])->where("id_modulo", $d["id_modulo"])->count_all_results();
                if($r==0){
                    $this->db->insert('acceso', $d);
                }else{
                    $this->db->where("id_tipo_usuario", $d["id_tipo_usuario"])->where("id_modulo", $d["id_modulo"]);
                    $this->db->update('acceso', array("estado"=>"A"));
                }
                //$this->menu_accesos($d["id_tipo_usuario"]);
                return 1;
            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }

        }

        public function eliminar($d)
        {
            try {
                $this->db->where("id_tipo_usuario", $d["id_tipo_usuario"])->where("id_modulo", $d["id_modulo"]);
                $this->db->update('acceso', array("estado"=>"I"));
                //$this->menu_accesos($d["id_tipo_usuario"]);
                return 1;
            } catch (Exception $e) {
                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            }

        }

        function datos($id){
            $mod_per = $this->db->from('acceso')->select("id_modulo")->where("id_tipo_usuario", $id)->where("estado", "A")->get();
            $mod_per = $mod_per->result();

            $mod = $this->db->from("modulo")->where("estado", "A")->get();
            $mod = $mod->result();

            $array = [];
            $b=0;
            foreach ($mod as $modulo)
            {
                $id_mod = $modulo->id_modulo;
                $mod = $modulo->descripcion;
                $padre = $modulo->id_modulo_padre;

                foreach ($mod_per as $permitido)
                {
                    if($modulo->id_modulo == $permitido->id_modulo){
                        $b=1;
                        break;
                    }
                }

                if($b==1)
                {
                    array_push($array, array("check"=>1, "id_modulo"=>$id_mod, "modulo"=>$mod, "padre"=>$padre));
                    $b=0;
                }else{
                    array_push($array, array("check"=>0, "id_modulo"=>$id_mod, "modulo"=>$mod, "padre"=>$padre));
                }
            }

            return $array;
        }

    }
?>