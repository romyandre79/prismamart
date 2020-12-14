$(function () {
    // Input group border
    $(".group-active-bordered input").focus(function () {
        $(this).parent().find('.btn').addClass('active');
    }).focusout(function () {
        $(this).parent().find('.btn').removeClass('active');
    });

    // Rotate Arrow
    $('.menu-collapse .nav-link-title').click(function () {
        $(this).find('.icon-rotate').toggleClass('icon-open');
    });

    // DateRangePicker
    moment.locale('id');
    var start = moment().subtract(1, 'months');
    var startRekap = moment().subtract(6, 'days');
    var startRekapKomplain = moment().subtract(6, 'months');
    var end = moment();

    function transaksi(start, end) {
        $('#pickerTransaksi .dateValueTransaksi').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
        $('#waktuMulaiFilterTransaksi').val(start.format('YYYY-MM-DD'));
        $('#waktuAkhirFilterTransaksi').val(end.format('YYYY-MM-DD'));
    }

    function rekap(start, end) {
        $('#pickerRekap .dateValueRekap').html('<i class="fa fa-calendar-alt icon-calendar text-secondary mr-2"></i> <span>' + start.fromNow() + '</span> ' + start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
        $('#waktuMulaiFilterRekap').val(start.format('YYYY-MM-DD'));
        $('#waktuAkhirFilterRekap').val(end.format('YYYY-MM-DD'));
    }

    function rekapKomplain(start, end) {
        $('#pickerRekapKomplainPenjual .dateValueRekapKomplainPenjual').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
        $('#waktuMulaiFilterRekapKomplainPenjual').val(start.format('YYYY-MM-DD'));
        $('#waktuAkhirFilterRekapKomplainPenjual').val(end.format('YYYY-MM-DD'));
    }

    $('#pickerTransaksi').daterangepicker({
        autoApply: true,
        startDate: start,
        endDate: end,
        locale: 'id'
    }, transaksi);
    transaksi(start, end);

    $('#pickerRekap').not('.disabled').daterangepicker({
        autoApply: true,
        startDate: startRekap,
        endDate: end,
        locale: 'id'
    }, rekap);
    rekap(startRekap, end);

    $('#pickerRekapKomplainPenjual').daterangepicker({
        autoApply: true,
        startDate: startRekap,
        endDate: end,
        locale: 'id'
    }, rekapKomplain);
    rekapKomplain(startRekapKomplain, end);

    // Owl Filter Menu
    $('.owl-filter-menu').owlCarousel({
        items: 5,
        margin: 10,
        autoWidth: true,
        nav: true,
        dots: false,
        navText: [
            "<i class='fas fa-chevron-left'></i>",
            "<i class='fas fa-chevron-right'></i>"
        ],
    });

    $('.owl-filter-menu-topup').owlCarousel({
        items: 4,
        margin: 10,
        autoWidth: true,
        nav: true,
        dots: false,
        navText: [
            "<i class='fas fa-chevron-left'></i>",
            "<i class='fas fa-chevron-right'></i>"
        ],
    });

    $('.owl-alert').owlCarousel({
        items: 1,
        nav: false,
        dots: true
    });
    
    $('.owl-inspirasi').owlCarousel({
        items: 2,
        margin: 25,
        autoWidth: true,
        stagePadding: 100,
        nav: false,
        dots: false,
        loop:true,
    });

    // Input none upload photo
    $('#btnOpenUpload').click(function () {
        $('#settingProfilUpload').trigger('click');
    });

    // Sidebar Toggle
    $('.btn-sidebar-toggle').on('click', function () {
        $('.sidebar-menu-toggle,.content-toggle').toggleClass('active');
    });

    $('.body-sidebar-toggle').hover(function () {
        $('.sidebar-menu-toggle.active,.content-toggle.active').addClass('active-hovered');
    }, function () {
        $('.sidebar-menu-toggle.active,.content-toggle.active').removeClass('active-hovered');
    });

    // Check Responsive Sidebar
    function sideResponsive() {
        var width = $(window).width();
        if (width < 768) {
            $('.sidebar-menu-toggle,.content-toggle').addClass('active');
        }
    }
    $(window).resize(function () {
        sideResponsive();
    });
    sideResponsive();
    
    // Icon Rotate Kurir
    $('.kurir-setsend .icon-menus').click(function (e) {
        e.preventDefault(); 
        $(this).toggleClass('active');
        $(this).parent().parent().find('.menus-kurir-setsend').toggleClass('menus-show');
    });

    $('.menus-kurir-setsend').change(function () {
        let check = 0;
        $(this).find('.list-kurir').each(function(e){
            if($(this).prop("checked") == true){
                check += 1;
            }
        })
        if(check >= 1){
            $(this).parent().find('.kurir-check').attr('checked','checked');
        }else {
            $(this).parent().find('.kurir-check').removeAttr('checked');
        }
    });
});