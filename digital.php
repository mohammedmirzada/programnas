<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin:programnas.com");
header('X-Frame-Options: SAMEORIGIN');
?>
<!DOCTYPE html>
<html>
    <head></head>
<body>
    <?php if(CheckUserReferer('https://programnas.com') && input_get('header') == session_get('csrf_token')){ ?>
    <script type="text/javascript" src="/control/template/js/classes_modules/simplex-noise.min.js?v=<?=config_get('web/version')?>"></script>
    <script type="text/javascript" src="/control/template/js/classes_modules/digitalStream.js?v=<?=config_get('web/version')?>"></script>
    <?php }else{http_response_code(403);exit();}?>
</body>
</html>