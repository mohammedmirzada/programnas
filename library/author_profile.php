<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();
$library = new library();
$actions = new actions();

$id = input_get('id');
$name = '';

if (empty($id)) {
	redirect_to('/404');
}else{
	if (!is_numeric($id)) {
		redirect_to('/404');
	}else{
		if (actions::Count('library_authors', array('id','=',$id)) == 0) {
			redirect_to('/404');
		}else{
			$actions->GetData('library_authors', array('id','=',$id));
			if (!cookies_exists('lang')) {
                $name = $actions->data()->name_en;
            }else{
                if (cookies_get("lang") == "en") {
                    $name = $actions->data()->name_en;
                }else{
                    $name = $actions->data()->name_ku;
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
	<?=actions::MetaLibrary($name, $library->AuthorsImage($actions->data()->image))?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/header.php"; ?>

<main>
	<div class="container">
		<div align="center">
		    <div>
		    	<img alt="<?=$name?>" src="<?=$library->AuthorsImage($actions->data()->image)?>" class="bd-placeholder-img rounded-circle" width="140" height="140">
		    </div>
		    <h2 class="pb-2 border-bottom mt-2"><?=$name?></h2>
	    </div>
	    <div class="row p-4 align-items-center">
			<div align="center" class="mt-3">
				<?=$library->GetAuthorBooks($id)?>
			</div>
		</div>
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