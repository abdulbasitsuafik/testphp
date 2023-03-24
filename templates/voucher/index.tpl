<!DOCTYPE html>
<html lang="tr" dir="ltr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content="">
    <title> Coupons | Ücretsiz Sürüş Kazan</title>
    <link rel="shortcut icon" href="https://www.atlagit.tech/uploads/favicon.ico" type="image/x-icon"/>
    <style>
        html {
            height: 100%;
        }
        body {
            background-color: white;
            font-size: 16px;
            height: 100%;
            color: #253342;
            font-family: 'Futura', sans-serif;
            font-weight: 500;
            margin: 0;
            overflow-x: hidden;
        }
        .page-wrap {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: auto;
            background-color: #fafafa;
        }
        .header {
            background: yellow;
            padding: 40px 0 10px;
            position: relative;
        }
        .header>.container {
            display: flex;
            align-items: flex-end;
        }
        .container {
            display: block;
            max-width: 1180px;
            padding: 0 24px;
            width: 100%;
            margin: 0 auto;
        }

        .page-wrap .header a {
            text-decoration: none;
        }
        .header .logo {
            position: absolute;
            bottom: -50px;
            background: yellow;
            padding: 0 16px 20px;
            border-radius: 50%;
            z-index: 10;
        }
        .header__title {
            display: block;
            font-size: 30px;
            margin-left: 140px;
            font-weight: bold;
            color: #383838;
        }
        figure {
            margin: 0;
        }
        .header .logo img {
            display: block;
        }
        .page-main {
            display: block;
            margin-top: 80px;
        }
        .box {
            border-radius: 8px;
            box-shadow: 0 2px 12px -5px rgba(37,51,66,0.5);
            background-color: #ffffff;
            max-width: 1180px;
            text-align: center;
        }
        .banner {
            padding: 50px 0 20px;
            background-color: rgba(171,171,171,0.15);
            display: flex;
            align-items: center;
            justify-content: space-around;
        }
        .banner {
            margin-bottom: 30px;
        }
        section {
            position: relative;
            width: 100%;
        }
        .banner__title {
            display: block;
            font-size: 28px;
            line-height: 1.67;
            letter-spacing: -0.01px;
            color: #383838;
        }
        .banner__desc {
            font-size: 18px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.5;
            letter-spacing: -0.01px;
            color: #959595;
        }
        .box .steps {
            padding: 0 40px;
        }

        .steps {
            margin-bottom: 20px;
        }
        .steps__item {
            margin-bottom: 26px;
        }
        .steps__item>span {
            display: block;
            margin-bottom: 16px;
        }
        .desc__content {
            font-size: 18px;
            line-height: 1.5;
            letter-spacing: -0.01px;
            color: #959595;
        }
        .pull-center {
            align-items: center;
            justify-content: center;
        }

        .flexible-row {
            display: flex;
        }
        .steps__item .mobile-store>a {
            margin-right: 20px;
        }
        .steps__item .mobile-store>a figure img {
            display: block;
        }
        .clipboard-wrapper {
            border: solid 1px #93e836;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 300px;
        }
        .clipboard-wrapper span {
            font-size: 16px;
            line-height: 1.5;
            letter-spacing: -0.01px;
            color: #383838;
        }
        .clipboard-wrapper .clipboard {
            position: relative;
            background: #93e836;
            border: none;
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 26px;
            letter-spacing: -0.01px;
            color: #ffffff;
        }
        .clipboard-wrapper .clipboard__tooltip {
            display: flex;
            opacity: 0;
            position: absolute;
            top: -40px;
            left: calc( -50% + 40px);
            width: 80px;
            height: 30px;
            background-color: #000;
            color: #fff;
            font-size: 11px;
            font-weight: 500;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            pointer-events: none;
            will-change: transform;
            transition: opacity 150ms ease-in-out;
        }

        .box .orientation {
            padding: 0 40px 40px;
        }

        .orientation {
            text-align: center;
        }
        .orientation span {
            display: block;
            margin-bottom: 10px;
        }

        .important-message {
            font-size: 22px;
            line-height: 2.5;
            letter-spacing: -0.01px;
            color: #383838;
        }
        .orientation .button {
            font-size: 20px;
        }

        button {
            cursor: pointer;
        }
        .button {
            min-width: 200px;
            display: inline-block;
            background: #93e836;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.5;
            text-align: center;
            color: #fff;
            border-radius: 25px;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
        }
        .banner__title span {
            color: #79d41f;
        }

        .margin-center {
            margin: 0 auto;
        }
        a {
            text-decoration: none;
        }

        /* Tooltip container */
        .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
        }

        /* Tooltip text */
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;

            /* Position the tooltip text */
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;

            /* Fade in tooltip */
            opacity: 0;
            transition: opacity 0.3s;
        }

        /* Tooltip arrow */
        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        /* Show the tooltip text when you mouse over the tooltip container */
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        @media screen and (max-width: 480px){
            .header {
                padding: 10px 0;
            }
            .header>.container {
                align-items: center;
            }
            .container {
                padding: 0 16px;
                width:93%;
            }
            .header .logo {
                position: relative;
                padding: 0;
                bottom: inherit;
            }
            .header__title {
                margin-left: 16px;
                font-size: 26px;
            }
            .page-main {
                margin-top: 20px;
            }
            .banner {
                padding: 20px 0;
                width:95%;
            }
            .banner {
                margin-bottom: 20px;
                width:100%;
            }
            .banner__title {
                font-size: 18px;
            }
            .banner__desc {
                font-size: 14px;
            }
            .banner__image img {
                width: 100px;
            }
            .box .steps {
                padding: 0 10px;
                width:95%;
            }
            .steps__item {
                margin-bottom: 16px;
            }
            .steps__item .mobile-store>a {
                margin-right: 0;
            }
            .box .orientation {
                padding: 0 10px 20px;
                width:95%;
            }
            .important-message {
                font-size: 16px;
                line-height: 1;
            }
            .button {
                min-width: 130px;
            }
        }

    </style>
    <script src="https://atlagit.tech/admin/static/temalar/default/assets/js/jquery-3.1.1.min.js"></script>
</head>
<body>
<div class="page-wrap">
    <header id="masthead" class="header">


        <div class="container">
            <a href="javascript:;" class="logo">
                <figure>
                    <img height="100" src="https://atlagit.tech/admin/static/temalar/default/assets/logo.png" alt="Coupons Logo">
                </figure>
            </a>
            <span class="header__title">Coupons</span>
        </div>

    </header>
    <main id="content" class="page-main">

        <div class="container">
            <div class="box">
                <section class="banner">
                    <div class="banner-left">
                        <span class="banner__title">Arkadaşının davetini kabul ederek <span>Ücretsiz</span> sürüş kazan!</span>
                        <span class="banner__desc">Coupons uygulamasını hemen indir ve sürüşün keyfini çıkar!</span>
                    </div>
                    <figure class="banner__image"><img height="180" src="https://www.atlagit.tech/uploads/scooter.png" alt="Scooter Image"></figure>
                </section>
                {% if code %}
                <section class="steps">
                    <div class="steps__item">
                        <span class="desc__content">1. Coupons uygulamasını uygulama marketinden indir</span>
                        <div class="flexible-row pull-center mobile-store">
                            <a href=""><figure><img src="https://www.atlagit.tech/uploads/app-store@2x.png" alt="App Store"></figure></a>
                            <a href="https://play.google.com/store/apps/details?id=com.atlagit.atlagit"><figure><img src="https://www.atlagit.tech/uploads/google-play@2x.png" alt="Google Play"></figure></a>
                        </div>
                    </div>
                    <div class="steps__item">
                        <span class="desc__content">2. Arkadaşının davetinden gelen aşağıdaki kodu kopyala</span>
                        <div class="clipboard-wrapper margin-center">
                            <span id="codes">{{code}}</span>
                            <button type="button" class="clipboard " onclick="kopyalama()">
                                KOPYALA
                                <span class="tooltiptext" style="display: none;">Kopyalandı</span>
                            </button>
                        </div>
                    </div>
                    <div class="steps__item">
                        <span class="desc__content">3. Uygulamaya giriş yapıp Kampanyalar menüsü altından Davet Kodunu Gir ve indirim kazan!</span>
                    </div>
                </section>
                {% else %}

                <section style="padding-top:100px;padding-bottom:100px">
                    <div class="steps__item"><span class="desc__content" style="color:red;font-size:24px">Kupon kodu mevcut değil.</span></div>
                </section>
                {% endif %}
                <section class="orientation">
                    <span class="important-message">Coupons hakkında daha fazla mı bilgi almak istiyorsun?</span>
                    <a href="https://www.atlagit.tech/" class="button">Web sitesine Git</a>
                </section>
            </div>
        </div>
    </main>
    <script>

        function kopyalama(){
            var element = document.getElementById("codes");
            var copyText = document.getElementById("codes");
            var textArea = document.createElement("textarea");
            textArea.value = copyText.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("Copy");
            textArea.remove();
            // console.log("copyText",element_val);
            alert("Kopayalan: " + element.innerHTML);

            $(".clipboard").addClass("tooltip");
            $(".clipboard__tooltip").show();
            $(".tooltip").show();
        }
    </script>
</div>
</body>
