<?php
    error_reporting(0);
    class Conocimientos extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model("conocimientos_model");
        }

        public function index()
        {
            $this->load->view("head",  array("menu"=>""));
            $this->load->view("menu_system", array("logo"=>$_SESSION['logo'], "menu"=>$_SESSION['menu'], "nombre"=>$_SESSION['nombre']));

            $data = $this->conocimientos_model->datos();
            $this->load->view("modulos/conocimientos", array("data"=>$data));
            $this->load->view("footer", array("js"=>"conocimientos.js"));
        }

        public function registrar()
        {
            $color = substr(md5(time()), 0, 6);
            $color = "#".$color;

            $d = array(
                "conocimiento" => ucwords($this->input->post('nombre')),
                "descripcion" => $this->input->post('descripcion'),
                "imagen" => $this->input->post('imagen'),
                "color" => $color,
                "insecticidas" =>  $this->input->post('insecticidas'),
                "toneladas_hectarea" =>  $this->input->post('toneladas_hectarea'),
                "costo_hectarea" =>  $this->input->post('costo_hectarea'),
                "periodo_crecimiento" =>  $this->input->post('periodo_crecimiento'),
                "ganancia" =>  $this->input->post('ganancia'),
                "estado" => "A"
            );

            $r = $this->conocimientos_model->registrar($d);
            echo $r;
        }

        public function editar()
        {
            $d = array(
                "conocimiento" => ucwords($this->input->post('nombre')),
                "descripcion" => $this->input->post('descripcion'),
                "imagen" => $this->input->post('imagen'),
                "insecticidas" =>  $this->input->post('insecticidas'),
                "toneladas_hectarea" =>  $this->input->post('toneladas_hectarea'),
                "costo_hectarea" =>  $this->input->post('costo_hectarea'),
                "periodo_crecimiento" =>  $this->input->post('periodo_crecimiento'),
                "ganancia" =>  $this->input->post('ganancia')
            );

            $r = $this->conocimientos_model->editar($d, $this->input->post('id_conocimientos'));
            echo $r;
        }

        public function eliminar(){
            $r = $this->conocimientos_model->eliminar($this->input->post('id_conocimientos'));
            echo $r;
        }

        public function datos(){
            //echo $this->input->post("id");
            $r = $this->conocimientos_model->datos($this->input->post("id"));
            echo json_encode($r);
        }

        function lista_hechos(){
            $r = $this->conocimientos_model->lista_hechos($this->input->post("id"));
            echo json_encode($r);
        }

        function registrar_detalle(){
            $r = $this->conocimientos_model->registrar_detalle($this->input->post("id"), $this->input->post("hechos"));
            echo $r;
        }

        /*public function cargar_imagen()
        {
            $ext = explode('.', $_FILES['logo']['name']);
            $img = 'img_'.rand('0', '9999').'.'.$ext[1];
            $file_element_name = "logo";
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '10000';
            $config['max_width']  = '1024';
            $config['max_height']  = '768';
            $config['upload_path'] = base_url().'/uploads/';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name))
            {
                echo json_encode($this->upload->display_errors());
            }
            else{
                $d=array(1, $img);
                echo json_encode($d);
            }
        }*/

        public function cargar_imagen()
        {
            $ext = explode('.', $_FILES['logo']['name']);
            $img = 'img_'.rand('0', '9999').'.'.$ext[1];
            $file_element_name = "logo";
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 1024 * 8;
            $config['max_width'] = '2024';
            $config['max_height'] = '2008';
            $config['file_name'] = $img;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name))
            {
                echo 0;
            }
            else{
                //$data = $this->upload->data();
                $d=array(1, $img);
                echo json_encode($d);
            }
            //echo $img;
        }

        function porcentaje(){
            $ingredientes = $this->input->post("hechos");

            $data = $this->db->from("conocimientos")->where("estado", "A")->get();
            $data = $data->result();//Obtener todos los conocimientos

            $result = [];
            $salidos = [];
            //echo "<div>";
            foreach ($data as $k) {
                $data2 = $this->hechoyconocimiento($k->id_conocimiento);//Obtener todos los hehcos que tiene 1 conocimiento
                $suma = 0;
                $umbral = 0;
                foreach ($data2 as $j) {
                    if($j->estado=="A"){
                        $umbral = $umbral + $j->peso;
                        if(in_array($j->id_hecho, $ingredientes)){
                            $suma =  $suma + $j->peso;
                        }
                    }
                }

                $porcentaje = ($umbral!=0)?round($suma/$umbral*100, 2):0;

                //PARA MOSTRAR SOLO LOS QUE SON O PASAN EL 60%

                if($porcentaje >= 60){
                    $result[] = array(
                        "id_p"=>$k->id_conocimiento,
                        "imagen"=>$k->imagen,
                        "nombre"=>$k->conocimiento,
                        "%"=>$porcentaje
                    );//$k->conocimiento, $k->id_conocimiento, $porcentaje];
                }else{
                    $salidos[] = [$k->conocimiento, $k->id_conocimiento, $porcentaje];
                }

                /*if($porcentaje > 0){
                    $result[] = array(
                        "plato"=>$k->conocimiento,
                        "id_plato"=>$k->id_conocimiento,
                        "p"=>$porcentaje);
                }*/

                //$result[] = [$k->conocimiento, $k->id_conocimiento, $porcentaje];
            }

            echo json_encode($result);
            //echo "</div>";
        }

        function hechoyconocimiento($id){
            $r = $this->db->select("*")->from("hecho_conocimiento")->join("hechos", "hecho_conocimiento.id_hecho = hechos.id_hecho")->where("hecho_conocimiento.id_conocimiento", $id)->where("hechos.estado", "A")->get();
            return $r->result();
        }

        function for_name(){
            $name = $this->input->post("name");
            $r = $this->db->from("conocimiento")->where("conocimiento", $name)->where("estado", "A")->get()->result();
            echo json_encode($r);
        }
    }
?>