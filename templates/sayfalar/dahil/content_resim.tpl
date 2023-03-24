<div class="coklu_resimler">
    <div class="row">
        {% set url_system = sessions.url_system %}
        {% if url_system == "headlines" %} {% set gelen_id = active_page_details.head_id %} {% set tablo = url_system %}
        {% elseif url_system == "headlines" %} {% set gelen_id = active_page_details.head_id %} {% set tablo = url_system %}
        {% elseif url_system == "hizmet_headlines" %} {% set gelen_id = active_page_details.head_id %}{% set tablo = "headlines" %}
        {% elseif url_system == "proje_headlines" %} {% set gelen_id = active_page_details.head_id %}{% set tablo = "headlines" %}
        {% elseif url_system == "urun" %} {% set gelen_id = active_page_details.urun_id %}{% set tablo = url_system %}
        {% elseif url_system == "proje" %} {% set gelen_id = active_page_details.proje_id %}{% set tablo = url_system %}
        {% elseif url_system == "hizmet" %} {% set gelen_id = active_page_details.hizmet_id %}{% set tablo = url_system %}
        {% elseif url_system == "etkinlik" %} {% set gelen_id = active_page_details.etkinlik_id %}{% set tablo = url_system %}
        {% elseif url_system == "makale" %} {% set gelen_id = active_page_details.makale_id %}{% set tablo = url_system %}
        {% endif %}
    {% set resim_oku = islem.sqlSorgu("SELECT * FROM "~prefix~url_system~"_resim a JOIN "~prefix~url_system~"_resim_ayrinti b ON a.boyut_kod=b.boyut_kod WHERE a."~tablo~"_id = :head_id and b.lang= :lang order by rank ASC",{":head_id":gelen_id,":lang":sessions.dil}) %}
    {% for key,value in resim_oku %}
        <div class="col-md-3 col-sm-4 col-xs-12">
            <a data-fancybox="gallery" data-srcset="" data-width="" data-height="" data-caption="{{value['title']}}" href="{{SITE_URL}}{{value.resim_link}}">
                <div class="resimlist_image">
                    <img class="img-responsive" src="{{islem.resimcek(value.resim_link,260,150,1)}}" alt="{{value.headlines}}">
                    <div class="buyutec"><i class="icon-zoom-in"></i></div>
                </div>
               <div class="resimlist_text">{{value.headlines}}</div>
            </a>
        </div>
    {%endfor%}

    </div>
</div>