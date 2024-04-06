<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
if (!session_exists('user')) {
	redirect_to("https://programnas.com/signin?ref=verify");
	die();
	exit();
}

$db = db::getInstance();
$user = new user();

?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
	<?=actions::IndexMeta()?>
</head>
<body>
<?php 

include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php";

if ($user->isVerified()) { ?>

	<div class="_Padd8">
		<div style="margin: 0 auto;max-width: 600px;" align="center">
			<div class="veriied-icon_support"></div>
			<div style="color: #555;font-size: 18px;padding: 12px;" class="<?=RTL_CLASS?>"><?=NOT_NEED_VERIFY?></div>
			<a href="/<?=$user->data()->username?>"> <u class="<?=RTL_CLASS?>"><?=CAN_G_T_PROF?></u> </a>
		</div>
	</div>

<?php
}elseif(actions::Count('verify_requests',array('user_id','=',$user->data()->id)) > 0){ ?>

	<div align="center" class="_FiveText _font20 <?=RTL_CLASS?>" style="padding-top: 20px;">
		<span style="border-left: 4px solid #d3b937;padding-left: 6px;"><?=VERIFY_IN_REVIEW?></span>
	</div>
	<div align="center" class="_MARtop">
		<a href="/<?=$user->data()->username?>"> <u class="<?=RTL_CLASS?>"><?=CAN_G_T_PROF?></u> </a>
	</div>

<?php
}else{ ?>

	<div class="_Padd8 <?=RTL_CLASS?>" align="ALIGN_ATTR">
		<div style="margin: 0 auto;max-width: 800px;">
			<div style="border: 1px solid #bfbfbf;border-radius: 8px;">
				<h3 align="center" class="_FiveText _Padd8"><?=VERIFY_YOUR_ACCOUNT?></h3>
				<div style="height: 1px;background: #0000001c;"></div>
				<?php
				if ($user->isConfirmed()) { ?>
					<div class="_Padd8" style="border-right: 6px solid #4e9536;">
						<div><?=EMAIL_ADDR_I_CO?></div>
					</div>
				<?php
				}else{ ?>
					<div class="_Padd8" style="border-right: 6px solid #deb352;">
						<div><?=HASNT_CONMIRMED_YET?></div>
					    <div class="_Padd8"><?=GO_TO_Y_PROF?></div>
					    <div class="_Padd8"><?=BELOW_WARN_E_SA?></div>
					    <div class="_Padd8"><?=OPEN_CONFIRMATI_FF?></div>
					</div>
				<?php
				}
				?>
				<div style="height: 1px;background: #0000001c;"></div>
				<div style="border-right: 6px solid #deb352;" class="_MARbot6">
					<div class="_Padd8"><?=WE_NEED_A_DOCUMENT?></div>
					<label for="js_jq">
						<span class="upload_doc"><?=UPLOAD?></span>
						<input type="file" id="js_jq" onchange="UploadDoc()" accept="image/*" class="_None">
						<span id="doc_name" style="line-break: anywhere;" class="_font12 _SevenText"></span>
						<?=actions::ProgressBar('pb_doc',true)?>
						<input type="hidden" id="image_doc" value="">
					</label>
					<div class="_Padd8"><?=ONLY_PIC?></div>
					<div class="_Padd8"><?=THE_PIC_M_READABLE?></div>
				</div>
			</div>
			<button class="sn-req_suppDOC" onclick="SendVerifyRequest()"><?=SEND_REQ?></button>
			<?=actions::ProgressBar('pb_send_request',true)?>
		</div>
	</div>

<?php
}

?>
</body>
</html>