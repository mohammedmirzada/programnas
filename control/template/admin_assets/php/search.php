<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

$db = db::getInstance();
$user = new user();
$actions = new actions();

if(CheckUserReferer('https://programnas.com') && input_get('header') == session_get('csrf_token') && session_exists('user') && !empty($user->data()->permission)){
    switch (input_get('t')) {
    	case 'questions':
    	$q = input_get("q");
		$data = '';
		if (ctype_digit(strval($q))) {
			if ($db->get('questions',array('id','=',$q))->count() > 0) {
				foreach ($db->get('questions',array('id','=',$q))->results() as $q) {
					$title = $q->title;
					$disabled = ($q->disabled == 1) ? 'background: #fff0f0;' : '' ;
					$data .= '<div style="'.$disabled.'">';
					$data .= '<a '.IsArabic($title).' href="/questions/?q='.$title.'" target="_blank" class="href-asj-smilary">'.$title.'</a>';
					$data .= '<a href="https://programnas.com/publicdashboard/questions?method=disable&id='.$q->id.'" class="_cursor" style="color:#bf2b2b;">Disable</a>';
					$data .= '</div>';
				}
			}
		}else{
			if ($db->get('questions',array('title','LIKE',"%$q%",'OR','content','LIKE',"%$q%"))->count() > 0) {
				foreach ($db->get('questions',array('title','LIKE',"%$q%",'OR','content','LIKE',"%$q%"))->results() as $q) {
					$title = $q->title;
					$disabled = ($q->disabled == 1) ? 'background: #fff0f0;' : '' ;
					$data .= '<div style="'.$disabled.'">';
					$data .= '<a '.IsArabic($title).' href="/questions/?q='.$title.'" target="_blank" class="href-asj-smilary">'.$title.'</a>';
					$data .= '<a href="https://programnas.com/publicdashboard/questions?method=disable&id='.$q->id.'" class="_cursor" style="color:#bf2b2b;">Disable</a>';
					$data .= '</div>';
				}
			}
		}
		echo json_encode(array('data' => $data),JSON_UNESCAPED_UNICODE);
    	break;
    	case 'answers':
    	$q = input_get("q");
		$data = '';
		if (ctype_digit(strval($q))) {
			if ($db->get('answers',array('id','=',$q,'OR','question_id','=',$q))->count() > 0) {
				foreach ($db->get('answers',array('id','=',$q,'OR','question_id','=',$q))->results() as $q) {
					$actions->GetData('questions', array('id','=',$q->question_id));
					$disabled = ($q->disabled == 1) ? 'background: #fff0f0;' : '' ;
					$data .= '<div style="'.$disabled.'">';
					$data .= '<a '.IsArabic($title).' href="/questions/?q='.$actions->data()->title.'" target="_blank" class="href-asj-smilary">View</a>';
					$data .= '<a href="https://programnas.com/publicdashboard/answers?method=disable&id='.$q->id.'" class="_cursor" style="color:#bf2b2b;">Disable</a>';
					$data .= '   <a href="https://programnas.com/publicdashboard/answers?method=check&id='.$q->id.'" class="_cursor" style="color:#6bc22c;">Check</a>';
					$data .= '</div>';
				}
			}
		}
		echo json_encode(array('data' => $data),JSON_UNESCAPED_UNICODE);
    	break;
    	case 'users':
    	$q = input_get("q");
		$data = '<table class="_table_tt">
		<tr>
			<th class="_th_table"><b>ID</b></th>
			<th class="_th_table"><b>username</b></th>
			<th class="_th_table"><b>Email Confirmed</b></th>
			<th class="_th_table"><b>Verfied</b></th>
			<th class="_th_table"><b>Suspended</b></th>
			<th class="_th_table"><b>Deactive</b></th>
			<th class="_th_table"><b>Support Code</b></th>
			<th class="_th_table"><b>Joined</b></th>
			<th class="_th_table"><b>Action</b></th>
		</tr>';
		if (ctype_digit(strval($q))) {
			if ($db->get('users',array('id','=',$q))->count() > 0) {
				foreach ($db->get('users',array('id','=',$q))->results() as $m) {
					$confirmed = ($m->confirmed == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';
					$verfied = ($m->verfied == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';
					$suspended = ($m->suspended == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';
					$deactive = ($m->deactive == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';

					$data .= '<tr style="'.$disabled.'" class="_tr_table">
						<td class="_td_table">'.$m->id.'</td>
						<td class="_td_table"><a target="_blank" href="https://programnas.com/'.$m->username.'" class="_cursor">'.$m->username.'</a></td>
						<td class="_td_table">'.$confirmed.'</td>
						<td class="_td_table">'.$verfied.'</td>
						<td class="_td_table">'.$suspended.'</td>
						<td class="_td_table">'.$deactive.'</td>
						<td class="_td_table">'.$m->support_code.'</td>
						<td class="_td_table">'.$m->joined.'</td>
						<td class="_td_table"><a href="https://programnas.com/publicdashboard/users?method=edit&id='.$m->id.'" class="_cursor">Edit</a></td>
					</tr>';
				}
			}
		}else{
			if ($db->get('users',array('username','LIKE',"%$q%",'OR','name','LIKE',"%$q%"))->count() > 0) {
				foreach ($db->get('users',array('username','LIKE',"%$q%",'OR','name','LIKE',"%$q%"))->results() as $m) {
					$confirmed = ($m->confirmed == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';
					$verfied = ($m->verfied == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';
					$suspended = ($m->suspended == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';
					$deactive = ($m->deactive == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';

					$data .= '<tr style="'.$disabled.'" class="_tr_table">
						<td class="_td_table">'.$m->id.'</td>
						<td class="_td_table"><a target="_blank" href="https://programnas.com/'.$m->username.'" class="_cursor">'.$m->username.'</a></td>
						<td class="_td_table">'.$confirmed.'</td>
						<td class="_td_table">'.$verfied.'</td>
						<td class="_td_table">'.$suspended.'</td>
						<td class="_td_table">'.$deactive.'</td>
						<td class="_td_table">'.$m->support_code.'</td>
						<td class="_td_table">'.$m->joined.'</td>
						<td class="_td_table"><a href="https://programnas.com/publicdashboard/users?method=edit&id='.$m->id.'" class="_cursor">Edit</a></td>
					</tr>';
				}
			}
		}
		$data .= '</table>';
		echo json_encode(array('data' => $data),JSON_UNESCAPED_UNICODE);
    	break;
    	case 'books':
    	$q = input_get("q");
    	$data = '';
    	foreach ($db->get('library_books', array('name','LIKE',"%$q%"))->results() as $m) {
    		$data .= '<div class="style_name_bb_se">'.$m->name.'</div>';
		}
		echo json_encode(array('data' => $data),JSON_UNESCAPED_UNICODE);
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

?>