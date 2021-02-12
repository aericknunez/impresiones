<?php
class Dinero{

public static function DineroEscrito($cantidad) {

	$cant = number_format($cantidad,2,'.',','); // establezco dos decimales al numero
	$decimales =  substr($cant, -2);
	$numero =  substr($cant, 0, -3);

		if($decimales == "00"){
		return ucfirst(self::convertir($numero) . " DOLARES EXACTOS"); 
		} else {
		return ucfirst(self::convertir($numero) . " " . $decimales . "/100 DOLARES"); 	
		}


  
}




public static function basico($numero) {
	$valor = array ('UNO','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO',
	'NUEVE','DIEZ', 'ONCE', 'DOCE','TRECE','CATORCE','QUINCE','DIECISEIS','DIECISIETE','DIECIOCHO','DIECINUEVE','VEINTE','VEINTIUNO','VEINTIDOS','VEINTITRES','VEINTICUATRO','VEINTICINCO',
	'VEINTISEIS','VEINTISIETE','VEINTIOCHO','VEINTINUEVE');
	return $valor[$numero - 1];
}

public static function decenas($n) {
$decenas = array (30=>'TREINTA',40=>'CUARENTA',50=>'CINCUENTA',60=>'SESENTA',
70=>'SETENTA',80=>'OCHENTA',90=>'NOVENTA');
	if( $n <= 29) return self::basico($n);
	$x = $n % 10;
	if ( $x == 0 ) {
	return $decenas[$n];
	} else return $decenas[$n - $x].' Y '. self::basico($x);
}

public static function centenas($n) {
$cientos = array (100 =>'CIEN',200 =>'DOSCIENTOS',300=>'TRECIENTOS',
400=>'CUATROCIENTOS', 500=>'QUINIENTOS',600=>'SEISCIENTOS',
700=>'SETECIENTOS',800=>'OCHOCIENTOS', 900 =>'NOVECIENTOS');
if( $n >= 100) {
	if ( $n % 100 == 0 ) {
	return $cientos[$n];
	} else {
	$u = (int) substr($n,0,1);
	$d = (int) substr($n,1,2);
	return (($u == 1)?'CIENTO':$cientos[$u*100]).' '.self::decenas($d);
	}
	} else return self::decenas($n);
}

public static function miles($n) {
	if($n > 999) {
	if( $n == 1000) {
		return 'MIL';
	}
		else {
		$l = strlen($n);
		$c = (int)substr($n,0,$l-3);
		$x = (int)substr($n,-3);
		if($c == 1) {$cadena = 'MIL '.self::centenas($x);}
		else if($x != 0) {$cadena = self::centenas($c).' MIL '.self::centenas($x);}
		else $cadena = self::centenas($c). ' MIL';
		return $cadena;
		}
		} else { 
			return self::centenas($n);
			}
	}

public static function millones($n) {
	if($n == 1000000) {
		return 'UN MILLON';
	}
		else {
		$l = strlen($n);
		$c = (int)substr($n,0,$l-6);
		$x = (int)substr($n,-6);
			if($c == 1) {
			$cadena = ' MILLON ';
			} else {
			$cadena = ' MILLONES ';
			}
		return self::miles($c).$cadena.(($x > 0)?self::miles($x):'');
		}
}


public static function convertir($n) {
		switch (true) {
		case ( $n >= 1 && $n <= 29) : return self::basico($n); break;
		case ( $n >= 30 && $n < 100) : return self::decenas($n); break;
		case ( $n >= 100 && $n < 1000) : return self::centenas($n); break;
		case ($n >= 1000 && $n <= 999999): return self::miles($n); break;
		case ($n >= 1000000): return self::millones($n);
		}
}




} // clase
?>