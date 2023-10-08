 <?php  
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

// sublima Soyapango

class Impresiones{
    public function __construct() { 
     } 



 public function Ticket($data){
    
    $txt1   = "15"; 
    $txt2   = "5";
    $txt3   = "0";
    $txt4   = "0";
    $n1   = "16";
    $n2   = "60";
    $n3   = "30";
    $n4   = "0";
    
    
    $col1 = 50;
    $col2 = 130;
    $col3 = 620;
    $col4 = 875;
    $col5 = 500;
    // $print
    $print = "FACTURA";
    
    $handle = printer_open($print);
    printer_set_option($handle, PRINTER_MODE, "RAW");
    
    printer_start_doc($handle, "Mi Documento");
    printer_start_page($handle);
    
    
    $font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
    printer_select_font($handle, $font);
    
    
    
    $oi=95;
    //// comienza la factura
    $oi=$oi+$n1;
    printer_draw_text($handle, "Sublima El Salvador", $col1, $oi);
    $oi=$oi+$n1;
    printer_draw_text($handle, "Tel: 2132-2987", $col1, $oi);
    $oi=$oi+$n1;
    printer_draw_text($handle, "Ticket Numero: ".$data["num_fac"], $col1, $oi);
    
    
    $oi=$oi+$n1;
    printer_draw_text($handle, "Fecha : " .date("d") . " de " . Fechas::MesEscrito(date("m")) ." de " . date("Y"), $col1, $oi);
    printer_draw_text($handle, "Cliente: " .iconv("UTF-8", "ISO-8859-1", $data["nombre"]), $col1, $oi+$n1);
    printer_draw_text($handle, "Direccion: ".iconv("UTF-8", "ISO-8859-1", $data["direccion"]), $col1, $oi+$n1+$n1);   
    
    $oi=200; // salto de linea

    $oi=$oi+$n1;
    printer_draw_text($handle, "Cant", $col1, $oi);
    printer_draw_text($handle, "Producto", $col2, $oi);
    printer_draw_text($handle, "Precio U", $col3, $oi);
    printer_draw_text($handle, "Total", $col4, $oi);
    
        foreach ($data["productos"] as $producto) {
     
    
              $oi=$oi+$n1;
              printer_draw_text($handle, $producto["cant"], $col1, $oi);
              printer_draw_text($handle, iconv("UTF-8", "ISO-8859-1", $producto["producto"]), $col2, $oi);
              printer_draw_text($handle, $producto["pv"], $col3, $oi);
              printer_draw_text($handle, $producto["total"], $col4, $oi);
    
        } 
    
    
    
    
    
    /// salto de linea
    $oi=600;
    
    // valores en letras
    printer_draw_text($handle,"Son: " .Dinero::DineroEscrito($data["total"]), $col1, $oi);
    // echo wordwrap($cadena, 15, "<br>" ,FALSE);
    
    // volores numericos
    printer_draw_text($handle, "Sumas $ " .Helpers::Format($data["total"]), $col4-60, $oi);
    
    printer_draw_text($handle, "Total $ " .Helpers::Format($data["total"]), $col4-45, $oi+$n1);
    
    
    printer_delete_font($font);
    
    printer_end_page($handle);
    printer_end_doc($handle);
    printer_close($handle);


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
    
    
    $col1 = 50;
    $col2 = 130;
    $col3 = 620;
    $col4 = 875;
    $col5 = 500;
    // $print
    $print = "FACTURA";
    
    $handle = printer_open($print);
    printer_set_option($handle, PRINTER_MODE, "RAW");
    
    printer_start_doc($handle, "Mi Documento");
    printer_start_page($handle);
    
    
    $font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
    printer_select_font($handle, $font);
    
    
    
    $oi=95;
    //// comienza la factura
    
    
    
    $oi=$oi+$n1+6;
    printer_draw_text($handle, iconv("UTF-8", "ISO-8859-1", $data["nombre"]), 190, $oi+$n1);
    printer_draw_text($handle, date("d") . " de " . Fechas::MesEscrito(date("m")) ." de " . date("Y"), 695, $oi+$n1);
    
    $oi=$oi+6;
    printer_draw_text($handle, iconv("UTF-8", "ISO-8859-1", $data["direccion"]), 110, $oi+$n1+$n1+5);
    
    printer_draw_text($handle, $data["documento"], 110, $oi+$n1+$n1+$n1+$n1);

    printer_draw_text($handle, "CONTADO", 400, $oi+$n1+$n1+$n1+$n1);
    
    
    $oi=225; // salto de linea
    
    
        foreach ($data["productos"] as $producto) {
     
    
              $oi=$oi+$n1;
              printer_draw_text($handle, $producto["cant"], $col1, $oi);
              printer_draw_text($handle, iconv("UTF-8", "ISO-8859-1", $producto["producto"]), $col2, $oi);
              printer_draw_text($handle, $producto["pv"], $col3, $oi);
              printer_draw_text($handle, $producto["total"], $col4, $oi);
    
        } 
    
    
    
    
    
    /// salto de linea
    $oi=600;
    
    // valores en letras
    printer_draw_text($handle, Dinero::DineroEscrito($data["total"]), $col2, $oi);
    // echo wordwrap($cadena, 15, "<br>" ,FALSE);
    
    // volores numericos
    printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
    
    
    $oi=$oi+$n1+$n1;
    printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi-6);
    
    
    $oi=$oi+$n1+$n1+32;
    printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi+12);
    
    
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
        
        
        $col1 = 50;
        $col2 = 130;
        $col3 = 620;
        $col4 = 875;
        $col5 = 800;
        // $print
        $print = "FACTURA";
    
    $handle = printer_open($print);
    printer_set_option($handle, PRINTER_MODE, "RAW");
    
    printer_start_doc($handle, "Mi Documento");
    printer_start_page($handle);
    
    
    $font = printer_create_font("Arial", $txt1, $txt2, PRINTER_FW_NORMAL, false, false, false, 0);
    printer_select_font($handle, $font);
    
    
    
    $oi=120;
    //// comienza la factura
    
    
    
    $oi=$oi+$n1;
    printer_draw_text($handle, iconv("UTF-8", "ISO-8859-1", $data["cliente"]), 190, $oi-6);
    printer_draw_text($handle, date("d") . " de " . Fechas::MesEscrito(date("m")) ." de " . date("Y"), 685, $oi-6);
    
    $oi=$oi+$n1+5;
    printer_draw_text($handle, iconv("UTF-8", "ISO-8859-1", $data["direccion"]), 115, $oi);
    printer_draw_text($handle, $data["registro"], 685, $oi);

    $oi=$oi+$n1;

    

    $oi=$oi+$n1;
    printer_draw_text($handle, $data["documento"], 110, $oi-3);
    printer_draw_text($handle, iconv("UTF-8", "ISO-8859-1", $data["giro"]), 325, $oi-3);

    $oi=$oi+$n1+5;
    printer_draw_text($handle, iconv("UTF-8", "ISO-8859-1", $data["departamento"]), 100, $oi);
    printer_draw_text($handle, "CONTADO", 685, $oi);
    
    
    
    $oi=250; // salto de linea
    
    
        foreach ($data["productos"] as $producto) {
     
    
          $oi=$oi+$n1;
          printer_draw_text($handle, $producto["cant"], $col1, $oi);
          printer_draw_text($handle, iconv("UTF-8", "ISO-8859-1", $producto["producto"]), $col2, $oi);
          printer_draw_text($handle, Helpers::Format4D(Helpers::STotal($producto["pv"], $data['config_imp'])), $col3, $oi);
          printer_draw_text($handle, $producto["stotal"], $col4, $oi);
    
        } 
    
    
    
    /// salto de linea
    $oi=595;
    
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
    
    
    $oi=$oi+$n1+$n1+$n1+25;
    printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
    
    
    printer_delete_font($font);
    ///
    printer_end_page($handle);
    printer_end_doc($handle);
    printer_close($handle);
    
    
    }
    
    
    
    
    
    
    
    
     public function Exportaciones($data){
    
    
        $txt1   = "15"; 
        $txt2   = "5";
        $txt3   = "0";
        $txt4   = "0";
        $n1   = "16";
        $n2   = "60";
        $n3   = "30";
        $n4   = "0";
        
        
        $col1 = 41;
        $col2 = 99;
        $col3 = 430;
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
    
    
    
    $oi=74;
    //// comienza la factura
    
    
    
    $oi=$oi+$n1;
    printer_draw_text($handle, date("d") . " " . Fechas::MesEscrito(date("m")) ."" . date("Y"), 450, $oi);
    
    $oi=$oi+$n1+5;
    printer_draw_text($handle, $data["nombre"], 250, $oi);


    $oi=$oi+$n1+$n1+5;
    printer_draw_text($handle, $data["direccion"], 115, $oi);

    $oi=$oi+$n1+4;
    printer_draw_text($handle, $data["documento"], 100, $oi);

    $oi=$oi+$n1;
    printer_draw_text($handle, $data["telefono"], 130, $oi);
    

    
    
    
    $oi=215; // salto de linea
    
    
        foreach ($data["productos"] as $producto) {
     
    
              $oi=$oi+$n1;
              printer_draw_text($handle, $producto["cant"], $col1, $oi);
              printer_draw_text($handle, $producto["producto"], $col2, $oi);
              printer_draw_text($handle, $producto["pv"], $col3, $oi);
              printer_draw_text($handle, $producto["total"], $col4, $oi);
    
        } 
    
    
    
    
    
    /// salto de linea
    $oi=406;
    
        // volores numericos
    printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
    
    $oi=415;

    // valores en letras
    printer_draw_text($handle, Dinero::DineroEscrito($data["total"]), $col2, $oi);
    // echo wordwrap($cadena, 15, "<br>" ,FALSE);
    

    

    
    $oi=$oi+$n1+20;
    printer_draw_text($handle, Helpers::Format($data["total"]), $col4, $oi);
    



    
    printer_delete_font($font);
    
    printer_end_page($handle);
    printer_end_doc($handle);
    printer_close($handle);
    
    
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