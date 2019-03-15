    <!DOCTYPE HTML>
	<html lang="es">
    <head>
    
    <script lang=javascript src="view/Contable/FuncionesJS/xlsx.full.min.js"></script>
    <script lang=javascript src="view/Contable/FuncionesJS/FileSaver.min.js"></script>
        
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Capremci</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
    <?php include("view/modulos/links_css.php"); ?>		
  	    
	</head>
 
    <body class="hold-transition skin-blue fixed sidebar-mini">
    
     <?php
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
     ?>
     
    <div class="wrapper">

      <header class="main-header">
      
          <?php include("view/modulos/logo.php"); ?>
          <?php include("view/modulos/head.php"); ?>	
        
      </header>
    
       <aside class="main-sidebar">
        <section class="sidebar">
         <?php include("view/modulos/menu_profile.php"); ?>
          <br>
         <?php include("view/modulos/menu.php"); ?>
        </section>
      </aside>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        
        <small><?php echo $fecha; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Contabilidad</a></li>
        <li class="active">Activos Fijos</li>
      </ol>
    </section>

    <section class="content">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Activos Fijos</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
              <i class="fa fa-minus"></i></button>
            
          </div>
        </div>
        
        <div class="box-body">
          
        
        <form action="<?php echo $helper->url("ActivosFijos","InsertaActivosFijos"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                                <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
                                
                                <div class="row">
                        		   <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                       
                                                          <label for="id_oficina" class="control-label">Oficina:</label>
                                                          <select name="id_oficina" id="id_oficina"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultOfi as $res) {?>
				 												<option value="<?php echo $res->id_oficina; ?>" <?php if ($res->id_oficina == $resEdit->id_oficina )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_oficina; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										  <div id="mensaje_id_oficina" class="errores"></div>
                                    </div>
                                    </div> 
                                  
									<div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                       
                                                          <label for="id_tipo_activos_fijos" class="control-label">Tipo Activos Fijos:</label>
                                                          <select name="id_tipo_activos_fijos" id="id_tipo_activos_fijos"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultTipoac as $res) {?>
				 												<option value="<?php echo $res->id_tipo_activos_fijos; ?>" <?php if ($res->id_tipo_activos_fijos == $resEdit->id_tipo_activos_fijos )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_tipo_activos_fijos; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										  <div id="mensaje_id_tipo_activos_fijos" class="errores"></div>
                                    </div>
                                    </div>  
                        		    
                        		   
                                    
                                    <div class="col-xs-12 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="codigo_activos_fijos" class="control-label">Código:</label>
                                                          <input type="text" class="form-control" id="codigo_activos_fijos" name="codigo_activos_fijos" value="<?php echo $resEdit->codigo_activos_fijos; ?>"  placeholder="código...">
                                                          <input type="hidden" name="id_activos_fijos" id="id_activos_fijos" value="<?php echo $resEdit->id_activos_fijos; ?>" class="form-control"/>
					                                      <div id="mensaje_codigo_activos_fijos" class="errores"></div>
                                    </div>
                        		    </div>
                        		    
                        		    <div class="col-xs-12 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="nombre_activos_fijos" class="control-label">Nombre Activos:</label>
                                                          <input type="text" class="form-control" id="nombre_activos_fijos" name="nombre_activos_fijos" value="<?php echo $resEdit->nombre_activos_fijos; ?>"  placeholder="Nombre...">
                                                          <div id="mensaje_nombre_activos_fijos" class="errores"></div>
                                    </div>
                        		    </div>
                                    
                                 </div>
                                 
                                 <div class="row">
                        		  
                                 <div class="col-xs-12 col-md-3 col-md-3 ">
                                 <div class="form-group">
                    			   <label for="fecha_compra_activos_fijos" class="control-label">Fecha:</label>
                    			   <input type="date" class="form-control" id="fecha_compra_activos_fijos" name="fecha_compra_activos_fijos" min="<?php echo date('Y-m-d', mktime(0,0,0, date('m'), date("d", mktime(0,0,0, date('m'), 1, date('Y'))), date('Y'))); ?>" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d');?>" >
                    			   <div id="mensaje_fecha_compra_activos_fijos" class="errores"></div>
                                 </div>  
                                 </div>
                                 
                        		    
                        		   
                        		    
                        		    <div class="col-xs-12 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="cantidad_activos_fijos" class="control-label">Cantidad de Activos</label>
                                                          <input type="text" class="form-control" id="cantidad_activos_fijos" name="cantidad_activos_fijos" value="<?php echo $resEdit->cantidad_activos_fijos; ?>"  placeholder="Cantidad..." onkeypress="return numeros(event)">
                                                          <div id="mensaje_cantidad_activos_fijos" class="errores"></div>
                                    </div>
                        		    </div>
                        		    
                            		<div class="col-lg-3 col-xs-12 col-md-3">
                        		    <div class="form-group">
                                                          <label for="valor_activos_fijos" class="control-label">Valor de activos:</label>
                                                          <input type="text" class="form-control cantidades1" id="valor_activos_fijos" name="valor_activos_fijos" value='<?php echo $resEdit->valor_activos_fijos; ?>' 
                                                          data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false">
                                                          <div id="mensaje_valor_activos_fijos" class="errores"></div>
                                    </div>
                                    </div>
                            		    
                        		    
                        		    <div class="col-xs-12 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="meses_depreciacion_activos_fijos" class="control-label">Meses de Depreciación</label>
                                                          <input type="text" class="form-control" id="meses_depreciacion_activos_fijos" name="meses_depreciacion_activos_fijos" value="<?php echo $resEdit->meses_depreciacion_activos_fijos; ?>"  placeholder="Meses..." onkeypress="return numeros(event)">
                                                          <div id="mensaje_meses_depreciacion_activos_fijos" class="errores"></div>
                                    </div>
                        		    </div>
                        		    
                        		    </div>
                        		    
                        		    <div class="row">
                        		    
                        		   
                        		    
                        		   
                        		     <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                       
                                                          <label for="id_estado" class="control-label">Estado:</label>
                                                          <select name="id_estado" id="id_estado"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($result_Activos_estados as $res) {?>
				 												<option value="<?php echo $res->id_estado; ?>" <?php if ($res->id_estado == $resEdit->id_estado )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_estado; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										  <div id="mensaje_id_estado" class="errores"></div>
                                    </div>
                                    </div>
                        		    </div>
                        		  
                                
                    		     <?php } } else {?>
                    		    
                    		   
								 <div class="row">
                        		    
                        		    
                        		   <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                          <label for="id_oficina" class="control-label">Oficina:</label>
                                                          <select name="id_oficina" id="id_oficina"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultOfi as $res) {?>
				 												<option value="<?php echo $res->id_oficina; ?>"  ><?php echo $res->nombre_oficina; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										   <div id="mensaje_id_oficina" class="errores"></div>
                                    </div>
                                    </div>
									
                        			
                        			<div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                          <label for="id_tipo_activos_fijos" class="control-label">Tipo Activos Fijos:</label>
                                                          <select name="id_tipo_activos_fijos" id="id_tipo_activos_fijos"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultTipoac as $res) {?>
				 												<option value="<?php echo $res->id_tipo_activos_fijos; ?>"  ><?php echo $res->nombre_tipo_activos_fijos; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										   <div id="mensaje_id_tipo_activos_fijos" class="errores"></div>
                                    </div>
                                    </div>
                        		    
                        		   
                                   
                                   <div class="col-xs-12 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="codigo_activos_fijos" class="control-label">Código:</label>
                                                          <input type="text" class="form-control" id="codigo_activos_fijos" name="codigo_activos_fijos" value=""  placeholder="código...">
                                                          <input type="hidden" name="id_activos_fijos" id="id_activos_fijos" value="0" class="form-control"/>
					                                       <div id="mensaje_codigo_activos_fijos" class="errores"></div>
                                    </div>
                        		    </div> 
                                   
                        		   <div class="col-xs-12 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="nombre_activos_fijos" class="control-label">Nombre Activos:</label>
                                                          <input type="text" class="form-control" id="nombre_activos_fijos" name="nombre_activos_fijos" value=""  placeholder="nombre...">
                                                           <div id="mensaje_nombre_activos_fijos" class="errores"></div>
                                    </div>
                        		    </div> 
                        		   
                        		  </div>
                        		  
                        		  <div class="row">
                        		    
                        		    
                        		    <div class="col-xs-12 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="fecha_compra_activos_fijos" class="control-label">Fecha:</label>
                                                          <input type="date" class="form-control" id="fecha_compra_activos_fijos" name="fecha_compra_activos_fijos" min="<?php echo date('Y-m-d', mktime(0,0,0, date('m'), date("d", mktime(0,0,0, date('m'), 1, date('Y'))), date('Y'))); ?>" max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d');?>" >
                    			                         <div id="mensaje_fecha_compra_activos_fijos" class="errores"></div>
                                    </div>
                        		    </div>
                        		    
                        		    <div class="col-xs-12 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="cantidad_activos_fijos" class="control-label">Cantidad de activos:</label>
                                                          <input type="text" class="form-control" id="cantidad_activos_fijos" name="cantidad_activos_fijos" value=""  placeholder="cantidad..." onkeypress="return numeros(event)">
                                                           <div id="mensaje_cantidad_activos_fijos" class="errores"></div>
                                    </div>
                        		    </div>
                        		    
                        		    
                            		<div class="col-lg-3 col-xs-12 col-md-3">
                        		    <div class="form-group">
                                                          <label for="valor_activos_fijos" class="control-label">Valor de activos:</label>
                                                          <input type="text" class="form-control cantidades1" id="valor_activos_fijos" name="valor_activos_fijos" value='0.00' 
                                                          data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false">
                                                          <div id="mensaje_valor_activos_fijos" class="errores"></div>
                                    </div>
                                    </div>
                        		    
                        		    
                        		    <div class="col-xs-12 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="meses_depreciacion_activos_fijos" class="control-label">Meses de Depreciación</label>
                                                          <input type="text" class="form-control" id="meses_depreciacion_activos_fijos" name="meses_depreciacion_activos_fijos" value=""  placeholder="meses..." onkeypress="return numeros(event)">
                                                           <div id="mensaje_meses_depreciacion_activos_fijos" class="errores"></div>
                                    </div>
                        		    </div>
                        		    
                        		  </div>
                        		  
                        		  <div class="row">
                        		    
                        		    
                        		     <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                          <label for="id_estado" class="control-label">Estado:</label>
                                                          <select name="id_estado" id="id_estado"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($result_Activos_estados as $res) {?>
				 												<option value="<?php echo $res->id_estado; ?>"  ><?php echo $res->nombre_estado; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										   <div id="mensaje_id_estado" class="errores"></div>
                                    </div>
                                    </div>
                        		    
                        		  </div>
									
								<?php } ?>
                    		    <br>  
                    		    <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; ">
                    		    <div class="form-group">
                                                      <button type="submit" id="Guardar" name="Guardar" class="btn btn-success">Guardar</button>
                                </div>
                    		    </div>
                    		    </div>
                    		        		  
              </form>
          
        </div>
        
        
      </div>
    </section>
    
    <section class="content">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Listado Activos Fijos</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                  <i class="fa fa-minus"></i></button>
                
              </div>
            </div>
            
            <div class="box-body">
            
           <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activos" data-toggle="tab">Activos Fijos</a></li>
              
            </ul>
            
            <div class="col-md-5 col-lg-12 col-xs-5">
            <div class="tab-content">
            
            <br>
              <div class="tab-pane active" id="activos">
              
                
					<div class="pull-right" style="margin-right:15px;">
						<input type="text" value="" class="form-control" id="search_activos" name="search_activos" onkeyup="load_activos_fijos(1)" placeholder="search.."/>
						
					</div>
					<div id="load_activos_fijos" ></div>
					<div id="activos_fijos_registrados"></div>	
                <button type="button" id="exportar" name="exportar" value="Exportar"   class="btn btn-primary" ><i class="fa fa-file-excel-o"></i></button>
               </div>
    		 </div>
            </div>
          </div>
            </div>
            </div>
            </section>
            
  </div>
 
 	<?php include("view/modulos/footer.php"); ?>	

   <div class="control-sidebar-bg"></div>
 </div>
    
    <?php include("view/modulos/links_js.php"); ?>
    <script src="view/bootstrap/otros/inputmask_bundle/jquery.inputmask.bundle.js"></script>
	<script src="view/Contable/FuncionesJS/ActivosFijos.js?1"></script> 
	
  </body>
</html>   

 