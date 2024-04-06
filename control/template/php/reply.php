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

if(input_get('header') == session_get('csrf_token') && session_exists('user')){
	$error = '';
	$status = false;
	$data = '';

	$text = input_get('text');
	$answer_id = input_get('answer_id');

	if (!$validate->CanReply()) {
		$error = CANT_REPLY;
	}else{
		if (actions::Count('answers',array('question_id','=',cookies_get('last-q-id'),'AND','id','=',$answer_id)) > 0) {
			$db->insert('replies',
				array(
					'user_id' => $user->data()->id,
					'question_id' => cookies_get('last-q-id'),
					'answer_id' => $answer_id,
					'content' => $text,
					'date' => date("Y-m-d")
				)
			);
			$status = true;
			$actions = new actions();
			$actions->GetData('answers',array('id','=',$answer_id));
			$data .= $questions->GetTheReply($db->return_mysql_insert_id(),$answer_id,'background: #f0d13a47;');
			$questions = new questions(cookies_get('last-q-id'));
			if ($actions->data()->user_id != $user->data()->id) {
				$db->insert('notifications',
					array(
						'user_id' => $actions->data()->user_id,
						'object_number' => N_REPLIED,
						'answer_id' => $answer_id,
						'reply_id' => $db->return_mysql_insert_id(),
						'question_id' => cookies_get('last-q-id'),
						'op_user_id' => $user->data()->id
					)
				);
			}
		}else{
			$error = 'ERROR';
		}
	}
	$array = array('error' => $error, 'status' => $status, 'data' => $data, 'answer_id' => $answer_id);
	echo json_encode($array,JSON_UNESCAPED_UNICODE);
}else{
	redirect_to('/');
	exit();
	die();
}

?>