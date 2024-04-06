<?php


/**
 * Mohammed D Mirzada
 */

class library{

    private $_user, $_db, $_actions;

    public function __construct(){
        $this->_db = db::getInstance();
        $this->_user = new user();
        $this->_actions = new actions();
    }

    public function GetHomeCategories(){
        $data = '';
        foreach ($this->_db->get('library_categories', array('id','>',0))->results() as $m) {
            if (!cookies_exists('lang')) {
                $cat_name = $m->name_en;
            }else{
                if (cookies_get("lang") == "en") {
                    $cat_name = $m->name_en;
                }else{
                    $cat_name = $m->name_ku;
                }
            }
            $data .= '<a href="/library/books/?t='.$m->id.'" class="ms-1 me-1 btn btn-outline-secondary">'.$cat_name.' <i style="background-image: url(/control/template/media/svg/'.$m->icon.');" class="icon_cats_lib"></i></a>';
        }
        return $data;
    }

    public function GetHomeBooks(){
        $data = '';
        foreach ($this->_db->get('library_books', array('id','>',0),18)->results() as $m) {
            $data .= '
            <a class="href-img-click" href="/library/read/?id='.$m->id.'&name='.$m->name.'">
                <span style="background-image: url('.$this->BooksImage($m->image).');" class="class-img0poster" width="15%" alt="'.$m->name.'"></span>
                <h6 class="mt-2 class-h6-titlename">'.$m->name.'</h6>
            </a>';
        }
        return $data;
    }

    public function GetAllBooks($category_id=null){
        if ($category_id == null) {
            $array = array('id','>',0);
            $total_rows = $this->_db->get('library_books',$array)->count();
            $t = 'all';
        }else{
            $array = array('category_ids','=',$category_id);
            $total_rows = $this->_db->get('library_books',$array)->count();
            $t = $category_id;
        }

        $data = '';

        if($total_rows > 0){
            $results_per_page = 48;
            $number_of_pages = ceil($total_rows/$results_per_page);
            if (!isset($_GET['p'])) {
                $p = 1;
            } else {
                $p = input_get('p');
            }
            $i = 1;
            $this_page_first_result = ($p-1)*$results_per_page;
            foreach ($this->_db->get('library_books',$array,$this_page_first_result.','.$results_per_page)->results() as $m) {
                $data .= '
                <a class="href-img-click" href="/library/read/?id='.$m->id.'&name='.$m->name.'">
                    <span style="background-image: url('.$this->BooksImage($m->image).');" class="class-img0poster" width="15%" alt="'.$m->name.'"></span>
                    <h6 class="mt-2 class-h6-titlename">'.$m->name.'</h6>
                </a>
                ';
                $i++;
            }
            $data .= '<div align="center" class="mt-3 horizScoll" style="overflow-x: auto;white-space: pre;"><nav><ul class="pagination" style="display: block;">';
            for ($p=1;$p<=$number_of_pages;$p++) {
                if (input_get('p') == $p) {
                    $data .= '<li class="page-item active"><a class="page-link" href="/library/books/?t='.$t.'&p='.$p.'">'.$p.'</a></li>';
                }elseif(empty(input_get('p'))){
                    if ($p == 1) {
                        $data .= '<li class="page-item active"><a class="page-link" href="/library/books/?t='.$t.'&p='.$p.'">'.$p.'</a></li>';
                    }else{
                        $data .= '<li class="page-item"><a class="page-link" href="/library/books/?t='.$t.'&p='.$p.'">'.$p.'</a></li>';
                    }
                }else{
                    $data .= '<li class="page-item"><a class="page-link" href="/library/books/?t='.$t.'&p='.$p.'">'.$p.'</a></li>';
                }
            }
            $data .= '</ul></nav></div>';
        }else{
            $data .= '<h4 align="center">'.NO_BOOKS_FOUND.'</h4>';
        }
        return $data;
    }

    public function GetAllAuthors(){
        $data = '';
        foreach ($this->_db->get('library_authors', array('id','>',0))->results() as $m) {
            if (!cookies_exists('lang')) {
                $name = $m->name_en;
            }else{
                if (cookies_get("lang") == "en") {
                    $name = $m->name_en;
                }else{
                    $name = $m->name_ku;
                }
            }

            $data .= '
            <div class="col-lg-4 lib__r_b">
                <img alt="'.$name.'" src="'.$this->AuthorsImage($m->image).'" class="bd-placeholder-img rounded-circle" width="200" height="200">
                <h3 class="mt-2 mb-2">'.$name.'</h3>
                <p><a class="btn btn-secondary" href="/library/author_profile/?id='.$m->id.'&name='.$name.'">'.VIEW_PROFILE.'</a></p>
            </div>';
        }
        return $data;
    }

    public function GetAllCategories(){
        $data = '';
        foreach ($this->_db->get('library_categories', array('id','>',0))->results() as $m) {
            if (!cookies_exists('lang')) {
                $cat_name = $m->name_en;
            }else{
                if (cookies_get("lang") == "en") {
                    $cat_name = $m->name_en;
                }else{
                    $cat_name = $m->name_ku;
                }
            }

            $data .= '
            <a href="/library/books?t='.$m->id.'" class="col d-flex align-items-start qa_hre_li_">
                <img style="margin-right: 8px;" width="44" height="44" src="/control/template/media/svg/'.$m->icon.'">
                <div>
                    <h5 class="fw-bold mb-0">'.$cat_name.'</h5>
                    <p>'.actions::Count('library_books', array('category_ids','=',$m->id)).' '.BOOKS_COUNTED.'</p>
                </div>
            </a>';
        }
        return $data;
    }

    public function GetAuthorBooks($author_id){
        $data = '';
        foreach ($this->_db->get('library_books', array('author_id','=',$author_id))->results() as $m) {
            $data .= '
            <a class="href-img-click" href="/library/read/?id='.$m->id.'&name='.$m->name.'">
                <span style="background-image: url('.$this->BooksImage($m->image).');" class="class-img0poster" width="15%" alt="'.$m->name.'"></span>
                <h6 class="mt-2 class-h6-titlename">'.$m->name.'</h6>
            </a>';
        }
        return $data;
    }

    public function CategoriesForRbooks($category_ids){
        $data = '';
        $i = 1;
        foreach (ConfigArray(explode(",", $category_ids)) as $ids) {
            $this->_actions->GetData('library_categories', array('id','=',$ids));
            if (!cookies_exists('lang')) {
                $cat_name = $this->_actions->data()->name_en;
            }else{
                if (cookies_get("lang") == "en") {
                    $cat_name = $this->_actions->data()->name_en;
                }else{
                    $cat_name = $this->_actions->data()->name_ku;
                }
            }
            if ($i == 1) {
                $data .= '<a href="/library/books/?t='.$ids.'" class="_Mar4LeftRight btn btn-primary">'.$cat_name.'</a>';
            }elseif($i == 2){
                $data .= '<a href="/library/books/?t='.$ids.'" class="_Mar4LeftRight btn btn-secondary">'.$cat_name.'</a>';
            }elseif ($i == 3) {
                $data .= '<a href="/library/books/?t='.$ids.'" class="_Mar4LeftRight btn btn-success">'.$cat_name.'</a>';
            }elseif ($i == 4) {
                $data .= '<a href="/library/books/?t='.$ids.'" class="_Mar4LeftRight btn btn-danger">'.$cat_name.'</a>';
            }elseif ($i == 5) {
                $data .= '<a href="/library/books/?t='.$ids.'" class="_Mar4LeftRight btn btn-warning text-dark">'.$cat_name.'</a>';
            }
            $i++;
        }
        return $data;
    }

    public function LibraryReadBook($library_book_id, $div_id, $book, $book_name){
        $this->_actions->GetData('library_books', array('id','=',$library_book_id));
        return '
        <div class="modal fade" id="'.$div_id.'" tabindex="-1" aria-labelledby="'.$div_id.'Label" aria-modal="true" role="dialog">
          <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title h4" id="'.$div_id.'Label">'.$book_name.'</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" style="padding:0;overflow: hidden;">
                <embed src="https://programnas.com/control/files/'.$book.'" width="100%" height="100%" />
              </div>
            </div>
          </div>
        </div>';
    }

    public function SearchResult($type, $q){
        $data = '';
        if ($type == "books") {
            if (!empty($q) && strlen($q) > 2) {
                $call = $this->_db->get('library_books', array('name','LIKE',"%".$q."%"));
                if ($call->count() > 0) {
                    foreach ($call->results() as $m) {
                        $data .= '
                            <a class="href-img-click" href="/library/read/?id='.$m->id.'&name='.$m->name.'">
                                <span style="background-image: url('.$this->BooksImage($m->image).');" class="class-img0poster" width="15%" alt="'.$m->name.'"></span>
                                <h6 class="mt-2 class-h6-titlename">'.$m->name.'</h6>
                            </a>
                        ';
                    }
                }else{
                    $data .= '<h4 align="center">'.NO_BOOKS_FOUND.'</h4>';
                }
            }else{
                $data .= '<h4 align="center">'.NO_BOOKS_FOUND.'</h4>';
            }
        }else{
            if (!empty($q) && strlen($q) > 2) {
                $call = $this->_db->get('library_authors', array('name_en','LIKE',"%".$q."%",'OR','name_ku','LIKE',"%".$q."%"));
                if ($call->count() > 0) {
                    foreach ($call->results() as $m) {
                        if (!cookies_exists('lang')) {
                            $name = $m->name_en;
                        }else{
                            if (cookies_get("lang") == "en") {
                                $name = $m->name_en;
                            }else{
                                $name = $m->name_ku;
                            }
                        }

                        $data .= '
                        <div class="col-lg-4">
                            <img alt="'.$name.'" src="'.$this->AuthorsImage($m->image).'" class="bd-placeholder-img rounded-circle" width="140" height="140">
                            <h3 class="mt-2 mb-2">'.$name.'</h3>
                            <p><a class="btn btn-secondary" href="/library/author_profile/?id='.$m->id.'&name='.$name.'">View Profile »</a></p>
                        </div>';
                    }
                }else{
                    $data .= '<h4 align="center">'.NO_AUTHORS_FOUND.'</h4>';
                }
            }else{
                $data .= '<h4 align="center">'.NO_AUTHORS_FOUND.'</h4>';
            }
        }
        return $data;
    }

    public function FavoriteListBooks(){
        $array = array('user_id','=',$this->_user->data()->id);
        $total_rows = $this->_db->get('library_favlist',$array)->count(); 
        $data = '';
        if($total_rows > 0){
            $results_per_page = 12;
            $number_of_pages = ceil($total_rows/$results_per_page);
            if (!isset($_GET['p'])) {
                $p = 1;
            } else {
                $p = input_get('p');
            }
            $this_page_first_result = ($p-1)*$results_per_page;
            foreach ($this->_db->get('library_favlist',$array,$this_page_first_result.','.$results_per_page)->results() as $m) {
                $this->_actions->GetData('library_books', array('id','=',$m->library_book_id));
                $data .= '
                <a class="href-img-click" href="/library/read/?id='.$m->library_book_id.'&name='.$this->_actions->data()->name.'">
                    <span style="background-image: url('.$this->BooksImage($this->_actions->data()->image).');" class="class-img0poster" width="15%" alt="'.$this->_actions->data()->name.'"></span>
                    <h6 class="mt-2 class-h6-titlename">'.$this->_actions->data()->name.'</h6>
                </a>';
            }
            $data .= '<div align="center" class="mt-3"><nav><ul class="pagination" style="display: block;">';
            for ($p=1;$p<=$number_of_pages;$p++) {
                if (input_get('p') == $p) {
                    $data .= '<li class="page-item active"><a class="page-link" href="/library/my_fav_books/?p='.$p.'">'.$p.'</a></li>';
                }elseif(empty(input_get('p'))){
                    if ($p == 1) {
                        $data .= '<li class="page-item active"><a class="page-link" href="/library/my_fav_books/?p='.$p.'">'.$p.'</a></li>';
                    }else{
                        $data .= '<li class="page-item"><a class="page-link" href="/library/my_fav_books/?p='.$p.'">'.$p.'</a></li>';
                    }
                }else{
                    $data .= '<li class="page-item"><a class="page-link" href="/library/my_fav_books/?p='.$p.'">'.$p.'</a></li>';
                }
            }
            $data .= '</ul></nav></div>';
        }else{
            $data .= '<h4 align="center">'.NO_BOOKS_FOUND.'</h4>';
        }
        return $data;
    }

    public function ReadsBooks(){
        $array = array('user_id','=',$this->_user->data()->id);
        $total_rows = $this->_db->get('library_reads',$array)->count(); 
        $data = '';
        if($total_rows > 0){
            $results_per_page = 12;
            $number_of_pages = ceil($total_rows/$results_per_page);
            if (!isset($_GET['p'])) {
                $p = 1;
            } else {
                $p = input_get('p');
            }
            $this_page_first_result = ($p-1)*$results_per_page;
            foreach ($this->_db->get('library_reads',$array,$this_page_first_result.','.$results_per_page)->results() as $m) {
                $this->_actions->GetData('library_books', array('id','=',$m->library_book_id));
                $data .= '
                <a class="href-img-click" href="/library/read/?id='.$m->library_book_id.'&name='.$this->_actions->data()->name.'">
                    <span style="background-image: url('.$this->BooksImage($this->_actions->data()->image).');" class="class-img0poster" width="15%" alt="'.$this->_actions->data()->name.'"></span>
                    <h6 class="mt-2 class-h6-titlename">'.$this->_actions->data()->name.'</h6>
                </a>';
            }
            $data .= '<div align="center" class="mt-3"><nav><ul class="pagination" style="display: block;">';
            for ($p=1;$p<=$number_of_pages;$p++) {
                if (input_get('p') == $p) {
                    $data .= '<li class="page-item active"><a class="page-link" href="/library/my_read_books/?p='.$p.'">'.$p.'</a></li>';
                }elseif(empty(input_get('p'))){
                    if ($p == 1) {
                        $data .= '<li class="page-item active"><a class="page-link" href="/library/my_read_books/?p='.$p.'">'.$p.'</a></li>';
                    }else{
                        $data .= '<li class="page-item"><a class="page-link" href="/library/my_read_books/?p='.$p.'">'.$p.'</a></li>';
                    }
                }else{
                    $data .= '<li class="page-item"><a class="page-link" href="/library/my_read_books/?p='.$p.'">'.$p.'</a></li>';
                }
            }
            $data .= '</ul></nav></div>';
        }else{
            $data .= '<h4 align="center">'.NO_BOOKS_FOUND.'</h4>';
        }
        return $data;
    }

    public function CountDownloads($library_book_id){
        return actions::Count('library_books_downloads', array('library_books_id','=',$library_book_id));
    }

    public function CountViews($library_book_id){
        return actions::Count('library_books_views', array('library_books_id','=',$library_book_id));
    }

    public function InsertDownloads($library_book_id){
        if (actions::Count('library_books_downloads', array('user_ip','=',prespe::GetUserIP(),'AND','library_books_id','=',$library_book_id)) == 0) {
            $this->_db->insert('library_books_downloads', array('user_ip' => prespe::GetUserIP(), 'library_books_id' => $library_book_id));
        }
    }

    public function InsertViews($library_book_id){
        if (actions::Count('library_books_views', array('user_ip','=',prespe::GetUserIP(),'AND','library_books_id','=',$library_book_id)) == 0) {
            $this->_db->insert('library_books_views', array('user_ip' => prespe::GetUserIP(), 'library_books_id' => $library_book_id));
        }
    }

    public function BooksImage($image=''){
        return (empty($image)) ? 'https://programnas.com/control/template/media/jpg/lib_no_image.jpg' : 'https://programnas.com/control/lpictures/'.$image ;
    }

    public function AuthorsImage($image=''){
        return (empty($image)) ? 'https://programnas.com/control/template/media/jpg/auth_no_img.jpg' : 'https://programnas.com/control/lpictures/'.$image ;
    }

}


?>