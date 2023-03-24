{% extends 'base.tpl' %}

{% block main %}
    
        {% include 'sayfalar/dahil/content_headlines3.tpl' %}

        <!--about-section-->
        <section class="content_section">
            <div class="container">
                <div class="row">


                    {% include 'sayfalar/dahil/solmenu.tpl' %}
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

                        {% set anaresim = islem.sqlSorgu("SELECT * FROM ".PREFIX."headlines_resim WHERE head_id= :head_id order by id ASC limit 1",{":head_id":active_page_details.head_id}) %}
                        {% if anaresim !='' %}<a href="{{SITE_URL}}{{anaresim}}" class="lightbox-image detayresim"><img src="{{islem.resimcek(anaresim,300,200)}}" alt="{{title}}"/></a>{%endif%}

                        {{active_page_details.content}}

                        {% include 'sayfalar/dahil/content_form.tpl' %}
                        {% include 'sayfalar/dahil/content_resim.tpl' %}
                        {% include 'sayfalar/dahil/content_video.tpl' %}
                        {% include 'sayfalar/dahil/content_dosya.tpl' %}

                        <div class="clear"></div>
                    </div>

                </div>
            </div>
        </section>
        <!--about-section end-->


{% endblock %}

