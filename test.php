 <?php  

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

$oi=$oi+20;
printer_draw_text($handle, date("d") . " - " . date("m") ." - " . date("Y"), 460, $oi);



$oi=$oi+20;
printer_draw_text($handle, "Prueba de Impresion", 85, $oi);




printer_delete_font($font);
///
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);
