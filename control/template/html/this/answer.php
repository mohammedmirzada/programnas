<div class="relative _border_asnwers_q_a">
	<label for="js_jq">
		<span class="p_icon_askit" style="background-image: url(/control/template/media/svg/photo.svg);"></span>
		<input type="file" onchange="UploadPicAnswer()" id="js_jq" name="image" accept="image/*" multiple class="_None">
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
	<span class="_Right _font12 _SevenText _MARbot"><span id="text_count">0</span>/1500</span>
	<!-- Code Box END --><div class="relative" id="inner_code_box"></div>
	<div><div><div><div><div><input type="hidden" id="imgs" value=""></div></div></div></div></div>
	<div><div><div><div><div><input type="hidden" id="_boxes" value="0"></div></div></div></div></div>
	<div>
		<button type="button" class="share_butt" onclick="Answer()"><?=ANSWER?></button>
	</div>
	<div align="center"><?=actions::ProgressBar('pb_share')?></div>
</div>