<script type="text/javascript">

    <? $param_dep_tanklar = GetListDataFromTableWithSingleWhere('param_dep_tanklar', '*', 'sort_order', 'active=1 AND tank_hesapla=1 AND sirket_id=' . $CurrentFirm['id']);

    foreach ($param_dep_tanklar as $tank) { ?>
    RefreshDepoHighChart('DepoHighChart<?=$tank['id']?>', <?=$tank['id']?>);
    <? } ?>



    // RefreshDepoHighChart();
    function DepoHighChart(selector, tank_id, tank_tag, capacity, value) {
        Highcharts.chart(selector, {
            chart: {
                type: 'gauge',
                height: 425,
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: ''
            },

            pane: {
                startAngle: -150,
                endAngle: 150,
                background: [{
                    backgroundColor: {
                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, '#FFF'],
                            [1, '#333']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: {
                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, '#333'],
                            [1, '#FFF']
                        ]
                    },
                    borderWidth: 1,
                    outerRadius: '107%'
                }, {
                    // default background
                }, {
                    backgroundColor: '#DDD',
                    borderWidth: 0,
                    outerRadius: '105%',
                    innerRadius: '103%'
                }]
            },

            // the value axis
            yAxis: {
                min: 0,
                max: capacity,

                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#666',

                tickPixelInterval: 30,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 10,
                tickColor: '#666',
                labels: {
                    step: 2,
                    rotation: 'auto'
                },
                title: {
                    text: tank_tag
                },
                plotBands: [{
                    from: 0,
                    to: capacity / 8,
                    color: '#DF5353' // red
                }, {
                    from: capacity / 8,
                    to: capacity / 1.6,
                    color: '#DDDF0D' // yellow
                }, {
                    from: capacity / 1.6,
                    to: capacity,
                    color: '#55BF3B' // green
                }]
            },

            series: [{
                name: tank_tag,
                data: [value],
                tooltip: {
                    valueSuffix: ' Litre'
                }
            }],

            exporting: {
                enabled: false
            },

            credits: {
                enabled: false
            }

        });
    }
    function RefreshDepoHighChart(selector, tank_id) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: siteUrl + 'actions/widgets.php?Action=YakitDepo&tank_id=' + tank_id,
            success: function (response) {
                if (response.kapasite !== '' && response.kalan !== '') {
                    DepoHighChart(selector, tank_id, response.tank_tag, response.kapasite, response.kalan);
                }
                else {
                    toastr.error('', 'Hata');
                }
            },
            error: function () {
                alert('An error occurred, please try again later.')
            }
        });
    }
</script>



