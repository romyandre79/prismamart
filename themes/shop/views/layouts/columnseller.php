<?php $this->beginContent('//layouts/main'); ?>
<div class="page-content layout-3 mt-4">
  <div class="container-fluid px-0">
    <div class="wrapper-toggle">
      <div class="sidebar-menu-toggle">
        <div class="row">
          <div class="col">
            <a href="#" class="btn btn-block btn-sidebar-toggle">
              <span class="icon">
                <i class="fas fa-chevron-left text-secondary"></i>
              </span>
              <span class="teks">Sembunyikan Menu</span>
            </a>
          </div>
        </div>
        <div class="row body-sidebar-toggle">
          <div class="col">
            <div class="profil-area d-flex align-items-center">
              <img src="<?php echo Yii::app()->request->baseUrl.'/images/supplier/'.Yii::app()->user->logo ?>" class="img-fluid rounded photo-profil" width="50"
                alt="profil" />
              <div class="profil-body-area">
                <h6 class="mb-0"><?php echo Yii::app()->user->shopname?></h6>
                <div class="badges-icon-list">
                  <img src="../../images/icons/side-profil-badges-icon.svg.svg"
                    class="img-fluid border-right pr-2 mr-1" alt="icon" />
                  <img src="../../images/icons/side-profil-check-icon.svg" class="img-fluid" alt="icon" />
                  <span>0</span>
                </div>
              </div>
            </div>

            <div class="wrap-progress-seller">
              <div class="row">
                <div class="col-8">
                  <div class="progress-wrap">
                    <div class="progress">
                      <div class="progress-bar rounded-pill" role="progressbar" style="width: 80%" aria-valuenow="80"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <p class="mb-0 d-inline-block"><span>80</span>/100</p>
                </div>
              </div>
            </div>

            <div class="regular-merchant-section clearfix">
              <a href="#" class="float-left">Reguler Merchant</a>
              <a href="pengaturan-toko-power-merchant.html" class="float-right">Upgrade</a>
            </div>

            <nav class="nav flex-column nav-saldo border-bottom pb-3 mt-3">
              <a class="nav-link clearfix" href="#">
                <span class="float-left">Saldo</span>
                <span class="float-right strong-val">Rp0</span>
              </a>
            </nav>

            <nav class="nav flex-column nav-single-link mt-4">
              <a class="nav-link d-flex align-items-center" href="<?php echo Yii::app()->createUrl('common/supplier/sellerinfo')?>">
                <img src="../../images/icons/side-toggle-home-icon.svg" class="img-fluid" alt="home" />
                <span>Home</span>
              </a>
              <a class="nav-link d-flex align-items-center" href="<?php echo Yii::app()->createUrl('common/supplier/sellerchat')?>">
                <img src="../../images/icons/side-toggle-chat-icon.svg" class="img-fluid" alt="chat" />
                <span>Chat</span>
              </a>
              <a class="nav-link d-flex align-items-center" href="<?php echo Yii::app()->createUrl('common/supplier/sellerdiskusi')?>">
                <img src="../../images/icons/side-toggle-diskusi-icon.svg" class="img-fluid" alt="diskusi" />
                <span>Diskusi</span>
              </a>
            </nav>

            <nav class="nav flex-column menu-collapse nav-collapse-link">
              <a class="btn btn-white rounded-0 text-left clearfix nav-link-title collapsed" data-toggle="collapse"
                href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
                <span class="float-left">
                  <img src="../../images/icons/side-toggle-produk-icon.svg" class="img-fluid" alt="produk" />
                  <span>Produk</span>
                </span>
                <span class="float-right icon-rotate">
                  <i class="fas fa-chevron-down"></i>
                </span>
              </a>
              <div class="collapse" id="collapse1">
                <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/selleraddproduct')?>"><span>Tambah Produk</span></a>
                <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerproductlist')?>"><span>Daftar Produk</span></a>
              </div>
            </nav>

            <nav class="nav flex-column nav-single-link border-bottom pb-2">
              <a class="nav-link d-flex align-items-center" href="<?php echo Yii::app()->createUrl('common/supplier/sellersales')?>">
                <img src="../../images/icons/side-toggle-penjualan-icon.svg" class="img-fluid" alt="penjualan" />
                <span>Penjualan</span>
              </a>
            </nav>

            <nav class="nav flex-column menu-collapse nav-collapse-link mt-2">
              <a class="btn btn-white rounded-0 text-left clearfix nav-link-title collapsed" data-toggle="collapse"
                href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
                <span class="float-left">
                  <img src="../../images/icons/side-toggle-statistik-icon.svg" class="img-fluid" alt="statistik" />
                  <span>Statistik</span>
                </span>
                <span class="float-right icon-rotate">
                  <i class="fas fa-chevron-down"></i>
                </span>
              </a>
              <div class="collapse" id="collapse2">
                <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerwawasan')?>"><span>Wawasan Toko</span></a>
              </div>
            </nav>
            <nav class="nav flex-column nav-single-link">
              <a class="nav-link d-flex align-items-center" href="<?php echo Yii::app()->createUrl('common/supplier/sellerpromo')?>">
                <img src="../../images/icons/side-toggle-iklan-promosi-icon.svg" class="img-fluid"
                  alt="iklan promosi" />
                <span>Iklan dan Promosi</span>
              </a>
              <a class="nav-link d-flex align-items-center" href="<?php echo Yii::app()->createUrl('common/supplier/sellerdekorasi')?>">
                <img src="../../images/icons/side-toggle-dekorasi-toko-icon.svg" class="img-fluid"
                  alt="dekorasi toko" />
                <span>Dekorasi Toko</span>
              </a>
            </nav>

            <nav class="nav flex-column menu-collapse nav-collapse-link">
              <a class="btn btn-white rounded-0 text-left clearfix nav-link-title collapsed" data-toggle="collapse"
                href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
                <span class="float-left">
                  <img src="../../images/icons/side-toggle-kata-pembeli-icon.svg" class="img-fluid"
                    alt="kata pembeli" />
                  <span>Kata Pembeli</span>
                </span>
                <span class="float-right icon-rotate">
                  <i class="fas fa-chevron-down"></i>
                </span>
              </a>
              <div class="collapse" id="collapse3">
                <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerulasan')?>"><span>Ulasan</span></a>
                <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerkomplain')?>"><span>Komplain</span></a>
              </div>
            </nav>

            <nav class="nav flex-column nav-single-link border-bottom pb-2">
              <a class="nav-link d-flex align-items-center" href="<?php echo Yii::app()->createUrl('common/supplier/sellerprint')?>">
                <img src="../../images/icons/side-toggle-amani-mart-print-icon.svg" class="img-fluid"
                  alt="Prisma mart print" />
                <span>Prisma Mart Print</span>
              </a>
            </nav>

            <nav class="nav flex-column nav-single-link border-bottom pb-2 mt-2">
              <a class="nav-link d-flex align-items-center" href="<?php echo Yii::app()->createUrl('blog/post/read/info-pusat-edukasi')?>">
                <img src="../../images/icons/side-toggle-pusat-edukasi-seller-icon.svg" class="img-fluid"
                  alt="pusat edukasi seller" />
                <span>Pusat Edukasi Seller</span>
                <i class="fas fa-external-link-alt icon-ext-link ml-auto"></i>
              </a>
              <a class="nav-link d-flex align-items-center" href="<?php echo Yii::app()->createUrl('blog/post/read/info-prisma-care')?>">
                <img src="../../images/icons/side-toggle-amani-mart-care-icon.svg" class="img-fluid"
                  alt="Prisma mart care" />
                <span>Prisma Mart Care</span>
                <i class="fas fa-external-link-alt icon-ext-link ml-auto"></i>
              </a>
            </nav>

            <nav class="nav flex-column menu-collapse nav-collapse-link">
              <a class="btn btn-white rounded-0 text-left clearfix nav-link-title collapsed" data-toggle="collapse"
                href="#collapse4" role="button" aria-expanded="false" aria-controls="collapse4">
                <span class="float-left">
                  <img src="../../images/icons/side-toggle-pengaturan-icon.svg" class="img-fluid" alt="pengaturan" />
                  <span>Pengaturan</span>
                </span>
                <span class="float-right icon-rotate">
                  <i class="fas fa-chevron-down"></i>
                </span>
              </a>
              <div class="collapse" id="collapse4">
                <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellershop')?>"><span>Pengaturan Toko</span></a>
                <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellershopadmin')?>"><span>Pengaturan Admin</span></a>
              </div>
            </nav>
          </div>
        </div>
      </div>
      <div class="content-toggle data-product seller-home">
        <div class="row">
          <div class="col-12">
            <?php echo $content ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->endContent(); ?>