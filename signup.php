<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
if (session_exists('user')) {
	redirect_to("/");
	die();
	exit();
}

$register = '';
$created = false;

if (input_get('token') == session_get('last_token')) {
	if(input_exists()) {
		if(CheckCaptcha(Captcha($_POST['g-recaptcha-response']))) {
			$name = input_get('name');
			$email = input_get('email');
			$username = input_get('username');
			$password = input_get('password');
			$confirm_password = input_get('confirm_password');
			$gender = input_get('gender');
			$years = input_get('years');
			$months = input_get('months');
			$days = input_get('days');
			$country = input_get('country');
			$image = input_get('image');

			$validate = new validate();
			$val_name = $validate->ValidateName($name);
			$val_email = $validate->ValidateEmail($email,'email');
			$val_username = $validate->ValidateUsername($username);
			$val_gender = $validate->ValidateGender($gender);
			$val_birthdate = $validate->ValidateBirthdate($years,$months,$days);
			$val_country = $validate->ValidateCountry($country);
			if (!empty($val_name)) {
				$register = $val_name;
			}elseif (!empty($val_email)) {
				$register = $val_email;
			}elseif (!empty($val_username)) {
				$register = $val_username;
			}elseif (!empty($val_gender)) {
				$register = $val_gender;
			}elseif (!empty($val_birthdate)) {
				$register = $val_birthdate;
			}elseif (!empty($val_country)) {
				$register = $val_country;
			}else{
				if ($password == $confirm_password) {
					$val_password = $validate->ValidatePassword($password);
					if (!empty($val_password)) {
						$register = $val_password;
					}else{
						//register
						$confirm_hash = hash_make($email, hash_salt(64));
						$confirm_code = RAND(111111,999999);

						$birthdate = $days.'/'.$months.'/'.$years;
						$db = db::getInstance();
						$salt = hash_salt(64);
						$inserted = $db->insert('users', array(
							'name' => $name,
							'username' => strtolower($username),
							'email' => strtolower($email),
							'gender' => $gender,
							'birthdate' => $birthdate,
							'country' => $country,
							'image' => $image,
							'salt' => $salt,
							'password' => hash_make($password, $salt),
							'confirm_hash' => $confirm_hash,
							'confirm_code' => $confirm_code,
							'support_code' => 'pn-'.RAND(11111111,99999999).'~'.time().'~'.strtolower($username),
							'joined' => date('Y-m-d')
						));
						if ($inserted) {
							$created = true;
							$mail = new email($email);
							$mail->ConfirmEmail($name,$confirm_hash,$confirm_code);
							redirect_to("/signin");
						}else{
							$register = SOMETHING_WRONG;
						}
					}
				}else{
					$register = PASSWORD_NOT_MATCHES;
				}
			}
		}else{
			$register = F_C_FORM;
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
	<?=actions::IndexMeta('Create Account')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php"; ?>
<div class="_Padd8">
	<div class="fix-signin-div">
		<div class="_Padd8">
			<a href="/" class="programnas-second-logo _icons"></a>
			<span class="_fontWeight _FiveText _font16" style="position: relative;top: -12px;"><?=SIGNUP_FOR_PN?></span>
		</div>
		<div class="bg-account">
		<?php if (!$created) { ?>
			<div>
			    <form method="POST" class="acc-f-side">
			    	<div>
			    		<div id="error-account-form" class="<?=RTL_CLASS?>"><?=$register?></div>
			    		<span class="_fontWeight _SevenText _font12"><?=YOUR_NAME?></span>
			    		<input type="text" name="name" id="name" class="input-acc-sign" value="<?=input_get('name')?>">
			    		<span class="_fontWeight _SevenText _font12"><?=EMAIL?></span>
			    		<input type="text" name="email" id="email" class="input-acc-sign" value="<?=input_get('email')?>">
			    		<span class="_fontWeight _SevenText _font12"><?=USERNAME?></span>
			    		<input type="text" name="username" id="username" class="input-acc-sign" value="<?=input_get('username')?>">
			    		<span class="_fontWeight _SevenText _font12"><?=PASSWORD?></span>
			    		<input type="password" name="password" id="password" class="input-acc-sign">
			    		<span class="_fontWeight _SevenText _font12"><?=CONFIRM_PASSWORD_TWO?></span>
			    		<input type="password" name="confirm_password" id="confirm_password" class="input-acc-sign">
			    		<span class="_fontWeight _SevenText _font12"><?=BIRTH?></span>
			    		<div class="_MARbot">
			    			<?php include $_SERVER["DOCUMENT_ROOT"].'/control/template/html/temp/birthdate.php'; ?>
			    		</div>
			    		<span class="_fontWeight _SevenText _font12"><?=COUNTRY_TE?></span>
			    		<div class="_MARbot">
			    			<?php include $_SERVER["DOCUMENT_ROOT"].'/control/template/html/temp/countries.php'; ?>
			    		</div>
						<input type="hidden" name="image" id="image">
			    		<span class="_fontWeight _SevenText _font12"><?=GENDER?></span>
			    		<div>
			    			<label class="gender_container"><?=MALE?>
			    			    <input type="radio" name="gender" id="gender_0" value="Male">
			    			    <span class="gender_checkmark"></span>
			    		    </label>
			    		    <label class="gender_container"><?=FEMALE?>
			    			    <input type="radio" name="gender" id="gender_1" value="Female">
			    			    <span class="gender_checkmark"></span>
			    		    </label>
			    		    <label class="gender_container"><?=PRE_NT_SAY?>
			    			    <input type="radio" name="gender" id="gender_2" value="Other">
			    			    <span class="gender_checkmark"></span>
			    		    </label>
			    		</div>
			    		<div class="g-recaptcha" data-sitekey="<?=config_get('recaptcha/site_key')?>"></div>
			    		<div align="center">
			    			<input type="submit" value="<?=SIGNIP?>" onclick="SignUp()" class="button-signin">
			    		</div>
			    		<div class="_font12 _SevenText _Padd8 <?=RTL_CLASS?>"><?=AGREED_TO_TERMS?></div>
			    	</div>
			    	<input type="hidden" name="token" value="<?=$token?>">
			    </form>
			    <?php ?>
		    </div>
		<?php }else{ ?>
			<div class="_Padd8 _FiveText" align="center">
				<div class="_Padd8 <?=RTL_CLASS?>"><?=CONGRATS_CREATED_ACC?></div>
				<a href="/signin"><u><?=SIGN_IN?></u></a>
			</div>
		<?php } ?>
		</div>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; ?>
</body>
</html>