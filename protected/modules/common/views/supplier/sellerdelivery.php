<div class="row">
  <div class="col">
    <div class="card card-tab">
      <div class="card-header">
        <nav class="nav">
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerinfo')?>">Informasi</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/selleretalase')?>">Etalase</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellernotes')?>">Catatan</a>
          <a class="nav-link" href="<?php echo Yii::app()->createUrl('common/supplier/sellerlocation')?>">Lokasi</a>
          <a class="nav-link active" href="<?php echo Yii::app()->createUrl('common/supplier/sellerdelivery')?>">Pengiriman</a>
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
                        <div
                          class="alert alert-light-primary alert-my-info"
                          role="alert"
                        >
                          <img
                            src="../../images/icons/info-alert-sms-icon.svg"
                            class="img-fluid"
                            alt="icon"
                          />
                          <h6
                            class="text-dark font-medium font-weight-bold mb-0"
                          >
                            Bebas Ongkir untuk PM akan dikenai biaya
                          </h6>
                          <p class="text-dark font-small mb-0">
                            Power Merchant (PM) bisa nonaktifkan Bebas Ongkir
                            saja tanpa harus nonaktifkan SiCepat & AnterAja
                            <a href="#">di sini.</a>
                          </p>
                        </div>

                        <div class="row address-setsend-section">
                          <div class="col">
                            <h6 class="title-setsend">Asal Pengiriman</h6>
                            <div class="row mt-3">
                              <div class="col-12 col-md-4 col-lg-3">
                                <div class="form-group">
                                  <label for="kotaKecamatan"
                                    >Kota atau Kecamatan</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    id="kotaKecamatan"
                                    placeholder="Jawa Barat, Kota Tasikmalaya, Bungursari"
                                  />
                                </div>
                              </div>
                              <div class="col-12 col-md-3 col-lg-2 pl-md-0">
                                <div class="form-group">
                                  <label for="kodePost">Kode Pos</label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    id="kodePost"
                                    placeholder="46151"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="devider-setsend"></div>
                          </div>
                        </div>

                        <div class="row layanan-setsend-section">
                          <div class="col-12">
                            <h6 class="title-setsend">Layanan Pengiriman</h6>
                            <p class="subtitle-setsend">
                              Pilih layanan kurir yang ingin kamu sediakan di
                              tokomu
                            </p>
                          </div>
                          <div class="col-12">
                            <div class="border-top pt-3">
                              <div class="row">
                                <div class="col-12 col-lg-6 pr-lg-4">
                                  <div
                                    class="cat-layanan-setsend d-flex align-items-center"
                                  >
                                    <img
                                      src="../../images/dummy.png"
                                      class="img-fluid img-cat"
                                      alt="images"
                                    />
                                    <div class="content-cat ml-4">
                                      <h6
                                        class="font-medium font-weight-bold mb-0"
                                      >
                                        Dijemput Kurir
                                      </h6>
                                      <p class="font-small mb-0">
                                        Kurir akan menjemput pesanan di alamatmu
                                        untuk diantar ke pembeli.
                                      </p>
                                    </div>
                                  </div>

                                  <div class="cat-layanan-ket-setsend mt-4">
                                    <p class="mb-0 font-small">
                                      Semua kurir pada layanan ini memiliki
                                      fitur.
                                    </p>
                                    <a
                                      href="#"
                                      class="text-dark font-weight-bold font-medium text-decoration-none"
                                    >
                                      AWB Otomatis
                                      <i
                                        class="fas fa-info-circle text-secondary ml-1"
                                      ></i>
                                    </a>
                                    <a
                                      href="#"
                                      class="text-dark font-weight-bold font-medium text-decoration-none ml-3"
                                    >
                                      Non Tunai
                                      <i
                                        class="fas fa-info-circle text-secondary ml-1"
                                      ></i>
                                    </a>
                                  </div>

                                  <div class="kurir-setsend mt-3">
                                    <div class="d-flex align-items-center">
                                      <div
                                        class="custom-control custom-checkbox mr-1"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input kurir-check"
                                          id="anterajaCheck"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="anterajaCheck"
                                        ></label>
                                      </div>
                                      <img
                                        src="../../images/kurir/kurir-anteraja.png"
                                        class="img-fluid img-kurir"
                                        alt="kurir"
                                      />
                                      <div class="wrap-title-kurir">
                                        <h6 class="title-kurir">AnterAja</h6>
                                        <p class="type-kurir">
                                          Reguler Next Day Same Day
                                        </p>
                                      </div>
                                      <a href="#" class="icon-menus ml-auto">
                                        <i class="fas fa-chevron-down"></i>
                                      </a>
                                    </div>
                                    <div class="cashback-setsend mt-3">
                                      Cashback dari Amani Store hingga 20%
                                    </div>

                                    <div class="menus-kurir-setsend">
                                      <div
                                        class="custom-control custom-checkbox"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input list-kurir"
                                          id="anterajaReguler"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="anterajaReguler"
                                          >Reguler</label
                                        >
                                      </div>
                                      <div
                                        class="custom-control custom-checkbox"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input list-kurir"
                                          id="anterajaNextDay"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="anterajaNextDay"
                                          >Next Day</label
                                        >
                                      </div>
                                      <div
                                        class="custom-control custom-checkbox"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input list-kurir"
                                          id="anterajaSameDay"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="anterajaSameDay"
                                          >Same Day</label
                                        >
                                      </div>
                                    </div>
                                  </div>

                                  <div class="kurir-setsend mt-4">
                                    <div class="d-flex align-items-center">
                                      <div
                                        class="custom-control custom-checkbox mr-1"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input kurir-check"
                                          id="grabCheck"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="grabCheck"
                                        ></label>
                                      </div>
                                      <img
                                        src="../../images/kurir/kurir-grap-express.png"
                                        class="img-fluid img-kurir"
                                        alt="kurir"
                                      />
                                      <div class="wrap-title-kurir">
                                        <h6 class="title-kurir">GrabExpress</h6>
                                        <p class="type-kurir">
                                          Instant Same Day
                                        </p>
                                      </div>
                                      <a href="#" class="icon-menus ml-auto">
                                        <i class="fas fa-chevron-down"></i>
                                      </a>
                                    </div>

                                    <div class="menus-kurir-setsend">
                                      <div
                                        class="custom-control custom-checkbox"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input list-kurir"
                                          id="grabInstant"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="grabInstant"
                                          >Instant</label
                                        >
                                      </div>
                                      <div
                                        class="custom-control custom-checkbox"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input list-kurir"
                                          id="grabSameDay"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="grabSameDay"
                                          >Same Day</label
                                        >
                                      </div>
                                    </div>
                                  </div>

                                  <div class="kurir-setsend mt-4">
                                    <div class="d-flex align-items-center">
                                      <div
                                        class="custom-control custom-checkbox mr-1"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input kurir-check"
                                          id="gojekCheck"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="gojekCheck"
                                        ></label>
                                      </div>
                                      <img
                                        src="../../images/kurir/kurir-gosend.png"
                                        class="img-fluid img-kurir"
                                        alt="kurir"
                                      />
                                      <div class="wrap-title-kurir">
                                        <h6 class="title-kurir">Gojek</h6>
                                        <p class="type-kurir">
                                          Instant Courier Same Day
                                        </p>
                                      </div>
                                      <a href="#" class="icon-menus ml-auto">
                                        <i class="fas fa-chevron-down"></i>
                                      </a>
                                    </div>

                                    <div class="menus-kurir-setsend">
                                      <div
                                        class="custom-control custom-checkbox"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input list-kurir"
                                          id="gojekInstant"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="gojekInstant"
                                          >Instant Courier</label
                                        >
                                      </div>
                                      <div
                                        class="custom-control custom-checkbox"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input list-kurir"
                                          id="gojekSameDay"
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="gojekSameDay"
                                          >Same Day</label
                                        >
                                      </div>
                                    </div>
                                  </div>

                                  <div class="kurir-setsend mt-4">
                                    <div
                                      class="alert alert-light-danger alert-my-info"
                                      role="alert"
                                    >
                                      <img
                                        src="../../images/icons/info-alert-cros.svg"
                                        class="img-fluid"
                                        alt="icon"
                                      />
                                      <p
                                        class="text-dark font-small mb-0 ket-alert"
                                      >
                                        Kurir ini tidak tersedia di wilayah
                                        tokomu
                                      </p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                      <div
                                        class="custom-control custom-checkbox mr-1"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input kurir-check"
                                          id="ninjaCheck"
                                          disabled
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="ninjaCheck"
                                        ></label>
                                      </div>
                                      <img
                                        src="../../images/kurir/kurir-ninja-xpress.png"
                                        class="img-fluid img-kurir"
                                        alt="kurir"
                                      />
                                      <div class="wrap-title-kurir">
                                        <h6 class="title-kurir">
                                          Ninja Xpress
                                        </h6>
                                        <p class="type-kurir">Reguler</p>
                                      </div>
                                      <a
                                        href="#"
                                        class="text-secondary ml-auto"
                                      >
                                        <i class="fas fa-chevron-down"></i>
                                      </a>
                                    </div>
                                  </div>

                                  <div class="kurir-setsend mt-4">
                                    <div
                                      class="alert alert-light-danger alert-my-info"
                                      role="alert"
                                    >
                                      <img
                                        src="../../images/icons/info-alert-cros.svg"
                                        class="img-fluid"
                                        alt="icon"
                                      />
                                      <p
                                        class="text-dark font-small mb-0 ket-alert"
                                      >
                                        Kurir ini tidak tersedia di wilayah
                                        tokomu
                                      </p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                      <div
                                        class="custom-control custom-checkbox mr-1"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input kurir-check"
                                          id="rexCheck"
                                          disabled
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="rexCheck"
                                        ></label>
                                      </div>
                                      <img
                                        src="../../images/kurir/kurir-rex.png"
                                        class="img-fluid img-kurir"
                                        alt="kurir"
                                      />
                                      <div class="wrap-title-kurir">
                                        <h6 class="title-kurir">REX</h6>
                                        <p class="type-kurir">REX-10</p>
                                      </div>
                                      <a
                                        href="#"
                                        class="text-secondary ml-auto"
                                      >
                                        <i class="fas fa-chevron-down"></i>
                                      </a>
                                    </div>
                                  </div>

                                  <div class="kurir-setsend mt-4">
                                    <div
                                      class="alert alert-light-danger alert-my-info"
                                      role="alert"
                                    >
                                      <img
                                        src="../../images/icons/info-alert-cros.svg"
                                        class="img-fluid"
                                        alt="icon"
                                      />
                                      <p
                                        class="text-dark font-small mb-0 ket-alert"
                                      >
                                        Kurir ini tidak tersedia di wilayah
                                        tokomu
                                      </p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                      <div
                                        class="custom-control custom-checkbox mr-1"
                                      >
                                        <input
                                          type="checkbox"
                                          class="custom-control-input kurir-check"
                                          id="lionParcelCheck"
                                          disabled
                                        />
                                        <label
                                          class="custom-control-label"
                                          for="lionParcelCheck"
                                        ></label>
                                      </div>
                                      <img
                                        src="../../images/kurir/kurir-lion-parcel.png"
                                        class="img-fluid img-kurir"
                                        alt="kurir"
                                      />
                                      <div class="wrap-title-kurir">
                                        <h6 class="title-kurir">Lion Parcel</h6>
                                        <p class="type-kurir">Reguler</p>
                                      </div>
                                      <a
                                        href="#"
                                        class="text-secondary ml-auto"
                                      >
                                        <i class="fas fa-chevron-down"></i>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                                <div
                                  class="col-12 col-lg-6 pl-lg-0 mt-4 mt-lg-0"
                                >
                                  <div class="cat-right pl-lg-4">
                                    <div
                                      class="cat-layanan-setsend d-flex align-items-center"
                                    >
                                      <img
                                        src="../../images/dummy.png"
                                        class="img-fluid img-cat"
                                        alt="images"
                                      />
                                      <div class="content-cat ml-4">
                                        <h6
                                          class="font-medium font-weight-bold mb-0"
                                        >
                                          Antar ke Kantor Agen
                                        </h6>
                                        <p class="font-small mb-0">
                                          Bawa pesanan ke kantor agen terdekat
                                          dan minta resi dari petugas.
                                        </p>
                                      </div>
                                    </div>

                                    <div class="kurir-setsend right-first">
                                      <div class="d-flex align-items-center">
                                        <div
                                          class="custom-control custom-checkbox mr-1"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input kurir-check"
                                            id="sicepatCheck"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="sicepatCheck"
                                          ></label>
                                        </div>
                                        <img
                                          src="../../images/kurir/kurir-sicepat.png"
                                          class="img-fluid img-kurir"
                                          alt="kurir"
                                        />
                                        <div class="wrap-title-kurir">
                                          <h6 class="title-kurir">SiCepat</h6>
                                          <p class="type-kurir">
                                            Regular Package BEST GOKIL
                                          </p>
                                        </div>
                                        <a href="#" class="icon-menus ml-auto">
                                          <i class="fas fa-chevron-down"></i>
                                        </a>
                                      </div>
                                      <div class="cashback-setsend mt-3">
                                        Cashback dari Amani Store hingga 35%
                                      </div>

                                      <div class="footer-kurir-setsend mt-3">
                                        <span
                                          class="d-inline-block py-1 px-2 font-small"
                                          >Amani Store Corner</span
                                        >
                                        <span
                                          class="d-inline-block py-1 px-2 font-small"
                                          >Bayar di Tempat</span
                                        >
                                      </div>

                                      <div class="menus-kurir-setsend">
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="sicepatReguler"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="sicepatReguler"
                                            >Reguler Package</label
                                          >
                                        </div>
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="sicepatNextDay"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="sicepatNextDay"
                                            >Best</label
                                          >
                                        </div>
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="sicepatSameDay"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="sicepatSameDay"
                                            >Gokil</label
                                          >
                                        </div>
                                      </div>
                                    </div>

                                    <div class="kurir-setsend mt-3">
                                      <div class="d-flex align-items-center">
                                        <div
                                          class="custom-control custom-checkbox mr-1"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input kurir-check"
                                            id="jntCheck"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="jntCheck"
                                          ></label>
                                        </div>
                                        <img
                                          src="../../images/kurir/kurir-jnt.png"
                                          class="img-fluid img-kurir"
                                          alt="kurir"
                                        />
                                        <div class="wrap-title-kurir">
                                          <h6 class="title-kurir">JNT</h6>
                                          <p class="type-kurir">Regular</p>
                                        </div>
                                        <a href="#" class="icon-menus ml-auto">
                                          <i class="fas fa-chevron-down"></i>
                                        </a>
                                      </div>
                                      <div class="cashback-setsend mt-3">
                                        Cashback dari Amani Store hingga 15%
                                      </div>

                                      <div class="footer-kurir-setsend mt-3">
                                        <span
                                          class="d-inline-block py-1 px-2 font-small"
                                          >Non Tunai</span
                                        >
                                        <span
                                          class="d-inline-block py-1 px-2 font-small"
                                          >AWB Otomatis</span
                                        >
                                      </div>

                                      <div class="menus-kurir-setsend">
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="jntReguler"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="jntReguler"
                                            >Reguler</label
                                          >
                                        </div>
                                      </div>
                                    </div>

                                    <div class="kurir-setsend mt-3">
                                      <div class="d-flex align-items-center">
                                        <div
                                          class="custom-control custom-checkbox mr-1"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input kurir-check"
                                            id="jneCheck"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="jneCheck"
                                          ></label>
                                        </div>
                                        <img
                                          src="../../images/kurir/kurir-jne.png"
                                          class="img-fluid img-kurir"
                                          alt="kurir"
                                        />
                                        <div class="wrap-title-kurir">
                                          <h6 class="title-kurir">JNE</h6>
                                          <p class="type-kurir">
                                            Reguler OKE YES JNE Trucking
                                          </p>
                                        </div>
                                        <a href="#" class="icon-menus ml-auto">
                                          <i class="fas fa-chevron-down"></i>
                                        </a>
                                      </div>
                                      <div class="cashback-setsend mt-3">
                                        Cashback dari Amani Store hingga 12.5%
                                      </div>

                                      <div class="footer-kurir-setsend mt-3">
                                        <span
                                          class="d-inline-block py-1 px-2 font-small"
                                          >Non Tunai</span
                                        >
                                        <span
                                          class="d-inline-block py-1 px-2 font-small"
                                          >AWB Otomatis</span
                                        >
                                      </div>

                                      <div class="menus-kurir-setsend">
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="jneReguler"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="jneReguler"
                                            >Reguler</label
                                          >
                                        </div>
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="jneOke"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="jneOke"
                                            >Oke</label
                                          >
                                        </div>
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="jneYes"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="jneYes"
                                            >Yes</label
                                          >
                                        </div>
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="jneTrucking"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="jneTrucking"
                                            >JNE Trucking</label
                                          >
                                        </div>
                                      </div>
                                    </div>

                                    <div class="kurir-setsend mt-3">
                                      <div class="d-flex align-items-center">
                                        <div
                                          class="custom-control custom-checkbox mr-1"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input kurir-check"
                                            id="tikiCheck"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="tikiCheck"
                                          ></label>
                                        </div>
                                        <img
                                          src="../../images/kurir/kurir-tiki.png"
                                          class="img-fluid img-kurir"
                                          alt="kurir"
                                        />
                                        <div class="wrap-title-kurir">
                                          <h6 class="title-kurir">TIKI</h6>
                                          <p class="type-kurir">
                                            Reguler Over Night Service
                                          </p>
                                        </div>
                                        <a href="#" class="icon-menus ml-auto">
                                          <i class="fas fa-chevron-down"></i>
                                        </a>
                                      </div>

                                      <div class="menus-kurir-setsend">
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="tikiReguler"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="tikiReguler"
                                            >Reguler</label
                                          >
                                        </div>
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="tikiONS"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="tikiONS"
                                            >Over Night Service</label
                                          >
                                        </div>
                                      </div>
                                    </div>

                                    <div class="kurir-setsend mt-3">
                                      <div class="d-flex align-items-center">
                                        <div
                                          class="custom-control custom-checkbox mr-1"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input kurir-check"
                                            id="wahanaCheck"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="wahanaCheck"
                                          ></label>
                                        </div>
                                        <img
                                          src="../../images/kurir/kurir-wahana.png"
                                          class="img-fluid img-kurir"
                                          alt="kurir"
                                        />
                                        <div class="wrap-title-kurir">
                                          <h6 class="title-kurir">Wahana</h6>
                                          <p class="type-kurir">
                                            Service Normal
                                          </p>
                                        </div>
                                        <a href="#" class="icon-menus ml-auto">
                                          <i class="fas fa-chevron-down"></i>
                                        </a>
                                      </div>

                                      <div class="menus-kurir-setsend">
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="wahanaServiceNormal"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="wahanaServiceNormal"
                                            >Service Normal</label
                                          >
                                        </div>
                                      </div>
                                    </div>

                                    <div class="kurir-setsend mt-3">
                                      <div class="d-flex align-items-center">
                                        <div
                                          class="custom-control custom-checkbox mr-1"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input kurir-check"
                                            id="posIndonesiaCheck"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="posIndonesiaCheck"
                                          ></label>
                                        </div>
                                        <img
                                          src="../../images/kurir/kurir-pos-indonesia.png"
                                          class="img-fluid img-kurir"
                                          alt="kurir"
                                        />
                                        <div class="wrap-title-kurir">
                                          <h6 class="title-kurir">
                                            Pos Indonesia
                                          </h6>
                                          <p class="type-kurir">
                                            Pos Kilat Khusus
                                          </p>
                                        </div>
                                        <a href="#" class="icon-menus ml-auto">
                                          <i class="fas fa-chevron-down"></i>
                                        </a>
                                      </div>

                                      <div class="menus-kurir-setsend">
                                        <div
                                          class="custom-control custom-checkbox"
                                        >
                                          <input
                                            type="checkbox"
                                            class="custom-control-input list-kurir"
                                            id="posIndonesiaPKS"
                                          />
                                          <label
                                            class="custom-control-label"
                                            for="posIndonesiaPKS"
                                            >Pos Kilat Khusus</label
                                          >
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row location-layanan-setsend mt-5">
                                <div class="col-12 col-md-6">
                                  <h6 class="title-setsend mb-0">
                                    Tandai Lokasi Penjemputan
                                  </h6>
                                  <p class="font-small text-secondary">
                                    (Wajib diisi jika mengaktifkan Dijemput
                                    Kurir)
                                  </p>

                                  <div class="card">
                                    <div class="card-body clearfix">
                                      <img
                                        src="../../images/icons/home-location-icon.svg"
                                        class="img-fluid"
                                        alt="icon"
                                      />
                                      <span
                                        class="text-secondary font-medium ml-2"
                                        >Kec. Bungursari, Tasikmalaya, Jawa
                                        Barat, 46151</span
                                      >
                                      <a
                                        href="#"
                                        class="float-right text-decoration-none"
                                        >Ubah</a
                                      >
                                    </div>
                                  </div>
                                </div>

                                <div
                                  class="col-12 col-md-6 d-flex justify-content-end align-items-end"
                                >
                                  <a
                                    href="#"
                                    class="btn btn-primary btn-lg px-5 font-weight-bold"
                                    >Simpan</a
                                  >
                                </div>
                              </div>
                            </div>

                            <div class="devider-setsend"></div>
                          </div>
                        </div>

                        <div class="row rekomendasi-setsend-section">
                          <div class="col-12">
                            <div class="border-bottom">
                              <h6 class="title-setsend">Kurir Rekomendasi</h6>
                              <p class="subtitle-setsend">
                                Kurir Rekomendasi adalah sebuah layanan
                                pengiriman yang disediakan Amani Store untuk
                                memudahkan Seller dalam proses pengiriman kepada
                                para pembeli. Dengan didukung oleh data dan
                                sistem yang canggih, Seller tidak perlu repot
                                berhadapan dengan standar dan kurir yang
                                berbeda-beda. Untuk informasi lebih lanjut bisa
                                cek <a href="#">disini</a>.
                              </p>
                            </div>
                          </div>

                          <div class="col-12 mt-3">
                            <div
                              class="card-rekomen-setsend border-bottom pb-3"
                            >
                              <h6 class="title-setsend">Instant</h6>
                              <p class="subtitle-setsend mb-0">
                                Layanan pengiriman instan dengan durasi
                                pengiriman beberapa jam saja (3 jam) sejak serah
                                terima paket ke kurir.
                              </p>
                              <p class="ket-setsend">
                                Partner yang menyediakan layanan ini:
                              </p>

                              <div class="table-responsive">
                                <table
                                  class="table table-bordered table-rekomen"
                                >
                                  <tbody>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-gosend.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>GoSend Instant</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-grap-express.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>GrabExpress Instant</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div
                              class="card-rekomen-setsend border-bottom mt-3 pb-3"
                            >
                              <h6 class="title-setsend">Same Day</h6>
                              <p class="subtitle-setsend mb-0">
                                Layanan pengiriman dengan durasi pengiriman
                                beberapa jam (6 jam) sejak serah terima paket ke
                                kurir dan akan sampai di hari yang sama.
                              </p>
                              <p class="ket-setsend">
                                Partner yang menyediakan layanan ini:
                              </p>

                              <div class="table-responsive">
                                <table
                                  class="table table-bordered table-rekomen"
                                >
                                  <tbody>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-gosend.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>GoSend Same Day</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-grap-express.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>GrabExpress Same Day</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div
                              class="card-rekomen-setsend border-bottom mt-3 pb-3"
                            >
                              <h6 class="title-setsend">Next Day</h6>
                              <p class="subtitle-setsend mb-0">
                                Layanan pengiriman express dengan durasi
                                pengiriman 1 hari dihitung sejak serah terima
                                paket ke kurir.
                              </p>
                              <p class="ket-setsend">
                                Partner yang menyediakan layanan ini:
                              </p>

                              <div class="table-responsive">
                                <table
                                  class="table table-bordered table-rekomen"
                                >
                                  <tbody>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-jne.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>JNE YES (Yakin Esok Sampai)</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-sicepat.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>
                                        SiCepat BEST (Besok Sampai Tujuan)
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-tiki.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>TIKI ONS (One Night Service)</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-anteraja.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>AnterAja Next Day</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div
                              class="card-rekomen-setsend border-bottom mt-3 pb-3"
                            >
                              <h6 class="title-setsend">Reguler</h6>
                              <p class="subtitle-setsend mb-0">
                                Layanan pengiriman standard dengan kecepatan
                                pengiriman tergantung dari lokasi pengiriman dan
                                lokasi tujuan. Umumnya 2-4 hari/ 5-9 hari/ >9
                                hari tergantung rute pengiriman.
                              </p>
                              <p class="ket-setsend">
                                Partner yang menyediakan layanan ini:
                              </p>

                              <div class="table-responsive">
                                <table
                                  class="table table-bordered table-rekomen"
                                >
                                  <tbody>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-jne.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>JNE REG (Reguler)</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-jnt.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>J&T Express Reguler</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-sicepat.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>SiCepat Regular</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-tiki.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>TIKI REG (Reguler)</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-pos-indonesia.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>Pos Kilat Khusus</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-anteraja.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>AnterAja Regular</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-ninja-xpress.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>Standar</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">...</td>
                                      <td>Kurir Rekomendasi Reguler</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div
                              class="card-rekomen-setsend border-bottom mt-3 pb-3"
                            >
                              <h6 class="title-setsend">Ekonomi</h6>
                              <p class="subtitle-setsend mb-0">
                                Layanan pengiriman standard dengan kecepatan
                                pengiriman 2-9 hari tergantung rute pengiriman.
                                Harga lebih murah apabila dibandingkan dengan
                                Reguler, tetapi durasi pengiriman mirip dengan
                                Reguler.
                              </p>
                              <p class="ket-setsend">
                                Partner yang menyediakan layanan ini:
                              </p>

                              <div class="table-responsive">
                                <table
                                  class="table table-bordered table-rekomen"
                                >
                                  <tbody>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-jne.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>JNE OKE (Ongkos Kirim Ekonomis)</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-wahana.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>Wahana Service Normal</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div class="card-rekomen-setsend mt-3 pb-3">
                              <h6 class="title-setsend">Kargo</h6>
                              <p class="subtitle-setsend mb-0">
                                Layanan pengiriman standard dengan kecepatan
                                pengiriman 3-8 hari tergantung rute pengiriman.
                                Harga lebih murah/ ekonomis dan berskala besar
                                (bulk shipment) dengan durasi pengiriman yang
                                lebih lama karena menggunakan jalur darat.
                              </p>
                              <p class="ket-setsend">
                                Partner yang menyediakan layanan ini:
                              </p>

                              <div class="table-responsive">
                                <table
                                  class="table table-bordered table-rekomen"
                                >
                                  <tbody>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-sicepat.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>SiCepat GOKIL</td>
                                    </tr>
                                    <tr>
                                      <td class="td-img">
                                        <img
                                          src="../../images/kurir/kurir-rex.png"
                                          class="img-fluid"
                                          alt="kurir"
                                        />
                                      </td>
                                      <td>REX Reguler Service (REX-10)</td>
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