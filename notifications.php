<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
if (!session_exists('user')) {
	redirect_to("https://programnas.com/signin?ref=notifications");
	die();
	exit();
}
$notifications = new notifications();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<?=actions::IndexMeta()?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php"; ?>

<div class="viwall_nofi_ax">
	<div class="viwall_nofi_ax_box">
		<h3 align="center"><?=ALL_NOTIFI?></h3>
		<div class="_Padd8">
			<?=$notifications->GetAllNotifications()?>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; ?>
</body>
</html>