<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();

if (session_exists('user')) {
	if (!$user->iaAuth()) {
		redirect_to('/');   
	}
}else{
	redirect_to('/');  
}

$error = '';

if (input_get('token') == session_get('last_token')) {
	if (input_get('submit') == "auth") {
		$validate = new validate();
		if ($validate->isValidAuthCode(input_get('code'),$user->data()->two_factor_auth_salt)) {
			cookies_put(config_get('cookies/auth'), input_get('code'), config_get('remember/cookie_expiry'));
		 	redirect_to('/');
		}else{
			$error = 'Authentication code is wrong.';
		}
	}elseif (input_get('submit') == "logout") {
		$user->logout();
		redirect_to('/');
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
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php"; ?>

<div class="_Padd8">
	<div class="_MarAutoLeftRight" style="max-width: 700px;">
		<form method="POST" class="bgadk-lines_">
			<h2 class="_FiveText"><?=TWO_FACTOR?></h2>
			<div class="_sett-border-bottom"></div>
			<div align="center" class="_Padd8"><?=$error?></div>
			<div>
			    <div class="_FiveText _fontWeight"><?=CODE__?></div>
			    <input type="text" name="code" class="_nput-text-seett">
			    <div align="center" class="_MARtop">
				    <input type="submit" value="<?=AUTH?>" class="save_changes_button">
	            </div>
	            <div align="center" class="_MARtop">
	            	<a href="/authenticate?token=<?=$token?>&submit=logout"><?=LOGOUT?></a>
	            </div>
	        </div>
	        <input type="hidden" name="token" value="<?=$token?>">
	        <input type="hidden" name="submit" value="auth">
		</form>
	</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; ?>
</body>
</html>