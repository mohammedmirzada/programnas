<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header('Content-Type: application/json');

ini_set('display_errors', 'OFF');

if (CheckUserReferer('https://programnas.com') && session_exists('user')) {

$imgFile = $_FILES['image']['name'];
$tmp_dir = $_FILES['image']['tmp_name'];
$imgSize = $_FILES['image']['size'];

$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
$ext = array('jpeg', 'jpg' , 'png'); 
$im = rand(1000,1000000).uniqid().time().".".$imgExt;
$this_upload = $_SERVER['DOCUMENT_ROOT']."/control/dpictures/"; 

$error = '';
if(in_array($imgExt,$ext)){     
    if($imgSize < 15000000){
        move_uploaded_file($tmp_dir,$this_upload.$im);
    }else{
        $error = UP_IMAGE_VAL;
    }
}else{
    $error = CANTUPTHISIMAGHE;
}

$imagepath = $this_upload.$im;
$save = $imagepath; 
$file = $imagepath; 
list($width, $height) = getimagesize($file); 
$tn = imagecreatetruecolor($width, $height);
$info = getimagesize($this_upload.$im);
if ($info['mime'] == 'image/jpeg'){
    $images = imagecreatefromjpeg($file);
}elseif ($info['mime'] == 'image/gif'){
    $images = imagecreatefromgif($file);
}elseif ($info['mime'] == 'image/png'){
    $images = imagecreatefrompng($file);
}
imagecopyresampled($tn, $images, 0, 0, 0, 0, $width, $height, $width, $height);
imagejpeg($tn, $save, 90);

$up = array(
	'image' => $im,
	'e' => $error
);
echo json_encode($up,JSON_UNESCAPED_UNICODE);

}else{
    redirect_to('/');
    exit();
    die();
}

/*if (input_get("typeOS") == "Android" || input_get("typeOS") == "iOS") {
$encode = input_get("encode");
$data = base64_decode($encode);
$this_upload = $_SERVER['DOCUMENT_ROOT']."/API/upload/kurdfilm/";
$im = rand(1000,1000000).uniqid().".jpg";
file_put_contents($this_upload.$im, $data);
echo 'https://filmnas.com/API/upload/kurdfilm/'.$im;
exit();
}*/

?>