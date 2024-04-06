<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$user = new user();
$library = new library();
$q = input_get('q');
?>

<!DOCTYPE html>
<html>
<head>
  <?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/meta.php"; ?>
  <?=actions::IndexMetaLibrary('Library - Search')?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/header.php"; ?>

<section class="mb-5 mt-4">
  <div class="container">
    <div class="row p-4 align-items-center rounded-3 border shadow-lg">
      <h2 class="pb-2 border-bottom" align="<?=ALIGN_ATTR?>"><?=SEARCH_RESULT?></h2>
      <div align="center" class="border-bottom">
        <?=$library->SearchResult('books', $q)?>
      </div>
      <div align="center" class="mt-3">
        <?=$library->SearchResult('authors', $q)?>
      </div>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/footer.php"; ?>
</body>
</html>