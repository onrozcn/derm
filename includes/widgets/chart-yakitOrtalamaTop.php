<script type="text/javascript">



    YakitOrtalamaHighChart('YakitOrtalamaHighChart');

    function YakitOrtalamaHighChart(selector) {
        var url = siteUrl + 'actions/widgets.php?Action=YakitOrtalamaHighChart&&top=';
        Highcharts.getJSON(url, function (data) {

            let cat = [];
            vals = data.map(val => {
                return val.plaka;
            });
            //console.log(vals);

            vals.forEach(v=>{
                if (cat.indexOf(v) === -1) cat.push(v);
            });
            //console.log(cat);

            const group_data = (array, key) => {
                return array.reduce((a, c) => {
                    (a[c[key]] = a[c[key]] || []).push(c);
                    return a;
                }, {});
            }

            const get_grouped = group_data(data, 'period');
            //console.log(get_grouped);

            for (a in get_grouped) {
                cat.forEach(t => {
                    if (!get_grouped[a].some(v => v.plaka == t)) {
                        get_grouped[a].push({
                            "period": get_grouped[a][0].date,
                            "litretoplam": 4,// changed here //
                            "plaka": t

                            // "date": get_grouped[a][0].date,
                            // "metric": 20,// changed here //
                            // "type": t
                        });
                    }
                })
            }

            //console.log(get_grouped);
            let series = Object.entries(get_grouped).map(([key, group]) => ({
                ['name']: key,
                ['data']: group.map(entry => entry['calcavg']),
                ['marker']: {
                    symbol: 'circle'
                }
            }));
            //console.log(series);


            Highcharts.chart(selector, {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: cat
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Litre (ortalama aylik)',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' litre'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: series,
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



