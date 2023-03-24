{% extends 'base.tpl' %}
{% block main %}
{% include 'sayfalar/dahil/content_headlines.tpl' %}

<section class="content-section content_sol_menu11">
    <div class="container">
        <div class="row">

            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="solbolum">{% include 'sayfalar/dahil/solmenu.tpl' %}</div>
                    <div class="solbolum_iletisim">
                        <ul>
                            <li><i class="icon-home-1"></i><div class="headlines">{{sitebilgi.adres1}}</div></li>
                            <li><i class="icon-phone"></i><div class="headlines">{{sitebilgi.telefon}}</div></li>
                            <li><i class="icon-email"></i><div class="headlines">{{sitebilgi.email}}</div></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-sm-12 col-xs-12">
                {{islem.breadcrumbCek(active_page_details)}}
                <div class="row">
                    <div class="content">
                        <h1>{{active_page_details.title}}</h1>
                        <h2 class="yazi">{{active_page_details.content}}</h2>

                        {% include 'sayfalar/dahil/content_form.tpl' %}
                        {% include 'sayfalar/dahil/content_resim.tpl' %}
                        {% include 'sayfalar/dahil/content_dosya.tpl' %}
                        {% include 'sayfalar/dahil/content_video.tpl' %}

                        <div class="clear"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{% endblock %}

