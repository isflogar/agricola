<?php
	@session_start();
	class Reporte extends CI_Controller
	{
		public function __construct()
	    {
	        parent::__construct();
	        $this->load->helper('url');
	        $this->load->model('fundo_model');
	    }

	    public function index(){
	    	$this->load->library('pdf');
            $pdfFilePath = "reporte.pdf";

            $data = $this->db->from("usuario")->where("id_usuario", (int)$_SESSION["id"])->get()->result();
            $user = $data[0]->nombre;

            $html = "<h4 style='width:100%; text-align:center'>SISTEMA EXPERTO DE DIÁGNOTICO DE TIERRAS AGRÍCOLAS - DIRECCIÓN REGIONAL DE AGRICULTURA DE SAN MARTÍN</h4><div style='width:100%; text-align:center'><b>REPORTE DE DIAGNÓSTICO</b></div>
            <div>
            	<b>Usuario :</b> ".$user."
            </div>";

            $image_link = base_url()."uploads/reporte_imagen.png";

            $imagen = "<img src='".$image_link."' style='width:100%; height:300px'>";

            $key = $_GET["type"];
            $id_user = $_SESSION["id"];

            $cant_hectareas = 0;
			$ban=1;
			$li_descrip_fundo = "";

			$li_general = "";

            if($key=="total_fundo"){

				$result = $this->fundo_model->porcentaje_fundo($id_user);

				$result = $this->orderMultiDimensionalArray($result, "porcentaje", true);

				$li_general = "El sistema experto recomienda para todos los fundos los cultivos de :";
				foreach ($result as $key=>$obj) {
					$cant_hectareas = "<b>Hectareas : </b> ".$obj["hectareas"]."<br><br>";

					if($ban<=3){
						$li_descrip_fundo.=$obj["nombre"]." <b>(".$obj["porcentaje"]."%)</b> - <b style='color:#00A65A'>Se recomienda</b><br>";

						if($ban==3){
							$li_general.="<b>".$ban.".".$obj["nombre"]."</b>.<br> La información detalla del diagnóstico se encuentra en el siguiente texto:<br><br>";
						}else{
							$li_general.="<b>".$ban.".".$obj["nombre"]."</b>, ";
						}

					}else{
						$li_descrip_fundo.=$obj["nombre"]." <b>(".$obj["porcentaje"]."%)</b> - <b style='color:#FF0000'>No se recomienda</b><br>";
					}

					$ban++;
				}

				$fundos = $this->db->from("fundo")->where("id_usuario", $id_user)->where("estado", "A")->get()->result();

				$html .= "<b>Cantidad de fundos : </b> ".count($fundos)."<br>".$cant_hectareas."".$imagen."<br><div style='width:100%'>".$li_general."</div>".$li_descrip_fundo;

            }elseif($key == "fundo"){
            	$id = $_GET["id_fundo"];

            	$response = $this->fundo_porcentaje($id);

            	$fundo = $this->db->from("fundo")->where("id_fundo", $id)->get()->result();
            	$fundo = $fundo[0]->nro;
            	/*echo "<pre>";
            	print_r($response);
            	return;*/
            	$li_general = "El sistema experto recomienda para el <b>Fundo N° ".$fundo."</b> los cultivos de :";

            	foreach ($response[0] as $obj) {
            		$cant_hectareas = "<b>Hectareas : </b> ".$obj["hectareas"]."<br><br>";

					if($ban<=3){
						$li_descrip_fundo.=$obj["nombre"]." <b>(".$obj["porcentaje"]."%)</b> - <b style='color:#00A65A'>Se recomienda</b><br>";

						if($ban==3){
							$li_general.="<b>".$ban.".".$obj["nombre"]."</b>.<br> La información detalla del diagnóstico se encuentra en el siguiente texto:<br><br>";
						}else{
							$li_general.="<b>".$ban.".".$obj["nombre"]."</b>, ";
						}
					}else{
						$li_descrip_fundo.=$obj["nombre"]." <b>(".$obj["porcentaje"]."%)</b> - <b style='color:#FF0000'>No se recomienda</b><br>";
					}

					$ban++;
            	}

            	$cant_hectareas = $this->db->query("SELECT SUM(dimension) AS total FROM parcela WHERE id_fundo = ".$id." AND estado = 'A'");
            	$cant_hectareas = $cant_hectareas->result();
            	$cant_hectareas = $cant_hectareas[0]->total;

            	$cant_parcelas = 0;
            	$html_div = "";

            	foreach($response[1] as $key => $obj){
            		$cant_parcelas+=1;

            		$html_div .= "<div style='width:33.3%; float:left'>
						<h5>".$key."</h5>";

					$ban=0;
					foreach ($obj as $obj1) {
						if($ban<3){
							$html_div.="<span style='font-size:10px'>".$obj1["nombre"]." <b>(".$obj1["porcentaje"]."%)</b> - <b style='color:#00A65A'>Se recomienda</b></span><br>";
						}else{
							$html_div.="<span style='font-size:10px'>".$obj1["nombre"]." <b>(".$obj1["porcentaje"]."%)</b> - <b style='color:#FF0000'>No se recomienda</b></span><br>";
						}

						$ban++;
					}
            		$html_div.="</div>";
            	}

            	$html .= "<b>Total de hectareas : </b> ".$cant_hectareas."<br>
            	<b>Cantidad de parcelas : </b> ".$cant_parcelas."<br>".$imagen."<br><div style='width:100%'>".$li_general."</div>".$li_descrip_fundo."<hr>".$html_div;

            }else{
            	$id_parcela = $_GET["id_fundo"];

				$data = $this->db->from("parcela")
				->join("fundo", "fundo.id_fundo = parcela.id_fundo")
				->join("tipo_investigacion", "tipo_investigacion.id_tipo_investigacion = parcela.id_tipo_investigacion")
				->where("parcela.id_parcela", $id_parcela)
				->select("fundo.nro as nro_fundo, parcela.nro as nro_parcela, tipo_investigacion.descripcion_tipo_investigacion as tipo_investigacion")
				->get()->result();

				$new = [];
				$new[] = $data;

				$por = $this->porcentaje($id_parcela);

				$new[] = $por;

				/*echo "<pre>";
				print_r($new[1]);
				return;*/

				$cabecera = "<b>Fundo N° : </b>".$new[0][0]->nro_fundo." | ";
				$cabecera .= "<b>Parcela N° : </b>".$new[0][0]->nro_parcela." | ";
				$cabecera .= "<b>Tipo de Investigación : </b>".$new[0][0]->tipo_investigacion."<br><br>";
				/*echo $cabecera;
				return;*/

				$li_general = "El sistema experto recomienda la <b>Parcela N° ".$new[0][0]->nro_parcela."</b> los cultivos de : ";

				$ban=1;
				foreach ($new[1] as $obj) {
					if($ban<=3){
						$li_descrip_fundo.=$obj["nombre"]." <b>(".$obj["porcentaje"]."%)</b> - <b style='color:#00A65A'>Se recomienda</b><br>";

						if($ban==3){
							$li_general.="<b>".($ban).".".$obj["nombre"]."</b>. La información detalla del diagnóstico se encuentra en el siguiente texto:<br><br>";
						}else{
							$li_general.="<b>".($ban).".".$obj["nombre"]."</b>, ";
						}
					}else{
						$li_descrip_fundo.=$obj["nombre"]." <b>(".$obj["porcentaje"]."%)</b> - <b style='color:#FF0000'>No se recomienda</b><br>";
					}

					$ban++;
				}

				$html .= $cabecera.$imagen."<div style='width:100%'>".$li_general."</div>".$li_descrip_fundo;
            }
            //echo $html;die;
            $this->pdf->WriteHTML($html);
            $this->pdf->Output($pdfFilePath, "I");
		}

		public function base64(){
			define('UPLOAD_DIR', 'uploads/');
			$img = $_POST['img'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$name_image = "reporte_imagen.png";
			$file = UPLOAD_DIR . $name_image;
			$success = file_put_contents($file, $data);
			if($success){
				echo 1;
			}else{
				echo 0;
			}
		}

		function orderMultiDimensionalArray ($array, $campo, $invertir) {
		    $posicion = array();
		    $newRow = array();
		    foreach ($array as $key => $row) {
		            $posicion[$key]  = $row[$campo];
		            $newRow[$key] = $row;
		    }
		    if ($invertir) {
		        arsort($posicion);
		    }
		    else {
		        asort($posicion);
		    }
		    $arrayRetorno = array();
		    foreach ($posicion as $key => $pos) {
		        $arrayRetorno[] = $newRow[$key];
		    }
		    return $arrayRetorno;
		}

		function fundo_porcentaje($id){
			$id = $id;

			$parcelas_hechos = $this->db->from("parcela_hechos")
			->join("parcela", "parcela.id_parcela = parcela_hechos.id_parcela")
			->join("tipo_investigacion", "tipo_investigacion.id_tipo_investigacion = parcela.id_tipo_investigacion")
			->where("parcela.id_fundo", $id)
			->select("parcela_hechos.id_hechos, parcela.id_parcela, parcela.nro ,tipo_investigacion.descripcion_tipo_investigacion as tipo_investigacion")
			->order_by("parcela_hechos.id_hechos", "asc")
			->get()->result();

			$propiedades = [];

			foreach ($parcelas_hechos as $obj) {
				$propiedades[] = (int)$obj->id_hechos;
			}

			$propiedades1 = $propiedades;
			$propiedades = array_count_values($propiedades);

			$data = $this->db->from("conocimiento")->where("estado", "A")->get();
            $data = $data->result();//Obtener todos los conocimientos
            $conoci = $data;

            $result = [];
            $umbral_final = 0;

            $hectareas = $this->db->query("SELECT SUM(parcela.dimension) as hectareas from parcela
			inner join fundo on parcela.id_fundo = fundo.id_fundo
			where fundo.id_usuario = ".$id);
			$hectareas = $hectareas->result();
			$hectareas = $hectareas[0]->hectareas;

            foreach ($data as $k) {
                $data2 = $this->conocimientos_model->hechoyconocimiento($k->id_conocimiento);//Obtener todos los hechos que tiene 1 conocimiento
                $suma = 0;
                $umbral = 0;
                foreach ($data2 as $j) {
                    if($j->estado=="A"){
                        if(in_array($j->id_hechos, $propiedades1)){
                            $suma += ($propiedades[$j->id_hechos]*$j->peso);
                            $umbral_final+=($propiedades[$j->id_hechos]*$j->peso);
                        }
                    }
                }

                //$porcentaje = ($umbral!=0)?round($suma/$umbral*100, 2):0;

                $result[] = array(
                        "id_p"=>$k->id_conocimiento,
                        "imagen"=>$k->imagen,
                        "nombre"=>$k->conocimiento,
                        "color"=>$k->color,
                        "suma" => $suma,
                        "hectareas" => $hectareas
                );

            }

			for ($i=0; $i < count($result) ; $i++) {
				$result[$i]["porcentaje"] = round($result[$i]["suma"]*100/$umbral_final, 2);
			}

			$parcelas_hechos = $this->db->from("parcela_hechos")
			->join("parcela", "parcela.id_parcela = parcela_hechos.id_parcela")
			->join("tipo_investigacion", "tipo_investigacion.id_tipo_investigacion = parcela.id_tipo_investigacion")
			->where("parcela.id_fundo", $id)
			->select("parcela_hechos.id_hechos, parcela.id_parcela, parcela.nro ,tipo_investigacion.descripcion_tipo_investigacion as tipo_investigacion, parcela.dimension as hectareas")
			->order_by("parcela_hechos.id_parcela", "asc")
			->get()->result();

			$new_parcela = [];
			$parcela = [];

			//----------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			//TODA LAS PARCELAS DEL FUNDO A ESTUDIAR
			foreach ($parcelas_hechos as $obj) {
				if(!in_array($obj->id_parcela, $parcela)){
					$new_parcela[$obj->id_parcela] = $obj;
					$parcela[] = $obj->id_parcela;
				}
			}

			//HECHOS POR PARCELA
			$parcela_nuevas = [];
			foreach ($new_parcela as $key => $obj) {
				//CREARMOS ARRAY DE LA PARCELA
				$tipe_parcela = "Parcela N° <b>".$obj->nro."</b> | <b>".$obj->tipo_investigacion."</b> | <b>N° Hectareas :</b> ".$obj->hectareas;

				$hectareas = $obj->hectareas;

				$propiedad_parcela = $this->db->from("parcela_hechos")
				->where("id_parcela", $obj->id_parcela)
				->where("estado", "A")
				->get()->result();

				$propiedades = [];

				foreach ($propiedad_parcela as $obj) {
					$propiedades[] = (int)$obj->id_hechos;
				}

				//$final = [];
				$umbral_parcela = 0;

				foreach ($conoci as $k) {
	                $data2 = $this->conocimientos_model->hechoyconocimiento($k->id_conocimiento);//Obtener todos los hechos que tiene 1 conocimiento
	                $suma = 0;
	                $umbral_conocimiento = 0;
	                foreach ($data2 as $j) {
	                	$umbral_hecho = 0;

	                    if($j->estado=="A"){
	                        $umbral_hecho += $j->peso;
	                        if(in_array($j->id_hechos, $propiedades)){
	                            $suma += $j->peso;
	                            $umbral_parcela += $j->peso;
	                        }
	                    }

	                    $umbral_conocimiento += $j->peso;
	                }

	                $parcela_nuevas[$tipe_parcela][] = array(
	                        "id_p"=>$k->id_conocimiento,
	                        "imagen"=>$k->imagen,
	                        "nombre"=>$k->conocimiento,
	                        "peso"=>$suma,
	                        "color"=>$k->color,
	                        "suma_conocimiento" => $umbral_conocimiento,
	                        "hectareas" => $hectareas
	                );

	            }

	            for ($i=0; $i < count($parcela_nuevas[$tipe_parcela]) ; $i++) {
	            	$parcela_nuevas[$tipe_parcela][$i]["porcentaje"] = round($parcela_nuevas[$tipe_parcela][$i]["peso"]*100/$umbral_parcela,2);
	            }

			}

			$parcelas = $this->db->from("parcela")
			->where("id_fundo", $id)
			->where("estado", "A")->count_all_results();

			$this->db->select('SUM(dimension) as hectareas');
			$this->db->where('id_fundo',$id);
			$this->db->where('estado','A');
			$q = $this->db->get('parcela');
			$row = $q->row();

			$hectareas = $this->db->query("SELECT SUM(dimension) as hectareas FROM parcela WHERE id_fundo = ".$id." AND estado = 'A'");
			$hectareas = $hectareas->result();
			$hectareas = $hectareas[0]->hectareas;

			//ordenando
			$result = $this->orderMultiDimensionalArray($result, "porcentaje", true);

			$data_fundo = array($parcelas, $hectareas);

			//ordenando lista de parcelas
			$new_parcelas_nuevas = [];
			foreach ($parcela_nuevas as $key => $obj) {
				$obj = $this->orderMultiDimensionalArray($obj, "porcentaje", true);
				$new_parcelas_nuevas[$key] = $obj;
			}

			$array_final = [$result, $new_parcelas_nuevas, $data_fundo];

			return $array_final;
		}

		function porcentaje($id){
			//CODE PARA HACER MAGIA DEL UMBRAL :v-------------------<<<<<<<<<<<<<<<<<<<
			$id_parcela = $id;

			$propiedades = [];//LISTA IDS DE HECHOS DE ACUERDO A LAS PROPIEDADES DE LA PARCELA A ESTUDIAR

			$propiedad_parcela = $this->db->from("parcela_hechos")
			->join("parcela", "parcela.id_parcela = parcela_hechos.id_parcela")
			->where("parcela_hechos.id_parcela", $id_parcela)
			->where("parcela_hechos.estado", "A")
			->get()->result();

			$hectareas = $propiedad_parcela[0]->dimension;

			foreach ($propiedad_parcela as $obj) {
				$propiedades[] = (int)$obj->id_hechos;
			}

            $data = $this->db->from("conocimiento")->where("estado", "A")->get();
            $data = $data->result();//Obtener todos los conocimientos

            $result = [];

			$umbral_parcela = 0;

			//echo $umbral;
            foreach ($data as $k) {
                $data2 = $this->conocimientos_model->hechoyconocimiento($k->id_conocimiento);//Obtener todos los hechos que tiene 1 conocimiento
                $suma = 0;
                $umbral_conocimiento = 0;
                foreach ($data2 as $j) {
                	$umbral_hecho = 0;

                    if($j->estado=="A"){
                        $umbral_hecho += $j->peso;
                        if(in_array($j->id_hechos, $propiedades)){
                            $suma += $j->peso;
                            $umbral_parcela += $j->peso;
                        }
                    }

                    $umbral_conocimiento += $j->peso;
                }

                $result[] = array(
                        "id_p"=>$k->id_conocimiento,
                        "imagen"=>$k->imagen,
                        "nombre"=>$k->conocimiento,
                        "peso"=>$suma,
                        "suma_conocimiento" => $umbral_conocimiento,
                        "color"=>$k->color,
                        "hectareas" => $hectareas
                );

            }

            for ($i=0; $i < count($result) ; $i++) {
            	$result[$i]["porcentaje"] = round($result[$i]["peso"]*100/$umbral_parcela,2);
            }

            /*echo "<pre>";
			print_r($result);
			return;*/

			$new = $this->orderMultiDimensionalArray($result, "porcentaje", true);

			return $new;
		}
	}
?>