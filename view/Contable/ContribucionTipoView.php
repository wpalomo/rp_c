    <!DOCTYPE HTML>
	<html lang="es">
    <head>
        
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Capremci</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" type="image/png" href="view/bootstrap/otros/login/images/icons/favicon.ico"/>
  
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
        <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Productos</li>
      </ol>
    </section>



    <section class="content">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Registrar Contribucion Tipo</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        
        <div class="box-body">
          
        
        <form action="<?php echo $helper->url("ContribucionTipo","InsertaContribucionTipo"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                                <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
                                
                                <div class="row">
                        		    
                        		    
                        			    <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                       
                                                          <label for="id_contribucion_categoria" class="control-label">Grupos</label>
                                                          <select name="id_contribucion_categoria" id="id_contribucion_categoria"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultCat as $resCat) {?>
				 												<option value="<?php echo $resCat->id_contribucion_categoria; ?>" <?php if ($resCat->id_contribucion_categoria == $resEdit->id_contribucion_categoria )  echo  ' selected="selected" '  ;  ?> ><?php echo $resCat->nombre_contribucion_categoria; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										  <div id="mensaje_id_contribucion_categoria" class="errores"></div>
                                    </div>
                                    </div>
                        		      
									<div class="col-xs-12 col-md-3 col-md-3 ">
                        		  <div class="form-group">
                                  <label for="nombre_contribucion_tipo" class="control-label">Nombre</label>
                                  <input type="text" class="form-control" id="nombre_contribucion_tipo" name="nombre_contribucion_tipo" value="<?php echo $resEdit->nombre_contribucion_tipo; ?>"  placeholder="Nombre de Estatus">
                                  <div id="mensaje_nombre_contribucion_tipo" class="errores"></div>
                                    </div>
                        		    </div>   
                        		    
                        		    	    <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                       
                                                          <label for="id_estado" class="control-label">Estados</label>
                                                          <select name="id_estado" id="id_estado"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultEst as $resEst) {?>
				 												<option value="<?php echo $resEst->id_estado; ?>" <?php if ($resEst->id_estado == $resEdit->id_estado )  echo  ' selected="selected" '  ;  ?> ><?php echo $resEst->nombre_estado; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										  <div id="mensaje_id_estado" class="errores"></div>
                                    </div>
                                    </div>
                        		
                        		    	    <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                       
                                                          <label for="id_estatus" class="control-label">Estatus</label>
                                                          <select name="id_estatus" id="id_estatus"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultEsta as $resEsta) {?>
				 												<option value="<?php echo $resEsta->id_estatus; ?>" <?php if ($resEsta->id_estatus == $resEdit->id_estatus )  echo  ' selected="selected" '  ;  ?> ><?php echo $resEsta->nombre_estatus; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										  <div id="mensaje_id_estatus" class="errores"></div>
                                    </div>
                                    </div>    
                    	
                        		    </div>
                                 
                                
                    		     <?php } } else {?>
                    		          <div class="row">
                     
                    		       <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                          <label for="id_contribucion_categoria" class="control-label">Categoria</label>
                                                          <select name="id_contribucion_categoria" id="id_contribucion_categoria"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultCat as $resCat) {?>
				 												<option value="<?php echo $resCat->id_contribucion_categoria; ?>"  ><?php echo $resCat->nombre_contribucion_categoria; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										   <div id="mensaje_id_contribucion_categoria" class="errores"></div>
                                    </div>
                                    </div>
                    		   
		                       <div class="col-xs-12 col-md-3 col-md-3 ">
                        	    <div class="form-group">
                                  <label for="nombre_contribucion_tipo" class="control-label">Nombre</label>
                                  <input type="text" class="form-control" id="nombre_contribucion_tipo" name="nombre_contribucion_tipo" value=""  placeholder="nombre de Estatus">
                                   <div id="mensaje_nombre_contribucion_tipo" class="errores"></div>
            					</div>
	       		               </div>
	       		            
                		        <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                          <label for="id_estado" class="control-label">Estado</label>
                                                          <select name="id_estado" id="id_estado"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultEst as $resEst) {?>
				 												<option value="<?php echo $resEst->id_estado; ?>"  ><?php echo $resEst->nombre_estado; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										   <div id="mensaje_id_estado" class="errores"></div>
                                    </div>
                                    </div>
                                    
                                      <div class="col-xs-12 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                          <label for="id_estatus" class="control-label">Estatus</label>
                                                          <select name="id_estatus" id="id_estatus"  class="form-control">
                                                            <option value="0" selected="selected">--Seleccione--</option>
																<?php foreach($resultEsta as $resEsta) {?>
				 												<option value="<?php echo $resEsta->id_estatus; ?>"  ><?php echo $resEsta->nombre_estatus; ?> </option>
													            <?php } ?>
								    					  </select>
		   		   										   <div id="mensaje_id_estatus" class="errores"></div>
                                    </div>
                              </div>
                		          </div>
                    	         	                     	           	
                    		     <?php } ?>
                    		
                    		    <br>  
                    		    <div class="row">
                    		    <div class="col-xs-12 col-md-4 col-lg-4" style="text-align: left;">
                    		    <div class="form-group">
                                                      <button type="submit" id="Guardar" name="Guardar" class="btn btn-success"><i class='glyphicon glyphicon-plus'></i> Guardar</button>
                                                      <a href="index.php?controller=ContribucionTipo&action=index" class="btn btn-primary"><i class='glyphicon glyphicon-remove'></i> Cancelar</a>
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
          <h3 class="box-title">Contribucion Tipo</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        
        <div class="box-body">
        
        
       <div class="ibox-content">  
      <div class="table-responsive">
        
      
      
  <table  class="table table-striped table-bordered table-hover dataTables-example">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Categoria</th>
                          <th>Nombre</th>
                          <th>Estado</th>
                          <th>Estatus</th>
                       
                          <th></th>
                          <th></th>
                         
                        </tr>
                      </thead>

                      <tbody>
    					<?php $i=0;?>
    						<?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
    						<?php $i++;?>
            	        		<tr>
            	                   <td > <?php echo $i; ?>  </td>
            		               <td > <?php echo $res->nombre_contribucion_categoria; ?>     </td> 
            		               <td > <?php echo $res->nombre_contribucion_tipo; ?>     </td> 
                		            <td > <?php echo $res->nombre_estado; ?>     </td> 
                		            <td > <?php echo $res->nombre_estatus; ?>     </td> 
                		            
            		                
            		           	   <td>
            			           		<div class="right">
            			                    <a href="<?php echo $helper->url("ContribucionTipo","index"); ?>&id_contribucion_tipo=<?php echo $res->id_contribucion_tipo; ?>" class="btn btn-warning" style="font-size:65%;" data-toggle="tooltip" title="Editar"><i class='glyphicon glyphicon-edit'></i></a>
            			                </div>
            			            
            			             </td>
            			             <td>   
            			                	<div class="right">
            			                    <a href="<?php echo $helper->url("ContribucionTipo","borrarId"); ?>&id_contribucion_tipo=<?php echo $res->id_contribucion_tipo; ?>" class="btn btn-danger" style="font-size:65%;" data-toggle="tooltip" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a>
            			                </div>
            			                
            		               </td>
            		    		</tr>
            		    		
            		        <?php } } ?>
 
                      </tbody>
                    </table>
     
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
       <script>
      $(document).ready(function(){
      $(".cantidades1").inputmask();
      });
	  </script>
    
           <script>
           // Campos Vacíos
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#Guardar").click(function() 
			{
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var nombre_estatus = $("#nombre_estatus").val();
		    	
		    	if (nombre_estatus == "")
		    	{
		    		$("#mensaje_nombre_estatus").text("Introduzca Un Nombre");
		    		$("#mensaje_nombre_estatus").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_nombre_estatus").fadeOut("slow"); //Muestra mensaje de error
		            
				}   

		    	
		    	
		    	
			}); 


		        $( "#nombre_estatus" ).focus(function() {
				  $("#mensaje_nombre_estatus").fadeOut("slow");
			    });
		}); 

	</script>	
	
		<script type="text/javascript">
     
	   $(document).ready( function (){
		   
		   load_bodegas_inactivos(1);
		   load_bodegas_activos(1);
		   
		});
        
	   function load_bodegas_activos(pagina){

		   var search=$("#search_activos").val();
	       var con_datos={
					  action:'ajax',
					  page:pagina
					  };
			  
	     $("#load_bodegas_activos").fadeIn('slow');
	     
	     $.ajax({
	               beforeSend: function(objeto){
	                 $("#load_bodegas_activos").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>');
	               },
	               url: 'index.php?controller=Bodegas&action=consulta_bodegas_activos&search='+search,
	               type: 'POST',
	               data: con_datos,
	               success: function(x){
	                 $("#bodegas_activos_registrados").html(x);
	                 $("#load_bodegas_activos").html("");
	                 $("#tabla_bodegas_activos").tablesorter(); 
	                 
	               },
	              error: function(jqXHR,estado,error){
	                $("#bodegas_activos_registrados").html("Ocurrio un error al cargar la informacion de Bodegas Activos..."+estado+"    "+error);
	              }
	            });


		   }

	   function load_bodegas_inactivos(pagina){

		   var search=$("#search_inactivos").val();
	       var con_datos={
					  action:'ajax',
					  page:pagina
					  };
			  
	     $("#load_bodegas_inactivos").fadeIn('slow');
	     
	     $.ajax({
	               beforeSend: function(objeto){
	                 $("#load_bodegas_inactivos").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>');
	               },
	               url: 'index.php?controller=Bodegas&action=consulta_bodegas_inactivos&search='+search,
	               type: 'POST',
	               data: con_datos,
	               success: function(x){
	                 $("#bodegas_inactivos_registrados").html(x);
	                 $("#load_bodegas_inactivos").html("");
	                 $("#tabla_bodegas_inactivos").tablesorter(); 
	                 
	               },
	              error: function(jqXHR,estado,error){
	                $("#bodegas_inactivos_registrados").html("Ocurrio un error al cargar la informacion de Bodegas Inactivos..."+estado+"    "+error);
	              }
	            });


		   }

	  
        	        	   

 </script>
	
  </body>
</html>   



