<div class="row">
    <div class="col">
        <div class="card card-tab">
            <div class="card-header">
                <nav class="nav">
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myaccount')?>">Biodata Diri</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myaddress')?>">Daftar Alamat</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mypayment')?>">Pembayaran</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myrekening')?>">Rekening Bank</a>
                    <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/mynotification')?>">Notifikasi</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mysecurity')?>">Keamanan</a>
                </nav>
            </div>
            <div class="card-body">
              <div class="row mt-3 information-section">
              <div class="alert alert-light-primary alert-dismissible fade show alert-my-info"
                                        role="alert">
                                        <img src="../../images/icons/info-alert-sms-icon.svg" class="img-fluid"
                                            alt="icon">
                                        Notifikasi SMS sifatnya penting karena memberimu kabar soal keamanan akun dan
                                        status transaksi. Hati-hati saat terima SMS spam yang mengatasnamakan Tokopedia,
                                        ya. Jika kamu menerima SMS tersebut, <a href="#">pelajari selengkapnya
                                            disini.</a>

                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="row notifikasi-section">
                                        <div class="col-12 mt-3">
                                            <h5 class="title">Notifikasi</h5>
                                            <p class="subtitle">Atur notifikasi yang ingin kamu terima disini</p>
                                        </div>
                                        <div class="col-12">
                                            <div class="master-title mt-3 clearfix">
                                                <h6 class="float-left">Transaksi</h6>
                                                <span class="float-right">E-mail</span>
                                            </div>

                                            <div class="row check-list-section mt-4">
                                                <div class="col-12">
                                                    <div class="title-check mb-3">
                                                        <i class="fas fa-shopping-cart text-secondary mr-1"></i>
                                                        <span>Transaksi Pembelian</span>
                                                    </div>

                                                    <ul class="list-group list-group-check">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span>Menunggu Konfirmasi</span>
                                                                </div>
                                                                <div class="col text-right">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="mengunggkuKonfirmasiCheck"
                                                                            name="mengunggkuKonfirmasiCheck" checked>
                                                                        <label class="custom-control-label"
                                                                            for="mengunggkuKonfirmasiCheck"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span>Pesanan Diproses</span>
                                                                </div>
                                                                <div class="col text-right">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="pesananDiprosesCheck"
                                                                            name="pesananDiprosesCheck" checked>
                                                                        <label class="custom-control-label"
                                                                            for="pesananDiprosesCheck"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span>Pesanan Dikirim</span>
                                                                </div>
                                                                <div class="col text-right">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="pesananDikirimCheck"
                                                                            name="pesananDikirimCheck" checked>
                                                                        <label class="custom-control-label"
                                                                            for="pesananDikirimCheck"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span>Pesanan Tiba</span>
                                                                </div>
                                                                <div class="col text-right">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="pesananTibaCheck"
                                                                            name="pesananTibaCheck" checked>
                                                                        <label class="custom-control-label"
                                                                            for="pesananTibaCheck"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span>Pengingat</span>
                                                                </div>
                                                                <div class="col text-right">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="pengingatCheck" name="pengingatCheck"
                                                                            checked>
                                                                        <label class="custom-control-label"
                                                                            for="pengingatCheck"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                    <div class="title-check my-3">
                                                        <img src="../../images/icons/notif-transaksi-penjualan-icon.svg"
                                                            class="img-fluid mr-1" alt="icon">
                                                        <span>Transaksi Penjualan</span>
                                                    </div>
                                                    <ul class="list-group list-group-check">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span>Pesanan Baru</span>
                                                                </div>
                                                                <div class="col text-right">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="pesananBaruCheck"
                                                                            name="pesananBaruCheck" checked>
                                                                        <label class="custom-control-label"
                                                                            for="pesananBaruCheck"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span>Pesanan Sudah Tiba</span>
                                                                </div>
                                                                <div class="col text-right">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="pesananSudahTibaCheck"
                                                                            name="pesananSudahTibaCheck" checked>
                                                                        <label class="custom-control-label"
                                                                            for="pesananSudahTibaCheck"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item border-bottom-0">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <span>Transaksi Selesai</span>
                                                                </div>
                                                                <div class="col text-right">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="transaksiSelesaiCheck"
                                                                            name="transaksiSelesaiCheck" checked>
                                                                        <label class="custom-control-label"
                                                                            for="transaksiSelesaiCheck"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
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
</div>