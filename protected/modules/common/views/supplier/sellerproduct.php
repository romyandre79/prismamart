<div class="row">
  <div class="col">
    <div class="card card-tab">
      <div class="card-header">
        <nav class="nav">
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerinfo')?>">Informasi</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/selleretalase')?>">Etalase</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellernotes')?>">Catatan</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerlocation')?>">Lokasi</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerdelivery')?>">Pengiriman</a>
          <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/sellerproduct')?>">Produk Unggulan</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellertemplate')?>">Template Balasan</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerlayanan')?>">Layanan</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerpowermerchant')?>">
            Power Merchant
            <span class="badge badge-pink ml-2">NEW</span>
          </a>
        </nav>
      </div>

      <div class="card-body">
                        <div class="row aksi-section">
                          <div class="col-12 mb-2 mb-lg-0">
                            <h6 class="title mb-0">Produk Unggulan</h6>
                            <p class="subtitle mb-0">
                              Lihat Produk Unggulan yang telah ditampilkan di
                              <a href="#" class="text-decoration-none"
                                >Halaman Toko</a
                              >
                            </p>
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="col">
                            <div class="card pt-4 pb-3">
                              <div class="card-body text-center">
                                <img
                                  src="../../images/img-info.png"
                                  class="img-fluid img-support"
                                  width="180"
                                  alt="info"
                                />
                                <h6 class="text-dark font-weight-bold mt-4">
                                  Toko Anda belum memiliki Produk Unggulan
                                </h6>
                                <p class="text-dark font-medium w-desc mx-auto">
                                  Tampilkan 5 Produk Terbaik Anda sebagai Produk
                                  Unggulan pada Halaman Toko. Dapatkan akses
                                  Produk Unggulan dengan berlangganan
                                  <a href="#" class="text-decoration-none"
                                    >Power Merchant.</a
                                  >
                                </p>
                                <a
                                  href="#"
                                  class="btn btn-primary font-weight-bold"
                                  >Upgrade Ke Power Merchant</a
                                >
                              </div>
                            </div>
                          </div>
                        </div>
    </div>
  </div>
</div>