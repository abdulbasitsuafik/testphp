{% extends 'base.tpl' %}

{% block main %}

<link href="{{THEME_PATH}}assets/css/iletisim.css" rel="stylesheet">

{% include 'sayfalar/dahil/content_headlines.tpl' %}

<section class="content_section">
    <div class="container">
        {{islem.breadcrumbCek(active_page_details)}}
        <div class="row">
            <div class="iletisim_listele2">   
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <p>{{active_page_details.content}}</p>
                    <ul class="iletisim">
                        <h1>{{sitebilgi.unvani}}</h1>
                        <li>
                            <div class="icon"><i class="licon-map-marker"></i></div>
                            <div class="yazi">
                                <h4>Adres</h4>
                                <span>{{sitebilgi.adres1}}</span>
                            </div>
                        </li>
                        <li>
                            <div class="icon"><i class="licon-telephone"></i></div>
                            <div class="yazi">
                                <h4>Telefon</h4>
                                <span>{{sitebilgi.telefon}}</span>
                            </div>
                        </li>
                        <li>
                            <div class="icon"><i class="icon-mobile-1"></i></div>
                            <div class="yazi">
                                <h4>Gsm</h4>
                                <span>{{sitebilgi.gsm}}</span>
                            </div>
                        </li>
                        <li>
                            <div class="icon"><i class="icon-mail"></i></div>
                                <div class="yazi">
                                <h4>Mail</h4>
                                <span><a href="mailto:{{sitebilgi.email}}">{{sitebilgi.email}}</a></span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        <h4>Biz Neredeyiz ?</h4>
                        {{islem.formCek(form_id)}}
                    </div>
                </div>
            
            <div class="maps">{{islem.base64_decode(sitebilgi.harita)}}</div>
            </div>
        </div>
    </div>
</section>

{% endblock %}

