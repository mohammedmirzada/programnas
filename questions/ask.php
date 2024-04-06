<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$db = db::getInstance();
$validate = new validate();
$user = new user();

if (!session_exists('user')) {
	redirect_to("/signin");
	die();
	exit();
}
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
if ($validate->CanAsk()) {
	include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/ask.php"; 
    include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer.php"; 
}else{
	echo('<div class="_Padd8LeftRight"><div class="cantASK '.RTL_CLASS.'">'.CANT_ASK.'</div></div>');
}
?>
</body>
</html>