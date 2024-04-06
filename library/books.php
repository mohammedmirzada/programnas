<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();
$library = new library();

$t = input_get('t');

$ti_ti = LATEST_BOOKS;

if (empty($t)) {
	$data = $library->GetAllBooks();
}elseif ($t == "all") {
	$data = $library->GetAllBooks();
}else{
	if (!is_numeric($t)) {
		$data = $library->GetAllBooks();
	}else{
		if (actions::Count('library_categories', array('id','=',$t)) == 0) {
			$data = $library->GetAllBooks();
		}else{
			$data = $library->GetAllBooks($t);
			$actions = new actions();
			$actions->GetData('library_categories', array('id','=',$t));
			if (!cookies_exists('lang')) {
				$ti_ti = $actions->data()->name_en.' Books';
            }else{
                if (cookies_get("lang") == "en") {
                    $ti_ti = $actions->data()->name_en.' Books';
                }else{
                    $ti_ti = $actions->data()->name_ku;
                }
            }
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/meta.php"; ?>
	<?=actions::IndexMetaLibrary('Library - Books')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/header.php"; ?>

<section class="mb-5 mt-5">
	<div class="container">
		<div class="row p-4 align-items-center rounded-3 border shadow-lg">
			<h2 class="pb-2 border-bottom" align="<?=ALIGN_ATTR?>"><?=$ti_ti?></h2>
			<div align="center" class="mt-3">
				<?=$data?>
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