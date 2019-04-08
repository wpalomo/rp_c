<?php

include dirname(__FILE__).'\..\..\view\mpdf\mpdf.php';
 
//echo getcwd().''; //para ver ubicacion de directorio

$template = file_get_contents('view/reportes/template/ActivosFijos.html');

$footer = file_get_contents('view/reportes/template/pieficha.html');


if(!empty($datos_empresa)){
    
    foreach ($datos_empresa as $clave=>$valor) {
        $template = str_replace('{'.$clave.'}', $valor, $template);
    }
}

if(isset($datosActivo)){
    
    foreach ($datosActivo as $clave=>$valor) {
        $template = str_replace('{'.$clave.'}', $valor, $template);
    }
}


$anio = date('Y');

$template = str_replace('{APERIODO}', $anio, $template);


//echo $template; die();

ob_end_clean();
//creacion del pdf
//$mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);
$mpdf=new mPDF();
$mpdf->SetDisplayMode('fullpage');
$mpdf->allow_charset_conversion = true;
$mpdf->charset_in = 'UTF-8';
$mpdf->setAutoTopMargin = 'stretch';
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->SetHTMLFooter($footer);
$mpdf->WriteHTML($template);
$mpdf->debug = true;
$mpdf->Output();
/*$content = $mpdf->Output('', 'S'); // Saving pdf to attach to email
$content = chunk_split(base64_encode($content));
$content = 'data:application/pdf;base64,'.$content;
print_r($content);*/
exit();
?>


