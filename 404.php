<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
?>
<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<title>Programnas - Error 404</title>
</head>
<body>

<div style="position: relative;top: 150px;width: 100%;">
	<span style="background-image: url(/control/template/media/png/404.png);background-size: 320px;display: block;height: 150px;background-repeat: no-repeat;background-position: center;"></span>
	<div align="center" style="margin-top: 12px;font-size: 18px;" class="<?=RTL_CLASS?>">
		<?=ERROR_404?>
	</div>
</div>
</body>
</html>