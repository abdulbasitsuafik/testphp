<!DOCTYPE html>
<html data-paneltema="{{THEME_PATH}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Panel App</title>

    <link href="{{THEME_PATH}}assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <!--<link href="{{THEME_PATH}}assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">-->

    <!-- Gritter -->
    <link href="{{THEME_PATH}}assets/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/animate.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/css/style.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/select2/select2.min.css" rel="stylesheet">
    <!--<link href="{{THEME_PATH}}assets/css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">-->

    <link href="{{THEME_PATH}}assets/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/dualListbox/bootstrap-duallistbox.min.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/plugins/upload/uploadfile.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">

    <link href="{{THEME_PATH}}assets/css/plugins/bootstrap-markdown/bootstrap-markdown.min.css" rel="stylesheet">

    <script src="{{THEME_PATH}}assets/js/jquery-3.1.1.min.js"></script>

    <link href="{{THEME_PATH}}assets/plugins/markdown/css/markdown-editor.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="{{THEME_PATH}}assets/plugins/markdown/plugins/highlight/github-gist.min.css" media="all" rel="stylesheet" type="text/css"/>


    <link rel="icon" href="{{SITE_URL}}favicon.ico">
    <link rel="apple-touch-icon" href="{{SITE_URL}}favicon.ico"/>
    <style>
        .select2{width:100%!important;}
        .ajs-message.ajs-error.ajs-visible{color:white!important;z-index:999999!important;}
        .alertify-notifier.ajs-top.ajs-center{color:white!important;z-index:999999!important;}
        .alertify-notifier { z-index: 999999!important;}
        div.popover.clockpicker-popover.bottom.clockpicker-align-left { z-index: 9999!important;}
        .ajs-modal { z-index: 9999!important;}
        .alertify .ajs-dialog {border: 5px solid #d68321;}
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
</head>

<body data-site="{{SITE_URL}}" data-panel="{{PANEL_URL}}">
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        {% block sidebar %}{% endblock %}
    </nav>
    <div id="page-wrapper" class="gray-bg dashbard-1">
        {% if calendar|default == true %}
        {% else %}
            {% block topbar %}{% endblock %}
        {% endif %}
        {% if dashboard|default ==true %}
        {% else %}
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4">
                <h2>{{ title|default("Hoşgeldiniz") }}</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="">Home</a>
                    </li>
                    <li class="active">
                        <strong>{{ title|default("Hoşgeldiniz") }}</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-8">
                <div class="title-action">

                        {% block action_area %}{% endblock %}
                </div>
            </div>
        </div>

        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>{{ title|default("Hoşgeldiniz") }}</h5>
                        </div>
                        <div class="ibox-content">
                            {% endif %}
                            {% block body %}{% endblock %}
                            {% if dashboard|default ==true %}{% else %}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {% endif %}
        {% if calendar|default == true %}
        {% else %}
            <div class="footer">
                <div class="pull-right">
                    Tolga EGE - ip = {{SERVER_ADDR}}
                </div>
                <div>
                    <strong>Copyright</strong> Panel &copy; {{ "now"|date("Y") }} - {{ "now"|date("d-m-Y H:i:s",'Europe/Istanbul') }}
                </div>
            </div>
        {% endif %}

    </div>
</div>

<!-- Mainly scripts -->
<!--<script src="{{THEME_PATH}}assets/js/popper.min.js"></script>-->
<script src="{{THEME_PATH}}assets/js/bootstrap.min.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="{{THEME_PATH}}assets/js/plugins/dataTables/datatables.min.js"></script>

<!-- Flot -->
<script src="{{THEME_PATH}}assets/js/plugins/flot/jquery.flot.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/flot/jquery.flot.time.js"></script>
<!-- Peity -->
<script src="{{THEME_PATH}}assets/js/plugins/peity/jquery.peity.min.js"></script>
<script src="{{THEME_PATH}}assets/js/demo/peity-demo.js"></script>
<!-- Jvectormap -->
<script src="{{THEME_PATH}}assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- EayPIE -->
<script src="{{THEME_PATH}}assets/js/plugins/easypiechart/jquery.easypiechart.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/nestable/jquery.nestable.js"></script>

<!-- Custom and plugin javascript -->
<script src="{{THEME_PATH}}assets/js/inspinia.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="{{THEME_PATH}}assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- GITTER -->
<script src="{{THEME_PATH}}assets/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Sparkline -->
<script src="{{THEME_PATH}}assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="{{THEME_PATH}}assets/js/demo/sparkline-demo.js"></script>

<!-- ChartJS-->
<script src="{{THEME_PATH}}assets/js/plugins/chartJs/Chart.min.js"></script>

<!-- Toastr -->
<!--<script src="{{THEME_PATH}}assets/js/plugins/toastr/toastr.min.js"></script>-->

<!-- Chosen -->
<!--<script src="{{THEME_PATH}}assets/js/plugins/chosen/chosenchosen.jquery.js"></script>-->

<!-- JSKnob -->
<script src="{{THEME_PATH}}assets/js/plugins/jsKnob/jquery.knob.js"></script>

<!-- Input Mask-->
<script src="{{THEME_PATH}}assets/js/plugins/jasny/jasny-bootstrap.min.js"></script>

<!-- Data picker -->
<script src="{{THEME_PATH}}assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- iCheck -->
<script src="{{THEME_PATH}}assets/js/plugins/iCheck/icheck.min.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Select2 -->
<script src="{{THEME_PATH}}assets/js/plugins/select2/select2.full.min.js"></script>

<!-- TouchSpin -->
<script src="{{THEME_PATH}}assets/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- Tags Input -->
<script src="{{THEME_PATH}}assets/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

<!-- Dual Listbox -->
<script src="{{THEME_PATH}}assets/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js"></script>
<!-- Clock picker -->
<script src="{{THEME_PATH}}assets/js/plugins/clockpicker/clockpicker.js"></script>

<!-- Bootstrap markdown -->
<script src="{{THEME_PATH}}assets/js/plugins/bootstrap-markdown/bootstrap-markdown.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/bootstrap-markdown/markdown.js"></script>

<!-- Upload -->

<script src="{{THEME_PATH}}assets/plugins/upload/jquery.uploadfile.min.js"></script>
<script src="{{THEME_PATH}}assets/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<!-- Page-Level Scripts -->

<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-deflist.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-footnote.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-abbr.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-sub.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-sup.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-ins.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-mark.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-smartarrows.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-checkbox.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-cjk-breaks.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/markdown-it/markdown-it-emoji.min.js" type="text/javascript"></script>
<!-- script src="{{THEME_PATH}}assets/plugins/markdown/plugins/marked/marked.min.js" type="text/javascript"></script -->
<!-- script src="{{THEME_PATH}}assets/plugins/markdown/js/plugins/js-markdown-extra.js" type="text/javascript"></script -->
<script src="{{THEME_PATH}}assets/plugins/markdown/plugins/highlight/highlight.min.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/js/markdown-editor.js" type="text/javascript"></script>
<script src="{{THEME_PATH}}assets/plugins/markdown/themes/fa4/theme.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $('.dataTables-example-').DataTable({
            pageLength: 100,
            responsive: true,
            //dom: '<"html5buttons"B>lTfgitp',
            dom: 'lTfgitp',
            buttons: [
                { extend: 'copy'},
                { extend: 'csv'},
                { extend: 'excel', title: 'ExampleFile'},
                { extend: 'pdf', title: 'ExampleFile'},

                {
                    extend: 'print',
                    customize: function (win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]
        });
    });

</script>
<script>
    $(document).ready(function() {
        // setTimeout(function() {
        //     toastr.options = {
        //         closeButton: true,
        //         progressBar: true,
        //         showMethod: 'slideDown',
        //         timeOut: 4000
        //     };
        //     toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');
        //
        // }, 1300);


        var data1 = [
            [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
        ];
        var data2 = [
            [0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
        ];
        $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                data1, data2
            ],
            {
                series: {
                    lines: {
                        show: false,
                        fill: true
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    points: {
                        radius: 0,
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: '#d5d5d5'
                },
                colors: ["#1ab394", "#1C84C6"],
                xaxis:{
                },
                yaxis: {
                    ticks: 4
                },
                tooltip: false
            }
        );

        var doughnutData = {
            labels: ["App","Software","Laptop" ],
            datasets: [{
                data: [300,50,100],
                backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
            }]
        } ;


        var doughnutOptions = {
            responsive: false,
            legend: {
                display: false
            }
        };


        var ctx4 = document.getElementById("doughnutChart").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

        var doughnutData = {
            labels: ["App","Software","Laptop" ],
            datasets: [{
                data: [70,27,85],
                backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
            }]
        } ;


        var doughnutOptions = {
            responsive: false,
            legend: {
                display: false
            }
        };


        var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

    });

</script>
<script>
    $(document).ready(function() {
        $('.chart').easyPieChart({
            barColor: '#f8ac59',
//                scaleColor: false,
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });

        $('.chart2').easyPieChart({
            barColor: '#1c84c6',
//                scaleColor: false,
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });

        var data2 = [
            [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
            [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
            [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
            [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
            [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
            [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
            [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
            [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
        ];

        var data3 = [
            [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
            [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
            [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
            [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
            [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
            [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
            [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
            [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
        ];


        var dataset = [
            {
                label: "Number of orders",
                data: data3,
                color: "#1ab394",
                bars: {
                    show: true,
                    align: "center",
                    barWidth: 24 * 60 * 60 * 600,
                    lineWidth:0
                }

            }, {
                label: "Payments",
                data: data2,
                yaxis: 2,
                color: "#1C84C6",
                lines: {
                    lineWidth:1,
                    show: true,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.2
                        }, {
                            opacity: 0.4
                        }]
                    }
                },
                splines: {
                    show: false,
                    tension: 0.6,
                    lineWidth: 1,
                    fill: 0.1
                },
            }
        ];


        var options = {
            xaxis: {
                mode: "time",
                tickSize: [3, "day"],
                tickLength: 0,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Arial',
                axisLabelPadding: 10,
                color: "#d5d5d5"
            },
            yaxes: [{
                position: "left",
                max: 1070,
                color: "#d5d5d5",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Arial',
                axisLabelPadding: 3
            }, {
                position: "right",
                clolor: "#d5d5d5",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: ' Arial',
                axisLabelPadding: 67
            }
            ],
            legend: {
                noColumns: 1,
                labelBoxBorderColor: "#000000",
                position: "nw"
            },
            grid: {
                hoverable: false,
                borderWidth: 0
            }
        };

        function gd(year, month, day) {
            return new Date(year, month - 1, day).getTime();
        }

        var previousPoint = null, previousLabel = null;

        $.plot($("#flot-dashboard-chart"), dataset, options);

        var mapData = {
            "US": 298,
            "SA": 200,
            "DE": 220,
            "FR": 540,
            "CN": 120,
            "AU": 760,
            "BR": 550,
            "IN": 200,
            "GB": 120,
        };

        $('#world-map').vectorMap({
            map: 'world_mill_en',
            backgroundColor: "transparent",
            regionStyle: {
                initial: {
                    fill: '#e4e4e4',
                    "fill-opacity": 0.9,
                    stroke: 'none',
                    "stroke-width": 0,
                    "stroke-opacity": 0
                }
            },

            series: {
                regions: [{
                    values: mapData,
                    scale: ["#1ab394", "#22d6b1"],
                    normalizeFunction: 'polynomial'
                }]
            },
        });
    });
</script>
<link rel="stylesheet" href="{{THEME_PATH}}assets/plugins/alertify/css/alertify.min.css">
<script type="text/javascript" src="{{THEME_PATH}}assets/plugins/alertify/js/alertify.min.js"></script>
<!-- Scriptler -->
<script type="text/javascript" src="{{PANEL_URL}}static/ajax/genel.js?time={{'now'|date('U')}}"></script>
<script src="{{THEME_PATH}}assets/plugins/ckeditor/ckeditor.js"></script>
<div class="modalgetir"></div>
<div class="modalgetir2"></div>
<script>
    $( document ).ready(function() {
        setPageToLeftSidebar();
        $(".select2").select2({
            placeholder: "Select Please",
            allowClear: true
        });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
        $('.datepicker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd-mm-yyyy',
            weekStart: 1,
            changeYear: false,
            startDate: "-80:+0",
            language: "en",
            todayHighlight: true,
        });
        $('.clockpicker').clockpicker();
    });

    // setTimeout(function(){
    //     $(".select2_demo_2").select2({
    //         placeholder: "Select Please",
    //         allowClear: true
    //     });
    // }, 3000);
    //form_enter();
</script>
<link rel="stylesheet" href="{{SITE_URL}}public/eklentiler/datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="{{SITE_URL}}public/eklentiler/datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="{{SITE_URL}}public/eklentiler/datepicker/locales/bootstrap-datepicker.tr.min.js"></script>
<script type="text/javascript">
    $(function() { "use strict";
        $('.bootstrap-datepicker2').datepicker({
            format: 'dd-mm-yyyy',
            weekStart: 1,
            changeYear: false,
            startDate: "-80:+0",
            language: "tr",
            //daysOfWeekDisabled: "0,6",
            //daysOfWeekHighlighted: "0,6",
            todayHighlight: true,
            autoclose:true
        });
    });
    var mem = $('.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

</script>
<div class="lightBoxGallery">
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
</div>
{% block new_scripts %} {% endblock %}
</body>
</html>
