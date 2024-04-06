<?php
class user {
    private $_db,
            $_data,
            $_language,
            $_sessionName,
            $_currentuser,
            $_cookieName,
            $isLoggedIn;

    public function __construct($user = null,$id=null) {
        $this->_db = db::getInstance();
        $this->_sessionName = config_get('sessions/session_name');
        $this->_cookieName = config_get('remember/cookie_name');
        if(!$user) {
            if( session_exists($this->_sessionName)) {
                $user = session_get($this->_sessionName);
                if( $this->find($user)) {
                    $this->isLoggedIn = true;
                } else {
                    $this->logout();
                }
            }
        } else {
            $this->find($user);
        }
        
    }
    public function find($user = null) {
        if($user) {
            if( ctype_digit( strval( $user ) ) && strlen( $user ) == 11 ) {
                $field = 'phone';
            } else if ( ctype_digit( strval( $user ) ) ) {
                $field = 'id';
            } else if ( filter_var( $user, FILTER_VALIDATE_EMAIL ) ) {
                $field = 'email';
            } else {
                $field = 'username';
            }

            $data = $this->_db->get('users', array( $field, '=', $user));
            if( $data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function data(){
        return $this->_data;
    }
    
    public function ImageIcon($id=null){
        if ($id != null) {
            $this->find($id);
        }
        if (!empty($this->_data->image)) {
            if(Is404($this->_data->image)){
                return "https://programnas.com/control/template/media/png/avatar.png";
            }else{
                return $this->_data->image;
            }
        }else{
            return "https://programnas.com/control/template/media/png/avatar.png";
        }
    }

    public function login($username = null, $password = null, $remember = true) {
        if(!$username && !$password && $this->exists()) {
            session_put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($username);
            if($user) {
                if($this->data()->password === hash_make($password, $this->data()->salt)) {
                    session_put($this->_sessionName, $this->data()->id);
                    $hash = hash_unique();
                    $HashCheck = cookies_get(config_get('remember/cookie_name'));
                    if($remember) {
                        $this->_db->insert('users_session', array(
                            'user_id' => $this->data()->id,
                            'hash' => $hash,
                            'user_ip' => prespe::GetUserIP(),
                            'user_agent' => $_SERVER['HTTP_USER_AGENT']
                        ));
                        cookies_put($this->_cookieName, $hash,  config_get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public function RecentLogins(){
        return $this->_db->get('users_session',array('user_id','=',$this->data()->id))->results();
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout() {
    	$this->_db->delete('users_session', array('user_id','=',$this->data()->id,'AND','user_agent', '=', $_SERVER['HTTP_USER_AGENT']));
    	session_delete($this->_sessionName);
    	cookies_delete($this->_cookieName);
        cookies_delete(config_get('cookies/auth'));
    }

    public function isLoggedIn() {
        return $this->isLoggedIn;
    }

    public function allUser() {
    	$result = $this->_db->get('SELECT id', 'users', array('id', 'NOT LIKE', $this->data()->id));
    	return $result->results();
    }

    public function Answers($id=null){
        if ($id != null) {
            $this->find($id);
        }
        return $this->_db->get('answers',array('user_id','=',$this->_data->id))->count();
    }

    public function Questions($id=null){
        if ($id != null) {
            $this->find($id);
        }
        return $this->_db->get('questions',array('user_id','=',$this->_data->id))->count();
    }

    public function Replies($id=null){
        if ($id != null) {
            $this->find($id);
        }
        return $this->_db->get('questions',array('user_id','=',$this->_data->id))->count();
    }

    public function Scores($id=null){
        return ($this->Questions() + $this->Answers() + $this->Replies()) * 7;
    }

    public function isConfirmed(){
        if ($this->data()->confirmed == 1) {
            return true;
        }else{
            return false;
        }
    }

    public function isSuspended(){
        if ($this->data()->suspended == 1) {
            return true;
        }else{
            return false;
        }
    }

    public function isVerified(){
        if ($this->data()->verified == 1) {
            return true;
        }else{
            return false;
        }
    }

    public function isNotifyNewQuestion(){
        if ($this->data()->notify_new_question == 1) {
            return true;
        }else{
            return false;
        }
    }

    public function isNotifyNewAnswer(){
        if ($this->data()->notify_new_answer == 1) {
            return true;
        }else{
            return false;
        }
    }

    public function iaAuth(){
        return ($this->data()->two_factor_auth == 1) ? true : false ;
    }

    public function isPrivate(){
        return ($this->data()->is_private == 1) ? true : false ;
    }

    public function Payments(){
        return $this->_db->get('fastpay',array('user_id','=',$this->_data->id))->count() + $this->_db->get('bitcoin',array('user_id','=',$this->_data->id))->count();
    }

    public static function isDeactive($username){
        if (actions::Count('users',array('username','=',$username,'AND','deactive','=',1)) > 0) {
            return true;
        }else{
            return false;
        }
    }
        
}
