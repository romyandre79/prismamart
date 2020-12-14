$(document).ready(function () {

  $('.owl-carousel').owlCarousel({
    items: 8,
    loop: true,
    margin: 10,
    merge: true,
    nav: true,
    navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
    responsive: {
      678: {
        mergeFit: true
      },
      1000: {
        mergeFit: false
      }
    }
  });

  $('input[type="checkbox"]').click(function () {
    if ($(this).is(":checked")) {
      $("#btn-checkout").addClass('active');
      $("#count-end").addClass('show');
    } else if ($(this).is(":not(:checked)")) {
      $('#btn-checkout').removeClass('active');
      $('#count-end').removeClass('show');

    }
  });

  $('#etalase').change(function () {
    let selectedCountry = $.trim($(this).children("option:selected").val()).toLowerCase();
    if (selectedCountry == 'tambah etalase') {
      $('#exampleModal').modal('show');
    }
  });

  $('#checkDisabledMinimun').click(function () {
    if ($('#MinimunPemesananInput').attr('disabled')) {
      $('#MinimunPemesananInput').removeAttr('disabled');
    } else {
      $('#MinimunPemesananInput').attr('disabled', 'disabled');
    }
  });
  $('#myonoffswitch2').click(function () {
    if ($(this).is(":checked")) {
      $('#estimasiPreorder').removeAttr('disabled');
    } else {
      $('#estimasiPreorder').attr('disabled', 'disabled');
    }
  });
});