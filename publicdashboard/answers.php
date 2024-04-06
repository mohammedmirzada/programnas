<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$actions = new actions();

$id = input_get('id');

if(input_get('method') == "disable"){
	$db->change('answers', $id, array('disabled' => 1));
	$db->delete('users_points',array('answer_id','=',$id));
	$actions->GetData('answers',array('id','=',$id));
	$db->change('questions', $actions->data()->question_id, array('checked' => 0));
	redirect_to('https://programnas.com/publicdashboard/answers');
}elseif(input_get('method') == "check"){
	$db->change('answers', $id, array('verified' => 1));
	$actions->GetData('answers',array('id','=',$id));
	$db->change('questions', $actions->data()->question_id, array('checked' => 1));
	$a = new actions();
	$a->GetData('answers', array('id','=',$id));
	$db->insert('users_points', array('question_id' => $actions->data()->id, 'answer_id' => $id, 'user_id' => $a->data()->user_id, 'user_agent' => 'pn', 'user_ip' => '127.0.0.1'));

	$aaa = new actions();
	$aaa->GetData('questions', array('id','=',$actions->data()->question_id));
	$uuu = new user($a->data()->user_id);
	$email = new email($uuu->data()->email);
	$email->CheckedAnswer('Programnas Team', $aaa->data()->title);

	redirect_to('https://programnas.com/publicdashboard/answers');
}

?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/admin_assets/meta.php"; ?>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/admin_assets/header.php"; ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Answers</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="canvas-wrapper">
							<div class="_Padd8">
								<input type="text" placeholder="Search For Answer/question ID ..." onkeyup="Search(this,'answers')" class="search_classs">
							</div>
							<div id="inner_html_search_items"></div>
							<table class="_table_tt">
								<tr>
									<th class="_th_table"><b>ID</b></th>
									<th class="_th_table"><b>User ID</b></th>
									<th class="_th_table"><b>Question ID</b></th>
									<th class="_th_table"><b>Reports</b></th>
									<th class="_th_table"><b>Date</b></th>
									<th class="_th_table"><b>Action</b></th>
								</tr>
								<?php
								$data = '';
								$total_rows = $db->get('answers',array('id','>',0))->count();
								if($total_rows > 0){
									$results_per_page = 13;
									$number_of_pages = ceil($total_rows/$results_per_page);
									if (!isset($_GET['p'])) {
										$p = 1;
									} else {
										$p = input_get('p');
									}
									$this_page_first_result = ($p-1)*$results_per_page;
									foreach ($db->get('answers', array('id','>',0),$this_page_first_result.','.$results_per_page)->results() as $m) {
										$disabled = ($m->disabled == 1) ? 'background: #fff0f0;' : '' ;
										$actions->GetData('questions', array('id','=',$m->question_id));
										$data .= '<tr style="'.$disabled.'" class="_tr_table">
											<td class="_td_table">'.$m->id.'</td>
											<td class="_td_table">'.$m->user_id.'</td>
											<td class="_td_table">'.$m->question_id.'</td>
											<td class="_td_table">'.actions::Count('reported_answers',array('answer_id','=',$m->id)).'</td>
											<td class="_td_table">'.ConvertSpecial($m->date).'</td>
											<td class="_td_table"><div><a href="https://programnas.com/publicdashboard/answers?method=disable&id='.$m->id.'" class="_cursor" style="color:#bf2b2b;">Disable</a></div><div><a href="https://programnas.com/questions/?id='.$m->question_id.'&q='.$actions->data()->title.'" class="_cursor" target="_blank">View</a></div><div><a href="https://programnas.com/publicdashboard/answers?method=check&id='.$m->id.'" class="_cursor" style="color:#6bc22c;">Check</a></div></td>
										</tr>';
									}
									$data .= '<div align="center" class="_MARbot"><div class="_page_nn_que">';
									for ($p=1;$p<=$number_of_pages;$p++) {
										if (input_get('p') == $p) {
											$data .= '<a class="href_Loadpages_que" style="background: #2b40651c;" href="?p=' . $p . '">' . $p . '</a> ';
										}elseif(empty(input_get('p'))){
											if ($p == 1) {
												$data .= '<a class="href_Loadpages_que" style="background: #2b40651c;" href="?p=' . $p . '">' . $p . '</a> ';
											}else{
												$data .= '<a class="href_Loadpages_que" href="?p=' . $p . '">' . $p . '</a> ';
											}
										}else{
											$data .= '<a class="href_Loadpages_que" href="?p=' . $p . '">' . $p . '</a> ';
										}
									}
									$data .= '</div></div>';
								}
								echo($data);
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>