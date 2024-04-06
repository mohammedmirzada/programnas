<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
$db = db::getInstance();
$user = new user();
$library = new library();
$actions = new actions();

$id = input_get('id');

if (empty($id)) {
	redirect_to('/404');
}else{
	if (!is_numeric($id)) {
		redirect_to('/404');
	}else{
		if (actions::Count('library_books', array('id','=',$id)) == 0) {
			redirect_to('/404');
		}else{
			//START Insert And Delete
			if (input_get('token') == session_get('last_token') && input_exists()) {
				if (input_get('type') == "remove_fav") {
					$db->delete('library_favlist', array('user_id','=',$user->data()->id,'AND','library_book_id','=',$id));
				}elseif (input_get('type') == "add_fav") {
					$db->insert('library_favlist', array('user_id' => $user->data()->id, 'library_book_id' => $id));
				}elseif (input_get('type') == "remove_read") {
					$db->delete('library_reads', array('user_id','=',$user->data()->id,'AND','library_book_id','=',$id));
				}elseif (input_get('type') == "add_read") {
					$db->insert('library_reads', array('user_id' => $user->data()->id, 'library_book_id' => $id));
				}
			}
			// END Insert And Delete
			$actions->GetData('library_books', array('id','=',$id));
			$library->InsertViews($id);
			if (!empty($actions->data()->author_id)) {
				$ac_auth = new actions();
				$ac_auth->GetData('library_authors', array('id','=',$actions->data()->author_id));
				if (!cookies_exists('lang')) {
					$author_name = '<h5 class="mt-3"><a class="btn btn-outline-primary" href="/library/author_profile/?id='.$actions->data()->author_id.'&name='.$ac_auth->data()->name_en.'">'.$ac_auth->data()->name_en.'</a></h5>';
	            }else{
	                if (cookies_get("lang") == "en") {
	                    $author_name = '<h5 class="mt-3"><a class="btn btn-outline-primary" href="/library/author_profile/?id='.$actions->data()->author_id.'&name='.$ac_auth->data()->name_en.'">'.$ac_auth->data()->name_en.'</a></h5>';
	                }else{
	                    $author_name = '<h5 class="mt-3"><a class="btn btn-outline-primary" href="/library/author_profile/?id='.$actions->data()->author_id.'&name='.$ac_auth->data()->name_ku.'">'.$ac_auth->data()->name_ku.'</a></h5>';
	                }
	            }
	        }else{
	        	$author_name = '';
	        }
		}
	}
}
$token = hash_make($_SERVER['SERVER_NAME'],uniqid(mt_rand(), true));
session_put('last_token',$token);

?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/meta.php"; ?>
	<?=actions::MetaLibrary($actions->data()->name, $library->BooksImage($actions->data()->image))?>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/html/library/header.php"; ?>

<main>
	<div class="container">
	    <div align="center" class="row p-4 rounded-3 border shadow mt-3">
	    	<div class="col-md-3">
	    		<img width="80%" class="border rounded" src="<?=$library->BooksImage($actions->data()->image)?>">
	    		<form method="POST" class="d-grid gap-2 mt-3">
	    			<?php
	    			if (session_exists('user')) {
	    				if (actions::Count('library_favlist', array('user_id','=',$user->data()->id,'AND','library_book_id','=',$id)) > 0) {
	    					echo '<input type="hidden" name="type" value="remove_fav">';
	    					echo '<button class="btn btn-danger" type="submit">'.REMOVE_FROM_FFAVLIST.'</button>';
	    				}else{
	    					echo '<input type="hidden" name="type" value="add_fav">';
	    					echo '<button class="btn btn-secondary" type="submit">'.ADD_TO_FAV_LIST.'</button>';
	    				}
	    				echo '<input type="hidden" name="token" value="'.$token.'">';
	    			}else{
	    				echo '
	    				<a href="/signin/?ref=library&url='.GetCurrentURL().'" class="btn btn-secondary">Add to favorite list +</a>
	    				<a href="/signin/?ref=library&url='.GetCurrentURL().'" class="btn btn-warning">Add to read list +</a>
	    				';
	    			}
	    			?>
	    		</form>
	    		<form method="POST" class="d-grid gap-2 mt-3">
	    			<?php
	    			if (session_exists('user')) {
	    				if (actions::Count('library_reads', array('user_id','=',$user->data()->id,'AND','library_book_id','=',$id)) > 0) {
	    					echo '<input type="hidden" name="type" value="remove_read">';
	    					echo '<button class="btn btn-danger" type="submit">'.REMOVE_FROM_READLIST.'</button>';
	    				}else{
	    					echo '<input type="hidden" name="type" value="add_read">';
	    					echo '<button class="btn btn-warning" type="submit">'.ADD_TO_READ_LIST.'</button>';
	    				}
	    				echo '<input type="hidden" name="token" value="'.$token.'">';
	    			}
	    			?>
	    		</form>
	    	</div>
	    	<div class="col-md-6">
	    		<h2 style="direction:rtl;" class="p-2 border-bottom"><?=$actions->data()->name?></h2>
	    		<div><?=$author_name?></div>
	    		<div class="mt-3"><?=$library->CategoriesForRbooks($actions->data()->category_ids)?></div>
	    		<h6 class="mt-3"><span style="background-image: url(/control/template/media/svg/downloads.svg);" class="books_list_icns"></span> <?=$library->CountDownloads($id)?></h6>
	    		<h6 class="mt-3"><span style="background-image: url(/control/template/media/svg/eye.svg);" class="books_list_icns"></span> <?=$library->CountViews($id)?></h6>
				<div class="list-group">
					<?php
					if (!empty($actions->data()->book1)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead1" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_ONE.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead1', $actions->data()->book1,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book1.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_ONE.'</a>';
						}
					}if (!empty($actions->data()->book2)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead2" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_TWO.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead2', $actions->data()->book2,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book2.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_TWO.'</a>';
						}
					}if (!empty($actions->data()->book3)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead3" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_THREE.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead3', $actions->data()->book3,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book3.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_THREE.'</a>';
						}
					}if (!empty($actions->data()->book4)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead4" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_FOUR.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead4', $actions->data()->book4,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book4.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_FOUR.'</a>';
						}
					}if (!empty($actions->data()->book5)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead5" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_FIVE.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead5', $actions->data()->book5,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book5.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_FIVE.'</a>';
						}
					}if (!empty($actions->data()->book6)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead6" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_SIX.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead6', $actions->data()->book6,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book6.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_SIX.'</a>';
						}
					}if (!empty($actions->data()->book7)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead7" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_SEVEN.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead7', $actions->data()->book7,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book7.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_SEVEN.'</a>';
						}
					}if (!empty($actions->data()->book8)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead8" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_EIGHT.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead8', $actions->data()->book8,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book8.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_EIGHT.'</a>';
						}
					}if (!empty($actions->data()->book9)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead9" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_NINE.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead9', $actions->data()->book9,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book9.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_NINE.'</a>';
						}
					}if (!empty($actions->data()->book10)) {
						if (!isMobile()) {
							echo '<button type="button" data-bs-toggle="modal" data-bs-target="#ModalRead10" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.READ_BOOK_TEN.'</button>';
							echo $library->LibraryReadBook($id, 'ModalRead10', $actions->data()->book10,$actions->data()->name);
						}else{
							echo '<a target="_blank" href="https://programnas.com/control/files/'.$actions->data()->book10.'" class="list-group-item list-group-item-action d-flex gap-3 py-3">'.READ_BOOK_TEN.'</a>';
						}
					}
					?>
				</div>
				<div class="list-group mt-3">
					<?php
					if (!empty($actions->data()->book1)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book1.'\',\''.$actions->data()->book1.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_ONE.'</button>';
					}if (!empty($actions->data()->book2)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book2.'\',\''.$actions->data()->book2.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_TWO.'</button>';
					}if (!empty($actions->data()->book3)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book3.'\',\''.$actions->data()->book3.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_THREE.'</button>';
					}if (!empty($actions->data()->book4)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book4.'\',\''.$actions->data()->book4.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_FOUR.'</button>';
					}if (!empty($actions->data()->book5)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book5.'\',\''.$actions->data()->book5.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_FIVE.'</button>';
					}if (!empty($actions->data()->book6)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book6.'\',\''.$actions->data()->book6.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_SIX.'</button>';
					}if (!empty($actions->data()->book7)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book7.'\',\''.$actions->data()->book7.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_SEVEN.'</button>';
					}if (!empty($actions->data()->book8)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book8.'\',\''.$actions->data()->book8.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_EIGHT.'</button>';
					}if (!empty($actions->data()->book9)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book9.'\',\''.$actions->data()->book9.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_NINE.'</button>';
					}if (!empty($actions->data()->book10)) {
						echo '<button type="button" onclick="downloadURI(\'https://programnas.com/control/files/'.$actions->data()->book10.'\',\''.$actions->data()->book10.'\','.$id.')" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">'.DOWNLOAD_BOOK_TEN.'</button>';
					}
					?>
				</div>
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