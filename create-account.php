<?php
	
include('classes/DB.php');

if (isset($_POST['createaccount'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	if ( !DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username) )) {

		if ( strlen($username) >= 3 && strlen($username) <= 32) {

			if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

				if (strlen($password) >= 6 && strlen($password) <= 60) {

					if (filter_var($email, FILTER_VALIDATE_EMAIL)) { 

						if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {

							DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));
							echo "Succes";

						} else {
							echo 'Email is in gebruik';
						}

					} else {
						echo "Email adres ongeldig";
					}

				} else {
					echo 'Wachtwoord ongeldig';
				}

			} else {
				echo 'Gebruikersnaam ongeldig';
			}

		} else {
			echo 'Gebruikersnaam ongeldig';
		}
	} else {
		echo 'Gebruiker bestaat al, kies een andere';
	}
}

?>

<h1>Registreer account</h1>
<form action="create-account.php" method="post">
	<input type="text" name="username" value="" placeholder="username..."> <p />
	<input type="password" name="password" value="" placeholder="password..."> <p />
	<input type="email" name="email" value="" placeholder="someone@somesite.com"> <p />
	<input type="submit" name="createaccount" value="Create Account">
</form>