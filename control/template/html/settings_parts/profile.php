<?php

$error = '';
if(input_get("update") == "profile" && input_get('token') == session_get('last_token')) {
	$image = input_get('image');
	$username = input_get('username');
	$country = input_get('country');
	$bio = input_get('bio');
	$facebook = input_get('facebook');
	$instagram = input_get('instagram');
	$twitter = input_get('twitter');
	$youtube = input_get('youtube');
	$linkedin = input_get('linkedin');

	//subscrabations
	$new_question = (input_get('new_question') == 1) ? 1 : 0 ;
	$new_answer = (input_get('new_answer') == 1) ? 1 : 0 ;

	$private = (input_get('private') == 1) ? 1 : 0 ;

	$validate = new validate();
	$val_image = $validate->ValidateUpdateImage($image);
	$val_username = $validate->ValidateUpdateUsername($username);
	$val_country = $validate->ValidateCountry($country);
	$val_bio = $validate->ValidateBio($bio);

	if (!preg_match('/^[A-Za-z][a-zA-Z0-9._]{3,20}$/', $facebook)) {
		$facebook = '';
	}if (!preg_match('/^[A-Za-z][a-zA-Z0-9._]{3,20}$/', $twitter)) {
		$twitter = '';
	}if (!preg_match('/^[A-Za-z][a-zA-Z0-9._]{3,20}$/', $instagram)) {
		$instagram = '';
	}if (!preg_match('/^[A-Za-z][a-zA-Z0-9._]{3,20}$/', $youtube)) {
		$youtube = '';
	}if (strlen($linkedin) > 50 || validate::JustAbuse($linkedin)) {
		$linkedin = '';
	}

	if (!empty($val_image)) {
		$error = $val_image;
	}elseif (!empty($val_username)) {
		$error = $val_username;
	}elseif (!empty($val_country)) {
		$error = $val_country;
	}elseif (!empty($val_bio)) {
		$error = $val_bio;
	}else{
		if ($image == "https://programnas.com/control/template/media/png/avatar.png") {
			$image = '';
		}
		if(!$db->change('users', $user->data()->id, array('image' => $image, 'username' => $username, 'country' => $country, 'bio' => $bio, 'facebook' => $facebook, 'instagram' => $instagram, 'twitter' => $twitter, 'youtube' => $youtube, 'linkedin' => $linkedin, 'notify_new_question' => $new_question, 'notify_new_answer' => $new_answer, 'is_private' => $private))){
			$error = SOMETHING_WRONG;
		}else{
			if ($username != $user->data()->username) {
				$old_support_code = $user->data()->support_code;
				$new_support_code = str_replace($user->data()->username, $username, $old_support_code);
				$db->change('users', $user->data()->id, array('support_code' => $new_support_code));
			}
			redirect_to('/settings?part=profile');
		}
	}
}
$token = hash_make($_SERVER['SERVER_NAME'],uniqid(mt_rand(), true));
session_put('last_token',$token);

?>
<div id="uploadProModal" class="_None styleModalProCHange" role="dialog" align="center">
	<div class="row">
		<div class="col-md-8 text-center">
			<div id="Pro_demo" class="_Padd8"></div>
		</div>
	</div>
	<div style="margin-top: -26px;">
		<button id="_UploadBTTPro" class="ave_chc"><?=SAVE_CHANGES?></button>
		<span class="_FourText _font18 _cursor _Padd8LeftRight _OverName" onclick="hide('uploadProModal');"><?=CANCEL_?></span>
	</div>
	<?=actions::ProgressBar('pb_upload_pro')?>
</div>

<div class="_Padd8">
	<div class="_Padd8 _RedText <?=RTL_CLASS?>" align="center"><?=$error?></div>
	<div class="_MARtop _MARbot">
		<div align="center">
			<label>
				<span id="img-pro-now" style="background-image: url(<?=$user->ImageIcon()?>);" class="into-prof-pic relative">
					<span class="change-pic-text"><?=CHANGE__?></span>
			    </span>
			    <input type="file" name="upload_Pro" id="upload_Pro" accept="image/*" class="_None">
			</label>
		</div>
	</div>
	<form method="POST" class="">
	    <div class="_FiveText _fontWeight"><?=NAME___?></div>
	    <input type="text" disabled style="background: #00000014;" value="<?=$user->data()->name?>" class="_nput-text-seett">
	    <div class="_FiveText _font12 _SevenText _Padd6"><?=CONTACT_T_C_NAME?></div>
	    <div class="_sett-border-bottom"></div>
	    <div class="_FiveText _font12 _SevenText _Padd6 <?=RTL_CLASS?>"><?=PRIVATE_TEXT?></div>
	    <div>
	    	<label class="gender_container"><?=YES__?>
	    		<input type="radio" name="private" value="1" <?=($user->isPrivate()) ? 'checked' : ''?>>
	    		<span class="gender_checkmark"></span>
	    	</label>
	    	<label class="gender_container"><?=NO__?>
	    		<input type="radio" name="private" value="0" <?=(!$user->isPrivate()) ? 'checked' : ''?>>
	    		<span class="gender_checkmark"></span>
	    	</label>
	    </div>
	    <div class="_sett-border-bottom"></div>
	    <div class="_FiveText _fontWeight"><?=USERNAME?></div>
	    @<input type="text" name="username" value="<?=$user->data()->username?>" class="_nput-text-seett">
	    <div class="_sett-border-bottom"></div>
	    <div class="_FiveText _fontWeight"><?=COUNTRY___?></div>
	    <?php include $_SERVER["DOCUMENT_ROOT"].'/control/template/html/temp/countries.php'; ?>
	    <div class="_sett-border-bottom"></div>
	    <div class="_FiveText _fontWeight"><?=BIO__?></div>
	    <textarea placeholder="<?=Y_BIO___?>" name="bio" class="_nput-text-seett _resizeArea"><?=$user->data()->bio?></textarea>
	    <div class="_sett-border-bottom"></div>
	    <div class="_FiveText _fontWeight"><?=SOCIAL_MED_LINKS?></div>
	    <div class="_InlineFlex">
	    	<span style="top: 10px;position: relative;">facebook.com/</span><input type="text" name="facebook" value="<?=$user->data()->facebook?>" placeholder="username" class="_nput-text-seett" style="width: unset;">
	    </div>
	    <div class="_InlineFlex">
	    	<span style="top: 10px;position: relative;">instagram.com/</span><input type="text" name="instagram" value="<?=$user->data()->instagram?>" placeholder="username" class="_nput-text-seett" style="width: unset;">
	    </div>
	    <div class="_InlineFlex">
	    	<span style="top: 10px;position: relative;">twitter.com/</span><input type="text" name="twitter" value="<?=$user->data()->twitter?>" placeholder="username" class="_nput-text-seett" style="width: unset;">
	    </div>
	    <div class="_InlineFlex">
	    	<span style="top: 10px;position: relative;">youtube.com/</span><input type="text" name="youtube" value="<?=$user->data()->youtube?>" placeholder="username" class="_nput-text-seett" style="width: unset;">
	    </div>
	    <div class="_InlineFlex">
	    	<span style="top: 10px;position: relative;">linkedin.com/in/</span><input type="text" name="linkedin" value="<?=$user->data()->linkedin?>" placeholder="username" class="_nput-text-seett" style="width: unset;">
	    </div>
	    <div class="_sett-border-bottom"></div>
	    <div class="_FiveText _fontWeight"><?=NOTIFY___EMAIL?></div>
	    <div class="_FiveText _font12 _SevenText _Padd6 <?=RTL_CLASS?>"><?=NOTIFY_NEW_QUESTION?></div>
	    <div>
	    	<label class="gender_container"><?=YES__?>
	    		<input type="radio" name="new_question" value="1" <?=($user->isNotifyNewQuestion()) ? 'checked' : ''?>>
	    		<span class="gender_checkmark"></span>
	    	</label>
	    	<label class="gender_container"><?=NO__?>
	    		<input type="radio" name="new_question" value="0" <?=(!$user->isNotifyNewQuestion()) ? 'checked' : ''?>>
	    		<span class="gender_checkmark"></span>
	    	</label>
	    </div>
	    <div class="_FiveText _font12 _SevenText _Padd6 <?=RTL_CLASS?>"><?=NOTIFY_NEW_ANSWER?></div>
	    <div>
	    	<label class="gender_container"><?=YES__?>
	    		<input type="radio" name="new_answer" value="1" <?=($user->isNotifyNewAnswer()) ? 'checked' : ''?>>
	    		<span class="gender_checkmark"></span>
	    	</label>
	    	<label class="gender_container"><?=NO__?>
	    		<input type="radio" name="new_answer" value="0" <?=(!$user->isNotifyNewAnswer()) ? 'checked' : ''?>>
	    		<span class="gender_checkmark"></span>
	    	</label>
	    </div>
	    <div align="center">
		    <input type="submit" name="save" value="<?=SAVE_CHANGES?>" class="save_changes_button">
	    </div>
	    <input type="hidden" name="image" id="image-valued" value="<?=$user->ImageIcon()?>">
	    <input type="hidden" name="update" value="profile">
	    <input type="hidden" name="token" value="<?=$token?>">
	</form>
</div>