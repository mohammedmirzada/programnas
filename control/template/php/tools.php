<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

$db = db::getInstance();

if(input_get('header') == session_get('csrf_token') && session_exists('user')){
    switch (input_get('tool')) {
	    case 'search_cat':
	    $q = input_get('q');
	    $data = '';
	    $do = $db->get('category_tags',array('name','LIKE',"%$q%"));
	    if ($do->count() > 0) {
		    foreach ($do ->results() as $d) {
			    $data .= '<span onclick="AddTag(\'tag_'.$d->id.'\',\''.$d->name.'\')" class="_span_tags" id="tag_'.$d->id.'">'.$d->name.'</span>';
			    $json[] = array('id' => $d->id, 'name' => $d->name);
		    }
		    $array = array(
			    'data' => $data,
			    'json' => $json
		    );
		    echo json_encode($array,JSON_UNESCAPED_UNICODE);
	    }else{
		    echo "";
	    }
	    break;
	    case 'tags_found':
	    $q = input_get('q');
	    $do = $db->get('category_tags',array('name','LIKE',"%$q%"));
	    if ($do->count() > 0) {
	    	$data = '';
		    foreach ($do ->results() as $d) {
			    $data .= '<span id="tags_'.$d->id.'" class="_span_tags-que _cursor _span_tags-que-hover" onclick="SelectTag(this)">'.$d->name.'</span>';
		    }
		    $array = array(
		    	'success' => true,
			    'data' => $data
		    );
		    echo json_encode($array,JSON_UNESCAPED_UNICODE);
	    }else{
		    $array = array(
		    	'success' => false
		    );
		    echo json_encode($array,JSON_UNESCAPED_UNICODE);
	    }
	    break;
	    case 'delete_reply':
	    $reply_id = input_get('reply_id');
	    $question_id = cookies_get('last-q-id');
	    if (actions::Count('replies',array('question_id','=',$question_id,'AND','id','=',$reply_id)) > 0) {
	    	$db->delete('replies',array('id','=',$reply_id));
	    	$db->delete('notifications', array('reply_id','=',$reply_id));
	    	echo json_encode(array('status' => true));
	    }else{
	    	redirect_to('/');
	    	exit();
	    	die();
	    }
	    break;
	    case 'report_reply':
	    $reply_id = input_get('reply_id');
	    $user = new user();
	    if (actions::Count('reported_replies',array('reply_id','=',$reply_id,'AND','user_id','=',$user->data()->id)) == 0) {
	    	$db->insert('reported_replies',array('reply_id' => $reply_id, 'user_id' => $user->data()->id, 'date' => date("Y-m-d")));
	    }else{
	    	redirect_to('/');
	    	exit();
	    	die();
	    }
	    break;
	    case 'report_answer':
	    $answer_id = input_get('answer_id');
	    $user = new user();
	    if (actions::Count('reported_answers',array('answer_id','=',$answer_id,'AND','user_id','=',$user->data()->id)) == 0) {
	    	$db->insert('reported_answers',array('answer_id' => $answer_id, 'user_id' => $user->data()->id, 'date' => date("Y-m-d")));
	    }else{
	    	redirect_to('/');
	    	exit();
	    	die();
	    }
	    break;
	    case 'checking_answer':
	    $answer_id = input_get('answer_id');
	    $question_id = input_get('question_id');
	    $question_id_session = cookies_get('last-q-id');
	    if ($question_id == $question_id_session) {
	    	if (actions::Count('users_points',array('answer_id','=',$answer_id,'AND','question_id','=',$question_id)) == 0) {

	    		if (actions::Count('questions',array('id','=',$question_id,'AND','checked','=',1)) == 0) {
	    			$actions = new actions();
	    			$actions->GetData('answers', array('id','=',$answer_id));

	    			//NOTE: If Programnas Team verify this answer user_agent is just: pn
	    			$db->insert(
	    				'users_points',
	    				array(
	    					'answer_id' => $answer_id,
	    					'question_id' => $question_id,
	    					'user_id' => $actions->data()->user_id,
	    					'user_agent' => $_SERVER['HTTP_USER_AGENT'],
	    					'user_ip' => prespe::GetUserIP(),
	    				)
	    			);

	    			$db->change('answers', $answer_id, array('verified' => 1));

	    			$db->change('questions', $question_id, array('checked' => 1));

	    			$qu_r = new questions($question_id);
	    			$s_u = new user($actions->data()->user_id);
	    			$mail = new email($s_u->data()->email);
	    			$uuu = new user();
	    			$mail->CheckedAnswer($uuu->data()->name, $qu_r->data()->title);
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
	    break;
	    case 'ads':
	    foreach ($db->get('ads', array('id','>',0))->results() as $a) {
	    	$data["data"][] = array(
	    		'ad_num' => $a->ad_num,
	    		'image' => $a->image,
	    		'link' => $a->link
	    	);
	    }
	    echo json_encode($data);
	    break;
	    case 'id_put_':
	    $question_id = input_get('question_id');
	    if (!empty($question_id)) {
			cookies_put('last-q-id',$question_id,config_get('remember/cookie_expiry'));
	    }else{
	    	redirect_to('/');
	    	exit();
	    	die();
	    }
	    break;
	    case 'verify_request':
	    $error = '';
	    $status = false;
	    $user = new user();
	    $image = input_get('image');
	    if ($user->isConfirmed()) {
	    	if (actions::Count('verify_requests',array('user_id','=',$user->data()->id)) == 0) {
	    		if (strpos($image, 'https://programnas.com/control/dpictures/') !== false) {
	    			$db->insert(
	    				'verify_requests',
	    				array(
	    					'user_id' => $user->data()->id,
	    					'document' => $image
	    				)
	    			);
	    			$status = true;
	    		}else{
	    			$error = SOMETHING_WRONG;
	    		}
	    	}else{
	    		$error = SOMETHING_WRONG;
	    	}
	    }else{
	    	$error = Y_HAVETO_C_EMAIL;
	    }
	    echo json_encode(array(
	    	'status' => $status,
	    	'error' => $error
	    ),JSON_UNESCAPED_UNICODE);
	    break;
	    case 'send_confirm_code':
	    $user = new user();
	    if (!$user->isConfirmed()) {

	    	$confirm_hash = hash_make($user->data()->email, hash_salt(64));
			$confirm_code = RAND(111111,999999);

	    	$changing = $db->change('users', $user->data()->id, array(
	    		'confirm_hash' => $confirm_hash,
	    		'confirm_code' => $confirm_code
	    	));

	    	if ($changing) {
	    		$mail = new email($user->data()->email);
	    		$mail->ConfirmEmail($user->data()->name,$confirm_hash,$confirm_code);
	    	}
	    }
	    break;
	    case 'enter_confirm_code':
	    $error = '';
	    $status = false;

	    $user = new user();
	    if (!$user->isConfirmed()) {
	    	if ($user->data()->confirm_code == input_get('code')) {
	    		$db->change('users', $user->data()->id, array('confirmed' => 1));
	    		if(actions::Count('subscribed_emails', array('email','=',$user->data()->email)) == 0){
	    			$db->insert('subscribed_emails', array('email' => $user->data()->email, 'hash' => hash_make($user->data()->email,uniqid(mt_rand(), true))));
	    		}
	    		$status = true;
	    	}else{
	    		$error = WRONG_CODE_CO;
	    	}
	    }else{
	    	$error = SOMETHING_WRONG;
	    }

	    echo json_encode(array(
	    	'status' => $status,
	    	'error' => $error
	    ),JSON_UNESCAPED_UNICODE);
	    break;
	    case 'delete_answer':
	    $answer_id = input_get('answer_id');
	    $question_id = input_get('question_id');
	    $question_id_session = cookies_get('last-q-id');
	    $user = new user();
	    if ($question_id == $question_id_session) {
	    	if (actions::Count('answers',array('id','=',$answer_id,'AND','question_id','=',$question_id)) > 0) {
	    		$db->delete('answers',array('id','=',$answer_id,'AND','question_id','=',$question_id));
	    		$db->delete('replies',array('answer_id','=',$answer_id,'AND','question_id','=',$question_id));
	    		$db->delete('reported_answers',array('answer_id','=',$answer_id));
	    		$db->delete('notifications',array('answer_id','=',$answer_id,'AND','op_user_id','=',$user->data()->id));
	    		$db->delete('users_points',array('answer_id','=',$answer_id));
	    		if (actions::Count('answers', array('question_id','=',$question_id)) == 0) {
	    			$db->change('questions', $question_id, array('has_answer' => 0));
	    		}
	    	}
	    }
	    break;
	    case 'get_notifications':
	    $notifications = new notifications();
	    echo json_encode(array(
	    	'data' => $notifications->GetNotifications(),
	    ),JSON_UNESCAPED_UNICODE);
	    break;
	    case 'get_auth_code':
	    $user = new user();
	    if (!$user->iaAuth()) {
	    	//strtoupper
	    	$g = new \Google\Authenticator\GoogleAuthenticator();
	    	$salt = $g->generateSecret();
	    	$data = '
	    	<div>
	    		<img class="border-r-getnc" src="'.$g->getURL($user->data()->username, "", $salt, 'Programnas').'">
	    	</div>
	    	<div>
	    	<input type="text" disabled value="'.$salt.'" class="gen_code_auth">
	    	<div>
	    		<input type="text" id="_code_auth_" placeholder="'.ENTER_CODE.'" class="gen_code_auth">
	    		<button class="veri_code_auth" onclick="VerifyAuthCode(\''.$salt.'\')">'.VERIFY__.'</button>
	    	</div>
	    	<div align="center">'.actions::ProgressBar('pb_load_code_auth',true).'</div>
	    	</div>
			';
			$db->change('users', $user->data()->id, array('two_factor_auth_salt' => $salt));
	    	echo json_encode(array(
	    		'data' => $data,
	    	),JSON_UNESCAPED_UNICODE);
	    }
	    break;
	    case 'verify_auth_code':
	    $validate = new validate();
	    $user = new user();
	    if ($validate->isValidAuthCode(input_get('code'), input_get('salt'))) {
	    	$error = '';
	    	$db->change('users', $user->data()->id, array('two_factor_auth' => 1, 'two_factor_auth_salt' => input_get('salt')));
	    }else{
	    	$error = YOU_VE_ENTERED;
	    }
	    echo json_encode(array(
	    	'error' => $error,
	    ),JSON_UNESCAPED_UNICODE);
	    break;
	    case 'disable_auth':
	    $user = new user();
	    if ($user->iaAuth()) {
	    	$db->change('users', $user->data()->id, array('two_factor_auth' => 0, 'two_factor_auth_salt' => ''));
	    }
	    break;
	    case 'voting':
	    $answer_id = input_get('answer_id');
	    $question_id = input_get('question_id');
	    $question_id_session = cookies_get('last-q-id');
	    $user = new user();
	    if ($question_id_session == $question_id) {
	    	if (actions::Count('user_votes', array('answer_id','=',$answer_id,'AND','user_id','=',$user->data()->id)) == 0) {
			    $db->insert(
			    	'user_votes',
			    	array(
			    		'user_id' => $user->data()->id,
			    		'question_id' => $question_id,
			    		'answer_id' => $answer_id,
			    		'user_ip' => prespe::GetUserIP(),
			    		'user_agent' => $_SERVER['HTTP_USER_AGENT']
			    	)
			    );
			}else{
				$db->delete('user_votes', array('answer_id','=',$answer_id,'AND','user_id','=',$user->data()->id));
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