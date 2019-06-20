<?php

include dirname(__FILE__).'\..\..\view\mpdf\mpdf.php';
 
//echo getcwd().''; //para ver ubicacion de directorio

$header = file_get_contents('view/reportes/template/CabeceraFinal.html');
$template = file_get_contents('view/reportes/template/CuentasPagar.html');

if(!empty($datos_empresa))
{
    
    foreach ($datos_empresa as $clave=>$valor) {        
        $header = str_replace('{'.$clave.'}', $valor, $header);
    }
}


$footer = file_get_contents('view/reportes/template/pieret.html');


if(!empty($datos_cabecera))
{
    
    foreach ($datos_cabecera as $clave=>$valor) {
        $template = str_replace('{'.$clave.'}', $valor, $template);
    }
}

if(!empty($datos_cuentas_pagar))
{
    
    foreach ($datos_cuentas_pagar as $clave=>$valor) {
        
        $template = str_replace('{'.$clave.'}', $valor, $template);
    }
}


ob_end_clean();
//creacion del pdf
//$mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);
$mpdf=new mPDF();
$mpdf->SetDisplayMode('fullpage');
$mpdf->allow_charset_conversion = true;
$mpdf->charset_in = 'UTF-8';
$mpdf->setAutoTopMargin = 'stretch';
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->SetHTMLHeader(utf8_encode($header));
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