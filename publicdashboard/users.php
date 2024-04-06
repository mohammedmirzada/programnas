<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$actions = new actions();

$id = input_get('id');

if(input_get('submit') == "Change Name"){
	$db->change('users', $id, array('name' => input_get('name')));
	redirect_to('https://programnas.com/publicdashboard/users');
}elseif(input_get('submit') == "Deactive Account"){
	$db->change('users', $id, array('deactive' => 1));
	redirect_to('https://programnas.com/publicdashboard/users');
}elseif(input_get('submit') == "Suspend Account"){
	$db->change('users', $id, array('suspended' => 1));
	redirect_to('https://programnas.com/publicdashboard/users');
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
				<h1 class="page-header">Users</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="canvas-wrapper">
							<?php if(input_get('method') != "edit"){ ?>
							<div class="_Padd8">
								<input type="text" placeholder="Search for users, type their ID/name/username ..." onkeyup="Search(this,'users')" class="search_classs">
							</div>
							<div id="inner_html_search_items"></div>
							<table class="_table_tt">
								<tr>
									<th class="_th_table"><b>ID</b></th>
									<th class="_th_table"><b>username</b></th>
									<th class="_th_table"><b>Email Confirmed</b></th>
									<th class="_th_table"><b>Verfied</b></th>
									<th class="_th_table"><b>Suspended</b></th>
									<th class="_th_table"><b>Deactive</b></th>
									<th class="_th_table"><b>Support Code</b></th>
									<th class="_th_table"><b>Joined</b></th>
									<th class="_th_table"><b>Action</b></th>
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

										$confirmed = ($m->confirmed == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';
										$verfied = ($m->verified == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';
										$suspended = ($m->suspended == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';
										$deactive = ($m->deactive == 1) ? '<span style="color:#48bf2b;">Yes</span>' : '<span style="color:#bf2b2b;">No</span>';

										$data .= '<tr class="_tr_table">
											<td class="_td_table">'.$m->id.'</td>
											<td class="_td_table"><a target="_blank" href="https://programnas.com/'.$m->username.'" class="_cursor">'.$m->username.'</a></td>
											<td class="_td_table">'.$confirmed.'</td>
											<td class="_td_table">'.$verfied.'</td>
											<td class="_td_table">'.$suspended.'</td>
											<td class="_td_table">'.$deactive.'</td>
											<td class="_td_table">'.$m->support_code.'</td>
											<td class="_td_table">'.$m->joined.'</td>
											<td class="_td_table"><a href="https://programnas.com/publicdashboard/users?method=edit&id='.$m->id.'" class="_cursor">Edit</a></td>
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
							<?php }else{ ?>
								<?php 
								$user = new user($id);
								?>
								<form method="POST">
									<input type="text" name="name" placeholder="Name" value="<?=$user->data()->name?>" class="input_classss">
									<input type="submit" name="submit" value="Change Name" class="button_save"><br>
									<input type="submit" name="submit" value="Deactive Account" class="class_ddleting_robot"><br>
									<input type="submit" name="submit" value="Suspend Account" class="class_ddleting_robot"><br>
								</form>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>