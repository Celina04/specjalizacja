<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

require_once _ROOT_PATH.'/lib/smarty/Smarty.class.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

include_once _ROOT_PATH.'/app/security/check.php';

// 1. pobranie parametrów

function getParams(&$form) {
	$form['k'] = isset($_REQUEST ['k']) ? $_REQUEST['k'] : null;
	$form['o']= isset($_REQUEST ['o']) ? $_REQUEST['o'] : null;
	$form['c'] = isset($_REQUEST ['c']) ? $_REQUEST['c'] : null;
}


//$operation = $_REQUEST ['op'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane

function validate(&$form,&$infos,&$msgs,&$hide_intro) {


if ( ! (isset($form['k']) && isset($form['o']) && isset($form['c']))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$hide_intro =true;

	$infos [] = 'Przekazano parametry.';
	// $messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $form['k'] == "") {
	$msgs [] = 'Nie podano kwoty';
}
if ( $form['o'] == "") {
	$msgs [] = 'Nie podano procentów';
}

if ( $form['c'] == "") {
	$msgs [] = 'Nie podano czasu';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (count( $msgs )==0) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $form['k'] )) {
		$msgs [] = 'Kwota nie jest liczbą';
	}
	
	if (! is_numeric( $form['o'] )) {
		$msgs [] = 'Oprocentowanie nie jest liczbą';
	}	

	if (! is_numeric( $form['c'] )) {
		$msgs [] = 'Rok nie jest liczbą';
	}	

	if (count ($msgs) > 0) return false;
	else return true;

}
}

	


// 3. wykonaj zadanie jeśli wszystko w porządku

//if (empty ( $messages )) { // gdy brak błędów

function process(&$form, &$infos, &$msgs, &$result){
	global $role;

	// $start  = microtime(true);

	$infos [] = 'Parametry poprawne. Wykonuję obliczenia.';
	
	//konwersja parametrów na int
	$form['k'] = intval($form['k']);
	$form['o'] = floatval($form['o']);
	$form['c'] = intval($form['c']);
	
	//wykonanie operacji
	$oprocentowanie = $form['c'] * $form['o'] * 0.01;

	$proc_kwoty = $oprocentowanie * $k;

	// if($i=0 ; $i<=$c ; $i++) {
	// 	$kwota = $k + $proc_kwoty + $kwota;
	// }

	if($form['o'] < 10 && $role != "admin"){
		$msgs [] = "Tylko admin może liczyć procent mniejszy niż 10";
	} else {
		$kwota = $form['k'] + $proc_kwoty;

		$m = $form['c'] *12;

		$result = round( $kwota / $m);
	}

	// $stop = microtime(true);

	// echo bcsub($start, $stop, 4);

	}
//}


// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie

$form = null;
$infos = array();

$result = null;
$messages = array();

getParams($form);

if(validate($form,$infos,$messages,$hide_intro)){
	process($form,$infos,$messages,$result);
}

//Wywołanie widoku, wcześniej ustalenie zawartości zmiennych elementów szablonu




$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Przykład 05');
$smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty');
$smarty->assign('page_header','Szablony Smarty');

//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);
$smarty->assign('infos',$infos);

// 5. Wywołanie szablonu
$smarty->display(_ROOT_PATH.'/app/bank.html');