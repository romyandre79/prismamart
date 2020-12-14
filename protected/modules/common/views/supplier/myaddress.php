<div class="row">
    <div class="col">
        <div class="card card-tab">
            <div class="card-header">
                <nav class="nav">
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myaccount')?>">Biodata Diri</a>
                    <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/myaddress')?>">Daftar Alamat</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mypayment')?>">Pembayaran</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/myrekening')?>">Rekening Bank</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mynotification')?>">Notifikasi</a>
                    <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/mysecurity')?>">Keamanan</a>
                </nav>
            </div>
            <div class="card-body">
                                    <div class="row setting-filter-section">
                                        <div class="col-12 col-md-12 col-lg-3 mb-3 mb-lg-0">
                                            <a href="#" class="btn btn-primary btn-add shadow-none">
                                                <i class="fas fa-plus"></i> Tambah Alamat Baru
                                            </a>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-9">
                                            <form class="form-inline d-flex justify-content-lg-end">
                                                <label for="urutkanSettingAlamatFilter" class="mr-4">Urutkan</label>
                                                <select class="form-control mr-sm-2 mb-2 mb-md-0"
                                                    id="urutkanSettingAlamatFilter">
                                                    <option disabled selected>Alamat Terbaru</option>
                                                    <option>sdad</option>
                                                </select>

                                                <label class="sr-only" for="cariAlamat">Cari Alamat</label>
                                                <div class="input-group">
                                                    <input type="text" id="cariAlamat" class="form-control"
                                                        placeholder="Cari alamat atau nama penerima"
                                                        aria-describedby="buttonSettingFilterAlamat">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-sfilter-alamat" type="button"
                                                            id="buttonSettingFilterAlamat">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="row setting-table-alamat-section mt-4">
                                        <div class="col">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="border-top-0" width="180">Penerima
                                                            </th>
                                                            <th scope="col" class="border-top-0" width="400">Alamat
                                                                Pengiriman</th>
                                                            <th scope="col" class="border-top-0" width="200">Daerah
                                                                Pengiriman</th>
                                                            <th scope="col" class="border-top-0">Pin Poin</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div
                                                                    class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" id="alamat1"
                                                                        name="alamatPenerimaanBelanja"
                                                                        class="custom-control-input" checked>
                                                                    <label class="custom-control-label pl-2"
                                                                        for="alamat1">
                                                                        <h6>Firmansyah</h6>
                                                                        <p>6281218868597</p>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h6>Rumah</h6>
                                                                <p>Jalan Sukabumi, Cibeureum, Tasikmalaya, Jawa Barat,
                                                                    46196
                                                                    [Tokopedia Note: Jl. Sukabumi Utama No 285 Blok 04
                                                                    RT 03
                                                                    RW 18 Perum Kotabaru]</p>
                                                            </td>
                                                            <td>
                                                                <p>Jawa Barat, Kota Tasikmalaya, Cibeureum 46196
                                                                    Indonesia
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="../../images/icons/location-icon.svg"
                                                                        class="img-fluid" alt="icon">
                                                                    <a href="#"
                                                                        class="btn btn-white d-flex align-items-center ml-4">
                                                                        <i class="far fa-edit text-secondary"></i>
                                                                        <span class="ml-1 mt-1">Ubah</span>
                                                                    </a>
                                                                    <a href="#"
                                                                        class="btn btn-white d-flex align-items-center ml-2">
                                                                        <i class="far fa-trash-alt text-secondary"></i>
                                                                        <span class="ml-1 mt-1">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        </div>
    </div>
</div>