function Search(e) {
	if (e.value == "") {
		ge('inner_search__').innerHTML = '';
	}else{
		$.ajax({
			url: "/control/template/php/search/",
			data: "header="+Functions.GetHeaderRequest()+"&q="+e.value,
			beforeSend: function(res){
				show('pb_search_header');
			},
			success: function(json){
				if (typeof(json.data) != "undefined") {
					ge('inner_search__').innerHTML = json.data;
				}
				hide('pb_search_header');
			},
			error: function(res){}
		});
    }
}
function CloseCookies() {
	var d = new Date();
	d.setTime(d.getTime() + (365*24*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	document.cookie = "cookies_warning" + "=" + "1" + ";" + expires + ";path=/";
	hide('cookies_ID');
}
function ShowSearchBarMenu() {
	hide('Logo_ID');
	ge('Search_ID').style.display='inline-flex';
	ge('search_input_ID').focus();
	show('box-contents-mob-ID');
}
function HideSearchBarMenu() {
	ge('Logo_ID').style.display='inline-flex';
	hide('Search_ID');
	hide('box-contents-mob-ID');
}
$(document).mouseup(function(e) {
	var c_menu = $("#SH_mobHE");
	var c_box_items = $("#box-contents-ID");
	var c_box_mob_items = $("#box-contents-mob-ID");
	var c_box_drop_prof_tools = $("#box-drop-prof-tools");
	var c_box_notify = $("#box-notify");
	var c_box_notify_mob = $("#box-notify-mob");
	var c_input_box_selector = $("#input_box_selector");
	if (!c_menu.is(e.target) && c_menu.has(e.target).length === 0) {
		c_menu.hide();
	}if (!c_box_items.is(e.target) && c_box_items.has(e.target).length === 0) {
		c_box_items.hide();
	}if (!c_box_mob_items.is(e.target) && c_box_mob_items.has(e.target).length === 0) {
		c_box_mob_items.hide();
	}if (!c_box_drop_prof_tools.is(e.target) && c_box_drop_prof_tools.has(e.target).length === 0) {
		c_box_drop_prof_tools.hide();
	}if (!c_box_notify.is(e.target) && c_box_notify.has(e.target).length === 0) {
		c_box_notify.hide();
	}if (!c_box_notify_mob.is(e.target) && c_box_notify_mob.has(e.target).length === 0) {
		c_box_notify_mob.hide();
	}if (!c_input_box_selector.is(e.target) && c_input_box_selector.has(e.target).length === 0) {
		c_input_box_selector.hide();
	}
});
//FOR IOS
$(document).bind( "mouseup touchend", function(e){
	var c_menu = $("#SH_mobHE");
	var c_box_items = $("#box-contents-ID");
	var c_box_mob_items = $("#box-contents-mob-ID");
	var c_box_drop_prof_tools = $("#box-drop-prof-tools");
	var c_box_notify = $("#box-notify");
	var c_box_notify_mob = $("#box-notify-mob");
	var c_input_box_selector = $("#input_box_selector");
	if (!c_menu.is(e.target) && c_menu.has(e.target).length === 0) {
		c_menu.hide();
	}if (!c_box_items.is(e.target) && c_box_items.has(e.target).length === 0) {
		c_box_items.hide();
	}if (!c_box_mob_items.is(e.target) && c_box_mob_items.has(e.target).length === 0) {
		c_box_mob_items.hide();
	}if (!c_box_drop_prof_tools.is(e.target) && c_box_drop_prof_tools.has(e.target).length === 0) {
		c_box_drop_prof_tools.hide();
	}if (!c_box_notify.is(e.target) && c_box_notify.has(e.target).length === 0) {
		c_box_notify.hide();
	}if (!c_box_notify_mob.is(e.target) && c_box_notify_mob.has(e.target).length === 0) {
		c_box_notify_mob.hide();
	}if (!c_input_box_selector.is(e.target) && c_input_box_selector.has(e.target).length === 0) {
		c_input_box_selector.hide();
	}
});
function Newest(e) {
	e.style.backgroundColor = '#0000000d';
	ge('filter-tags').style.backgroundColor = 'transparent';
	ge('filter-unanswered').style.backgroundColor = 'transparent';
	hide('tags-showing');
	ge('tag_list').value = '';
	$.ajax({
		url: "/control/template/php/questions/",
		data: "header="+Functions.GetHeaderRequest()+"&get=all",
		beforeSend: function(res){
			show('pb_load_que');
		},
		success: function(json){
			if (typeof(json.data) != "undefined") {
				ge('innser_new_que').innerHTML = json.data;
				history.pushState(null, null, '?parted=all');
			}
			hide('pb_load_que');
		},
		error: function(res){}
	});
}
function Unanswered(e) {
	e.style.backgroundColor = '#0000000d';
	ge('filter-tags').style.backgroundColor = 'transparent';
	ge('filter-newest').style.backgroundColor = 'transparent';
	hide('tags-showing');
	ge('tag_list').value = '';
	$.ajax({
		url: "/control/template/php/questions/",
		data: "header="+Functions.GetHeaderRequest()+"&get=unanswered",
		beforeSend: function(res){
			show('pb_load_que');
		},
		success: function(json){
			if (typeof(json.data) != "undefined") {
				ge('innser_new_que').innerHTML = json.data;
				history.pushState(null, null, '?parted=unanswered');
			}
			hide('pb_load_que');
		},
		error: function(res){}
	});
}
function Tags(e) {
	e.style.backgroundColor = '#0000000d';
	show('tags-showing');
	ge('filter-newest').style.backgroundColor = 'transparent';
	ge('filter-unanswered').style.backgroundColor = 'transparent';
}
function SelectTag(e) {
	var id = e.id.replace('tags_','');
	if (e.className == "_span_tags-que _cursor _span_tags-que-hover _span_tags-que-hove_border") {
		e.classList.remove("_span_tags-que-hove_border");
		ge('tag_list').value = ge('tag_list').value.replace(id,'');
	}else{
		e.classList.add("_span_tags-que-hove_border");
		ge('tag_list').value += "|"+id+"|";
	}
	//reload_tags_filter
	$.ajax({
		url: "/control/template/php/questions/",
		data: "header="+Functions.GetHeaderRequest()+"&get=tags&t="+ge('tag_list').value,
		beforeSend: function(res){
			show('pb_load_que');
		},
		success: function(json){
			if (typeof(json.data) != "undefined") {
				ge('innser_new_que').innerHTML = json.data;
				history.pushState(null, null, '?parted=tags&t='+json.tags);
			}
			hide('pb_load_que');
		},
		error: function(res){}
	});
}
function TypeTags(e) {
	var tag = e.value;
	if (tag == "") {
		hide('box-tag-ID');
	}else{
		show('box-tag-ID');
		$.ajax({
			url: "/control/template/php/tools/",
			data: "tool=search_cat&q="+tag+"&header="+Functions.GetHeaderRequest(),
			beforeSend: function(res){},
			success: function(v){
				if (v != "") {
					//var v = $.parseJSON(res);
					ge('box-tag-ID').innerHTML = v.data;
				}
			},
			error: function(res){}
		});
	}
}
function AddTag(tag_id,name) {
	var id = tag_id.replace("tag_", "");
	ge('tag_value').value += "|" + id + "|";
	show('add-tags-place');
	var tag = '<span class="_span_tags" id="tagged_'+id+'">'+name+'<span class="_bg_icon_delete" onclick="DeleteTag(\'tagged_'+id+'\')"></span></span>';
	ge('add-tags-place').innerHTML += tag;
}
function DeleteTag(tag) {
	var id = tag.replace("tagged_", "");
	ge('tag_value').value = ge('tag_value').value.replace(id,"");
	Functions.RemoveElement(tag);
}
function AddBox() {
	var code_lang = ge('lang_code').value.toLowerCase();
	var boxes = ge('_boxes').value;
	var lang = ['html','css','xml','svg','js','actionscript','c#','bash','brainfuck','brightscript',
		'c','c++','coffeescript','dart','go','java','json','kotlin','matlab','moonscript','objectivec','pascal',
		'perl','php','sql','sql','sql','python','r','ruby','rust','swift','vbnet'];
	if (boxes == 3) {
		ge('error_add_box').innerHTML = Functions.GetMetaContent('SORRY_MORE_THAN_THREE_CPX');
	}else{
		if (lang.indexOf(code_lang) == -1) {
			ge('error_add_box').innerHTML = Functions.GetMetaContent('THE_FIELD_IS_EMPTY');
		}else{
			ge('_boxes').value = parseInt(boxes) + 1;
			ge('error_add_box').innerHTML = '';
			hide('input_box_selector');
			//Add box
			var textarea = document.createElement("textarea");
			textarea.classList.add('_code-box-manu');
			textarea.classList.add('_resizeArea');
			textarea.style.height = "100px";
			textarea.id = 'box_'+ ge('_boxes').value;
			textarea.setAttribute('data-lang', code_lang);
			textarea.placeholder = "//Code...";
			var i = document.createElement("i");
			i.classList.add('_remove_boxCode');
			i.id = '_remove_i'+ge('_boxes').value;
			i.setAttribute('onclick',"RemoveCodeBox("+ge('_boxes').value+")");
			var span = document.createElement("span");
			span.innerHTML = code_lang.charAt(0).toUpperCase() + code_lang.slice(1);
			span.classList.add('span_lang_name');
			span.id = 'span_'+ ge('_boxes').value;
			ge('inner_code_box').append(span);
			ge('inner_code_box').append(i);
			ge('inner_code_box').append(textarea);
		}
	}
}
function RemoveCodeBox(id) {
	Functions.RemoveElement('_remove_i'+id);
	Functions.RemoveElement('box_'+id);
	Functions.RemoveElement('span_'+id);
	ge('_boxes').value -= 1;
}
function UploadPicQuestion(){
    if (ge('js_jq').files.length <= 3) {
        for (var i = 0; i < ge('js_jq').files.length; ++i) {
            var imgPath = ge('js_jq').files.item(i).name;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            if (extn == "png" || extn == "jpg" || extn == "jpeg") {
                var form = $('js_jq')[i];
                var data = new FormData(form);
                data.append('image', $('input[type=file]')[0].files[i]);
                const imageName = ge('js_jq').files.item(i).name;
                $.ajax({
                    url: 'https://programnas.com/control/template/php/upload_question/',
                    type: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend:function(res){
                        var html = '<span class="_LOaDgifCir" id="IM_'+imageName+'"></span>';
                        ge('ImageListUpload').innerHTML += html;
                    },
                    success:function(v){
                        //var v = $.parseJSON(res);
                        if (v.e == "") {
                        	var div = document.createElement("div");
                        	div.classList.add('_added_oicssr');
                            var del = "DeletePicQuestion('"+v.image+"')";
                            var html =
                            '<div class="img_readyPost" id="Del_'+v.image+'">'+
                                '<span class="DeletePosPic_" onclick="'+del+'"></span>'+
                                '<img style="height: 90px;" src="https://programnas.com/control/qpictures/'+v.image+'">'+
                            '</div>';
                            div.innerHTML += html;
                            ge('ImageListUpload').appendChild(div);
                            ge('imgs').value += '||'+v.image+'||'; 
                            Functions.RemoveElement('IM_'+imageName);
                        }else{
                        	alert(v.e);
                        	Functions.RemoveElement('IM_'+imageName);
                        }
                    },
                    error:function (res){}
                });
            }
        }
    }else{
    	alert(Functions.GetMetaContent('CANT_UPM_THANTHREE'));
    }
}
function UploadPicAnswer(){
    if (ge('js_jq').files.length <= 3) {
        for (var i = 0; i < ge('js_jq').files.length; ++i) {
            var imgPath = ge('js_jq').files.item(i).name;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            if (extn == "png" || extn == "jpg" || extn == "jpeg") {
                var form = $('js_jq')[i];
                var data = new FormData(form);
                data.append('image', $('input[type=file]')[0].files[i]);
                const imageName = ge('js_jq').files.item(i).name;
                $.ajax({
                    url: 'https://programnas.com/control/template/php/upload_answer/',
                    type: "POST",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend:function(res){
                        var html = '<span class="_LOaDgifCir" id="IM_'+imageName+'"></span>';
                        ge('ImageListUpload').innerHTML += html;
                    },
                    success:function(v){
                        //var v = $.parseJSON(res);
                        if (v.e == "") {
                        	var div = document.createElement("div");
                        	div.classList.add('_added_oicssr');
                            var del = "DeletePicAnswer('"+v.image+"')";
                            var html =
                            '<div class="img_readyPost" id="Del_'+v.image+'">'+
                                '<span class="DeletePosPic_" onclick="'+del+'"></span>'+
                                '<img style="height: 90px;" src="https://programnas.com/control/apictures/'+v.image+'">'+
                            '</div>';
                            div.innerHTML += html;
                            ge('ImageListUpload').appendChild(div);
                            ge('imgs').value += '||'+v.image+'||'; 
                            Functions.RemoveElement('IM_'+imageName);
                        }else{
                        	alert(v.e);
                        	Functions.RemoveElement('IM_'+imageName);
                        }
                    },
                    error:function (res){}
                });
            }
        }
    }else{
    	alert(Functions.GetMetaContent('CANT_UPM_THANTHREE'));
    }
}
function DeletePicQuestion(file) {
    Functions.PostData('https://programnas.com/control/qpictures/',
    	'file='+file+"&header="+Functions.GetHeaderRequest());
    Functions.RemoveElement('Del_'+file);
    var replaced = ge('imgs').value.replace('||'+file+'||','');
    ge('imgs').value = replaced;    
    if (ge('imgs').value == "") {
        ge('ImageListUpload').innerHTML = "";
    }
}
function DeletePicAnswer(file) {
    Functions.PostData('https://programnas.com/control/apictures/',
    	'file='+file+"&header="+Functions.GetHeaderRequest());
    Functions.RemoveElement('Del_'+file);
    var replaced = ge('imgs').value.replace('||'+file+'||','');
    ge('imgs').value = replaced;    
    if (ge('imgs').value == "") {
        ge('ImageListUpload').innerHTML = "";
    }
}
$(document).mouseup(function(e) {
    $("#area_content_typing").on('keyup', function (e) {
	    var count = ge('area_content_typing').value.length;
	    if (parseInt(count) > 9000) {
		    ge('text_count').classList.remove('_SevenText');
		    ge('text_count').classList.add('_RedText');

	    }else{
		    ge('text_count').classList.remove('_RedText');
		    ge('text_count').classList.add('_SevenText');
	    }
        ge('text_count').innerHTML = count;
    });
});
function Ask() {
	var title = ge('_title_que').value;
	var content = encodeURIComponent(ge('area_content_typing').value);
	var tags = ge('tag_value').value;
	var images = ge('imgs').value;
	var boxes = ge('_boxes').value;
	var data = "header="+Functions.GetHeaderRequest()+"&num_boxes="+boxes;
	if (title == "") {
		alert(Functions.GetMetaContent('QUE_TITLE_EMPTY'));
		return;
	}else if (content == "") {
		alert(Functions.GetMetaContent('CONTENT_EMPTY'));
		return;
	}else if (tags == "") {
		alert(Functions.GetMetaContent('CANT_ASK_WOUT_TAGS'));
		return;
	}else{
		var box_one = ge('box_1');
		var box_two = ge('box_2');
		var box_three = ge('box_3');
		if (box_one != null) {
			if (box_one.value == "") {
				alert(Functions.GetMetaContent('FIRST_CODE_BOX_EMPTY'));
				return;
			}else if(box_one.value.length > 50000){
				alert(Functions.GetMetaContent('FIRST_CODE_BOX_LONG'));
				return;
			}else if(box_one.value.length < 20){
				alert(Functions.GetMetaContent('FIRST_CODE_BOX_SHORT'));
				return;
			}else{
				data += "&box_1="+encodeURIComponent(box_one.value)+"&language_1="+box_one.getAttribute('data-lang');
			}
		}if (box_two != null) {
			if (box_two.value == "") {
				alert(Functions.GetMetaContent('SECOND_CODE_BOX_SHORT'));
				return;
			}else if(box_two.value.length > 50000){
				alert(Functions.GetMetaContent('SECOND_CODE_BOX_LONG'));
				return;
			}else if(box_two.value.length < 20){
				alert(Functions.GetMetaContent('SECOND_CODE_BOX'));
				return;
			}else{
				data += "&box_2="+encodeURIComponent(box_two.value)+"&language_2="+box_two.getAttribute('data-lang');
			}
		}if (box_three != null) {
			if (box_three.value == "") {
				alert(Functions.GetMetaContent('THIRD_CODE_BOX_EMPTY'));
				return;
			}else if(box_three.value.length > 50000){
				alert(Functions.GetMetaContent('THIRD_CODE_BOX_LONG'));
				return;
			}else if(box_three.value.length < 20){
				alert(Functions.GetMetaContent('THIRD_CODE_BOX_SHORT'));
				return;
			}else{
				data += "&box_3="+encodeURIComponent(box_three.value)+"&language_3="+box_three.getAttribute('data-lang');
			}
		}
		data += "&title="+title+"&content="+content+"&tags="+tags+"&images="+images;
		$.ajax({
			url: "/control/template/php/ask/",
			data: data,
			beforeSend: function(res){
				show('pb_share');
			},
			success: function(json){
				//var json = $.parseJSON(res);
				if (json.status == true) {
					window.location.href = "/questions";
				}else{
					alert(json.error);
					hide('pb_share');
				}
			},
			error: function(res){}
		});
	}
}
function Answer() {
	var content = encodeURIComponent(ge('area_content_typing').value);
	var images = ge('imgs').value;
	var boxes = ge('_boxes').value;
	var data = "header="+Functions.GetHeaderRequest()+"&num_boxes="+boxes;
	if (content == "") {
		alert(Functions.GetMetaContent('CONTENT_EMPTY'));
		return;
	}else{
		var box_one = ge('box_1');
		var box_two = ge('box_2');
		var box_three = ge('box_3');
		if (box_one != null) {
			if (box_one.value == "") {
				alert(Functions.GetMetaContent('FIRST_CODE_BOX_EMPTY'));
				return;
			}else if(box_one.value.length > 50000){
				alert(Functions.GetMetaContent('FIRST_CODE_BOX_LONG'));
				return;
			}else if(box_one.value.length < 20){
				alert(Functions.GetMetaContent('FIRST_CODE_BOX_SHORT'));
				return;
			}else{
				data += "&box_1="+encodeURIComponent(box_one.value)+"&language_1="+box_one.getAttribute('data-lang');
			}
		}if (box_two != null) {
			if (box_two.value == "") {
				alert(Functions.GetMetaContent('SECOND_CODE_BOX_SHORT'));
				return;
			}else if(box_two.value.length > 50000){
				alert(Functions.GetMetaContent('SECOND_CODE_BOX_LONG'));
				return;
			}else if(box_two.value.length < 20){
				alert(Functions.GetMetaContent('SECOND_CODE_BOX'));
				return;
			}else{
				data += "&box_2="+encodeURIComponent(box_two.value)+"&language_2="+box_two.getAttribute('data-lang');
			}
		}if (box_three != null) {
			if (box_three.value == "") {
				alert(Functions.GetMetaContent('THIRD_CODE_BOX_EMPTY'));
				return;
			}else if(box_three.value.length > 50000){
				alert(Functions.GetMetaContent('THIRD_CODE_BOX_LONG'));
				return;
			}else if(box_three.value.length < 20){
				alert(Functions.GetMetaContent('THIRD_CODE_BOX_SHORT'));
				return;
			}else{
				data += "&box_3="+encodeURIComponent(box_three.value)+"&language_3="+box_three.getAttribute('data-lang');
			}
		}
		data += "&content="+content+"&images="+images;
		$.ajax({
			url: "/control/template/php/answer/",
			data: data,
			beforeSend: function(res){
				show('pb_share');
			},
			success: function(json){
				//var json = $.parseJSON(res);
				if (json.status == true) {
					location.reload();
				}else{
					alert(json.error);
					hide('pb_share');
				}
			},
			error: function(res){}
		});
	}
}
$(document).ready(function(){

	$Pro_crop = $('#Pro_demo').croppie({
		enableExif: true,
		viewport: {
			width:250,
			height:250,
			type:'circle' //square
		},
		boundary:{
			width:350,
			height:350
		}
	});

	$('#upload_Pro').on('change', function(){
		var reader = new FileReader();
		reader.onload = function (event) {
			$Pro_crop.croppie('bind', {
				url: event.target.result
			}).then(function(){});
		}
		reader.readAsDataURL(this.files[0]);
		show('uploadProModal');
	});

	$('#_UploadBTTPro').click(function(event){
		$Pro_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function(response){
			$.ajax({
				url: 'https://programnas.com/control/template/php/upload_profile/',
				type: "POST",
				data: {"image": response},
				beforeSend : function(res){
					show('pb_upload_pro');
				},
				success:function(v){
					//var v = $.parseJSON(res);
					if (v.e == "") {
						var image_d = "https://programnas.com/control/ppictures/"+v.image;
						ge('img-pro-now').style.backgroundImage = "url("+image_d+")";
						ge('image-valued').value = image_d;
					}else{
						alert(v.e);
					}
					hide('uploadProModal');
					hide('pb_upload_pro');
				},
				error:function (res){}
			});
		})
	});
});
function Reply(id) {
	var text = ge(id).value;
	if (text == "") {
		ge(id).style.border = "1px solid #a30f0f";
	}else if (text.length > 250) {
		ge(id).style.border = "1px solid #a30f0f";
		alert(Functions.GetMetaContent('REPLY_CONTENT_TOOLONG'));
	}else{
		ge(id).style.border = "1px solid #ddd";
		$.ajax({
			url: "/control/template/php/reply/",
			data: "header="+Functions.GetHeaderRequest()+"&text="+text+"&answer_id="+id.replace("reply_text",""),
			beforeSend: function(res){},
			success: function(json){
				//var json = JSON.parse(res);
				if (json.status == true) {
					ge('inner_replies'+json.answer_id).innerHTML += json.data;
					ge('reply_text'+json.answer_id).value = '';
				}else{
					alert(json.error);
				}
			},
			error: function(res){}
		});
	}
}
function AddPayment(method) {
	if (method == "fastpay") {
		show(method);
		hide('wire');
		hide('bitcoin');
	}else if (method == "wire") {
		show(method);
		hide('fastpay');
		hide('bitcoin');
	}else if (method == "bitcoin") {
		show(method);
		hide('wire');
		hide('fastpay');
	}
}
function ShowOmageQueVie(e) {
	var img = document.createElement("img");
	img.src = e.src.replace("https://programnas.com/control/im/?width=500&quality=50&image=","");
	img.id = 'height_show_img';
	ge('image_show_id').innerHTML += 
	'<i class="closeIco_IMG" onclick="hide(\'image_show_id\');ge(\'image_show_id\').innerHTML = \'\';"></i>';
	ge('image_show_id').append(img);
	show('image_show_id');
}
function ShowBGRe(reply_id) {
	if (ge('_mini_bg_rep'+reply_id).style.display == "none") {
		show('_mini_bg_rep'+reply_id);
	}else{
		hide('_mini_bg_rep'+reply_id);
	}
}
function DeleteReply(reply_id) {
	$.ajax({
		url: "/control/template/php/tools/",
		data: "header="+Functions.GetHeaderRequest()+"&tool=delete_reply&reply_id="+reply_id,
		beforeSend: function(res){},
		success: function(json){
			//var json = $.parseJSON(res);
			if (json.status == true) { 
				Functions.RemoveElement('relative_reply'+reply_id);
			}
		},
		error: function(res){}
	});
}
function ReportReply(e,reply_id) {
	Functions.PostData(
		'/control/template/php/tools/',
		"header="+Functions.GetHeaderRequest()+"&tool=report_reply&reply_id="+reply_id,null
	);
	e.classList.remove("textsInminiG");
	e.classList.add("textsInminiGNona");
	e.removeAttribute('onclick');
	e.innerHTML = Functions.GetMetaContent('REPORTED');
	hide('_mini_bg_rep'+reply_id);
	Functions.Toast();
}
function ReportAnswer(e,answer_id) {
	Functions.PostData(
		'/control/template/php/tools/',
		"header="+Functions.GetHeaderRequest()+"&tool=report_answer&answer_id="+answer_id,null
	);
	e.style.backgroundColor = "#7e0f0f66";
	e.removeAttribute('onclick');
	Functions.Toast();
}
function CheckAnswer(e,answer_id,question_id) {
	Functions.PostData(
		'/control/template/php/tools/',
		"header="+Functions.GetHeaderRequest()+
		"&tool=checking_answer&answer_id="+answer_id+"&question_id="+question_id,null
	);
	e.style.backgroundImage = "url(/control/template/media/svg/trued.svg)";
	e.removeAttribute('onclick');
	ge('_is_true_message'+answer_id).innerHTML = Functions.GetMetaContent('YOU_CHECKED_AS');
}
function UpdateQuestion() {
	var content = encodeURIComponent(ge('area_content_typing').value);
	var data = "header="+Functions.GetHeaderRequest()+"&update=question";
	if (content == "") {
		alert(Functions.GetMetaContent('CONTENT_EMPTY'));
		return;
	}else{
		data += "&content="+content;
		$.ajax({
			url: "/control/template/php/update/",
			data: data,
			beforeSend: function(res){
				show('pb_share');
			},
			success: function(json){
				if (json.status == true) {
					window.location.href = "/questions";
				}else{
					alert(json.error);
					hide('pb_share');
				}
			},
			error: function(res){}
		});
	}
}
function PrepareUpdatingAnswer(answer_id,question_id) {
	ge('text-area-inner'+answer_id).innerHTML = '';
	var textarea = document.createElement('textarea');
	textarea.dir = "auto";
	textarea.classList.add('_inparea_');
	textarea.classList.add('_resizeArea');
	textarea.style.height = "250px";
	textarea.placeholder = Functions.GetMetaContent('UPDATE_CONTENT__');
	textarea.id = "area_answer_update";
	ge('text-area-inner'+answer_id).append(textarea);
	var div = document.createElement('div');
	div.align = "right";
	ge('text-area-inner'+answer_id).append(div);
	var span = document.createElement('span');
	span.classList.add('_FourText');
	span.classList.add('_font18');
	span.classList.add('_cursor');
	span.classList.add('_Padd8LeftRight');
	span.classList.add('_OverName');
	span.setAttribute('onclick','ge("text-area-inner'+answer_id+'").innerHTML = "";');
	span.innerHTML = Functions.GetMetaContent('CANCEL_');
	var button = document.createElement('button');
	button.type = "button";
	button.classList.add('share_butt');
	button.setAttribute('onclick','UpdateAnswer('+answer_id+','+question_id+')');
	button.innerHTML = Functions.GetMetaContent('__UPDATE__');
	div.append(span);
	div.append(button);
}
function UpdateAnswer(answer_id,question_id) {
	var content = encodeURIComponent(ge('area_answer_update').value);
	var data = "header="+Functions.GetHeaderRequest()+"&update=answer";
	if (content == "") {
		alert(Functions.GetMetaContent('CONTENT_EMPTY'));
		return;
	}else{
		data += "&content="+content+"&answer_id="+answer_id+"&question_id="+question_id;
		$.ajax({
			url: "/control/template/php/update/",
			data: data,
			beforeSend: function(res){},
			success: function(json){
				if (json.status == true) {
					location.reload();
				}else{
					alert(json.error);
				}
			},
			error: function(res){}
		});
	}
}
function UploadDoc() {
	var imgPath = ge('js_jq').files.item(0).name;
	var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
	if (extn == "png" || extn == "jpg" || extn == "jpeg") {
		var form = $('js_jq')[0];
		var data = new FormData(form);
		data.append('image', $('input[type=file]')[0].files[0]);
		const imageName = ge('js_jq').files.item(0).name;
		$.ajax({
			url: 'https://programnas.com/control/template/php/upload_document/',
			type: "POST",
			data: data,
			contentType: false,
            cache: false,
            processData:false,
            beforeSend:function(res){
            	show('pb_doc');
            },
            success:function(res){
            	ge('doc_name').innerHTML = imageName;
            	ge('image_doc').value = "https://programnas.com/control/dpictures/" + res.image;
				hide('pb_doc');
            },
            error:function (res){}
        });
	}else{
		alert(Functions.GetMetaContent('INVALID_FILE_TYPE'));
	}
}
function SendVerifyRequest() {
	$.ajax({
		url: "/control/template/php/tools/",
		data: "header="+Functions.GetHeaderRequest()+"&tool=verify_request&image="+ge('image_doc').value,
		beforeSend: function(res){
			show('pb_send_request');
		},
		success: function(json){
			if (json.status == true) {
				window.location.href = "https://programnas.com/support/verify/";
			}else{
				alert(json.error);
				hide('pb_send_request');
			}
		},
		error: function(res){}
	});
}
function SendConfirmationCode(e) {
	Functions.PostData(
		'/control/template/php/tools/',"header="+Functions.GetHeaderRequest()+"&tool=send_confirm_code"
	);
	e.removeAttribute('onclick');
	e.innerHTML = Functions.GetMetaContent('CP_CODE_SENT');
}
function EnterConfirmationCode() {
	$.ajax({
		url: "/control/template/php/tools/",
		data: "header="+Functions.GetHeaderRequest()+"&tool=enter_confirm_code&code="+
		ge('the_c_code').value,
		beforeSend: function(res){
			show('pb_confirming_code');
		},
		success: function(json){
			if (json.status == true) {
				location.reload();
			}else{
				alert(json.error);
			}
			hide('pb_confirming_code');
		},
		error: function(res){}
	});
}
function DeleteAnswer(answer_id,question_id,title) {
	var r = confirm(Functions.GetMetaContent('ARE_Y_SURE'));
	if (r == true) {
		Functions.PostData('/control/template/php/tools/',
			"header="+Functions.GetHeaderRequest()+"&tool=delete_answer&"+
			"answer_id="+answer_id+"&question_id="+question_id
		);
		window.location.replace("/questions/?id="+question_id+"&q="+title);
	}
}
function VotingAnswer(e,answer_id,question_id,vote) {
	if (vote) {
		e.style.backgroundImage = "url(/control/template/media/svg/vote_down.svg";
		e.removeAttribute('onclick');
		e.setAttribute('onclick',"VotingAnswer(this,"+answer_id+","+question_id+",false)");
	}else{
		e.style.backgroundImage = "url(/control/template/media/svg/vote_up.svg";
		e.setAttribute('onclick',"VotingAnswer(this,"+answer_id+","+question_id+",true)");
	}
	Functions.PostData('/control/template/php/tools/',
		"header="+Functions.GetHeaderRequest()+"&tool=voting&"+
		"answer_id="+answer_id+"&question_id="+question_id
	);
}
function GetNotifications() {
	$.ajax({
		url: "/control/template/php/tools/",
		data: "header="+Functions.GetHeaderRequest()+"&tool=get_notifications",
		beforeSend: function(res){
			show('pb_show_cont_notifi');
		},
		success: function(json){
			ge('notifications_content_id').innerHTML = json.data;
			hide('pb_show_cont_notifi');
			ge('change_num_noti').innerHTML = '';
		},
		error: function(res){}
	});
}
function SimilarySearch(e) {
	if (e.value == "") {
		hide('inner_similary');
		ge('inner_similary').innerHTML = "";
	}else{
		$.ajax({
			url: "/control/template/php/search/",
			data: "header="+Functions.GetHeaderRequest()+"&part=similary&q="+e.value,
			beforeSend: function(res){},
			success: function(json){
				if (json.data != "") {
					ge('inner_similary').innerHTML = "<div class=\"_fontWeight _SevenText\">Similar Questions</div>";
					ge('inner_similary').innerHTML += json.data;
					show('inner_similary');
				}else{
					hide('inner_similary');
					ge('inner_similary').innerHTML = "";
				}
			},
			error: function(res){}
		});
    }
}
window.onload = function() {
	var url = window.location.href;
	if (url.includes("questions") && !url.includes("ask") && !url.includes("update")) {
		$.ajax({
			url: "/control/template/php/ads/",
			data: "header="+Functions.GetHeaderRequest(),
			beforeSend: function(res){},
			success: function(json){
				var images = [];
				var links = [];
				for (i in json.data) {
					images.push(json.data[i].image);
					links.push(json.data[i].link);
				}
				var ii = 0;
				setInterval(function() {
					ii += 1;

					ge('ad_s').href = links[ii-1];
					ge('ad_s').style.backgroundImage = 
					"url(/control/template/media/jpg/ads/"+images[ii-1]+"_"+
					ge('ad_s').getAttribute('data-size')+".jpg)";
					ge('ad_s').style.backgroundPosition = "";
					ge('ad_s').classList.remove("a_image_no_ads"+ge('ad_s').getAttribute('data-size'));
					ge('ad_s').classList.add("a_image_ads"+ge('ad_s').getAttribute('data-size'));
					ge('ad_s').target = "_blank";

					ge('ad_s__web').href = links[ii-1];
					ge('ad_s__web').style.backgroundImage = 
					"url(/control/template/media/jpg/ads/"+images[ii-1]+"_"+
					ge('ad_s__web').getAttribute('data-size')+".jpg)";
					ge('ad_s__web').style.backgroundPosition = "";
					ge('ad_s__web').classList.remove("a_image_no_ads"+ge('ad_s__web').getAttribute('data-size'));
					ge('ad_s__web').classList.add("a_image_ads"+ge('ad_s__web').getAttribute('data-size'));
					ge('ad_s__web').target = "_blank";

					if (ii > images.length-1) {ii = 0;}
				},10000);
			},
			error: function(res){}
		});
	}
	var question_id = ge('id_put_');
	if (question_id != null) {
		document.addEventListener('visibilitychange', function(ev) {
	    	Functions.PostData('/control/template/php/tools/',
	    		"header="+Functions.GetHeaderRequest()+"&tool=id_put_&question_id="+question_id.value,null
	    	);
	    });
	}
}
function CopyFunc(id) {
	var copyText = document.getElementById(id);
	copyText.select();
	document.execCommand("copy");
}
function TwoFactorAuthConfig(m) {
	if (m == "disable") {
		Functions.PostData('/control/template/php/tools/',
	    	"header="+Functions.GetHeaderRequest()+"&tool=disable_auth",null
	    );
	    window.location.href = "/settings/?part=security";
	}else if(m == "enable"){
		$.ajax({
			url: "/control/template/php/tools/",
			data: "header="+Functions.GetHeaderRequest()+"&tool=get_auth_code",
			beforeSend: function(res){
				show('pb_load_auth');
			},
			success: function(json){
				hide('pb_load_auth');
				show('inner_gen_auth_');
				ge('inner_gen_auth_').innerHTML = json.data;
			},
			error: function(res){}
		});
	}
}
function VerifyAuthCode(salt) {
	$.ajax({
		url: "/control/template/php/tools/",
		data: "header="+Functions.GetHeaderRequest()+"&tool=verify_auth_code&code="+ge('_code_auth_').value+"&salt="+salt,
		beforeSend: function(res){
			show('pb_load_code_auth');
		},
		success: function(json){
			hide('pb_load_code_auth');
			if (json.error == "") {
				window.location.href = "/settings/?part=security";
			}else{
				alert(Functions.GetMetaContent('YOU_VE_ENTERED'));
			}
		},
		error: function(res){}
	});
}
function CopyCodeBox(id, e){
	var r = document.createRange();
	r.selectNode(document.getElementById("code_"+id));
	window.getSelection().removeAllRanges();
	window.getSelection().addRange(r);
	document.execCommand('copy');
	window.getSelection().removeAllRanges();
	ge(e).innerHTML = Functions.GetMetaContent('_COPIED');
	setTimeout(function(){ ge(e).innerHTML = Functions.GetMetaContent('_COPY_IT'); }, 800);
}
function FindTagsQuestions(e) {
	if (e.value == "") {
		ge('tags_inner_place_found').innerHTML = '';
		hide('tags_inner_place_found');
	}else{
		$.ajax({
			url: "/control/template/php/tools/",
			data: "tool=tags_found&q="+e.value+"&header="+Functions.GetHeaderRequest(),
			beforeSend: function(res){},
			success: function(json){
				if (json.success == true) {
					ge('tags_inner_place_found').innerHTML = json.data;
				}else{
					ge('tags_inner_place_found').innerHTML = '<span class="_no_found_tags">No tags found.</span>';
				}
				show('tags_inner_place_found');
			},
			error: function(res){}
		});
    }
}