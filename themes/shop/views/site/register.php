<script type="text/javascript">
function daftaruser() {
  jQuery.ajax({'url': '<?php echo Yii::app()->createUrl('site/register') ?>',
    'data': {
      'regname': $("input[name='regname']").val(),
      'regpass': $("input[name='regpass']").val(),
      'regemail': $("input[name='regemail']").val(),
      'regphoneno': $("input[name='regphoneno']").val(),
      'regrealname': $("input[name='regrealname']").val(),
    },
    'type': 'post', 'dataType': 'json',
    'success': function (data) {
      if (data.status == "success") {
        location.href = "<?php echo Yii::app()->createUrl('site/index') ?>";
      } else {
        toastr.error(data.msg);
      }
    },
    'cache': false});
}
</script>

<section class="register start">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-md-6">
      </div>
      <div class="col-12 col-md-6">
        <div class="modal-login">
          <div style="display: block">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="text-center">
                    <h5 class="m-signin">Daftar Sekarang</h5>
                  </div>
                  <form method="post" action="<?php echo Yii::app()->createUrl('site/register')?>" role="form">
                  <div class="form-group">
                    <label for="regname">User Name</label>
                    <input
                      type="text"
                      class="form-control"
                      id="regname"
                      name="regname"
                    />
                  </div>
                  <div class="form-group">
                    <label for="regrealname">Nama Lengkap</label>
                    <input
                      type="text"
                      class="form-control"
                      id="regrealname"
                      name="regrealname"
                    />
                  </div>
                  <div class="form-group">
                    <label for="regemail">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      id="regemail"
                      name="regemail"
                    />
                  </div>
                  <div class="form-group">
                    <label for="regphoneno">No HP</label>
                    <input
                      type="text"
                      class="form-control"
                      id="regphoneno"
                      name="regphoneno"
                    />
                  </div>
                  <div class="form-group">
                    <label for="regpass">Password</label>
                    <input
                      type="password"
                      class="form-control"
                      id="regpass"
                      name="regpass"
                    />
                  </div>
                  <button href="#" type="button" class="btn btn-block" onclick="daftaruser()">Daftar</button>
</form>
                  <h5 class="already">
                    Sudah punya akun <a href="#" data-toggle="modal" data-target="#loginModal">Prisma Mart</a>?
                  </h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="modal-register">
  <div
    class="modal fade"
    id="myModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            emailsaya@gmail.com
          </h5>
        </div>
        <div class="modal-body">
          <span>Apakah email yang Anda masukkan sudah benar?</span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn change">Ubah</button>
          <button type="button" class="btn yes">Ya, Benar</button>
        </div>
      </div>
    </div>
  </div>
</section>