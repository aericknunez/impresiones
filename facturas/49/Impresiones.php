 <?php  
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

// Al MArket

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





public function Factura($data){


  $txt1   = "15"; 
  $txt2   = "5";
  $txt3   = "0";
  $txt4   = "0";
  $n1   = "16";
  $n2   = "60";
  $n3   = "30";
  $n4   = "0";
  
  
  $col1 = 38;
  $col2 = 98;
  $col3 = 370;
  $col4 = 550;
  $col5 = 500;
  // $print
  $print = "FACTURA";
  
  $handle = printer_open($print);
  printer_set_option($handle, PRINTER_MODE, "RAW");
  
  printer_start_doc($handle, "Mi Documento");
  printer_start_page($handle);
  
  
  $font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
  printer_select_font($handle, $font);
  
  
  
  $oi=80;
  //// comienza la factura
  
  
  
  $oi=$oi+$n1+$n1;
  printer_draw_text($handle, $data["nombre"], 95, $oi+$n1);
  printer_draw_text($handle, date("d") . " " . Fechas::MesEscrito(date("m")) ."  " . date("Y"), 400, $oi);
  
  $oi=$oi+$n1;
  printer_draw_text($handle, $data["direccion"], 110, $oi+$n1);
  
  printer_draw_text($handle, $data["documento"], 110, $oi+$n1+$n1);
  
  
  $oi=180; // salto de linea
  
  
      foreach ($data["productos"] as $producto) {
   
  
            $oi=$oi+$n1;
            printer_draw_text($handle, $producto["cant"], $col1, $oi);
            printer_draw_text($handle, $producto["producto"], $col2, $oi);
            printer_draw_text($handle, $producto["pv"], $col3, $oi);
            printer_draw_text($handle, $producto["total"], $col4, $oi);
  
      } 
  
  
  
  
  
  /// salto de linea
  $oi=455;
  
  // valores en letras
  printer_draw_text($handle, Dinero::DineroEscrito($data["total"]), $col2-10, $oi);
  // echo wordwrap($cadena, 15, "<br>" ,FALSE);
  
  // volores numericos
  printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
  
  
  $oi=$oi+$n1+$n1;
  printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
  
  
  $oi=$oi+$n1+32;
  printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
  
  
  printer_delete_font($font);
  
  printer_end_page($handle);
  printer_end_doc($handle);
  printer_close($handle);
  
  
  }   /// termina FACTURA
  
  
  
  
  
   public function CreditoFiscal($data){
  
      $txt1   = "15"; 
      $txt2   = "5";
      $txt3   = "0";
      $txt4   = "0";
      $n1   = "16";
      $n2   = "60";
      $n3   = "30";
      $n4   = "0";
      
      
      $col1 = 38;
      $col2 = 89;
      $col3 = 400;
      $col4 = 550;
      $col5 = 500;
      // $print
      $print = "FACTURA";
  
  $handle = printer_open($print);
  printer_set_option($handle, PRINTER_MODE, "RAW");
  
  printer_start_doc($handle, "Mi Documento");
  printer_start_page($handle);
  
  
  $font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
  printer_select_font($handle, $font);
  
  
  
  $oi=88;
  //// comienza la factura
  
  
  
  $oi=$oi+$n1;
  printer_draw_text($handle, date("d") . " " . Fechas::MesEscrito(date("m")) ."" . date("Y"), 450, $oi);
  

  $oi=$oi+$n1;
  printer_draw_text($handle, $data["cliente"], 100, $oi);

  $oi=$oi+$n1;
  printer_draw_text($handle, $data["direccion"], 100, $oi);


  $oi=$oi+$n1;
  printer_draw_text($handle, $data["municipio"], 130, $oi);
  printer_draw_text($handle, $data["registro"], 480, $oi);



  $oi=$oi+$n1;
  printer_draw_text($handle, $data["departamento"], 130, $oi);
  printer_draw_text($handle, $data["documento"], 465, $oi);

  $oi=$oi+$n1;
  printer_draw_text($handle, $data["giro"], 450, $oi);

  
  $oi=$oi+$n1;
  printer_draw_text($handle, "CONTADO", 500, $oi);
  
  
  
  $oi=228; // salto de linea
  
  
      foreach ($data["productos"] as $producto) {
   
  
        $oi=$oi+$n1;
        printer_draw_text($handle, $producto["cant"], $col1, $oi);
        printer_draw_text($handle, $producto["producto"], $col2, $oi);
        printer_draw_text($handle, Helpers::Format4D(Helpers::STotal($producto["pv"], $data['config_imp'])), $col3, $oi);
        printer_draw_text($handle, $producto["stotal"], $col4, $oi);
  
      } 
  
  
  
  /// salto de linea
  $oi=437;
  
  // valores en letras
  printer_draw_text($handle, Dinero::DineroEscrito($data["total"]), $col2, $oi);
  // echo wordwrap($cadena, 15, "<br>" ,FALSE);
  
  
  // volores numericos
  // printer_draw_text($handle, Helpers::Format($totalx), $col4, $oi);
  printer_draw_text($handle, Helpers::Format($data["stotal"]), $col4, $oi);
  
  
  
  
  $oi=$oi+$n1;
  // printer_draw_text($handle, Helpers::Format($impx), $col4, $oi);
  printer_draw_text($handle, Helpers::Format(Helpers::Impuesto(Helpers::STotal($data["total"], $data['config_imp']), $data['config_imp'])), $col4, $oi);
  
  
  $oi=$oi+$n1;
  printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
  
  
  $oi=$oi+$n1+$n1+$n1+10;
  printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
  
  
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