{% extends 'base.tpl' %}
{% block main %}

{% include 'sayfalar/dahil/content_headlines.tpl' %}

<section class="content_section">
    <div class="container">
        {{islem.breadcrumbCek(active_page_details)}}
        <div class="row">
            {% set gelen_veri = islem.sqlSorgu("SELECT * FROM "~prefix~"referanslar order by rank ASC") %}
            {% for key,value in gelen_veri %}
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="referanslar_logo_liste">
                    <div class="resim">
                        <img src="{{islem.resimcek(value.firma_logo,500,300,1)}}" alt="{{value.firma_adi}}">
                    </div>
                    <div class="description">
                        <h4>{{value.firma_adi}}</h4>
                        <ul>
                            <li>{{value.proje_adi}}</li>
                            <li><i class="icon-location-1"></i>{{value.sehir}}</li>
                            <li><i class="icon-attention-alt"></i>{{value.yapilan_is}}</li>
                            <li><i class="icon-link-3"></i>{{value.link}}</li>
                        </ul>
                    </div>
                </div>
            </div>
            {%endfor%}
        </div>
    </div>
</section>

{% endblock %}