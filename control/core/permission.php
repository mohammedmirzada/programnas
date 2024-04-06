<?php
if (session_exists(config_get('sessions/session_name'))) {
	$user = new user();
	$permission = $user->data()->permission;
	if (!empty($permission)) {
		if ($permission != "super") {
			if (FindUrl("transactions")) {
				if ($permission != 'transactions') {
                    http_response_code(403);
                    exit();
				}
			}elseif (FindUrl("reports")) {
				if ($permission != 'reports') {
                    http_response_code(403);
                    exit();
				}
			}elseif (FindUrl("library")) {
				if ($permission != 'library') {
                    http_response_code(403);
                    exit();
				}
			}elseif (FindUrl("answers") || FindUrl("points") || FindUrl("questions") || FindUrl("requests") || FindUrl("transactions") || FindUrl("users") || FindUrl("referrals") || FindUrl("reports") || FindUrl("library")) {
				if ($permission != 'review') {
                    http_response_code(403);
                    exit();
				}
			}elseif (FindUrl("admins")) {
				http_response_code(403);
                exit();
			}
		}
	}else{
		http_response_code(403);
        exit();
	}
}else{
    http_response_code(403);
    exit();
}
?>