<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

function getParams(&$k, &$o, &$c) {
	$k = isset($_REQUEST ['k']) ? $_REQUEST['k'] : null;
	$o = isset($_REQUEST ['o']) ? $_REQUEST['o'] : null;
	$c = isset($_REQUEST ['c']) ? $_REQUEST['c'] : null;
}


//$operation = $_REQUEST ['op'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane

function validate(&$k, &$o, &$c, &$messages) {


if ( ! (isset($k) && isset($o) && isset($c))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $k == "") {
	$messages [] = 'Nie podano kwoty';
}
if ( $o == "") {
	$messages [] = 'Nie podano procentów';
}

if ( $c == "") {
	$messages [] = 'Nie podano czasu';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $k )) {
		$messages [] = 'Kwota nie jest liczbą';
	}
	
	if (! is_numeric( $o )) {
		$messages [] = 'Oprocentowanie nie jest liczbą';
	}	

	if (! is_numeric( $c )) {
		$messages [] = 'Rok nie jest liczbą';
	}	

	if (count ($messages) != 0) return false;
	else return true;

}
}

// function process($k, $c, $o, $messages, $result){
// 	global $role;
// }



// 3. wykonaj zadanie jeśli wszystko w porządku

//if (empty ( $messages )) { // gdy brak błędów

function process(&$k, &$o, &$c, &$messages, &$result){
	
	//konwersja parametrów na int
	$k = intval($k);
	$o = floatval($o);
	$c = intval($c);
	
	//wykonanie operacji
	$oprocentowanie = $c * $o * 0.01;

	$proc_kwoty = $oprocentowanie * $k;

	// if($i=0 ; $i<=$c ; $i++) {
	// 	$kwota = $k + $proc_kwoty + $kwota;
	// }

	$kwota = $k + $proc_kwoty;

	$m = $c *12;

	$result = round( $kwota / $m);

	}
//}


// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie

$k = null;
$o = null;
$c = null;

$result = null;
$messages = array();

getParams($k, $o, $c);

if(validate($k, $o, $c, $messages)){
	process($k, $o, $c, $messages, $result);
}

include 'bank_view.php';