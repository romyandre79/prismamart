<div class="row">
  <div class="col">
    <div class="card card-tab">
      <div class="card-header">
        <nav class="nav">
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerinfo')?>">Informasi</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/selleretalase')?>">Etalase</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellernotes')?>">Catatan</a>
          <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/sellerlocation')?>">Lokasi</a>
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
                          <div class="col-12 col-md-6 mb-2 mb-lg-0">
                            <h6 class="title mb-0">Lokasi Toko</h6>
                            <p class="subtitle mb-0">
                              Kamu bisa masukkan lokasi dan informasi toko di
                              sini.
                            </p>
                          </div>
                          <div class="col-12 col-md-6 text-md-right">
                            <a href="#" class="btn btn-primary mb-2 mb-lg-0"
                              >Tambah Lokasi</a
                            >
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="highlight-section mt-3 text-center">
                              <h4 class="text-dark mt-4">Tidak Ada Lokasi</h4>
                            </div>
                          </div>
                        </div>
                      </div>
    </div>
  </div>
</div>