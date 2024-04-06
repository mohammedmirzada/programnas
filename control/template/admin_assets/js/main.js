function DeletePics(p) {
    $.ajax({
        url: "/control/template/admin_assets/php/delete",
        data: "header="+Functions.GetHeaderRequest()+"&deleting="+p,
        beforeSend: function(res){
            show('pb_deleting');
        },
        success: function(json){
            ge('inner_result_delete').innerHTML = json.result;
            hide('pb_deleting');
        },
        error: function(res){}
    });
}
function Search(e,t) {
    if (e.value != "") {
        $.ajax({
            url: "/control/template/admin_assets/php/search",
            data: "header="+Functions.GetHeaderRequest()+"&q="+e.value+"&t="+t,
            beforeSend: function(res){},
            success: function(json){
                ge('inner_html_search_items').innerHTML = json.data;
                show('inner_html_search_items');
            },
            error: function(res){}
        });
    }else{
        hide('inner_html_search_items');
    }
}
function SendingEmail(p) {
    $.ajax({
        url: "/control/template/admin_assets/php/emails",
        data: "header="+Functions.GetHeaderRequest()+"&send="+p,
        beforeSend: function(res){
            show('loading_robot_sending');
        },
        success: function(json){
            if (json.s == "done") {
                hide('loading_robot_sending');
            }
        },
        error: function(res){}
    });
}
function UploadLibrary() {
    var imgPath = ge('js_jq').files.item(0).name;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    if (extn == "png" || extn == "jpg" || extn == "jpeg") {
        var form = $('js_jq')[0];
        var data = new FormData(form);
        data.append('image', $('input[type=file]')[0].files[0]);
        const imageName = ge('js_jq').files.item(0).name;
        $.ajax({
            url: 'https://programnas.com/control/template/php/upload_library/',
            type: "POST",
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend:function(res){
                show('pb_lib_img');
            },
            success:function(res){
                ge('image_lib').innerHTML = res.image;
                hide('pb_lib_img');
            },
            error:function (res){}
        });
    }else{
        alert('ERROR');
    }
}
function SearchBookName(e) {
    if (e.value != "") {
        $.ajax({
            url: "/control/template/admin_assets/php/search",
            data: "header="+Functions.GetHeaderRequest()+"&q="+e.value+"&t=books",
            beforeSend: function(res){},
            success: function(json){
                ge('inner_search_html_books').innerHTML = json.data;
                show('inner_search_html_books');
            },
            error: function(res){}
        });
    }else{
        hide('inner_search_html_books');
    }
}