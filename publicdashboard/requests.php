<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$actions = new actions();

$id = input_get('id');

if (input_get('submit') == "accept") {
	$user_id = input_get('user_id');
	$actions->GetData('verify_requests', array('id','=',$id));
	$db->change('users', $user_id, array('document_id' => $actions->data()->document, 'verified' => 1));
	$user = new user($user_id);
	$mail = new email($user->data()->email);
	$mail->AccountVerified($user->data()->name);
	$db->delete('verify_requests', array('id','=',$id));
	redirect_to('/publicdashboard/requests');
}elseif (input_get('submit') == "reject") {
	$user_id = input_get('user_id');
	$user = new user($user_id);
	$mail = new email($user->data()->email);
	$mail->AccountNotVerified();
	$db->delete('verify_requests', array('id','=',$id));
	redirect_to('/publicdashboard/requests');
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
				<h1 class="page-header">Verify Requests</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="_table_tt">
								<tr>
									<th class="_th_table"><b>Account</b></th>
									<th class="_th_table"><b>Document</b></th>
									<th class="_th_table"><b>Date</b></th>
									<th class="_th_table"><b>Actions</b></th>
								</tr>
								<?php
								$data = '';
								$total_rows = $db->get('verify_requests',array('id','>',0))->count();
								if($total_rows > 0){
									$results_per_page = 13;
									$number_of_pages = ceil($total_rows/$results_per_page);
									if (!isset($_GET['p'])) {
										$p = 1;
									} else {
										$p = input_get('p');
									}
									$this_page_first_result = ($p-1)*$results_per_page;
									foreach ($db->get('verify_requests', array('id','>',0),$this_page_first_result.','.$results_per_page)->results() as $m) {
										$user = new user($m->user_id);
										$data .= '<tr style="'.$disabled.'" class="_tr_table">
											<td class="_td_table"><a href="https://programnas.com/'.$user->data()->username.'" class="_cursor">'.$user->data()->username.'</a></td>
											<td class="_td_table"><a target="_blank" href="'.$m->document.'" class="_cursor">Image</a></td>
											<td class="_td_table">'.$m->date.'</td>
											<td class="_td_table"><div><a href="https://programnas.com/publicdashboard/requests?submit=accept&id='.$m->id.'&user_id='.$m->user_id.'" style="color: #49ab21;" class="_cursor">Accept</a></div><div><a href="https://programnas.com/publicdashboard/requests?submit=reject&id='.$m->id.'&user_id='.$m->user_id.'" class="_cursor" style="color: #ab2121;">Reject</a></div></td>
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