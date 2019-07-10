<?php
class BuscarParticipesController extends ControladorBase{
    public function index(){
        session_start();
        $estado = new EstadoModel();
        $id_rol = $_SESSION['id_rol'];
        
        $this->view_Credito("BuscarParticipes",array(
            "result" => ""
        ));
    }
    
    public function BuscarParticipe()
    {
        session_start();
        $cedula=$_POST['cedula'];
        $html="";
        $participes= new ParticipesModel();
        $icon="";
        $respuesta= array();
        
        $columnas="core_estado_participes.nombre_estado_participes, core_participes.nombre_participes,
                    core_participes.apellido_participes, core_participes.ocupacion_participes,
                    core_participes.cedula_participes, core_entidad_patronal.nombre_entidad_patronal,
                    core_participes.telefono_participes, core_participes.direccion_participes,
                    core_estado_civil_participes.nombre_estado_civil_participes, core_genero_participes.nombre_genero_participes,
                    core_participes.id_participes";
        $tablas="public.core_participes INNER JOIN public.core_estado_participes
                    ON core_participes.id_estado_participes = core_estado_participes.id_estado_participes
                    INNER JOIN core_entidad_patronal
                    ON core_participes.id_entidad_patronal = core_entidad_patronal.id_entidad_patronal
                    INNER JOIN core_estado_civil_participes
                    ON core_participes.id_estado_civil_participes=core_estado_civil_participes.id_estado_civil_participes
                    INNER JOIN core_genero_participes
                    ON core_genero_participes.id_genero_participes = core_participes.id_genero_participes";
    
        $where="core_participes.cedula_participes='".$cedula."'";
        
        $id="core_participes.id_participes";
        
        $resultSet=$participes->getCondiciones($columnas, $tablas, $where, $id);
        
        if(!(empty($resultSet)))
        {if($resultSet[0]->nombre_genero_participes == "HOMBRE") $icon='<i class="fa fa-male fa-3x" style="float: left;"></i>';
        else $icon='<i class="fa fa-female fa-3x" style="float: left;"></i>';
        
        $html.='
        <div class="box box-widget widget-user-2">
        <div class="widget-user-header bg-olive">'
            .$icon.
            '<h3 class="widget-user-username">'.$resultSet[0]->nombre_participes.' '.$resultSet[0]->apellido_participes.'</h3>
         <h5 class="widget-user-desc">Estado: '.$resultSet[0]->nombre_estado_participes.'</h5>
        <h5 class="widget-user-desc">CI: '.$resultSet[0]->cedula_participes.'</h5>
        </div>
        <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
        <table align="right" class="tablesorter table table-striped table-bordered dt-responsive nowrap dataTables-example">
        <tr>
        <th>Cargo:</th>
        <td>'.$resultSet[0]->ocupacion_participes.'</td>
        <th>Entidad Patronal:</th>
        <td>'.$resultSet[0]->nombre_entidad_patronal.'</td>
        </tr>
        <tr>
        <th>Teléfono:</th>
        <td>'.$resultSet[0]->telefono_participes.'</td>
        <th>Estado Civil:</th>
        <td>'.$resultSet[0]->nombre_estado_civil_participes.'</td>
        </tr>
        <tr >
        <th>Dirección:</th>
        <td colspan="3">'.$resultSet[0]->direccion_participes.'</td>
        </tr>
        </table>
        </ul>
        </div>
        </div>';
        
            array_push($respuesta, $html);
            array_push($respuesta, $resultSet[0]->id_participes);
        }
        else
        {
            $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
            $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $html.='<h4>Aviso!!!</h4> <b>No se ha encontrado participes con número de cédula '.$cedula.'</b>';
            $html.='</div>';
            
            array_push($respuesta, $html);
            array_push($respuesta, 0);
        }
        
        
        
        echo json_encode($respuesta);
    }
    
    public function dateDifference($date_1 , $date_2 , $differenceFormat = '%y Años, %m Meses' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        
        $interval = date_diff($datetime1, $datetime2);
        
        return $interval->format($differenceFormat);
        
    }
    
    
    
    public function AportesParticipe()
    {
        session_start();
        $id_participe=$_POST['id_participe'];
        $html="";
        $participes= new ParticipesModel();
        $total=0;
        
        $columnas="fecha_registro_contribucion, nombre_contribucion_tipo, valor_personal_contribucion";
        $tablas="core_contribucion INNER JOIN core_contribucion_tipo
                ON core_contribucion.id_contribucion_tipo = core_contribucion_tipo.id_contribucion_tipo";
        $where="core_contribucion.id_participes=".$id_participe." AND core_contribucion.id_contribucion_tipo=1 
                AND core_contribucion.id_estatus=1";
        $id="fecha_registro_contribucion";
        
        $resultAportesPersonales=$participes->getCondiciones($columnas, $tablas, $where, $id);
        
        $columnas="fecha_registro_contribucion, nombre_contribucion_tipo, valor_personal_contribucion, valor_patronal_contribucion";
        $tablas="core_contribucion INNER JOIN core_contribucion_tipo
                ON core_contribucion.id_contribucion_tipo = core_contribucion_tipo.id_contribucion_tipo";
        $where="core_contribucion.id_participes=".$id_participe." AND core_contribucion.id_estatus=1";
        $id="fecha_registro_contribucion";
        
        $resultAportes=$participes->getCondiciones($columnas, $tablas, $where, $id);
        if(!(empty($resultAportes)))
        {
            foreach($resultAportes as $res)
            {
                if($res->valor_personal_contribucion!=0)
                {
                    $total+=$res->valor_personal_contribucion;
                    
                }
                else
                {
                    $total+=$res->valor_patronal_contribucion;
                }
            }
            
            $personales=sizeof($resultAportesPersonales);
            $last=sizeof($resultAportes);
            $fecha_primer=$resultAportes[0]->fecha_registro_contribucion;
            $fecha_ultimo=$resultAportes[$last-1]->fecha_registro_contribucion;
            $fecha_primer=substr($fecha_primer,0,10);
            $fecha_ultimo=substr($fecha_ultimo,0,10);
            $tiempo=$this->dateDifference($fecha_primer, $fecha_ultimo);
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
            $resultSet=$participes->getCantidad("*", $tablas, $where);
            $cantidadResult=(int)$resultSet[0]->total;
            $per_page = 20; //la cantidad de registros que desea mostrar
            $adjacents  = 9; //brecha entre páginas después de varios adyacentes
            $offset = ($page - 1) * $per_page;
            $limit = " LIMIT   '$per_page' OFFSET '$offset'";
            $resultAportes=$participes->getCondicionesPag($columnas, $tablas, $where, $id, $limit);
            $last=sizeof($resultAportes);
            
            $total_pages = ceil($cantidadResult/$per_page);
                        
            $html='<div class="box box-solid bg-olive">
            <div class="box-header with-border">
            <h3 class="box-title">Aportaciones</h3>
            <h4 class="widget-user-desc"><b>Tiempo de Aportes:</b> '.$tiempo.'</h4>
            <h4 class="widget-user-desc"><b>Número de Aportaciones Personales mensuales:</b> '.$personales.'</h4>
            </div>
             <table border="1" width="100%">
                     <tr style="color:white;" class="bg-olive">
                        <th width="10%">№</th>
                        <th width="29%">FECHA DE APORTACION</th>
                        <th width="28%">TIPO DE APORTE</th>
                        <th width="29%">TOTAL</th>
                        <th width="1.5%"></th>
                     </tr>
                   </table>
                   <div style="overflow-y: scroll; overflow-x: hidden; height:200px; width:100%;">
                     <table border="1" width="100%">';
                       for($i=$last-1; $i>0; $i--)
                       {    
                           $index=$i+($last-1)*($page-1);
                           if($resultAportes[$i]->valor_personal_contribucion!=0)
                           {
                               $fecha=substr($resultAportes[$i]->fecha_registro_contribucion,0,10);
                               $monto=number_format((float)$resultAportes[$i]->valor_personal_contribucion, 2, ',', '.');
                               $html.='<tr>
                                 <td bgcolor="white" width="10%"><font color="black">'.$index.'</font></td>
                                 <td bgcolor="white" width="30%"><font color="black">'.$fecha.'</font></td>
                                 <td bgcolor="white" width="30%"><font color="black">'.$resultAportes[$i]->nombre_contribucion_tipo.'</font></td>
                                 <td bgcolor="white" align="right" width="30%"><font color="black">'.$monto.'</font></td>
                                </tr>';
                           }
                           else
                           {
                               $fecha=substr($resultAportes[$i]->fecha_registro_contribucion,0,10);
                               $monto=number_format((float)$resultAportes[$i]->valor_patronal_contribucion, 2, ',', '.');
                               $html.='<tr>
                                 <td bgcolor="white"  width="10%"><font color="black">'.$index.'</font></td>
                                 <td bgcolor="white"  width="30%"><font color="black">'.$fecha.'</font></td>
                                 <td bgcolor="white" width="30%"><font color="black">'.$resultAportes[$i]->nombre_contribucion_tipo.'</font></td>
                                 <td bgcolor="white" align="right" width="30%"><font color="black">'.$monto.'</font></td>
                                </tr>';
                           }
                           
                          
                       }
                       $total=number_format((float)$total, 2, ',', '.');
                     $html.='</table>  
                   </div>
                    <table border="1" width="100%">
                     <tr style="color:white;" class="bg-olive">
                        <th class="text-right">Acumulado Total de Aportes: '.$total.'</th>
                        <th width="1.5%"></th>
                     </tr>
                   </table>';
                     $html.='<div class="table-pagination pull-right">';
                     $html.=''. $this->paginate_aportes("index.php", $page, $total_pages, $adjacents,$id_participe,"AportesParticipe").'';
                     $html.='</div>
                    </div>';
            
            
            echo $html;
            
        }
        else
        {
            $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
            $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $html.='<h4>Aviso!!!</h4> <b>El participe no tiene aportaciones</b>';
            $html.='</div>';
            echo $html;
        }
         
        
    }
    
    public function paginate_aportes($reload, $page, $tpages, $adjacents,$id_participe,$funcion='') {
        
        $prevlabel = "&lsaquo; Prev";
        $nextlabel = "Next &rsaquo;";
        $out = '<ul class="pagination pagination-large">';
        
        // previous label
        
        if($page==1) {
            $out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
        } else if($page==2) {
            $out.= "<li><span><a href='javascript:void(0);' onclick='$funcion($id_participe,1)'>$prevlabel</a></span></li>";
        }else {
            $out.= "<li><span><a href='javascript:void(0);' onclick='$funcion(".$id_participe.",".($page-1).")'>$prevlabel</a></span></li>";
            
        }
        
        // first label
        if($page>($adjacents+1)) {
            $out.= "<li><a href='javascript:void(0);' onclick='$funcion($id_participe,1)'>1</a></li>";
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
                $out.= "<li><a href='javascript:void(0);' onclick='$funcion($id_participe,1)'>$i</a></li>";
            }else {
                $out.= "<li><a href='javascript:void(0);' onclick='$funcion(".$id_participe.",".$i.")'>$i</a></li>";
            }
        }
        
        // interval
        
        if($page<($tpages-$adjacents-1)) {
            $out.= "<li><a>...</a></li>";
        }
        
        // last
        
        if($page<($tpages-$adjacents)) {
            $out.= "<li><a href='javascript:void(0);' onclick='$funcion($id_participe,$tpages)'>$tpages</a></li>";
        }
        
        // next
        
        if($page<$tpages) {
            $out.= "<li><span><a href='javascript:void(0);' onclick='$funcion(".$id_participe.",".($page+1).")'>$nextlabel</a></span></li>";
        }else {
            $out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
        }
        
        $out.= "</ul>";
        return $out;
    }
    
    
    
    
}


?>