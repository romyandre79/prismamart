<?php $this->beginContent('//layouts/main'); ?>
<div class="page-content page-biodata-diri layout-2 start">
  <div class="container">
      <div class="row justify-content-center">
          <div class="side-menu-wrap order-last order-lg-first mt-4 mt-lg-0">
              <div class="side-menus">
                  <div class="profil-area d-flex align-items-center">
                    <?php getpicture(Yii::app()->request->baseUrl.'/images/useraccess/'.Yii::app()->user->picture, Yii::app()->user->realname,
                      37,37,'img-fluid rounded mr-2')?>
                      <div class="d-inline-block">
                          <h6 class="mb-0"><?php echo Yii::app()->user->realname?></h6>
                      </div>
                  </div>

                  <div class="row sub-toko-point">
                      <div class="col-12 d-flex align-items-start">
                          <img src="<?php echo Yii::app()->request->baseUrl.'/images/icons/side-saldo-icon.svg'?>" class="img-fluid" alt="icon">
                          <div class="d-inline-block w-100">
                              <nav class="nav flex-column">
                                  <a class="nav-link clearfix" href="#">
                                      <span class="float-left">PrismaPay Cash</span>
                                      <span class="float-right">Rp 0</span>
                                  </a>
                                  <a class="nav-link clearfix" href="#">
                                      <span class="float-left">PrismaPay Points</span>
                                      <span class="float-right">0</span>
                                  </a>
                                  <a class="nav-link clearfix" href="#">
                                      <span class="float-left">Saldo</span>
                                      <span class="float-right">0</span>
                                  </a>
                                  <div class="devider"></div>
                              </nav>
                          </div>
                      </div>
                  </div>

                  <nav class="nav flex-column border-bottom pb-1 menu-collapse">
                      <a class="btn btn-white rounded-0 text-left clearfix nav-link-title" data-toggle="collapse"
                          href="#kotakMasukMenu" role="button" aria-expanded="false"
                          aria-controls="kotakMasukMenu">
                          <span class="float-left">Kotak Masuk</span>
                          <span class="float-right icon-rotate icon-open">
                              <i class="fas fa-chevron-down"></i>
                          </span>
                      </a>
                      <div class="collapse show" id="kotakMasukMenu">
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/mychat'?>"><span>Chat</span></a>
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/mydiscussion'?>"><span>Diskusi Produk</span></a>
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/myulasan'?>"><span>Ulasan</span></a>
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/myhelp'?>"><span>Pesan Bantuan</span></a>
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/mycomplaint'?>"><span>Komplain Pesanan</span></a>
                      </div>
                  </nav>

                  <nav class="nav flex-column border-bottom pb-1 menu-collapse">
                      <a class="btn btn-white rounded-0 text-left clearfix nav-link-title" data-toggle="collapse"
                          href="#pembelianMenu" role="button" aria-expanded="false" aria-controls="pembelianMenu">
                          <span class="float-left">Pembelian</span>
                          <span class="float-right icon-rotate icon-open">
                              <i class="fas fa-chevron-down"></i>
                          </span>
                      </a>
                      <div class="collapse show" id="pembelianMenu">
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/mywaitpayment'?>"><span>Menunggu Pembayaran</span></a>
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/mytranslist'?>"><span>Daftar Transaksi</span></a>
                      </div>
                  </nav>

                  <nav class="nav flex-column menu-collapse">
                      <a class="btn btn-white rounded-0 text-left clearfix nav-link-title" data-toggle="collapse"
                          href="#profilSayaMenu" role="button" aria-expanded="false"
                          aria-controls="profilSayaMenu">
                          <span class="float-left">Profil Saya</span>
                          <span class="float-right icon-rotate icon-open">
                              <i class="fas fa-chevron-down"></i>
                          </span>
                      </a>
                      <div class="collapse show" id="profilSayaMenu">
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/mywish'?>"><span>Wishlist</span></a>
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/myfavourite'?>"><span>Toko Favorit</span></a>
                          <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl.'/common/supplier/myaccount'?>"><span>Pengaturan</span></a>
                      </div>
                  </nav>
              </div>
          </div>

          <div class="content order-first order-lg-last">
              <div class="row">
                  <div class="col">
                      <h6 class="title-content-page">
                          <i class="far fa-user mr-1"></i>
                          <span><?php echo Yii::app()->user->realname?></span>
                      </h6>
                  </div>
              </div>

              <?php echo $content; ?>	
          </div>
      </div>
  </div>
</div>
<?php $this->endContent(); ?>