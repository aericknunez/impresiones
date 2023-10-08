 <?php  
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

// MOVIL PLACE

class Impresiones{
    public function __construct() { 
     } 



 public function Ticket($data){

  $nombre_impresora = "TICKET";
  // $img  = "C:/AppServ/www/pizto//img/foto.jpg";


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

$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer->text("CHATO");


$printer->feed();
$printer->text("3ra Avenida Norte, Residencial Las vegas");
$printer->feed();
$printer->text("Metapán, Santa Ana");

$printer->feed();
$printer->text("Tel: 2467-9707 Cel: 7899-4580");


$printer->feed();
$printer->text("Giro: Reparación de motos");

$printer->feed();
$printer->text("CAJA: 1.  TICKET NUMERO: " . $data["num_fac"]);


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
  
  
  $col1 = 37;
  $col2 = 75;
  $col3 = 260;
  $col4 = 400;
  $col5 = 500;
  // $print
  $print = "FACTURA";
  
  $handle = printer_open($print);
  printer_set_option($handle, PRINTER_MODE, "RAW");
  
  printer_start_doc($handle, "Mi Documento");
  printer_start_page($handle);
  
  
  $font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
  printer_select_font($handle, $font);
  
  
  
  $oi=70;
  //// comienza la factura
  
  
  
  $oi=$oi+$n1+$n1;
  printer_draw_text($handle, $data["nombre"], 90, $oi);
  printer_draw_text($handle, date("d") . " " . Fechas::MesEscrito(date("m")) ."  " . date("Y"), 330, $oi-2);
  
  $oi=$oi+$n1;
  printer_draw_text($handle, $data["direccion"], 100, $oi+3);
  
  printer_draw_text($handle, $data["documento"], 350, $oi+$n1-20);
  
  
  $oi=142; // salto de linea
  
  
      foreach ($data["productos"] as $producto) {
   
  
            $oi=$oi+$n1;
            printer_draw_text($handle, $producto["cant"], $col1, $oi);
            printer_draw_text($handle, $producto["producto"], $col2, $oi);
            printer_draw_text($handle, $producto["pv"], $col3, $oi);
            printer_draw_text($handle, $producto["total"], $col4, $oi);
  
      } 
  
  
  
  
  
  /// salto de linea
  $oi=335;
  
  // valores en letras
  printer_draw_text($handle, Dinero::DineroEscrito($data["total"]), $col2-10, $oi);
  // echo wordwrap($cadena, 15, "<br>" ,FALSE);
  
  // volores numericos
  printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
  
  
  $oi=$oi+$n1+$n1;
  printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi-5);
  
  
  $oi=$oi+$n1+20;
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
      
      
      $col1 = 45;
      $col2 = 110;
      $col3 = 400;
      $col4 = 600;
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
  printer_draw_text($handle, date("d") . " " . Fechas::MesEscrito(date("m")) ."" . date("Y"), 500, $oi+3);
  

  $oi=$oi+$n1;
  printer_draw_text($handle, $data["cliente"], 105, $oi-2);

  $oi=$oi+$n1;
  printer_draw_text($handle, $data["direccion"], 120, $oi-4);
  printer_draw_text($handle, $data["departamento"], 120, $oi+8);


  $frase = $data["giro"];
  function cortarFrase($frase, $maxPalabras = 3, $noTerminales = ["de"]) {
    $palabras = explode(" ", $frase);
    $numPalabras = count($palabras);
    if ($numPalabras > $maxPalabras) {
       $offset = $maxPalabras - 1;
       while (in_array($palabras[$offset], $noTerminales) && $offset < $numPalabras) { $offset++; }
       return implode(" ", array_slice($palabras, 0, $offset + 1));
    }
    return $frase;
  }

  $frase1 = cortarFrase($frase, 5);
  $frase2 = cortarFrase(str_replace($frase1, '', $frase), 5);


  $oi=$oi+$n1;
  printer_draw_text($handle, $data["municipio"], 130, $oi);
  printer_draw_text($handle, $frase1, 450, $oi);
  printer_draw_text($handle, $data["documento"], 90, $oi+5);


  $oi=$oi+$n1;
  printer_draw_text($handle, $frase2, 450, $oi);
  
  

  $oi=$oi+$n1;
  printer_draw_text($handle, $data["registro"], 480, $oi);

  
  $oi=$oi+$n1;
  //printer_draw_text($handle, "CONTADO", 500, $oi);
  
  
  
  $oi=210; // salto de linea
  
  
      foreach ($data["productos"] as $producto) {
   
  
        $oi=$oi+$n1;
        printer_draw_text($handle, $producto["cant"], $col1, $oi);
        printer_draw_text($handle, $producto["producto"], $col2, $oi);
        printer_draw_text($handle, Helpers::Format4D(Helpers::STotal($producto["pv"], $data['config_imp'])), $col3, $oi);
        printer_draw_text($handle, $producto["stotal"], $col4, $oi);
  
      } 
  
  
  
  /// salto de linea
  $oi=412;
  
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
  
  
  $oi=$oi+$n1+$n1+$n1+35;
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