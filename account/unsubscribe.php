<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$db = db::getInstance();
$user = new user();

if(actions::Count('subscribed_emails', array('hash','=',input_get('hash'),'AND','email','=',input_get('email'))) > 0){
	$db->delete('subscribed_emails', array('email','=',input_get('email')));
}else{
	redirect_to('/');
	exit();
	die();
}

?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<?=actions::IndexMeta()?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php"; ?>
	
<div class="_Padd8">
	<div class="_MarAutoLeftRight" style="max-width: 700px;">
		<div class="bgadk-lines_">
			<h3 align="center" class="<?=RTL_CLASS?>">(<?=input_get('email')?>) <?=UNSUBS?></h3>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; ?>
</body>
</html>