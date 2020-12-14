<div class="row">
  <div class="col">
    <div class="card card-tab">
      <div class="card-header">
        <nav class="nav">
          <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/sellerinfo')?>">Informasi</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/selleretalase')?>">Etalase</a>
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
        <div class="row justify-content-between py-4 px-3">
          <div class="my-etalase">
            <span>Status Keanggotaan</span>
            <h5 class="pesanan">Regular Merchant (Aktif)</h5>
          </div>
          <div class="seller-flex align-self-center">
            <p class="text-right w-50 my-0 mr-3">
              Power Merchant sekarang bebas biaya bulanan!
            </p>
            <button class="status preview btn ml-2 open-o">
              Upgrade jadi Power Merchant
            </button>
          </div>
        </div>
        <hr class="m-3" />
        <h6>Informasi Toko</h6>
        <div class="form-row">
          <div class="col-6">
            <label for="exampleInputEmail2">Nama Toko</label>
            <input id="exampleInputEmail2" disabled value="Firmansyah" type="text" class="form-control" />
          </div>
          <div class="col-6">
            <label for="exampleInputEmail3">Slogan</label>
            <input id="exampleInputEmail3" type="text" class="form-control" />
            <small id="exampleInputEmail3" class="form-text text-muted">Maksimum <span>48</span>
              karakter</small>
          </div>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Deskripsi</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" style="height: initial;"></textarea>
          <small id="exampleFormControlTextarea1" class="form-text text-muted">Maksimum
            <span>140</span> karakter</small>
        </div>
        <hr class="mx-3 my-5" />
        <div class="row mt-3">
          <h6 class="m-3 mr-5">Status</h6>
          <div class="align-self-center ml-5">
            <div class="form">
              <div class="onoffswitch">
                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch"
                  checked />
                <label class="onoffswitch-label" for="myonoffswitch">
                  <span class="onoffswitch-inner"></span>
                  <span class="onoffswitch-switch"></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <h6 class="m-3 status-toko">Status Toko</h6>
          <div class="align-self-center container">
            <span class="close-icon"><i class="fas fa-store-alt-slash"></i></span>
            <span class="ml-4 closed">Ditutup</span>
            <p class="until my-4">
              Tutup Sampai: Invalid Date Catatan:
            </p>
            <button class="status preview btn ml-2 open-operasional">
              Buka Oprasional Toko
            </button>
            <button class="status preview btn ml-2 open-o">
              Ubah Jadwal Tutup Toko
            </button>
          </div>
        </div>
        <hr class="m-3" />
        <h6 class="mx-3">Gambar Toko</h6>
        <div class="row">
          <img src="../../images/mp1/img/Rectangle273.png" class="img-fluid col-6 col-md-3" alt="" />
          <div class="align-self-center container col-12 col-md-7 mt-2">
            <p>
              Besar file: Maksimum 10.000.000 bytes (10 Megabytes)
              Ekstensi Ekstensi file yang diperbolehkan: JPG, JPEG, PNG
            </p>
            <div class="input-group mb-3">
              <div class="custom-file">
                <input type="file" class="custom-file-input d-none" id="inputGroupFile01"
                  aria-describedby="inputGroupFileAddon01" />
                <label class="custom-file-label file-profile text-center" for="inputGroupFile01">Pilih
                  Foto</label>
              </div>
            </div>
          </div>
        </div>
        <hr class="m-3" />
        <h6 class="mx-3">Informasi Toko</h6>
        <p class="mx-3">
          Jadikan halaman toko Anda lebih menarik dengan kreasi foto
          Anda sendiri. <a href=""> Ke Halaman Toko Saya</a>
        </p>
        <div class="sampul-toko mx-3 p-2">
          <div class="sampul-child mx-auto p-3">
            <span class="lock"><i class="fas fa-lock"></i></span>
            <p class="text-white">
              Sampul toko membuat toko Anda lebih menarik. Upgrade toko
              Anda menjadi <a href=""> Power Merchant</a> untuk
              mendapatkan akses sampul toko.
            </p>
            <button class="status preview btn ml-2">
              Upgrade ke Power Merchant
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>