<div class="max-fix-ask <?=RTL_CLASS?>">

	<h2 class="_FiveText _Padd8 ">
		<?=UPDATE__Q?> <span style="border-bottom: 2px solid #2baebf;"><?=$data->title?></span>
    </h2>

	<div class="_InlineFlex _Width100" id="mob_column_and_rev">

		<div style="flex: 3;" class="bgadk-lines_">
			<form method="POST" class="relative">

				<textarea id="area_content_typing" dir="auto" class="_inparea_ _resizeArea" style="height: 250px;" placeholder="<?=__Content__?>"></textarea>
				<span class="_Right _font12 _SevenText _MARbot"><span id="text_count">0</span>/9000</span>

				<div align="right">
				    <button type="button" class="share_butt" onclick="UpdateQuestion()"><?=__UPDATE__?></button>
				</div>

				<div align="center"><?=actions::ProgressBar('pb_share')?></div>
				<input type="hidden" name="token" value="<?=$token?>">
				
			</form>

		</div>

		<div style="flex: 1;height: fit-content;" class="bgadk-lines_" id="guides_id" align="<?=ALIGN_ATTR?>">
			<h3 class="_guide-aski"><?=NOTE?></h3>
			<div align="<?=ALIGN_ATTR?>" class="<?=RTL_CLASS?>" style="white-space: pre-line;"><?=NOTE_TEXT?></div>
		</div>

	</div>

</div>