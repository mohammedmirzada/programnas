<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$db = db::getInstance();
$validate = new validate();
$user = new user();

if(input_get('token') == session_get('last_token')){
	if (session_exists('user')) {
		if (actions::Count('questions', array('user_id','=',$user->data()->id)) > 0) {
			if (cookies_exists('ur-last-que')) {
				$question_id = cookies_get('ur-last-que');
				$actions = new actions();
				$actions->GetData('questions',array('id','=',$question_id));
				$data = $actions->data();
				if ($data->updated == 1) {
					redirect_to("/signin");
		            die();
		            exit();
				}
			}else{
				redirect_to("/signin");
		        die();
		        exit();
			}
		}else{
			redirect_to("/signin");
		    die();
		    exit();
		}
	}else{
		redirect_to("/signin");
		die();
		exit();
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
include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/update_question.php"; 
include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php"; 

?>
</body>
</html>