<!DOCTYPE html>
<html lang="{{lang|lower}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{islem.kisalt(title,60)}}</title>
    <meta name="description" content="{{islem.kisalt(description,150)}}">
    <!--<meta name="keywords" content="{{keywords}}">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,index,follow" />
    <meta name="googlebot" content="all,index,follow" />
    <meta name="msnbot" content="all,index,follow" />
    <meta name="Slurp" content="all,index,follow" />
    <meta name="Revisit-After" content="1 Days" />
    <meta name="Page-Type" content="Information" />
    <meta name="audience" lang="{{dil}}" content="all" />
    <!--<meta name="Language" content="Turkish" />-->
    <meta http-equiv="expires" content="Yes"/>
    <meta http-equiv="ImageToolbar" content="No"/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="author" content="{{sitebilgi.telif}}" />
    <meta name="abstract"  content="{{description}}" />
    <meta name="content-language" content="{{dil|lower}}-{{dil|upper}}" />
    <link rel="alternate" href="{{active_link}}"  hreflang="{{dil|lower}}" />
    <link rel="canonical" href="{{active_link}}"/>
    <meta name="theme-color" content="invalid">
    <!-- sosyalmedya taglari -->
    <meta property="fb:app_id" content="966242223397117" />
    <meta property="og:url" content="{{active_link}}" />
    <meta property="og:description" content="{{description}}" />
    <meta property="og:image" content="{{meta_image}}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{title}}" />
    <meta property="og:title" content="{{title}}" />
    <meta property="og:image:width" content="765" />
    <meta property="og:image:height" content="375" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="{{title}}" />
    <meta name="twitter:description" content="{{description}}" />
    <meta name="twitter:image" content="{{meta_image}}" />

    <link rel="icon" href="{{SITE_URL}}{{sitebilgi.favicon}}">
    <link rel="apple-touch-icon" href="{{SITE_URL}}{{sitebilgi.favicon}}"/>

    <meta name="verify-admitad" content="5232f542ad" />
    <!-- sosyalmedya taglari -->
    <link href="{{THEME_PATH}}assets/css/formlar.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="{{THEME_PATH}}assets/form/select/css/bootstrap-select.css">
    <!--<link href="{{THEME_PATH}}assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/css/formlar.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="{{THEME_PATH}}assets/form/select/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="{{THEME_PATH}}assets/fancybox/css/jquery.fancybox.min.css" media="screen">
    <script src="{{THEME_PATH}}assets/js/vendor/jquery-1.12.4.min.js"></script>-->
    <link href="{{THEME_PATH}}tema_assets/css/bootstrap.css" rel="stylesheet">
    <link href="{{THEME_PATH}}tema_assets/css/stil.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,900italic,700italic,900,700,500italic,500,400italic,300italic,300,100italic,100|Open+Sans:400,300,400italic,300italic,600,600italic,700italic,700,800|Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700" rel="stylesheet" type="text/css">
    <!-- Styles -->

</head>

<body data-site="{{SITE_URL}}" data-panel="{{PANEL_URL}}" oncontextmenu="return false">
{% block header %}{% endblock %}
{% block main %}{% endblock %}
{% block footer %}{% endblock %}

<!-- jQuery -->

<!-- Scriptler -->
<!--<script src="{{THEME_PATH}}assets/js/bootstrap.min.js"></script>
            <script src="{{THEME_PATH}}assets/fancybox/js/jquery.fancybox.min.js"></script>
            <link rel="stylesheet" href="{{THEME_PATH}}assets/font/demo-files/demo.css">
            <link rel="stylesheet" href="{{THEME_PATH}}assets/font/demo-files/fontello.css">
            <style type="text/css">
            @font-face {
                font-family: 'Linearicons';
                src: url('{{THEME_PATH}}assets/font/Linearicons.ttf') format('truetype');
                font-weight: normal;
                font-style: normal;
            }
            @font-face {
                font-family: 'fontello';
                src: url('{{THEME_PATH}}assets/font/alarm9dd3.eot?11759646');
                src: url('{{THEME_PATH}}assets/font/alarm9dd3.eot?11759646#iefix') format('embedded-opentype'),
                url('{{THEME_PATH}}assets/font/alarm9dd3.woff?11759646') format('woff'),
                url('{{THEME_PATH}}assets/font/alarm9dd3.ttf?11759646') format('truetype'),
                url('{{THEME_PATH}}assets/font/alarm9dd3.svg?11759646#alarm') format('svg');
                font-weight: normal;
                font-style: normal;
            }
            </style>
            <script src="{{THEME_PATH}}assets/form/select/js/bootstrap-select.js"></script>
            <script src="{{THEME_PATH}}assets/form/fileselect/fileselect.js"></script>
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
            <script src="{{THEME_PATH}}assets/input-mask/jquery.inputmask.bundle.min.js"></script>
            <script src="{{THEME_PATH}}assets/input-mask/phone-codes/phone.min.js"></script>
            <script type="text/javascript">
                 $('[data-mask]').inputmask();
            </script>
            <link rel="stylesheet" href="{{SITE_URL}}public/eklentiler/datepicker/css/bootstrap-datepicker.min.css">
            <script type="text/javascript" src="{{SITE_URL}}public/eklentiler/datepicker/js/bootstrap-datepicker.min.js"></script>
            <script type="text/javascript" src="{{SITE_URL}}public/eklentiler/datepicker/locales/bootstrap-datepicker.tr.min.js"></script>
            <script type="text/javascript">
                $(function() { "use strict";
                    $('.bootstrap-datepicker').datepicker({
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

            </script>-->
<!-- Scriptler -->

<script src="{{THEME_PATH}}tema_assets/js/jquery-3.4.1.slim.min.js"></script>
<script src="{{THEME_PATH}}tema_assets/js/bootstrap.js"></script>

<div class="modalgetir"></div>
<div class="modalgetir2"></div>
</body>
</html>
