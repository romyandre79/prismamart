<!-- the shop is not complete -->
<section class="not-complete corresponding start">
    <div class="container">
      <h3 class="form-label">Informasi Produk</h3>
    </div>
    <div class="container container-resposne">
      <p>Pastikan produk anda sudah sesuai dengan syarat dan ketentuan Prisma Store. Prisma Store menghimbau seller untuk
        menjual produk dengan
        harga yang wajar atau produk Anda dapat diturunkan oleh Prisma Store sesuai S&K yang berlaku</p>
    </div>
  </section>
  <!-- end the shop is not complete -->

  <section class="upload-product">
    <div class="container">
      <div class="row">
        <form role="form" action="#" method="post" enctype="multipart/form-data">
          <div class="banner">
            <h3 class="form-label">Informasi Produk<span>wajib</span> </h3>
            <div class="desc">
              <p class="text-left">Format gambar .jpg .jpeg .png dan ukuran minimum 300 x 300px (Untuk gambar
                optimal gunakan ukuran 700 x700)</p>
            </div>
            <div id="app" class="img-banner">
              <upload-gambar></upload-gambar>
              <upload-gambar></upload-gambar>
              <upload-gambar></upload-gambar>
              <upload-gambar></upload-gambar>
              <upload-gambar></upload-gambar>
            </div>

            <div class="banner-foot">
              <div class="upload-btn-wrapper">
                <button class="btn">+ Pilih Gambar Produk</button>
                <input type="file" name="myfile" />
                <p class="text-left">atau tarik dan letakkan hingga 5 gambar sekaligus di sini</p>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="banner">
            <h3 class="form-label">Upload Produk</h3>
            <div class="form-group row">
              <div class="form-desc">
                <label for="inputEmail3">Nama Produk <span>Wajib</span> </label>
                <span>Nama Produk min. 5 kata dan terdiri
                  dari jenis produk, merek, dan
                  keterangan seperti warna, bahan,
                  atau tipe.</span>
              </div>
              <div class="input-form">
                <input type="email" class="form-control" id="inputEmail3"
                  placeholder="Contoh: Sepatu Pria (Jenis/Kategori Produk) + Tokostore (Merek) + Kanvas Hitam (Keterangan)">
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="Kategori" class="col-form-label">Kategori<span>Wajib</span> </label>
              </div>
              <div class="input-form">
                <select id="Kategori" class="form-control">
                  <option>Pilih Kategori</option>
                  <option>Elektronik</option>
                  <option>Fashion</option>
                  <option>Makanan</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="etalase" class="col-form-label">Etalase<span>Wajib</span> </label>
              </div>
              <div class="input-form">
                <select id="etalase" class="form-control etalase">
                  <option disabled selected>Pilih Etalase</option>
                  <option>Tambah Etalase</option>
                  <option>Etalas 1</option>
                  <option>Etalas 2</option>
                  <option>Etalas 3</option>
                </select>
              </div>
            </div>
          </div>

          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content modal-original">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Etalase</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group d-block m-0">
                    <label for="inputTambahEtalase">Etalase</label>
                    <input type="text" class="form-control" id="inputTambahEtalase">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                  <button type="button" class="btn btn-success">Tambah</button>
                </div>
              </div>
            </div>
          </div>


          <div class="col-md-12 banner">
            <h3 class="form-label">Deskripsi Produk</h3>
            <div class="form-group row">
              <div class="form-desc">
                <label for="inputEmail3" class="col-form-label">Kondisi</label>
              </div>
              <div class="col-10 input-form">
                <div class="form">
                  <div class="form-head">
                    <label class="contain">
                      <input value="baru" checked type="radio" name="kondisi">
                      <span class="checkmark"></span>
                    </label>
                    <span class="value">Baru</span>
                  </div>
                  <div class="form-head">
                    <label class="contain">
                      <input value="bekas" type="radio" name="kondisi">
                      <span class="checkmark"></span>
                    </label>
                    <span class="value">Bekas</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="Kategori" class="col-form-label">Keterangan Produk</label>
                <span class="span-textarea">cantumkan deskripsi lengkap sesuai
                  produk, seperti keunggulan,
                  spesifikasi, material, ukuran, masa
                  berlaku, dan lainnya. Panjang
                  deskripsi antara 450-2000 karakter.</span>
              </div>
              <div class="col-10 input-form">
                <textarea placeholder="Sepatu Sneakers Pria Tokostore Kanvas Hitam Seri C28B

                - Model Simple
                - Nyaman Digunakan
                - Tersedia warna hitam
                - Sole PVC (injection shoes) yang nyaman awet untuk digunakan sehari - hari
                
                Bahan:
                Upper: Semi Leather (kulit tidak pecah - pecah)
                Sole: Premium Rubber Sole
                
                Ukuran
                39 : 25,5 cm
                40 : 26 cm
                41 : 26,5 cm
                " class="form-control" id="exampleFormControlTextarea1" rows="15"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="etalase" class="col-form-label">Vieo Produk <small>(Opsional)</small></label>
                <span>URL video yang didukung saat ini
                  adalah URL video dari <a href=""> Youtube. Info
                    Lengkap</a></span>
              </div>
              <div class="input-form">
                <button class="btn btn-light plus" type="button">+ Tambah URL Video</button>
              </div>
            </div>
          </div>
          <div class="banner">
            <h3 class="form-label">Varian Produk</h3>
            <div class="form-group">
              <div class="form-desc varian">
                <label for="inputEmail3" class="col-9 col-form-label"></label>
                <span class="span-varian w-75">Aktifkan Varian Produk agar memudahkan pembeli cek stok produkmu. Tambahkan
                  detail varian seperti warna, ukuran,
                  atau pilihan varian lainnya, Varian Produk tersedia untuk kategori tertentu, <a href=""> Pilih
                    Kategori</a> Produk
                  sekarang</span>
              </div>
              <div class="input-form">
                <button class="btn btn-light plus" type="button">+ Tambah Varian Video</button>
              </div>
            </div>
          </div>
          <div class="banner">
            <h3 class="form-label">Harga</h3>
            <div class="form-group row">
              <div class="form-desc">
                <label for="Kategori" class="col-form-label">Minimum Pemesanan</label>
                <span>Atur jumlah minimum yang harus
                  dibeli untuk produk ini.</span>
              </div>
              <div class="col-10 input-form">
                <div class="row">
                  <div class="col-1">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="checkDisabledMinimun">
                      <label class="custom-control-label" for="checkDisabledMinimun"></label>
                    </div>
                  </div>
                  <div class="col-11">
                    <input type="text" class="form-control stok" id="MinimunPemesananInput" placeholder="1"
                      disabled="disabled">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="Kategori" class="col-form-label">Harga Satuan <span>Wajib</span></label>
              </div>
              <div class="col-10 input-form">
                <div class="row">
                  <div class="col-1">
                    <span>Rp</span>
                  </div>
                  <div class="col-11">
                    <input type="text" class="form-control stok" id="inputEmail3" placeholder="Masukan Harga">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="Kategori" class="col-form-label">Harga Grosir</label>
                <span>Tambahkan harga grosir untuk
                  pembelian produk dalam jumlah
                  tertentu.</span>
              </div>
              <div class="col-10 input-form">
                <button class="btn btn-light plus-grosir" type="button">+ Tambah Harga Grosir</button>
                <div class="row align-items-center">
                  <div class="col-4">
                    <div class="form-group m-0 row align-items-center">
                      <label for="colFormLabel" class="col-sm-2 col-form-label">Min. Qty</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="col-5">
                    <div class="form-group m-0 row align-items-center">
                      <label for="colFormLabel" class="col-sm-2 col-form-label">Rp</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="banner">
            <h3 class="form-label">Pengelolaan Produk</h3>
            <div class="form-group row">
              <div class="form-desc">
                <label for="inputEmail3" class="col-form-label">Staus Produk</label>
                <span>Jika status aktif, produkmu dapat
                  dicari oleh calon pembeli.</span>
              </div>
              <div class="col-10 input-form">
                <div class="form">
                  <div class="form-head">
                    <div class="onoffswitch">
                      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                      <label class="onoffswitch-label" for="myonoffswitch">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                    <span class="value">Aktif</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="Kategori" class="col-form-label">Stok Produk</label>
              </div>
              <div class="col-10 input-form">
                <input type="email" class="form-control stok" id="inputEmail3" placeholder="Masukan Jumlah Stok">
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="Kategori" class="col-form-label">SKU (Stock Keeping Unit)</label>
                <span>Gunakan SKU untuk menambahkan
                  kode unik pada produk ini.</span>
              </div>
              <div class="col-10 input-form">
                <input type="email" class="form-control stok" id="inputEmail3" placeholder="Masukan SKU">
              </div>
            </div>
          </div>
          <div class="col-md-12 banner">
            <h3 class="form-label">Berat & Pengiriman</h3>
            <div class="form-group row">
              <div class="form-desc">
                <label for="inputEmail3" class="col-form-label">Berat <span>Wajib</span> </label>
                <span>Produk ringan dengan ukuran yang
                  besar hitung dengan <a href=""> Volume Weight.</a></span>
              </div>
              <div class="input-form weight">
                <select id="weight" class="form-control etalase">
                  <option>Gram (g)</option>
                  <option>Kilogram (Kg)</option>
                </select>
                <input type="email" class="form-control stok" id="inputEmail3" placeholder="Masukan Berat">
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label class="col-form-label">Volumetrik <span>Wajib</span> </label>
              </div>
              <div class="input-form">
                <input type="number" class="form-control w-volumetrik d-inline-block" placeholder="P">
                <span class="text-secondary mx-2">x</span>
                <input type="number" class="form-control w-volumetrik d-inline-block" placeholder="L">
                <span class="text-secondary mx-2">x</span>
                <input type="number" class="form-control w-volumetrik d-inline-block" placeholder="T">
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="inputEmail3" class="col-form-label">Layanan Pengiriman</label>
                <span>Atur layanan pengiriman sesuai jenis
                  produkmu</span>
              </div>
              <div class="col-10 input-form">
                <div class="form-row">
                  <div class="form-head my-2">
                    <label class="contain">
                      <input value="1" checked type="radio" name="layanan">
                      <span class="checkmark"></span>
                    </label>
                    <span class="value">Standard</span>
                  </div>
                  <div class="form-head my-2">
                    <label class="contain">
                      <input value="2" type="radio" name="layanan">
                      <span class="checkmark"></span>
                    </label>
                    <span class="value">Ambil di Toko</span>
                  </div>
                  <div class="form-head my-2">
                    <label class="contain">
                      <input value="2" type="radio" name="layanan">
                      <span class="checkmark"></span>
                    </label>
                    <span class="value">Bisa COD oleh Kurir sendiri</span>
                  </div>
                </div>
                <small>Layanan pengiriman untuk produk ini akan disamakan dengan yang ada di Pengaturan
                  Pengiriman.</small>
              </div>
            </div>
            <div class="form-group row">
              <div class="form-desc">
                <label for="inputEmail3" class="col-form-label">Preorder</label>
              </div>
              <div class="input-form">
                <div class="form mb-3">
                  <div class="form-head">
                    <div class="onoffswitch">
                      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch2"
                        checked>
                      <label class="onoffswitch-label" for="myonoffswitch2">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                      </label>
                    </div>
                    <span class="aktif">Aktifkan Preorder ini jika membutuhkan waktu proses lebih lama. <a href="">Info
                        Lengkap</a></span>
                  </div>
                </div>
                <div class="form-group m-0">
                  <input type="text" id="estimasiPreorder" class="form-control w-25" placeholder="estimasi preorder">
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="button-footer">
        <button onclick="location.href='<?php echo CHttpRequest::getUrlReferrer()?>';" id="reset" type="button" class="btn cancel">Batal</button>
        <button onclick="savedata()" type="submit" class="btn add">Simpan & Tambah Baru</button>
        <button onclick="savedatanew()" type="submit" class="btn save">Simpan</button>
      </div>
      </form>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script>
    Vue.component('upload-gambar', {
      template: `
  <div @click="openUpload" class="img-content" >
  	<img ref="preview" :src="showImage" style="width: 157px; height: 157px">
    <input ref="input" @change="previewImage" type="file" id="file-field" accept="image/*" style="display: none"/>
  </div>`,

      data: () => {
        return {
          showImage: '../../images/mp1/img/blank.jpeg'
        }
      },

      methods: {
        openUpload() {
          this.$refs.input.click()
        },

        previewImage() {
          var reader = new FileReader()
          reader.readAsDataURL(this.$refs.input.files[0])

          reader.onload = e => {
            this.showImage = e.target.result
          }
        }
      }
    });

    new Vue({
      el: '#app'
    })
  </script>