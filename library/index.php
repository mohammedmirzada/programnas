<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();
$library = new library();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/meta.php"; ?>
	<?=actions::IndexMetaLibrary('Library')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/header.php"; ?>

<section>
	<div class="px-4 py-5 my-3 text-center">
		<h1 class="display-5 fw-bold <?=RTL_CLASS?>"><?=OVER_THAU?></h1>
		<div class="col-lg-6 mx-auto">
			<p class="lead mb-2 <?=RTL_CLASS?>"><?=BELOW_OVER_THAU?></p>
		</div>
	</div>
</section>

<section class="mb-2">
	<div class="container">
		<div class="_Padd8">
			<div class="horizScoll class_scroll_hori">
				<?=$library->GetHomeCategories()?>
			</div>
		</div>
	</div>
</section>

<section class="mb-5">
	<div class="container">
		<div class="row p-4 align-items-center rounded-3 border shadow-lg">
			<h2 class="pb-2 border-bottom" align="<?=ALIGN_ATTR?>"><?=LATEST_BOOKS?></h2>
			<div align="center">
				<?=$library->GetHomeBooks()?>
			</div>
			<div class="mt-3 d-grid gap-2 col-6 mx-auto">
				<a href="/library/books/?t=all" class="btn btn-outline-primary btn-lg"><?=VIEW_ALL?></a>
			</div>
		</div>
	</div>
</section>

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