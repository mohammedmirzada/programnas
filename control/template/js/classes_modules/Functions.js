class Functions {

	constructor() {}

	static RemoveElement(id) {
		var elem = document.getElementById(id);
		elem.parentNode.removeChild(elem);
		return false;
	}

	static StripTags(input, allowed) {
		allowed = (((allowed || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
		var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
		commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
		return input.replace(commentsAndPhpTags, '').replace("style",'=')
		.replace(tags, function($0, $1) {
			return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
		});
	}

	static PostData(url,d,pb=null) {
		$.ajax({
			url: url,
			data: d,
			beforeSend: function(res){if (pb != null) {show(pb);}},
			success: function(res){if (pb != null) {hide(pb);}},
			error: function(res){}
		});
	}

	static Toast(){
		var x = document.getElementById('snackbar');
		x.className = "show";
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
	}


	static STRtoINT(str){
		return parseInt(str);
	}

	static GetHeaderRequest(){
		return $('meta[name="csrf-token"]').attr('content');
	}

	static GetMetaContent(name){
		return $('meta[name="'+name+'"]').attr('content');
	}

	static CookiesExist(key) {
		var re = new RegExp(key + "=([^;]+)");
		var value = re.exec(document.cookie);
		return (value != null) ? unescape(value[1]) : null;
	}

	static SetSession(key,value) {
		if (typeof(Storage) !== "undefined") {
			sessionStorage.setItem(key, value);
		} else {
			alert("Sorry, your browser does not support Web Storage...");
		}
	}

	static GetSession(key) {
		if (typeof(Storage) !== "undefined") {
			return sessionStorage.getItem(key);
		} else {
			alert("Sorry, your browser does not support Web Storage...");
			return "";
		}
	}

}