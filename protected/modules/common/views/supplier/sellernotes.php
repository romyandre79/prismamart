<div class="row">
  <div class="col">
    <div class="card card-tab">
      <div class="card-header">
        <nav class="nav">
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerinfo')?>">Informasi</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/selleretalase')?>">Etalase</a>
          <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/sellernotes')?>">Catatan</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerlocation')?>">Lokasi</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerdelivery')?>">Pengiriman</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerproduct')?>">Produk Unggulan</a>
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
                        <div class="col-12 col-md-4 col-lg-3 mb-2 mb-lg-0">
                          <h6 class="title mb-0">Catatan Toko</h6>
                          <p class="subtitle mb-0">
                            Lihat Catatan Toko di
                            <a href="#" class="text-decoration-none">Halaman Toko</a>
                          </p>
                        </div>
                        <div class="col-12 col-md-8 col-lg-9 text-lg-right">
                          <a href="#" class="btn btn-white mb-2 mb-lg-0">Preview</a>
                          <a href="#" class="btn btn-primary mb-2 mb-lg-0">Tambah Catatan</a>
                          <a href="#" class="btn btn-primary mb-2 mb-lg-0">Tambah Kebijakan Toko</a>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="highlight-section mt-3 text-center">
                            <h6 class="text-secondary mt-4">
                              Tidak ada catatan toko
                            </h6>
                            <p class="text-secondary font-medium">
                              Tambah kebijakan atau syarat & ketentuan toko.
                              Informasi tersebut akan muncul di halaman tokomu
                            </p>
                            <a href="#" class="btn btn-primary font-medium font-weight-bold py-2 px-4 mb-2">Tambah
                              Catatan</a>
                          </div>
                        </div>
                      </div>
                    </div>
    </div>
  </div>
</div>