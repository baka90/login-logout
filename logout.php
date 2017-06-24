<?php
ob_start();

include('classes/DB.php');
include('classes/Login.php');


if (!Login::isLoggedIn()) {

	die('Niet ingelogd.');
}	

if (isset($_POST['confirm'])) {

	if (isset($_POST['alldevices'])) {

		DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>Login::isLoggedIn()));
		die('Niet ingelogd.');

} else {

		if (isset($_COOKIE['SNID'])) { 

			DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
		}

		setcookie("SNID", '', time() - 60 * 60 * 24 * 356, '/', NULL, NULL, TRUE);
		setcookie("SNID_", '1', time() - 60 * 60 * 24 * 356, '/', NULL, NULL, TRUE);
		die('Niet ingelogd.');
	}
}

?>

<h1>Uitloggen</h1>
<p>Weet je zeker dat je wilt uitloggen?</p>
<form action="logout.php" method="post">
	<input type="checkbox" name="alldevices" value="alldevices"> Alle ingelogde apparaten uitloggen.<br />
	<input type="submit" name="confirm" value="Bevestigen">
</form>