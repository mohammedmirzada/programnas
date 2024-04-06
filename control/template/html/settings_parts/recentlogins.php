<?php

if(input_get("update") == "recentlogins" && input_get('token') == session_get('last_token')) {

	$session_id = input_get('session_id');
	$hash = input_get('hash');

	if ($db->delete("users_session",array('id','=',$session_id,'AND','user_id','=',$user->data()->id))) {
		if ($hash == cookies_get(config_get('remember/cookie_name'))) {
			$user->logout();
			redirect_to('/');
		}else{
			redirect_to('/settings?part=recentlogins');
		}
	}

}

$token = hash_make($_SERVER['SERVER_NAME'],uniqid(mt_rand(), true));
session_put('last_token',$token);

?>
<div class="_Padd8">
	<div style="height: 400px;" class="_Over_Y">
		<div>
		    <?php
		    $data = '';
		    foreach ($user->RecentLogins() as $u) {
			    $prespe = new prespe($u->user_ip);
			    if ($u->hash == cookies_get(config_get('remember/cookie_name'))) {
				    $data .= '
				    <form method="POST" class="_recentLoginDiv_">
				        <div>
				        '.$u->user_ip.' / <span class="_DarkBlueText">('.prespe::GetOS($u->user_agent).'</span>: <span class="_DarkBlueText">'.prespe::GetBrowser($u->user_agent).')</span>
				        </div>
				        <div><span class="_GreenText">'.CURRENTLY_ACTIVE.'</span></div>
				        <input type="submit" class="remove_session_butt" value="'.REMOVE_LOGOUT.'">
				        <input type="hidden" name="session_id" value="'.$u->id.'">
				        <input type="hidden" name="hash" value="'.$u->hash.'">
				        <input type="hidden" name="update" value="recentlogins">
				        <input type="hidden" name="token" value="'.$token.'">
				    </form>';
			    }else{
				    $data .= '
				    <form method="POST" class="_recentLoginDiv_">
				        <div>
				        '.$u->user_ip.' / <span class="_DarkBlueText">('.prespe::GetOS($u->user_agent).'</span>: <span class="_DarkBlueText">'.prespe::GetBrowser($u->user_agent).')</span>
				        </div>
				        <input type="submit" class="remove_session_butt" value="'.REMOVE_LOGOUT.'">
				        <input type="hidden" name="session_id" value="'.$u->id.'">
				        <input type="hidden" name="hash" value="'.$u->hash.'">
				        <input type="hidden" name="update" value="recentlogins">
				        <input type="hidden" name="token" value="'.$token.'">
				    </form>';
			    }
		    }
		    echo($data);
		    ?>
		</div>
	</div>
</div>