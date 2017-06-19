<?php
    @session_start();
    class Validateaccess_model extends CI_Model{
        function __construct() {
            parent::__construct(); //llamada al constructor de Model.
            $this->load->helper('url');
            $this->load->database();
        }

        function validate(){
            if(isset($_SESSION['menu']) && isset($_SESSION['id']) && isset($_SESSION['nombre'])):
                return true;
            else:
                redirect(base_url(), "refresh");
            endif;
        }
    }
?>