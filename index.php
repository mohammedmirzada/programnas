<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$questions = new questions();

$username = input_get("username");

?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<?php
	if (!empty($username) && validate::LinkUsername($username) && actions::Count('users',array('username','=',$username,'AND','deactive','=',0)) > 0) {
		echo actions::IndexMetaProfile($username);
	}else{
		echo actions::IndexMeta();
	}
	?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php"; ?>
<?php

if (session_exists('user')) {
	$user = new user();
	if ($user->data()->username == input_get("username")) {
		$isu = true;
		$user = new user();
		$payment = new payment();
	}else{
		$user = new user($username);
		$isu = false;
	}
}else{
	$user = new user($username);
	$isu = false;
}



if (empty($username)) {
	include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/home.php";
}else{
	if (validate::LinkUsername($username)) {
		$count_username = actions::Count('users',array('username','=',$username));
		if ($count_username > 0) {
			if (user::isDeactive($username)) {
				http_response_code(404);
			    include $_SERVER['DOCUMENT_ROOT'].'/404.php';
			    die();
			    exit();
			}else{
				include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/profile.php";
			}
		}else{
			http_response_code(404);
			include $_SERVER['DOCUMENT_ROOT'].'/404.php';
			die();
			exit();
		}
	}else{
		http_response_code(404);
		include $_SERVER['DOCUMENT_ROOT'].'/404.php';
		die();
		exit();
	}
}

?>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer.php"; ?>
</body>
</html>