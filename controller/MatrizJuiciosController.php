	<?php

    class MatrizJuiciosController extends ControladorBase{
	public function __construct() {
		parent::__construct();
		
	}
	
	public function index5(){
	    
	    session_start();
	    if (isset(  $_SESSION['nombre_usuarios']) )
	    {
	        $controladores = new ControladoresModel();
	        $nombre_controladores = "MatrizJuicios";
	        $id_rol= $_SESSION['id_rol'];
	        $resultPer = $controladores->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	        
	        if (!empty($resultPer))
	        {
	            
	            
	            
	            $this->view_GestionDocumental("MatrizJuiciosCordinador",array(
	                ""=>""
	            ));
	            
	        }
	        else
	        {
	            $this->view("Error",array(
	                "resultado"=>"No tiene Permisos de Acceso a consultar una solicitud de prestamo."
	                
	            ));
	            
	        }
	        
	        
	    }
	    else
	    {
	        $error = TRUE;
	        $mensaje = "Te sesión a caducado, vuelve a iniciar sesión.";
	        
	        $this->view("Login",array(
	            "resultSet"=>"$mensaje", "error"=>$error
	        ));
	        
	        
	        die();
	        
	    }
	    
	}
	public function searchadminsuper(){
	    
	    session_start();
	    
	    require_once 'core/DB_Juicios.php';
	    $db = new DB_Juicios();
	    
	    
	    
	    
	    $where_to="";
	    $columnas = " juicios.id_juicios,
								  juicios.orden,
								  juicios.regional,
								  juicios.juicio_referido_titulo_credito,
								  juicios.year_juicios,
								  clientes.id_clientes,
								  clientes.identificacion_clientes,
								  clientes.nombres_clientes,
								  clientes.nombre_garantes,
								  clientes.identificacion_garantes,
								clientes.identificacion_clientes_1,
								clientes.nombre_clientes_1,
								clientes.identificacion_clientes_2,
								clientes.nombre_clientes_2,
								clientes.identificacion_clientes_3,
								clientes.nombre_clientes_3,
								clientes.identificacion_garantes_1,
								clientes.nombre_garantes_1,
								clientes.identificacion_garantes_2,
								clientes.nombre_garantes_2,
								clientes.identificacion_garantes_3,
								clientes.nombre_garantes_3,
								clientes.correo_clientes,
								clientes.correo_clientes_1,
								clientes.correo_clientes_2,
								clientes.correo_clientes_3,
								clientes.direccion_clientes,
								clientes.direccion_clientes_1,
								clientes.direccion_clientes_2,
								clientes.direccion_clientes_3,
									clientes.cantidad_clientes,
								  clientes.cantidad_garantes,
								  clientes.sexo_clientes,
								  clientes.sexo_clientes_1,
								  clientes.sexo_clientes_2,
								  clientes.sexo_clientes_3,
								  clientes.sexo_garantes,
								  clientes.sexo_garantes_1,
								  clientes.sexo_garantes_2,
								  clientes.sexo_garantes_3,
								  provincias.id_provincias,
								  provincias.nombre_provincias,
								  titulo_credito.id_titulo_credito,
								  titulo_credito.numero_titulo_credito,
								  juicios.fecha_emision_juicios,
								  juicios.cuantia_inicial,
								  juicios.riesgo_actual,
								  estados_procesales_juicios.id_estados_procesales_juicios,
								  estados_procesales_juicios.nombre_estados_procesales_juicios,
								  juicios.descripcion_estado_procesal,
								  juicios.fecha_ultima_providencia,
								  juicios.estrategia_seguir,
								  juicios.observaciones,
								  juicios.tipo_leyes,
								  juicios.medida_cautelar,
								  juicios.embargo_bienes,
								  juicios.detalle_embargo_bienes,
								  juicios.observacion,
								  asignacion_secretarios_view.id_abogado,
								  asignacion_secretarios_view.impulsores,
								  asignacion_secretarios_view.id_secretario,
								  asignacion_secretarios_view.secretarios,
								  ciudad.id_ciudad,
								  ciudad.nombre_ciudad,
									clientes.correo_garantes_1,
								  clientes.correo_garantes_2,
								  clientes.correo_garantes_3,
								  clientes.correo_garantes_4,
								  clientes.direccion_garantes_1,
								  clientes.direccion_garantes_2,
								  clientes.direccion_garantes_3,
								  clientes.direccion_garantes_4,
									juicios.id_origen_juicio,
								  origen_juicio.nombre_origen_juicio,
									carton_juicuis.numero_carton_jucios";
	    
	    
	    
	    $tablas=" public.clientes,
							  public.titulo_credito,
							  public.juicios,
							  public.asignacion_secretarios_view,
							  public.estados_procesales_juicios,
							  public.provincias,
							  public.ciudad, public.origen_juicio, public.carton_juicuis";
	    
	    $where="clientes.id_clientes = titulo_credito.id_clientes AND
							clientes.id_provincias = provincias.id_provincias AND
							titulo_credito.id_titulo_credito = juicios.id_titulo_credito AND
							asignacion_secretarios_view.id_ciudad = ciudad.id_ciudad AND
							juicios.id_estados_procesales_juicios = estados_procesales_juicios.id_estados_procesales_juicios AND
							asignacion_secretarios_view.id_abogado = titulo_credito.id_usuarios AND juicios.id_origen_juicio= origen_juicio.id_origen_juicio AND juicios.id_carton_juicios=carton_juicuis.id_carton_juicios";
	    
	    $id="juicios.id_juicios";
	    
	    
	    //$where_to=$where;
	    
	    
	    $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	    $search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
	    
	    if($action == 'ajax')
	    {
	        
	        if(!empty($search)){
	            
	            
	            $where1=" AND (clientes.identificacion_clientes LIKE '".$search."%' OR clientes.nombres_clientes LIKE '".$search."%' OR clientes.nombre_garantes LIKE '".$search."%' OR juicios.juicio_referido_titulo_credito LIKE '".$search."%'  OR ciudad.nombre_ciudad LIKE '".$search."%' OR  origen_juicio.nombre_origen_juicio LIKE '".$search."%')";
	            
	            $where_to=$where.$where1;
	        }else{
	            
	            $where_to=$where;
	            
	        }
	        
	        
	        $html="";
	        $resultSet=$db->getCantidad("*", $tablas, $where_to);
	        $cantidadResult=(int)$resultSet[0]->total;
	        
	        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	        
	        $per_page = 10; //la cantidad de registros que desea mostrar
	        $adjacents  = 9; //brecha entre páginas después de varios adyacentes
	        $offset = ($page - 1) * $per_page;
	        
	        $limit = " LIMIT   '$per_page' OFFSET '$offset'";
	        
	        $resultSet=$db->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
	        $count_query   = $cantidadResult;
	        $total_pages = ceil($cantidadResult/$per_page);
	        
	        if ($cantidadResult>0)
	        {
	            
	           
	            $html.='<div class="pull-left" style="margin-left:11px;">';
	            $html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
	            $html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
	            $html.='</div>';
	            $html.='<div class="col-lg-12 col-md-12 col-xs-12">';
	            $html.='<section style="height:350px; overflow-y:scroll;">';
	            $html.= "<table id='tabla_solicitud_prestamos_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
	            $html.= "<thead>";
	            $html.= "<tr>";
	            $html.='<th style="text-align: left;  font-size: 10px;">Ord.</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;">Origen</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;"># Juicio</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;">Año Juicio</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;">Nombres Cliente 1</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;">Sexo 1</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;">Fecha Última Providencia</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;">Estrategia a Seguir</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;">Estado Procesal</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;">Observaciones</th>';
	            $html.='<th style="text-align: left;  font-size: 10px;">Impulsor</th>';
	            
	            $html.='</tr>';
	            $html.='</thead>';
	            $html.='<tbody>';
	            
	            $i=0;
	            
	            foreach ($resultSet as $res)
	            {
	                
	                $i++;
	                $html.='<tr>';
	                $html.='<td style="font-size: 9px;">'.$i.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->nombre_origen_juicio.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->juicio_referido_titulo_credito.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->year_juicios.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->nombres_clientes.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->sexo_clientes.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->fecha_ultima_providencia.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->estrategia_seguir.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->nombre_estados_procesales_juicios.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->observacion.'</td>';
	                $html.='<td style="font-size: 9px;">'.$res->impulsores.'</td>';
	                $html.='</tr>';
	                
	                
	                
	            }
	            
	            $html.='</tbody>';
	            $html.='</table>';
	            $html.='</section>';
	            $html.='</div>';
	            $html.='<div class="table-pagination pull-right">';
	            $html.=''. $this->paginate("index.php", $page, $total_pages, $adjacents).'';
	            $html.='</div>';
	            
	            
	            
	        }else{
	            
	            $html.='<div class="alert alert-warning alert-dismissable">';
	            $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	            $html.='<h4>Aviso!!!</h4> No hay datos para mostrar';
	            $html.='</div>';
	            
	        }
	        
	        echo $html;
	        die();
	        
	    }
	    
	}
	
	



	public function paginate($reload, $page, $tpages, $adjacents) {
	    
	    $prevlabel = "&lsaquo; Prev";
	    $nextlabel = "Next &rsaquo;";
	    $out = '<ul class="pagination pagination-large">';
	    
	    // previous label
	    
	    if($page==1) {
	        $out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
	    } else if($page==2) {
	        $out.= "<li><span><a href='javascript:void(0);' onclick='load_matriz(1)'>$prevlabel</a></span></li>";
	    }else {
	        $out.= "<li><span><a href='javascript:void(0);' onclick='load_matriz(".($page-1).")'>$prevlabel</a></span></li>";
	        
	    }
	    
	    // first label
	    if($page>($adjacents+1)) {
	        $out.= "<li><a href='javascript:void(0);' onclick='load_matriz(1)'>1</a></li>";
	    }
	    // interval
	    if($page>($adjacents+2)) {
	        $out.= "<li><a>...</a></li>";
	    }
	    
	    // pages
	    
	    $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	    $pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	    for($i=$pmin; $i<=$pmax; $i++) {
	        if($i==$page) {
	            $out.= "<li class='active'><a>$i</a></li>";
	        }else if($i==1) {
	            $out.= "<li><a href='javascript:void(0);' onclick='load_matriz(1)'>$i</a></li>";
	        }else {
	            $out.= "<li><a href='javascript:void(0);' onclick='load_matriz(".$i.")'>$i</a></li>";
	        }
	    }
	    
	    // interval
	    
	    if($page<($tpages-$adjacents-1)) {
	        $out.= "<li><a>...</a></li>";
	    }
	    
	    // last
	    
	    if($page<($tpages-$adjacents)) {
	        $out.= "<li><a href='javascript:void(0);' onclick='load_matriz($tpages)'>$tpages</a></li>";
	    }
	    
	    // next
	    
	    if($page<$tpages) {
	        $out.= "<li><span><a href='javascript:void(0);' onclick='load_matriz(".($page+1).")'>$nextlabel</a></span></li>";
	    }else {
	        $out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
	    }
	    
	    $out.= "</ul>";
	    return $out;
	}
	


	
		}
	
	
	
	
	?>