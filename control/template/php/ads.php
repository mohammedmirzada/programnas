<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

$db = db::getInstance();

if(input_get('header') == session_get('csrf_token')){
	foreach ($db->get('ads', array('ad_num','>',0))->results() as $a) {
	    $data["data"][] = array(
	    	'ad_num' => $a->ad_num,
	    	'image' => $a->image,
	    	'link' => $a->link
	    );
	}
	echo json_encode($data);
}else{
	redirect_to('/');
	exit();
    die();
}

?>