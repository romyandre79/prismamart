<div class="row">
    <div class="col">
        <div class="card card-tab">
            <div class="card-header">
                <nav class="nav">
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myaccount')?>">Biodata Diri</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myaddress')?>">Daftar Alamat</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mypayment')?>">Pembayaran</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myrekening')?>">Rekening Bank</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mynotification')?>">Notifikasi</a>
                    <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/mysecurity')?>">Keamanan</a>
                </nav>
            </div>
            <div class="card-body">
              <div class="row keamanan-aktifitas-section">
                <div class="keamanan-menus pr-lg-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link clearfix border-bottom">
                                <span class="float-left">Aktivitas Login</span>
                                <i class="fas fa-chevron-right text-secondary float-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="keamanan-content">
                    <h6 class="title text-center mt-4">Aktivitas Login</h6>
                    <div class="info d-flex align-items-center mx-auto mt-3">
                        <img src="../../images/icons/info-alert-pass-icon.svg"
                            class="img-fluid mr-2" alt="icon">
                        <p class="d-inline-block">Bila terdapat aktivitas tidak dikenal, segera
                            klik "Keluar" dan ubah <a href="#">kata sandi.</a></p>
                    </div>

                    <p class="secure-title mt-5">Aktivitas login saat ini</p>
                    <div class="box-secure d-flex align-items-start">
                        <img src="../../images/icons/keamanan-desktop-active-icon.svg"
                            class="img-fluid mt-2 mr-3" alt="icon">
                        <div class="box-content d-inline-block">
                            <h3 class="box-title">Chrome di Windows 10</h3>
                            <p>36.77.159.95</p>
                            <span class="verif rounded-pill">Sedang Aktif</span>
                        </div>
                    </div>
                    <div class="box-secure d-flex align-items-start">
                        <img src="../../images/icons/keamanan-desktop-active-icon.svg"
                            class="img-fluid mt-2 mr-3" alt="icon">
                        <div class="box-content d-inline-block">
                            <h3 class="box-title">Android</h3>
                            <p>36.81.222.175</p>
                            <span class="history">Aktif 7 Sep 2020, 09.07</span>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <a href="#" class="secure-link text-decoration-none">Keluar dari
                            semua perangkat</a>
                    </div>

                    <p class="secure-title mt-3">Riwayat dalam 30 hari terakhir</p>
                    <div class="box-secure d-flex align-items-start">
                        <img src="../../images/icons/keamanan-desktop-nonactive-icon.svg"
                            class="img-fluid mt-2 mr-3" alt="icon">
                        <div class="box-content nonactive d-inline-block">
                            <h3 class="box-title">Chrome di Windows 10</h3>
                            <p>36.77.159.95</p>
                            <span class="history">Aktif 27 Agu 2020, 14.17</span>
                            <span class="info-right">Telah Keluar</span>
                        </div>
                    </div>
                </div>
            </div>      
            </div>
        </div>
    </div>
</div>