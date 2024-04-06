<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
if (!session_exists('user')) {
	redirect_to("https://programnas.com/signin?ref=settings");
	die();
	exit();
}

$db = db::getInstance();
$questions = new questions();
$user = new user();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<?=actions::IndexMeta()?>
</head>
<body>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php";
include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/settings.php";
include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; 
?>
</body>
</html>