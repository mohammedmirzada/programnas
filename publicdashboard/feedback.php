<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$actions = new actions();

$id = input_get('id');

if(input_get('method') == "delete"){
	$db->delete('feedback',array('id','=',$id));
	redirect_to('https://programnas.com/publicdashboard/feedback');
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
				<h1 class="page-header">Chat Feedback</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="_table_tt">
								<tr>
									<th class="_th_table"><b>User Agent</b></th>
									<th class="_th_table"><b>User IP</b></th>
									<th class="_th_table"><b>Content</b></th>
									<th class="_th_table"><b>Date</b></th>
									<th class="_th_table"><b>Action</b></th>
								</tr>
								<?php
								$data = '';
								$total_rows = $db->get('feedback',array('id','>',0))->count();
								if($total_rows > 0){
									$results_per_page = 13;
									$number_of_pages = ceil($total_rows/$results_per_page);
									if (!isset($_GET['p'])) {
										$p = 1;
									} else {
										$p = input_get('p');
									}
									$this_page_first_result = ($p-1)*$results_per_page;
									foreach ($db->get('feedback', array('id','>',0),$this_page_first_result.','.$results_per_page)->results() as $m) {
										$data .= '<tr class="_tr_table">
											<td class="_td_table">'.$m->user_agent.'</td>
											<td class="_td_table">'.$m->user_ip.'</td>
											<td class="_td_table">'.$m->content.'...</td>
											<td class="_td_table">'.ConvertSpecial($m->date).'</td>
											<td class="_td_table"><div><a href="https://programnas.com/publicdashboard/feedback?method=delete&id='.$m->id.'" class="_cursor" style="color:#bf2b2b;">Delete</a></div></td>
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