<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

$db = db::getInstance();
$library = new library();
$actions = new actions();

if(input_get('header') == session_get('csrf_token')){
    switch (input_get('library')) {
	    case 'download_book':
	    	$book_id = input_get('book_id');
	    	if (is_numeric($book_id)) {
	    		if (actions::Count('library_books', array('id','=',$book_id)) > 0) {
	    			$library->InsertDownloads($book_id);
	    		}else{
	    			redirect_to('/');
	    		}
	    	}else{
	    		redirect_to('/');
	    	}
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