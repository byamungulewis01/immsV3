@extends('layouts.admin.app')
@section('page-name')
    Branch Orders
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">PERCEL INBOXING</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">PERCEL INBOXING</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-6 row-cols-md-3 row-cols-1 g-0">
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-uppercase fs-13 mb-0">Total number<i
                                        class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <span class="text-muted">Package Posted</span>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-pulse-line display-6 text-muted"></i>

                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="190">190</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-uppercase fs-13 mb-0">Current Month<i
                                        class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <span class="text-muted">in {{ now()->format('F') }}</span>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-pulse-line display-6 text-muted"></i>

                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="75">75</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-uppercase fs-13 mb-0">Previous Month <i
                                        class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <span class="text-muted">Previos Month in {{ now()->year }}</span>

                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-pulse-line display-6 text-muted"></i>

                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="200">200</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-uppercase fs-13 mb-0">Origin of Items<i
                                        class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                                <span class="text-muted">by Districts</span>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-pulse-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="32">32</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                <h5 class="text-uppercase fs-13 mb-0">Diverse destinations <i
                                        class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                <span class="text-muted">Destination Countries</span>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-pulse-line display-6 text-muted"></i>

                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="45">45</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                <h5 class="text-uppercase fs-13 mb-0">Total Weight<i
                                        class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                                <span class="text-muted">Items Sent/kgs</span>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-pulse-line display-6 text-muted"></i>

                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value" data-target="2659.43">2,659.43</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>

    <div class="row">

        <div class="col-xl-5">
            <div class="card card-height-100">
                <div class="card-header">
                    <h4 class="card-title mb-0">Transactions by Districts</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="column_rotated_labels" data-colors='["--vz-info"]' class="apex-charts" dir="ltr"></div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Countries Across the world</h4>
                </div>
                <div class="card-body p-0">
                    <div>
                        <div id="countries_charts"
                            data-colors='["--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-danger", "--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-info"]'
                            class="apex-charts" dir="ltr"></div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div> <!-- end col-->
        <div class="col-xl-3">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Total Weight sent </h4>
                </div>
                <div class="card-body p-0">
                    <div class="card-body pb-0">
                        <div id="sales-forecast-chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]'
                            class="apex-charts" dir="ltr"></div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div> <!-- end col-->
    </div>
@endsection

@section('css')
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- barcharts init -->
    <script>
        function getChartColorsArray(t) {
            if (null !== document.getElementById(t))
                return (
                    (t = document.getElementById(t).getAttribute("data-colors")),
                    (t = JSON.parse(t)).map(function(t) {
                        var e = t.replace(" ", "");
                        return -1 === e.indexOf(",") ?
                            getComputedStyle(
                                document.documentElement
                            ).getPropertyValue(e) || e :
                            2 == (t = t.split(",")).length ?
                            "rgba(" +
                            getComputedStyle(
                                document.documentElement
                            ).getPropertyValue(t[0]) +
                            "," +
                            t[1] +
                            ")" :
                            e;
                    })
                );
        }
    </script>
    <script>
        var chartColumnColors = getChartColorsArray("column_chart"),
            chartColumnDatatalabelColors = (chartColumnColors && (options = {
                    chart: {
                        height: 350,
                        type: "bar",
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: !1,
                            columnWidth: "45%",
                            endingShape: "rounded"
                        }
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        show: !0,
                        width: 2,
                        colors: ["transparent"]
                    },
                    series: [{
                        name: "Net Profit",
                        data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
                    }, {
                        name: "Revenue",
                        data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
                    }, {
                        name: "Free Cash Flow",
                        data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
                    }],
                    colors: chartColumnColors,
                    xaxis: {
                        categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"]
                    },
                    yaxis: {
                        title: {
                            text: "$ (thousands)"
                        }
                    },
                    grid: {
                        borderColor: "#f1f1f1"
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(e) {
                                return "$ " + e + " thousands"
                            }
                        }
                    }
                }, (chart = new ApexCharts(document.querySelector("#column_chart"), options)).render()),
                getChartColorsArray("column_chart_datalabel")),
            chartColumnStackedColors = (chartColumnDatatalabelColors && (options = {
                    chart: {
                        height: 350,
                        type: "bar",
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                position: "top"
                            }
                        }
                    },
                    dataLabels: {
                        enabled: !0,
                        formatter: function(e) {
                            return e + "%"
                        },
                        offsetY: -20,
                        style: {
                            fontSize: "12px",
                            colors: ["#adb5bd"]
                        }
                    },
                    series: [{
                        name: "Inflation",
                        data: [2.5, 3.2, 5, 10.1, 4.2, 3.8, 3, 2.4, 4, 1.2, 3.5, .8]
                    }],
                    colors: chartColumnDatatalabelColors,
                    grid: {
                        borderColor: "#f1f1f1"
                    },
                    xaxis: {
                        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov",
                            "Dec"],
                        position: "top",
                        labels: {
                            offsetY: -18
                        },
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        crosshairs: {
                            fill: {
                                type: "gradient",
                                gradient: {
                                    colorFrom: "#D8E3F0",
                                    colorTo: "#BED1E6",
                                    stops: [0, 100],
                                    opacityFrom: .4,
                                    opacityTo: .5
                                }
                            }
                        },
                        tooltip: {
                            enabled: !0,
                            offsetY: -35
                        }
                    },
                    fill: {
                        gradient: {
                            shade: "light",
                            type: "horizontal",
                            shadeIntensity: .25,
                            gradientToColors: void 0,
                            inverseColors: !0,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [50, 0, 100, 100]
                        }
                    },
                    yaxis: {
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            show: !1,
                            formatter: function(e) {
                                return e + "%"
                            }
                        }
                    },
                    title: {
                        text: "Monthly Inflation in Argentina, 2002",
                        floating: !0,
                        offsetY: 320,
                        align: "center",
                        style: {
                            fontWeight: 500
                        }
                    }
                }, (chart = new ApexCharts(document.querySelector("#column_chart_datalabel"), options)).render()),
                getChartColorsArray("column_stacked")),
            chartColumnStacked100Colors = (chartColumnStackedColors && (options = {
                    series: [{
                        name: "PRODUCT A",
                        data: [44, 55, 41, 67, 22, 43]
                    }, {
                        name: "PRODUCT B",
                        data: [13, 23, 20, 8, 13, 27]
                    }, {
                        name: "PRODUCT C",
                        data: [11, 17, 15, 15, 21, 14]
                    }, {
                        name: "PRODUCT D",
                        data: [21, 7, 25, 13, 22, 8]
                    }],
                    chart: {
                        type: "bar",
                        height: 350,
                        stacked: !0,
                        toolbar: {
                            show: !1
                        },
                        zoom: {
                            enabled: !0
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: "bottom",
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: !1,
                            borderRadius: 10
                        }
                    },
                    xaxis: {
                        type: "datetime",
                        categories: ["01/01/2011 GMT", "01/02/2011 GMT", "01/03/2011 GMT", "01/04/2011 GMT",
                            "01/05/2011 GMT", "01/06/2011 GMT"
                        ]
                    },
                    legend: {
                        position: "right",
                        offsetY: 40
                    },
                    fill: {
                        opacity: 1
                    },
                    colors: chartColumnStackedColors
                }, (chart = new ApexCharts(document.querySelector("#column_stacked"), options)).render()),
                getChartColorsArray("column_stacked_chart")),
            groupedStackedColors = (chartColumnStacked100Colors && (options = {
                    series: [{
                        name: "PRODUCT A",
                        data: [44, 55, 41, 67, 22, 43, 21, 49]
                    }, {
                        name: "PRODUCT B",
                        data: [13, 23, 20, 8, 13, 27, 33, 12]
                    }, {
                        name: "PRODUCT C",
                        data: [11, 17, 15, 15, 21, 14, 15, 13]
                    }],
                    chart: {
                        type: "bar",
                        height: 350,
                        stacked: !0,
                        stackType: "100%",
                        toolbar: {
                            show: !1
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: "bottom",
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    xaxis: {
                        categories: ["2011 Q1", "2011 Q2", "2011 Q3", "2011 Q4", "2012 Q1", "2012 Q2", "2012 Q3",
                            "2012 Q4"
                        ]
                    },
                    fill: {
                        opacity: 1
                    },
                    legend: {
                        position: "right",
                        offsetX: 0,
                        offsetY: 50
                    },
                    colors: chartColumnStacked100Colors
                }, (chart = new ApexCharts(document.querySelector("#column_stacked_chart"), options)).render()),
                getChartColorsArray("grouped_stacked_columns")),
            dumbbellChartColors = (groupedStackedColors && (options = {
                    series: [{
                        name: "Q1 Budget",
                        group: "budget",
                        data: [44e3, 55e3, 41e3, 67e3, 22e3, 43e3]
                    }, {
                        name: "Q1 Actual",
                        group: "actual",
                        data: [48e3, 5e4, 4e4, 65e3, 25e3, 4e4]
                    }, {
                        name: "Q2 Budget",
                        group: "budget",
                        data: [13e3, 36e3, 2e4, 8e3, 13e3, 27e3]
                    }, {
                        name: "Q2 Actual",
                        group: "actual",
                        data: [2e4, 4e4, 25e3, 1e4, 12e3, 28e3]
                    }],
                    chart: {
                        type: "bar",
                        height: 350,
                        stacked: !0
                    },
                    stroke: {
                        width: 1,
                        colors: ["#fff"]
                    },
                    dataLabels: {
                        formatter: e => e / 1e3 + "K"
                    },
                    plotOptions: {
                        bar: {
                            horizontal: !1
                        }
                    },
                    xaxis: {
                        categories: ["Online advertising", "Sales Training", "Print advertising", "Catalogs",
                            "Meetings", "Public relations"
                        ]
                    },
                    fill: {
                        opacity: 1
                    },
                    colors: groupedStackedColors,
                    yaxis: {
                        labels: {
                            formatter: e => e / 1e3 + "K"
                        }
                    },
                    legend: {
                        position: "top",
                        horizontalAlign: "left"
                    }
                }, (chart = new ApexCharts(document.querySelector("#grouped_stacked_columns"), options)).render()),
                getChartColorsArray("dumbbell_chart")),
            chartColumnMarkersColors = (dumbbellChartColors && (options = {
                    series: [{
                        data: [{
                            x: "2008",
                            y: [2800, 4500]
                        }, {
                            x: "2009",
                            y: [3200, 4100]
                        }, {
                            x: "2010",
                            y: [2950, 7800]
                        }, {
                            x: "2011",
                            y: [3e3, 4600]
                        }, {
                            x: "2012",
                            y: [3500, 4100]
                        }, {
                            x: "2013",
                            y: [4500, 6500]
                        }, {
                            x: "2014",
                            y: [4100, 5600]
                        }]
                    }],
                    chart: {
                        height: 350,
                        type: "rangeBar",
                        zoom: {
                            enabled: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            isDumbbell: !0,
                            columnWidth: 3,
                            dumbbellColors: dumbbellChartColors
                        }
                    },
                    legend: {
                        show: !0,
                        showForSingleSeries: !0,
                        position: "top",
                        horizontalAlign: "left",
                        customLegendItems: ["Product A", "Product B"]
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            type: "vertical",
                            gradientToColors: ["#00E396"],
                            inverseColors: !0,
                            stops: [0, 100]
                        }
                    },
                    grid: {
                        xaxis: {
                            lines: {
                                show: !0
                            }
                        },
                        yaxis: {
                            lines: {
                                show: !1
                            }
                        }
                    },
                    xaxis: {
                        tickPlacement: "on"
                    }
                }, (chart = new ApexCharts(document.querySelector("#dumbbell_chart"), options)).render()),
                getChartColorsArray("column_markers")),
            chartColumnRotateLabelsColors = (chartColumnMarkersColors && (options = {
                    series: [{
                        name: "Actual",
                        data: [{
                            x: "2011",
                            y: 1292,
                            goals: [{
                                name: "Expected",
                                value: 1400,
                                strokeWidth: 5,
                                strokeColor: "#775DD0"
                            }]
                        }, {
                            x: "2012",
                            y: 4432,
                            goals: [{
                                name: "Expected",
                                value: 5400,
                                strokeWidth: 5,
                                strokeColor: "#775DD0"
                            }]
                        }, {
                            x: "2013",
                            y: 5423,
                            goals: [{
                                name: "Expected",
                                value: 5200,
                                strokeWidth: 5,
                                strokeColor: "#775DD0"
                            }]
                        }, {
                            x: "2014",
                            y: 6653,
                            goals: [{
                                name: "Expected",
                                value: 6500,
                                strokeWidth: 5,
                                strokeColor: "#775DD0"
                            }]
                        }, {
                            x: "2015",
                            y: 8133,
                            goals: [{
                                name: "Expected",
                                value: 6600,
                                strokeWidth: 5,
                                strokeColor: "#775DD0"
                            }]
                        }, {
                            x: "2016",
                            y: 7132,
                            goals: [{
                                name: "Expected",
                                value: 7500,
                                strokeWidth: 5,
                                strokeColor: "#775DD0"
                            }]
                        }, {
                            x: "2017",
                            y: 7332,
                            goals: [{
                                name: "Expected",
                                value: 8700,
                                strokeWidth: 5,
                                strokeColor: "#775DD0"
                            }]
                        }, {
                            x: "2018",
                            y: 6553,
                            goals: [{
                                name: "Expected",
                                value: 7300,
                                strokeWidth: 5,
                                strokeColor: "#775DD0"
                            }]
                        }]
                    }],
                    chart: {
                        height: 350,
                        type: "bar",
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: "30%"
                        }
                    },
                    colors: chartColumnMarkersColors,
                    dataLabels: {
                        enabled: !1
                    },
                    legend: {
                        show: !0,
                        showForSingleSeries: !0,
                        customLegendItems: ["Actual", "Expected"],
                        markers: {
                            fillColors: chartColumnMarkersColors
                        }
                    }
                }, (chart = new ApexCharts(document.querySelector("#column_markers"), options)).render()),
                getChartColorsArray("column_rotated_labels")),
            chartNagetiveValuesColors = (chartColumnRotateLabelsColors && (options = {
                    series: [{
                        name: "Servings",
                        data: [44, 55, 41, 67, 22, 43, 21, 33, 45, 31]
                    }],
                    chart: {
                        height: 350,
                        type: "bar",
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 10,
                            columnWidth: "50%"
                        }
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        width: 2
                    },
                    colors: chartColumnRotateLabelsColors,
                    xaxis: {
                        labels: {
                            rotate: -45
                        },
                        categories: ["Bugesera", "Gakenke", "Gasabo", "Gicumbi", "Gisagara", "Huye",
                            "Kayonza", "Kicukiro", "Muhanga", "Ngororero"
                        ],
                        tickPlacement: "on"
                    },
                    yaxis: {
                        title: {
                            text: "Items Sent"
                        }
                    },

                }, (chart = new ApexCharts(document.querySelector("#column_rotated_labels"), options)).render()),
                getChartColorsArray("column_nagetive_values")),
            chartRangeColors = (chartNagetiveValuesColors && (options = {
                    series: [{
                        name: "Cash Flow",
                        data: [1.45, 5.42, 5.9, -.42, -12.6, -18.1, -18.2, -14.16, -11.1, -6.09, .34, 3.88,
                            13.07, 5.8, 2, 7.37, 8.1, 13.57, 15.75, 17.1, 19.8, -27.03, -54.4, -47.2, -43.3,
                            -18.6, -48.6, -41.1, -39.6, -37.6, -29.4, -21.4, -2.4
                        ]
                    }],
                    chart: {
                        type: "bar",
                        height: 350,
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            colors: {
                                ranges: [{
                                    from: -100,
                                    to: -46,
                                    color: chartNagetiveValuesColors[1]
                                }, {
                                    from: -45,
                                    to: 0,
                                    color: chartNagetiveValuesColors[2]
                                }]
                            },
                            columnWidth: "80%"
                        }
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    colors: chartNagetiveValuesColors[0],
                    yaxis: {
                        title: {
                            text: "Growth"
                        },
                        labels: {
                            formatter: function(e) {
                                return e.toFixed(0) + "%"
                            }
                        }
                    },
                    xaxis: {
                        type: "datetime",
                        categories: ["2011-01-01", "2011-02-01", "2011-03-01", "2011-04-01", "2011-05-01", "2011-06-01",
                            "2011-07-01", "2011-08-01", "2011-09-01", "2011-10-01", "2011-11-01", "2011-12-01",
                            "2012-01-01", "2012-02-01", "2012-03-01", "2012-04-01", "2012-05-01", "2012-06-01",
                            "2012-07-01", "2012-08-01", "2012-09-01", "2012-10-01", "2012-11-01", "2012-12-01",
                            "2013-01-01", "2013-02-01", "2013-03-01", "2013-04-01", "2013-05-01", "2013-06-01",
                            "2013-07-01", "2013-08-01", "2013-09-01"
                        ],
                        labels: {
                            rotate: -90
                        }
                    }
                }, (chart = new ApexCharts(document.querySelector("#column_nagetive_values"), options)).render()),
                getChartColorsArray("column_range")),
            colors = (chartRangeColors && (options = {
                series: [{
                    data: [{
                        x: "Team A",
                        y: [1, 5]
                    }, {
                        x: "Team B",
                        y: [4, 6]
                    }, {
                        x: "Team C",
                        y: [5, 8]
                    }, {
                        x: "Team D",
                        y: [3, 11]
                    }]
                }, {
                    data: [{
                        x: "Team A",
                        y: [2, 6]
                    }, {
                        x: "Team B",
                        y: [1, 3]
                    }, {
                        x: "Team C",
                        y: [7, 8]
                    }, {
                        x: "Team D",
                        y: [5, 9]
                    }]
                }],
                chart: {
                    type: "rangeBar",
                    height: 335,
                    toolbar: {
                        show: !1
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1
                    }
                },
                dataLabels: {
                    enabled: !0
                },
                legend: {
                    show: !1
                },
                colors: chartRangeColors
            }, (chart = new ApexCharts(document.querySelector("#column_range"), options)).render()), Apex = {
                chart: {
                    toolbar: {
                        show: !1
                    }
                },
                tooltip: {
                    shared: !1
                },
                legend: {
                    show: !1
                }
            }, getChartColorsArray("chart-year"));

        function shuffleArray(e) {
            for (var t = e.length - 1; 0 < t; t--) {
                var o = Math.floor(Math.random() * (t + 1)),
                    a = e[t];
                e[t] = e[o], e[o] = a
            }
            return e
        }
        var arrayData = [{
            y: 400,
            quarters: [{
                x: "Q1",
                y: 120
            }, {
                x: "Q2",
                y: 90
            }, {
                x: "Q3",
                y: 100
            }, {
                x: "Q4",
                y: 90
            }]
        }, {
            y: 430,
            quarters: [{
                x: "Q1",
                y: 120
            }, {
                x: "Q2",
                y: 110
            }, {
                x: "Q3",
                y: 90
            }, {
                x: "Q4",
                y: 110
            }]
        }, {
            y: 448,
            quarters: [{
                x: "Q1",
                y: 70
            }, {
                x: "Q2",
                y: 100
            }, {
                x: "Q3",
                y: 140
            }, {
                x: "Q4",
                y: 138
            }]
        }, {
            y: 470,
            quarters: [{
                x: "Q1",
                y: 150
            }, {
                x: "Q2",
                y: 60
            }, {
                x: "Q3",
                y: 190
            }, {
                x: "Q4",
                y: 70
            }]
        }, {
            y: 540,
            quarters: [{
                x: "Q1",
                y: 120
            }, {
                x: "Q2",
                y: 120
            }, {
                x: "Q3",
                y: 130
            }, {
                x: "Q4",
                y: 170
            }]
        }, {
            y: 580,
            quarters: [{
                x: "Q1",
                y: 170
            }, {
                x: "Q2",
                y: 130
            }, {
                x: "Q3",
                y: 120
            }, {
                x: "Q4",
                y: 160
            }]
        }];
        var chart, optionsGroup, chartGroup, options = {
                series: [{
                    data: makeData()
                }],
                chart: {
                    id: "barYear",
                    height: 330,
                    width: "100%",
                    type: "bar",
                    events: {
                        dataPointSelection: function(e, t, o) {
                            var a = document.querySelector("#chart-quarter"),
                                r = document.querySelector("#chart-year");
                            1 !== o.selectedDataPoints[0].length || a.classList.contains("active") || (r.classList.add(
                                "chart-quarter-activated"), a.classList.add("active")), updateQuarterChart(t,
                                "barQuarter"), 0 === o.selectedDataPoints[0].length && (r.classList.remove(
                                "chart-quarter-activated"), a.classList.remove("active"))
                        },
                        updated: function(e) {
                            updateQuarterChart(e, "barQuarter")
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        distributed: !0,
                        horizontal: !0,
                        barHeight: "75%",
                        dataLabels: {
                            position: "bottom"
                        }
                    }
                },
                dataLabels: {
                    enabled: !0,
                    textAnchor: "start",
                    style: {
                        colors: ["#fff"]
                    },
                    formatter: function(e, t) {
                        return t.w.globals.labels[t.dataPointIndex]
                    },
                    offsetX: 0,
                    dropShadow: {
                        enabled: !1
                    }
                },
                colors: colors,
                states: {
                    normal: {
                        filter: {
                            type: "desaturate"
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: !0,
                        filter: {
                            type: "darken",
                            value: 1
                        }
                    }
                },
                tooltip: {
                    x: {
                        show: !1
                    },
                    y: {
                        title: {
                            formatter: function(e, t) {
                                return t.w.globals.labels[t.dataPointIndex]
                            }
                        }
                    }
                },
                title: {
                    text: "Yearly Results",
                    offsetX: 15,
                    style: {
                        fontWeight: 500
                    }
                },
                subtitle: {
                    text: "(Click on bar to see details)",
                    offsetX: 15
                },
                yaxis: {
                    labels: {
                        show: !1
                    }
                }
            },
            optionsQuarter = ((chart = new ApexCharts(document.querySelector("#chart-year"), options)).render(), {
                series: [{
                    data: []
                }],
                chart: {
                    id: "barQuarter",
                    height: 330,
                    width: "100%",
                    type: "bar",
                    stacked: !0
                },
                plotOptions: {
                    bar: {
                        columnWidth: "50%",
                        horizontal: !1
                    }
                },
                legend: {
                    show: !1
                },
                grid: {
                    yaxis: {
                        lines: {
                            show: !1
                        }
                    },
                    xaxis: {
                        lines: {
                            show: !0
                        }
                    }
                },
                yaxis: {
                    labels: {
                        show: !1
                    }
                },
                title: {
                    text: "Quarterly Results",
                    offsetX: 10,
                    style: {
                        fontWeight: 500
                    }
                },
                tooltip: {
                    x: {
                        formatter: function(e, t) {
                            return t.w.globals.seriesNames[t.seriesIndex]
                        }
                    },
                    y: {
                        title: {
                            formatter: function(e, t) {
                                return t.w.globals.labels[t.dataPointIndex]
                            }
                        }
                    }
                }
            }),
            chartQuarter = new ApexCharts(document.querySelector("#chart-quarter"), optionsQuarter),
            chartColumnDistributedColors = (chartQuarter.render(), chart.addEventListener("dataPointSelection", function(e,
                t, o) {
                var a = document.querySelector("#chart-quarter"),
                    r = document.querySelector("#chart-year");
                1 !== o.selectedDataPoints[0].length || a.classList.contains("active") || (r.classList.add(
                        "chart-quarter-activated"), a.classList.add("active")), updateQuarterChart(t, "barQuarter"),
                    0 === o.selectedDataPoints[0].length && (r.classList.remove("chart-quarter-activated"), a
                        .classList.remove("active"))
            }), chart.addEventListener("updated", function(e) {
                updateQuarterChart(e, "barQuarter")
            }), getChartColorsArray("column_distributed")),
            chartColumnGroupLabelsColors = (chartColumnDistributedColors && (options = {
                    series: [{
                        data: [21, 22, 10, 28, 16, 21, 13, 30]
                    }],
                    chart: {
                        height: 350,
                        type: "bar",
                        events: {
                            click: function(e, t, o) {}
                        }
                    },
                    colors: chartColumnDistributedColors,
                    plotOptions: {
                        bar: {
                            columnWidth: "45%",
                            distributed: !0
                        }
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    legend: {
                        show: !1
                    },
                    xaxis: {
                        categories: [
                            ["John", "Doe"],
                            ["Joe", "Smith"],
                            ["Jake", "Williams"], "Amber", ["Peter", "Brown"],
                            ["Mary", "Evans"],
                            ["David", "Wilson"],
                            ["Lily", "Roberts"]
                        ],
                        labels: {
                            style: {
                                colors: ["#038edc", "#51d28c", "#f7cc53", "#f34e4e", "#564ab1", "#5fd0f3"],
                                fontSize: "12px"
                            }
                        }
                    }
                }, (chart = new ApexCharts(document.querySelector("#column_distributed"), options)).render()),
                getChartColorsArray("column_group_labels"));
        chartColumnGroupLabelsColors && (dayjs.extend(window.dayjs_plugin_quarterOfYear), optionsGroup = {
            series: [{
                name: "sales",
                data: [{
                    x: "2020/01/01",
                    y: 400
                }, {
                    x: "2020/04/01",
                    y: 430
                }, {
                    x: "2020/07/01",
                    y: 448
                }, {
                    x: "2020/10/01",
                    y: 470
                }, {
                    x: "2021/01/01",
                    y: 540
                }, {
                    x: "2021/04/01",
                    y: 580
                }, {
                    x: "2021/07/01",
                    y: 690
                }, {
                    x: "2021/10/01",
                    y: 690
                }]
            }],
            chart: {
                type: "bar",
                height: 350,
                toolbar: {
                    show: !1
                }
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "45%"
                }
            },
            colors: chartColumnGroupLabelsColors,
            xaxis: {
                type: "category",
                labels: {
                    formatter: function(e) {
                        return "Q" + dayjs(e).quarter()
                    }
                },
                group: {
                    style: {
                        fontSize: "10px",
                        fontWeight: 700
                    },
                    groups: [{
                        title: "2020",
                        cols: 4
                    }, {
                        title: "2021",
                        cols: 4
                    }]
                }
            },
            title: {
                text: "Grouped Labels on the X-axis",
                style: {
                    fontWeight: 500
                }
            },
            tooltip: {
                x: {
                    formatter: function(e) {
                        return "Q" + dayjs(e).quarter() + " " + dayjs(e).format("YYYY")
                    }
                }
            }
        }, (chartGroup = new ApexCharts(document.querySelector("#column_group_labels"), optionsGroup)).render());
    </script>

    <script>
        var worldlinemap,
            vectorMapWorldLineColors = getChartColorsArray("users-by-country"),
            barchartCountriesColors =
            (vectorMapWorldLineColors &&
                (worldlinemap = new jsVectorMap({

                })),
                getChartColorsArray("countries_charts"));


        barchartCountriesColors &&
            ((options = {
                    series: [{
                        data: [100, 1640, 490, 1255, 1050, 689, 800, 420, 1085, 589],
                        name: "Sessions",
                    }, ],
                    chart: {
                        type: "bar",
                        height: 436,
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: !0,
                            distributed: !0,
                            dataLabels: {
                                position: "top"
                            },
                        },
                    },
                    colors: barchartCountriesColors,
                    dataLabels: {
                        enabled: !0,
                        offsetX: 32,
                        style: {
                            fontSize: "12px",
                            fontWeight: 400,
                            colors: ["#adb5bd"]
                        },
                    },
                    legend: {
                        show: !1
                    },
                    grid: {
                        show: !1
                    },
                    xaxis: {
                        categories: [
                            "Korean",
                            "United States",
                            "China",
                            "Indonesia",
                            "Russia",
                            "Bangladesh",
                            "Canada",
                            "Brazil",
                            "Vietnam",
                            "UK",
                        ],
                    },
                }),
                (chart = new ApexCharts(
                    document.querySelector("#countries_charts"),
                    options
                )).render());
    </script>

    <script>
        var options, chart, areachartSalesColors = getChartColorsArray("sales-forecast-chart"),
            dealTypeChartsColors = (areachartSalesColors && (options = {
                    series: [{
                        name: "February",
                        data: [15]
                    }, {
                        name: "March",
                        data: [12]
                    }, {
                        name: "April",
                        data: [18]
                    }],
                    chart: {
                        type: "bar",
                        height: 341,
                        toolbar: {
                            show: !1
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: !1,
                            columnWidth: "65%"
                        }
                    },
                    stroke: {
                        show: !0,
                        width: 5,
                        colors: ["transparent"]
                    },
                    xaxis: {
                        categories: [""],
                        axisTicks: {
                            show: !1,
                            borderType: "solid",
                            color: "#78909C",
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        },

                    },
                    yaxis: {
                        labels: {
                            formatter: function(e) {
                                return e + "kg"
                            }
                        },
                        tickAmount: 4,
                        min: 0
                    },
                    fill: {
                        opacity: 1
                    },
                    legend: {
                        show: !0,
                        position: "bottom",
                        horizontalAlign: "center",
                        fontWeight: 500,
                        offsetX: 0,
                        offsetY: -14,
                        itemMargin: {
                            horizontal: 8,
                            vertical: 0
                        },
                        markers: {
                            width: 10,
                            height: 10
                        }
                    },
                    colors: areachartSalesColors
                }, (chart = new ApexCharts(document.querySelector("#sales-forecast-chart"), options)).render()),
                getChartColorsArray("deal-type-charts")),
            revenueExpensesChartsColors = (dealTypeChartsColors && (options = {


                }, (chart = new ApexCharts(document.querySelector("#deal-type-charts"), options)).render()),
                getChartColorsArray("revenue-expenses-charts"));
        revenueExpensesChartsColors && (options = {}, (chart = new ApexCharts(document.querySelector(
            "#revenue-expenses-charts"), options)).render());
    </script>
@endsection
