<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<?php
	if (actions::Count('questions', array('id', '=', input_get("id"),'AND','disabled', '=', 0)) != 0) {
		echo actions::IndexMetaQuestion(input_get("id"));
	}else{
		echo actions::IndexMeta('Questions');
	}
	?>
</head>
<body>
<?php 
include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php";

$title = input_get("q");

if (empty($title)) {
	include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/questions.php"; 
}else{
	if (actions::Count('questions', array('title', '=', $title)) == 0) {
		http_response_code(404);
		include $_SERVER['DOCUMENT_ROOT'].'/404.php';
		die();
		exit();
    }
	else{
		$actions = new actions();
		$actions->GetData('questions', array('title','=',$title));
		$questions = new questions($actions->data()->id);
		$user = new user($actions->data()->user_id);
		$you = new user();
		if ($questions->isDisabled()) {
			http_response_code(404);
			include $_SERVER['DOCUMENT_ROOT'].'/404.php';
			die();
			exit();
		}else{
			include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/question_view.php"; 
		}
	}
}

include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer.php"; 
?>
</body>
</html>