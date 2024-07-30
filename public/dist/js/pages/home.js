$(function () {
    var areaChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'Tổng chi',
            backgroundColor: 'rgba(210, 214, 222, 1)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointRadius: false,
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: [65, 59, 80, 81, 56, 55, 40]
        }, {
            label: 'Tổng thu',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [65, 59, 80, 81, 56, 55, 40]
        },

        ]
    }

    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function (value, index, values) {
                        return value.toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        });
                    }
                }
            }]
        },
        tooltips: {
            callbacks: {
                label: function (tooltipItem, data) {
                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    return value.toLocaleString('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    });
                }
            }
        }
    }

    var chart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })

    $(document).ready(function () {
        var type = 'week';
        ajaxChart(type, null, null);
    })

    $(document).on('change', '#filter', function(){
        var type = $(this).val();
        ajaxChart(type, null, null);
    })

    $(document).on('click', '#fillter_date', function(){
        var from = $('input[name="from"]').val();
        var to = $('input[name="to"]').val();
        ajaxChart(null, from, to)
    })

    function ajaxChart(type, from, to) {
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-Token": $('input[name="_token"]').val(),
            },
            url: "/statistic",
            data: {
                type: type,
                from: from,
                to: to
            },
            dataType: "JSON",
            success: function (response) {
                chart.data.datasets[0].data = response.receipt;
                chart.data.datasets[1].data = response.payment;
                chart.data.labels = response.date;

                chart.data.datasets[0].label = 'Tổng thu: ' + response.sum_receipt + 'đ';
                chart.data.datasets[1].label = 'Tổng chi: ' + response.sum_payment + 'đ';

                chart.update();
            }
        });
    }

    $(document).on('focus', '.datepicker_start', function () {
        $(this).datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function (selectedDate) {
                $(this).closest('.col-md-12').find(".datepicker_end").datepicker("option",
                    "minDate", selectedDate);
            }
        });

        $(this).closest('.col-md-12').find('.datepicker_end').datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function (selectedDate) {
                $(this).closest('.col-md-12').find(".datepicker_start").datepicker("option",
                    "maxDate", selectedDate);
            }
        });

        $(this).closest('.col-md-12').find('.datepicker_contract_date').datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function (selectedDate) {
                $(this).closest('.col-md-12').find(".datepicker_contract_date").datepicker("option",
                    "maxDate", selectedDate);
            }
        });
    })
})
