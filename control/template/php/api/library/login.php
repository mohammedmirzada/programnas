<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";

if (session_exists('user')) {
	redirect_to("/");
}

$db = db::getInstance();
$user = new user();

$login = '';
if (input_get('token') == session_get('last_token')) {
	if(input_exists()) {
		if(CheckCaptcha(Captcha($_POST['g-recaptcha-response']))) {
			$username = input_get('username');
			$password = input_get('password');
			if (empty($username)) {
				$login = EMAIL_USERNAME_EMPTY;
			}else if (empty($password)) {
				$login = PASS_EMPTY;
			}else{
				if ($db->get('users',array('username','=',$username,'OR','email','=',$username))->count() > 0) {
					$user = new user($username);
					if ($user->isSuspended()) {
						$login = ACCONNT_IS_SUSP;
					}elseif ($user->data()->password === hash_make($password, $user->data()->salt)) {
						$user = new user($username);
						$mail = new email($user->data()->email);
						$mail->LogInAttention();
						$db->change('users', $user->data()->id, array('deactive' => 0));
						redirect_to('https://programnas.com/control/template/php/api/library/login?login=true&user_id='.$user->data()->id);
					}else{
						$login = ENTERED_WRONG_PASS;
					}
				}else{
					$login = "{$username} ".IS_N_EXISTS."";
				}
			}
		}else{
			$login = F_C_FORM;
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
</head>
<body style="margin-top: 100px;">	
<div class="_Padd8">
	<div class="fix-signin-div">
		<div class="_Padd8">
			<h2 class="_fontWeight _FiveText" style="position: relative;top: -12px;"><?=LOGIN?></h2>
		</div>
		<div class="bg-account">
			<div class="_InlineFlex _Width100" id="column-multi-side">
			    <form method="POST" class="acc-f-side">
			    	<div id="error-account-form" class="<?=RTL_CLASS?>"><?=$login?></div>
			    	<div>
			    		<span class="_fontWeight _SevenText _font12"><?=EMAIL_OR_USERNAME?></span>
			    		<input type="text" name="username" class="input-acc-sign" value="<?=input_get("username")?>">
			    		<span class="_fontWeight _SevenText _font12"><?=PASSWORD?></span>
			    		<input type="password" name="password" class="input-acc-sign">
			    		<div class="_MARtop g-recaptcha" data-sitekey="<?=config_get('recaptcha/site_key')?>"></div>
			    		<div align="center">
			    			<input type="submit" value="<?=LOGIN?>" class="button-signin">
			    		</div>
			    	</div>
					<input type="hidden" name="token" value="<?=$token?>">
			    </form>
		    </div>
		</div>
	</div>
</div>
</body>
</html>