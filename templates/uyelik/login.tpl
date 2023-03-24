{% extends 'base_member.tpl' %}
{% block main %}
<div class="limiter">
    <div class="container-login100" style="background-image: url('{{MEMBER_THEME_PATH}}images/img-01.jpg');">
        <div class="wrap-login100 p-t-190 p-b-30">
            <form class="login100-form validate-form" action="" id="girisyap" method="post">

                <div class="login100-form-avatar">
                    <img src="{{SITE_URL}}uploads/logo.jpeg" alt="AVATAR">
                </div>

                <span class="login100-form-title p-t-20 p-b-45">
						Efx akademi içerik havuzu
					</span>

                <div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
                    <input class="input100" type="text" name="username" placeholder="Kullanıcı Adı & Email">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
                </div>

                <div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
                    <input class="input100" type="password" name="password" placeholder="Parola">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
                </div>

                <div class="container-login100-form-btn p-t-10">
                    <button type="button" class="login100-form-btn" onclick="girisYap()">
                        Giriş Yap
                    </button>
                </div>

                <div class="text-center w-full p-t-25 p-b-230">
                    <div class="col-xs-12 col-md-12"><div class="row"><div class="alert formAlert_11 alert-danger" role="alert" style="display: none;"></div></div></div>
                    <!--<a href="#" class="txt1">
                        Forgot Username / Password?
                    </a>-->
                </div>

                <div class="text-center w-full">
                    <!--<a class="txt1" href="#">
                        Create new account
                        <i class="fa fa-long-arrow-right"></i>
                    </a>-->
                </div>
            </form>
        </div>
    </div>
</div>
{% endblock %}

{% block new_scripts  %}
<link rel="stylesheet" href="{{PANEL_TEMA}}assets/plugins/alertify/css/alertify.min.css">
<script type="text/javascript" src="{{PANEL_TEMA}}assets/plugins/alertify/js/alertify.min.js"></script>
    <script>
        function girisYap(){
            var form = $("#girisyap").serialize();
            $.ajax({
                type: "POST",
                url: "{{SITE_URL}}uyelik/girisyap",
                data: form,
                success: function(data) {
                    var gelenData = JSON.parse(data);
                    console.log(gelenData);
                    $(".formAlert_11").css("display","block");
                    $(".formAlert_11").html(gelenData["mesaj"]);
                    if(gelenData["status"]==true){
                        location.href = gelenData["link"];
                    }
                    alertCagir(gelenData)
                }
            });
        }
    </script>
{% endblock %}

