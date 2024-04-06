<?php

/**
 * Tekosher
 */
class questions{

	private $_data, $_db, $_actions, $_user;
	
	public function __construct($id=null){
		$this->_db = db::getInstance();
        $this->_actions = new actions();
        $this->_user = new user();
        if ($id != null) {
            $this->GetData($id);
        }
	}

	public function GetData($id){
        $data = $this->_db->get('questions', array('id','=',$id));
        if($data->count()) {
            $this->_data = $data->first();
            return true;
        }
        return false;
    }

    public function data(){
        return $this->_data;
    }

    public function Count($disabled=false){
    	$d = ($disabled) ? 1 : 0 ;
    	return $this->_db->get('questions',array('id','>',0,'AND','disabled','=',$d))->count();
    }

    public function GetQuestions($array=array('disabled','=',0),$ppp='?p='){
        $data = '';

        $total_rows = $this->_db->get('questions',$array)->count();

        if($total_rows > 0){

        $results_per_page = 13;
        $number_of_pages = ceil($total_rows/$results_per_page);
        if (!isset($_GET['p'])) {
            $p = 1;
        } else {
            $p = input_get('p');
        }
        $this_page_first_result = ($p-1)*$results_per_page;
        //$i = ($page-1)*$results_per_page + 1;

        foreach ($this->_db->get('questions',$array,$this_page_first_result.','.$results_per_page)->results() as $q) {
            $user = new user($q->user_id);
            $title = $q->title;
            $tags = '';

            $answers_count = $this->CountAnswers($q->id);

            if ($answers_count == 0) {
                $counted_answer_text = '0 '.ANSWER;
                $style_answer = '_RedText ';
            }elseif ($answers_count == 1) {
                $counted_answer_text = '1 '.ANSWER;
                $style_answer = '_GreenText ';
            }else {
                $counted_answer_text = $answers_count.' '.ANSWERS;
                $style_answer = '_GreenText ';
            }

            $checked_symbol = ($this->isChecked($q->id)) ? '<span class="bett-line-span"></span>'.'<i class="small_true_icon"></i>' : '' ;

            $data .= '
            <div class="_ThiList">
                <a href="/questions/?id='.$q->id.'&q='.$title.'" class="href-que-list" '.IsArabic($title).' >'.$title.'</a>
                <span class="line-middle '.$style_answer.' '.RTL_CLASS.'">'.$counted_answer_text.'</span>
                <span class="bett-line-span"></span>
                <span class="line-middle _SevenText"><i class="_icons view_que_"></i> '.$this->GetViews($q->id).'</span>
                <span class="bett-line-span"></span>
                <span class="line-middle _SevenText '.RTL_CLASS.'">'.time_elapsed_string($q->time).'</span>
                '.$checked_symbol.'
                <span class="bett-line-span"></span>
                <span class="_breakWord _InlineBlock">
                    '.$this->GetTags($q->tags).'
                </span>
                <div class="_MARtop6">
                    <a href="/'.$user->data()->username.'" class="_href_go_prof-intlist">
                        <span style="background-image: url('.$user->ImageIcon().');" class="avatar-pic-init-que-li"></span>
                        <span>'.$user->data()->name.'</span>
                    </a>
                </div>
            </div>';
        }
        $data .= '<div align="center"><div class="_page_nn_que">';
        for ($p=1;$p<=$number_of_pages;$p++) {
            if (input_get('p') == $p) {
                $data .= '<a class="href_Loadpages_que" style="background: #2b40651c;" href="'. $ppp . $p . '">' . $p . '</a> ';
            }elseif(empty(input_get('p'))){
                if ($p == 1) {
                    $data .= '<a class="href_Loadpages_que" style="background: #2b40651c;" href="'. $ppp . $p . '">' . $p . '</a> ';
                }else{
                    $data .= '<a class="href_Loadpages_que" href="'. $ppp . $p . '">' . $p . '</a> ';
                }
            }else{
                $data .= '<a class="href_Loadpages_que" href="'. $ppp . $p . '">' . $p . '</a> ';
            }
        }
        $data .= '</div></div>';
        $data .= '<div class="BlockForMob _MARtop">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Mobile -->
        <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-9877420063334339"
        data-ad-slot="6100405738"
        data-ad-format="horizontal"
        data-full-width-responsive="false"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>';
        }else{
            $data .= '<h4 align="center">'.NO_Q_FOUND.'</h4>';
        }
        return $data;
    }

    public function GetProfileQuestions($user_id){
        $data = '';

        $array = array('disabled','=',0,'AND','user_id','=',$user_id);
        $total_rows = $this->_db->get('questions',$array)->count();

        if($total_rows > 0){

        $results_per_page = 8;
        $number_of_pages = ceil($total_rows/$results_per_page);
        if (!isset($_GET['p'])) {
            $p = 1;
        } else {
            $p = input_get('p');
        }
        $this_page_first_result = ($p-1)*$results_per_page;

        foreach ($this->_db->get('questions',$array,$this_page_first_result.','.$results_per_page)->results() as $q) {
            $title = $q->title;
            $tags = '';

            $answers_count = $this->CountAnswers($q->id);

            if ($answers_count == 0) {
                $counted_answer_text = '0 '.ANSWER;
                $style_answer = '_RedText ';
            }elseif ($answers_count == 1) {
                $counted_answer_text = '1 '.ANSWER;
                $style_answer = '_GreenText ';
            }else {
                $counted_answer_text = $answers_count.' '.ANSWERS;
                $style_answer = '_GreenText ';
            }

            $checked_symbol = ($this->isChecked($q->id)) ? '<span class="bett-line-span"></span>'.'<i class="small_true_icon"></i>' : '' ;

            $data .= '
            <div class="_ThiList">
                <a href="/questions/?q='.$title.'" class="href-que-list" '.IsArabic($title).' >'.$title.'</a>
                <span class="line-middle '.$style_answer.' '.RTL_CLASS.'">'.$counted_answer_text.'</span>
                <span class="bett-line-span"></span>
                <span class="line-middle _SevenText"><i class="_icons view_que_"></i> '.$this->GetViews($q->id).'</span>
                <span class="bett-line-span"></span>
                <span class="line-middle _SevenText '.RTL_CLASS.'">'.time_elapsed_string($q->time).'</span>
                '.$checked_symbol.'
                <span class="bett-line-span"></span>
                <span class="_breakWord _InlineBlock">
                    '.$this->GetTags($q->tags).'
                </span>
            </div>';
        }
        $data .= '<div align="center"><div class="_page_nn">';
        for ($p=1;$p<=$number_of_pages;$p++) {
            if (input_get('p') == $p) {
                $data .= '<a class="href_Loadpages" style="background: #ffffff47;" href="?p='. $p . '">' . $p . '</a> ';
            }elseif(empty(input_get('p'))){
                if ($p == 1) {
                    $data .= '<a class="href_Loadpages" style="background: #ffffff47;" href="?p='. $p . '">' . $p . '</a> ';
                }else{
                    $data .= '<a class="href_Loadpages" href="?p='. $p . '">' . $p . '</a> ';
                }
            }else{
                $data .= '<a class="href_Loadpages" href="?p='. $p . '">' . $p . '</a> ';
            }
        }
        $data .= '</div></div>';
        }else{
            $data .= '<div align="center"><span class="no-activity-bg"></span></div>';
        }
        return $data;
    }

    public function GetProfileAnswers($user_id,$username){
        $data = '';

        $total_rows = $this->_db->get('answers',array('disabled','=',0,'AND','user_id','=',$user_id))->count();

        if($total_rows > 0){

        $results_per_page = 8;
        $number_of_pages = ceil($total_rows/$results_per_page);
        if (!isset($_GET['p'])) {
            $p = 1;
        } else {
            $p = input_get('p');
        }
        $this_page_first_result = ($p-1)*$results_per_page;

        foreach ($this->_db->get('answers',array('disabled','=',0,'AND','user_id','=',$user_id),$this_page_first_result.','.$results_per_page)->results() as $k) {
        foreach ($this->_db->get('questions',array('id','=',$k->question_id,'AND','disabled','=',0))->results() as $qq) {
            $title = $qq->title;
            $tags = '';

            $answers_count = $this->CountAnswers($qq->id);

            if ($answers_count == 0) {
                $counted_answer_text = '0 '.ANSWER;
                $style_answer = '_RedText ';
            }elseif ($answers_count == 1) {
                $counted_answer_text = '1 '.ANSWER;
                $style_answer = '_GreenText ';
            }else {
                $counted_answer_text = $answers_count.' '.ANSWERS;
                $style_answer = '_GreenText ';
            }

            $checked_symbol = ($this->isChecked($qq->id)) ? '<span class="bett-line-span"></span>'.'<i class="small_true_icon"></i>' : '' ;

            $data .= '
                <div class="_ThiList">
                    <a href="/questions/?q='.$title.'" class="href-que-list" '.IsArabic($title).' >'.$title.'</a>
                    <span class="line-middle '.$style_answer.' '.RTL_CLASS.'">'.$counted_answer_text.'</span>
                    <span class="bett-line-span"></span>
                    <span class="line-middle _SevenText"><i class="_icons view_que_"></i> '.$this->GetViews($qq->id).'</span>
                    <span class="bett-line-span"></span>
                    <span class="line-middle _SevenText '.RTL_CLASS.'">'.time_elapsed_string($qq->time).'</span>
                    '.$checked_symbol.'
                    <span class="bett-line-span"></span>
                    <span class="_breakWord _InlineBlock">
                    '.$this->GetTags($qq->tags).'
                    </span>
                </div>';
            }
        }
        $q_p = (isset($_GET['part'])) ? '?p=' : '?p=' ;
        $data .= '<div align="center"><div class="_page_nn">';
        for ($p=1;$p<=$number_of_pages;$p++) {
            if (input_get('p') == $p) {
                $data .= '<a class="href_Loadpages" style="background: #ffffff47;" href="https://programnas.com/'.$username.'?part=answers&p='. $p . '">' . $p . '</a> ';
            }elseif(empty(input_get('p'))){
                if ($p == 1) {
                    $data .= '<a class="href_Loadpages" style="background: #ffffff47;" href="https://programnas.com/'.$username.'?part=answers&p='. $p . '">' . $p . '</a> ';
                }else{
                    $data .= '<a class="href_Loadpages" href="https://programnas.com/'.$username.'?part=answers&p='. $p . '">' . $p . '</a> ';
                }
            }else{
                $data .= '<a class="href_Loadpages" href="https://programnas.com/'.$username.'?part=answers&p='. $p . '">' . $p . '</a> ';
            }
        }
        $data .= '</div></div>';
        }else{
            $data .= '<div align="center"><span class="no-activity-bg"></span></div>';
        }
        return $data;
    }

    public function GetAnswers(){
        $data = '';
        foreach ($this->_db->get('answers',array('question_id','=',$this->data()->id,'AND','disabled','=',0))->results() as $a) {
            $user = new user($a->user_id);

            $true_answered_bg = ($a->verified == 1) ? 'background: #95f00414;' : '' ;
            $more_tools = '';
            if ($a->verified == 1) {
                $who_checked = (actions::Count('users_points', array('answer_id','=',$a->id,'AND','user_agent','=','pn')) > 0) ? PN_CHECKED_ANSWER : Y_CHECKED_T_ANSWER ;
                $more_tools .= '<div onmouseout="hide(\'_is_true_message\')" onmouseover="show(\'_is_true_message\')" class="trueing_tool_que" style="background-image: url(/control/template/media/svg/trued.svg);"></div>';
                $more_tools .= '<span id="_is_true_message" style="display: none;" class="istruedYeNo_que">'.$who_checked.'</span>';
            }
            if (session_exists('user')) {
                if ($this->_user->data()->id == $this->data()->user_id) {
                    if ($this->data()->checked == 0) {
                        $more_tools .= '<div onmouseout="hide(\'_is_true_message\')" onmouseover="show(\'_is_true_message\')" class="trueing_tool_que" style="background-image: url(/control/template/media/svg/true.svg);" onclick="CheckAnswer(this,'.$a->id.','.$a->question_id.')"></div>';
                        $more_tools .= '<span id="_is_true_message" style="display: none;" class="istruedYeNo_que">'.CHECK_T_ANSWER_C_O.'</span>';
                    }
                    $more_tools .= '<div onmouseout="hide(\'_reporting_message\')" onmouseover="show(\'_reporting_message\')" class="trueing_tool_que" style="background-image: url(/control/template/media/svg/report_answer.svg);" onclick="ReportAnswer(this,'.$a->id.')"></div>';
                    $more_tools .= '<span id="_reporting_message" style="display: none;" class="istruedYeNo_que">'.REPORT_T_ANSWER.'</span>';
                }
            }
            

            $updateButt = '';
            if (session_exists('user')) {
                if ($a->user_id == $this->_user->data()->id && $a->updated == 0) {
                    $more_tools .= '<div onmouseout="hide(\'_update_message\')" onmouseover="show(\'_update_message\')" class="trueing_tool_que" style="background-image: url(/control/template/media/svg/edit.svg);" onclick="PrepareUpdatingAnswer('.$a->id.','.$a->question_id.')"></div>';
                    $more_tools .= '<span id="_update_message" style="display: none;" class="istruedYeNo_que">'.UPDATE_Y_ANSWER.'</span>';
                    if ($a->verified != 1) {
                        $more_tools .= '<div onmouseout="hide(\'_update_message_delete\')" onmouseover="show(\'_update_message_delete\')" class="trueing_tool_que" style="background-image: url(/control/template/media/svg/trash.svg);" onclick="DeleteAnswer('.$a->id.','.$a->question_id.',\''.input_get('q').'\')"></div>';
                        $more_tools .= '<span id="_update_message_delete" style="display: none;" class="istruedYeNo_que">'.DELETE_ANSWER.'</span>';
                    }
                }
            }

            $count_votes = $this->CountVotes($a->id);
            if ($this->isVoted($a->id)) {
                $more_tools .= '<div onmouseout="hide(\'_vote_up_down_message_\')" onmouseover="show(\'_vote_up_down_message_\')" class="trueing_tool_que relative" style="background-position: center -2px;background-image: url(/control/template/media/svg/vote_up.svg);" onclick="VotingAnswer(this,'.$a->id.','.$a->question_id.',true)"><span class="_voting_butt">'.OrgViews($count_votes).'</span></div>';
            }else{
                $more_tools .= '<div onmouseout="hide(\'_vote_up_down_message_\')" onmouseover="show(\'_vote_up_down_message_\')" class="trueing_tool_que relative" style="background-position: center -2px;background-image: url(/control/template/media/svg/vote_down.svg);" onclick="VotingAnswer(this,'.$a->id.','.$a->question_id.',false)"><span class="_voting_butt">'.OrgViews($count_votes).'</span></div>';
            }
            $more_tools .= '<span id="_vote_up_down_message_" style="display: none;" class="istruedYeNo_que">'.VOTING_UP_INS.'</span>';

            $updated_statused = '';
            if ($a->updated == 1) {
                $updated_statused = '
                <div class="updated-text-ti">
                    <h3 style="border-bottom: 1px solid #c3c3c3;padding-bottom: 4px;">'.UPDATED.'</h3>
                    <div style="text-align: start;white-space: break-spaces;" '.IsArabic(substr($a->updated_content, 0, 10)).'>
                        '.actions::ContentText($a->updated_content, '12px').'
                    </div>
                </div>';
            }

            $is_refed_notify = (input_get('notify_ref_id') == $a->id) ? 'border: 1px solid #2063b6;' : '' ;

            $data .= '
            <div class="_Padd8">
            <div class="_InlineFlex _Width100" id="mob_column_and_rev" style="'.$true_answered_bg.' '.$is_refed_notify.'">
                <div class="_border_asnwers_q_a" style="flex: 10;">
                    <a style="display: block;overflow: hidden;" class="_InlineBlock _Padd8 _hovering-ahrefQUe" href="/'.$user->data()->username.'">
                        <span class="img0civon-que" style="background-image: url('.$user->ImageIcon().');"></span>
                        <span class="href-que-name">'.$user->data()->name.'</span>
                        <span class="bett-line-span" style="top: -7px;"></span>
                        <span '.actions::Relative(-12).' class="_font8 _SevenText '.RTL_CLASS.'">'.ANSWERED.' '.time_elapsed_string($a->time).'</span>
                    </a>
                    <div style="text-align: start;white-space: break-spaces;" '.IsArabic(substr($a->content, 0, 10)).'>
                        '.actions::ContentText($a->content, '12px').'    
                    </div>
                    <div id="text-area-inner'.$a->id.'"></div>
                    <div>
                        '.$this->GetBoxes($a->box_ids).'
                    </div>
                    <div style="border-bottom: 1px solid #ddd;" class="_MARtop _OverflowAuto _Flex horizScoll" align="center">
                        '.$this->GetImages($a->image,'a').'
                    </div>
                    '.$updated_statused.'
                    <div class="_SevenText _fontWeight _font14 _Padd8"><u>'.REPLIES.'</u></div>
                    <div class="style_pos_bor_rep">
                        <textarea type="text" style="height: 46px;resize: vertical;" id="reply_text'.$a->id.'" placeholder="'.REPLY___.'" class="reply_class"></textarea>
                        <button class="reply_butt" onclick="Reply(\'reply_text'.$a->id.'\')">'.REPLY.'</button>
                        <div class="_Padd8 relative" id="inner_replies'.$a->id.'">
                            '.$this->GetReplies($a->id).'
                        </div>
                    </div>
                </div>
                <div align="center" style="flex: 0.8;" class="style_more_border-tools">'.$more_tools.'</div>
                </div>
            </div>';
        }
        $data .= '<div class="BlockForMob _MARtop">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- Mobile -->
        <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-9877420063334339"
        data-ad-slot="6100405738"
        data-ad-format="horizontal"
        data-full-width-responsive="false"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>';
        return $data;
    }

    public function GetReplies($answer_id){
        $data = '';
        foreach ($this->_db->get('replies',array('answer_id','=',$answer_id,'AND','disabled','=',0),null,'ASC')->results() as $r) {
            $user = new user($r->user_id);
            $mini_bg = '';
            if (session_exists('user')) {
                if ($this->_user->data()->id == $user->data()->id) {
                    $mini_bg .= '
                    <div id="_mini_bg_rep'.$r->id.'" class="_mini_bg_rep" style="display: none;">
                        <span class="textsInminiG _RedText" onclick="DeleteReply('.$r->id.')">'.DELETE_.'</span>
                    </div>';
                }else{
                    if ($this->isReportedReply($r->id,$this->_user->data()->id)) {
                        $reporting = '<span class="textsInminiGNona">'.REPORTED.'</span>';
                    }else{
                        $reporting = '<span class="textsInminiG" onclick="ReportReply(this,'.$r->id.')">'.REPORT.'</span>';
                    }
                    $mini_bg .= '
                    <div id="_mini_bg_rep'.$r->id.'" class="_mini_bg_rep" style="display: none;">
                        '.$reporting.'
                    </div>';
                }
            }
            $i_bg = (session_exists('user')) ? '<i class="more_butt_edit" onclick="ShowBGRe('.$r->id.')"></i>' : '' ;
            $data .= '
            <div class="relative" id="relative_reply'.$r->id.'">
                <a href="/'.$user->data()->username.'" class="href-rep-name">'.$user->data()->name.'</a>
                <div '.IsArabic($r->content).' style="border-left: 4px solid '.actions::RandColors().';" class="replied_text">'.actions::ContentText($r->content).'</div>
                '.$i_bg.'
                '.$mini_bg.'
            </div>
            ';
        }
        return $data;
    }

    public function GetTheReply($reply_id,$answer_id,$newing=null){
        $data = '';
        $this->_actions->GetData('replies',array('id','=',$reply_id,'AND','answer_id','=',$answer_id));
        $get = $this->_actions->data();

        $user = new user($get->user_id);

        $mini_bg = '';
        if (session_exists('user')) {
            if ($this->_user->data()->id == $user->data()->id) {
                $mini_bg .= '
                <div id="_mini_bg_rep'.$get->id.'" class="_mini_bg_rep" style="display: none;">
                    <span class="textsInminiG _RedText" onclick="DeleteReply('.$get->id.')">'.DELETE_.'</span>
                </div>';
            }else{
                if ($this->isReportedReply($reply_id,$this->_user->data()->id)) {
                    $reporting = '<span class="textsInminiGNona">'.REPORTED.'</span>';
                }else{
                    $reporting = '<span class="textsInminiG" onclick="ReportReply(this,'.$get->id.')">'.REPORT.'</span>';
                }
                $mini_bg .= '
                <div id="_mini_bg_rep'.$get->id.'" class="_mini_bg_rep" style="display: none;">
                    '.$reporting.'
                </div>';
            }
        }
        $i_bg = (session_exists('user')) ? '<i class="more_butt_edit" onclick="ShowBGRe('.$get->id.')"></i>' : 'b' ;
        $data .= '
        <div class="relative" style="'.$newing.'" id="relative_reply'.$reply_id.'">
            <a href="/'.$user->data()->username.'" class="href-rep-name">'.$user->data()->name.'</a>
            <div '.IsArabic($get->content).' style="border-left: 4px solid '.actions::RandColors().';" class="replied_text">'.actions::ContentText($get->content).'</div>
            '.$i_bg.'
            '.$mini_bg.'
        </div>
        ';
        
        return $data;
    }

    public function GetTags($tags){
        $data = '';
        foreach (explode(',', $tags) as $t) {
            foreach ($this->_db->get('category_tags',array('id','=',$t))->results() as $m) {
                $data .= '<span class="_span_tags-que">'.$m->name.'</span>';
            }
        }
        return $data;
    }

    public function GetBoxes($boxes){
        $data = '';
        $boxe_s = (substr($boxes, -1) == ",") ? substr($boxes, 0, strlen($boxes) - 1) : $boxes ;
        foreach (explode(',', $boxe_s) as $t) {
            foreach ($this->_db->get('code_boxes',array('id','=',$t))->results() as $m) {
                $data .= actions::Code($m->lang,$m->id,$m->code);
            }
        }
        return $data;
    }

    public function GetImages($images,$q_a){
        $data = '';
        $images_ = array_filter(ConfigArray(explode("|", $images)));
        foreach ($images_ as $t) {
            $im = 'https://programnas.com/control/'.$q_a.'pictures/'.$t;
            $image = (Is404($im)) ? 'https://programnas.com/control/template/media/jpg/404_imgs.JPG' : $im ;
            $data .= '<img onclick="ShowOmageQueVie(this)" class="bg_img_que_view _Mar4LeftRight _MARtop _MARbot" src="'.$image.'">';
        }
        return $data;
    }

    public function GetViews($question_id){
        return OrgViews($this->_db->get('question_views',array('question_id','=',$question_id))->count());
    }

    public function CountAnswers($question_id){
        return $this->_db->get('answers',array('question_id','=',$question_id))->count();
    }

    public function InsertViews(){
        if ($this->_db->get('question_views',array('question_id','=',$this->data()->id,'AND','user_ip','=',prespe::GetUserIP()))->count() == 0) {
            $this->_db->insert(
                'question_views',
                array(
                    'question_id' => $this->data()->id,
                    'user_ip' => prespe::GetUserIP()
                )
            );
        }
    }

    public function InsertLastSessionIDCookie(){
        cookies_put('last-q-id',$this->data()->id,config_get('remember/cookie_expiry'));
    }

    public function isDisabled(){
        return ($this->data()->disabled == 1) ? true : false ;
    }

    public function isReportedReply($reply_id,$user_id){
        return (actions::Count('reported_replies',array('reply_id','=',$reply_id,'AND','user_id','=',$user_id)) > 0) ? true : false ;
    }

    public function isChecked($question_id){
        return (actions::Count('answers',array('question_id','=',$question_id,'AND','verified','=',1)) > 0) ? true : false ;
    }

    public function CountVotes($answer_id){
        return actions::Count('user_votes', array('answer_id','=',$answer_id));
    }

    public function isVoted($answer_id){
        return (actions::Count('user_votes', array('answer_id','=',$answer_id,'AND','user_id','=',$this->_user->data()->id)) > 0) ? true : false ;
    }


}

?>