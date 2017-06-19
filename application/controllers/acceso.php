<?php
    @session_start();
    class Acceso extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('acceso_model');
            $this->load->model('validateaccess_model');
        }

        public function index()
        {
            $this->validateaccess_model->validate();
            $this->load->view("head");
            $this->load->view("menu_system", array("menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));

            $d = $this->db->from("tipo_usuario")->where("estado", "A")->get()->result();

            $this->load->view("modulos/acceso", array("data"=>$d));
            $this->load->view("footer",  array("js"=>"acceso.js"));
        }

        public function registrar()
        {
            $d = array(
                "id_modulo" => $this->input->post('id_modulo'),
                "id_tipo_usuario" => $this->input->post('id_tipo_usuario'),
                "estado" => "A"
            );

            $r = $this->acceso_model->registrar($d);
            echo $r;
        }

        public function eliminar(){
            $d = array(
                "id_modulo" => $this->input->post('id_modulo'),
                "id_tipo_usuario" => $this->input->post('id_tipo_usuario')
            );
            $r = $this->acceso_model->eliminar($d);
            echo $r;
        }

        public function datos(){
            $r = $this->acceso_model->datos($this->input->post("id_tipo_usuario"));
            echo json_encode($r);
        }
    }
?>