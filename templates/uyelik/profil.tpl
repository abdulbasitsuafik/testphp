{% extends 'base.tpl' %}

{% block main %}
 <style type="text/css">
    .bilgi_menu {display: block!important;}
</style>
{% set uye = islem.sqlSorgu("SELECT * FROM "~prefix~"uyeler WHERE id= :id",{":id":sessions.uye_id}) %}
{% set urlcek = islem.urlcek(2) %}
<div class="content_headlines" style="background: url('{{THEME_PATH}}assets/img/headlines_bg.jpg') center;">
    <div class="kararti"></div>
    <div class="container">
        <div class="row">
            <h1>Üye Profil Sayfası </h1>
        </div>
    </div>
</div>
  <section class="content_section">
    <div class="container">
        <div class="row">
             <div class="col-md-3 col-sm-3 col-xs-12">
                 <ul class="nav nav-pills nav-stacked">
                  <li role="presentation" {% if urlcek == 'randevularim' %}class="active"{% endif %}><a href="{{SITE_URL}}uyelik/profil/randevularim">Randevularım</a></li>
                  <li role="presentation" {% if urlcek == 'raporlarim' %}class="active"{% endif %}><a href="{{SITE_URL}}uyelik/profil/raporlarim">Raporlarım</a></li>
                  <li role="presentation" {% if urlcek == 'doktorgorusleri' %}class="active"{% endif %}><a href="{{SITE_URL}}uyelik/profil/doktorgorusleri">Doktor Görüşleri</a></li>
                  <li role="presentation" {% if urlcek == 'sikayetbildir' %}class="active"{% endif %}><a href="{{SITE_URL}}uyelik/profil/sikayetbildir">Şikayet Bildir</a></li>
                  <li role="presentation" {% if urlcek == 'bilgiler' %}class="active"{% endif %}><a href="{{SITE_URL}}uyelik/profil/bilgiler">Profil Bilgilerim</a></li>
                </ul>
             </div>
              <div class="col-md-9 col-sm-9 col-xs-12">
                  burda
              </div>

        </div>
    </div>
</section>

{% endblock %}

