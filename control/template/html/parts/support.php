<?php

$validate = new validate();
$db = db::getInstance();

$email = '';
if (session_exists('user')) {
	$email = $user->data()->email;
}

$error = '';
$success = false;
if (input_exists()) {
	if(CheckCaptcha(Captcha($_POST['g-recaptcha-response'])) && input_get('token') == session_get('last_token')) {
		$subject = input_get('subject');
		$content = input_get('content');
		$email = input_get('email');
		$support_code = input_get('support_code');
		$name = input_get('name');
		$phone = input_get('phone');

		$support = input_get('support');
		if ($support == "support_0") {
			$subject = "I want to change my Account Name.";
		}else {
			$subject = "Other";
		}

		if(($support == 'support_0') && empty($support_code)){
			$error = SUPPORT_CODE_REQ;
		}elseif (empty($subject)) {
			$error = SUBJECT_EMPTY;
		}elseif (strlen($subject) > 500) {
			$error = SUBJECT_LONG;
		}elseif (empty($content)) {
			$error = CONTENT_EMPTY;
		}elseif (strlen($content) > 2500) {
			$error = CONTENT_TOO_LONG;
		}elseif (strlen($content) > 2500) {
			$error = CONTENT_TOO_LONG;
		}elseif (!Email($email)) {
            $error = "{$email} ".INCORRECT_FORMAT_EMAIL;
        }elseif (empty($name)) {
            $error = NAME_IS_EMPTY;
        }elseif (strlen($name) > 30) {
            $error = LENGTH_NAME_SU;
        }else{
        	if (!empty($phone)) {
        		if (strlen($phone) > 50) {
        			$phone = '';
        		}
			}
			$body = nl2br('Support: '.$subject."\n".'Name: '.$name."\n".'Email: '.$email."\n".'Support Code: '.$support_code."\n".'Phone: '.$phone."\n".'Content: '."\n".$content);
			$mail = new email($email);
			$mail->SendSupport($name,$subject,$body);
        	$success = true;
        }
	}else{
		$error = F_C_FORM;
	}
}
$token = hash_make($_SERVER['SERVER_NAME'],uniqid(mt_rand(), true));
session_put('last_token',$token);

?>
<div class="slemani-image"></div>
<div style="background: #2d5e7075;height: 500px;">
    <div style="text-shadow: 0px 0px 5px #4a4a4a8f;">
	    <div class="_Padd8">
		    <h1 align="center" class="_MARtop _MARbot">
			    <span class="_WhiteText"><?=SUPPORT__?></span>
		    </h1>
		    <div class="_WhiteText <?=RTL_CLASS?>" align="center"><?=WECANH?></div>
	    </div>
    </div>
    <div class="fix-belw-suppPage">
	    <div align="center" class="_Width100 _InlineFlex" id="column-multi-side">
		    <div style="background-image: url(/control/template/media/svg/support_1.svg);" class="supportd_icons"></div>
		    <div style="background-image: url(/control/template/media/svg/support_2.svg);" class="supportd_icons"></div>
		    <div style="background-image: url(/control/template/media/svg/support_3.svg);" class="supportd_icons"></div>
	    </div>
    </div>
</div>
<div class="bg-below-contact">
	<div align="center">
		<span class="lamp_png"></span>
	</div>
	<div class="fix-blowed-von">
		<form method="POST" style="padding-bottom: 200px;">
			<div class="_InlineFlex _Width100" id="column-multi-side">
				<div style="flex: 0.4;margin-top: 16px;" class="_WhiteText">
					<div class="<?=RTL_CLASS?>"><?=PN_C_.date('Y')?></div>
					<div>
						<span class="email_supp_icc"></span>
						<a class="_WhiteText" href="mailto:<?=config_get('email/username')?>"><u><?=config_get('email/username')?></u></a>
					</div>
				</div>
				<div style="flex: 1;" class="_MARtop">
					<?php if(!$success){ ?>
					<div class="_supporting_error <?=RTL_CLASS?>"><?=$error?></div>
					<div class="inp-supp-c0">
						<div style="color: #ffffff57;"><?=STAR_SUBJECT?></div>
			    		<label class="support_container <?=RTL_CLASS?>"><?=WANT_TO_CHANGE_NAME?>
			    			<input type="radio" name="support" value="support_0">
			    			<span class="support_checkmark"></span>
			    		</label>
			    		<label class="support_container <?=RTL_CLASS?>"><?=OTHER?> <span class="_font12 _WhiteLitText"><?=EXPLAIN_CONTENT?></span>
			    			<input type="radio" name="support" value="support_2">
			    			<span class="support_checkmark"></span>
			    		</label>
			    	</div>
					<textarea name="content" placeholder="<?=CONTENT_STAR?>" class="are-supp-c0"><?=input_get('content')?></textarea>
					<input type="text" name="email" placeholder="<?=EMAIL_STAR?>" class="inp-supp-c0" value="<?=(empty($email))?input_get('email'):$email?>">
					<input type="text" name="support_code" placeholder="<?=SUPPORT_CODE_IF_REQ?>" class="inp-supp-c0 <?=RTL_CLASS?>">
					<div class="fin_supp <?=RTL_CLASS?>"><?=FIND_SUPP_CODE?></div>
					<input type="text" name="name" placeholder="<?=NAME_STAR?>" class="inp-supp-c0" value="<?=input_get('name')?>">
					<input type="text" name="phone" placeholder="<?=PHONE_NUMBER?>" class="inp-supp-c0" value="<?=input_get('phone')?>">
					<input style="border-radius: 0px 0px 8px 8px;" type="submit" value="<?=SEND__?>" class="submit-supp-c0">
					<div class="_MARtop">
						<div class="g-recaptcha" data-sitekey="<?=config_get('recaptcha/site_key')?>"></div>
					</div>
					<div class="_Padd8 <?=RTL_CLASS?>" style="margin-top: 20px;">
						<div align="center">
							<div class="_font14 _WhiteText">
								<span class="<?=RTL_CLASS?>"><?=PN_C_.date('Y')?></span>
								<a href="/about" class="_font14 _WhiteLitText _Mar4LeftRight"><b><?=ABOUT__?></b></a>
				                <a href="/help" class="_font14 _WhiteLitText _Mar4LeftRight"><b><?=HELP__?></b></a>
				                <a href="/terms" class="_font14 _WhiteLitText _Mar4LeftRight"><b><?=TERMS?></b></a>
				                <a href="/library" class="_font14 _WhiteLitText _Mar4LeftRight"><b><?=LIBRARY?></b></a>
				            </div>
				            <div class="_MARtop">
				            	<span class="_font14 _WhiteText"><?=LANG__?></span>
				            	<a href="https://programnas.com/control/template/php/lang?lang=en&ref=<?=GetCurrentURL()?>" class="_font14  _SevenText _WhiteLitText _Mar4LeftRight _cursor"><b>English</b></a>
				                <a href="https://programnas.com/control/template/php/lang?lang=ku_central&ref=<?=GetCurrentURL()?>" class="_font14 _SevenText _WhiteLitText _Mar4LeftRight _cursor"><b>كوردی (سۆرانی)</b></a>
				            </div>
				        </div>
				    </div>
				    <?php }else{ ?>
				    	<div class="adver_sent"><?=THANKS_GET_IN?></div>
				    <?php } ?>
				</div>
			</div>
			<input type="hidden" name="token" value="<?=$token?>">
		</form>
	</div>
</div>