<?php

$error = '';
$error_two = '';
$success = false;

if (input_get('token') == session_get('last_token')) {
	if(input_get("update") == "security") {

		$c_password = input_get('c_password');
		$new_password = input_get('new_password');
		$repeat_new_password = input_get('repeat_new_password');

		if (!empty($c_password) || !empty($new_password) || !empty($repeat_new_password)) {
			if($user->data()->password === hash_make($c_password, $user->data()->salt)) {
				if ($new_password == $repeat_new_password) {
					$validate = new validate();
					$val_password = $validate->ValidatePassword($repeat_new_password);
					if (!empty($val_password)) {
						$error = $val_password;
					}else{
						$salt = hash_salt(64);
						$password = hash_make($repeat_new_password, $salt);
						if(!$db->change('users', $user->data()->id, array('password' => $password, 'salt' => $salt))){
							$error = SOMETHING_WRONG;
						}else{
							redirect_to('/settings?part=security');
						}
					}
				}else{
					$error = PASSWORD_NOT_MATCHES;
				}
			}else{
				$error = ENTERED_WRONG_PASS_TWO;
			}
		}
	}elseif(input_get("update") == "change_email") {
		$new_email = input_get('new_email');

		$validate = new validate();
		$val_email = $validate->ValidateEmail($new_email, 'email');
		if (!empty($val_email)) {
			$error_two = $val_email;
		}else{
			$hash = hash_make($new_email, hash_salt(64));
			$db->change('users', $user->data()->id, array('email_change' => $new_email, 'hash_email_change' => $hash));
			$success = true;
			$mail = new email($user->data()->email);
			$mail->ChangeEmail($new_email,$hash);
		}
	}elseif(input_get("update") == "deactive") {
		$password = input_get('password');
		if($user->data()->password === hash_make($password, $user->data()->salt)) {
			$db->change('users', $user->data()->id, array('deactive' => 1));
			$db->delete('users_session', array('user_id','=',$user->data()->id));
			redirect_to('/');
		}else{
			$error = ENTERED_WRONG_PASS;
		}
	}
}

$token = hash_make($_SERVER['SERVER_NAME'],uniqid(mt_rand(), true));
session_put('last_token',$token);

?>

<div class="_Padd8">
	<div class="_FiveText _fontWeight"><?=Y_S_CODE?></div>
	<div class="_Width100 _InlineFlex">
		<div style="flex: 1;">
			<input type="text" value="<?=$user->data()->support_code?>" id="_sh_su_code" readonly>
		</div>
		<div style="flex: 0.2;">
			<button onclick="CopyFunc('_sh_su_code')" class="copy_butt"><?=_COPY_IT?></button>
		</div>
	</div>
	<div class="_sett-border-bottom"></div>
	<div class="_Padd8 _RedText" align="center"><?=$error?></div>
	<form method="POST">
	    <div class="_FiveText _fontWeight"><?=PASSWORD?></div>
	    <input type="password" name="c_password" placeholder="<?=CONFIRM_OLD_PASS?>" class="_nput-text-seett">
	    <input type="password" name="new_password" placeholder="<?=NEW_PASSWORD?>" class="_nput-text-seett">
	    <input type="password" name="repeat_new_password" placeholder="<?=REPEAT_NEW_PASS?>" class="_nput-text-seett">
	    <div class="_FiveText _font12 _SevenText _Padd6"><?=FORGET_PASS?></div>
	    <div align="center" class="_MARtop">
		    <input type="submit" name="save" value="<?=SAVE_CHANGES?>" class="save_changes_button">
	    </div>
	    <input type="hidden" name="update" value="security">
	    <input type="hidden" name="token" value="<?=$token?>">
	</form>
	<div class="_sett-border-bottom"></div>
	<div class="_FiveText _fontWeight">
	    <span><?=ACC_STATUS?></span>
	    <span>
	    	<?php
	    	if ($user->isVerified()) {
	    		echo '<span class="_GreenText '.RTL_CLASS.'">'.VERIFIED.'</span>';
	    	}else{
	    		echo NOT_VERIFIED;
	    	}
	    	?>
	    </span>
	</div>
	<div class="_sett-border-bottom"></div>
	<?php if(!$success){ ?>
		<div class="_Padd8 _RedText" align="center"><?=$error_two?></div>
		<form method="POST">
		    <div class="_FiveText _fontWeight"><?=CHANGE_EMAIL?></div>
		    <input type="text" disabled value="<?=$user->data()->email?>" class="_nput-text-seett">
		    <input name="new_email" placeholder="<?=ENTR_NEW_EMMAIL?>" class="_nput-text-seett">
		    <div align="center">
			   <input type="submit" value="<?=CHANGE_EMAIL?>" class="save_changes_button">
		    </div>
		    <input type="hidden" name="update" value="change_email">
		    <input type="hidden" name="token" value="<?=$token?>">
	    </form>
	<?php }else{ ?>
		<div style="margin-bottom: 12px;" class="adver_sent"><?=WE_SENT_VERIFI?> (<?=$user->data()->email?>)</div>
	<?php } ?>
	<div class="_sett-border-bottom"></div>
	<form method="POST">
	    <div class="_FiveText _fontWeight"><?=DEACTIVE_Y_ACCOUNT?></div>
	    <input type="password" name="password" placeholder="<?=PASSWORD?>" class="_nput-text-seett">
	    <div align="center" class="_MARtop">
		    <input type="submit" name="save" value="<?=DEACTIVE?>" class="save_changes_button" style="background: #d06262;">
	    </div>
	    <input type="hidden" name="update" value="deactive">
	    <input type="hidden" name="token" value="<?=$token?>">
	</form>
	<div class="_sett-border-bottom"></div>
	<div class="_FiveText _fontWeight"><?=TWO_FACTOR?></div>
	<div class="_Padd8" align="center">
		<?php
		if ($user->iaAuth()) {
			echo '<button class="save_changes_button" style="border: 0; background: #d06262;" onclick="TwoFactorAuthConfig(\'disable\')">'.DISABLE.'</button>';
		}else{
			echo '<button class="save_changes_button" style="border: 0; background: #62d080;" onclick="TwoFactorAuthConfig(\'enable\')">'.ENABLE.'</button>';
		}
		?>
	</div>
	<div align="center"><?=actions::ProgressBar('pb_load_auth',true)?></div>
	<div id="inner_gen_auth_" class="_Padd8 _None" align="center"></div>
</div>