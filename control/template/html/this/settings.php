<?php $settings_part = input_get('part'); if (!isMobile()) {?>
	<?php
	$href_bg_profile = '';
	$href_bg_security = '';
	$href_bg_payments = '';
	$href_bg_recentlogins = '';
	if (empty($settings_part) || $settings_part == "profile") {
		$settings_part = "profile";
		$href_bg_profile = 'style="background: #5e9bd01f;"';
	}elseif ($settings_part == "security") {
		$href_bg_security = 'style="background: #5e9bd01f;"';
	}elseif ($settings_part == "payments") {
		$href_bg_payments = 'style="background: #5e9bd01f;"';
	}elseif ($settings_part == "recentlogins") {
		$href_bg_recentlogins = 'style="background: #5e9bd01f;"';
	}else{
		$settings_part = "profile";
		$href_bg_profile = 'style="background: #5e9bd01f;"';
	}
	?>
	<div class="fix-settings-max">
		<div class="bgadk-lines_" style="padding: 0;">
			<div class="_Width100 _InlineFlex">
				<div style="flex: 4;border-right: 1px solid #dddddd6e;" class="relative">
					<a href="/settings?part=profile" class="settings-hrefs" <?=$href_bg_profile?> >
						<i style="background-image: url(/control/template/media/svg/profile.svg);" class="class-sett-icons"></i> <?=PROFILE?>
					</a>
					<a href="/settings?part=security" class="settings-hrefs" <?=$href_bg_security?> >
						<i style="background-image: url(/control/template/media/svg/security.svg);" class="class-sett-icons"></i> <?=SECURITY?>
					</a>
					<a href="/settings?part=payments" class="settings-hrefs" <?=$href_bg_payments?> >
						<i style="background-image: url(/control/template/media/svg/payments.svg);" class="class-sett-icons"></i> <?=PAYMENTS?>
					</a>
					<a href="/settings?part=recentlogins" class="settings-hrefs" <?=$href_bg_recentlogins?> >
						<i style="background-image: url(/control/template/media/svg/recent.svg);" class="class-sett-icons"></i> <?=RECENT_LOGINS?>
					</a>
					<a href="/logout" class="href-sett-logout"><?=LOGOUT?></a>
				</div>
				<div style="flex: 10;" class="_Padd8">
					<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/settings_parts/".$settings_part.".php"; ?>
				</div>
			</div>
		</div>
	</div>
<?php } else {
	if (empty($settings_part)) { ?>
		<div class="bgadk-lines_" style="padding: 0;margin: 80px 10px 10px 10px;">
			<div style="flex: 4;border-right: 1px solid #dddddd6e;" class="relative">
				<a href="/settings?part=profile" class="settings-hrefs">
					<i style="background-image: url(/control/template/media/svg/profile.svg);" class="class-sett-icons"></i> <?=PROFILE?>
				</a>
				<a href="/settings?part=security" class="settings-hrefs">
					<i style="background-image: url(/control/template/media/svg/security.svg);" class="class-sett-icons"></i> <?=SECURITY?>
				</a>
				<a href="/settings?part=payments" class="settings-hrefs">
					<i style="background-image: url(/control/template/media/svg/payments.svg);" class="class-sett-icons"></i> <?=PAYMENTS?>
				</a>
				<a href="/settings?part=recentlogins" class="settings-hrefs">
					<i style="background-image: url(/control/template/media/svg/recent.svg);" class="class-sett-icons"></i> <?=RECENT_LOGINS?>
				</a>
				<a href="/logout" class="href-sett-logout"><?=LOGOUT?></a>
			</div>
		</div>
	<?php }else{
		if ($settings_part == "profile") {
			echo '<div class="_Padd8"><a href="/settings" style="color: #5d9ace;">'.SETTINGS_BACK.'</a>';
			include $_SERVER['DOCUMENT_ROOT']."/control/template/html/settings_parts/profile.php";
			echo '</div>';
		}elseif ($settings_part == "security") {
			echo '<div class="_Padd8"><a href="/settings" style="color: #5d9ace;">'.SETTINGS_BACK.'</a>';
			include $_SERVER['DOCUMENT_ROOT']."/control/template/html/settings_parts/security.php";
			echo '</div>';
		}elseif ($settings_part == "payments") {
			echo '<div class="_Padd8"><a href="/settings" style="color: #5d9ace;">'.SETTINGS_BACK.'</a>';
			include $_SERVER['DOCUMENT_ROOT']."/control/template/html/settings_parts/payments.php";
			echo '</div>';
		}elseif ($settings_part == "recentlogins") {
			echo '<div class="_Padd8"><a href="/settings" style="color: #5d9ace;">'.SETTINGS_BACK.'</a>';
			include $_SERVER['DOCUMENT_ROOT']."/control/template/html/settings_parts/recentlogins.php";
			echo '</div>';
		}else{
			echo '<div class="_Padd8"><a href="/settings" style="color: #5d9ace;">'.SETTINGS_BACK.'</a>';
			include $_SERVER['DOCUMENT_ROOT']."/control/template/html/settings_parts/profile.php";
			echo '</div>';
		}
	}
}?>