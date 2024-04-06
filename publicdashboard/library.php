<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$payment = new payment();
$actions = new actions();

if (input_exists()) {
	//CATEGORIES
	if (input_get('submit') == "Add Category") {
		$name_en = input_get('name_en');
		$name_ku = input_get('name_ku');
		if (!empty($name_ku) && !empty($name_en)) {
			$db->insert('library_categories', array('name_en' => $name_en, 'name_ku' => $name_ku));
		}
	}elseif (input_get('submit') == "Update Category") {
		$name_en = input_get('name_en');
		$name_ku = input_get('name_ku');
		$id = input_get('id');
		if (!empty($name_ku) && !empty($name_en)) {
			$db->change('library_categories', $id, array('name_en' => $name_en, 'name_ku' => $name_ku));
		}
	}elseif (input_get('submit') == "Delete Category") {
		$id = input_get('id');
		if (!empty($id)) {
			$db->delete('library_categories', array('id','=',$id));
		}
	}
	//AUTHORS
	elseif (input_get('submit') == "Add Author") {
		$name_en = input_get('name_en');
		$name_ku = input_get('name_ku');
		$image = input_get('image');
		if (!empty($name_ku) && !empty($name_en)) {
			$db->insert('library_authors', array('name_en' => $name_en, 'name_ku' => $name_ku, 'image' => $image));
		}
	}elseif (input_get('submit') == "Update Author") {
		$name_en = input_get('name_en');
		$name_ku = input_get('name_ku');
		$image = input_get('image');
		$id = input_get('id');
		if (!empty($name_ku) && !empty($name_en)) {
			$db->change('library_authors', $id, array('name_en' => $name_en, 'name_ku' => $name_ku, 'image' => $image));
		}
	}elseif (input_get('submit') == "Delete Author") {
		$id = input_get('id');
		if (!empty($id)) {
			$db->delete('library_authors', array('id','=',$id));
		}
	}
	//BOOKS
	elseif (input_get('submit') == "Add Book") {
		$name = input_get('name');
		$image = input_get('image');
		$author_id = input_get('author_id');
		$category_ids = input_get('category_ids');
		$book1 = input_get('book1');
		$book2 = input_get('book2');
		$book3 = input_get('book3');
		$book4 = input_get('book4');
		$book5 = input_get('book5');
		$book6 = input_get('book6');
		$book7 = input_get('book7');
		$book8 = input_get('book8');
		$book9 = input_get('book9');
		$book10 = input_get('book10');
		if (!empty($name) && !empty($category_ids) && !empty($book1)) {
			$db->insert(
				'library_books',
				array(
					'name' => $name,
					'image' => $image,
					'author_id' => $author_id,
					'category_ids' => $category_ids,
					'book1' => $book1,
					'book2' => $book2,
					'book3' => $book3,
					'book4' => $book4,
					'book5' => $book5,
					'book6' => $book6,
					'book7' => $book7,
					'book8' => $book8,
					'book9' => $book9,
					'book10' => $book10
				)
			);
		}
	}elseif (input_get('submit') == "Update Book") {
		$name = input_get('name');
		$image = input_get('image');
		$author_id = input_get('author_id');
		$category_ids = input_get('category_ids');
		$book1 = input_get('book1');
		$book2 = input_get('book2');
		$book3 = input_get('book3');
		$book4 = input_get('book4');
		$book5 = input_get('book5');
		$book6 = input_get('book6');
		$book7 = input_get('book7');
		$book8 = input_get('book8');
		$book9 = input_get('book9');
		$book10 = input_get('book10');
		$id = input_get('id');
		if (!empty($name) && !empty($category_ids) && !empty($book1)) {
			$db->change(
				'library_books',
				$id,
				array(
					'name' => $name,
					'image' => $image,
					'author_id' => $author_id,
					'category_ids' => $category_ids,
					'book1' => $book1,
					'book2' => $book2,
					'book3' => $book3,
					'book4' => $book4,
					'book5' => $book5,
					'book6' => $book6,
					'book7' => $book7,
					'book8' => $book8,
					'book9' => $book9,
					'book10' => $book10
				)
			);
		}
	}elseif (input_get('submit') == "Delete Book") {
		$id = input_get('id');
		if (!empty($id)) {
			$db->delete('library_books', array('id','=',$id));
		}
	}
}

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
				<h1 class="page-header">Library</h1>
			</div>
		</div>
		<div class="panel panel-container">
			<div class="row" align="center">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding">
							<div class="large"><?=actions::Count('library_books',array('id','>',0))?></div>
							<div class="text-muted">Books</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-blue panel-widget">
						<div class="row no-padding">
							<div class="large"><?=actions::Count('library_authors',array('id','>',0))?></div>
							<div class="text-muted">Authors</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default chat">
					<div class="panel-heading">Library Categories</div>
					<div class="panel-body">
						<form method="POST">
							<input type="text" name="name_en" placeholder="Category name english" class="input_classss">
							<input type="text" name="name_ku" placeholder="Category name kurdish" class="input_classss">
							<input type="submit" name="submit" value="Add Category" class="button_save">
						</form>
						<?php
						$catego = '';
						foreach ($db->get('library_categories', array('id','>',0))->results() as $m) {
							$catego .= '
							<form method="POST">
								<div class="_id_c">ID: '.$m->id.'</div>
								<input type="text" name="name_en" value="'.$m->name_en.'" placeholder="Category name english" class="input_classss">
								<input type="text" name="name_ku" value="'.$m->name_ku.'" placeholder="Category name kurdish" class="input_classss">
								<input type="submit" name="submit" value="Update Category" class="button_save">
								<input type="submit" style="background: #c77171;" name="submit" value="Delete Category" class="button_save">
								<input type="hidden" name="id" value="'.$m->id.'">
							</form>';
						}
						echo($catego);
						?>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Library Books</div>
					<div class="panel-body">
						<form method="POST">
							<input type="text" name="name" placeholder="Book name" class="input_classss" onkeyup="SearchBookName(this)">
							<div id="inner_search_html_books"></div>
							<input type="text" name="image" placeholder="Book image 700x1120" class="input_classss">
							<input type="text" name="author_id" placeholder="Author ID" class="input_classss" value="<?=input_get('author_id')?>">
							<input type="text" name="category_ids" placeholder="Category IDs" class="input_classss" value="<?=input_get('category_ids')?>">
							<h5>Books</h5>
							<input type="text" name="book1" placeholder="Book 1" class="input_classss">
							<input type="text" name="book2" placeholder="Book 2" class="input_classss">
							<input type="text" name="book3" placeholder="Book 3" class="input_classss">
							<input type="text" name="book4" placeholder="Book 4" class="input_classss">
							<input type="text" name="book5" placeholder="Book 5" class="input_classss">
							<input type="text" name="book6" placeholder="Book 6" class="input_classss">
							<input type="text" name="book7" placeholder="Book 7" class="input_classss">
							<input type="text" name="book8" placeholder="Book 8" class="input_classss">
							<input type="text" name="book9" placeholder="Book 9" class="input_classss">
							<input type="text" name="book10" placeholder="Book 10" class="input_classss">
							<input type="submit" name="submit" value="Add Book" class="button_save">
						</form>
					</div>
					<div style="padding: 12px;background: #001a471a;max-height: 1000px;overflow-y: auto;">
					<?php
						$boooks = '';
						foreach ($db->get('library_books', array('id','>',0))->results() as $m) {
							$boooks .= '
							<form method="POST">
								<input type="text" name="name" placeholder="Book name" class="input_classss" value="'.$m->name.'">
								<input type="text" name="image" placeholder="Book image 700x1120" class="input_classss" value="'.$m->image.'">
								<input type="text" name="author_id" placeholder="Author ID" class="input_classss" value="'.$m->author_id.'">
								<input type="text" name="category_ids" placeholder="Category IDs" class="input_classss" value="'.$m->category_ids.'">
								<h5>Books</h5>
								<input type="text" name="book1" placeholder="Book 1" class="input_classss" value="'.$m->book1.'">
								<input type="text" name="book2" placeholder="Book 2" class="input_classss" value="'.$m->book2.'">
								<input type="text" name="book3" placeholder="Book 3" class="input_classss" value="'.$m->book3.'">
								<input type="text" name="book4" placeholder="Book 4" class="input_classss" value="'.$m->book4.'">
								<input type="text" name="book5" placeholder="Book 5" class="input_classss" value="'.$m->book5.'">
								<input type="text" name="book6" placeholder="Book 6" class="input_classss" value="'.$m->book6.'">
								<input type="text" name="book7" placeholder="Book 7" class="input_classss" value="'.$m->book7.'">
								<input type="text" name="book8" placeholder="Book 8" class="input_classss" value="'.$m->book8.'">
								<input type="text" name="book9" placeholder="Book 9" class="input_classss" value="'.$m->book9.'">
								<input type="text" name="book10" placeholder="Book 10" class="input_classss" value="'.$book10.'">
								<input type="submit" name="submit" value="Update Book" class="button_save">
								<input type="submit" style="background: #c77171;" name="submit" value="Delete Book" class="button_save">
								<input type="hidden" name="id" value="'.$m->id.'">
							</form>';
						}
						echo($boooks);
					?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default chat">
					<div class="panel-heading">Library Authors</div>
					<div class="panel-body timeline-container">
						<form method="POST">
							<input type="text" name="name_en" placeholder="Author name english" class="input_classss">
							<input type="text" name="name_ku" placeholder="Author name kurdish" class="input_classss">
							<input type="text" name="image" placeholder="Author image" class="input_classss">
							<input type="submit" name="submit" value="Add Author" class="button_save">
						</form>
						<?php
						$authorrr = '';
						foreach ($db->get('library_authors', array('id','>',0))->results() as $m) {
							$authorrr .= '
							<form method="POST">
								<div class="_id_c">ID: '.$m->id.'</div>
								<input type="text" name="name_en" value="'.$m->name_en.'" placeholder="Author name english" class="input_classss">
								<input type="text" name="name_ku" value="'.$m->name_ku.'" placeholder="Author name kurdish" class="input_classss">
								<input type="text" name="image" value="'.$m->image.'" placeholder="Author image 370x370" class="input_classss">
								<input type="submit" name="submit" value="Update Author" class="button_save">
								<input type="submit" style="background: #c77171;" name="submit" value="Delete Author" class="button_save">
								<input type="hidden" name="id" value="'.$m->id.'">
							</form>';
						}
						echo($authorrr);
						?>
					</div>
				</div>
				<div class="panel panel-default ">
					<div class="panel-heading">Upload Image</div>
					<div class="panel-body timeline-container">
						<label for="js_jq">
							<span class="upload_doc">Upload</span>
							<input type="file" id="js_jq" onchange="UploadLibrary()" accept="image/*" class="_None">
							<?=actions::ProgressBar('pb_lib_img',true)?>
						</label>
						<div id="image_lib" class="img_lib_up_text"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>