<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if(CheckUserReferer('https://programnas.com') && input_get('header') == session_get('csrf_token')){
	unlink(input_get('file'));
}else{
	redirect_to('/');
    exit();
    die();
}

?>