{% extends 'base.tpl' %}

{% block main %}

<link href="{{THEME_PATH}}assets/css/iletisim.css" rel="stylesheet">
<div class="iletisim_listele1_maps">
    <div class="maps">{{islem.base64_decode(sitebilgi.harita)}}</div>
</div>


<section class="content_section">
    <div class="container">
        {{islem.breadcrumbCek(active_page_details)}}
        <div class="row">
            <div class="iletisim_listele1">
            <p>{{active_page_details.content}}</p>

            <ul class="iletisim">
                <h1>{{sitebilgi.unvani}}</h1>
                <li>
                    <i class="licon-map-marker"></i>
                    <h4>Adres</h4>
                    <h5>{{sitebilgi.adres1}}</h5>
                </li>
                <li>
                    <i class="licon-telephone"></i>
                    <h4>Telefon</h4>
                    <h5>{{sitebilgi.telefon}}</h5>
                </li>
                <li>
                    <i class="icon-mobile-1"></i>
                    <h4>Telefon</h4>
                    <h5>{{sitebilgi.gsm}}</h5>
                </li>
                <li>
                    <i class="icon-mail"></i>
                    <h4>Mail</h4>
                    <h5><a href="mailto:{{sitebilgi.email}}">{{sitebilgi.email}}</a></h5>
                </li>
            </ul>

              {{islem.formCek(form_id)}}
                 
            </div>
        </div>

        </div>
    </div>
</section>

{% endblock %}

