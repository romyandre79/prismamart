<div class="row">
    <div class="col">
        <div class="card card-tab">
            <div class="card-header">
                <nav class="nav">
                    <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/myaccount')?>">Biodata Diri</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myaddress')?>">Daftar Alamat</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mypayment')?>">Pembayaran</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myrekening')?>">Rekening Bank</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mynotification')?>">Notifikasi</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mysecurity')?>">Keamanan</a>
                </nav>
            </div>
            <div class="card-body">
                <div class="row setting-profil-section">
                    <div class="card-change-profil order-last order-lg-first mt-4 mt-lg-0">
                        <div class="card card-body rounded-0">
                            <!-- Gambar Profil menggunakan background supaya bentuk masih relative -->
                            <div class="image-wrap"
                                style="<?php echo getpicture(Yii::app()->request->baseUrl.'/images/useraccess/'.Yii::app()->user->picture,Yii::app()->user->realname,80,100,'',1)?>">
                            </div>
                            <!-- ./end gambar profil -->

                            <div class="form-group">
                                <input type="file" id="settingProfilUpload" class="d-none">
                                <a href="#"
                                    class="btn btn-white btn-open-upload btn-block shadow-none"
                                    id="btnOpenUpload">Pilih
                                    Foto</a>
                            </div>

                            <div class="info">
                                <p>Besar file: maksimum 10.000.000 bytes (10 Megabytes)</p>
                                <p>Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG</p>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <a href="#" class="btn btn-white btn-block shadow-none">
                                    <i class="fas fa-key"></i> Ubah Kata Sandi
                                </a>
                                <a href="#" class="btn btn-primary btn-pin btn-block shadow-none">
                                    <img src="<?php echo Yii::app()->request->baseUrl.'/images/icons/pin-lock-icon.svg'?>"
                                        class="img-fluid" width="10" alt="icon">
                                    <span> PIN Prisma Store</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="biodata-profil-section order-first order-lg-last">
                        <div class="row">
                            <div class="col">
                                <h6 class="title">Ubah Biodata Diri</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item pl-0 field">Nama</li>
                                    <li class="list-group-item value">
                                        <span><?php echo Yii::app()->user->realname?></span>
                                        <a href="#" class="ml-5">Ubah</a>
                                    </li>
                                </ul>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item pl-0 field">Tanggal Lahir</li>
                                    <li class="list-group-item value"><?php echo Yii::app()->user->birthdate?></li>
                                </ul>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item pl-0 field">Jenis Kelamin</li>
                                    <li class="list-group-item value"><?php echo Yii::app()->user->sexname?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <h6 class="title">Ubah Kontak</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item pl-0 field">Email</li>
                                    <li class="list-group-item value">
                                        <span><?php echo Yii::app()->user->email?></span>
                                        <a href="#" class="ml-4">Ubah</a>
                                    </li>
                                </ul>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item pl-0 field">Nomor HP</li>
                                    <li class="list-group-item value">
                                        <span><?php echo Yii::app()->user->phoneno?></span>
                                        <a href="#" class="ml-4">Ubah</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="title">Safe Mode</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="subtitle">Fitur ini akan otomatis menyaring hasil
                                    pencarian sesuai
                                    kebijakan dan batasan usia pengguna</p>
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item pl-0 field">Aktifkan</li>
                                    <li class="list-group-item value">
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>