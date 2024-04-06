<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');
//ini_set('display_errors', 'OFF');

$db = db::getInstance();
$user = new user();
$validate = new validate();
$questions = new questions();

if(input_get('header') == session_get('csrf_token')){
	$get = input_get("get");
	if ($get == "all") {
		$array = array('data' => $questions->GetQuestions());
	}elseif ($get == "unanswered") {
		$array = array('data' => $questions->GetQuestions(array('disabled','=',0,'AND','has_answer','=',0)));
	}elseif ($get == "tags") {
		$tags = '';
		$tags_ = array_map('intval', array_filter(ConfigArray(explode("|", input_get('t')))));
		$numItems = count($tags_);
		$i = 0;
		if (array_filter($tags_,'is_numeric')) {
			foreach ($tags_ as $tag) {
				if(++$i === $numItems) {
					$tags .= $tag;
				}else{
					$tags .= $tag.',';
				}
			}
			$array = array('data' => $questions->GetQuestions(array('disabled','=',0,'AND','tags','LIKE',"%$tags%")), 'tags' => $tags);
		}else{
			redirect_to('/');
	        exit();
            die();
		}
	}else{
		redirect_to('/');
	    exit();
        die();
	}
	echo json_encode($array,JSON_UNESCAPED_UNICODE);
}else{
	redirect_to('/');
	exit();
    die();
}

?>