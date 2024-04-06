<!-- ADS -->
<div class="BlockForMob">
	<div class="_Padd8" align="center">
		<?php
		$actions = new actions();
		echo $actions->GetBanner(MOB_BANNER);
		?>
	</div>
</div>
<!-- ADS -->

<?php

$questions->InsertViews();
$questions->InsertLastSessionIDCookie();

$answers_count = $questions->CountAnswers($questions->data()->id);
if ($answers_count == 0) {
	$counted_answer_text = '0 '.ANSWER;
    $style_answer = '_RedText';
}elseif ($answers_count == 1) {
    $counted_answer_text = '1 '.ANSWER;
    $style_answer = '_GreenText';
}else {
    $counted_answer_text = $answers_count.' '.ANSWER;
    $style_answer = '_GreenText';
}

echo actions::Toast(REPORTED);

?>

<input type="hidden" id="id_put_" value="<?=$questions->data()->id?>">
<div id="image_show_id" align="center"></div>
<div class="_Padd8" style="padding-bottom: 200px;">
	<div class="_InlineFlex _Width100">
		<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/left.php"; ?>
		<div style="flex: 2;width: 50%;" class="_fix-borders">
			<div class="_fix-borders">
				<div align="center">
			    	<a href="/questions/ask" class="_href_ask_into_que"><?=ASK__?></a>
			    </div>
				<a style="display: block;overflow: hidden;" class="_InlineBlock _Padd8 _hovering-ahrefQUe" href="/<?=$user->data()->username?>">
					<span class="img0civon-que" style="background-image: url(<?=$user->ImageIcon()?>);"></span>
					<span class="href-que-name"><?=$user->data()->name?></span>
					<span class="bett-line-span" style="top: -7px;"></span>
					<span <?=actions::Relative(-12)?> class="_font8 _SevenText <?=RTL_CLASS?>"><?=ASKED?> <?=time_elapsed_string($questions->data()->time)?></span>
			    </a>
			</div>
			<div style="background: #2b406508;padding: 16px;border: 1px solid #dddddd45;">
			<?php
			if (session_exists('user')) {
				if ($questions->data()->user_id == $you->data()->id && $questions->data()->updated == 0) {cookies_put('ur-last-que',$questions->data()->id,config_get('remember/cookie_expiry'));?>
					<a href="/questions/update/" class="update-que-user"><?=UPDATE_Y_QUE?></a>
			<?php	}
			}
			?>
			<h3 style="line-break: anywhere;" class="_Padd8 _FiveText" <?=IsArabic($title)?>><?=$title?></h3>
			<div>
				<span class="line-middle _SevenText"><i class="_Mar4LeftRight _icons view_que_"></i><?=$questions->GetViews($questions->data()->id)?></span>
                <span class="bett-line-span"></span>
                <span class="line-middle <?=$style_answer?>"><?=$counted_answer_text?></span>
			</div>
			<div style="text-align: start;overflow-wrap: anywhere;white-space: break-spaces;" <?=IsArabic(substr($questions->data()->content, 0, 10))?>>
				<?=actions::ContentText($questions->data()->content, '12px')?>
			</div>
			<div class="_breakWord _InlineBlock _Mar4LeftRight">
                <?=$questions->GetTags($questions->data()->tags)?>
            </div>
			<div>
				<?=$questions->GetBoxes($questions->data()->box_ids)?>
			</div>
			<div class="_MARtop _OverflowAuto _Flex horizScoll" align="center">
				<?=$questions->GetImages($questions->data()->image,'q')?>
			</div>
			<?php
			if ($questions->data()->updated == 1) { ?>
			    <div class="updated-text-ti">
				    <h3 style="border-bottom: 1px solid #c3c3c3;padding-bottom: 4px;"><?=UPDATED?></h3>
				    <div style="text-align: start;white-space: break-spaces;" <?=IsArabic(substr($questions->data()->updated_content, 0, 10))?>>
					    <?=actions::ContentText($questions->data()->updated_content, '12px')?>
				    </div>
				</div>
			<?php } ?>
			</div>
			<div class="_Padd8">
				<h2 class="h2_answers_header"><?=ANSWERS?></h2>
			</div>
			<div class="_Padd8">
				<?php if ($questions->CountAnswers($questions->data()->id) > 0) {
					echo $questions->GetAnswers();
				}else{ ?>
					<h3 align="center" class="_SevenText _Padd8 <?=RTL_CLASS?>"><?=THIS_Q_HN_ANSWER?></h3>
				<?php } ?>
			</div>
			<div class="_Padd8">
				<?php
				if (session_exists('user')) {
					if (actions::Count('answers',array('user_id','=',$you->data()->id,'AND','question_id','=',$questions->data()->id)) == 0) {
						if ($user->data()->id != $you->data()->id) {
							include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/answer.php";
						}
					}
				}
				?>
			</div>
		</div>
		<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/right.php"; ?>
	</div>
</div>