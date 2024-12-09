<script type="text/javascript">

    $('#YakitTuketimHighChartPeriodInput').on('change', function() {
        YakitTuketimHighChart('YakitTuketimHighChart', this.value);
    });

    YakitTuketimHighChart('YakitTuketimHighChart', moment(new Date()).format("YYYY-MM"));

    function YakitTuketimHighChart(selector, period=moment(new Date()).format("YYYY-MM"), top=10) {
        var url = siteUrl + 'actions/widgets.php?Action=YakitTuketimTop&period=' + period + '&top=' + top;
        Highcharts.getJSON(url, function (data) {
            // Radialize the colors
            // Highcharts.setOptions({
            //     colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
            //         return {
            //             radialGradient: {
            //                 cx: 0.5,
            //                 cy: 0.3,
            //                 r: 0.7
            //             },
            //             stops: [
            //                 [0, color],
            //                 [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
            //             ]
            //         };
            //     })
            // });
            // Build the chart
            Highcharts.chart(selector, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: 'Oran: %{point.percentage:.1f}<br>Litre: <b>{point.y}</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                           enabled: true,
                           format: '<b>{point.name}</b><br>Oran: %{point.percentage:.1f}<br>Litre: {point.y}',
                           connectorColor: 'silver'
                       }
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: data
                }],
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                }
            });
        });
    }
</script>



