<header class="p-3 mb-1 border-bottom">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/library" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
        <i class="img_logo_lib"></i>
      </a>
      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/library" class="nav-link px-2 link-dark"><?=HOME?></a></li>
        <li><a href="/library/books" class="nav-link px-2 link-dark"><?=BOOKS?></a></li>
        <li><a href="/library/authors" class="nav-link px-2 link-dark"><?=AUTHORS?></a></li>
        <li><a href="/library/categories" class="nav-link px-2 link-dark"><?=CATEGORIES?></a></li>
      </ul>
      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" method="GET" action="/library/search">
        <input type="search" class="form-control" placeholder="<?=FIND_LIB_CONTENT?>" aria-label="Search" name="q">
      </form>
      <?php if (session_exists('user')) { ?>
        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?=$user->ImageIcon()?>" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
            <li><a class="dropdown-item" href="/library/my_read_books"><?=MY_READ_BOOKS?></a></li>
            <li><a class="dropdown-item" href="/library/my_fav_books"><?=MY_FAV_BOOKS?></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout"><?=LOGOUT?></a></li>
          </ul>
        </div>
      <?php }else{ ?>
        <div>
          <a class="btn btn-outline-primary me-2" href="https://programnas.com/signin?ref=library"><?=SIGNIN?></a>
          <a class="btn btn-primary" href="https://programnas.com/signup"><?=SIGNIP?></a>
        </div>
      <?php } ?>
    </div>
  </div>
</header>