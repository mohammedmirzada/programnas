<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<?=actions::IndexMeta('About')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/parts/about.php"; ?>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer.php"; ?>
</body>
</html>