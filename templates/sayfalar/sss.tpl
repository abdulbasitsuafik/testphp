{% extends 'base.tpl' %}
{% block main %}

{{ islem.altsayfa_kontrol(active_page_details,true) }}
{% include 'sayfalar/dahil/content_headlines.tpl' %}

<section class="content_section">
    <div class="container">
        {{islem.breadcrumbCek(active_page_details)}}
        <div class="row">
            <h1 class="yazi">{{active_page_details.content}}</h1>

            <div class="sss_lisleleme">
                <div class="panel-group" id="accordion">
                    {% set gelen_veri = islem.sqlSorgu("SELECT * FROM "~prefix~"sss a JOIN "~prefix~"sss_dil b ON a.id=b.sss_id WHERE b.lang = :lang order by a.id ASC",{":lang":sessions.dil}) %}
                    {% set liste_ranksi = 0 %}
                    {% for key,value in gelen_veri %}
                    {% set liste_ranksi = liste_ranksi + 1 %}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapsediv{{liste_ranksi}}" class="{% if liste_ranksi == '1' %}collapsed{%endif%}">{{value.soru}} </a></h4>
                        </div>
                        <div id="collapsediv{{liste_ranksi}}" class="panel-collapse collapse {% if liste_ranksi == '1' %} in {%endif%} "  >
                            <div class="panel-body">
                                <p>{{value.cevap}}</p>
                            </div>
                        </div>
                    </div>
                    {%endfor%}
                </div>
            </div>
            {% include 'sayfalar/dahil/content_form.tpl' %}
            {% include 'sayfalar/dahil/content_resim.tpl' %}
            {% include 'sayfalar/dahil/content_dosya.tpl' %}
            {% include 'sayfalar/dahil/content_video.tpl' %}
        </div>
    </div>
</section>

{% endblock %}



