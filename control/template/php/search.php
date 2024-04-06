<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

$db = db::getInstance();
$user = new user();
$validate = new validate();
$questions = new questions();

if(input_get('header') == session_get('csrf_token')){

	if (input_get("part") != "similary") {
		$q = str_replace('how to ', '', str_replace('', 'چۆن ', input_get("q")));

		$data = '<div align="left" class="_FiveText _fontWeight">'.QUESTIONS.'</div><div style="border-bottom: 1px solid #ddd;" class=""></div>';

		if ($db->get('questions',array('title','LIKE',"%$q%",'OR','content','LIKE',"%$q%"))->count() == 0) {
			$data .= '<div class="_MARtop">'.NO_Q_FOUND.'</div>';
		}else{
			foreach ($db->get('questions',array('title','LIKE',"%$q%",'OR','content','LIKE',"%$q%"))->results() as $m) {
				if($m->disabled == 0){
					$data .= '<a '.IsArabic($m->title).' href="/questions/?q='.$m->title.'" class="href-que-list _Padd8">'.$m->title.'</a><div style="border-bottom: 1px solid #ddd;" class=""></div>';
				}
			}
		}
		echo json_encode(array('data' => $data),JSON_UNESCAPED_UNICODE);
	}else{
		$q = input_get("q");
		$data = '';
		if ($db->get('questions',array('title','LIKE',"%$q%",'OR','content','LIKE',"%$q%"))->count() > 0) {
			foreach ($db->get('questions',array('title','LIKE',"%$q%",'OR','content','LIKE',"%$q%"))->results() as $m) {
				if($m->disabled == 0){
					$title = $m->title;
					$data .= '<a '.IsArabic($title).' href="/questions/?q='.$title.'" target="_blank" class="href-asj-smilary">'.$title.'</a>';
				}
			}
		}
		echo json_encode(array('data' => $data),JSON_UNESCAPED_UNICODE);
	}

}else{
	redirect_to('/');
	exit();
    die();
}

?>