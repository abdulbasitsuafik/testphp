{% extends 'login_base.tpl' %}
{% block main %}
    <form class="m-t" role="form" action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Kullanıcı Adı" required="" autocomplete="off">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Şifre" required="" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary block full-width m-b">Giriş Yap</button>
        <p style="color:red" class="m-t">
            <small>{{enter_status}}</small>
        </p>
        <!--<a href="#">
            <small>Forgot password?</small>
        </a>

        <p class="text-muted text-center">
            <small>Do not have an account?</small>
        </p>
        <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>-->
    </form>
{% endblock %}