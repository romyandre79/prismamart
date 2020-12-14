<div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col">
                    <h6 class="title-content">Ulasan</h6>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="card card-tab card-tab-shadow-radius">
                      <div class="card-header">
                        <nav class="nav">
                          <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/sellerulasan')?>">Rating Produk</a>
                          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerinboxulasan')?>">Inbox Ulasan</a>
                          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerpenilaian')?>">Penilaian Pembeli</a>
                          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerpenaltyreward')?>">Penalty dan Reward</a>
                        </nav>
                      </div>
                      <div class="card-body">
                        <div class="row filter-rating-produk-section">
                          <div class="col-12 mb-4">
                            <h6 class="title">Rata-rata rating 0 produk</h6>
                          </div>
                          <div class="col-12">
                            <div class="row rating-wrap">
                              <div
                                class="col-12 col-md-12 col-lg-5 d-flex align-items-end mb-4 mb-lg-0"
                              >
                                <div class="rating-star d-inline-block">
                                  <span class="icon-star"
                                    ><i class="fas fa-star"></i
                                  ></span>
                                  <p class="d-inline-block mb-0">
                                    <span>0.0</span>/5.0
                                  </p>
                                </div>
                                <div class="rating-info d-inline-block ml-5">
                                  <p class="mb-0"><span>0</span> ulasan</p>
                                  <p class="mb-0">Periode 27 Agu 2020 -</p>
                                  <p class="mb-0">Hari ini</p>
                                </div>
                              </div>
                              <div class="col-12 col-md-12 col-lg-7">
                                <div class="row d-flex align-items-end h-100">
                                  <div
                                    class="col-12 col-md-12 col-lg-4 mb-2 mb-0 pr-lg-0"
                                  >
                                    <div class="form-group mb-0">
                                      <select class="form-control shadow-none">
                                        <option>7 Hari Terakhir</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div
                                    class="col-12 col-md-12 col-lg-4 mb-2 mb-0 pr-lg-0"
                                  >
                                    <div class="form-group mb-0">
                                      <select class="form-control shadow-none">
                                        <option>Ulasan Terbanyak</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div
                                    class="col-12 col-md-12 col-lg-4 mb-2 mb-0"
                                  >
                                    <div class="input-group mb-0">
                                      <input
                                        type="text"
                                        class="form-control shadow-none"
                                        placeholder="Cari nama produk"
                                        aria-label="Cari nama produk"
                                        aria-describedby="filter-produk-name"
                                      />
                                      <div class="input-group-append">
                                        <button
                                          class="btn btn-light border shadow-none text-secondary"
                                          type="button"
                                          id="filter-produk-name"
                                        >
                                          <i class="fas fa-search"></i>
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-3 information-section p-0">
                          <div class="col">
                            <div class="table-responsive">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Nama produk</th>
                                    <th>Rating</th>
                                    <th>Total Ulasan</th>
                                    <th>
                                      Topik Populer
                                      <i
                                        class="fas fa-info-circle text-secondary ml-1"
                                      ></i>
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td colspan="4" class="text-center py-5">
                                      <img
                                        src="../../images/img-info.png"
                                        class="img-fluid img-support mt-5"
                                        alt="info"
                                      />
                                      <h1 class="title">Tidak ada ulasan</h1>
                                      <p>
                                        Yuk, terus jualan agar pembeli kasih
                                        kamu ulasan yang bikin happy
                                      </p>
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
              </div>