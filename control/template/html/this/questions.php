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

<div class="_Padd8">
	<div class="_InlineFlex _Width100">
		<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/left.php"; ?>
		<div style="flex: 2;width: 50%;" class="_fix-borders">
			<div class="_InlineFlex _Width100 _Padd8 _fix-borders">
				<div style="flex: 20;"><h1 style="margin: 0;font-weight: 100;" class="_FiveText"><span class="que-count-text"><?=$questions->Count()?></span> <?=QUESTIONS?></h1></div>
				<div style="flex: 5;">
					<a href="/questions/ask" class="ask-butt-que"><?=ASK__?></a>
				</div>
			</div>
			<div class="_Padd8" style="border-bottom: 1px solid #ddd;">
				<div class="_font18">
				    <span id="filter-newest" class="filter-org-d" style="background-color: #0000000d;" onclick="Newest(this)"><?=ALL_NEWEST?></span>
				    <span id="filter-unanswered" class="filter-org-d" onclick="Unanswered(this)"><?=UNANSWERED?></span>
				    <span id="filter-tags" class="filter-org-d" onclick="Tags(this)"><?=TAGS__?></span>
			    </div>
				<div class="_None" id="tags-showing">
					<?php
					$data = '';
					foreach ($db->get('category_tags',array('id','>',"0"))->results() as $d) {
						$data .= '<span id="tags_'.$d->id.'" class="_span_tags-que _cursor _span_tags-que-hover" onclick="SelectTag(this)">'.$d->name.'</span>';
					}
					?>
					<div class="box-tags-search-que">
						<input type="text" placeholder="Find tags..." class="_span_tags-que" style="background-color: white;" onkeyup="FindTagsQuestions(this)">
						<div id="tags_inner_place_found" class="_found_tags" style="display: none;"></div>
						<?=$data?>
					</div>
					<input type="hidden" id="tag_list" value="">
				</div>
			</div>
			<div class="_Padd8">
				<div align="center"><?=actions::ProgressBar('pb_load_que',true)?></div>
				<div id="innser_new_que">
					<?php
					$parted = input_get("parted");
					switch (input_get("parted")) {
						case 'all':
						echo $questions->GetQuestions();
						break;
						case 'unanswered':
						echo $questions->GetQuestions(array('disabled','=',0,'AND','has_answer','=',0),"https://programnas.com/questions/?parted=unanswered&p=");
						break;
						case 'tags':
						$t = input_get("t");
						echo $questions->GetQuestions(array('disabled','=',0,'AND','tags','LIKE',"%$t%"),"https://programnas.com/questions/?parted=tags&t=".$t."&p=");
						break;
						default:
						echo $questions->GetQuestions();
						break;
					}
					?>
				</div>
			</div>
		</div>
		<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/this/right.php"; ?>
	</div>
</div>