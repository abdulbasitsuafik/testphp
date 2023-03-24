<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel | Giriş Yap </title>

    <link href="{{THEME_PATH}}assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/css/animate.css" rel="stylesheet">
    <link href="{{THEME_PATH}}assets/css/style.css" rel="stylesheet">
    <link rel="icon" href="{{SITE_URL}}favicon.ico">
    <link rel="apple-touch-icon" href="{{SITE_URL}}favicon.ico"/>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <!--<h1 class="logo-name">IN+</h1>-->
            <img src="{{SITE_URL}}uploads/logo.png" alt="login" class="img-fluid" style="width: 100%;">
        </div>
        {% block main %}        {% endblock %}
        <p class="m-t">  <small>{{telif}} © {{ "now"|date("Y") }}</small> </p>
    </div>
</div>

</body>

</html>
