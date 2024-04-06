<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
?>
<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<title>Programnas - Error 403</title>
</head>
<body>

<div style="position: relative;top: 150px;width: 100%;">
	<span style="background-image: url(/control/template/media/png/403.png);background-size: 320px;display: block;height: 80px;background-repeat: no-repeat;background-position: center;"></span>
	<h1 align="center" style="margin-top: 12px;font-size: 18px;" class="<?=RTL_CLASS?>">
		<?=ERROR_403?>
	</h1>
</div>
</body>
</html>