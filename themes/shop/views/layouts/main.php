<!DOCTYPE html>
<html lang="en">
<head>
  <?php display_seo($this->metatag, $this->description, $this->pageTitle); ?>
  <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
</head>
<body>
  <!-- hero image -->
<?php if (Yii::app()->user->name !== 'Guest') { ?>
<div class="fixed-top">
  <?php } else { ?>
<div class="sticky-top">
  <?php } ?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white puldapii-navbar">
      <div class="container-fluid">
        <a class="navbar-brand d-lg-none" href="#">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/logo.jpg" height="45" alt="" loading="lazy">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="#">
                <img src="<?php echo Yii::app()->request->baseUrl?>/images/icons/nav-download-app-icon.svg" class="img-fluid mr-2" alt="download app">
                <span>Download Prisma Mart App</span>
              </a>
            </li>
          </ul>

          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo Yii::app()->createUrl('blog/post/read/info-prisma-mart')?>">Tentang Prisma Mart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo Yii::app()->createUrl('blog/post/read/info-mulai-jual')?>">Mulai Berjualan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo Yii::app()->createUrl('blog/post/read/info-promo')?>">Promo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/product/donasi')?>">Donasi</a>
            </li>
          </ul>

          <ul class="navbar-nav d-block d-lg-none border-top menus-mobile">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="kategoriNavDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Kategori
              </a>
              <div class="dropdown-menu" aria-labelledby="kategoriNavDropdown">
              <?php $matgroups = getmaterialgroup('BJ',5,0);
        foreach ($matgroups as $matgroup) {?>
         <a class="dropdown-item" href="<?php echo Yii::app()->createUrl('common/supplier/category/'.$matgroup['slug'])?>"><?php echo $matgroup['description']?></a>
        <?php }?>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Keranjang</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- ./End Navbar -->

    <!-- Header -->
    <header class="navbar navbar-expand-lg navbar-light bg-white d-none d-lg-flex puldapii-header">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/logo.jpg" height="45" alt="" loading="lazy">
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item">
              <span class="p-2 text-secondary">Kategori</span>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0 w-75">
            <div class="input-group w-100 group-active-bordered">
              <input type="text" class="form-control border-right-0 shadow-none"
                aria-describedby="button-kategoriSearchHeader">
              <div class="input-group-append">
                <button class="btn btn-search shadow-none border-left-0" type="button" id="button-kategoriSearchHeader">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
            <nav class="nav w-100 nav-kategori">
              <a class="nav-link" href="#">Kurta</a>
              <a class="nav-link" href="#">Beras</a>
              <a class="nav-link" href="#">Gamis</a>
              <a class="nav-link" href="#">Kitab</a>
              <a class="nav-link" href="#">Masker</a>
              <a class="nav-link" href="#">Hijab</a>
              <a class="nav-link" href="#">Laptop</a>
            </nav>
          </form>

          <?php if (Yii::app()->user->name !== 'Guest') { ?>
          <ul class="navbar-nav border-right pr-3 mr-3 nav-icon ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-shopping-cart"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-bell"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-envelope"></i>
              </a>
            </li>
          </ul>

          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerinfo')?>">
                <img src="<?php echo Yii::app()->request->baseUrl.'/images/supplier/'.Yii::app()->user->logo?>" class="img-fluid rounded-circle mr-1" width="28" alt="profil">
                <span><?php echo Yii::app()->user->shopname?></span>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-primary" href="#" id="profileDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="<?php echo Yii::app()->request->baseUrl.'/images/useraccess/'.Yii::app()->user->picture?>" class="img-fluid rounded-circle mr-1 d-block" width="28" alt="profil">
                <span><?php echo Yii::app()->user->realname?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="<?php echo Yii::app()->createUrl('common/supplier/myaccount')?>"><span class=" btn btn-sm btn-danger-outlined btn-block"><i
                      class="fas fa-sign-out-alt"></i> Akun Saya</span></a>
                <a class="dropdown-item" href="<?php echo Yii::app()->createUrl('logout')?>"><span class=" btn btn-sm btn-danger-outlined btn-block"><i
                      class="fas fa-sign-out-alt"></i> Logout</span></a>
              </div>
            </li>
          </ul>
          <?php } else {?>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="#" class="btn-link signin" data-toggle="modal" data-target="#loginModal">Masuk</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo Yii::app()->createUrl('site/register')?>" class="btn-link signup">Daftar</a>
            </li>
          </ul>
          <?php } ?>
        </div>
      </div>
    </header>
    <!-- ./End Header -->
  </div>
  
  <section class="modal-login" style="background-color: #ffffff">
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5 class="m-signin"><a href="">Masuk</a></h5>
              </div>
              <div>
                <h5 class="m-signup"><a href="<?php echo Yii::app()->createUrl('site/register')?>">Daftar</a></h5>
              </div>
            </div>
            <form method="post" role="form">
            <div class="form-group">
              <label for="pptt">User Name</label>
              <input type="text" class="form-control" id="pptt" name="pptt" />
            </div>
            <div class="form-group">
              <label for="sstt">Password</label>
              <input type="password" class="form-control" id="sstt" name="sstt" />
            </div>
            <p class="text-right"><a href="<?php echo Yii::app()->createUrl('site/forgetpass')?>">Lupa Kata Sandi?</a></p>
            <button href="#" type="button" class="btn btn-block" onclick="submituser()">Login</button>
  </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php echo $content?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/css/style.css">
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl ?>/css/toastr.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- owl carousel -->
  <script src="<?php echo Yii::app()->theme->baseUrl.'/js/script.js'?>"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl.'/js/style.js'?>"></script>
  <script src="<?php echo Yii::app()->request->baseUrl.'/js/toastr.min.js'?>"></script>
  <script src="<?php echo Yii::app()->request->baseUrl ?>/js/lazysizes.min.js"></script>

  <script type="text/javascript">
function submituser() {
		jQuery.ajax({'url': '<?php echo Yii::app()->createUrl('site/login') ?>',
			'data': {
				'pptt': $("input[name='pptt']").val(),
				'sstt': $("input[name='sstt']").val(),
			},
			'type': 'post', 'dataType': 'json',
			'success': function (data) {
				if (data.status == "success") {
					location.href = "<?php echo Yii::app()->createUrl('site/index') ?>";
				} else {
					toastr.error(data.msg);
				}
			},
			'cache': false});
	}
    if ('ontouchstart' in document.documentElement) {      
      document.addEventListener('touchstart', onTouchStart, {passive: true});
    };
  </script>

</body>

</html>