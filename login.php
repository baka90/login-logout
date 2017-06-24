<?php
//ob_start();

include('classes/DB.php');

if (isset($_POST['login'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	if ( DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username) )) {

		if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {

			//Make two cookies, the second one to check the extended time
			$cstrong = true;
			$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
			$user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
			DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));

			setcookie("SNID", $token, time() + 60 * 60, '/', NULL, NULL, TRUE);
			setcookie("SNID_", '1', time() + 60 * 5, '/', NULL, NULL, TRUE);

			echo 'Welkom ', $username;

		} else {

			echo 'Gebruikersnaam met wachtwoord combinatie onbekend';
		}

	} else {

		echo 'Gebruikersnaam met wachtwoord combinatie onbekend';
	}
}

?>

<h1>Inloggen</h1>
<form action="login.php" method="post">
	<input type="text" name="username" value="" placeholder="username..."> <p />
	<input type="password" name="password" value="" placeholder="password..."> <p />
	<input type="submit" name="login" value="Log in">
	<p id="testje"></p>
</form>
