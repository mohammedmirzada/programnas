<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
if (session_exists('user')) {
	redirect_to("/");
	die();
	exit();
}

$db = db::getInstance();
$user = new user();

$login = '';
if (input_get('token') == session_get('last_token')) {
	if(input_exists()) {
		if(CheckCaptcha(Captcha($_POST['g-recaptcha-response']))) {
			$username = input_get('username');
			$password = input_get('password');
			$remember = input_get('remember');
			$remember = (isset($_POST['remember'])) ? true : false ;
			if (empty($username)) {
				$login = EMAIL_USERNAME_EMPTY;
			}else if (empty($password)) {
				$login = PASS_EMPTY;
			}else{
				if ($db->get('users',array('username','=',$username,'OR','email','=',$username))->count() > 0) {
					$user = new user($username);
					if ($user->isSuspended()) {
						$login = ACCONNT_IS_SUSP;
					}elseif ($user->login($username, $password, $remember)) {
						//$user = new user($username);
						//if(actions::Count('users_session', array('user_ip','=',prespe::GetUserIP(),'AND','user_id','=',$user->data()->id)) == 0){
							$user = new user($username);
							$mail = new email($user->data()->email);
							$mail->LogInAttention();
						//}
						$db->change('users', $user->data()->id, array('deactive' => 0));
						switch (input_get('ref')) {
							case 'settings':
								redirect_to("/settings");
							break;
							case 'verify':
								redirect_to("/support/verify");
							break;
							case 'notifications':
								redirect_to("/notifications");
							break;
							case 'library':
								$url = input_get('url');
								if (!empty($url)) {
									if (strpos($url, 'programnas.com')) {
										redirect_to($url);
									}else{
										redirect_to('/library');
									}
								}else{
									redirect_to("/library");
								}
							break;
							case 'confirm':
								$hash = input_get('hash');
								if (!empty($hash)) {
									redirect_to("https://programnas.com/account/confirm?hash=".$hash);
								}else{
									redirect_to('/questions');
								}
							break;
							default:
								redirect_to('/questions');
							break;
						}
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
	<?=actions::IndexMeta('Log In')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php"; ?>
	
<div class="_Padd8">
	<div class="fix-signin-div">
		<div class="_Padd8">
			<a href="/" class="programnas-second-logo _icons"></a>
			<span class="_fontWeight _FiveText _font16" style="position: relative;top: -12px;"><?=LOGIN?></span>
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
			    		<a href="/reset" class="href-s-side <?=RTL_CLASS?>"><?=FORGOT_PASS?></a>
			    		<div class="_MARtop g-recaptcha" data-sitekey="<?=config_get('recaptcha/site_key')?>"></div>
			    		<div align="center">
			    			<input type="submit" value="<?=LOGIN?>" class="button-signin">
			    		</div>
			    		<label class="remember_container"><?=REMEMBER?>
			    			<input type="checkbox" class="remember_checkbox" name="remember" checked="checked">
			    			<span class="remember_checkmark"></span>
			    		</label>
			    	</div>
					<a href="/signup" class="_create_acc_butt"><?=C_A_A?></a>
					<input type="hidden" name="token" value="<?=$token?>">
			    </form>
		    </div>
		</div>
	</div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; ?>
</body>
</html>