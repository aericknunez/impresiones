<?php //Ejemplo aprenderaprogramar.com, archivo escribir.php
header('Access-Control-Allow-Origin: *');
include_once 'common/Dinero.php';
include_once 'common/Fechas.php';
include_once 'common/Helpers.php';


// $file = fopen("archivo.txt", "w");

// // fwrite($file, "Esto es una nueva linea de texto" . PHP_EOL);

// // fwrite($file, "Otra más" . PHP_EOL);

// fwrite($file, json_encode($_POST));

// fclose($file);



// echo json_encode($_POST);
// 


if($_POST["identidad"] == 24){
require_once ('ticket/autoload.php'); 
include_once 'facturas/'.$_POST["identidad"].'/Impresiones.php';
	$fac = new Impresiones();

if($_POST["tipoticket"] == 2){
	$fac->Factura($_POST); //2
}

if($_POST["tipoticket"] == 3){
	$fac->CreditoFiscal($_POST); //3
}


}










?>