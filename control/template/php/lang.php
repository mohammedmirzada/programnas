<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:kfilmone.com");

switch(input_get('lang')){
    case "en":
        cookies_put('lang',"en",60480000);
    break;
    case "ku_central":
        cookies_put('lang',"ku_central",60480000);
    break;
}

$ref = input_get('ref');

if (empty($ref)) {
    redirect_to('/');
}else{
    if (strpos($ref, 'programnas.com')) {
        redirect_to($ref);
    }else{
        redirect_to('/');
    }
}

?>