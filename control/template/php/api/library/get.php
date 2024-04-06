<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

$db = db::getInstance();
$actions = new actions();

switch (input_get('tool')) {
	case 'get_categories':
		$lang = input_get('lang');
		foreach ($db->get('library_categories', array('id','>',0))->results() as $m) {
			if (empty($lang)) {
				$name = $m->name_en;
			}else{
				if ($lang == 'en') {
					$name = $m->name_en;
				}else{
					$name = $m->name_ku;
				}
			}
			$category_id = $m->id;
			$books = actions::Count('library_books', array('category_ids','=',$m->id));
			$image = 'https://programnas.com/control/template/media/png/'.$m->png;
			$json['data'][] = array(
		        'name' => $name,
		        'category_id' => $category_id,
		        'image' => $image,
		        'books' => $books
		    );
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_user':
		$user = new user(input_get('user_id'));
		$json['data'][] = array(
		    'name' => $user->data()->name,
		    'username' => $user->data()->username,
		    'image' => $user->ImageIcon()
		);
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_home_books':
		$library = new library();
		foreach ($db->get('library_books', array('id','>',0), 10)->results() as $m) {
			$json['data'][] = array(
		        'name' => $m->name,
		        'image' => $library->BooksImage($m->image),
		        'id' => $m->id
		    );
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_home_authors':
		$lang = input_get('lang');
		$library = new library();
		foreach ($db->get('library_authors', array('id','>',0),null,'ASC')->results() as $m) {
			if (empty($lang)) {
				$name = $m->name_en;
			}else{
				if ($lang == 'en') {
					$name = $m->name_en;
				}else{
					$name = $m->name_ku;
				}
			}
			$image = 'https://programnas.com/control/template/media/png/'.$m->png;
			$json['data'][] = array(
		        'name' => $name,
		        'id' => $m->id,
		        'image' => $library->AuthorsImage($m->image),
		        'books' => $books
		    );
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_search':
		$q = input_get('q');
		$library = new library();
		if (actions::Count('library_books', array('name','LIKE',"%".$q."%")) > 0) {
			foreach ($db->get('library_books', array('name','LIKE',"%".$q."%"))->results() as $m) {
				$json['data'][] = array(
		        	'name' => $m->name,
		        	'image' => $library->BooksImage($m->image),
		        	'id' => $m->id
		    	);
			}
		}else{
			$json = array('result' => false);
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_all_books':
		$library = new library();
		$array = array('id','>',0);
        $total_rows = $db->get('library_books',$array)->count();
        $results_per_page = 40;
        $number_of_pages = ceil($total_rows/$results_per_page);
        if (!isset($_GET['p'])) {
            $p = 1;
        }else {
            $p = input_get('p');
        }
        $this_page_first_result = ($p-1)*$results_per_page;
        foreach ($db->get('library_books',$array,$this_page_first_result.','.$results_per_page)->results() as $m) {
        	$json['data'][] = array(
		        'name' => $m->name,
		        'image' => $library->BooksImage($m->image),
		        'id' => $m->id,
		        'number_of_pages' => $number_of_pages
		    );
        }
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_all_favlist_books':
		$library = new library();
		$array = array('user_id','=',input_get('user_id'));
        $total_rows = $db->get('library_favlist',$array)->count();
        $results_per_page = 40;
        $number_of_pages = ceil($total_rows/$results_per_page);
        if (!isset($_GET['p'])) {
            $p = 1;
        }else {
            $p = input_get('p');
        }
        $this_page_first_result = ($p-1)*$results_per_page;
        foreach ($db->get('library_favlist',$array,$this_page_first_result.','.$results_per_page)->results() as $m) {
        	$actions->GetData('library_books', array('id','=',$m->library_book_id));
        	$json['data'][] = array(
		        'name' => $actions->data()->name,
		        'image' => $library->BooksImage($actions->data()->image),
		        'id' => $actions->data()->id,
		        'number_of_pages' => $number_of_pages
		    );
        }
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_all_reads_books':
		$library = new library();
		$array = array('user_id','=',input_get('user_id'));
        $total_rows = $db->get('library_reads',$array)->count();
        $results_per_page = 40;
        $number_of_pages = ceil($total_rows/$results_per_page);
        if (!isset($_GET['p'])) {
            $p = 1;
        }else {
            $p = input_get('p');
        }
        $this_page_first_result = ($p-1)*$results_per_page;
        foreach ($db->get('library_reads',$array,$this_page_first_result.','.$results_per_page)->results() as $m) {
        	$actions->GetData('library_books', array('id','=',$m->library_book_id));
        	$json['data'][] = array(
		        'name' => $actions->data()->name,
		        'image' => $library->BooksImage($actions->data()->image),
		        'id' => $actions->data()->id,
		        'number_of_pages' => $number_of_pages
		    );
        }
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_all_category_books':
		$library = new library();
		$array = array('category_ids','=',input_get('category_id'));
        $total_rows = $db->get('library_books',$array)->count();
        $results_per_page = 40;
        $number_of_pages = ceil($total_rows/$results_per_page);
        if (!isset($_GET['p'])) {
            $p = 1;
        }else {
            $p = input_get('p');
        }
        $this_page_first_result = ($p-1)*$results_per_page;
        foreach ($db->get('library_books',$array,$this_page_first_result.','.$results_per_page)->results() as $m) {
        	$json['data'][] = array(
		        'name' => $m->name,
		        'image' => $library->BooksImage($m->image),
		        'id' => $m->id,
		        'number_of_pages' => $number_of_pages
		    );
        }
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_book':
		$library = new library();
		$id = input_get('id');
		$lang = input_get('lang');
		$user_id = input_get('user_id');
		$actions->GetData('library_books', array('id','=',$id));
		$a = new actions();
		$a->GetData('library_authors', array('id','=',$actions->data()->author_id));
		if (empty($lang)) {
			$author_name = $a->data()->name_en;
		}else{
			if ($lang == 'en') {
				$author_name = $a->data()->name_en;
			}else{
				$author_name = $a->data()->name_ku;
			}
		}
		$b = new actions();
		$b->GetData('library_categories', array('id','=',$actions->data()->category_ids));
		if (empty($lang)) {
			$category_name = $b->data()->name_en;
		}else{
			if ($lang == 'en') {
				$category_name = $b->data()->name_en;
			}else{
				$category_name = $b->data()->name_ku;
			}
		}
		$is_fav = (actions::Count('library_favlist', array('library_book_id','=',$id,'AND','user_id','=',$user_id)) == 0) ? false : true;
		$is_read = (actions::Count('library_reads', array('library_book_id','=',$id,'AND','user_id','=',$user_id)) == 0) ? false : true;
		$json = array(
			'author_name' => $author_name,
		    'category_name' => $category_name,
		    'views' => $library->CountViews($id),
		    'downloads' => $library->CountDownloads($id),
		    'is_fav' => $is_fav,
		    'is_read' => $is_read,
		    'book1' => $actions->data()->book1,
		    'book2' => $actions->data()->book2,
		    'book3' => $actions->data()->book3,
		    'book4' => $actions->data()->book4,
		    'book5' => $actions->data()->book5,
		    'book6' => $actions->data()->book6,
		    'book7' => $actions->data()->book7,
		    'book8' => $actions->data()->book8,
		    'book9' => $actions->data()->book9,
		    'book10' => $actions->data()->book10
		);
		$library->InsertViews($id);
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'get_author_books':
		$library = new library();
		$author_id = input_get('author_id');
		foreach ($db->get('library_books', array('author_id','=',$author_id))->results() as $m) {
        	$json["data"][] = array(
		        'name' => $m->name,
		        'image' => $library->BooksImage($m->image),
		        'id' => $m->id
		    );
        }
		echo json_encode($json,JSON_UNESCAPED_UNICODE);
	break;
	case 'add_fav':
		$book_id = input_get('book_id');
		$user_id = input_get('user_id');
		if (actions::Count('library_favlist', array('user_id','=',$user_id,'AND','library_book_id','=',$book_id)) == 0) {
			$db->insert('library_favlist', array('user_id' => $user_id, 'library_book_id' => $book_id));
			echo json_encode("Inserted",JSON_UNESCAPED_UNICODE);
		}else{
			$db->delete('library_favlist', array('user_id','=',$user_id,'AND','library_book_id','=',$book_id));
			echo json_encode("Removed",JSON_UNESCAPED_UNICODE);
		}
	break;
	case 'add_read':
		$book_id = input_get('book_id');
		$user_id = input_get('user_id');
		if (actions::Count('library_reads', array('user_id','=',$user_id,'AND','library_book_id','=',$book_id)) == 0) {
			$db->insert('library_reads', array('user_id' => $user_id, 'library_book_id' => $book_id));
			echo json_encode("Inserted",JSON_UNESCAPED_UNICODE);
		}else{
			$db->delete('library_reads', array('user_id','=',$user_id,'AND','library_book_id','=',$book_id));
			echo json_encode("Removed",JSON_UNESCAPED_UNICODE);
		}
	break;
	default:
		redirect_to("/");
	break;
}

?>