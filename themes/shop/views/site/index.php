<?php if (Yii::app()->user->name !== 'Guest') { ?>
  <section class="logged">
    <div class="container">
      <div class="row">
        <div class="list-body mx-2 mx-md-0">
          <ul class="list-group list-group-horizontal-md">
            <li class="list-group-item">
              <div class="profile">
                <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/download.jpeg" class="img-fluid rounded-circle" alt="">
                <span class="name"><?php echo Yii::app()->user->realname?></span>
              </div>
            </li>
            <li class="list-group-item">
              <div class="main" data-toggle="collapse" href="#demo" role="button" aria-expanded="false"
                aria-controls="demo">
                <div class="head"> <i class="fas fa-money-bill-wave"></i> Saldo Prismapay</div>
                <div class="chevron" id="myID"><i class="fas fa-chevron-down"></i></div>
              </div>
              <div id="demo" class=" collapse collapses">
                <div style="display: flex;">
                  <span>saldo</span>
                  <span>Rp 30.000</span>
                </div>
                <span> <a href="">Top-up Saldo</a></span>
              </div>
            </li>
            <li class="list-group-item">
              <div class="main" data-toggle="collapse" href="#demo1" role="button" aria-expanded="false"
                aria-controls="demo1">
                <div class="head"> <i class="fas fa-star-half-alt"></i> Member Silver</div>
                <div class="chevron"><i class="fas fa-chevron-down"></i></div>
              </div>
              <div id="demo1" class=" collapse collapses">
                <span> <a href=""> Toko Member</a></span>
                <span> <a href=""> Kupon Saya</a></span>
                <span> <a href=""> Daftar Anggota Koperasi</a></span>
              </div>
            </li>
            <li class="list-group-item">
              <div class="main" data-toggle="collapse" href="#demo2" role="button" aria-expanded="false"
                aria-controls="demo2">
                <div class="head">Kotak Masuk</div>
                <div class="chevron"><i class="fas fa-chevron-down"></i></div>
              </div>
              <div id="demo2" class=" collapse collapses">
                <span><a href=""> Chat</a></span>
                <span> <a href=""> Diskusi produk</a></span>
                <span> <a href=""> Ulasan </a></span>
                <span><a href=""> Pesan bantuan</a></span>
                <span> <a href=""> Komplain pesanan</a></span>
                <span><a href=""> Update </a> </span>
              </div>
            </li>
            <li class="list-group-item">
              <div class="main" data-toggle="collapse" href="#demo3" role="button" aria-expanded="false"
                aria-controls="demo3">
                <div class="head">Pembelian</div>
                <div class="chevron"><i class="fas fa-chevron-down"></i></div>
              </div>
              <div id="demo3" class=" collapse collapses">
                <span>Menunggu pembayaran</span>
                <span>Daftar transaksi</span>
              </div>
            </li>
            <li class="list-group-item">
              <div class="main" data-toggle="collapse" href="#demo4" role="button" aria-expanded="false"
                aria-controls="demo3">
                <div class="head">Profil Saya</div>
                <div class="chevron"><i class="fas fa-chevron-down"></i></div>
              </div>
              <div id="demo4" class=" collapse collapses">
                <span>Whislist</span>
                <span>Toko favorit</span>
                <span>Pengaturan</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <?php } ?>

<!-- hero image -->
<section class="hero-img">
  <div class="container">
    <div class="row">
      <div class="col">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
          <?php $i=0; $slides = getslideshow('Main Banner');
        foreach ($slides as $slide) {
          if ($i == 0) {
            $i++;
        ?>
        <li data-target="#MainBanner" data-slide-to="<?php echo $i ?>" class="active"></li>
          <?php } else {?>
            <li data-target="#MainBanner" data-slide-to="<?php echo $i ?>"></li>
        <?php } ?>
        <?php } ?>
          </ol>
          <div class="carousel-inner">
          <?php $i=0;
        foreach ($slides as $slide) {
          if ($i == 0) {
            $i++;
        ?>
        <div class="carousel-item active">
          <?php } else { ?>
            <div class="carousel-item">
          <?php } ?>
          <?php getpicture(Yii::app()->request->baseUrl.'/images/slideshow/'.$slide['slidepic'],$slide['slidetitle'],1080,270,'d-block w-100') ?>
          </div>
          <?php } ?>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end hero image -->

<!-- category -->
<section class="category">
  <div class="container">
    <h4>Kategori</h4>
    <div class="row">
      <div class="owl-carousel owl-theme">
      <?php $matgroups = getmaterialgroup('BJ',0,0);
        foreach ($matgroups as $matgroup) {?>
        <div class="item">
          <a href="<?php echo Yii::app()->createUrl('common/supplier/category/'.$matgroup['slug'])?>">
          <?php getpicture(Yii::app()->request->baseUrl.'/images/materialgroup/'.$matgroup['materialgrouppic'],$matgroup['description'],96,70,'img-fluid') ?>
          </a>
          <p class="text-center"><?php echo $matgroup['description']?></p>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
</section>
<!-- end category -->

<!-- donatae and top up -->
<section class="donate">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="d-flex justify-content-between">
          <div>
            <h5 class="heading1">Donasi</h5>
          </div>
          <div>
            <h5 class="heading2">Lihat Semua</h5>
          </div>
        </div>
        <div id="DonasiBanner" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
          <?php $i=0; $slides = getslideshow('Donasi Banner');
          foreach ($slides as $slide) {
            if ($i == 0) {?>
            <li data-target="#DonasiBanner" data-slide-to="<?php echo $i?>" class="active"></li>
            <?php } else {?>
              <li data-target="#DonasiBanner" data-slide-to="<?php echo $i?>" class=""></li>
        <?php } $i++;?>
        <?php } ?>
          </ol>
          <div class="carousel-inner">
          <?php $i=0;foreach ($slides as $slide) {
             if ($i == 0) {?>
            <div class="carousel-item active">
                <?php } else {?>
                  <div class="carousel-item">
                <?php } $i++; ?>
              <?php getpicture(Yii::app()->request->baseUrl.'/images/slideshow/'.$slide['slidepic'],'Donasi',540,184,'d-block w-100') ?>
            </div>
            <?php }?>
          </div>
          <a class="carousel-control-prev" href="#DonasiBanner" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#DonasiBanner" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <div class="col-12 col-md-6 my-4 my-md-0">
        <div class="d-flex justify-content-between">
          <div>
            <h5 class="heading1">Isi Ulang & Tagihan</h5>
          </div>
          <div>
            <h5 class="heading2">Lihat Semua</h5>
          </div>
        </div>
        <div class="card card-tab">
          <div class="card-header">
            <ul class="nav justify-content-between" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pulsa-tab" data-toggle="tab" href="#pulsa" role="tab"
                  aria-controls="pulsa" aria-selected="true">Pulsa</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="paket-data-tab" data-toggle="tab" href="#paket-data" role="tab"
                  aria-controls="paket-data" aria-selected="true">Paket Data</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="listrik-pln-tab" data-toggle="tab" href="#listrik-pln" role="tab"
                  aria-controls="listrik-pln" aria-selected="true">Listrik PLN</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="air-pdam-tab" data-toggle="tab" href="#air-pdam" role="tab"
                  aria-controls="air-pdam" aria-selected="true">Air PDAM</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="telkom-tab" data-toggle="tab" href="#telkom" role="tab" aria-controls="telkom"
                  aria-selected="true">Telkom</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link" data-toggle="tab" href="#telkom" role="tab" aria-controls="telkom"
                  aria-selected="true"><i class="fa fa-list"></i></a></span>
              </li>
            </ul>
          </div>
          <div class="card-body tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pulsa" role="tabpanel" aria-labelledby="pulsa-tab">
              <form action="#">
                <div class="form-row align-items-center">
                  <div class="form-group col-12 col-md-4">
                    <label for="no-hp">Nomor Telepon</label>
                    <input type="text" class="form-control" id="no-hp">
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="nominal">Nominal</label>
                    <select id="nominal" class="form-control nominal">
                      <option>select</option>
                      <option>1000</option>
                      <option>2000</option>
                    </select>
                  </div>
                  <div class="col col6-6 col-md-4 align-self-center">
                    <button class="btn btn-primary mt-md-3">Beli</button>
                  </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="paket-data" role="tabpanel" aria-labelledby="paket-data-tab">
              <form action="#">
                <div class="form-row align-items-center">
                  <div class="form-group col-12 col-md-4">
                    <label for="no-hp">Nomor Telepon</label>
                    <input type="text" class="form-control" id="no-hp">
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="nominal">Nominal</label>
                    <select id="nominal" class="form-control nominal">
                      <option>select</option>
                      <option>1000</option>
                      <option>2000</option>
                    </select>
                  </div>
                  <div class="col col-6 col-md-4 align-self-center">
                    <button class="btn btn-primary mt-md-3">Beli</button>
                  </div>
                </div>
              </form>
            </div>


            <div class="tab-pane fade" id="listrik-pln" role="tabpanel" aria-labelledby="listrik-pln-tab">
              <form action="#">
                <div class="form-row align-items-center">
                  <div class="form-group col-12 col-md-4">
                    <label for="jenis_produk_listrik">Jenis Produk Listrik</label>
                    <select id="jenis_produk_listrik" class="form-control">
                      <option>select</option>
                      <option>Token Listrik</option>
                      <option>Tagihan Listrik</option>
                      <option>PLN Non-Taglis</option>
                    </select>
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="id_pel">No.Meter/ID Pel</label>
                    <input type="text" class="form-control" id="id_pel">
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="nominal">Nominal</label>
                    <select id="nominal" class="form-control nominal">
                      <option>select</option>
                      <option>1000</option>
                      <option>2000</option>
                    </select>
                  </div>
                  <div class="col col-6 col-md-4 align-self-center">
                    <button class="btn btn-primary mt-md-3">Beli</button>
                  </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="air-pdam" role="tabpanel" aria-labelledby="air-pdam-tab">
              <form action="#">
                <div class="form-row align-items-center">
                  <div class="form-group col-12 col-md-4">
                    <label for="wilayah">Wilayah</label>
                    <select id="wilayah" class="form-control">
                      <option>select</option>
                      <option>Jakarta</option>
                      <option>Bandung</option>
                      <option>Medan</option>
                    </select>
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="id_pel">Nomor Pelanggan</label>
                    <input type="text" class="form-control" id="id_pel">
                  </div>
                  <div class="col col-6 col-md-4 align-self-center">
                    <button class="btn btn-primary mt-md-3 ">Beli</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="telkom" role="tabpanel" aria-labelledby="telkom-tab">
              <form action="#">
                <div class="form-row align-items-stretch">
                  <div class="form-group col-12 col-md-4">
                    <label for="no-hp">Nomor Telepon</label>
                    <input type="text" class="form-control" id="no-hp">
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <div class="container">
                      <label class="d-block" for="defaultCheck1">
                        Bayar Instan
                      </label>
                      <input class="d-block" type="checkbox" value="" id="defaultCheck1">
                    </div>
                  </div>
                  <div class="col col-6 col-md-4 align-self-center">
                    <button class="btn btn-primary mt-md-3">Beli</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- end donate and topup -->

<!-- flash sale -->
<section class="flash-sale">
  <div class="container">
    <div class="d-flex justify-content-between">
      <div>
        <h5 class="heading1">
          Belanja Cepat
          <span class="small-text end">berakhir dalam</span>
          <div>
            <span class="small-text">jam</span>
            <span class="count">24</span>
          </div>
          <span class="dot"> : </span>
          <div>
            <span class="small-text">menit</span>
            <span class="count">24</span>
          </div>
          <span class="dot"> : </span>
          <div>
            <span class="small-text">detik</span>
            <span class="count">24</span>
          </div>
        </h5>
      </div>
      <div>
        <h5 class="heading2"><a href=""> Lihat Semua</a></h5>
      </div>
    </div>
    <div class="row">
      <div class="p-0 col-6 col-md-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <span class="percent"> 35% </span>
            <span class="count-slash"><del>Rp.25.000</del> </span>
            <span class="price d-block">Rp.19.000</span>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">Habis Terjual</span>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <span class="percent"> 35% </span>
            <span class="count-slash"><del>Rp.25.000</del> </span>
            <span class="price d-block">Rp.19.000</span>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">Terjual Sebagian</span>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <span class="percent"> 35% </span>
            <span class="count-slash"><del>Rp.25.000</del> </span>
            <span class="price d-block">Rp.19.000</span>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">Terjual banyak</span>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <span class="percent"> 35% </span>
            <span class="count-slash"><del>Rp.25.000</del> </span>
            <span class="price d-block">Rp.19.000</span>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">Habis Terjual</span>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div id="BelanjaCepatBanner" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
          <?php $i=0; $slides = getslideshow('Belanja Cepat Banner');
          foreach ($slides as $slide) {
            if ($i == 0) {?>
            <li data-target="#BelanjaCepatBanner" data-slide-to="<?php echo $i?>" class="active"></li>
            <?php } else {?>
              <li data-target="#BelanjaCepatBanner" data-slide-to="<?php echo $i?>" class=""></li>
        <?php } $i++;?>
        <?php } ?>
          </ol>
          <div class="carousel-inner">
          <?php $i=0;foreach ($slides as $slide) {
             if ($i == 0) {?>
            <div class="carousel-item active">
                <?php } else {?>
                  <div class="carousel-item">
                <?php } $i++; ?>
              <?php getpicture(Yii::app()->request->baseUrl.'/images/slideshow/'.$slide['slidepic'],'Donasi',540,330,'d-block w-100') ?>
            </div>
            <?php }?>
          </div>
          <a class="carousel-control-prev" href="#carouselIndicators3" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselIndicators3" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end flase sale -->

<!-- flash sale -->
<section class="flash-sale">
  <div class="container">
    <div class="d-flex justify-content-between">
      <div>
        <h5 class="heading1">
          Patungan Belanja
          <span class="small-text end">berakhir dalam</span>
          <div>
            <span class="small-text">jam</span>
            <span class="count">24</span>
          </div>
          <span class="dot"> : </span>
          <div>
            <span class="small-text">menit</span>
            <span class="count">24</span>
          </div>
          <span class="dot"> : </span>
          <div>
            <span class="small-text">detik</span>
            <span class="count">24</span>
          </div>
        </h5>
      </div>
      <div>
        <h5 class="heading2">Lihat Semua</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-4">
        <div id="PatunganBanner" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
          <?php $i=0; $slides = getslideshow('Patungan Banner');
          foreach ($slides as $slide) {
            if ($i == 0) {?>
            <li data-target="#PatunganBanner" data-slide-to="<?php echo $i?>" class="active"></li>
            <?php } else {?>
              <li data-target="#PatunganBanner" data-slide-to="<?php echo $i?>" class=""></li>
        <?php } $i++;?>
        <?php } ?>
          </ol>
          <div class="carousel-inner">
          <?php $i=0;foreach ($slides as $slide) {
             if ($i == 0) {?>
            <div class="carousel-item active">
                <?php } else {?>
                  <div class="carousel-item">
                <?php } $i++; ?>
              <?php getpicture(Yii::app()->request->baseUrl.'/images/slideshow/'.$slide['slidepic'],'Donasi',540,320,'d-block w-100') ?>
            </div>
            <?php }?>
          </div>
          <a class="carousel-control-prev" href="#carouselIndicators4" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselIndicators4" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <div class="d-flex justify-content-between">
              <div>
                <span class="percent"> 35% </span>
                <span class="count-slash"><del>Rp.25.000</del> </span>
              </div>
              <div>
                <span class="maks-p">Min.Qty</span>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <span class="price">Rp.450.000.000</span>
              </div>
              <div>
                <span class="total">54</span>
              </div>
            </div>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">Minimum Kuantitas Terpenuhi</span>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <div class="d-flex justify-content-between">
              <div>
                <span class="percent"> 35% </span>
                <span class="count-slash"><del>Rp.25.000</del> </span>
              </div>
              <div>
                <span class="maks-p">Min.Qty</span>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <span class="price">Rp.450.000.000</span>
              </div>
              <div>
                <span class="total">54</span>
              </div>
            </div>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">Terpesan 135 dari 460</span>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <div class="d-flex justify-content-between">
              <div>
                <span class="percent"> 35% </span>
                <span class="count-slash"><del>Rp.25.000</del> </span>
              </div>
              <div>
                <span class="maks-p">Min.Qty</span>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <span class="price">Rp.450.000.000</span>
              </div>
              <div>
                <span class="total">54</span>
              </div>
            </div>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">Terpesan 72 dari 110</span>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <div class="d-flex justify-content-between">
              <div>
                <span class="percent"> 35% </span>
                <span class="count-slash"><del>Rp.25.000</del> </span>
              </div>
              <div>
                <span class="maks-p">Min.Qty</span>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <span class="price">Rp.450.000.000</span>
              </div>
              <div>
                <span class="total">54</span>
              </div>
            </div>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">Minimum Kuantitas Terpenuhi</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end flase sale -->

<!-- flash sale -->
<section class="flash-sale">
  <div class="container">
    <div class="d-flex justify-content-between">
      <div>
        <h5 class="heading1">
          Lelang
          <span class="small-text end">berakhir dalam</span>
          <div>
            <span class="small-text">jam</span>
            <span class="count">24</span>
          </div>
          <span class="dot"> : </span>
          <div>
            <span class="small-text">menit</span>
            <span class="count">24</span>
          </div>
          <span class="dot"> : </span>
          <div>
            <span class="small-text">detik</span>
            <span class="count">24</span>
          </div>
        </h5>
      </div>
      <div>
        <h5 class="heading2">Lihat Semua</h5>
      </div>
    </div>
    <div class="row">
      <div class="p-0 col-6 col-md-2 col-lg-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <div class="d-flex justify-content-between">
              <div>
                <span class="open-bid">buka harga</span>
              </div>
              <div>
                <span class="maks-p">maks.pesserta</span>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <span class="price">Rp.450.000.000</span>
              </div>
              <div>
                <span class="total">54</span>
              </div>
            </div>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">harga bid tertinggi Rp 2.100.000</span>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 col-lg-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <div class="d-flex justify-content-between">
              <div>
                <span class="open-bid">buka harga</span>
              </div>
              <div>
                <span class="maks-p">maks.pesserta</span>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <span class="price">Rp.450.000.000</span>
              </div>
              <div>
                <span class="total">54</span>
              </div>
            </div>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">harga bid tertinggi Rp 2.100.000</span>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 col-lg-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <div class="d-flex justify-content-between">
              <div>
                <span class="open-bid">buka harga</span>
              </div>
              <div>
                <span class="maks-p">maks.pesserta</span>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <span class="price">Rp.450.000.000</span>
              </div>
              <div>
                <span class="total">54</span>
              </div>
            </div>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">harga bid tertinggi Rp 2.100.000</span>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-2 col-lg-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              Mini Cooper Morris Tahun 1994 Mesin Bertenaga
            </p>
            <div class="d-flex justify-content-between">
              <div>
                <span class="open-bid">buka harga</span>
              </div>
              <div>
                <span class="maks-p">maks.pesserta</span>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <span class="price">Rp.450.000.000</span>
              </div>
              <div>
                <span class="total">54</span>
              </div>
            </div>
            <div class="progress" style="height: 2px">
              <div class="progress-bar" role="progressbar" style="width: 76%" aria-valuenow="76" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
            <span class="bid-count">harga bid tertinggi Rp 2.100.000</span>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div id="LelangBanner" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
          <?php $i=0; $slides = getslideshow('Lelang Banner');
          foreach ($slides as $slide) {
            if ($i == 0) {?>
            <li data-target="#LelangBanner" data-slide-to="<?php echo $i?>" class="active"></li>
            <?php } else {?>
              <li data-target="#LelangBanner" data-slide-to="<?php echo $i?>" class=""></li>
        <?php } $i++;?>
        <?php } ?>
          </ol>
          <div class="carousel-inner">
          <?php $i=0;foreach ($slides as $slide) {
             if ($i == 0) {?>
            <div class="carousel-item active">
                <?php } else {?>
                  <div class="carousel-item">
                <?php } $i++; ?>
              <?php getpicture(Yii::app()->request->baseUrl.'/images/slideshow/'.$slide['slidepic'],'Donasi',540,330,'d-block w-100') ?>
            </div>
            <?php }?>
          </div>
          <a class="carousel-control-prev" href="#LelangBanner" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#LelangBanner" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end flase sale -->

<!-- trusted shop -->
<section class="trusted">
  <div class="container">
    <h5>Toko Terpercaya</h5>
    <div class="row justify-content">
      <?php $tokos = gettokotrust(6);
      foreach ($tokos as $toko) {?>
      <div class="col-12 col-md-4">
        <img src="<?php echo Yii::app()->request->baseUrl.'/images/supplier/'.$toko['logo']?>" class="img-fluid" alt="<?php echo $toko['fullname']?>" />
      </div>
      <?php }?>
      <div class="col-6 col-md-2 align-self-center">
        <button class="btn">Lihat Semua</button>
      </div>
    </div>
  </div>
</section>
<!-- end trusted shop -->

<!-- all product -->
<section class="all-product">
  <div class="container">
    <div class="d-flex justify-content-between">
      <div>
        <h5 class="heading1">Semua Produk</h5>
      </div>
      <div>
        <h5 class="heading2"><a href=""> Lihat Semua</a></h5>
      </div>
    </div>
    <div class="row">
      <?php $products = getproduct(30,1,
        [
          [
            'filter'=>'materialgroup',
            'type'=>'not in',
            'value'=>"('DONASI','DIGITAL')"
          ]
        ]);
        foreach ($products as $product) { ?>
      <div class="p-0 col-6 col-md-2 my-2 my-md-0">
        <div class="card">
          <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/monil.png" class="card-img-top" alt="..." />
          <div class="card-body">
            <p class="card-text">
              <?php echo $product['productname']?>
            </p>
            <span class="price price-all d-block">Rp27.000</span>
            <span class="open-bid place">
              <i class="fas fa-map-marker-alt"></i> Jakarta Barat</span>
            <div class="stars">
              <span class="active"><i class="fas fa-star"></i></span>
              <span class="active"><i class="fas fa-star"></i></span>
              <span class="active"><i class="fas fa-star"></i></span>
              <span class="active"><i class="fas fa-star"></i></span>
              <span class="active"><i class="fas fa-star"></i></span>
              <span class="open-bid">(283)</span>
            </div>
            <span class="mumtaz">Mumtaz</span>
          </div>
        </div>
      </div>
      <?php }?>
      <div class="container">
        <div class="col-12 text-center">
          <button type="button" class="btn more">Muat Lebih Banyak</button>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end all product -->

<!-- tag -->
<section class="tag">
  <div class="container">
    <div class="row">
      <div class="list-body">
      <?php 
        $i = 0;
        $products = getproduct(30,1,
        [
          [
            'filter'=>'materialgroup',
            'type'=>'in',
            'value'=>"('DIGITAL')"
          ]
        ]);
        foreach ($products as $product) { 
        if ($i == 0) { ?>
        <ul class="list-group list-group-horizontal-md">
          <?php }?>          
          <li class="list-group-item">
            <a href="<?php echo Yii::app()->createUrl('common/product/digital/'.$product['slug'])?>"><img src="<?php echo Yii::app()->request->baseUrl.'/images/product/'.$product['productpic']?>" alt="<?php echo $product['productname']?>"
                class="icon icon-emas"><?php echo $product['productname']?></a>
          </li>
       <?php if ($i < 5) { $i++; } else {
         $i = 0; ?>
          </ul>
         <?php } ?>
       <?php } ?>
      </div>
    </div>
  </div>
</section>
<!-- end tag -->

<!-- puldapi section -->
<section class="puldapii-section">
  <div class="container">
    <div class="row">
      <div class="p-0 col-6 col-md-4">
        <div class="card" style="max-width: 540px">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/SEOcontent2.png" class="img-fluid" class="card-img" alt="..." />
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Transparant</h5>
                <p class="card-text">
                  Pembayaran baru diteruskan ke penjual setelah barang anda terima
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-4">
        <div class="card" style="max-width: 540px">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/SEOcontent3.png" class="img-fluid" class="card-img" alt="..." />
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Aman</h5>
                <p class="card-text">
                  Bandingkan review untuk berbagai online shop terpercaya se-Indonesia
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="p-0 col-6 col-md-4">
        <div class="card" style="max-width: 540px">
          <div class="row no-gutters">
            <div class="col-md-4">
              <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/SEOcontent4.png" class="img-fluid" class="card-img" alt="..." />
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Fasilitas Escrow Gratis</h5>
                <p class="card-text">
                  Fasilitas Escrow (Rekening Bersama) Tokopedia tidak dikenakan biaya tambahan
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr />
</section>
<!-- end puldapi section -->

<!-- footer -->
<section class="footer">
  <div class="container">
    <div class="row">
      <div class="col-8 col-md-2">
        <ul class="list-group list-group-flush">
          <li class="list-group-item title">Prisma Mart</li>
          <li class="list-group-item">
            <a href="#">Tentang Prisma Mart</a>
          </li>
          <li class="list-group-item"><a href="<?php echo Yii::app()->createUrl('blog/post/read/info-karir')?>">Karir</a></li>
          <li class="list-group-item"><a href="<?php echo Yii::app()->createUrl('blog/')?>">Blog</a></li>
          <li class="list-group-item"><a href="<?php echo Yii::app()->createUrl('blog/post/read/info-official-store')?>">Official Store</a></li>
        </ul>
      </div>
      <div class="col-8 col-md-2">
        <ul class="list-group list-group-flush">
          <li class="list-group-item title">Jual</li>
          <li class="list-group-item">
            <a href="<?php echo Yii::app()->createUrl('blog/post/read/info-pusat-jual')?>">Pusat Informasi Penjual</a>
          </li>
          <li class="list-group-item">
            <a href="<?php echo Yii::app()->createUrl('blog/post/read/daftar-official-store')?>">Daftar Official Store</a>
          </li>
        </ul>
      </div>
      <div class="col-8 col-md-2">
        <ul class="list-group list-group-flush">
          <li class="list-group-item title">Bantuan</li>
          <li class="list-group-item"><a href="<?php echo Yii::app()->createUrl('blog/post/read/info-prisma-care')?>">Prisma Care</a></li>
          <li class="list-group-item"><a href="<?php echo Yii::app()->createUrl('blog/post/read/info-syarat-ketentuan')?>">Syarat & Ketentuan</a></li>
          <li class="list-group-item"><a href="<?php echo Yii::app()->createUrl('blog/post/read/kebijakan-privasi')?>">Kebijakan privasi</a></li>
        </ul>
      </div>
      <div class="col-7 col-md-2">
        <ul class="list-group list-group-flush">
          <li class="list-group-item title">Ikuti kami</li>
          <li class="list-group-item">
            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/youtube1.png" alt="Prisma Youtube" /></a>
            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/facebook.png" alt="Prisma Facebook" /></a>
            <a href="#"><img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/instagram.png" alt="Prisma Instagram" /></a>
          </li>
        </ul>
      </div>
      <div class="col-4 text-center">
        <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/Rectangle72.png" class="img-fluid" alt="Prisma" />
        <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/gogl.png" class="img-fluid" alt="Prisma Google" />
        <img src="<?php echo Yii::app()->request->baseUrl?>/images/mp1/img/aapl.png" class="img-fluid" alt="Prisma Apple" />
      </div>
    </div>
    <div class="copyright text-center">
      <p>&copy; 2020, PT.Prisma Mart</p>
    </div>
  </div>
</section>
  <!-- end footer -->