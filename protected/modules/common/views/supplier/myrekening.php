<div class="row">
    <div class="col">
        <div class="card card-tab">
            <div class="card-header">
                <nav class="nav">
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myaccount')?>">Biodata Diri</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myaddress')?>">Daftar Alamat</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mypayment')?>">Pembayaran</a>
                    <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/myrekening')?>">Rekening Bank</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mynotification')?>">Notifikasi</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mysecurity')?>">Keamanan</a>
                </nav>
            </div>
            <div class="card-body">
              <div class="row mt-3 information-section">
                  <div class="col text-center">
                      <img src="../../images/img-info.png" class="img-fluid img-support"
                          alt="info">
                      <h1 class="title">Belum ada rekening bank tersimpan</h1>
                      <p class="desc">Yuk, tambah rekening bank kamu biar lebih mudah saat tarik
                          Saldo Prisma Mart!</p>
                      <a href="#" class="btn btn-primary py-2 px-5">Tambah Rekening</a>
                  </div>
              </div>             
            </div>
        </div>
    </div>
</div>