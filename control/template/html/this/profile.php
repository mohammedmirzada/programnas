<?php
if (session_exists('user')) { if (!$user->isConfirmed() && $isu) { ?>
	<div id="innerConfirmed <?=RTL_CLASS?>" align="center" style="background: #343c4112;">
	    <div class="not-confirmed" align="center">
		    <span><?=HASNT_CONFIRMED?></span>
		    <input type="text" id="the_c_code" class="inp-code-confirm" placeholder="<?=CONFIRMATION_CODE?>">
		    <button class="_butt_confirm_code" onclick="EnterConfirmationCode()"><?=SUBMIT?></button>
	    </div>
	    <div align="center">
		    <span class="_cursor _font14 _FiveText" onclick="SendConfirmationCode(this)"><u><?=SEND_SP_AGAIN?></u></span>
	    </div>
	</div>
	<div align="center">
		<?=actions::ProgressBar('pb_confirming_code',true)?>
	</div>
<?php }} ?>
<div class="_Padd8" style="padding-bottom: 200px;">
	<div class="fix-cent-prof">
		<div class="_Width100 _InlineFlex" id="_reverse_answer_coins">
			<div style="flex: 5;padding: 0;" class="bgadk-lines_">
				<div class="_BlackBG _Padd8" style="border-radius: 6px 6px 0px 0px;" align="center">
					<div class="_MARtop" align="center">
						<?php if ($isu) { ?>
							<a href="/settings" class="butt-href-prof"><?=SETTINGS?></a>
					    <?php } ?>
					</div>
					<span class="cup-score-intprof"></span>
					<span class="_WhiteText _TextShadow relative" style="top: -6px;"><?=SCORES?> <?=$user->Scores()?></span>
					<span style="background-image: url(<?=$user->ImageIcon()?>);" class="into-prof-pic"></span>
					<div class="_Padd8 _WhiteText _font22 _TextShadow  relative">
						<span><?=$user->data()->name?></span>
						<?php
						if ($user->isVerified()) {
							echo('<span onmouseout="hide(\'accont-supp-verf\')" onmouseover="show(\'accont-supp-verf\')" class="veriied-icon"></span><span class="_None" id="accont-supp-verf">'.VERIFIED.'</span>');
						}else{
							if ($isu) {
								echo('<a href="https://programnas.com/support/verify/" class="needs-veriy"><u>'.NEEDS_VERIFYING.'</u></a>');
							}
						}
						?>
					</div>
					<div class="_TextShadow _WhiteText">@<?=$user->data()->username?></div>
					<div class="_TextShadow _WhiteText"><?=JOINED_IN?> <?=ConvertYear($user->data()->joined)?></div>
				</div>
				<div class="_Padd8" align="center">
					<span class="ciricle-mini" style="background: #994087;"></span>
					<span style="color: #994087;"><?=ANSWERS?>: <?=$user->Answers()?></span>
					<span class="ciricle-mini" style="background: #543f95;"></span>
					<span style="color: #543f95;"><?=QUESTIONS?>: <?=$user->Questions()?></span>
				</div>
				<div class="_Padd8">
					<?php
					if (empty($user->data()->bio)) {
						if ($isu) {
							echo('<div class="bio-dic-text">');
							echo '<div align="center"><a href="/settings?part=profile" class="Int0-bio-prof">'.EDIT_BIO.'</a></div>';
							echo('</div>');
						}
					}else{
						echo('<div class="bio-dic-text">');
						echo(actions::ContentText($user->data()->bio, '-10px 0px -10px 0px'));
						echo('</div>');
					}
					?>
				</div>
				<div class="_Padd8 <?=RTL_CLASS?>" align="<?=ALIGN_ATTR?>">
					<div class="_MARtop _FiveText _fontWeight"><?=BIRTH?>: <span class="_SevenText"><?=($user->isPrivate()) ? PRIVATE_ACCOUNT : $user->data()->birthdate;?></span></div>
					<div class="_MARtop _FiveText _fontWeight"><?=GENDER?>: 
						<?php
						if (!$user->isPrivate()) {
							if (cookies_exists('lang') == "ku_central") {
								if ($user->data()->gender == "Male") {
									echo('<span class="_SevenText">نێر</span>');
								}elseif($user->data()->gender == "Female"){
									echo('<span class="_SevenText">مێ</span>');
								}else{
									echo('<span class="_SevenText">واى بە باش نەزانى بڵێت</span>');
								}
							}else{
								if ($user->data()->gender == "Male") {
									echo('<span class="_SevenText">Male</span>');
								}elseif($user->data()->gender == "Female"){
									echo('<span class="_SevenText">Female</span>');
								}else{
									echo('<span class="_SevenText">Preferred not to say</span>');
								}
							}
						}else{
							echo('<span class="_SevenText">'.PRIVATE_ACCOUNT.'</span>');
						}
						?>
					</div>
					<div class="_MARtop _FiveText _fontWeight"><?=COUNTRY___?>: <span class="_SevenText"><?=$user->data()->country?></span></div>
					<div class="_MARtop" align="center">
						<?php
						if (!empty($user->data()->facebook)) {
							echo '<a href="https://www.facebook.com/'.$user->data()->facebook.'" style="background-image: url(/control/template/media/svg/facebook.svg);" class="social_media_links" target="_blank"></a>';
						}if (!empty($user->data()->instagram)) {
							echo '<a href="https://www.instagram.com/'.$user->data()->instagram.'" style="background-image: url(/control/template/media/svg/instagram.svg);" class="social_media_links" target="_blank"></a>';
						}if (!empty($user->data()->twitter)) {
							echo '<a href="https://www.twitter.com/'.$user->data()->twitter.'" style="background-image: url(/control/template/media/svg/twitter.svg);" class="social_media_links" target="_blank"></a>';
						}if (!empty($user->data()->youtube)) {
							echo '<a href="https://www.youtube.com/'.$user->data()->youtube.'" style="background-image: url(/control/template/media/svg/youtube.svg);" class="social_media_links" target="_blank"></a>';
						}if (!empty($user->data()->linkedin)) {
							echo '<a href="https://www.linkedin.com/in/'.$user->data()->linkedin.'" style="background-image: url(/control/template/media/svg/linkedin.svg);" class="social_media_links" target="_blank"></a>';
						}
						?>
					</div>
				</div>
			</div>
			<?php
			$ans = '';
			$que = '';
			if (input_get('part') == "answers") {
				$ans = 'background: #343c41e8;';
				//call answers
			}else{
				$que = 'background: #343c41e8;';
				//call questions
			}
			?>
			<div style="flex: 10;padding: 0;" class="bgadk-lines_">
				<div class="_InlineFlex _Width100">
					<a style="flex: 1;<?=$que?>" class="_href_into_prof_menu" href="/<?=$user->data()->username?>?part=questions"><?=QUESTIONS?></a>
					<a style="flex: 1;<?=$ans?>" class="_href_into_prof_menu" href="/<?=$user->data()->username?>?part=answers"><?=ANSWERS?></a>
				</div>
				<div class="_Padd8">
					<?php
					if (input_get('part') == "answers") {
						echo $questions->GetProfileAnswers($user->data()->id,$user->data()->username);
					}else{
						echo $questions->GetProfileQuestions($user->data()->id);
					}
					?>
				</div>
			</div>
		</div>
		<?php if ($isu) { ?>
		<div style="margin: 0px 6px 0px 6px;" class="bgadk-lines_ <?=RTL_CLASS?>" align="<?=ALIGN_ATTR?>">
			<?php if (!$user->isVerified()) { ?>
				<div>
				    <h2 class="_FiveText"><?=STEPS_T_VERIFY?></h2>
			        <div class="_font14 _SevenText"><?=BEFORE_START_EARNING?></div>
			    </div>
			    <div class="_sett-border-bottom"></div>
		    <?php } ?>
			<h2 class="_FiveText"><?=YOUR_EARNINGS?></h2>
			<div class="_Width100 _InlineFlex _MARtop" id="column-multi-side">
				<div style="flex: 0.3;">
					<div class="bg-tran-balance_">
						<div class="_balance_text relative">
							<div class="_font14"><?=CURRENT_BALANCE?></div>
							<span>$</span><?=$payment->GetBalance()?>
							<a href="/settings?part=payments" class="butt-href-sett-pay"><?=PAYMENT_SETTINGS?></a>
						</div>
					</div>
				</div>
				<div style="flex: 0.7;">
					<div class="bg-tran-balance_ relative">
						<div class="transcations_title"><?=TRANSACTIONS?></div>
						<div class="trns-form-dates">
							<?php
							if ($payment->CountTransactions() > 0) {
								echo $payment->GetTransactions();
							}
							?>
							<div style="margin: 20px 8px 20px 8px; opacity: 0.5;">
								<?=P_P_C?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	    <?php } ?>
	</div>
</div>