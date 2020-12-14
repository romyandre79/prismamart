$(function () {
    // Looping hari
    function getDayChart(day) {
        let dataDay = [];
        for (let i = (day - 1); i >= 0; i--) {
            dataDay.push(moment().subtract(i, 'days').format('DD MMM YYYY'));
        }
        return dataDay;
    }

    // --------------------------------------------------
    // ---------------------- DATA ----------------------
    // --------------------------------------------------

    // Data Chart Pendapatan
    let _day = getDayChart(7);
    let _labelPendapatan = 'Pendapatan';
    let _dataPendapatan = [0, 0, 0, 0, 0, 0, 0]; //Diisi dengan data asli nantinya

    // Data Chart Pendapatan Bersih Ongkir
    let _dataLabelPendapatanBersihOngkirSection = ['bebas ongkir', 'non-bebas ongkir'];
    let _labelPendapatanBersihOngkirSection = 'Pendapatan';
    let _dataPendapatanBersihOngkirSection = [1000, 1900]; //Diisi dengan data asli nantinya

    // Data Chart Pesanan Baru Ongkir
    let _dataLabelPesananBaruOngkirSection = ['bebas ongkir', 'non-bebas ongkir'];
    let _labelPesananBaruOngkirSection = 'Pesanan';
    let _dataPesananBaruOngkirSection = [160, 1500]; //Diisi dengan data asli nantinya

    // Data Chart Tren Produk Dilihat
    let _labelTrenProdukDilihatSection = 'Tren Dilihat';
    let _dataTrenProdukDilihatSection = [0, 0, 0, 0, 0, 0, 0]; //Diisi dengan data asli nantinya

    // Data Chart Tren Produk Konversi
    let _labelTrenProdukKonversiSection = 'Tren Konversi';
    let _dataTrenProdukKonversiSection = [0, 0, 0, 0, 0, 0, 0]; //Diisi dengan data asli nantinya

    // Data Chart Tren Pesanan
    let _labelTrenPesananSection = 'Tren Pesanan';
    let _dataTrenPesananSection = [0, 0, 0, 0, 0, 0, 0]; //Diisi dengan data asli nantinya

    // Data Chart Tipe Pembatalan
    let _dataLabelTipePembatalanSection = ['Dibatalkan otomatis', 'Ditolak seller', 'Permintaan pembeli'];
    let _labelTipePembatalanSection = 'Tipe Pembatalan';
    let _dataTipePembatalanSection = [0, 0, 0]; //Diisi dengan data asli nantinya

    // Data Chart Jenis Kelamin Pembeli
    let _dataLabelGenderPembeliSection = ['Tidak disebutkan', 'Laki-laki', 'Perempuan'];
    let _labelGenderPembeliSection = 'Jenis Kelamin';
    let _dataGenderPembeliSection = [3, 2, 2]; //Diisi dengan data asli nantinya

    // Data Chart Tipe Pembeli
    let _dataLabelTipePembeliSection = ['Pembeli Baru', 'Pembeli Reguler'];
    let _labelTipePembeliSection = 'Tipe Pembeli';
    let _dataTipePembeliSection = [3, 2]; //Diisi dengan data asli nantinya

    // Data Chart Usia Pembeli
    let _dataLabelUsiaPembeliSection = ['<17', '18-23', '24-34', '35-44', '>45'];
    let _labelUsiaPembeliSection = 'Usia Pembeli';
    let _dataUsiaPembeliSection = [0, 0, 0, 0, 0]; //Diisi dengan data asli nantinya




    // --------------------------------------------------
    // ---------------------- CHART ---------------------
    // --------------------------------------------------
    function pieChart(element, dataLabel, lebel, data, teksCustom = '') {
        let chart = new Chart(element, {
            type: 'pie',
            data: {
                labels: dataLabel,
                datasets: [{
                    label: lebel,
                    data: data,
                    backgroundColor: [
                        'rgba(0, 140, 140, 1)',
                        'rgba(90, 196, 196, 1)',
                        'rgba(253, 92, 131, 1)'
                    ],
                    borderColor: [
                        'rgba(4, 125, 125, 1)',
                        'rgba(76, 175, 175, 1)',
                        'rgba(236, 81, 118, 1)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            stepSize: 1,
                            stepValue: 10,
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItems, data) {
                            var label = data.labels[tooltipItems.index];
                            var val = data.datasets[tooltipItems.datasetIndex].data[tooltipItems.index];
                            return label + ': ' + teksCustom + val;
                        }
                    }
                }
            }
        });
        return chart;
    }

    function lineChart(element, dataLabel, lebel, data) {
        let chart = new Chart(element, {
            type: 'line',
            data: {
                labels: dataLabel,
                datasets: [{
                    label: lebel,
                    data: data,
                    fill: false,
                    backgroundColor: [
                        'rgba(0, 140, 140, 1)'
                    ],
                    borderColor: [
                        'rgba(4, 125, 125, 1)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            stepSize: 1,
                            stepValue: 10,
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });
        return chart;
    }
    // Chart Pendapatan
    let jumlahPendapatanChart = document.getElementById('jumlahPendapatanChart').getContext('2d');
    let myChartJumlahPendapatanChart = lineChart(jumlahPendapatanChart, _day, _labelPendapatan, _dataPendapatan);

    // Chart Pendapatan Bersih Ongkir
    let ongkirPendapatanBersihChart = document.getElementById('ongkirPendapatanBersihChart').getContext('2d');
    let myChartOngkirPendapatanBersihChart = pieChart(ongkirPendapatanBersihChart, _dataLabelPendapatanBersihOngkirSection, _labelPendapatanBersihOngkirSection, _dataPendapatanBersihOngkirSection, 'Rp');

    // Chart Pesanan Baru Ongkir
    let ongkirPesananBaruChart = document.getElementById('ongkirPesananBaruChart').getContext('2d');
    let myChartOngkirPesananBaruChart = pieChart(ongkirPesananBaruChart, _dataLabelPesananBaruOngkirSection, _labelPesananBaruOngkirSection, _dataPesananBaruOngkirSection, 'Rp');

    // Chart Konversi Trend Dilihat
    let trenDilihatChart = document.getElementById('trenDilihatChart').getContext('2d');
    let myChartTrenDilihatChart = lineChart(trenDilihatChart, _day, _labelTrenProdukDilihatSection, _dataTrenProdukDilihatSection);

    // Chart Trend Konversi
    let trenKonversiChart = document.getElementById('trenKonversiChart').getContext('2d');
    let myChartTrenKonversiChart = lineChart(trenKonversiChart, _day, _labelTrenProdukKonversiSection, _dataTrenProdukKonversiSection);

    // Chart Trend Pesanan
    let trenPesananChart = document.getElementById('trenPesananChart').getContext('2d');
    let myCharttrenPesananChart = lineChart(trenPesananChart, _day, _labelTrenPesananSection, _dataTrenPesananSection);

    // Chart Tipe Pembatalan
    let tipePembatalanChart = document.getElementById('tipePembatalanChart').getContext('2d');
    let myCharttipePembatalanChart = lineChart(tipePembatalanChart, _dataLabelTipePembatalanSection, _labelTipePembatalanSection, _dataTipePembatalanSection);

    // Chart Jenis Kelamin Pembeli
    let jenisKelaminPembeliChart = document.getElementById('jenisKelaminPembeliChart').getContext('2d');
    let myChartjenisKelaminPembeliChart = pieChart(jenisKelaminPembeliChart, _dataLabelGenderPembeliSection, _labelGenderPembeliSection, _dataGenderPembeliSection);

    // Chart Tipe Pembeli
    let tipePembeliChart = document.getElementById('tipePembeliChart').getContext('2d');
    let myCharttipePembeliChart = pieChart(tipePembeliChart, _dataLabelTipePembeliSection, _labelTipePembeliSection, _dataTipePembeliSection);

    // Chart Usia Pembeli
    let usiaPembeliChart = document.getElementById('usiaPembeliChart').getContext('2d');
    let myChartusiaPembeliChart = lineChart(usiaPembeliChart, _dataLabelUsiaPembeliSection, _labelUsiaPembeliSection, _dataUsiaPembeliSection);
});