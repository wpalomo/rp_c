<!DOCTYPE html>
<html lang="en">
  <head>
   <script lang=javascript src="view/Contable/FuncionesJS/xlsx.full.min.js"></script>
      <script lang=javascript src="view/Contable/FuncionesJS/FileSaver.min.js"></script>
    
    
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Capremci</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
      
      
   <?php include("view/modulos/links_css.php"); ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    
   
  </head>

  <body class="hold-transition skin-blue fixed sidebar-mini">

 <?php  $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        $DateString = (string)$fecha;
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
                <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Usuarios</li>
            </ol>
        </section>
        
        <!-- comienza diseño controles usuario -->
        
        <section class="content">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registrar Usuarios</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                
              </div>
            </div>
            
            <div class="box-body">
            
                <form action="<?php echo $helper->url("Usuarios","InsertaUsuarios"); ?>" method="post" enctype="multipart/form-data" class="col-lg-12 col-md-12 col-xs-12">
          		 	  <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
              		 	 <div class="row">
                         	<div class="col-xs-6 col-md-3 col-lg-3 ">
                            	<div class="form-group">
                                	<label for="cedula_usuarios" class="control-label">Cedula:</label>
                                    <input type="text" class="form-control" id="cedula_usuarios" name="cedula_usuarios" value="<?php echo $resEdit->cedula_usuarios; ?>"  placeholder="ci-ruc.." readonly>
                                    <input type="hidden" class="form-control" id="id_usuarios" name="id_usuarios" value="<?php echo $resEdit->id_usuarios; ?>" >
                                    <div id="mensaje_cedula_usuarios" class="errores"></div>
                                 </div>
                             </div>
                             <div class="col-xs-6 col-md-3 col-lg-3">
                             	<div class="form-group">
                                	 <label for="nombre_usuarios" class="control-label">Nombres:</label>
                                      <input type="text" class="form-control" id="nombre_usuarios" name="nombre_usuarios" value="<?php echo $resEdit->nombre_usuarios; ?>" placeholder="nombres..">
                                      <div id="mensaje_nombre_usuarios" class="errores"></div>
                                 </div>
                             </div>
                             <div class="col-xs-6 col-md-3 col-lg-3">
                             	<div class="form-group">
                                	 <label for="apellidos_usuarios" class="control-label">Apellidos:</label>
                                      <input type="text" class="form-control" id="apellidos_usuarios" name="apellidos_usuarios" value="<?php echo $resEdit->apellidos_usuarios; ?>" placeholder="nombres..">
                                      <div id="mensaje_apellido_usuarios" class="errores"></div>
                                 </div>
                             </div>
                             <div class="col-xs-6 col-md-3 col-lg-3 ">
                            	<div class="form-group">
                                	<label for="usuario_usuarios" class="control-label">Usuario:</label>
                                    <input type="text" class="form-control" id="usuario_usuarios" name="usuario_usuarios" value="<?php echo $resEdit->usuario_usuarios; ?>"  placeholder="usuario..." >
                                    <div id="usuario_usuarios" class="errores"></div>
                                 </div>
                             </div> 
                          </div>
                          <div class="row">
                          
                          	<div class="col-xs-6 col-md-3 col-lg-3 ">
                          		<div class="form-group">
                             		 	<label for="fecha_nacimiento_usuarios" class="control-label">Fecha Nacimiento:</label>
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <input type="date" class="form-control" id="fecha_nacimiento_usuarios" name="fecha_nacimiento_usuarios" value="<?php echo $resEdit->fecha_nacimiento_usuarios; ?>"  >
                                          <div id="mensaje_fecha_nacimiento_usuarios" class="errores"></div>
                                        </div>
                                        <!-- /.input group -->
                                      </div>                            	
                             </div> 
                             
                             <div class="col-lg-3 col-xs-6 col-md-3">
                             
                                 <div class="form-group">
                                    <label>Celular:</label>
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-tablet"></i>
                                      </div>
                                      <input type="text" id="celular_usuarios" name="celular_usuarios" value="<?php echo $resEdit->celular_usuarios; ?>" class="form-control" data-inputmask='"mask": "999-999-9999"' data-mask>
                                      <div id="mensaje_celular_usuarios" class="errores"></div>
                                    </div>
                                    <!-- /.input group -->
                                  </div>
                    		    
                             </div>
                             
                             <div class="col-lg-3 col-xs-6 col-md-3">
                             	<div class="form-group">
                                        <label>Telefono:</label>
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                          </div>
                                          <input type="text" class="form-control"  id="telefono_usuarios" name="telefono_usuarios" value="<?php echo $resEdit->telefono_usuarios; ?>"  data-inputmask='"mask": "(99) 9999-999"' data-mask>
                                        </div>
                                        <!-- /.input group -->
                                  </div>
                    		   
                    	    </div>
                    	    
                    	    
                    	    <div class="col-lg-3 col-xs-12 col-md-3">
                        		    <div class="form-group">
                                          <label for="correo_usuarios" class="control-label">Correo:</label>
                                          <input type="email" class="form-control" id="correo_usuarios" name="correo_usuarios" value="<?php echo $resEdit->correo_usuarios; ?>" placeholder="email..">
                                          <div id="mensaje_correo_usuarios" class="errores"></div>
                                    </div>
                    		    </div>
                                
                        	                            
                          </div>
                          
                          <div class="row">
                		       
                		       <div class="col-xs-6 col-md-3 col-lg-3">
                        		<div class="form-group">
                                  <label for="clave_usuarios" class="control-label">Password:</label>
                                  <input type="password" class="form-control caducaclave" id="clave_usuarios" name="clave_usuarios" value="<?php echo $resEdit->clave_n_claves; ?>" placeholder="(solo números..)" maxlength="4" onkeypress="return numeros(event)" readonly>
                                  <div id="mensaje_clave_usuarios" class="errores"></div>
                                </div>
                            	</div>
                            		    
                    		    <div class="col-lg-3 col-xs-6 col-md-3">
                    		    <div class="form-group">
                                      <label for="clave_usuarios_r" class="control-label">Repita Password:</label>
                                      <input type="password" class="form-control" id="clave_usuarios_r" name="clave_usuarios_r" value="<?php echo $resEdit->clave_n_claves; ?>" placeholder="(solo números..)" maxlength="4" onkeypress="return numeros(event)" readonly>
                                      <div id="mensaje_clave_usuarios_r" class="errores"></div>
                                </div>
                                </div>
                    			
                    		    
                    		    <div class="col-xs-12 col-md-3 col-lg-3">
                        		   <div class="form-group">
                                      <label for="id_estado" class="control-label">Estado:</label>
                                      <select name="id_estado" id="id_estado"  class="form-control" >
                                      <option value="0" selected="selected">--Seleccione--</option>
    									<?php  foreach($result_catalogo_usuario as $res) {?>
    										<option value="<?php echo $res->valor_catalogo; ?>" <?php if ($res->valor_catalogo == $resEdit->estado_usuarios )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_catalogo; ?> </option>
    							        <?php } ?>
    								   </select> 
                                      <div id="mensaje_id_estados" class="errores"></div>
                                    </div>
                                  </div>
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                        		    <div class="form-group">
                                          <label for="fotografia_usuarios" class="control-label">Fotografía:</label>
                                          <input type="file" class="form-control" id="fotografia_usuarios" name="fotografia_usuarios" value="">
                                          <div id="mensaje_usuario" class="errores"></div>
                                    </div>
                    		    </div>
                        	</div>
                        	
                        	
                    		
                    		<div class="row"> 
                    		
                    			<div class="col-xs-12 col-lg-3 col-md-3">
                        		   <div class="form-group">
                                      <label for="id_rol_principal" class="control-label">Rol :</label>
                                      <select name="id_rol_principal" id="id_rol_principal"  class="form-control" >
                                      <option value="0" selected="selected">--Seleccione--</option>
    									<?php foreach($resultRol as $res) {?>
    										<option value="<?php echo $res->id_rol; ?>" <?php if ($res->id_rol == $resEdit->id_rol )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_rol; ?> </option>
    							        <?php } ?>
    								   </select> 
                                      <div id="mensaje_id_rols" class="errores"></div>
                                    </div>
                                 </div> 
                                 
                                 <div class="col-xs-12 col-lg-3 col-md-3">                                  
                        		   <div class="form-group">
                        		   <br>
                        		   	  <input type="hidden" class="form-control" id="codigo_clave" name="codigo_clave" value="<?php echo $resEdit->clave_n_claves; ?>" >
                                      <label for="cambiar_clave" class="control-label">Cambiar Clave: </label> &nbsp;&nbsp;
                                      <input type="checkbox"  id="cambiar_clave" name="cambiar_clave" value="1"   /> <br>
                                      <label for="caduca_clave" class="control-label">Caduca  Clave: </label> &nbsp;&nbsp; &nbsp;
                                      <input type="checkbox"  id="caduca_clave" name="caduca_clave" value="1" <?php  if($resEdit->caduca_claves=='t'){echo 'checked="checked" ';} ?>  />
                                    </div>
                                 </div> 
                                 
                              </div>
                              
                                
                      <?php } } else {?>                		    
                      	  <div class="row">
                		  	<div class="col-xs-6 col-md-3 col-lg-3 ">
                    			<div class="form-group">
                                    <label for="cedula_usuarios" class="control-label">Cedula:</label>
                                    <input type="text" class="form-control" id="cedula_usuarios" name="cedula_usuarios" value=""  placeholder="ci-ruc.." >
                                     <input type="hidden" class="form-control" id="id_usuarios" name="id_usuarios" value="0" >
                                    <div id="mensaje_cedula_usuarios" class="errores"></div>
                                 </div>
                             </div>
                             <div class="col-xs-6 col-md-3 col-lg-3">
                             	<div class="form-group">
                                	 <label for="nombre_usuarios" class="control-label">Nombres:</label>
                                      <input type="text" class="form-control" id="nombre_usuarios" name="nombre_usuarios" value="" placeholder="nombres..">
                                      <div id="mensaje_nombre_usuarios" class="errores"></div>
                                 </div>
                             </div>
                             <div class="col-xs-6 col-md-3 col-lg-3">
                             	<div class="form-group">
                                	 <label for="apellidos_usuarios" class="control-label">Apellidos:</label>
                                      <input type="text" class="form-control" id="apellidos_usuarios" name="apellidos_usuarios" value="" placeholder="apellidos..">
                                      <div id="mensaje_apellido_usuarios" class="errores"></div>
                                 </div>
                             </div>
                             
                             <div class="col-xs-6 col-md-3 col-lg-3 ">
                                	<div class="form-group">
                                    	<label for="usuario_usuarios" class="control-label">Usuario:</label>
                                        <input type="text" class="form-control" id="usuario_usuarios" name="usuario_usuarios" value=""  placeholder="usuario..." >
                                        <div id="mensaje_usuario_usuarios" class="errores"></div>
                                     </div>
                                 </div>
                             </div>
                                  
                             <div class="row">
                             	
                             	<div class="col-xs-6 col-md-3 col-lg-3 ">
                             		 <div class="form-group">
                             		 	<label for="fecha_nacimiento_usuarios" class="control-label">Fecha Nacimiento:</label>
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <input type="date" class="form-control" id="fecha_nacimiento_usuarios" name="fecha_nacimiento_usuarios" value="" min="2001-01-01" max="<?php echo date("Y-m-d");?>"  step="2" required>
                                         <div id="mensaje_fecha_nacimiento_usuarios" class="errores"></div>
                                        </div>
                                         
                                        <!-- /.input group -->
                                      </div>
                                	
                                   </div>  
                                
                                 
                                 <div class="col-lg-3 col-xs-6 col-md-3">
                                 	<div class="form-group">
                                        <label>Celular:</label>
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-tablet"></i>
                                          </div>
                                          <input type="text" id="celular_usuarios" name="celular_usuarios" value="" class="form-control" data-inputmask='"mask": "999-999-9999"' data-mask>
                                          <div id="mensaje_celular_usuarios" class="errores"></div>
                                        </div>
                                        <!-- /.input group -->
                                      </div>
                                </div>
                                
                                <div class="col-lg-3 col-xs-6 col-md-3">
                                	<div class="form-group">
                                        <label>Telefono:</label>
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                          </div>
                                          <input type="text" class="form-control" id="telefono_usuarios" name="telefono_usuarios" value=""  data-inputmask='"mask": "(99) 9999-999"' data-mask>
                                        </div>
                                        <!-- /.input group -->
                                      </div>
                        		    
                        	    </div>
                        	    
                        	    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                        		    <div class="form-group">
                                          <label for="correo_usuarios" class="control-label">Correo:</label>
                                          <input type="email" class="form-control" id="correo_usuarios" name="correo_usuarios" value="" placeholder="email..">
                                          <div id="mensaje_correo_usuarios" class="errores"></div>
                                    </div>
                    		    </div>
                    		    									
                                
                             	                            
                              </div>
                            
                          
                          <div class="row">                		      
                    			
                    		    <div class="col-xs-6 col-md-3 col-lg-3">
                            		<div class="form-group">
                                      <label for="clave_usuarios" class="control-label">Password:</label>
                                      <input type="password" class="form-control" id="clave_usuarios" name="clave_usuarios" value="" placeholder="(solo números..)" maxlength="4" onkeypress="return numeros(event)">
                                      <div id="mensaje_clave_usuarios" class="errores"></div>
                                    </div>
                            	</div>
                            	
                            	<div class="col-lg-3 col-xs-6 col-md-3">
                        		    <div class="form-group">
                                          <label for="clave_usuarios_r" class="control-label">Repita Password:</label>
                                          <input type="password" class="form-control" id="clave_usuarios_r" name="clave_usuarios_r" value="" placeholder="(solo números..)" maxlength="4" onkeypress="return numeros(event)">
                                          <div id="mensaje_clave_usuarios_r" class="errores"></div>
                                    </div>
                                </div>
                                
                    		    <div class="col-xs-12 col-md-3 col-lg-3">
                        		   <div class="form-group">
                                      <label for="id_estado" class="control-label">Estado:</label>
                                      <select name="id_estado" id="id_estado"  class="form-control" >
                                      <option value="0" selected="selected">--Seleccione--</option>
    									<?php foreach($resEstado as $res) {?>
    										<option value="<?php echo $res->id_esatdo; ?>" ><?php echo $res->nombre_estado; ?> </option>
    							        <?php } ?>
    								   </select> 
                                      <div id="mensaje_id_estados" class="errores"></div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-lg-3 col-xs-12 col-md-3">
                        		    <div class="form-group">
                                          <label for="fotografia_usuarios" class="control-label">Fotografía:</label>
                                          <input type="file" class="form-control" id="fotografia_usuarios" name="fotografia_usuarios" value="">
                                          <div id="mensaje_fotografia_usuario" class="errores"></div>
                                    </div>
                    		    </div>
                        	</div>
                        	
                        	<div class="row"> 
                    		    		    
                        		<div class="col-xs-12 col-lg-3 col-md-3">
                        		   <div class="form-group">
                                      <label for="id_rol_principal" class="control-label">Rol:</label>
                                      <select name="id_rol_principal" id="id_rol_principal"   class="form-control" >
                                      <option value="0" selected="selected">--Seleccione--</option>
    									<?php foreach($resultRol as $res) {?>
    										<option value="<?php echo $res->id_rol; ?>" ><?php echo $res->nombre_rol; ?> </option>
    							        <?php } ?>
    								   </select> 
                                      <div id="mensaje_id_rol_principal" class="errores"></div>
                                    </div>
                                 </div>
                                 
                                 <div class="col-xs-12 col-lg-3 col-md-3">                                  
                        		   <div class="form-group" >
                        		   <br>
                        		   	  <input type="hidden" class="form-control" id="codigo_clave" name="codigo_clave" value="0" />
                        		   	  <label for="cambiar_clave" class="control-label" id="lbl_cambiar_clave"></label>&nbsp;&nbsp;
                        		   	  <input type="checkbox"  id="cambiar_clave" name="cambiar_clave" value="0"  style="display:none" /> <br>
                                      <label for="id_rol_principal" class="control-label">Caduca Clave: </label> &nbsp;&nbsp;
                                      <input type="checkbox" id="caduca_clave" name="caduca_clave" value=""  />
                                    </div>
                                 </div> 
                                 
                             </div>
                        	
                        	
                        	
                        	
                    		            
                     <?php } ?>
                     	<div class="row">
            			    <div class="col-xs-12 col-md-12 col-md-12 " style="margin-top:15px;  text-align: center; ">
                	   		    <div class="form-group">
            	                  <button type="submit" id="Guardar" name="Guardar" class="btn btn-success">GUARDAR</button>
            	                  <a class="btn btn-danger" href="<?php  echo $helper->url("Usuarios","index"); ?>">CANCELAR</a>
        	                    </div>
    	        		    </div>
    	        		    
            		    </div>
          		 	
          		 	</form>
          
        			</div>
      			</div>
      			
      			<div id="resultadosjq">
      			
      			</div>
    		</section>
    		
    		
    		
    		
       <section class="content">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Listado Usuarios</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                
              </div>
            </div>
            
            <div class="box-body">
			<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activos" data-toggle="tab">Usuarios Activos</a></li>
              <li><a href="#inactivos" data-toggle="tab">Usuarios Inactivos</a></li>
            </ul>
            
            <div class="col-md-12 col-lg-12 col-xs-12">
            <div class="tab-content">
             
            <br>
              <div class="tab-pane active" id="activos">
              
                
					<div class="pull-right" style="margin-right:15px;">
					
						<input type="text" value="" class="form-control" id="search" name="search" onkeyup="load_usuarios(1)" placeholder="search.."/>
					</div>
					<div id="load_registrados" ></div>	
					<div id="users_registrados"></div>	
                
              </div>
              
              <div class="tab-pane" id="inactivos">
                
                    <div class="pull-right" style="margin-right:15px;">
					<input type="text" value="" class="form-control" id="search_inactivos" name="search_inactivos" onkeyup="load_usuarios_inactivos(1)" placeholder="search.."/>
					</div>
					
					
					<div id="load_inactivos_registrados" ></div>	
					<div id="users_inactivos_registrados"></div>
                
                
              </div>
             
              <button type="submit" id="btExportar" name="exportar" class="btn btn-info">Exportar</button>
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
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
   <script src="view/bootstrap/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="view/bootstrap/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="view/bootstrap/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="view/bootstrap/otros/inputmask_bundle/jquery.inputmask.bundle.js"></script>  
   <script src="view/Contable/FuncionesJS/Usuarios.js?1"></script>         	
  </body>
</html>

 