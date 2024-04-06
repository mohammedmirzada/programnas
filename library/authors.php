<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();
$library = new library();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/meta.php"; ?>
	<?=actions::IndexMetaLibrary('Library - Authors')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/header.php"; ?>

<main>
	<div class="container marketing mt-3" align="center">
		<div class="row">
	      <?=$library->GetAllAuthors()?>
	    </div>
	</div>
</main>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/footer.php"; ?>
</body>
</html>