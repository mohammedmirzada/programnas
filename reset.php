<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$db = db::getInstance();
$user = new user();

$email = '';
if (session_exists('user')) {
	$email = $user->data()->email;
}

$message = '';
$display = '';

if (input_get('token') == session_get('last_token')) {
	if(input_exists()) {
		if(CheckCaptcha(Captcha($_POST['g-recaptcha-response']))) {
			$emailed = input_get('email');
			if (actions::Count('users',array('email','=',$emailed)) > 0) {
				$actions = new actions();
				$actions->GetData('users',array('email','=',$emailed));
				$reset_password_hash = hash_make($user->data()->email, hash_salt(64));
				$changing = $db->change(
					'users', $actions->data()->id,
					array(
						'reset_password_hash' => $reset_password_hash,
						'password_reset_life' => date("Y-m-d")
					)
				);
				if ($changing) {
					$mail = new email($emailed);
					$mail->ResetPassword($name,$reset_password_hash);
					$message = "<div class='_Padd8 ".RTL_CLASS."' align='center'>".RESET_SEND_P_C_E."</div>";
					$display = '_None';
				}else{
					$message = "<div class='_Padd8 _RedText ".RTL_CLASS."' align='center'>".SOMETHING_WRONG."</div>";
				}
			}else{
				$message = "<div class='_Padd8 _RedText ".RTL_CLASS."' align='center'>{$emailed} ".IS_N_EXISTS."</div>";
			}
		}else{
			$message = "<div class='_Padd8 _RedText ".RTL_CLASS."' align='center'>".F_C_FORM."</div>";
		}
	}
}

$token = hash_make($_SERVER['SERVER_NAME'],uniqid(mt_rand(), true));
session_put('last_token',$token);

?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<?=actions::IndexMeta('Reset Password')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php"; ?>
	
<div class="_Padd8">
	<div class="_MarAutoLeftRight" style="max-width: 700px;">
		<form method="POST" class="bgadk-lines_">
			<h2 class="_FiveText"><?=RESET_Y_PASSWORD?></h2>
			<div class="_sett-border-bottom"></div>
			<?=$message?>
			<div class="<?=$display?>">
			    <div class="_FiveText _fontWeight"><?=EMAIL?></div>
			    <input type="text" name="email" class="_nput-text-seett" value="<?=$email?>">
			    <div class="_Padd8 _SevenText _font12"><?=WE_LL_S_REQ?></div>
			    <div class="_MARtop g-recaptcha" data-sitekey="<?=config_get('recaptcha/site_key')?>"></div>
			    <div align="center" class="_MARtop">
				    <input type="submit" name="save" value="<?=SEND_REQ?>" class="save_changes_button">
	            </div>
	        </div>
	         <input type="hidden" name="token" value="<?=$token?>">
		</form>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; ?>
</body>
</html>