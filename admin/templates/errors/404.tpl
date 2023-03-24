{% extends 'base.tpl' %}
{% block body %}
{% if status =="1" %}
    <div class="middle-box text-center animated fadeInDown">
        <h1>404</h1>
        <h3 class="font-bold">Page Not Found</h3>
        <div class="error-desc">
            Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
            <br>
            You can go back to main page: <br><br><a href="{{panel_url}}" class="btn btn-primary "><span class="glyphicon glyphicon-home"></span> Home </a>
        </div>
    </div>

{% elseif status =="2" %}
    <div class="middle-box text-center animated fadeInDown">
        <h1>404</h1>
        <h3 class="font-bold">Permission Denied</h3>
        <div class="error-desc">
            Sorry, you do not have permission to enter the current page.
            <br>
            You can go back to main page: <br><br><a href="{{panel_url}}" class="btn btn-primary "><span class="glyphicon glyphicon-home"></span> Home </a>
        </div>
    </div>
{% endif %}

{% endblock %}
