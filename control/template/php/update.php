<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

$db = db::getInstance();
$user = new user();
$validate = new validate();

if(input_get('header') == session_get('csrf_token') && session_exists('user')){
    switch (input_get('update')) {
	    case 'question':
	    $error = '';
	    $status = false;

	    $content = input_get('content');
	    $content_val = $validate->ValidateQuestionContent($content);

	    if (!empty($content_val)) {
	    	$error = $content_val;
	    }else{
	    	$db->change('questions',cookies_get('ur-last-que'),array(
	    		'updated' => 1,
	    		'updated_content' => $content
	    	));
	    	$status = true;
	    }
	    $array = array('error' => $error, 'status' => $status);
	    echo json_encode($array,JSON_UNESCAPED_UNICODE);
	    break;
	    case 'answer':
	    $error = '';
	    $status = false;

	    $content = input_get('content');
	    $answer_id = input_get('answer_id');
	    $question_id = input_get('question_id');
	    $question_id_session = cookies_get('last-q-id');

	    $content_val = $validate->ValidateQuestionContent($content);

	    if (!empty($content_val)) {
	    	$error = $content_val;
	    }else{
	    	if ($question_id_session == $question_id) {
	    		if (actions::Count('answers',array('id','=',$answer_id,'AND','question_id','=',$question_id)) > 0) {
	    			$db->change('answers',$answer_id,array(
	    				'updated' => 1,
	    				'updated_content' => $content
	    			));
	    			$status = true;
	    		}
	    	}
	    }
	    $array = array('error' => $error, 'status' => $status);
	    echo json_encode($array,JSON_UNESCAPED_UNICODE);
	    break;
	    default:
	    redirect_to('/');
	    break;
	}
}else{
	redirect_to('/');
	exit();
    die();
}

?>