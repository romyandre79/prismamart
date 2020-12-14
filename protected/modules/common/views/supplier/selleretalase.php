<div class="row">
  <div class="col">
    <div class="card card-tab">
      <div class="card-header">
        <nav class="nav">
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerinfo')?>">Informasi</a>
          <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/selleretalase')?>">Etalase</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellernotes')?>">Catatan</a>
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
                      <div class="seller-flex justify-content-between py-4 px-3">
                        <div class="my-etalase">
                          <h5 class="pesanan">Daftar Etalase Saya</h5>
                          <p>Lihat Etalase di <a href=""> Halaman Toko</a></p>
                        </div>
                        <div class="seller-flex align-self-center">
                          <button class="status preview btn ml-2">Preview</button>
                          <button class="status preview btn ml-2">
                            <span><i class="fa fa-plus"></i></span> Tambah Etalase
                          </button>
                        </div>
                      </div>
                      <ul class="list-group m-3">
                        <li class="list-group-item active d-flex justify-content-between">
                          <div>
                            Jumlah etalase 0/10 <i class="fas fa-sync-alt"></i>
                          </div>
                          <div>
                            Lebih leluasa dengan 200 etalase khusus Power Merchant.
                            <a href=""> Selngkapnya.</a>
                          </div>
                        </li>
                        <li class="list-group-item">
                          Semua Produk
                          <p>Total Produk: 0</p>
                        </li>
                        <li class="list-group-item">
                          Produk Terjual
                          <p>Total Produk: 0</p>
                        </li>
                      </ul>
                    </div>
    </div>
  </div>
</div>