<?php
require_once dirname(__FILE__).'/../config.php';
//ochrona widoku
include _ROOT_PATH.'/app/security/check.php';
?>
<?php //góra strony z szablonu 
include _ROOT_PATH.'/templates/top.php';
?>
<body>

<div style="width:90%; margin: 2em auto;">
	<a href="<?php print(_APP_ROOT); ?>/app/bank.php" class="pure-button">Powrót do obliczeń</a>
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
</div>

<div style="width:90%; margin: 2em auto;">
	<p>To jest inna chroniona strona aplikacji internetowej</p>
</div>	

</body>
<?php //dół strony z szablonu 
include _ROOT_PATH.'/templates/bottom.php';
?>