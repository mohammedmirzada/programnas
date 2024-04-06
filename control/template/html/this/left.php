<div style="flex: 1;border-right: 1px solid #00000026;" align="right" class="_None NoneForMob">
	<div>
		<div>
			<a href="/questions" class="hre-left-menu-soc">
				<span class="_icons soc-cions-left" style="background-image: url(/control/template/media/svg/question.svg);"></span>
				    	<?=QUESTIONS?>
			</a>
			<a href="/library" class="hre-left-menu-soc">
				<span class="_icons soc-cions-left" style="background-image: url(/control/template/media/svg/library.svg);"></span>
				    	<?=LIBRARY?>
			</a>
			<?php if(session_exists('user')){ ?>
			<?php $uuu = new user(); ?>
			<a href="/<?=$uuu->data()->username?>" class="hre-left-menu-soc">
				<span class="_icons soc-cions-left" style="background-image: url(/control/template/media/svg/users.svg);"></span>
				        <?=PROFILE?>
			</a>
			<a href="/settings" class="hre-left-menu-soc">
				<span class="_icons soc-cions-left" style="background-image: url(/control/template/media/svg/settings.svg);"></span>
				        <?=SETTINGS?>
			</a>
				    <?php } ?>
		</div>
		<div align="right" class="div-this-line"></div>
		<div>
			<a href="/help" class="hre-left-menu-soc">
				<span class="_icons soc-cions-left" style="background-image: url(/control/template/media/svg/help.svg);"></span>
				        <?=HELP?>
			</a>
		</div>
		<div>
			<a href="/support" class="hre-left-menu-soc">
				<span class="_icons soc-cions-left" style="background-image: url(/control/template/media/svg/contact.svg);"></span>
				        <?=SUPPORT__?>
			</a>
		</div>
	</div>
	<div style="padding: 34px;">
		<ins class="adsbygoogle"
		style="display:block"
		data-ad-client="ca-pub-9877420063334339"
		data-ad-slot="6391710464"
		data-ad-format="vertical"
		data-full-width-responsive="false"></ins>
		<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
	</div>
</div>