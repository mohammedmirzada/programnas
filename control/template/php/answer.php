<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');
//ini_set('display_errors', 'OFF');

$db = db::getInstance();
$user = new user();
$validate = new validate();
$actions = new actions();

if(input_get('header') == session_get('csrf_token') && session_exists('user')){
	$error = '';
	$status = false;

	$content = input_get('content');
	$images = input_get('images');
	$num_boxes = input_get('num_boxes');
	$box_1 = input_get('box_1');
	$box_2 = input_get('box_2');
	$box_3 = input_get('box_3');
	$lang_1 = input_get('language_1');
	$lang_2 = input_get('language_2');
	$lang_3 = input_get('language_3');

	$content_val = $validate->ValidateQuestionContent($content);

	if (!empty($content_val)) {
		$error = $content_val;
	}else{
		if ($num_boxes <= 3) {
			$iBox = 0;
			$Box_ = '';
			$status = true;
			for ($x = 0; $x <= $num_boxes-1; $x++) {
				if ($x == 0) {
					$db->insert('code_boxes',array('code' => $box_1, 'lang' => $lang_1));
				}elseif ($x == 1) {
					$db->insert('code_boxes',array('code' => $box_2, 'lang' => $lang_2));
				}elseif ($x == 2) {
					$db->insert('code_boxes',array('code' => $box_3, 'lang' => $lang_3));
				}
				if(++$iBox === $num_boxes) {
					$Box_ .= $db->return_mysql_insert_id();
				}else{
					$Box_ .= $db->return_mysql_insert_id().',';
				}
			}
			if ($validate->CanAnswer()) {
				$db->insert('answers',
					array(
						'user_id' => $user->data()->id,
					    'question_id' => cookies_get('last-q-id'),
					    'content' => $content,
					    'box_ids' => $Box_,
					    'image' => $images,
					    'date' => date("Y-m-d")
				    )
				);
				$questions = new questions(cookies_get('last-q-id'));
				$db->insert('notifications',
					array(
						'user_id' => $questions->data()->user_id,
					    'object_number' => N_ASNWERED,
					    'answer_id' => $db->return_mysql_insert_id(),
					    'question_id' => cookies_get('last-q-id'),
					    'op_user_id' => $user->data()->id
				    )
				);
				$db->change('questions',cookies_get('last-q-id'),array('has_answer' => 1));

				$actions->GetData('questions', array('id','=',cookies_get('last-q-id')));
				$uuu = new user($actions->data()->user_id);
				if ($uuu->isConfirmed() && $uuu->isNotifyNewAnswer()) {
					$email = new email($uuu->data()->email);
					$email->AnsweredQuestion($actions->data()->title, cookies_get('last-q-id'));
				}
			}else{
				$error = CANT_ANSWER;
			}
		}else{
			$error = WENT_WRONG_CB;
		}
	}
	$array = array('error' => $error, 'status' => $status);
	echo json_encode($array,JSON_UNESCAPED_UNICODE);
}else{
	redirect_to('/');
	exit();
	die();
}

?>