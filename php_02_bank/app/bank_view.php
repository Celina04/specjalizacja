<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Bank</title>
</head>
<body>

<form action="<?php print(_APP_URL);?>/app/bank.php" method="post">
	<label for="kwota">Kwota kredytu: </label>
	<input id="kwota" type="text" name="k" value="<?php out($k); ?>" /><br />
	<label for="id_op">Oprocentowanie kredytu: </label>
	<input id="id_op" type="text" name="o" value="<?php out($o); ?>" /><br />
	<label for="czas">Ilość lat: </label>
	<input id="czas" type="text" name="c" value="<?php  out($c); ?>" /><br />
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Spłata miesięczna: '.$result . ' złotych.'; ?>
</div>
<?php } ?>

</body>
</html>