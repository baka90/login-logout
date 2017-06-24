<?php

include('classes/DB.php');
include('classes/login.php');

if (Login::isLoggedIn()) {

	echo 'Ingelogd ', Login::isLoggedIn();

} else {

	echo 'Niet ingelogd';

}



?>