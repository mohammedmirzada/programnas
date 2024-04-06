<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/meta.php"; ?>
	<?=actions::IndexMetaLibrary('Library - Copyright')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/header.php"; ?>

<div class="col-lg-8 mx-auto p-3 py-md-5 <?=RTL_CLASS?>" align="<?=ALIGN_ATTR?>">
  <header class="d-flex align-items-center pb-3 mb-2 border-bottom">
    <div class="d-flex align-items-center text-dark text-decoration-none">
      <span class="fs-2"><?=COPYRIGHT?></span>
    </div>
  </header>
  <main>
    <p class="fs-5"><?=COPYRIGHT_CONTENT?></p>
  </main>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/footer.php"; ?>
</body>
</html>