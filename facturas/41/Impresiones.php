 <?php  
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

// Toque Diamante Eventos

class Impresiones{
    public function __construct() { 
     } 



 public function Ticket($data){


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
    $col2 = 89;
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
    
    
    
    $oi=$oi+$n1;
    printer_draw_text($handle, $data["nombre"], 95, $oi+$n1);
    printer_draw_text($handle, date("d") . " " . Fechas::MesEscrito(date("m")) ."" . date("Y"), 400, $oi);
    
    $oi=$oi+$n1;
    printer_draw_text($handle, $data["direccion"], 110, $oi+$n1);
    
    printer_draw_text($handle, $data["documento"], 110, $oi+$n1+$n1);
    
    
    $oi=174; // salto de linea
    
    
        foreach ($data["productos"] as $producto) {
     
    
              $oi=$oi+$n1;
              printer_draw_text($handle, $producto["cant"], $col1, $oi);
              printer_draw_text($handle, $producto["producto"], $col2, $oi);
              printer_draw_text($handle, $producto["pv"], $col3, $oi);
              printer_draw_text($handle, $producto["total"], $col4, $oi);
    
        } 
    
    
    
    
    
    /// salto de linea
    $oi=427;
    
    // valores en letras
    printer_draw_text($handle, Dinero::DineroEscrito($data["total"]), $col2, $oi);
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
    
    
    
    $oi=74;
    //// comienza la factura
    
    
    
    $oi=$oi+$n1;
    printer_draw_text($handle, $data["cliente"], 95, $oi);
    printer_draw_text($handle, date("d") . " " . Fechas::MesEscrito(date("m")) ."" . date("Y"), 400, $oi);
    
    $oi=$oi+$n1;
    printer_draw_text($handle, $data["registro"], 430, $oi);

    $oi=$oi+$n1;
    printer_draw_text($handle, $data["direccion"], 100, $oi);
    printer_draw_text($handle, $data["documento"], 400, $oi);

    $oi=$oi+$n1;
    printer_draw_text($handle, $data["giro"], 400, $oi);

    $oi=$oi+$n1;
    printer_draw_text($handle, $data["departamento"], 130, $oi);
    
    $oi=$oi+$n1;
    printer_draw_text($handle, "CONTADO", 215, $oi);
    
    
    
    $oi=191; // salto de linea
    
    
        foreach ($data["productos"] as $producto) {
     
    
          $oi=$oi+$n1;
          printer_draw_text($handle, $producto["cant"], $col1, $oi);
          printer_draw_text($handle, $producto["producto"], $col2, $oi);
          printer_draw_text($handle, Helpers::Format4D(Helpers::STotal($producto["pv"], $data['config_imp'])), $col3, $oi);
          printer_draw_text($handle, $producto["stotal"], $col4, $oi);
    
        } 
    
    
    
    /// salto de linea
    $oi=405;
    
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
    
    
    
    
    
    
    
    
     public function Exportaciones($data){
    
    
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

    $oi=$oi+$n1;
    printer_draw_text($handle, $data["documento"], 100, $oi);

    $oi=$oi+$n1;
    printer_draw_text($handle, $data["telefono"], 130, $oi);
    

    
    
    
    $oi=208; // salto de linea
    
    
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