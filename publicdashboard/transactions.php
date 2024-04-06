<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$actions = new actions();
$payment = new payment();
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
				<h1 class="page-header">Transactions</h1>
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
									<th class="_th_table"><b>Payment Details</b></th>
									<th class="_th_table"><b>Amount</b></th>
									<th class="_th_table"><b>Status</b></th>
								</tr>
								<?php
								$data = '';
								foreach ($db->get('users', array('id','>',0))->results() as $m) {

									// IF THE USER ACCOUNT VERIFIED AND CONFIRMED EMAIL
									if ($m->verirfied == 1 && $m->confirmed == 1) {
										
										// IF THE PRIMARY PAYMENT WAS NOT EMPTY
										if (!empty($m->primary_payment)) {
											
											// IF THE PAYMENT ID WAS FOUND IN THE TABLE
											$payment_method = substr($m->primary_payment, 0, 7);
											$payment_id = substr($m->primary_payment, 8);
											$amount = $payment->GetBalance($m->id);

											if ($payment_method == "bitcoin") {
												if (actions::Count('bitcoin', array('id','=',$payment_id)) > 0) {

													//IF THE USER REACHED THE BALANCE IN BTC
													if ($amount >= $m->threshold) {

														$actions->GetData('bitcoin', array('id','=',$payment_id));

														$data .= '
														<tr class="_tr_table">
															<td class="_td_table">'.$m->username.'</td>
															<td class="_td_table">BTC Hash: '.$actions->data()->hash.'</td>
															<td class="_td_table">$'.$m->threshold.'</td>
														</tr>
														';
														//TO-DO: THEN WE CREATE A FORM FOR PENDING STATUS
														//TO-DO: SUBMIT THE FORM VALIDATION
														//TO-DO: WE CREATE A TRANSACTION INFORMATION IN THE TRANSACTION TABLE TO LET THE USERS KNOW ABOUT THEIR PAYMENT STATUS
														//TO-DO: FINALY WE SEND AN EMAIL TO USER ABOUT PENDING STATUS

														// ABOUT ANY PAYMENT STATUS USERS MUST KNOW ABOUT IT
														//IF THE PAYMENT PROCESSED ALL USER POINTS WILL BE DELETED

														//AFTER SENDING MONEY, ALL is_paid=0 WILL BE is_paid=1
													}
												}
											}elseif ($payment_method == "fastpay") {
												if (actions::Count('fastpay', array('id','=',$payment_id)) > 0) {
													
													//IF THE USER REACHED THE BALANCE IN FASTPAY
													if ($amount >= $m->threshold) {

														$actions->GetData('fastpay', array('id','=',$payment_id));

														$data .= '
														<tr class="_tr_table">
															<td class="_td_table">'.$m->username.'</td>
															<td class="_td_table">FastPay Account: '.$actions->data()->number.'</td>
															<td class="_td_table">$'.$m->threshold.'</td>
														</tr>
														';
														//TO-DO: THEN WE CREATE A FORM FOR PENDING STATUS
														//TO-DO: SUBMIT THE FORM VALIDATION
														//TO-DO: WE CREATE A TRANSACTION INFORMATION IN THE TRANSACTION TABLE TO LET THE USERS KNOW ABOUT THEIR PAYMENT STATUS
														//TO-DO: FINALY WE SEND AN EMAIL TO USER ABOUT PENDING STATUS

														// ABOUT ANY PAYMENT STATUS USERS MUST KNOW ABOUT IT
														//IF THE PAYMENT PROCESSED ALL USER POINTS WILL BE DELETED

														//AFTER SENDING MONEY, ALL is_paid=0 WILL BE is_paid=1
													}
												}
											}
										}
									}
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