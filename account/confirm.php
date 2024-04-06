<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$db = db::getInstance();
$user = new user();

if (!session_exists('user')) {
	redirect_to('https://programnas.com/signin/?ref=confirm&hash='.input_get('hash'));
	exit();
	die();
}else{
	if ($user->data()->confirm_hash == input_get('hash')) {
		$db->change('users', $user->data()->id, array('confirmed' => 1));
		if(actions::Count('subscribed_emails', array('email','=',$user->data()->email)) == 0){
	    	$db->insert('subscribed_emails', array('email' => $user->data()->email, 'hash' => hash_make($user->data()->email,uniqid(mt_rand(), true))));
	    }
	}else{
		redirect_to('/');
	    exit();
	    die();
	}
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
			<h3 align="center" class="<?=RTL_CLASS?>"><?=EMAIL_CONFIRMED?></h3>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; ?>
</body>
</html>