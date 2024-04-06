<?php

function SendMail($from,$to,$subject,$message){
    $headers = 'From: '. $from . "\r\n" .
    'Reply-To: '. $from . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    return mail($to, $subject, $message, $headers);
}

function IsMicrosoftEmail($str){
    return (substr($str, -12) == "@hotmail.com" || substr($str, -12) == "@outlook.com") ? true : false ;
}

function GetURLData($url,$data){
    $parts = parse_url($url);
    parse_str($parts['query'], $query);
    return $query[$data];
}

function KurdishToLatin($str=""){
    $str1 = str_replace('ق', 'q', $str);$str2 = str_replace('و', 'w', $str1);$str3 = str_replace('ە', 'a', $str2);$str4 = str_replace('ێ', 'e', $str3);$str5 = str_replace('ر', 'r', $str4);$str6 = str_replace('ڕ', 'r', $str5);$str7 = str_replace('ت', 't', $str6);$str8 = str_replace('ی', 'y', $str7);$str10 = str_replace('وو', 'u', $str8);$str11 = str_replace('ى', 'i', $str10);$str12 = str_replace('ۆ', 'o', $str11);$str13 = str_replace('پ', 'p', $str12);$str14 = str_replace('ا', 'a', $str13);$str15 = str_replace('ئ', 'a', $str14);$str16 = str_replace('س', 's', $str15);$str17 = str_replace('ش', 'sh', $str16);$str18 = str_replace('د', 'd', $str17);$str19 = str_replace('ف', 'f', $str18);$str20 = str_replace('گ', 'g', $str19);$str21 = str_replace('ه', 'a', $str20);$str22 = str_replace('ح', 'h', $str21);$str23 = str_replace('ژ', 'zh', $str22);$str24 = str_replace('ک', 'k', $str23);$str25 = str_replace('ل', 'l', $str24);$str26 = str_replace('ڵ', 'l', $str25);$str27 = str_replace('ز', 'z', $str26);$str28 = str_replace('خ', 'x', $str27);$str29 = str_replace('غ', 'gh', $str28);$str30 = str_replace('چ', 'ch', $str29);$str31 = str_replace('ج', 'j', $str30);$str32 = str_replace('ڤ', 'v', $str31);$str33 = str_replace('ب', 'b', $str32);$str34 = str_replace('ن', 'n', $str33);$str35 = str_replace('م', 'm', $str34);$str36 = str_replace('ي', 'y', $str35);$str37 = str_replace('ك', 'k', $str36);$str38 = str_replace('؟', '?', $str37);
    return ucfirst($str38);
}

function Is404($url){
    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
        return true;
    }else{
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        return ($httpCode != 200) ? true : false ;
    }
}

function DateInt($str){
    $step = str_replace('-', '', $str);
    $step_two = str_replace(' ', '', $step);
    return str_replace(':', '', $step_two);
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => YEAR___,
        'm' => MONTH___,
        'w' => WEEK___,
        'd' => DAY___,
        'h' => HOUR___,
        'i' => MINUTE___,
        's' => SECOND___,
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v;
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' '.AGO_TIME : JUST_NOW;
}

function IsArabic($text){
    $retVal = (preg_match("/[א-ת]/", $text)) ? 'ar' : 'en';
    return 'lang="'.$retVal.'"';
}

function Captcha($user_response) {
    $fields_string = '';
    $fields = array(
        'secret' => config_get('recaptcha/secret_key'),
        'response' => $user_response
    );
    foreach($fields as $key=>$value)
    $fields_string .= $key . '=' . $value . '&';
    $fields_string = rtrim($fields_string, '&');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

function CheckCaptcha($res){
    if (!$res['success']) {
        return false;
    } else {
        return true;
    }
}

function SecureEcho($str){
    return AntiXSS::setEncoding(strip_tags(
        filter_var(htmlspecialchars(
            $str, ENT_QUOTES, 'UTF-8'
        ), FILTER_SANITIZE_STRING)
    ), 'UTF-8');
}

function GetUrlFromIFRAME($iframe){
    preg_match('/src="([^"]+)"/', $iframe, $export);
    return $export[1];
}

function CatchWebView($package){
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] == $package) {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function ConfigDefine($word){
    return constant(str_replace(array(' ','-'), '_', strtolower($word)));
}

function GetLangString(){
    if (cookies_exists('lang')) {
        return cookies_get("language");
    }else{
        return 'en';
    }
}

function GetLang(){
    if (cookies_exists('lang')) {
        include $_SERVER["DOCUMENT_ROOT"].'/control/languages/'.cookies_get("language").'.php';
    }else{
        // PUT COOKIES BY LOCATION
    }
}

function FullResponseURL($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function isOnlyNum($str){
    if (preg_match("/^\d+$/", $str)) {
        return true;
    } else {
        return false;
    }
}

function CSRF_TOKEN(){
    if (!session_exists('csrf_token')) {
        $hash = hash_make($_SERVER['SERVER_NAME'],uniqid(mt_rand(), true));
        $re_hash = substr($hash, 0, 32).'=PROGRAMNAS-MIDDLE='.substr($hash, -32, 32);
        session_put(
            'csrf_token',
            'PROGRAMNAS-START='.$re_hash.'-'.time().'~'.rand(111111111,999999999).'=PROGRAMNAS-END'
        );
    }
}

function CheckUserReferer($address){
    if(isset($_SERVER['HTTP_REFERER'])) {
        if (strpos($_SERVER['HTTP_REFERER'], $address) !== false) {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function ConfigArray($array){
    if (($key = array_search('', $array)) !== false) {
        unset($array[$key]);
    }
    return array_unique($array);
}

function RemoveItemFromArray($array,$item){
    if (($key = array_search('', $array)) !== false) {
        unset($array[$key]);
    }
    if (($de = array_search($item, $array)) !== false) {
        unset($array[$de]);
    }
    return $array;
}

function SameDate($date){
    $a = DateTime::createFromFormat("Y-m-d H:i:s", $data);
    return ($a->format("Y-m-d") == date('Y-m-d')) ? true : false ;
}

function ConvertMessage($check){
    $dates = '';
    $dates = date("l, F d h:i a" , strtotime($check));
    return $dates;
}

function ConvertSpecial($check){
    $dates = '';
    $dates = date("Y-m-d" , strtotime($check));
    return $dates;
}

function convertshorttime ($check){
    $dates = '';
    $dates = date('h:i A', strtotime($check));
    return $dates;
}

function converttime ($check){
    $dates = '';
    $dates = date("m-d" , strtotime($check));
    return $dates;
}

function ConvertMonth ($check){
    $dates = '';
    $dates = date("Y-m" , strtotime($check));
    return $dates;
}

function ConvertYear ($check){
    $dates = '';
    $dates = date("Y" , strtotime($check));
    return $dates;
}

function nextdate ($check){
    $dates = '';
    $checks = strtotime($check);
    $dates = date("Y-m-d" , strtotime("+1 month",$checks));
    return $dates;
}

function laterMonth ($check){
    $dates = '';
    $checks = strtotime($check);
    $dates = date("Y-m" , strtotime("-1 month",$checks));
    return $dates;
}

function laterYear ($check){
    $dates = '';
    $checks = strtotime($check);
    $dates = date("Y" , strtotime("-1 year",$checks));
    return $dates;
}

function laterdate ($check){
    $dates = '';
    $checks = strtotime($check);
    $dates = date("Y-m-d" , strtotime("-1 day",$checks));
    return $dates;
}

    //dataCookies
function cookies_exists($name) {
    return (isset($_COOKIE[$name])) ? true : false;
}

function cookies_get($name) {
    return $_COOKIE[$name];
}

function cookies_put($name, $value, $expiry) {
    if(setcookie($name, $value, time() + $expiry, '/')) {
        return true;
    }
    return false;
}

function cookies_delete($name) {
    cookies_put($name, '', time() -1);
}

function config_get($path = null) {
    if ($path){
        $config = $GLOBALS['config'];
        $path = explode('/', $path);

        foreach($path as $bit) {
            if(isset($config[$bit])) {
                $config = $config[$bit];
            }
        }

        return $config;
    }
    return false;
}

function StrigToBinary($string){
    $characters = str_split($string);
 
    $binary = [];
    foreach ($characters as $character) {
        $data = unpack('H*', $character);
        $binary[] = base_convert($data[1], 16, 2);
    }
 
    return implode(' ', $binary);    
}

//DataHash
function isSHA256($str){
    if (preg_match("/^([a-f0-9]{64})$/", $str) == 1) {
        return true;
    }else {
        return false;
    }
}

function hash_make($string, $salt = '') {
    return hash('sha256', $string . $salt);
}

function hash_salt($length) {
    return random_bytes($length);
}

function hash_unique() {
    return hash_make(uniqid());
}

function input_exists($type = 'post') {
    switch($type) {
        case 'post':
            return (!empty($_POST)) ? true : false;
            break;
        case 'get':
            return (!empty($_GET)) ? true : false;
            break;
        default:
            return false;
            break;
    }
}

function input_get($item) {
    if(isset($_POST[$item])) {
        return SecureEcho($_POST[$item]);
    } else if(isset($_GET[$item])) {
        return SecureEcho($_GET[$item]);
    }
}

function regular_input_get($item) {
    if(isset($_POST[$item])) {
        return $_POST[$item];
    } else if(isset($_GET[$item])) {
        return $_GET[$item];
    }
}
    
function redirect_to($location = null) {
    if($location) {
        if(is_numeric($location)) {
            switch($location) {
                case 404:
                    header('HTTP/1.0 404 Not Found');
                    //include 'includes/errors/404.php';
                    exit();
                break;
            }
        }
        header('Location: ' . $location);
        exit();
    }
}

function session_exists($name) {
    return (isset($_SESSION[$name])) ? true : false;
}

function session_put($name, $value) {
    return $_SESSION[$name] = $value;
}

function session_get($name) {
    return $_SESSION[$name];
}

function session_delete($name) {
    if(session_exists($name)) {
        unset($_SESSION[$name]);
    }
}

function session_flash ($name, $string = 'null') {
    if(exists($name)) {
        $session = session_get($name);
        session_delete($name);
            return $session;
    } else {
        session_put($name, $string);
    }
}

function token_generate() {
    return session_put(config_get('sessions/token_name'), md5(uniqid()));
}

function token_check($token) {
    $tokenName = config_get('sessions/token_name');
    if(session_exists($tokenName) && $token === session_get($tokenName)) {
        session_delete($tokenName);
        return true;
    }
    return false;
}

function gulpmail($mail){
    $mail   = explode("@",$mail);
    $mail = implode(array_slice($mail, 0, count($mail)-1), '@');
    $mail  = floor(strlen($mail)/3);
    return $mail;
}

function Email($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
        return true;
    } else {
        return false;
    }
}

function FindUrl($w) {
    if (strpos($_SERVER['REQUEST_URI'], $w) !== false) {
        return true;
    }else{
        return false;
    }
}

function GetUrl($url) {
    if(filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) !== false) {
        return true;
    } else {
        return false;
    }
}

function GetCurrentURL(){
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}

function MakeLink($text) {
    $text = ' ' . $text;
    $text = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', 'matchlink', $text);
    $text = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', 'webhttp', $text);
    $text = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $text);
    $text = trim($text);
    return $text;
}

function FixLink($url){
    $u = str_replace('http://', '', $url);
    $u_two = str_replace('https://', '', $u);
    if (substr($u_two, 0, 4) == "www.") {
        $u_three = str_replace('www.', '', $u_two);
    }else{
        $u_three = $u_two;
    }
    return 'http://'.$u_three;
}

function GetExtension($path) {
    return strtolower(pathinfo($path, PATHINFO_EXTENSION));
}

function OrgViews($numbers){
    $numbers = number_format($numbers);
    $input_count = substr_count($numbers, ',');
    if($input_count != '0'){
        if($input_count == '1'){
            return substr($numbers, 0, -4).'k';
        } else if($input_count == '2'){
            return substr($numbers, 0, -8).'m';
        } else if($input_count == '3'){
            return substr($numbers, 0,  -12).'b';
        } else {
            return;
        }
    } else {
        return $numbers;
    }
}

function CachePage($content) {
    $fileName = $Server_Root.$_SERVER["REQUEST_URI"];
    if(false !== ($f = @fopen($fileName, 'd'))) {
        fwrite($f, $content);
        fclose($f);
    }
    return $content.'';
}

function Escape($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function isMobile(){
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

?>