<?php
    @session_start();
    class Conocimientos_model extends CI_Model{
        function __construct() {
            parent::__construct(); //llamada al constructor de Model.
            $this->load->helper('url');
            $this->load->database();
        }

        public function datos($id=""){
            if($id==""){
                $r = $this->db->from("conocimiento")->where("estado", "A")->get();
                $r = $r->result();
            }else{
                $r = $this->db->from("conocimiento")->where("id_conocimiento", $id)->where("estado", "A")->get();
                $r = $r->result();

                $obj = $this->db->select("hechos.descripcion, tipo_hecho.descripcion as tipo_hecho")->from("hecho_conocimiento")
                ->join("hechos", "hechos.id_hechos = hecho_conocimiento.id_hechos")
                ->join("tipo_hecho", "tipo_hecho.id_tipo_hecho = hechos.id_tipo_hecho")
                ->where("hecho_conocimiento.id_conocimiento", $id)
                ->where("hecho_conocimiento.estado", "A")->get();
                $obj = $obj->result();

                $r = array($r, $obj);
            }
            return $r;
        }

        function lista_hechos($id){
            $r = $this->db->select("hechos.id_hechos, hechos.descripcion, hecho_conocimiento.peso, tipo_hecho.descripcion as tipo_hecho, tipo_investigacion.descripcion_tipo_investigacion as tipo_investigacion")
            ->from("hecho_conocimiento")
            ->join("hechos", "hechos.id_hechos=hecho_conocimiento.id_hechos")
            ->join("tipo_hecho", "tipo_hecho.id_tipo_hecho = hechos.id_tipo_hecho")
            ->join("tipo_investigacion", "tipo_investigacion.id_tipo_investigacion = hechos.id_tipo_investigacion")
            ->where("hecho_conocimiento.id_conocimiento", $id)
            ->where("hecho_conocimiento.estado", "A")
            ->where("hechos.estado", "A")
            ->get();
            return $r->result();
        }

        public function registrar($d){
            $r = $this->db->from("conocimiento")->where("conocimiento", $d["conocimiento"])->count_all_results();
            if($r==1){
                return 2;
            }else{
                $this->db->insert("conocimiento", $d);
                return 1;
            }

        }

        public function editar($d, $id){
            $this->db->where("id_conocimiento", $id);
            $this->db->update("conocimiento", $d);
            return 1;
        }

        public function eliminar($id){
            $this->db->where("id_conocimiento", $id);
            $r = $this->db->update("conocimiento", array("estado"=>"I"));
            return $r;
        }

        function registrar_detalle($id, $det){
            $this->db->where("id_conocimiento", $id);
            $this->db->update("hecho_conocimiento", array("estado"=>"I"));

            for($i=0; $i<count($det); $i++){
                $c = $this->db->from("hecho_conocimiento")->where("id_conocimiento", $id)->where("id_hechos", $det[$i][0])->get();
                $c = $c->result();
                //echo json_encode($c[0]->id_hechos_conocimiento);

                if(count($c)==1){
                    $this->db
                    ->where("id_conocimiento", $id)
                    ->where("id_hechos", $det[$i][0]);

                    $this->db->update("hecho_conocimiento", array("peso"=>$det[$i][1], "estado"=>"A"));
                    //echo json_encode("U");
                }else{
                    $this->db->insert("hecho_conocimiento", array(
                        "id_conocimiento" => $id,
                        "id_hechos" => $det[$i][0],
                        "peso" => $det[$i][1],
                        "estado" => "A"
                    ));
                    //echo json_encode("I");
                }
            }

            return 1;
        }

        function hechoyconocimiento($id){
            $r = $this->db->select("*")
                ->from("hecho_conocimiento")
                ->join("hechos", "hecho_conocimiento.id_hechos = hechos.id_hechos")
                ->where("hecho_conocimiento.id_conocimiento", $id)
                ->where("hechos.estado", "A")
                ->get();

            return $r->result();
        }
    }
?>