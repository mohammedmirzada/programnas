<?php


/**
 * Tekosher
 */
class notifications{

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
        $data = $this->_db->get('notifications', array('id','=',$id));
        if($data->count()) {
            $this->_data = $data->first();
            return true;
        }
        return false;
    }

    public function data(){
        return $this->_data;
    }

    public function GetNotifications(){
        $data = '';
        if (actions::Count('notifications',array('user_id','=',$this->_user->data()->id)) > 0) {
            foreach ($this->_db->get('notifications', array('user_id','=',$this->_user->data()->id), 10)->results() as $n) {
                $this->_db->change('notifications', $n->id, array('opened' => 1));
                $data .= '<div class="bg_notify_create">';
                switch ($n->object_number) {
                    case N_ASNWERED:
                    $questions = new questions($n->question_id);
                    $user = new user($n->op_user_id);
                    $title = $questions->data()->title;
                    $data .= '<a align="'.ALIGN_ATTR.'" href="/questions?q='.$title.'&notify_ref_id='.$n->answer_id.'" class="href-notifi-new_answerd '.RTL_CLASS.'">
                    <span><span class="_fontWeight _GreenText">'.$user->data()->name.'</span> '.ANSWERED_Y_QUE.'</span>
                    <div '.IsArabic($title).' class="_title_notifi_asnwerd_wrwe">'.$title.'</div>
                    <div class="_font12 _DarkBlueText">('.time_elapsed_string($n->date).')</div>
                    </a>';
                    break;
                    case N_REPLIED:
                    $questions = new questions($n->question_id);
                    $user = new user($n->op_user_id);
                    $title = $questions->data()->title;
                    $data .= '<a align="'.ALIGN_ATTR.'" href="/questions?q='.$title.'" class="href-notifi-new_answerd '.RTL_CLASS.'">
                    <span><span class="_fontWeight _GreenText">'.$user->data()->name.'</span> '.REPLIED_Y_QUE.'</span>
                    <div '.IsArabic($title).' class="_title_notifi_asnwerd_wrwe">'.$title.'</div>
                    <div class="_font12 _DarkBlueText">('.time_elapsed_string($n->date).')</div>
                    </a>';
                    break;
                }
                $data .= '</div>';
            }
            $data .= '<a href="/notifications" class="viewall_notifi">'.VIEW_ALL.'</a>';
        }else{
            $data = '<h4 class="_Padd8 '.RTL_CLASS.'" align="center">'.NO_NOTIFICATIONS.'</h4>';
        }
        return $data;
    }

    public function GetAllNotifications(){
        $data = '';
        $array = array('user_id','=',$this->_user->data()->id);
        if (actions::Count('notifications',$array) > 0) {
            $total_rows = $this->_db->get('notifications',$array)->count();
            $results_per_page = 10;
            $number_of_pages = ceil($total_rows/$results_per_page);
            if (!isset($_GET['p'])) {
                $p = 1;
            } else {
                $p = input_get('p');
            }
            $this_page_first_result = ($p-1)*$results_per_page;
            foreach ($this->_db->get('notifications', $array, $this_page_first_result.','.$results_per_page)->results() as $n) {
                $this->_db->change('notifications', $n->id, array('opened' => 1));
                $data .= '<div class="bg_notify_create">';
                switch ($n->object_number) {
                    case N_ASNWERED:
                    $questions = new questions($n->question_id);
                    $user = new user($n->op_user_id);
                    $title = $questions->data()->title;
                    $data .= '<a align="'.ALIGN_ATTR.'" href="/questions?q='.$title.'&notify_ref_id='.$n->answer_id.'" class="href-notifi-new_answerd '.RTL_CLASS.'">
                    <span><span class="_fontWeight _GreenText">'.$user->data()->name.'</span> '.ANSWERED_Y_QUE.'</span>
                    <div '.IsArabic($title).' class="_title_notifi_asnwerd_wrwe">'.$title.'</div>
                    <div class="_font12 _DarkBlueText">('.time_elapsed_string($n->date).')</div>
                    </a>';
                    break;
                    case N_REPLIED:
                    $questions = new questions($n->question_id);
                    $user = new user($n->op_user_id);
                    $title = $questions->data()->title;
                    $data .= '<a align="'.ALIGN_ATTR.'" href="/questions?q='.$title.'" class="href-notifi-new_answerd '.RTL_CLASS.'">
                    <span><span class="_fontWeight _GreenText">'.$user->data()->name.'</span> '.REPLIED_Y_QUE.'</span>
                    <div '.IsArabic($title).' class="_title_notifi_asnwerd_wrwe">'.$title.'</div>
                    <div class="_font12 _DarkBlueText">('.time_elapsed_string($n->date).')</div>
                    </a>';
                    break;
                }
                $data .= '</div>';
            }
            $data .= '<div align="center"><div class="_page_nn_que">';
            for ($p=1;$p<=$number_of_pages;$p++) {
                if (input_get('p') == $p) {
                    $data .= '<a class="href_Loadpages_que" style="background: #2b40651c;" href="?p='.$p.'">'.$p.'</a> ';
                }elseif(empty(input_get('p'))){
                    if ($p == 1) {
                        $data .= '<a class="href_Loadpages_que" style="background: #2b40651c;" href="?p='.$p.'">'.$p.'</a> ';
                    }else{
                        $data .= '<a class="href_Loadpages_que" href="?p='.$p.'">'.$p.'</a> ';
                    }
                }else{
                    $data .= '<a class="href_Loadpages_que" href="?p='.$p.'">'.$p.'</a> ';
                }
            }
            $data .= '</div></div>';
        }else{
            $data = '<h4 class="_Padd8 '.RTL_CLASS.'" align="center">'.NO_NOTIFICATIONS.'</h4>';
        }
        return $data;
    }

    public function CountNotifications(){
        return $this->_db->get('notifications', array('user_id','=',$this->_user->data()->id,'AND','opened','=',0))->count();
    }

    public function GetLastNotificationsID(){
        $data = '';
        foreach ($this->_db->get('notifications',array('user_id','=',$this->_user->data()->id,'AND','opened','=',0),1)->results() as $n) {
            $data .= $n->id;
        }
        return $data;
    }

    public function PushNotification($array){
        return $this->_db->insert('notifications', $array);
    }

}


?>