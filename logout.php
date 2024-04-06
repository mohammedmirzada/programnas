<?php

include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
ini_set('display_errors', 'OFF');

if (!session_exists('user')) {
	redirect_to("/");
	die();
	exit();
}

$user = new user();

$user->logout();

redirect_to("/");

?>