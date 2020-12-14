<div class="row head-rekap-section">
                        <div class="col-12 col-lg-3 d-flex align-items-center">
                            <h4 class="title mb-0">Wawasan Toko</h4>
                        </div>
                        <div class="col-12 col-lg-7 offset-lg-2 col-modify mt-3 mt-lg-0">
                            <div class="clearfix w-100">
                                <div class="float-lg-right pl-lg-2 mb-2 mb-lg-0">
                                    <a href="#" class="btn btn-saran">
                                        <img src="../../images/icons/info-saran-icon.svg" class="img-fluid mr-1"
                                            alt="icon">
                                        <span>Beri Saran</span>
                                    </a>
                                </div>
                                <div class="float-lg-right px-lg-2 w-75">
                                    <div id="pickerRekap" class="form-control disabled clearfix">
                                        <span class="dateValueRekap"></span>
                                        <i class="fas fa-chevron-down icon-calendar float-right"></i>
                                    </div>

                                    <div class="form-group mb-0">
                                        <input type="hidden" id="waktuMulaiFilterRekap" name="waktuMulaiFilterRekap">
                                        <input type="hidden" id="waktuAkhirFilterRekap" name="waktuAkhirFilterRekap">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col">
                            <div class="alert alert-light-primary alert-dismissible fade show alert-my-info"
                                role="alert">
                                <img src="../../images/icons/info-alert-sms-icon.svg" class="img-fluid" alt="icon">
                                Ingin buka halaman Wawasan Toko versi sebelumnya? <a href="#">Pakai Versi Lama</a>

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row ringkasan-statistik-section mt-3">
                        <div class="col-12">
                            <h5 class="title">Ringkasan statistik</h5>
                            <p class="subtitle">Rutin pantau perkembangan toko untuk tingkatkan penjualanmu.</p>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                                    <div class="card card-box-repot">
                                        <div class="card-body">
                                            <p class="text-top">
                                                Pendapatan bersih baru
                                                <span><i class="fas fa-info-circle ml-1"></i></span>
                                            </p>
                                            <h3 class="text-middle">Rp0</h3>
                                            <p class="text-bottom">
                                                <span>0%</span> dari 7 hari lalu
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                                    <div class="card card-box-repot">
                                        <div class="card-body">
                                            <p class="text-top">
                                                Produk dilihat
                                                <span><i class="fas fa-info-circle ml-1"></i></span>
                                            </p>
                                            <h3 class="text-middle">Rp0</h3>
                                            <p class="text-bottom">
                                                <span>0%</span> dari 7 hari lalu
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                                    <div class="card card-box-repot">
                                        <div class="card-body">
                                            <p class="text-top">
                                                Konversi
                                                <span><i class="fas fa-info-circle ml-1"></i></span>
                                            </p>
                                            <h3 class="text-middle">Rp0</h3>
                                            <p class="text-bottom">
                                                <span>0%</span> dari 7 hari lalu
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                                    <div class="card card-box-repot">
                                        <div class="card-body">
                                            <p class="text-top">
                                                Pesanan baru
                                                <span><i class="fas fa-info-circle ml-1"></i></span>
                                            </p>
                                            <h3 class="text-middle">Rp0</h3>
                                            <p class="text-bottom">
                                                <span>0%</span> dari 7 hari lalu
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row jumlah-pendapatan-section mt-5">
                        <div class="col-12">
                            <h5 class="title">Ringkasan statistik</h5>
                            <p class="subtitle">Rutin pantau perkembangan toko untuk tingkatkan penjualanmu.</p>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Pendapatan bersih baru</h4>
                                                    <h3 class="value">Rp0</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <canvas id="jumlahPendapatanChart" height="80"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                                    <div class="card card-box-repot">
                                        <div class="card-body">
                                            <p class="text-top">
                                                Pendapatan kotor diterima
                                                <span><i class="fas fa-info-circle ml-1"></i></span>
                                            </p>
                                            <h3 class="text-middle">Rp0</h3>
                                            <p class="text-bottom">
                                                <span>0%</span> dari 7 hari lalu
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                                    <div class="card card-box-repot">
                                        <div class="card-body">
                                            <p class="text-top">
                                                Pendapatan bersih diterima
                                                <span><i class="fas fa-info-circle ml-1"></i></span>
                                            </p>
                                            <h3 class="text-middle">Rp0</h3>
                                            <p class="text-bottom">
                                                <span>0%</span> dari 7 hari lalu
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ongkir-info-section mt-5">
                        <div class="col-12">
                            <h5 class="title">Bagaimana Bebas Ongkir memengaruhi pendapatanmu?</h5>
                            <p class="subtitle">Data berikut di-update beberapa waktu lebih lambat dari data lainnya.
                            </p>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3 mb-lg-0">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Detail pendapatan bersih baru <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></h4>
                                                    <h3 class="value">Rp0</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                                                    <canvas id="ongkirPendapatanBersihChart"></canvas>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="legend-custom">
                                                        <p class="mb-0">
                                                            <i class="fas fa-circle text-primary"></i> Bebas Ongkir
                                                        </p>
                                                        <p class="mb-0 ml-3">Rp0</p>
                                                    </div>
                                                    <div class="legend-custom">
                                                        <p class="mb-0">
                                                            <i class="fas fa-circle text-info"></i> Non-Bebas Ongkir
                                                        </p>
                                                        <p class="mb-0 ml-3">Rp0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3 mb-lg-0">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Detail pesanan baru <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></h4>
                                                    <h3 class="value">Rp0</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                                                    <canvas id="ongkirPesananBaruChart"></canvas>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="legend-custom">
                                                        <p class="mb-0">
                                                            <i class="fas fa-circle text-primary"></i> Bebas Ongkir
                                                        </p>
                                                        <p class="mb-0 ml-3">Rp0</p>
                                                    </div>
                                                    <div class="legend-custom">
                                                        <p class="mb-0">
                                                            <i class="fas fa-circle text-info"></i> Non-Bebas Ongkir
                                                        </p>
                                                        <p class="mb-0 ml-3">Rp0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row konversi-produk-section mt-5">
                        <div class="col-12">
                            <h5 class="title">Produk dilihat dan konversi</h5>
                            <p class="subtitle">Pantau berapa kali produkmu dilihat dan terjual.</p>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3 mb-lg-0">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Tren produk dilihat <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></h4>
                                                    <h3 class="value">Rp0</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <canvas id="trenDilihatChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3 mb-lg-0">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Tren konversi produk <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></h4>
                                                    <h3 class="value">Rp0</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <canvas id="trenKonversiChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row perubahan-produk-section mt-4">
                        <div class="col">
                            <div class="card get-shadow-card">
                                <div class="card-header bg-white border-bottom-0 pb-0">
                                    <h5 class="my-card-title">
                                        Perubahan produk dilihat
                                        <i class="fas fa-info-circle text-secondary ml-1"></i>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td class="border-top-0">Nama produk</td>
                                                    <td class="border-top-0">Kategori</td>
                                                    <td class="border-top-0">Etalase</td>
                                                    <td class="border-top-0">Perubahan <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="4" class="text-center pt-5">
                                                        <span class="">Tidak ada data yang ditampilkan</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row performa-pesanan-section mt-5">
                        <div class="col-12">
                            <h5 class="title">Performa pesanan</h5>
                            <p class="subtitle">Perkembangan pesanan yang berhasil dibayar oleh pembeli.</p>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3 mb-lg-0">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Tren pesanan <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></h4>
                                                    <h3 class="value">Rp0</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <canvas id="trenPesananChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3 mb-lg-0">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Tipe pembatalan <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></h4>
                                                    <h3 class="value">0 Penjualan</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <canvas id="tipePembatalanChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                                    <div class="card card-box-repot">
                                        <div class="card-body">
                                            <p class="text-top">
                                                Rata-rata transaksi
                                                <span><i class="fas fa-info-circle ml-1"></i></span>
                                            </p>
                                            <h3 class="text-middle">Rp0</h3>
                                            <p class="text-bottom">
                                                <span>0%</span> dari 7 hari lalu
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                                    <div class="card card-box-repot">
                                        <div class="card-body">
                                            <p class="text-top">
                                                Rata-rata jumlah barang
                                                <span><i class="fas fa-info-circle ml-1"></i></span>
                                            </p>
                                            <h3 class="text-middle">0 barang</h3>
                                            <p class="text-bottom">
                                                <span>0%</span> dari 7 hari lalu
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row gender-pembeli-section mt-5">
                        <div class="col-12">
                            <h5 class="title">Profil pembeli</h5>
                            <p class="subtitle">Info seputar pembeli yang berbelanja di tokomu.</p>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3 mb-lg-0">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Jenis kelamin pembeli <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></h4>
                                                    <h3 class="value">Rp0</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                                                    <canvas id="jenisKelaminPembeliChart"></canvas>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="legend-custom">
                                                        <p class="mb-0">
                                                            <i class="fas fa-circle text-primary"></i> Tidak disebutkan
                                                        </p>
                                                        <p class="mb-0 ml-3">Rp0</p>
                                                    </div>
                                                    <div class="legend-custom">
                                                        <p class="mb-0">
                                                            <i class="fas fa-circle text-info"></i> Laki-laki
                                                        </p>
                                                        <p class="mb-0 ml-3">Rp0</p>
                                                    </div>
                                                    <div class="legend-custom">
                                                        <p class="mb-0">
                                                            <i class="fas fa-circle text-pink"></i> Perempuan
                                                        </p>
                                                        <p class="mb-0 ml-3">Rp0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-3 mb-lg-0">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Tipe pembeli <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></h4>
                                                    <h3 class="value">Rp0</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                                                    <canvas id="tipePembeliChart"></canvas>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="legend-custom">
                                                        <p class="mb-0">
                                                            <i class="fas fa-circle text-primary"></i> Pembeli Baru
                                                        </p>
                                                        <p class="mb-0 ml-3">Rp0</p>
                                                    </div>
                                                    <div class="legend-custom">
                                                        <p class="mb-0">
                                                            <i class="fas fa-circle text-info"></i> Pembeli Reguler
                                                        </p>
                                                        <p class="mb-0 ml-3">Rp0</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row usia-pembeli-section mt-5">
                        <div class="col-12">
                            <div class="row">
                                <div class="col">
                                    <div class="card card-chart">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h4 class="title-chart">Usia Pembeli <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></h4>
                                                    <h3 class="value">0 Pembeli</h3>
                                                    <p class="info"><span>0%</span> dari 7 hari lalu</p>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <canvas id="usiaPembeliChart" height="80"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pasal-kota-pembeli-section mt-4">
                        <div class="col">
                            <div class="card get-shadow-card">
                                <div class="card-header bg-white border-bottom-0 pb-0">
                                    <h5 class="my-card-title">
                                        Asal kota pembeli
                                        <i class="fas fa-info-circle text-secondary ml-1"></i>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td class="border-top-0">Kota</td>
                                                    <td class="border-top-0">Pembeli</td>
                                                    <td class="border-top-0">Pesanan</td>
                                                    <td class="border-top-0">Barang <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></td>
                                                    <td class="border-top-0">Nilai Pesanan <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></td>
                                                    <td class="border-top-0">% Nilai Pesanan <i
                                                            class="fas fa-info-circle text-secondary ml-1"></i></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="6" class="text-center pt-5">
                                                        <span class="">Tidak ada data yang ditampilkan</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>