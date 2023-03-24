<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Giriş</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{MEMBER_THEME_PATH}}images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{MEMBER_THEME_PATH}}vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{MEMBER_THEME_PATH}}fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{MEMBER_THEME_PATH}}fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{MEMBER_THEME_PATH}}vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{MEMBER_THEME_PATH}}vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{MEMBER_THEME_PATH}}vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{MEMBER_THEME_PATH}}css/util.css">
    <link rel="stylesheet" type="text/css" href="{{MEMBER_THEME_PATH}}css/main.css">
    <!--===============================================================================================-->
</head>
<body data-site="{{SITE_URL}}" data-panel="{{SITE_URL}}">


{% block main %}{% endblock %}


<!--===============================================================================================-->
<script src="{{MEMBER_THEME_PATH}}vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="{{MEMBER_THEME_PATH}}vendor/bootstrap/js/popper.js"></script>
<script src="{{MEMBER_THEME_PATH}}vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="{{MEMBER_THEME_PATH}}vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="{{MEMBER_THEME_PATH}}js/main.js"></script>
<script type="text/javascript" src="{{PANEL_URL}}static/ajax/genel.js?time={{'now'|date('U')}}"></script>
{% block new_scripts %} {% endblock %}
</body>
</html>
