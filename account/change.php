<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$db = db::getInstance();
$user = new user();

if (!session_exists('user')) {
	redirect_to('/');
	exit();
	die();
}else{
	if ($user->data()->hash_email_change == input_get('hash')) {
		if($db->get('users', array('email','=',$user->data()->email_change))->count() == 0){
			$confirm_hash = hash_make($user->data()->email, hash_salt(64));
			$confirm_code = RAND(111111,999999);
			$db->change('users', $user->data()->id, 
				array(
					'email' => $user->data()->email_change,
					'email_change' => '',
					'hash_email_change' => '',
					'confirmed' => 0,
					'confirm_hash' => $confirm_hash,
					'confirm_code' => $confirm_code
				)
			);
			$actions = new actions();
			$actions->GetData('users', array('id','=',$user->data()->id));
			$mail = new email($actions->data()->email);
			$mail->ConfirmEmail($actions->data()->name, $confirm_hash, $confirm_code);
		}else{
			redirect_to('/');
			exit();
			die();
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
			<h3 align="center" class="<?=RTL_CLASS?>"><?=EMAIL_CHANGES_S.$user->data()->email.CHECK_INBOX_?></h3>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; ?>
</body>
</html>