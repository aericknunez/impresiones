<?php
class Helpers{

    public function __construct(){

    } 


    public static function ServerDomain(){
          if($_SERVER["SERVER_NAME"] == "pizto.com" 
          or $_SERVER["SERVER_NAME"] == "www.pizto.com"
          or $_SERVER["SERVER_NAME"] == "superpollo.net"
          or $_SERVER["SERVER_NAME"] == "www.superpollo.net"){
            return TRUE;
          } else {
            return FALSE;
          }
    }

    public static function IsAdmin(){ // verifica si es administrador del sistema
          if($_SESSION["tipo_cuenta"] == 1 and $_SESSION["td"] == 0){
            return TRUE;
          } else {
            return FALSE;
          }
    }

    static public function ServerDemo(){
      $direccion = dirname(__FILE__);
        if (strpos($direccion, 'demo') !== false) {
           return TRUE;
        } else { 
          return FALSE; 
        }  
    }

    static public function ServerPractica(){
      $direccion = dirname(__FILE__);
        if (strpos($direccion, 'practica') !== false) {
           return TRUE;
        } else { 
          return FALSE; 
        }  
    }

    public static function CodigoValidacionHora(){
        $id = date("d-m-Y-H");
        $iden = sha1($id); 
        $hash = strtoupper(substr($iden,0,8));  

        return $hash;
    }

    static public function EdoEcommerce($string) {
    if($string == "0") return '<div class="text-danger font-weight-bold">Anulado</div>';
    if($string == "1") return '<div class="text-secondary font-weight-bold">En Proceso</div>';
    if($string == "2") return '<div class="text-success font-weight-bold">Activo</div>';
    if($string == "3") return '<div class="text-primary font-weight-bold">Enviado</div>';
    if($string == "4") return '<div class="text-info font-weight-bold">Entregado</div>';
    if($string == "5") return '<div class="text-primary-color-dark font-weight-bold">Incompleto</div>';
    }



    static public function Gasto($string) {
    if($string == "1") return '<div class="text-danger font-weight-bold">Compra No Facturado</div>';
    if($string == "2") return '<div class="text-success font-weight-bold">Compra con Factura</div>';
    if($string == "3") return '<div class="text-info font-weight-bold">Remesas</div>';
    if($string == "4") return '<div class="text-primary font-weight-bold">Adelanto a personal</div>';
    if($string == "5") return '<div class="text-warning font-weight-bold">Cheques</div>';
    }


    static public function EstadoCredito($string) {
    if($string == "1") return '<div class="text-success font-weight-bold">Activo</div>';
    if($string == "2") return '<div class="text-info font-weight-bold">Pagado</div>';
    if($string == "0") return '<div class="text-danger font-weight-bold">Eliminado</div>';
    }



    static public function EdoCaduca($edo) {
    if($edo == "1") return '<i class="fas fa-exclamation-triangle fa-lg orange-text"></i> Por caducar';
    if($edo == "2") return '<i class="fas fa-exclamation-circle fa-lg red-text"></i> Caducado';
    if($edo == "0") return '<i class="fas fa-heart fa-lg"></i> Bueno';
    }


    static public function VerTipoSync($tipo) {
    if($tipo == "1") return '<p class="text-danger font-weight-bold">Corte</p>';
    if($tipo == "2") return '<p class="text-success font-weight-bold">Configuracion</p>';
    if($tipo == "3") return '<p class="text-warning font-weight-bold">Todo</p>'; 
    if($tipo == "4") return '<p class="text-primary font-weight-bold">Sync BD</p>';
    if($tipo == "5") return '<p class="text-info font-weight-bold">Sync Upload</p>';
    }


        static public function InOut($string) {
    if($string == "1") return '<div class="text-success font-weight-bold">Entrada</div>';
    if($string == "2") return '<div class="text-danger font-weight-bold">Salida</div>';
    }


    static public function Pais($string) {
        if($string == "1") return 'El Salvador';
        if($string == "2") return 'Honduras';
        if($string == "3") return 'Guatemala';
    }


 static public function TipoPago($string) {
    if($string == "1") return 'Efectivo';
    if($string == "2") return 'Tarjeta';
    if($string == "3") return 'Credito';
    }



    static public function UserName($tipo){
        if($tipo == 1) return "Root";
        if($tipo == 2) return "Administrador";
        if($tipo == 3) return "Cajero";
        if($tipo == 4) return "Usuario";
        if($tipo == 5) return "Gerencia";
    }




    static public function Signo($string) {
    if($string == "1") return '+';
    if($string == "2") return '-';
    }


    public static function Color($elemento){
    if(substr($elemento, -1) == "1") $color="light-blue lighten-5";
    if(substr($elemento, -1) == "2") $color="deep-orange lighten-5";
    if(substr($elemento, -1) == "3") $color="brown lighten-5";
    if(substr($elemento, -1) == "4") $color="cyan lighten-5";
    if(substr($elemento, -1) == "5") $color="blue-grey lighten-5";
    if(substr($elemento, -1) == "6") $color="red lighten-5";
    if(substr($elemento, -1) == "7") $color="cyan lighten-4";
    if(substr($elemento, -1) == "8") $color="deep-purple lighten-5";
    if(substr($elemento, -1) == "9") $color="orange lighten-5";
    if(substr($elemento, -1) == "0") $color="purple lighten-5";
     return $color;
    }


    static public function Mayusculas($nombre){
        return ucwords(strtolower($nombre));
    }

    static public function MayusInicial($nombre){
    return ucfirst(strtolower($nombre));
    }


   static  public function Dinero($numero){  
        $format= $_SESSION['config_moneda_simbolo'] ." " . number_format($numero,2,'.',',');
        return $format;
     } 


    public function Format($numero){ 
        $format=number_format($numero,2,'.',',');
        return $format;
     } 


    public function Format4D($numero){ 
        $format=number_format($numero,4,'.',',');
        return $format;
     } 


    static public function Entero($numero){ 
        $format=intval($numero);
        return $format;
     } 

    
    static public function STotal($numero, $impuestos){  
        $imp = ($impuestos / 100)+1;
        $st = $numero / $imp;
        return $st;
     } 


    static public function Impuesto($numero, $impuestos){  
        $imp = $impuestos / 100;
        return $numero * $imp;
    } 


    static public function Propina($numero){ 
        $num = $_SESSION['config_propina'] / 100;
        $propina = $numero * $num;
        return $propina;
    }


    static public function PropinaTotal($numero){ 
        $num = $_SESSION['config_propina'] / 100;
        $propina = $numero * $num;
        $numer = $propina + $numero;
        return $numer;
    }


    static public function Descuento($numero){ 
        $num = $_SESSION['descuento'] / 100;
        $descuento = $numero * $num;
        return $descuento;
    }

    static public function DescuentoTotal($numero){ 
        $num = $_SESSION['descuento'] / 100;
        $descuento = $numero * $num;
        $numer = $numero - $descuento;
        return $numer;
    }

    static public function DescuentoTotalCot($numero){ 
        $num = $_SESSION['descuento_cot'] / 100;
        $descuento = $numero * $num;
        $numer = $numero - $descuento;
        return $numer;
    }

   static  public function NFactura($numero){ 
        $numero1=str_pad($numero, 8, "0", STR_PAD_LEFT);
        $format="000-001-01-$numero1";
        return $format;
     } 





///////////// para usos de control de usuario ////////
    static public function GetIp(){
        // Intentamos primero saber si se ha utilizado un proxy para acceder a la página,
            // y si éste ha indicado en alguna cabecera la IP real del usuario.
            if (getenv('HTTP_CLIENT_IP')) {
              $ip = getenv('HTTP_CLIENT_IP');
            } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
              $ip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_X_FORWARDED')) {
              $ip = getenv('HTTP_X_FORWARDED');
            } elseif (getenv('HTTP_FORWARDED_FOR')) {
              $ip = getenv('HTTP_FORWARDED_FOR');
            } elseif (getenv('HTTP_FORWARDED')) {
              $ip = getenv('HTTP_FORWARDED');
            } else {
              // Método por defecto de obtener la IP del usuario
              // Si se utiliza un proxy, esto nos daría la IP del proxy
              // y no la IP real del usuario.
              $ip = $_SERVER['REMOTE_ADDR'];
            }

            return $ip;
    }



    static public function ObtenerNavegador($user_agent) {
     $navegadores = array(
          'Opera' => 'Opera',
          'Mozilla Firefox'=> '(Firebird)|(Firefox)',
          'Galeon' => 'Galeon',
          'Google Chrome' => 'Chrome',
          'Mozilla'=>'Gecko',
          'MyIE'=>'MyIE',
          'Lynx' => 'Lynx',
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
          'Konqueror'=>'Konqueror',
          'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
          'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
          'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
          'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
            );
            foreach($navegadores as $navegador=>$pattern){
                   if (eregi($pattern, $user_agent))
                   return $navegador;
                }
            return 'Desconocido';
            }


////////////////////////////// Nuevos Hash $id = base_convert(microtime(false), 10, 36);
public static function HashId(){
  $id = $_SESSION["td"] . "-" . date("d-m-Y-H:i:s") . rand(1,999999999);
  $iden = sha1($id);
  $hash = substr($iden,0,10);
  return $hash;
}


public static function TimeId(){
  $id = strtotime(date("H:i:s"));
  return $id;
}


public static function DeleteId($tabla, $condicion){
  $db = new dbConn();
      if($_SESSION["root_plataforma"] == 0 and $_SESSION['root_tipo_sistema'] != 0){
        $a = $db->query("SELECT hash FROM {$tabla} WHERE {$condicion}"); 
        foreach ($a as $b) {
              $datos = array();
              $datos["tabla"] = $tabla;
              $datos["hash"] = $b["hash"];
              $datos["time"] = self::TimeId();
              $datos["action"] = 1;
              $datos["td"] = $_SESSION["td"];
              $db->insert("sync_tables_updates", $datos);
              if($db->delete($tabla, "WHERE {$condicion}")){
                return TRUE;
              } else {
                return FALSE;
              }
          unset($datos);
        } $a->close();
      } else {
            if($db->delete($tabla, "WHERE {$condicion}")){
                return TRUE;
              } else {
                return FALSE;
              }
      }
}


public static function UpdateId($tabla, $dato, $condicion){
  $db = new dbConn(); // dato actualzar y datos insertar
      if($_SESSION["root_plataforma"] == 0 and $_SESSION['root_tipo_sistema'] != 0){
        $a = $db->query("SELECT hash FROM {$tabla} WHERE {$condicion}"); 
        foreach ($a as $b) {
              $datos = array();
              $datos["tabla"] = $tabla;
              $datos["hash"] = $b["hash"];
              $datos["time"] = self::TimeId();
              $datos["action"] = 2;
              $datos["td"] = $_SESSION["td"];

              /// verifico si hay registro, lo actualizao, sino  lo agrego
              $reg = $db->query("SELECT * FROM sync_tables_updates WHERE tabla = '$tabla' and hash = '".$b["hash"]."' and td = ".$_SESSION["td"]."");
              if($reg->num_rows == 0){
                $db->insert("sync_tables_updates", $datos);
              } else {
                $datopre["time"] = self::TimeId();
                $db->update("sync_tables_updates", $datopre, "WHERE tabla = '$tabla' and hash = '".$b["hash"]."' and td = ".$_SESSION["td"]."");
              } $reg->close();
               /// con esto nada mas se registra una vez           


              $dato["time"] = self::TimeId();
              if($db->update($tabla, $dato, "WHERE {$condicion}")){
                return TRUE;
              } else {
                return FALSE;
              }
          unset($datos);
        } $a->close(); // foreach

      } else { // si es web solo actualizo y ya
            $dato["time"] = self::TimeId();
            if($db->update($tabla, $dato, "WHERE {$condicion}")){
                return TRUE;
              } else {
                return FALSE;
              }
      }  
}


/// para hacer un select sencilo y no tener que andar haciendolos uno a uno
   static public function SelectData($select, $tabla, $iden, $nombre, $selected = NULL) { // NOmbre, tabla, iden = hash nombre= listado
    $db = new dbConn();

      $a = $db->query("SELECT $iden, $nombre FROM $tabla WHERE td = ".$_SESSION["td"]."");
      echo '<option selected disabled>'.$select.'</option>';
      foreach ($a as $b) {  

          if($selected != NULL and $selected == $b[$iden]){
              echo '<option value="'. $b[$iden] .'" selected >'. $b[$nombre] .'</option>'; 
          } else {
              echo '<option value="'. $b[$iden] .'">'. $b[$nombre] .'</option>'; 
          }

      } $a->close(); 

    }



   static public function SelectDataMultiple($select, 
   $tabla, $iden, $nombre, 
   $campo, 
   $tabla2, $iden2, $nombre2, 
   $selected = NULL) { // NOmbre, tabla, iden = hash nombre= listado
    $db = new dbConn();

      $a = $db->query("SELECT $iden, $nombre FROM $tabla WHERE td = ".$_SESSION["td"]."");
      echo '<option selected disabled>'.$select.'</option>';
      foreach ($a as $b) {  
        echo '<optgroup label="'.$b[$nombre].'">';

              $x = $db->query("SELECT $iden2, $nombre2 FROM $tabla2 WHERE $campo = '".$b[$iden]."' and td = ".$_SESSION["td"]."");
              foreach ($x as $y) {

                  if($selected != NULL and $selected == $y[$iden2]){
                      echo '<option value="'. $y[$iden2] .'" selected >'. $y[$nombre2] .'</option>'; 
                  } else {
                      echo '<option value="'. $y[$iden2] .'">'. $y[$nombre2] .'</option>'; 
                  }


              }$x->close();
        echo '</optgroup>';   

      } $a->close(); 

    }








} // class
?>