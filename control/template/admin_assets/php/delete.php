<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

$db = db::getInstance();
$user = new user();

if(CheckUserReferer('https://programnas.com') && input_get('header') == session_get('csrf_token') && session_exists('user')){
    if(!empty($user->data()->permission)){
        switch (input_get('deleting')) {
        	case 'profile':
        	$dirs = new dirs('/control/ppictures/');
        	$i = 0;
    	    foreach ($dirs->GetAllFiles('/control/ppictures/') as $file) {
    	    	if (actions::Count('users',array('image','=','https://programnas.com/control/ppictures/'.$file)) == 0) {
    	    		if ($file != 'index.php') {
                        $dirs->DeleteFile($file);
                        $i++;
                    }
    	    	}
    	    }
    	    echo json_encode(array(
    	    	'result' => $i.' Picture Deleted.'
    	    ));
        	break;
        	case 'question':
        	$dirs = new dirs('/control/qpictures/');
        	$i = 0;
        	$all_question_pictures = array();
        	foreach ($db->get('questions',array('id','>',0))->results() as $q) {
        		$images_ = array_filter(ConfigArray(explode("|", $q->image)));
        		foreach ($images_ as $t) {
        			array_push($all_question_pictures, $t);
        		}
        	}
        	foreach ($dirs->GetAllFiles('/control/qpictures/') as $file) {
        		if (!in_array($file, $all_question_pictures)) {
        			if ($file != 'index.php') {
                        $dirs->DeleteFile($file);
                        $i++;
                    }
        		}
        	}
        	echo json_encode(array(
    	    	'result' => $i.' Picture Deleted.'
    	    ));
        	break;
        	case 'answer':
        	$dirs = new dirs('/control/apictures/');
        	$i = 0;
        	$all_answer_pictures = array();
        	foreach ($db->get('answers',array('id','>',0))->results() as $a) {
        		$images_ = array_filter(ConfigArray(explode("|", $a->image)));
        		foreach ($images_ as $t) {
        			array_push($all_answer_pictures, $t);
        		}
        	}
        	foreach ($dirs->GetAllFiles('/control/apictures/') as $file) {
        		if (!in_array($file, $all_answer_pictures)) {
                    if ($file != 'index.php') {
        			    $dirs->DeleteFile($file);
        			    $i++;
                    }
        		}
        	}
        	echo json_encode(array(
    	    	'result' => $i.' Picture Deleted.'
    	    ));
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
}else{
	redirect_to('/');
	exit();
    die();
}

?>