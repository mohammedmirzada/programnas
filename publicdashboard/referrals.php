<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$actions = new actions();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/admin_assets/meta.php"; ?>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/admin_assets/header.php"; ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Referrals</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="canvas-wrapper">
							<h4><code>KurdFilm: <span style="color: #001946;"><?=actions::Count('referral',array('referral','=','KurdFilm','OR','referral','LIKE',"%kfilmone.com%"))?></span> Visitors</code></h4>
							<h4><code>Youtube: <span style="color: #001946;"><?=actions::Count('referral',array('referral','=','Youtube','OR','referral','LIKE',"%youtube.com%"))?></span> Visitors</code></h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>