<?php

class validate {

    private $_db;
    private $_user;
    private $_actions;

    public function __construct() {
        $this->_db = db::getInstance();
        $this->_user = new user();
        $this->_actions = new actions();
    }

    public function ValidateName($str){
        if (empty($str)) {
            return NAME_IS_EMPTY;
        }else if ($this->JustAbuse($str)) {
            return WRITE_NAME_CORRECTLY;
        }else if (strlen($str) > 30) {
            return LENGTH_NAME;
        }else if (strlen($str) < 3) {
            return TRY_NAME_CO_Y;
        }else if (!preg_match("/^[\p{L} ]+$/u",$str)) {
            return $str." ".INCORRECT_FORMAT_NAME;
        }else{
            return "";
        }
    }

    public function ValidateUsername($str){
        if (empty($str)) {
            return USERNAME_IS_EMPTY;
        }else if ($this->Blocked($str)) {
            return USERNAME_NOT_ALLOWED;
        }else if ($this->_db->get('users', array('username', '=', $str))->count() >= 1 ) {
            return $str.ALREADY_EXISTS;
        }else if (!preg_match('/^[A-Za-z][a-zA-Z0-9._]{3,20}$/', $str)) {
            return $str.INCORRECT_FORMAT_USERNAME;
        }else{
            return "";
        }
    }

    public function ValidateUpdateUsername($str){
        if (empty($str)) {
            return USERNAME_IS_EMPTY;
        }else if ($this->Blocked($str)) {
            return USERNAME_NOT_ALLOWED;
        }else if (!preg_match('/^[A-Za-z][a-zA-Z0-9._]{3,20}$/', $str)) {
            return $str.INCORRECT_FORMAT_USERNAME;
        }else if ($this->_db->get('users', array('username', '=', $str))->count() >= 1 ) {
            if ($str != $this->_user->data()->username) {
                return $str.ALREADY_EXISTS;
            }else{
                return "";
            }
        }else{
            return "";
        }
    }

    public function ValidateEmail($str,$type_email){
        if (empty($str)) {
            return EMAIL_IS_EMPTY;
        }else if ($this->_db->get('users', array($type_email, '=', $str))->count() >= 1 ) {
            return $str.ALREADY_EXISTS;
        }else if (!Email($str)) {
            return "{$str} ".INCORRECT_FORMAT_EMAIL;
        }else{
            return "";
        }
    }

    public function ValidatePassword($str){
        if (strlen($str) < 7){
            return PASS_VAL_ONE;
        }else if (strlen($str) > 64){
            return PASS_VAL_TWO;
        }else{
            return "";
        }
    }

    public function ValidateGender($str){
        if ($str == "Male" || $str == "Female" || $str == "Other") {
            return "";
        }else {
            return SELECT_GENDER;
        }
    }

    public function ValidateBirthdate($year,$month,$day){
        if (is_int((int)$year) && is_int((int)$month) && is_int((int)$day)) {
            if (empty($year) || empty($month) || empty($day)) {
                return SELECT_BIRTH;
            }else if ($year > 2010 || $year < 1900) {
                return SELECT_BIRTH;
            }else if ($month == 0 || $month > 12) {
                return SELECT_BIRTH;
            }else if ($day == 0 || $day > 31) {
                return SELECT_BIRTH;
            }else {
                return "";
            }
        }else{
            return SELECT_BIRTH;
        }
    }

    public function ValidateCountry($str){
        if (empty($str)) {
            return SELECT_COUNTRY_TE;
        }else if ($str == "Country&Territory"){
            return SELECT_COUNTRY_TE;
        }else if (strlen($str) > 30){
            return SOMETHING_WRONG;
        }else if ($this->_actions->Count('countries',array('name','=',$str)) == 0){
            return SELECT_COUNTRY_TE;
        }else{
            return "";
        }
    }

    public function ValidateQuestionTitle($title){
        if (strlen($title) > 100) {
            return QUE_TITLE_VAL;
        }else if (empty($title)) {
            return QUE_TITLE_EMPTY;
        }else if (strlen($title) < 20) {
            return QUE_TITLE_SHORT;
        }else if ($this->_db->get('questions', array('title', '=', $title))->count() >= 1 ) {
            return QUE_DUPLI;
        }else if ($this->JustAbuse($title)) {
            return QUE_WRITE_CORRECTLY;
        }else {
            return "";
        }
    }

    public function ValidateQuestionContent($content){
        if (strlen($content) > 9000) {
            return CONTENT_SHORT;
        }else if (empty($content)) {
            return CONTENT_EMPTY;
        }else if (strlen($content) < 10) {
            return CONTENT_LONG;
        }else if ($this->JustAbuse($content)) {
            return CONTENT_WRITE_CORRECTLY;
        }else {
            return "";
        }
    }

    public function ValidateImage($folder_,$img){
        $images = array_filter(ConfigArray(explode("|", $img)));
        $val = '';
        foreach ($images as $i) {
            $extension = substr($i, -3);
            if ($extension == "png" || $extension == "jpg" || $extension == "jpeg") {
                $val = 'https://programnas.com/control/'.$folder_.'/'.$i;
            }else{
                $val = "https://programnas.com/control/template/media/jpg/404_imgs.jpg";
                break;
            }
        }
        return $val;
    }

    public function ValidateUpdateImage($str){
        if (strlen($str) > 500) {
            return SOMETHING_WRONG;
        }else if (!empty($str)) {
            if (strpos($str, 'programnas') == false) {
                return SOMETHING_WRONG;
            }else{
                return "";
            }
        }else {
            return "";
        }
    }

    public function ValidateBio($str){
        if (strlen($str) > 380) {
            return BIO_LONG;
        }else if ($this->JustAbuse($str)) {
            return BIO_ABUSE;
        }else {
            return "";
        }
    }

    public function ValidateWireTransfer($name,$account_id,$bank_address,$bank_name,$swift,$iban){
        $val_name = $this->ValidateName($name);
        if (!empty($val_name)) {
            return $val_name;
        }elseif (!empty($account_id)) {
            if (ctype_digit($account_id)) {
                return "";
            }else{
                return VAL_ACC_NUM;
            }
        }elseif (!empty($bank_address)) {
            if (strlen($bank_address) > 100) {
                return VAL_B_ADDERSS;
            }else{
                return "";
            }
        }elseif (strlen($bank_name) > 100) {
            return VAL_B_NAME;
        }elseif (!preg_match('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', $swift)) {
            return SWIFT_VAL;
        }elseif (strlen($iban) > 200) {
            return IBAN_VAL;
        }else{
            return "";
        }
        
    }

    public static function isBitcoin($address){
        $origbase58 = $address;
        $dec = "0";

        for ($i = 0; $i < strlen($address); $i++){
            $dec = bcadd(bcmul($dec,"58",0),strpos("123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz",substr($address,$i,1)),0);
        }

        $address = "";

        while (bccomp($dec,0) == 1){
            $dv = bcdiv($dec,"16",0);
            $rem = (integer)bcmod($dec,"16");
            $dec = $dv;
            $address = $address.substr("0123456789ABCDEF",$rem,1);
        }

        $address = strrev($address);

        for ($i = 0; $i < strlen($origbase58) && substr($origbase58,$i,1) == "1"; $i++){
            $address = "00".$address;
        }

        if (strlen($address)%2 != 0){
            $address = "0".$address;
        }

        if (strlen($address) != 50){
            return false;
        }

        if (hexdec(substr($address,0,2)) > 0){
            return false;
        }

        return substr(strtoupper(hash("sha256",hash("sha256",pack("H*",substr($address,0,strlen($address)-8)),true))),0,8) == substr($address,strlen($address)-8);
    }

    public function CanAsk(){
        if (actions::Count('questions',array('user_id','=',$this->_user->data()->id,'AND','date','=',date("Y-m-d"))) > 3) {
            return false;
        }else{
            return true;
        }
        return true;
    }

    public function CanAnswer(){
        if (actions::Count('answers',array('user_id','=',$this->_user->data()->id,'AND','date','=',date("Y-m-d"))) > 100) {
            return false;
        }else{
            return true;
        }
        return true;
    }

    public function CanReply(){
        if (actions::Count('replies',array('user_id','=',$this->_user->data()->id,'AND','date','=',date("Y-m-d"))) > 100) {
            return false;
        }else{
            return true;
        }
        return true;
    }

    public static function LinkUsername($username){
        if (preg_match('/^[A-Za-z][a-zA-Z0-9._]{3,20}$/', $username)) {
            return true;
        }else{
            return false;
        }
    }

    public static function Blocked($text){
        $disable_content = array('username', 'name', 'developer', 'developers', 'api' ,'about' ,'programnas' ,'dnianas', 'contacts', 'sign', 'signin', 'login', 'signup', 'register', 'signout', 'logout', 'reset', 'activation', 'connect', 'archived', 'following', 'follower', 'search', 'friends', 'message', 'notifications', 'notification', 'settings', 'setting', 'posts', 'post', 'photos', 'photo', 'create', 'pages', 'page', 'groups', 'group', 'games', 'game', 'saved', 'directory', 'products', 'product', 'market', 'library', 'bio', 'archive', 'sexy', 'fuck', 'porn', 'bitch', 'suck', 'gay', 'pussy', 'ass', 'anal', 'cock', 'dick', 'felch', 'cunt', 'skullfuck', 'cum', ' blumpkin', 'trombone', 'bate', 'fucking', 'cocksucker', 'cuntbag', 'shum', 'slich', 'gan', 'gandar', 'blowjob', 'fuckme', 'Sexual', 'porn', 'pornography', 'sex', 'tits', 'cumshot', 'hardfuck', 'suckdick', 'lickpussy', 'fuck ass', 'fuck anal', 'fuck pussy', 'suck dick' , 'messages', 'users', 'pornhub', 'xnxx', 'xlxx', 'facebook', 'instagram', 'twitter', 'edit', 'profile', 'htaccess', 'male', 'female', 'account', 'accounts', 'payment', 'payments', 'kurdfilm', 'zhinma', 'zhinmagroup','phpmyadmin','questions','cookies','cookie','control','admin','admins','digital','test','publicadmin','publicdashboard','7iz','xushk');
        if(in_array(strtolower($text), $disable_content)) {
            return true;
        } else {
            return false;
        }
    }

    public static function JustAbuse($text){
        $disable_content = array('sexy', 'fuck', 'fuckyou', 'porn', 'bitch', 'suck', 'gay', 'pussy', 'ass', 'anal', 'cock', 'dick', 'felch', 'cunt', 'skullfuck', 'cum', ' blumpkin', 'trombone', 'bate', 'fucking', 'cocksucker', 'cuntbag', 'shum', 'slich', 'gan', 'blowjob', 'fuckme', 'Sexual', 'porn', 'pornography', 'sex', 'tits', 'cumshot', 'hardfuck', 'gandar', 'suckdick', 'lickpussy', 'fuck ass', 'fuck anal', 'fuck pussy', 'suck dick','7iz','xushk');
        if(in_array(strtolower($text), $disable_content)) {
            return true;
        } else {
            return false;
        }
    }

    public function isValidAuthCode($code,$salt){
        $g = new \Google\Authenticator\GoogleAuthenticator();
        return ($g->checkCode($salt, $code)) ? true : false ;
    }

}
