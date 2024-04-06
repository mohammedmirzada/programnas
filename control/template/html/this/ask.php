<div class="max-fix-ask" style="padding-bottom: 250px;">

	<h2 class="_FiveText _Padd8">
		<a href="/help" class="ques_icon_askit"></a>
		Ask Question
    </h2>

	<div class="_InlineFlex _Width100" id="mob_column_and_rev">

		<div style="flex: 3;" class="bgadk-lines_">
			<form method="POST" class="relative">

				<input onkeyup="SimilarySearch(this)" type="text" id="_title_que" class="_inparea_" placeholder="<?=TITLE__?>" dir="auto">

				<div id="inner_similary" class="_None similary_bg_ask"></div>

				<label for="js_jq">
					<span class="p_icon_askit" style="background-image: url(/control/template/media/svg/photo.svg);"></span>
					<input type="file" onchange="UploadPicQuestion()" id="js_jq" name="image" accept="image/*" multiple class="_None">
				</label>
				<i onclick="show('input_box_selector')" class="p_icon_askit" style="background-image: url(/control/template/media/svg/coding.svg);"></i>
				<div id="ImageListUpload" class="_MARtop"></div>

				<!-- Code Box START -->
				<div class="_None" id="input_box_selector">
					<div class="_WhiteLitText" id="error_add_box"></div>
					<input class="inp_placehol_lang" type="text" id="lang_code" placeholder="<?=LANG_EX_JAVA?>">
					<button type="button" class="inp_placehol_lang _transition add-box-class_hover" onclick="AddBox()"><?=ADD__?></button>
				</div>
				<!-- Code Box END -->
				<textarea id="area_content_typing" dir="auto" class="_inparea_ _resizeArea" style="height: 250px;" placeholder="<?=__Content__?>"></textarea>
				<span class="_Right _font12 _SevenText _MARbot"><span id="text_count">0</span>/9000</span>
				<!-- Code Box END --><div class="relative" id="inner_code_box"></div>

				<div style="margin: 12px;">
					<input type="text" name="" placeholder="<?=FIND_TAGS_?>" class="input_tags <?=RTL_CLASS?>" onkeyup="TypeTags(this)">
					<div class="box-tags-search _None" id="box-tag-ID"></div>
					<div class="_Padd8 _None" id="add-tags-place"></div>
				</div>

				<div><div><div><div><div><input type="hidden" name="" id="imgs" value=""></div></div></div></div></div>
				<div><div><div><div><input type="hidden" id="tag_value" value=""></div></div></div></div>
				<div><div><div><div><div><input type="hidden" id="_boxes" value="0"></div></div></div></div></div>

				<div align="right">
				    <button type="button" class="share_butt" onclick="Ask()"><?=PUBLISH?></button>
				</div>

				<div align="center"><?=actions::ProgressBar('pb_share')?></div>

			</form>

		</div>

		<div style="flex: 1;height: fit-content;" class="bgadk-lines_" id="guides_id" align="<?=ALIGN_ATTR?>">
			<h3 class="_guide-aski"><?=QUCIK_GUIDES?></h3>
			<div align="<?=ALIGN_ATTR?>" class="<?=RTL_CLASS?>" style="white-space: pre-line;"><?=QUCIK_GUIDES_TEXT?></div>
		</div>

	</div>

</div>