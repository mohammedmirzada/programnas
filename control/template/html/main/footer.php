<?php if (!cookies_exists('cookies_warning')) { ?>
<div class="_fixed_footer_cookies" id="cookies_ID">
	<div align="center">
		<div class="_Padd14">
			<div class="_WhiteText relative">
				<div class="<?=RTL_CLASS?>"><?=COOKIES_WARN?></div>
				<span class="absolute _icons close_icon_menu_white_ _cursor" style="right: 0;top: -8px;" onclick="CloseCookies()"></span>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<footer align=<?=ALIGN_ATTR?>>
	<div class="fix-footer-p">
		<div class="fix-footer-p-two">
			<div class="_InlineFlex _Width100 _MARtop" id="column-mob-footer">
				<div class="flex-inline-vi">
					<a href="/" class="logo-footer"></a>
					<div class="_font14"><?=PN_C_.date('Y').ALL_R_RES?></div>
					<div class="_MARtop">
						<div class="_font14 _WhiteLitText"><b><?=MAIN_SECTIONS?></b></div>
						<div>
							<a class="href-footer-link" href="/questions"><?=QUESTIONS?></a>
							<a class="href-footer-link" href="/library"><?=LIBRARY?></a>
						</div>
					</div>
				</div>
				<div class="flex-inline-vi">
					<div class="_MARtop _font14 _WhiteLitText"><b><?=ACCEPT_PAY_ME?></b></div>
					<span class="payments-accpted"></span>
					<div class="_MARtop _font14 _WhiteLitText"><b><?=FOLLOW_US_HERE?></b></div>
					<div class="_MARtop">
						<a target="_blank" class="_line_help-href _Block" href="https://www.facebook.com/programnas"><?=FB?></a>
						<a target="_blank" class="_line_help-href _Block" href="https://www.instagram.com/programnas"><?=INSTA?></a>
						<a target="_blank" class="_line_help-href _Block" href="https://www.youtube.com/programnas"><?=YOUTUBE?></a>
						<a target="_blank" class="_line_help-href _Block" href="https://www.linkedin.com/in/mirzada/"><?=LINKEDIN?></a>
						<a target="_blank" class="_line_help-href _Block" href="https://github.com/mohammedmirzada"><?=GITHUB?></a>
					</div>
				</div>
				<div class="flex-inline-vi">
					<div class="_MARtop _font14 _WhiteLitText"><b><?=LANG____?></b></div>
					<div class="_MARtop">
						<a href="https://programnas.com/control/template/php/lang?lang=en&ref=<?=GetCurrentURL()?>" class="_lang_foot-press">English</a>
						<a href="https://programnas.com/control/template/php/lang?lang=ku_central&ref=<?=GetCurrentURL()?>" class="_lang_foot-press _dir_rtl">كوردی (ناوەندی)</a>
					</div>
					<div class="_MARtop _font14 _WhiteLitText"><b><?=LINE_SECTIONS?></b></div>
					<div class="_MARtop">
						<a class="_line_help-href" href="/about"><?=ABOUT__?></a>
						<a class="_line_help-href" href="/support"><?=SUPPORT?></a>
						<a class="_line_help-href" href="/help"><?=HELP?></a>
						<a class="_line_help-href" href="/terms"><?=TERMS?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>