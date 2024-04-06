<?php
if (session_exists('user')) {
	$notifications = new notifications();
	$coun_N = $notifications->CountNotifications();
	$count_notifications = ($coun_N == 0) ? '' : $coun_N ;
	$lastN_id = $notifications->GetLastNotificationsID();
}else{
	$coun_N = '';
}
?>
<header class="_fixed_header">
	<div class="border-then-header">
		<div class="_White">
			<div class="_Padd8">
				<div class="_fix_max_header">
					<div class="_InlineFlex _Width100" id="Logo_ID">
						<div>
							<a href="/" class="_LogoHeader relative"></a>
						</div>
						<!-- Search, Signin and Signup -->
						<div id="HideListSS" class="_InlineFlex" style="flex:1;position: relative;top: 2px;">
							<div style="flex: 3;" align="center" class="relative _InlineFlex _Width100">
								<div style="flex: 3;">
									<a href="/questions" class="_class_href_question"><?=QUESTIONS?></a>
								</div>
								<?php if (!isMobile()) { ?>
								<div style="flex: 12;">
									<i class="iconFind" onclick="Search(ge('id_seac_vl'))"></i> 
									<input id="id_seac_vl" onkeyup="Search(this)" onclick="show('box-contents-ID')" type="text" name="" placeholder="<?=FIND_?>" class="find_search_header">
									<div class="_None" id="box-contents-ID">
										<div class="box-finding-content">
											<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/temp/search.php"; ?>	
										</div>
									</div>
								</div>
							    <?php } ?>
							</div>
							<?php if (!isMobile()) { ?>
							<div class="_InlineFlex" style="flex: 1;" align="center">
								<?php if(!session_exists('user')){ ?>
									<a href="/signin" class="_FinlinedoSScorner hoverThisSignin"><?=SIGN_IN?></a>
									<a href="/signup" class="_FinlinedoSScorner _Radius6 _WhiteText _DarkBlueHH _transition"><?=SIGNIP?></a>
							    <?php }else{ ?>
							    	<span class="_icons notify-icon-header relative" onclick="show('box-notify');GetNotifications();">
							    		<span class="notify-number-header" id="change_num_noti"><?=$count_notifications?></span>
							    		<?php
							    		if (empty($lastN_id)) {
							    			echo('<input type="hidden" id="last-notify-id" value="">');
							    		}else{
							    			echo('<input type="hidden" id="last-notify-id" value="'.$lastN_id.'">');
							    		}
							    		?>
							    	</span>
							    	<div class="div-clickabel" onclick="show('box-drop-prof-tools')">
							    		<span class="prof-header-pic" style="background-image: url(<?=$user->ImageIcon()?>);"></span>
							    	</div>
							    	<div class="_None" id="box-drop-prof-tools">
										<a href="/<?=$user->data()->username?>" class="href-prof-tools _FiveText"><?=PROFILE?></a>
										<a href="/settings" class="href-prof-tools _FiveText"><?=SETTINGS?></a>
										<a href="/logout" class="href-prof-tools _RedText"><?=LOGOUT?></a>
									</div>
									<div class="_None" id="box-notify" align="left">
										<div id="notifications_content_id">
											<?=actions::ProgressBar('pb_show_cont_notifi',true)?>
										</div>
									</div>
							    <?php } ?>
							</div>
						    <?php } ?>
						</div>
						<!-- Menu for mobile -->
						<div id="MobileMenu" class="_gotoleftMobIth">
							<div>
								<span class="_Right _icons menu_icon" onclick="show('SH_mobHE');"></span>
								<span class="_Right _icons _searchIcon" onclick="ShowSearchBarMenu()"></span>
								<?php if(session_exists('user')){ ?>
								<span class="_Right _icons _notifyIcon" onclick="show('box-notify-mob');GetNotifications();">
									<span class="notify-number-header-mob" id="change_num_noti"><?=$count_notifications?></span>
									<?php
									if (empty($lastN_id)) {
										echo('<input type="hidden" id="last-notify-id" value="">');
									}else{
										echo('<input type="hidden" id="last-notify-id" value="'.$lastN_id.'">');
									}
									?>
								</span>
								<div class="_None" id="box-notify-mob">
									<div id="notifications_content_id">
										<?=actions::ProgressBar('pb_show_cont_notifi',true)?>
									</div>
								</div>
								<?php } ?>
							</div>
						</div> 
					</div>
					<!-- This Search is for mobile -->
					<div class="_None _Width100" id="Search_ID">
						<div style="flex: 1;" class="_icons close_icon_menu_" onclick="HideSearchBarMenu()"></div>
						<div style="flex: 8;" class="relative">
							<i class="iconFind"></i> 
							<input id="search_input_ID" onkeyup="Search(this)" onclick="show('box-contents-mob-ID')" type="text" name="" placeholder="<?=FIND_?>" class="find_search_header_mobile">
							<div class="_None" id="box-contents-mob-ID">
								<div class="box-finding-content">
									<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/temp/search.php"; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="_None" id="SH_mobHE">
	<div class="bg_menu_mobOpen">
		<div class="_InlineFlex _Height100 _Width100" style="flex-direction: column;">
			<div style="flex: 5;border-bottom: 1px solid #ddd;" class="_Grid">
				<?php if(!session_exists('user')){ ?>
				    <a href="/signup" class="_href_mob_menu_s_s_ _DarkBlueHH _WhiteText"><?=SIGNIP?></a>
				    <a href="/signin" class="_href_mob_menu_s_s_ _fontWeight"><?=SIGNIN?></a>
			    <?php }else{ ?>
			    	<div align="center" class="_MARtop6">
			    		<span class="prof-header-pic" style="background-image: url(<?=$user->ImageIcon()?>);"></span>
			    		<a href="/<?=$user->data()->username?>" class="href-prof-tools _FiveText"><?=PROFILE?></a>
					    <a href="/settings" class="href-prof-tools _FiveText"><?=SETTINGS?></a>
					    <a href="/logout" class="href-prof-tools _RedText"><?=LOGOUT?></a>
			    	</div>

			    <?php } ?>
			</div>
			<div style="flex: 30;" align="<?=ALIGN_ATTR?>">
				<div class="_fontWeight _SevenText _Padd8 _font14"><u><?=MENU?></u></div>
				<a href="/questions" class="bar_menu_vuttons_mob"><?=QUESTIONS?></a>
			</div>
		</div>
	</div>
</div>