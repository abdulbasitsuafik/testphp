<div class="coklu_video">
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
{% set resim_oku = islem.sqlSorgu("SELECT * FROM "~prefix~url_system~"_video a JOIN "~prefix~url_system~"_video_ayrinti b ON a.id=b.video_id WHERE a."~tablo~"_id = :head_id and b.lang= :lang order by a.rank ASC",{":head_id":gelen_id,":lang":sessions.dil}) %}
{% for key,value in resim_oku %} 
 
<div class="col-md-3 col-sm-4 col-xs-12">
    <div class="video_liste">
        <a data-fancybox="gallery" data-srcset="" data-width="" data-height="" data-caption="{{value['title']}}" href="{{value.video_link}}">
            <div class="video">
                <img class="img-responsive" src="{{islem.videoresim_getir(value.video_link)}}" alt="{{value.title}}">
                <div class="play"><i class="icon-play-outline"></i></div>
            </div>
            <div class="resimlist_text">{{value.headlines}}</div>
        </a>
    </div>
</div>
 
{%endfor%}
</div>
<div class="clear"></div>
</div>