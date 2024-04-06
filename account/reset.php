<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$db = db::getInstance();
$user = new user();
$actions = new actions();
$validate = new validate();

$hash = input_get('hash');
$actions->GetData('users',array('reset_password_hash','=',$hash));
$data = $actions->data();

$message = '';
$token_bool = true;
if (actions::Count('users', array('reset_password_hash','=',$hash)) > 0) {
	if (DateInt($data->password_reset_life) < DateInt(date("Y-m-d"))) {
		$message = TOKEN_EXPIRED;
		$token_bool = false;
	}else{
		$user = new user($data->id);
	}
}else{
	$message = TOKEN_NOT_MATCHES;
	$token_bool = false;
}

if (input_get('token') == session_get('last_token')) {
	if (input_get('resetting') == 'resetting_'.$hash) {
		$new_password = input_get('n_pass');
		$confirm_new_password = input_get('c_pass');
		if ($new_password == $confirm_new_password) {
			$val_password = $validate->ValidatePassword($confirm_new_password);
			if (!empty($val_password)) {
				$message = "<div class='_Padd8 _RedText '".RTL_CLASS."' align='center'>".$val_password."</div>";
			}else{
				$salt = hash_salt(64);
				$db->change(
					'users', $user->data()->id,
					array(
						'password' => hash_make($confirm_new_password, $salt),
						'salt' => $salt,
						'password_reset_life' => date('Y-m-d',strtotime($data->password_reset_life . "-1 days"))
					)
				);
				if (!session_exists('user')) {
					redirect_to('/signin');
				}else{
					redirect_to('/'.$user->data()->username);
				}
			}
		}else{
			$message = "<div class='_Padd8 _RedText ".RTL_CLASS."' align='center'>".PASSWORD_NOT_MATCHES."</div>";
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
	<?=actions::IndexMeta()?>
</head>
<body>
<?php 

include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php";

if (!$token_bool) {
	echo '
	<div class="_Padd8">
	    <div class="_MarAutoLeftRight" style="max-width: 700px;">
	        <div class="bgadk-lines_">
	            <div class="_RedText" align="center" class="'.RTL_CLASS.'">'.$message.'</div>
	        </div>
	    </div>
	</div>';
}else{ ?>

<div class="_Padd8">
	<div class="_MarAutoLeftRight" style="max-width: 700px;">
		<form method="POST" class="bgadk-lines_">
			<h2 class="_FiveText"><?=RESET_Y_PASSWORD?></h2>
			<div class="_sett-border-bottom <?=RTL_CLASS?>"></div>
			<?=$message?>
			<div>
			    <div class="_FiveText _fontWeight"><?=NEW_PASSWORD?></div>
			    <input type="password" name="n_pass" class="_nput-text-seett">
			    <div class="_FiveText _fontWeight"><?=CONFIRM_PASSWORD?></div>
			    <input type="password" name="c_pass" class="_nput-text-seett">
			    <div align="center" class="_MARtop">
				    <input type="submit" name="save" value="<?=CHANGE_PASSWORD?>" class="save_changes_button">
				    <input type="hidden" name="resetting" value="resetting_<?=$hash?>">
	            </div>
	        </div>
	        <input type="hidden" name="token" value="<?=$token?>">
		</form>
	</div>
</div>

<?php
}

include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; 

?>
</body>
</html>