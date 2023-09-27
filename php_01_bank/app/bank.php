<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$k = $_REQUEST ['k'];
$o = $_REQUEST ['o'];
$c = $_REQUEST ['c'];
//$operation = $_REQUEST ['op'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
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


}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$k = intval($k);
	$o = intval($o);
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

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'bank_view.php';