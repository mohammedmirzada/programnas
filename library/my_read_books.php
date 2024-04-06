<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();
$library = new library();
if (!session_exists('user')) {
  redirect_to('/library');
}
?>

<!DOCTYPE html>
<html>
<head>
  <?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/meta.php"; ?>
  <?=actions::IndexMetaLibrary('Library - Read Books')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/header.php"; ?>

<section class="mb-5 mt-4">
  <div class="container">
    <div class="row p-4 align-items-center rounded-3 border shadow-lg">
      <h2 class="pb-2 border-bottom" align="<?=ALIGN_ATTR?>"><?=YOUT_READ_BOOKS?></h2>
      <div align="center">
        <?=$library->ReadsBooks()?>
      </div>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/footer.php"; ?>
</body>
</html>