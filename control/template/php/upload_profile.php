<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

if (session_exists('user')) {
    if (!empty(input_get('image'))) {
        $data = input_get('image');
        $size = strlen(base64_decode($data));
        if ($size > 7691170) {
            $up = array(
                'image' => $im,
                'e' => UP_IMAGE_VAL,
                'size' => $size
            );
        }else{
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $im = rand(1000,1000000).uniqid().".png";
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/control/ppictures/".$im, $data);
            $up = array(
                'image' => $im,
                'e' => "",
                'size' => $size
            );
        }
    }else{
        redirect_to('/');
        exit();
        die();
    }
    echo json_encode($up,JSON_UNESCAPED_UNICODE);
}else{
    redirect_to('/');
    exit();
    die();
}

?>