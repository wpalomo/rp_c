<?php

class TablaAmortizacionController extends ControladorBase{
    
	public function __construct() {
		parent::__construct();
	}

	public function index(){
	    
	    session_start();
	    $cuentas_pagar = new CuentasPagarModel();
	    
	    if( !isset($_SESSION['id_usuarios']) ){
	        
	        $this->redirect("Usuarios","sesion_caducada");
	    }
	    
	    $_id_usuarios = $_SESSION['id_usuarios'];
	    
	    $_id_rol = $_SESSION['id_rol'];
	    $nombre_controladores = "ReporteMovimientos";
	    $resultPer = $cuentas_pagar->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$_id_rol' " );
	    
	    if( empty($resultPer)){
	        
	        $this->view("Error",array(
	            "resultado"=>"No tiene Permisos de Acceso a Movimientos Productos Cabeza"	            
	        ));
	        
	        exit();	
	    }
	    
	    $this->view_Contable('MovimientosContable',array());
	}
	

	
	public function GENERAR_REPORTE(){
	    session_start();
	    $entidades = new EntidadesModel();
	    //PARA OBTENER DATOS DE LA EMPRESA
	    $datos_empresa = array();
	    $rsdatosEmpresa = $entidades->getBy("id_entidades = 1");
	    
	    if(!empty($rsdatosEmpresa) && count($rsdatosEmpresa)>0){
	        //llenar nombres con variables que va en html de reporte
	        $datos_empresa['NOMBREEMPRESA']=$rsdatosEmpresa[0]->nombre_entidades;
	        $datos_empresa['DIRECCIONEMPRESA']=$rsdatosEmpresa[0]->direccion_entidades;
	        $datos_empresa['TELEFONOEMPRESA']=$rsdatosEmpresa[0]->telefono_entidades;
	        $datos_empresa['RUCEMPRESA']=$rsdatosEmpresa[0]->ruc_entidades;
	        $datos_empresa['FECHAEMPRESA']=date('Y-m-d H:i');
	        $datos_empresa['USUARIOEMPRESA']=(isset($_SESSION['usuario_usuarios']))?$_SESSION['usuario_usuarios']:'';
	    }
	    
	    //NOTICE DATA
	    $datos_cabecera = array();
	    $datos_cabecera['USUARIO'] = (isset($_SESSION['nombre_usuarios'])) ? $_SESSION['nombre_usuarios'] : 'N/D';
	    $datos_cabecera['FECHA'] = date('Y/m/d');
	    $datos_cabecera['HORA'] = date('h:i:s');
	    
	    $tab_amortizacion= new TablaAmortizacionModel();
	    $id_creditos =  (isset($_REQUEST['id_creditos'])&& $_REQUEST['id_creditos'] !=NULL)?$_REQUEST['id_creditos']:'';
	    
	    
	    $datos_reporte = array();
	    
	    $columnas = " core_creditos.id_creditos, 
                      core_tipo_creditos.codigo_tipo_creditos,
                      core_creditos.numero_creditos, 
                      core_creditos.fecha_concesion_creditos, 
                      core_participes.id_participes, 
                      core_participes.apellido_participes, 
                      core_participes.nombre_participes, 
                      core_participes.cedula_participes, 
                      core_participes.direccion_participes,
                      core_participes.telefono_participes,
                      core_entidad_patronal.id_entidad_patronal, 
                      core_entidad_patronal.nombre_entidad_patronal, 
                      core_tipo_creditos.nombre_tipo_creditos, 
                      core_creditos.plazo_creditos, 
                      core_estado_creditos.nombre_estado_creditos, 
                      core_creditos.monto_otorgado_creditos, 
                      core_creditos.saldo_actual_creditos, 
                      core_creditos.monto_neto_entregado_creditos, 
                      core_creditos.fecha_servidor_creditos, 
                      core_creditos.interes_creditos";
	    
	    $tablas = "   public.core_tipo_creditos, 
                      public.core_creditos, 
                      public.core_participes, 
                      public.core_estado_creditos, 
                      public.core_entidad_patronal";
	    $where= "     core_creditos.id_tipo_creditos = core_tipo_creditos.id_tipo_creditos AND
                      core_creditos.id_estado_creditos = core_estado_creditos.id_estado_creditos AND
                      core_participes.id_participes = core_creditos.id_participes AND
                      core_participes.id_entidad_patronal = core_entidad_patronal.id_entidad_patronal
                      AND core_creditos.id_creditos ='$id_creditos'";
	    $id="core_creditos.id_creditos";
	    
	    $rsdatos = $tab_amortizacion->getCondiciones($columnas, $tablas, $where, $id);
	    
	    $datos_reporte['CODCREDITO']=$rsdatos[0]->codigo_tipo_creditos;
	    $datos_reporte['NUMCREDITO']=$rsdatos[0]->numero_creditos;
	    $datos_reporte['FECHACONCRED']=$rsdatos[0]->fecha_concesion_creditos;
	    $datos_reporte['APELLPARTICIPE']=$rsdatos[0]->apellido_participes;
	    $datos_reporte['NOMPARICIPE']=$rsdatos[0]->nombre_participes;
	    $datos_reporte['CEDPARTICIPE']=$rsdatos[0]->cedula_participes;
	    $datos_reporte['DIRPARTICIPE']=$rsdatos[0]->direccion_participes;
	    $datos_reporte['TELEFPARTICIPE']=$rsdatos[0]->telefono_participes;
	    $datos_reporte['ENTIDADPATRON']=$rsdatos[0]->nombre_entidad_patronal;
	    $datos_reporte['TIPOPRESTAMO']=$rsdatos[0]->nombre_tipo_creditos;
	    $datos_reporte['PLAZO']=$rsdatos[0]->plazo_creditos;
	    $datos_reporte['TAZA']=$rsdatos[0]->interes_creditos;
	    $datos_reporte['ESTADO']=$rsdatos[0]->nombre_estado_creditos;
	    $datos_reporte['MONTO']=$rsdatos[0]->monto_otorgado_creditos;
	    $datos_reporte['SALDO']=$rsdatos[0]->saldo_actual_creditos;
	    $datos_reporte['MONTORECIBIR']=$rsdatos[0]->monto_neto_entregado_creditos;
	   	    

	    
	    //////retencion detalle
	    
	    $columnas = " core_creditos.id_creditos, 
                      core_tabla_amortizacion.fecha_tabla_amortizacion, 
                      core_tabla_amortizacion.capital_tabla_amortizacion,
                      core_tabla_amortizacion.seguro_desgravamen_tabla_amortizacion,  
                      core_tabla_amortizacion.interes_tabla_amortizacion, 
                      core_tabla_amortizacion.total_valor_tabla_amortizacion,
                      core_tabla_amortizacion.mora_tabla_amortizacion,
                      core_tabla_amortizacion.balance_tabla_amortizacion,
                      core_tabla_amortizacion.numero_pago_tabla_amortizacion, 
                      core_tabla_amortizacion.total_balance_tabla_amortizacion,  
                      core_estado_tabla_amortizacion.nombre_estado_tabla_amortizacion, 
                      core_tabla_amortizacion.total_valor_tabla_amortizacion,
                      (select sum(c1.capital_tabla_amortizacion) 
                      from core_tabla_amortizacion c1 where id_creditos = '$id_creditos' and id_estatus=1 limit 1
                      ) as \"totalcapital\",  
                      (select sum(c1.interes_tabla_amortizacion) 
                      from core_tabla_amortizacion c1 where id_creditos = '$id_creditos' and id_estatus=1 limit 1
                      ) as \"totalintereses\",  
                      (select sum(c1.seguro_desgravamen_tabla_amortizacion) 
                      from core_tabla_amortizacion c1 where id_creditos = '$id_creditos' and id_estatus=1 limit 1
                      ) as \"totalseguro\", 
                      (select sum(c1.total_valor_tabla_amortizacion) 
                      from core_tabla_amortizacion c1 where id_creditos = '$id_creditos' and id_estatus=1 limit 1
                      ) as \"totalcuota\"               
";
	    
	    $tablas = "   public.core_creditos, 
                      public.core_tabla_amortizacion, 
                      public.core_estado_tabla_amortizacion";
	    $where= "   core_tabla_amortizacion.id_creditos = core_creditos.id_creditos AND
                    core_estado_tabla_amortizacion.id_estado_tabla_amortizacion = core_tabla_amortizacion.id_estado_tabla_amortizacion
                    AND core_creditos.id_creditos ='$id_creditos'";
	    $id="core_tabla_amortizacion.numero_pago_tabla_amortizacion";
	    
	    $amortizacion_detalle = $tab_amortizacion->getCondiciones($columnas, $tablas, $where, $id);
	    
	    
	    
	    
	    
	    $html='';
	    
	    
	    $html.='<table class="1" cellspacing="0" style="width:100px;" border="1" >';
	    $html.='<tr>';
	    $html.='<th style="text-align: left;  font-size: 12px;">#</th>';
	    $html.='<th style="text-align: center; font-size: 11px;">Fecha</th>';
	    $html.='<th style="text-align: center; font-size: 11px;">Capital</th>';
	    $html.='<th style="text-align: center; font-size: 11px;">Intereses</th>';
	    $html.='<th style="text-align: center; font-size: 11px;">Seg. Desgrav.</th>';
	    $html.='<th style="text-align: center; font-size: 11px;">Cuota</th>';
	    $html.='<th style="text-align: center; font-size: 11px;">Saldo</th>';
	   
	    $html.='</tr>';
	    
	    
	    $i=0;
	    
	    foreach ($amortizacion_detalle as $res)
	    {
	     
	        
	        $i++;
	        $html.='<tr >';
	        $html.='<td style="font-size: 11px;"align="center">'.$res->numero_pago_tabla_amortizacion.'</td>';
	        $html.='<td style="text-align: center; font-size: 11px;">'.$res->fecha_tabla_amortizacion.'</td>';
	        $html.='<td style="text-align: center; font-size: 11px;"align="right">'.number_format($res->capital_tabla_amortizacion, 2, ",", ".").'</td>';
	        $html.='<td style="text-align: center; font-size: 11px;"align="right">'.number_format($res->interes_tabla_amortizacion, 2, ",", ".").'</td>';
	        $html.='<td style="text-align: center; font-size: 11px;"align="right">'.number_format($res->seguro_desgravamen_tabla_amortizacion, 2, ",", ".").'</td>';
	        $html.='<td style="text-align: center; font-size: 11px;"align="right">'.number_format($res->total_valor_tabla_amortizacion, 2, ",", ".").'</td>';
	        $html.='<td style="text-align: center; font-size: 11px;"align="right">'.number_format($res->total_balance_tabla_amortizacion, 2, ",", ".").'</td>';
	        
	        
	        
	        $html.='</td>';
	        $html.='</tr>';
	       
	    }
	    
	    $html.='<tr>';
	    $html.='<th style="text-align: left;  font-size: 12px;">Totales</th>';
	    $html.='<th style="text-align: center; font-size: 11px;"></th>';
	    $html.='<th style="font-size: 11px;" align="right">'.number_format($res->totalcapital, 2, ",", ".").'</th>';
	    $html.='<th style="font-size: 11px;" align="right">'.number_format($res->totalintereses, 2, ",", ".").'</th>';
	    $html.='<th style="font-size: 11px;" align="right">'.number_format($res->totalseguro, 2, ",", ".").'</th>';
	    $html.='<th style="font-size: 11px;" align="right">'.number_format($res->totalcuota, 2, ",", ".").'</th>';
	    $html.='<th style="text-align: center; font-size: 11px;"></th>';
	    
	    $html.='</tr>';
	    $html.='</table>';
	    
	    $datos_reporte['DETALLE_AMORTIZACION']= $html;
	    
	    
	    
	    
	    
	    $this->verReporte("TablaAmortizacion", array('datos_empresa'=>$datos_empresa, 'datos_cabecera'=>$datos_cabecera, 'datos_reporte'=>$datos_reporte));
	    
	  
	}

	

	
	
}



?>