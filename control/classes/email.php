<?php

class email {

    private $_user_email;
    private $_mailer;

    public function __construct($user_email) {
        $this->_db = db::getInstance();
        $this->_user = new user();
        $this->_user_email = $user_email;
        $transport = (new Swift_SmtpTransport(config_get('mail_server/incoming_server'), config_get('mail_server/smtp_port'), 'tls'))->setUsername(config_get('email/username'))->setPassword(config_get('email/password'))->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));
        $this->_mailer = new Swift_Mailer($transport);
    }

    public function ConfirmEmail($name,$confirm_hash,$confirm_code){
        $subject = "Confirm Your Email";
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/confirm_email.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function AccountVerified($name){
        $subject = "Your Account has been Verified";
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/verify_account.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function ResetPassword($name,$hash){
        $confirm_code = '';
        $hash_link = '';
        $subject = "Reset Password";
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/reset_password.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function SendSupport($name,$subject,$body){
        $message = (new Swift_Message($subject))
        ->setFrom([$this->_user_email => $name])
        ->setTo(config_get('email/username'))
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function LogInAttention(){
        $actions = new actions();
        $actions->GetData('users',array('email','=',$this->_user_email));
        $reset_password_hash = hash_make($this->_user_email, hash_salt(64));
        $db = db::getInstance();
        $db->change(
            'users', $actions->data()->id,
            array(
                'reset_password_hash' => $reset_password_hash,
                'password_reset_life' => date("Y-m-d")
            )
        );
        $subject = "Log In Attention";
        $link = 'https://programnas.com/account/reset/?hash='.$reset_password_hash;
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/loged_in.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function ChangeEmail($new_email,$hash){
        $subject = "Change Email";
        $link = 'https://programnas.com/account/change/?hash='.$hash;
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/change_email.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function AccountNotVerified(){
        $subject = "Your Verifying Request";
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/not_verify_account.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function AccountSuspended(){
        $subject = "Your Account is Suspended";
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/account_suspended.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function QuestionDisabled($title){
        $subject = "Your Question is Disabled";
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/question_disabled.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function CheckedAnswer($name,$title){
        $subject = "Your Answer Status";
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/checked_answer.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function AnsweredQuestion($title, $id){
        $subject = "Someone has answered your question";
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/answered_your_question.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public function UnansweredQuestions($user_id, $name){
        $subject = "Unanswered questions in Programnas";
        $db = db::getInstance();
        $html = '';
        foreach ($db->get('questions', array('disabled','=',0,'AND','has_answer','=',0))->results() as $m) {
            if ($m->user_id != $user_id) {
                $sstyle = (IsArabic($m->title)) ? 'direction:rtl;' : 'direction:ltr;' ;
                $html .= '<a href="https://programnas.com/questions/?id='.$m->id.'&q='.$m->title.'" style="display: block;padding: 10px 16px 10px 16px;border-radius: 8px;color: #001946;'.$sstyle.'">'.$m->title.'</a>';
            }
        }
        /*$body = */ include $_SERVER['DOCUMENT_ROOT']."/control/template/html/emails/unanswered_question.php";
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$this->_user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $this->_mailer->send($message);
    }

    public static function SendIndividualEmail($user_email, $subject, $body){
        $transport = (new Swift_SmtpTransport(config_get('mail_server/incoming_server'), config_get('mail_server/smtp_port'), 'tls'))->setUsername(config_get('email/username'))->setPassword(config_get('email/password'))->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($subject))
        ->setFrom([config_get('email/username') => 'Programnas'])
        ->setTo([$user_email])
        ->setBody($body);
        $message->setContentType("text/html");
        return $mailer->send($message);
    }

}
