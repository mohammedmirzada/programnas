<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();

if (input_get('method') == "delete_answers") {
	$db->delete('reported_answers', array('id','=',input_get('id')));
}elseif (input_get('method') == "delete_replies") {
	$db->delete('reported_replies', array('id','=',input_get('id')));
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
				<h1 class="page-header">Reports</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading"><?=ucfirst(input_get('type'))?></div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="_table_tt">
								<?php if(input_get('type') == "answers"){ ?>
									<tr>
										<th class="_th_table"><b>NO</b></th>
										<th class="_th_table"><b>User ID</b></th>
										<th class="_th_table"><b>Answer ID</b></th>
										<th class="_th_table"><b>Report Date</b></th>
										<th class="_th_table"><b>Action</b></th>
									</tr>
									<?php
									$data = '';
									$i = 1;
									foreach ($db->get('reported_answers', array('id','>',0))->results() as $m) {
										$data .= '<tr class="_tr_table">
										<td class="_td_table">'.$i++.'</td>
										<td class="_td_table">'.$m->user_id.'</td>
										<td class="_td_table">'.$m->answer_id.'</td>
										<td class="_td_table">'.ConvertSpecial($m->date).'</td>
										<td class="_td_table"><a href="https://programnas.com/publicdashboard/reports?type=answers&method=delete_answers&id='.$m->id.'" class="_cursor">Delete</a></td>
										</tr>';
									}
									echo($data);
									?>
								<?php }else{ ?>
									<tr>
										<th class="_th_table"><b>NO</b></th>
										<th class="_th_table"><b>User ID</b></th>
										<th class="_th_table"><b>Reply ID</b></th>
										<th class="_th_table"><b>Report Date</b></th>
										<th class="_th_table"><b>Action</b></th>
									</tr>
									<?php
									$data = '';
									$i = 1;
									foreach ($db->get('reported_replies', array('id','>',0))->results() as $m) {
										$data .= '<tr class="_tr_table">
										<td class="_td_table">'.$i++.'</td>
										<td class="_td_table">'.$m->user_id.'</td>
										<td class="_td_table">'.$m->reply_id.'</td>
										<td class="_td_table">'.ConvertSpecial($m->date).'</td>
										<td class="_td_table"><a href="https://programnas.com/publicdashboard/reports?type=replies&method=delete_replies&id='.$m->id.'" class="_cursor">Delete</a></td>
										</tr>';
									}
									echo($data);
									?>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>