
<?php //góra strony z szablonu 
include _ROOT_PATH.'/templates/top.php';
?>
<body>

<div style="width:90%; margin: 2em auto;  ">
	<a href="<?php print(_APP_ROOT); ?>/app/inna_chroniona.php" class="pure-button">Kolejna chroniona strona</a>
	
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
</div>

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
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #199e83; width:300px;">
<?php echo 'Spłata miesięczna: '.$result . ' złotych.'; ?>
</div>
<?php } ?>

</body>
<?php //dół strony z szablonu 
include _ROOT_PATH.'/templates/bottom.php';
?>