<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

$db = db::getInstance();
$user = new user();

if(CheckUserReferer('https://programnas.com') && input_get('header') == session_get('csrf_token') && session_exists('user')){
    if(!empty($user->data()->permission)){
        switch (input_get('send')) {
        	case 'unanswered':
        	foreach ($db->get('users', array('confirmed','=',1))->results() as $u) {
				if ($u->notify_new_question == 1) {
					$email = new email($u->email);
					$email->UnansweredQuestions($u->id, $u->name);
				}
			}
			echo json_encode(array('s' => 'done'));
        	break;
        	default:
        	redirect_to('/');
        	exit();
        	die();
        	break;
        }
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

?>