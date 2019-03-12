<?php

class PermisosRolesController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		session_start();
	
	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
			$permisos_rol = new PermisosRolesModel();
			
			$nombre_controladores = "PermisosRoles";
			$id_rol= $_SESSION['id_rol'];
			if (isset($_POST['selected_rol']))
			{
			    $selrol=$_POST['selected_rol'];
			    $this->view_Administracion("PermisosRoles",array(
			        "selrol"=>$selrol
			    ));
			}
			
			$resultPer = $permisos_rol->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			

                    $columnas = "permisos_rol.id_permisos_rol, rol.nombre_rol, permisos_rol.nombre_permisos_rol, controladores.nombre_controladores, permisos_rol.ver_permisos_rol, permisos_rol.guardar_permisos_rol, permisos_rol.editar_permisos_rol, permisos_rol.borrar_permisos_rol  ";
					$tablas   = "public.controladores,  public.permisos_rol, public.rol";
					$where    = " controladores.id_controladores = permisos_rol.id_controladores AND permisos_rol.id_rol = rol.id_rol";
					$id       = " permisos_rol.id_permisos_rol";
						
					$permisos_rol = new PermisosRolesModel();
					$resultSet=$permisos_rol->getCondiciones($columnas ,$tablas ,$where, $id);
					
					
			
			if (!empty($resultPer))
			{
					
					//roles
					$rol = new RolesModel();
					$resultRol=$rol->getAll("nombre_rol");
					
					$controladores=new ControladoresModel();
					$resultCon=$controladores->getAll("nombre_controladores");
			
			
					$resultEdit = "";
					$resul = "";
			
					if (isset ($_GET["id_permisos_rol"])   )
					{
						$nombre_controladores = "PermisosRoles";
						$id_rol= $_SESSION['id_rol'];
						$resultPer = $permisos_rol->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
						if (!empty($resultPer))
						{
						
							$_id_permisos_rol = $_GET["id_permisos_rol"];
							$resultEdit = $permisos_rol->getBy("id_permisos_rol = '$_id_permisos_rol' ");
							
						}
						else
						{
						    $this->view_Administracion("Error",array(
									"resultado"=>"No tiene Permisos de Editar Permisos Roles"
						
									
							));
						
							exit();
						}
						
						
						
					}
			
					
					$this->view_Administracion("PermisosRoles",array(
							"resultCon"=>$resultCon, "resultSet"=>$resultSet,  "resultEdit"=>$resultEdit, "resultRol"=>$resultRol
					));
			
			
			}
			else
			{
			    $this->view_Administracion("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Permisos Rol"
			
				));
			
			
			}
				}
	else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
	
	}
	
	public function Cargar_arbol(){
	    
	    session_start();
	    
	    
	    if (isset(  $_SESSION['nombre_usuarios']) )
	    {
	        
	        $permisos_rol = new PermisosRolesModel();
	        $rol = new RolesModel();
	        $controladores = new ControladoresModel();
	        
	        $nombre_controladores = "PermisosRoles";
	        $id_rol= $_SESSION['id_rol'];
	        if (isset($_POST['selected_rol']))
	        {
	            
	            
	            
	            $selrol=$_POST['selected_rol'];
	        }
	        
	        $resultPer = $permisos_rol->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	         
	        $columnas1 = "rol.id_rol";
	        $tablas1   = "public.rol";
	        $where1    = "rol.nombre_rol='".$selrol."'";
	        $id1       = "rol.id_rol";
	        
	                
	         if ($selrol!='0') 
	         {
	             $rolId = $rol->getCondiciones($columnas1 ,$tablas1 ,$where1, $id1);
	             $columnas = "controladores.nombre_controladores, modulos.id_modulos,
                         permisos_rol.ver_permisos_rol,
                         permisos_rol.guardar_permisos_rol,
                         permisos_rol.editar_permisos_rol, permisos_rol.borrar_permisos_rol";
	             $tablas   = "public.controladores INNER JOIN public.permisos_rol
                         ON permisos_rol.id_controladores = controladores.id_controladores
                         INNER JOIN public.modulos ON modulos.id_modulos = controladores.id_modulos";
	             $where    = "permisos_rol.id_rol=".$rolId[0]->id_rol;
	             $id       = "controladores.id_modulos, controladores.nombre_controladores ";
	             
	             $resultSet=$permisos_rol->getCondiciones($columnas ,$tablas ,$where, $id);
	             
	             $columnas1 = "controladores.nombre_controladores, controladores.id_modulos";
	             $tablas1   = "public.controladores ";
	             $where1    = "1=1";
	             $id1       ="controladores.id_modulos";
	             
	             $columnas2 = "DISTINCT modulos.nombre_modulos, modulos.id_modulos";
	             $tablas2   = "public.modulos";
	             $where2    = "1=1";
	             $id2= "modulos.id_modulos";
	             
	             $columnas3 = "controladores.nombre_controladores, controladores.id_modulos";
	             $tablas3   = "public.controladores";
	             $where3    = "1=1";
	             $id3= "controladores.id_modulos, controladores.nombre_controladores";
	             
	             $resultSetV=$permisos_rol->getCondiciones($columnas1 ,$tablas1 ,$where1, $id1);
	             $resultMod=$permisos_rol->getCondiciones($columnas2 ,$tablas2 ,$where2, $id2);
	             $resultCtr=$permisos_rol->getCondiciones($columnas3 ,$tablas3 ,$where3, $id3);
	             
	             
	             if (!empty($resultPer))
	             {
	                 
	                 //roles
	                 $html='';
	                 
	                 if (!empty($rolId))
	                 {
	                     
	                     if (!empty($resultSet))
	                     {   
	                         $html.='<ul id="PermisosList">';
	                         $indm=1;
	                         foreach ($resultMod as $rm)
	                         {
	                             $html.='<li><input type="checkbox" onclick= "RevisaModulos(&quot;'.$rm->nombre_modulos.'&quot;)" class="sup" name="modulo" value="'.$rm->nombre_modulos.'">'.$rm->nombre_modulos.'<span class="caret"></span>';
	                             $html.='<ul id="contlist'.$indm.'" class ="nested active">';
	                             
	                         $ind=1;
	                         for ($i=0;$i<sizeof($resultCtr); $i++)
	                         {
	                             if($resultCtr[$i]->id_modulos == $rm->id_modulos)
	                             {
	                                 $gettfv=0;
	                                 $jindex=0;
	                                 $html.='<li><input type="checkbox" onclick="RevisaControladores(&quot;'.$resultCtr[$i]->nombre_controladores.'&quot;)" class ="cont'.$indm.''.$ind.'" name="controlador" value="'.$resultCtr[$i]->nombre_controladores.'">'.$resultCtr[$i]->nombre_controladores.'<span class="caret"></span>';
	                                $html.='<ul id="permlist'.$indm.''.$ind.'" class ="nested">';
	                                for ($j=0;$j<sizeof($resultSet); $j++)
	                                {
	                                    if ($resultSet[$j]->nombre_controladores == $resultCtr[$i]->nombre_controladores)
	                                    {
	                                        $gettfv=1;
	                                        $jindex=$j;
	                                    }
	                                    
	                                }
	                                if($gettfv==1)
	                                {if($resultSet[$jindex]->ver_permisos_rol == 't') $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="ver" value="ver" checked>Ver</li>';
	                                else $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="ver" value="ver">Ver</li>';
	                                if($resultSet[$jindex]->guardar_permisos_rol == 't') $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="guardar" value="guardar" checked>Guardar</li>';
	                                else $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="guardar" value="guardar">Guardar</li>';
	                                if($resultSet[$jindex]->editar_permisos_rol == 't') $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="editar" value="editar" checked>Editar</li>';
	                                else $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="editar" value="editar">Editar</li>';
	                                if($resultSet[$jindex]->borrar_permisos_rol == 't') $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="borrar" value="borrar" checked>Borrar</li>';
	                                else $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="borrar" value="borrar">Borrar</li>';}
	                                else
	                                {
	                                    $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="ver" value="ver">Ver</li>';
	                                    $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="guardar" value="guardar">Guardar</li>';
	                                    $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="editar" value="editar">Editar</li>';
	                                    $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$indm.''.$ind.'" name="borrar" value="borrar">Borrar</li>';
	                                }
                                   
	                                 $html.='</ul>';
	                                 $html.='</li>';
	                                 ++$ind;
	                             }
	                         }
	                         $html.='</ul>';
	                         $indm++;
	                     }
	                     
	                         $html.='</ul>';
	                     }
	                     else
	                     {
	                         $html.='<ul id="PermisosList">';
	                         $indm=1;
	                         foreach ($resultMod as $rm)
	                         {
	                         $html.='<li><input type="checkbox" onclick= "RevisaModulos(&quot;'.$rm->nombre_modulos.'&quot;)" class="sup" name="modulo" value="'.$rm->nombre_modulos.'">'.$rm->nombre_modulos.'<span class="caret"></span>';
	                         $html.='<ul class ="nested active">';
	                         $ind=1;
	                         foreach ($resultSetV as $res)
	                         {
	                             if($res->id_modulos == $rm->id_modulos)
	                             {
	                                 
	                                 $html.='<li><input type="checkbox" onclick="RevisaControladores(&quot;'.$resultCtr[$i]->nombre_controladores.'&quot;)" class ="cont'.$rm->id_modulos.''.$ind.'" name="controlador" value="'.$resultCtr[$i]->nombre_controladores.'">'.$resultCtr[$i]->nombre_controladores.'<span class="caret"></span>';
	                                 $html.='<ul class ="nested">';
	                                 $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$rm->id_modulos.''.$ind.'" name="ver" value="ver">Ver</li>';
	                                 $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$rm->id_modulos.''.$ind.'" name="guardar" value="guardar">Guardar</li>';
	                                 $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$rm->id_modulos.''.$ind.'" name="editar" value="editar">Editar</li>';
	                                 $html.='<li><input type="checkbox" onclick="RevisaCheck()" class="permck'.$rm->id_modulos.''.$ind.'" name="borrar" value="borrar">Borrar</li>';
	                                 $html.='</ul>';
	                                 $html.='</li>';
	                                 ++$ind;
	                             }
	                         }
	                         $html.='</ul>';
	                         $indm++;
	                     }
	                         $html.='</ul>';
	                     }
	                 }
	                 
	                 echo $html;
	                 
	                 
	                 
	                 
	                 
	                 
	             }
	             else
	             {
	                 $this->view_Administracion("Error",array(
	                     "resultado"=>"No tiene Permisos de Acceso a Permisos Rol"
	                     
	                 ));
	                 
	                 
	             }
	             
	         }
	         else 
	         {
	             $html='';
	             echo $html;
	         }
	     }
	    else{
	        
	        $this->redirect("Usuarios","sesion_caducada");
	        
	    }
	    
	}
	
	
	public function InsertaPermisosRoles(){

		session_start();
		
		$resultado = null;
		$permisos_rol=new PermisosRolesModel();
	
		
		$nombre_controladores = "PermisosRoles";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosEditar("   nombre_controladores = '$nombre_controladores' AND id_rol = '$id_rol' " );
		
		if (!empty($resultPer))
		{
		
		
		//_nombre_categorias character varying, _path_categorias character varying
		if (isset ($_POST["nombre_permisos_rol"]) && isset ($_POST["id_controladores"]) && isset ($_POST["id_rol"])  )
			
		{
			$_nombre_permisos_rol = $_POST["nombre_permisos_rol"];
			$_id_controladores = $_POST["id_controladores"];
			$_ver_permisos_rol = $_POST["ver_permisos_rol"];
			
			$_guardar_permisos_rol = $_POST["guardar_permisos_rol"];
			
			$_editar_permisos_rol = $_POST["editar_permisos_rol"];
			$_borrar_permisos_rol = $_POST["borrar_permisos_rol"];
			$_id_rol = $_POST["id_rol"];
			$_id_permisos_rol = $_POST["id_permisos_rol"];
			 
			
			if($_id_permisos_rol > 0){
				
				$columnas = " nombre_permisos_rol = '$_nombre_permisos_rol',
							  id_controladores ='$_id_controladores',	
							  ver_permisos_rol = '$_ver_permisos_rol',
                              guardar_permisos_rol = '$_guardar_permisos_rol',
							  editar_permisos_rol = '$_editar_permisos_rol',
							  borrar_permisos_rol = '$_borrar_permisos_rol',
							  id_rol = '$_id_rol'";
				$tabla = "permisos_rol";
				$where = "id_permisos_rol = '$_id_permisos_rol'";
				$resultado=$permisos_rol->UpdateBy($columnas, $tabla, $where);
				
			}else{
			
			$funcion = "ins_permisos_rol";
				$parametros = " '$_nombre_permisos_rol' ,'$_id_controladores' , '$_id_rol' , '$_ver_permisos_rol', '$_guardar_permisos_rol', '$_editar_permisos_rol', '$_borrar_permisos_rol'";
				$permisos_rol->setFuncion($funcion);
				$permisos_rol->setParametros($parametros);
				$resultado=$permisos_rol->Insert();
			}				
	
		}
		
		$this->redirect("PermisosRoles", "index");
		}
		else
		{
		    $this->view_Administracion("Error",array(
					"resultado"=>"No tiene Permisos Para Crear Permisos Roles"
		
			));
		
		
		}
		
		
		
	}
	
	public function borrarId()
	{
		$permisos_rol = new PermisosRolesModel();

		session_start();
		
		$nombre_controladores = "PermisosRoles";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $permisos_rol->getPermisosBorrar("   nombre_controladores = '$nombre_controladores' AND id_rol = '$id_rol' " );
		
		if (!empty($resultPer))
		{
			if(isset($_GET["id_permisos_rol"]))
			{
				$id_permisos_rol=(int)$_GET["id_permisos_rol"];
		
				$permisos_rol=new PermisosRolesModel();
				
				$permisos_rol->deleteBy(" id_permisos_rol",$id_permisos_rol);
			}
			
			$this->redirect("PermisosRoles", "index");
			
		}
		else
		{
		    $this->view_Administracion("Error",array(
					"resultado"=>"No tiene Permisos de Borrar Permisos Roles"
		
			));
		
		
		}
		
	}
	
	public function devuelveAcciones()
	{
		$resultAcc = array();
	
		if(isset($_POST["id_controladores"]))
		{
	
			$id_controladores=(int)$_POST["id_controladores"];
	
			$acciones=new AccionesModel();
	
			$resultAcc = $acciones->getBy(" id_controladores = '$id_controladores'  ");
	
	
		}
	
		echo json_encode($resultAcc);
	
	}
	
	
	public function devuelveSubByAcciones()
	{
		$resultAcc = array();
	
		if(isset($_POST["id_acciones"]))
		{
	
			$id_acciones=(int)$_POST["id_acciones"];
	
			$acciones=new AccionesModel();
	
			$resultAcc = $acciones->getBy(" id_acciones = '$id_acciones'  ");
	
	
		}
	
		echo json_encode($resultAcc);
	
	}
	
	
	
	
	
	
	public function devuelveAllAcciones()
	{
		$resultAcc = array();
	
		$acciones=new AccionesModel();
	
		$resultAcc = $acciones->getAll(" id_controladores, nombre_acciones");
	
		echo json_encode($resultAcc);
	
	}
	

	
	
	public function Reporte(){
	
		//Creamos el objeto usuario
		$subcategorias=new SubCategoriasModel();
		//Conseguimos todos los usuarios
	
	
		$columnas = " subcategorias.id_subcategorias, categorias.nombre_categorias, subcategorias.nombre_subcategorias, subcategorias.path_subcategorias";
		$tablas   = "public.subcategorias, public.categorias";
		$where    = "subcategorias.id_categorias = categorias.id_categorias";
		$id       = "categorias.nombre_categorias,subcategorias.nombre_subcategorias";
		
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario']) )
		{
			$resultRep = $subcategorias->getCondicionesPDF($columnas, $tablas, $where, $id);
			
			$this->report("SubCategorias",array(	"resultRep"=>$resultRep));
	
		}
			
	
	}
	

	
 public function ActualizarPermisos()
 {
     
     session_start();
     if(isset($_POST['condiciones_permisos']))
     {
         $arreglo = $_POST['condiciones_permisos'];
         echo $arreglo[0][2][0];
     }
     
     /*$resultado = null;
     $permisos_rol=new PermisosRolesModel();
     $_modulo=$_POST["modulo"];
     die ($_modulo);
     
     
     $nombre_controladores = "PermisosRoles";
     $id_rol= $_SESSION['id_rol'];
     $resultPer = $permisos_rol->getPermisosEditar("nombre_controladores = '$nombre_controladores' AND id_rol = '$id_rol' " );
     
     if (!empty($resultPer))
     {
         
         
         //_nombre_categorias character varying, _path_categorias character varying
         if (isset ($_POST["id_rol"]))
         {
             
             $_id_rol = $_POST["id_rol"];
             $_id_controladores = $_POST["id_controladores"];
           
                 $funcion = "ins_permisos_rol";
                 $parametros = " '$_nombre_permisos_rol' ,'$_id_controladores' , '$_id_rol' , '$_ver_permisos_rol', '$_guardar_permisos_rol', '$_editar_permisos_rol', '$_borrar_permisos_rol'";
                 $permisos_rol->setFuncion($funcion);
                 $permisos_rol->setParametros($parametros);
                 $resultado=$permisos_rol->Insert();
            
             
         }
         
         $this->redirect("PermisosRoles", "index");
     }
     else
     {
         $this->view_Administracion("Error",array(
             "resultado"=>"No tiene Permisos Para Crear Permisos Roles"
             
         ));
         
         
     }*/
     
     
     
     
     
     
     
     
 }
	
	
	
}
?>