<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$actions = new actions();

$id = input_get('id');

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
				<h1 class="page-header">Points</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="canvas-wrapper">
							<?php if(input_get('method') != "edit"){ ?>
							<table class="_table_tt">
								<tr>
									<th class="_th_table"><b>User ID</b></th>
									<th class="_th_table"><b>username</b></th>
									<th class="_th_table"><b>Answers</b></th>
									<th class="_th_table"><b>Points</b></th>
									<th class="_th_table"><b>Actions</b></th>
								</tr>
								<?php
								$data = '';
								$total_rows = $db->get('users',array('id','>',0))->count();
								if($total_rows > 0){
									$results_per_page = 13;
									$number_of_pages = ceil($total_rows/$results_per_page);
									if (!isset($_GET['p'])) {
										$p = 1;
									} else {
										$p = input_get('p');
									}
									$this_page_first_result = ($p-1)*$results_per_page;
									foreach ($db->get('users', array('id','>',0),$this_page_first_result.','.$results_per_page)->results() as $m) {
										$data .= '<tr style="'.$disabled.'" class="_tr_table">
											<td class="_td_table">'.$m->id.'</td>
											<td class="_td_table"><a target="_blank" href="https://programnas.com/'.$m->username.'" class="_cursor">'.$m->username.'</a></td>
											<td class="_td_table">'.actions::Count('answers',array('user_id','=',$m->id)).'</td>
											<td class="_td_table">'.actions::Count('users_points',array('user_id','=',$m->id)).'</td>
											<td class="_td_table"><a href="https://programnas.com/publicdashboard/points?method=edit&id='.$m->id.'" class="_cursor">More Details</a></td>
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
							<?php }else{
								$data = '<table class="_table_tt">
								<tr>
									<th class="_th_table"><b>Answer ID</b></th>
									<th class="_th_table"><b>User Agent</b></th>
									<th class="_th_table"><b>User IP</b></th>
									<th class="_th_table"><b>Question ID</b></th>
									<th class="_th_table"><b>Date</b></th>
								</tr>';
								if (actions::Count('answers', array('user_id','=',$id,'AND','verified','=',1)) > 0) {
									foreach ($db->get('answers', array('user_id','=',$id,'AND','verified','=',1))->results() as $m) {
										$actions->GetData('users_points', array('answer_id','=',$m->id));
										$data .= '
										<tr class="_tr_table">
											<td class="_td_table">'.$m->id.'</td>
											<td class="_td_table">'.$actions->data()->user_agent.'</td>
											<td class="_td_table">'.$actions->data()->user_ip.'</td>
											<td class="_td_table">'.$actions->data()->question_id.'</td>
											<td class="_td_table">'.$actions->data()->date.'</td>
										</tr>';
									}
								}
								echo('</table>'.$data);
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>