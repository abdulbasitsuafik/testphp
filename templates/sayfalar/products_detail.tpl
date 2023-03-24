{% extends 'base.tpl' %}
{% block main %}
{% set gelen_seflink = islem.urlcek(2) %}
{% set verioku = islem.sqlSorgu("SELECT * FROM "~prefix~"urun a JOIN "~prefix~"urun_dil b ON a.id=b.urun_id WHERE b.lang = :lang and b.seflink = :seflink order by a.id ASC limit 1",{":seflink":gelen_seflink,":lang":sessions.dil}) %}
{% set head_ids = active_page_details.head_ids|split(',') %}
{% include 'sayfalar/dahil/content_headlines.tpl' %}

<section class="inner-page">
    <div class="container">
        <div class="row">
            <div class="left-content col-md-10">
                <div class="post">

                    <span class="category"> {{islem.breadcrumbCek(active_page_details)}}</span><!-- Categories -->
                    <h1>{{active_page_details.title}}</h1>
                    <div class="post-desc">
                        <p>
                            {{active_page_details.description}}
                        </p>
                    </div>
                    <p>
                    <div class="about-charity-video" style="max-height: 500px;float:left;width: 600px;">
                        <img src="{{islem.resimcek(active_page_details.image,500,300,2)}}" alt="" /><!-- Post Image -->
                    </div>
                        {{active_page_details.content}}
                    </p>
                    <div class="post-image-list">
                        {% set gelen_veri = islem.sqlSorgu("SELECT * FROM "~PREFIX~"products_files WHERE head_id = :head_id AND (file_type= :type OR file_type= :type2 OR file_type= :type3 OR file_type= :type4)   order by rank ASC",{":head_id":active_page_details.head_id,":type":"jpg",":type2":"png",":type3":"jpeg",":type4":"gif"}) %}
                        {% for key,value in gelen_veri %}
                        <a href="{{SITE_URL}}{{value.file_path}}" class="html5lightbox post-image" title="">
                            <img src="{{islem.resimcek(value.file_path,400,300,2)}}" alt="" />
                        </a>
                        {%endfor%}

                    </div>
                    <div class="cloud-tags">
                        <h3 class="sub-head">Etiketler</h3>
                        {% for va in active_page_details.keywords|split(",") %}
                            <a title="" href="#">{{va}}</a>
                        {% endfor %}
                    </div><!-- Tags -->

                </div>



            </div>
        </div>
    </div>
</section>
{% endblock %}