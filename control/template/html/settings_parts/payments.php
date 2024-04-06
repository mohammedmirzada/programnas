<?php

$payment = new payment();

$error_fastpay = '';
$error_bitcoin = '';
$error_threshold = '';
$dis_one = '';
$dis_two = '';
$dis_three = '';

$add = input_get('add');

//ADD PAYMENT
if (input_get('token') == session_get('last_token')) {
	if ($add == "fastpay") {
		$phone_number = input_get('phone_number');
		if (ctype_digit($phone_number)) {
			if (substr($phone_number, 0, 5) != "00964") {
				$error_fastpay = FASTPAY_VAL;
				$dis_one = 'display: block;';
			}elseif (strlen($phone_number) < 9) {
				$error_fastpay = FASTPAY_VAL_TWO;
				$dis_one = 'display: block;';
			}elseif ($user->Payments() > 3) {
				$error_fastpay = FASTPAY_VAL_THREE;
				$dis_one = 'display: block;';
			}else{
				$db->insert('fastpay',array('user_id' => $user->data()->id, 'number' => $phone_number));
				redirect_to('/settings?part=payments');
			}
		}else{
			$error_fastpay = FASTPAY_VAL_TWO;
			$dis_one = 'display: block;';
		}
	}else if ($add == "bitcoin") {
		$hash = input_get('hash');
		if (validate::isBitcoin($hash)) {
			if ($user->Payments() > 3) {
				$error_bitcoin = PAYMENT_VAL_ONE;
				$dis_three = 'display: block;';
			}else{
				$db->insert('bitcoin',array('user_id' => $user->data()->id, 'hash' => $hash));
				redirect_to('/settings?part=payments');	
			}
		}else{
			$error_bitcoin = PAYMENT_VAL_TWO;
			$dis_three = 'display: block;';
		}
	}else if ($add == "threshold") {
		$threshold_value = input_get('threshold_value');
		if (empty($threshold_value)) {
			$error_threshold = PAYMENT_VAL_THREE;
		}elseif (!is_int((int)$threshold_value)) {
			$error_threshold = SOMETHING_WRONG;
		}elseif (strlen($threshold_value) > 4) {
			$error_threshold = SOMETHING_WRONG;
		}elseif ($threshold_value < 25) {
			$error_threshold = PAYMENT_VAL_FOUR;
		}elseif ($threshold_value > 1000) {
			$error_threshold = PAYMENT_VAL_FIVE;
		}else{
			if ($user->Payments() > 3) {
				$error_threshold = PAYMENT_VAL_ONE;
			}else{
				$db->change('users', $user->data()->id, array('threshold' => $threshold_value));
				redirect_to('/settings?part=payments');
			}
		}
	}
}

//DELETE PAYMENT
$delete = input_get('delete');
$payment_id = input_get('payment_id');

if (input_get('token') == session_get('last_token')) {
	if ($delete == "fastpay") {
		$db->delete('fastpay', array('user_id','=',$user->data()->id,'AND','id','=',$payment_id));
		if ($payment->isPrimary('fastpay',$payment_id)) {
			$db->change('users', $user->data()->id, array('primary_payment' => ''));
		}
		redirect_to('/settings?part=payments');
	}elseif($delete == "bitcoin"){
		$db->delete('bitcoin', array('user_id','=',$user->data()->id,'AND','id','=',$payment_id));
		if ($payment->isPrimary('fastpay',$payment_id)) {
			$db->change('bitcoin', $user->data()->id, array('primary_payment' => ''));
		}
		redirect_to('/settings?part=payments');
	}
}

//MAKE PRIMARY PAYMENT
$primary = input_get('primary');
$payment_id = input_get('payment_id');

if (input_get('token') == session_get('last_token')) {
	if ($primary == "fastpay") {
		$db->change('users', $user->data()->id, array('primary_payment' => $primary.'_'.$payment_id));
		redirect_to('/settings?part=payments');
	}elseif($primary == "bitcoin"){
		$db->change('users', $user->data()->id, array('primary_payment' => $primary.'_'.$payment_id));
		redirect_to('/settings?part=payments');
	}
}

$token = hash_make($_SERVER['SERVER_NAME'],uniqid(mt_rand(), true));
session_put('last_token',$token);

?>

<!-- ADD PAYMENT FORMS -->
<div class="_bg-payments _None <?=RTL_CLASS?>" style="<?=$dis_one?>" id="fastpay">
	<div class="_Padd8">
		<h3 class="_FiveText _Padd8"><?=ADD_FASTPAY?></h3>
		<div align="center" class="_RedText _Padd8"><?=$error_fastpay?></div>
		<form method="POST">
			<div class="_Padd8">
				<div class="_FiveText _fontWeight"><?=PH_N_ONLYIRAQI?></div>
			    <input type="text" name="phone_number" placeholder="009647501234567" class="_nput-text-seett" value="00964">
			    <div align="center">
			    	<input type="submit" name="save" value="<?=ADD__?>" class="save_changes_button">
			    	<span class="_FourText _font14 _cursor _Padd8LeftRight _OverName" onclick="hide('fastpay');"><?=CANCEL_?></span>
	            </div>
			</div>
			<input type="hidden" name="add" value="fastpay">
			<input type="hidden" name="token" value="<?=$token?>">
		</form>
	</div>
</div>
<div class="_bg-payments _None" style="<?=$dis_three?>" id="bitcoin">
	<div class="_Padd8">
		<h3 class="_FiveText _Padd8"><?=ADD_BITCOIN?></h3>
		<div align="center" class="_RedText _Padd8"><?=$error_bitcoin?></div>
		<form method="POST">
			<div class="_Padd8">
				<div class="_FiveText _fontWeight"><?=BITCOIN_HASH_?></div>
			    <input type="text" class="_nput-text-seett" name="hash">
			    <div align="center">
			    	<input type="submit" name="save" value="<?=ADD__?>" class="save_changes_button">
			    	<span class="_FourText _font14 _cursor _Padd8LeftRight _OverName" onclick="hide('bitcoin');"><?=CANCEL_?></span>
	            </div>
			</div>
			<input type="hidden" name="add" value="bitcoin">
			<input type="hidden" name="token" value="<?=$token?>">
		</form>
	</div>
</div>

<div class="_Padd8">
	<div class="_FiveText _fontWeight _InlineBlock"><?=YOUR_P_METHODS?></div>
	<a href="/help" style="left: 6px;top: 6px;" class="ques_icon_askit"></a>
	<div class="_MARtop" style="margin-bottom: 70px;">
		<?php
		$data = '';
		if ($user->Payments() > 0) {
			if (actions::Count('fastpay',array('user_id','=',$user->data()->id)) > 0) {
				foreach ($db->get('fastpay',array('user_id','=',$user->data()->id))->results() as $f) {
					if ($payment->isPrimary('fastpay',$f->id)) {
						$bg = 'border-top: 4px solid #458d18;';
						$primary = '';
					}else{
						$bg = '';
						$primary = '
						<form method="POST">
					        <input type="submit" class="m_primary_paymm_" value="'.MAKE_PRIMARY.'">
					        <input type="hidden" name="primary" value="fastpay">
					        <input type="hidden" name="payment_id" value="'.$f->id.'">
					        <input type="hidden" name="token" value="'.$token.'">
					    </form>';
					}
					$data .= '
					<button class="butt-list-payemnt" style="background-image: url(/control/template/media/png/fastpay.png);'.$bg.'">
					    <span class="text-info-payemnt">'.$f->number.'</span>
					    <form method="POST">
					        <input type="submit" class="deleete_paymm_" value="'.DELETE_.'">
					        <input type="hidden" name="delete" value="fastpay">
					        <input type="hidden" name="payment_id" value="'.$f->id.'">
					        <input type="hidden" name="token" value="'.$token.'">
					    </form>
					    '.$primary.'
					</button>';
				}
			}if (actions::Count('bitcoin',array('user_id','=',$user->data()->id)) > 0) {
				foreach ($db->get('bitcoin',array('user_id','=',$user->data()->id))->results() as $f) {
					if ($payment->isPrimary('bitcoin',$f->id)) {
						$bg = 'border-top: 4px solid #458d18;';
						$primary = '';
					}else{
						$bg = '';
						$primary = '
						<form method="POST">
					        <input type="submit" class="m_primary_paymm_" value="'.MAKE_PRIMARY.'">
					        <input type="hidden" name="primary" value="bitcoin">
					        <input type="hidden" name="payment_id" value="'.$f->id.'">
					        <input type="hidden" name="token" value="'.$token.'">
					    </form>';
					}
					$data .= '
					<button class="butt-list-payemnt" style="background-image: url(/control/template/media/png/bitcoin.png);'.$bg.'">
					    <span class="text-info-payemnt">'.$f->hash.'</span>
					    <form method="POST">
					        <input type="submit" class="deleete_paymm_" value="'.DELETE_.'">
					        <input type="hidden" name="delete" value="bitcoin">
					        <input type="hidden" name="payment_id" value="'.$f->id.'">
					        <input type="hidden" name="token" value="'.$token.'">
					    </form>
					    '.$primary.'
					</button>';
				}
			}
		}else{
			$data .= '<div align="center" class="empty_payment">'.PAY_METH_YET.'</div>';
		}
		echo $data;
		?>
	</div>
	<?php if ($user->Payments() < 3) { ?>
	<div class="_sett-border-bottom"></div>
	<div class="_FiveText _fontWeight"><?=SELECT_PAY_FORM?></div>
	<div class="_Padd8">
		<button onclick="AddPayment('fastpay')" class="butt-add-payemnt" style="background-image: url(/control/template/media/png/fastpay.png);"></button>
		<button onclick="AddPayment('bitcoin')" class="butt-add-payemnt" style="background-image: url(/control/template/media/png/bitcoin.png);"></button>
	</div>
	<?php } ?>
	<div class="_sett-border-bottom"></div>
	<div class="_FiveText _fontWeight"><?=PAYOUT_THRES?></div>
	<div class="_font12 _SevenText _Padd6"><?=PAID_MO_?>$<?=(empty($user->data()->threshold)) ? 100 : $user->data()->threshold?></div>
	<form method="POST">
		<div align="center" class="_RedText _Padd8"><?=$error_threshold?></div>
		$<input type="text" name="threshold_value" id="_value_threshold" value="<?=(empty($user->data()->threshold)) ? 100 : $user->data()->threshold?>" class="_nput-text-seett">
		<div align="center">
			<input type="submit" name="change" value="<?=CHANGE__?>" class="save_changes_button">
		</div>
		<input type="hidden" name="add" value="threshold">
		<input type="hidden" name="token" value="<?=$token?>">
    </form>
	<div class="_sett-border-bottom"></div>
	<div>
		<?=GET_PAID_INFO?>
	</div>
</div>