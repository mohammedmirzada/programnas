<?php

ini_set('memory_limit', '-1');
define('WP_CACHE', true);
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
session_start();

$GLOBALS['config'] = array(
    'web' => array(
        'version' => '1.7.2'
    ),
    'mysql' => array(
        'host' => 'localhost',
        'username' => 'pn_user',
        'password' => 'pXyfKdZtEAX5ZCG',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'db' => 'pn_db'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 6048000000
    ),
    'sessions' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    ),
    'cookies' => array(
        'guides' => 'cookies_guides',
        'warning' => 'cookies_warning',
        'auth' => 'auth'
    ),
    'recaptcha' => array(
        'site_key' => '6LcdIYMaAAAAAJSezLMV29EENxstTYhUgh6moPLF',
        'secret_key' => '6LcdIYMaAAAAACkyJ5fgOcQaUndd6ghiRsT7_myR'
    ),
    'mail_server' => array(
        'incoming_server' => 'smtp.gmail.com',
        'outgoing_server' => 'smtp.gmail.com',
        'smtp_port' => 587,
    ),
    'email' => array(
        'username' => 'support@programnas.com',
        'password' => 'Xiem)tmQ[xjd'
    )
);

require_once $_SERVER['DOCUMENT_ROOT'].'/control/APIs/SwiftMailer/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/control/APIs/GoogleAuthenticator/vendor/autoload.php';
spl_autoload_register(function($class) {
    require_once $_SERVER['DOCUMENT_ROOT']."/control/classes/". $class . ".php";
});
require_once "functions.php";

//REDIRECT WWW TO HTTPS
if (substr(GetCurrentURL(), 8, 4) == "www." || substr(GetCurrentURL(), 7, 4) == "www.") {
    header("Location: https://programnas.com/");
}

if(cookies_exists(config_get('remember/cookie_name')) && !cookies_exists(config_get('sessions/session_name'))) {
   $hash = cookies_get(config_get('remember/cookie_name'));
   $hashCheck = db::getInstance()->get('users_session', array('hash', '=', $hash));
    if($hashCheck->count()) {
        $user = new user($hashCheck->first()->user_id);
        $user->login();
    }else{
        session_delete(config_get('sessions/session_name'));
    	cookies_delete(config_get('remember/cookie_name'));
        cookies_delete(config_get('cookies/auth'));
    }
}

if (!cookies_exists('lang')) {
    include $_SERVER["DOCUMENT_ROOT"].'/control/lang/en.php';
}else{
    include $_SERVER["DOCUMENT_ROOT"].'/control/lang/'.cookies_get("lang").'.php';
}

CSRF_TOKEN();
ob_start();

//BANNER SIZES
define('WEB_BANNER', '385x750');
define('MOB_BANNER', '750x150');

//NOTIFICATION OBJECTS
define('N_ASNWERED', 1);//Some one Answered your question.
define('N_REPLIED', 2);//Some one replied your answer.

//TRANSACTIONS
define('T_PENDING', 1);
define('T_PROCESSED', 2);
define('T_CANCELED', 3);


//AUTHENTICAT
if (session_exists('user')) {
    $user = new user();
    if ($user->iaAuth()) {
        if (!FindUrl('/authenticate')) {
            if (!cookies_exists(config_get('cookies/auth'))) {
                redirect_to('/authenticate');
            }
        }
    }
}

//REFERRAL
$ref = input_get('ref');
$dbb = db::getInstance();
if (!empty($ref)) {
    if (actions::Count('referral', array('user_ip','=',prespe::GetUserIP(),'AND','referral','=',$ref)) == 0) {
        switch ($ref) {
            case 'kf':
            $dbb->insert('referral', array('referral' => 'KurdFilm', 'user_ip' => prespe::GetUserIP(), 'user_agent' => $_SERVER['HTTP_USER_AGENT'], 'date' => date("Y-m-d")));
            break;
            case 'yt':
            $dbb->insert('referral', array('referral' => 'Youtube', 'user_ip' => prespe::GetUserIP(), 'user_agent' => $_SERVER['HTTP_USER_AGENT'], 'date' => date("Y-m-d")));
            break;
        }
    }
}

?>