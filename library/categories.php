<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();
$library = new library();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/meta.php"; ?>
	<?=actions::IndexMetaLibrary('Library - Categories')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/header.php"; ?>

<main>
	<div class="container px-4 py-5" id="icon-grid">
    <h2 class="pb-2 border-bottom" align="<?=ALIGN_ATTR?>"><?=CATEGORIES?></h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 <?=RTL_CLASS?>" align="<?=ALIGN_ATTR?>"><?=$library->GetAllCategories()?></div>
  </div>
</main>

<div align="center">
	<ins class="adsbygoogle"
	     style="display:block"
	     data-ad-client="ca-pub-9877420063334339"
	     data-ad-slot="6852505427"
	     data-ad-format="auto"
	     data-full-width-responsive="true"></ins>
	<script>
	     (adsbygoogle = window.adsbygoogle || []).push({});
	</script>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/footer.php"; ?>
</body>
</html>