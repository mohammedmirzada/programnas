<?php


/**
 * Tekosher
 */
class payment{

    private $_data, 
            $_user, 
            $_db, 
            $_actions;

    public function __construct($id=null){
        $this->_db = db::getInstance();
        $this->_user = new user();
        $this->_actions = new actions();
        if ($id != null) {
            $this->GetData($id);
        }
    }

    public function GetData($id){
        $data = $this->_db->get('users_points', array('id','=',$id));
        if($data->count()) {
            $this->_data = $data->first();
            return true;
        }
        return false;
    }

    public function data(){
        return $this->_data;
    }

    public function GetBalance($id=null){
        if ($id == null) {
            $points = $this->_db->get('users_points', array('user_id','=',$this->_user->data()->id,'AND','is_paid','=',0))->count() * 0.10;
            $votes = $this->_db->get('user_votes', array('user_id','=',$this->_user->data()->id,'AND','is_paid','=',0))->count() * 0.01;
            return $points + $votes;
        }else{
            $points = $this->_db->get('users_points', array('user_id','=',$id,'AND','is_paid','=',0))->count() * 0.10;
            $votes = $this->_db->get('user_votes', array('user_id','=',$id,'AND','is_paid','=',0))->count() * 0.01;
            return $points + $votes;
        }
    }

    public function GetAllUsersBalance(){
        $points = 0;
        $votes = 0;
        foreach ($this->_db->get('users', array('suspended','=',0))->results() as $m) {
            $points +=  $this->_db->get('users_points', array('user_id','=',$m->id,'AND','is_paid','=',0))->count() * 0.10;
            $votes +=  $this->_db->get('user_votes', array('user_id','=',$m->id,'AND','is_paid','=',0))->count() * 0.01;
        }
        return $points + $votes;
    }

    public function isPrimary($method,$payment_id){
        $primary_payment = $this->_user->data()->primary_payment;
        if ($primary_payment == $method.'_'.$payment_id) {
            return true;
        }else{
            return false;
        }
    }

    public function GetTransactions(){
        $data = '<table class="_table_tt">';
        $data .= '
        <tr style="background: #343c4112;">
            <th class="_th_table" style="width:40%;"><b>'.METHOD.'</b></th>
            <th class="_th_table" style="width:20%;"><b>'.AMOUNT.'</b></th>
            <th class="_th_table" style="width:20%;"><b>'.STATUS.'</b></th>
            <th class="_th_table" style="width:20%;"><b>'.DATE_ISSUED.'</b></th>
        </tr>
        ';
        foreach ($this->_db->get('transactions', array('user_id','=',$this->_user->data()->id))->results() as $m) {
            $status = '';
            if ($m->object_number == T_PENDING) {
                $status .= '<span style="color: #a5a12d;">'.PENDING.'</span>';
            }elseif ($m->object_number == T_PROCESSED) {
                $status .= '<span style="color: #1b8e14;">'.PROCESSED.'</span>';
            }elseif ($m->object_number == T_CANCELED) {
                $status .= '<span style="color: #a02e2e;">'.CANCELED.'</span>';
            }
            if ($m->method == "fastpay" || $m->method == "Fastpay") {
                $logo_detail = '<div class="fastpay_log_de"></div>';
            }elseif ($m->method == "bitcoin" || $m->method == "Bitcoin") {
                $logo_detail = '<div class="bitcoin_log_de"></div>';
            }else{
                $logo_detail = '<div class="wire_log_de"></div>';
            }
            $data .= '
            <tr class="_tr_table">
                <td class="_td_table"><span class="details_show" onclick="show(deatails_id_'.$m->id.');">'.$m->method.'</span></td>
                <td class="_td_table">$'.$m->amount.'</td>
                <td class="_td_table">'.$status.'</td>
                <td class="_td_table">'.ConvertSpecial($m->date).'</td>
            </tr>
            <div align="center" class="_details_payeh_" id="deatails_id_'.$m->id.'">
                <button class="hide_but_det" onclick="hide(deatails_id_'.$m->id.');">'.HIDE.'</button>
                <div>'.$logo_detail.'</div>
                <div style="white-space: pre-wrap;">'.$m->payment_details.'</div>
            </div>
            ';
        }
        $data .= '</table>';
        return $data;
    }

    public function CountTransactions(){
        return $this->_db->get('transactions',array('user_id','=',$this->_user->data()->id))->count();
    }

}


?>