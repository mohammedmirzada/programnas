<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$actions = new actions();

$id = input_get('id');

if(input_get('submit') == "delete_role"){
	$db->change('users', input_get('user_id'), array('permission' => ''));
	redirect_to('https://programnas.com/publicdashboard/admins');
}elseif(input_get('submit') == "Update Role"){
	$role = input_get('role');
	if ($role == "super" || $role == "review" || $role == "transactions" || $role == "reports" || $role == "library") {
		$db->change('users', input_get('user_id'), array('permission' => $role));
	}
	redirect_to('https://programnas.com/publicdashboard/admins');
}if(input_get('submit') == "Add"){
	$role = input_get('role');
	if ($role == "super" || $role == "review" || $role == "transactions" || $role == "reports" || $role == "library") {
		$ee = new user(input_get('username'));
		$db->change('users', $ee->data()->id, array('permission' => $role));
	}
	redirect_to('https://programnas.com/publicdashboard/admins');
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
				<h1 class="page-header">Dashboard Roles</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="canvas-wrapper">
							<div class="_Padd8">
								<pre>Manager: [super] Full-Control.
Review: [review] main, Reiview of all parts without admins.
Transactions: [transactions] main, Transactions Money.
Reports: [reports] main, Report Answers and Replies.
Library: [library] main, adding, updating and removing books.</pre>
							</div>
							<form method="POST" class="_Padd8">
								<input type="text" name="role" placeholder="Role">
								<input type="text" name="username" placeholder="username">
								<input type="submit" name="submit" value="Add">					
							</form>
							<table class="_table_tt">
								<tr>
									<th class="_th_table"><b>username</b></th>
									<th class="_th_table"><b>role</b></th>
									<th class="_th_table"><b>Actions</b></th>
								</tr>
								<?php
								$data = '';
								foreach ($db->get('users', array('permission','!=',''))->results() as $m) {
									$data .= '<tr class="_tr_table">
										<td class="_td_table">'.$m->username.'</td>
										<td class="_td_table">
											<form method="POST">
												<input type="text" name="role" value="'.$m->permission.'" placeholder="Role">
												<input type="submit" name="submit" value="Update Role">
												<input type="hidden" name="user_id" value="'.$m->id.'">
											</form>
										</td>
										<td class="_td_table"><div><a href="https://programnas.com/publicdashboard/admins?submit=delete_role&user_id='.$m->id.'" class="_cursor" style="color:#bf2b2b;">Delete Role</a></div></td>
									</tr>';
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