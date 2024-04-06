<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

$db = db::getInstance();
$user = new user();
$validate = new validate();
$actions = new actions();

if(CheckUserReferer('https://programnas.com') && input_get('header') == session_get('csrf_token') && session_exists('user')){
	$error = '';
	$status = false;

	$title = input_get('title');
	$content = input_get('content');
	$images = input_get('images');
	$num_boxes = input_get('num_boxes');
	$box_1 = input_get('box_1');
	$box_2 = input_get('box_2');
	$box_3 = input_get('box_3');
	$lang_1 = input_get('language_1');
	$lang_2 = input_get('language_2');
	$lang_3 = input_get('language_3');

	$title_val = $validate->ValidateQuestionTitle($title);
	$content_val = $validate->ValidateQuestionContent($content);

	if (!empty($title_val)){
		$error = $title_val;
	}elseif (!empty($content_val)) {
		$error = $content_val;
	}else{
		$tags = '';
		$tags_ = array_map('intval', array_filter(ConfigArray(explode("|", input_get('tags')))));
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
				if ($validate->CanAsk()) {
				    $db->insert('questions',array(
					    'user_id' => $user->data()->id,
					    'title' => $title,
					    'content' => $content,
					    'tags' => $tags,
					    'box_ids' => $Box_,
					    'image' => $images,
					    'date' => date('Y-m-d')
				    ));
			    }else{
			    	$error = CANT_ASK;
			    }
			}else{
				$error = WENT_WRONG_CB;
			}
		}else{
			$error = WENT_WRONG_QT;
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