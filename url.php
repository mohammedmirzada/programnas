<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();
?>


<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/meta.php"; ?>
</head>
<body>
<?php
include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/header.php";

$url = FixLink(input_get('u'));

if (!empty($url)) {
	$parse = parse_url($url);
	if (isset($parse['host'])) {
		$domain = $parse['host'];
		if (actions::Count('blocked_url',array('domain','=',$domain)) > 0) {
			echo(URL_PASSING);
		}else{
			if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
				echo(URL_PASSING);
			}else{
				redirect_to($url);
			}
		}
	}else{
		redirect_to('/');
	}
}else{
	redirect_to('/');
}

include $_SERVER['DOCUMENT_ROOT']."/control/template/html/main/footer_two.php";
?>

</body>
</html>