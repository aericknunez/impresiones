 <?php  
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

// Toque Diamante Eventos

class Impresiones{
    public function __construct() { 
     } 



 public function Ticket($data){

  $nombre_impresora = "TICKET";
  // $img  = "C:/AppServ/www/pizto//img/sotano.jpg";


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
$printer -> initialize();

$printer -> setFont(Printer::FONT_B);
// $printer -> selectPrintMode(Printer::MODE_DOUBLE_HEIGHT);
// $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);

$printer -> setTextSize(1, 2);
$printer -> setLineSpacing(80);


// $printer -> setJustification(Printer::JUSTIFY_CENTER);
// $logo = EscposImage::load($img, false);
// $printer->bitImage($logo);
$printer -> setJustification(Printer::JUSTIFY_LEFT);

$printer->text($data["c_cliente"]);

$printer->feed();
$printer->text($data["c_giro"]);

$printer->feed();
$printer->text($data["c_nombre"]);

$printer->feed();
$printer->text($data["c_direccion"]);

$printer->feed();
$printer->text("Tel: " . $data["c_telefono"]);

$printer->feed();
$printer->text("FACTURA NUMERO: " . $data["num_fac"]);


/* Stuff around with left margin */
$printer->feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("____________________________________________________________");
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer->feed();
/* Items */

$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> setEmphasis(true);
$printer -> text($this->Item("Cant", 'Producto', 'Precio', 'Total'));
$printer -> setEmphasis(false);



    foreach ($data["productos"] as $producto) {

      $printer -> text($this->Item($producto["cant"], $producto["producto"], $producto["pv"], $producto["total"]));
    } 



$printer -> text("____________________________________________________________");
$printer->feed();


$printer -> text($this->DosCol("Sub Total $:", 40, Helpers::Format($data["total"]), 20));


$printer -> text($this->DosCol("IVA $:", 40, Helpers::Format(Helpers::Impuesto(Helpers::STotal($data["total"], $data['config_imp']), $data['config_imp'])), 20));


$printer -> text($this->DosCol("TOTAL $:", 40, Helpers::Format($data["total"]), 20));



$printer -> text("____________________________________________________________");
$printer->feed();

if($data["efectivo"] != 0){
  $cambio = $data["efectivo"] - $data["total"];
  $efectivo = $data["efectivo"];
} else {
  $cambio = "0.00";
  $efectivo = $data["total"];
}

$printer -> text($this->DosCol("Efectivo $:", 40, Helpers::Format($efectivo), 20));

//cambio
$printer -> text($this->DosCol("Cambio $:", 40, Helpers::Format($cambio), 20));


$printer -> text("____________________________________________________________");
$printer->feed();


$printer -> text($this->DosCol(date("d-m-Y"), 30, date("H:i:s"), 30));

$printer -> text("Cajero: " . $data["cajero"]);

$printer->feed();
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("GRACIAS POR SU PREFERENCIA...");
$printer -> setJustification();

$printer->feed();
$printer->cut();
$printer->pulse();
$printer->close();



}








public function Factura($efectivo, $numero){
  $db = new dbConn();

$txt1   = "15"; 
$txt2   = "5";
$txt3   = "0";
$txt4   = "0";
$n1   = "15";
$n2   = "60";
$n3   = "30";
$n4   = "0";


$col1 = 25;
$col2 = 70;
$col3 = 370; //400
$col4 = 550; //565
$col5 = 500;
// $print
$print = "FACTURA";

$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);



$oi=58;
//// comienza la factura

$oi=$oi+$n1;
printer_draw_text($handle, date("d") . " - " . Fechas::MesEscrito(date("m")) ." - " . date("Y"), 460, $oi);


$oi=98;


if ($r = $db->select("orden", "ticket_num", "WHERE num_fac = '$numero' and tx = " . $_SESSION["tx"] . " and tipo = ".$_SESSION["tipoticket"]." and td = " .  $_SESSION["td"])) { 
    $orden = $r["orden"];
} unset($r);

    if ($r = $db->select("cliente", "ticket_cliente", "WHERE orden = '$orden' and factura = '$numero' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"])) { 
        $hashcliente = $r["cliente"];
    } unset($r);  


    if ($r = $db->select("nombre, documento, direccion", "clientes", "WHERE hash = '$hashcliente' and td = " .  $_SESSION["td"])) { 
        $nombre = $r["nombre"];
        $documento = $r["documento"];
        $direccion = $r["direccion"];
    } unset($r);  


$oi=$oi+$n1;
printer_draw_text($handle, $nombre, 85, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, $direccion, 100, $oi);

$oi=$oi+$n1+2;
printer_draw_text($handle, $documento, 105, $oi);


$oi=180; // salto de linea

$a = $db->query("select cod, cant, producto, pv, total, fecha, hora, num_fac from ticket where num_fac = '".$numero."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and tipo = ".$_SESSION["tipoticket"]." group by cod");
  
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];
 $num_fac=$b["num_fac"];

          $oi=$oi+$n1;
          printer_draw_text($handle, $b["cant"], $col1, $oi);
          printer_draw_text($handle, $b["producto"], $col2, $oi);
          printer_draw_text($handle, $b["pv"], $col3, $oi);
          printer_draw_text($handle, $b["total"], $col4, $oi);



    }    $a->close();


if ($sx = $db->select("sum(stotal), sum(imp), sum(total)", "ticket", "WHERE num_fac = '".$numero."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and tipo = ".$_SESSION["tipoticket"]."")) { 
       $stotalx=$sx["sum(stotal)"];
       $impx=$sx["sum(imp)"];
       $totalx=$sx["sum(total)"];
    } unset($sx); 
 
/// salto de linea
$oi=440;


// valores en letras
printer_draw_text($handle, Dinero::DineroEscrito($totalx), $col2, $oi);
// echo wordwrap($cadena, 15, "<br>" ,FALSE);


// volores numericos
printer_draw_text($handle, Helpers::Format($totalx), $col4, $oi);



$oi=$oi+$n1;
// printer_draw_text($handle, Helpers::Format($impx), $col4, $oi);
// printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($totalx, $_SESSION['config_imp']), $_SESSION['config_imp'])), $col4, $oi);


$oi=$oi+$n1+$n1;
printer_draw_text($handle, Helpers::Format($totalx), $col4, $oi);


$oi=$oi+$n1+$n1;
printer_draw_text($handle, Helpers::Format($totalx), $col4, $oi);


// $oi=$oi+$n3+$n1;
// printer_draw_text($handle, "Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 185, $oi);
// printer_draw_text($handle, Helpers::Format(Helpers::STotal($subtotalf, $_SESSION['config_imp'])), 320, $oi);


// $oi=$oi+$n1;
// printer_draw_text($handle, "15% Impu. " . $_SESSION['config_moneda_simbolo'] . ":", 175, $oi);
// printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($subtotalf, $_SESSION['config_imp']), $_SESSION['config_imp'])), 320, $oi);




// $oi=$oi+$n1;
// printer_draw_text($handle, "Total " . $_SESSION['config_moneda_simbolo'] . ":", 232, $oi);
// printer_draw_text($handle, Helpers::Format($subtotalf), 320, $oi);





printer_delete_font($font);
///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);




}   /// termina FACTURA





 public function CreditoFiscal($efectivo, $numero){
  $db = new dbConn();

$txt1   = "15"; 
$txt2   = "5";
$txt3   = "0";
$txt4   = "0";
$n1   = "15";
$n2   = "15";
$n3   = "30";
$n4   = "0";


$col1 = 30;
$col2 = 70;
$col3 = 370; //400
$col4 = 550; //565
$col5 = 500;
// $print
$print = "FACTURA";

$handle = printer_open($print);
printer_set_option($handle, PRINTER_MODE, "RAW");

printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);


$font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
printer_select_font($handle, $font);



$oi=47;
//// comienza la factura

$oi=$oi+$n1;
printer_draw_text($handle, date("d-m-Y"), 450, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, "CONTADO", 528, $oi);
// printer_draw_text($handle, date("m"), 490, $oi);
// printer_draw_text($handle, substr(date("Y"), -1), 590, $oi);

$oi=96;

  if ($r = $db->select("documento", "facturar_documento_factura", "WHERE factura = '$numero' and tx = " . $_SESSION["tx"] . " and td = " .  $_SESSION["td"] . " order by time desc limit 1" )) { 
      $documento = $r["documento"];
  } unset($r);  



    if ($r = $db->select("cliente, giro, registro, direccion, departamento", "facturar_documento", "WHERE documento = '$documento' and td = " .  $_SESSION["td"])) { 
        $cliente = $r["cliente"];
        $giro = $r["giro"];
        $registro = $r["registro"];
        $direccion = $r["direccion"];
        $departamento = $r["departamento"];
    } unset($r);  



$oi=$oi+$n1;
printer_draw_text($handle, $cliente, 85, $oi);
printer_draw_text($handle, $registro, 450, $oi);
$oi=$oi+$n1;
printer_draw_text($handle, $direccion, 100, $oi);
printer_draw_text($handle, $departamento, 450, $oi);

$oi=$oi+$n1;
printer_draw_text($handle, $giro, 110, $oi);
printer_draw_text($handle, $documento, 450, $oi);


$oi=180; // salto de linea

$a = $db->query("select cod, cant, producto, pv, stotal, total, fecha, hora, num_fac from ticket where num_fac = '".$numero."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and tipo = ".$_SESSION["tipoticket"]." group by cod");
  
    foreach ($a as $b) {
 
 $fechaf=$b["fecha"];
 $horaf=$b["hora"];
 $num_fac=$b["num_fac"];

          $oi=$oi+$n2;
          printer_draw_text($handle, $b["cant"], $col1, $oi);
          printer_draw_text($handle, $b["producto"], $col2, $oi);
          printer_draw_text($handle, Helpers::Format4D(Helpers::STotal($b["pv"], $_SESSION['config_imp'])), $col3, $oi);

          // printer_draw_text($handle, $b["pv"], $col3, $oi);
          printer_draw_text($handle, $b["stotal"], $col4, $oi);



    }    $a->close();


if ($sx = $db->select("sum(stotal), sum(imp), sum(total)", "ticket", "WHERE num_fac = '".$numero."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and tipo = ".$_SESSION["tipoticket"]."")) { 
       $stotalx=$sx["sum(stotal)"];
       $impx=$sx["sum(imp)"];
       $totalx=$sx["sum(total)"];
    } unset($sx); 
 
/// salto de linea
$oi=435;

// valores en letras
printer_draw_text($handle, Dinero::DineroEscrito($totalx), $col2, $oi);
// echo wordwrap($cadena, 15, "<br>" ,FALSE);


// volores numericos
// printer_draw_text($handle, Helpers::Format($totalx), $col4, $oi);
printer_draw_text($handle, Helpers::Format($stotalx), $col4, $oi);




$oi=$oi+$n1;
// printer_draw_text($handle, Helpers::Format($impx), $col4, $oi);
printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($totalx, $_SESSION['config_imp']), $_SESSION['config_imp'])), $col4, $oi);


$oi=$oi+$n1;
printer_draw_text($handle, Helpers::Format($totalx), $col4, $oi);


$oi=$oi+$n1+$n1+$n1+$n1;
printer_draw_text($handle, Helpers::Format($totalx), $col4, $oi);


// $oi=$oi+$n3+$n1;
// printer_draw_text($handle, "Sub Total " . $_SESSION['config_moneda_simbolo'] . ":", 185, $oi);
// printer_draw_text($handle, Helpers::Format(Helpers::STotal($subtotalf, $_SESSION['config_imp'])), 320, $oi);


// $oi=$oi+$n1;
// printer_draw_text($handle, "15% Impu. " . $_SESSION['config_moneda_simbolo'] . ":", 175, $oi);
// printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($subtotalf, $_SESSION['config_imp']), $_SESSION['config_imp'])), 320, $oi);




// $oi=$oi+$n1;
// printer_draw_text($handle, "Total " . $_SESSION['config_moneda_simbolo'] . ":", 232, $oi);
// printer_draw_text($handle, Helpers::Format($subtotalf), 320, $oi);





printer_delete_font($font);
///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);


}

  
  







 public function Exportacion($data){


}   /// termina FACTURA







 public function Ninguno(){


}   /// termina /.;ninguno






 public function ImprimirAntes($efectivo, $numero, $cancelar){

} /// TERMINA IMPRIMIR ANTES







 public function Comanda(){


 }














 public function ReporteDiario($fecha){


}   // termina reporte diario








 public function AbrirCaja(){


}







 public function Barcode($numero){


}






















 public function Item($cant,  $name = '', $price = '', $total = '', $dollarSign = false)
    {
        $rightCols = 10;
        $leftCols = 42;
        if ($dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($cant . " " . $name, $leftCols) ;
        
        $sign = ($dollarSign ? '$ ' : '');

        $total = str_pad($sign . $total, $rightCols, ' ', STR_PAD_LEFT);
        $right = str_pad($sign . $price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right$total\n";
    }



 public function DosCol($izquierda = '', $iz, $derecha = '', $der)
    {
        $left = str_pad($izquierda, $iz, ' ', STR_PAD_LEFT) ;      
        $right = str_pad($derecha, $der, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }











}// class