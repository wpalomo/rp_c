<!DOCTYPE HTML>
	<html lang="es">
    <head>
        
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Capremci</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="icon" type="image/png" href="view/bootstrap/otros/login/images/icons/favicon.ico"/>
    <?php include("view/modulos/links_css.php"); ?>		
      
    	
	
		    
	</head>
 
    <body class="hold-transition skin-blue fixed sidebar-mini" ng-app="myApp" ng-controller="myCtrl">
    
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
        <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Inventario</a></li>
        <li class="active">Productos</li>
      </ol>
    </section>

    
 <section class="content">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Inventario de los Productos</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                
              </div>
            </div>
            
            <div class="box-body">

           <br>
              <div class="tab-pane active" id="productos">
                
					<div class="pull-right" style="margin-right:15px;">
						<input type="text" value="" class="form-control" id="search_buscar_productos" name="search_buscar_productos" onkeyup="load_buscar_productos(1)" placeholder="search.."/>
					</div>
					<div id="load_buscar_productos" ></div>	
					<div id="productos_registrados"></div>	
                
              </div>
                 		  <a href="index.php?controller=BuscarProducto&action=reporte_stock_productos" target="_blank"><input type="image" src="view/images/print.png" alt="Submit" width="50" height="34" formtarget="_blank" id="btngenerar" name="btngenerar" class="btn btn-default" title="Reporte Productos"></label></a>
         
              
            </div>
            </div>
            </section>
    
     
    
  </div>
 
 	<?php include("view/modulos/footer.php"); ?>	

   <div class="control-sidebar-bg"></div>
 </div>
    
    <?php include("view/modulos/links_js.php"); ?>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
	
    <script type="text/javascript" >   
    
    	function numeros(e){
    		  var key = window.event ? e.which : e.keyCode;
    		  if (key < 48 || key > 57) {
    		    e.preventDefault();
    		  }
     }
    </script> 
    
<script type="text/javascript">

        	   $(document).ready( function (){
        		   
        		 
        		   load_buscar_productos(1);
        		   
	   			});

        	


	   function load_buscar_productos(pagina){

		   var search=$("#search_buscar_productos").val();
	       var con_datos={
					  action:'ajax',
					  page:pagina
					  };
			  
	     $("#load_buscar_productos").fadeIn('slow');
	     
	     $.ajax({
	               beforeSend: function(objeto){
	                 $("#load_buscar_productos").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>');
	               },
	               url: 'index.php?controller=BuscarProducto&action=consulta_productos&search='+search,
	               type: 'POST',
	               data: con_datos,
	               success: function(x){
	                 $("#productos_registrados").html(x);
	                 $("#load_buscar_productos").html("");
	                 $("#tabla_productos").tablesorter(); 
	                 
	               },
	              error: function(jqXHR,estado,error){
	                $("#productos_registrados").html("Ocurrio un error al cargar la informacion de Productos..."+estado+"    "+error);
	              }
	            });


		   }



 </script>
	
	<script src="view/bootstrap/otros/inputmask_bundle/jquery.inputmask.bundle.js"></script>
  	  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      
    <script src="view/Contable/FuncionesJS/ActivosFijosD.js?1.0"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    
    
    
    
    
    
	
  </body>
</html>  