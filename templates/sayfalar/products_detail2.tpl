{% extends 'base.tpl' %}
{% block main %}
{% set gelen_seflink = islem.urlcek(2) %}
{% set verioku = islem.sqlSorgu("SELECT * FROM "~prefix~"urun a JOIN "~prefix~"urun_dil b ON a.id=b.urun_id WHERE b.lang = :lang and b.seflink = :seflink order by a.id ASC limit 1",{":seflink":gelen_seflink,":lang":sessions.dil}) %}
{% set head_ids = active_page_details.head_ids|split(',') %}
{% include 'sayfalar/dahil/content_headlines.tpl' %}
<section class="content-section content_sol_menu10">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="solbolum">
                        {% include 'sayfalar/dahil/solmenu_urunler.tpl' %}
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    {{islem.breadcrumbCek(active_page_details)}}
                     <div class="row">
                        <div class="urundetay_listesi">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="resim">
                                    <a data-fancybox="gallery" data-srcset="" data-width="" data-height="" data-caption="{{value['title']}}" href="{{SITE_URL}}{{active_page_details.urun_resmi}}">
                                        <img alt="{{active_page_details.title}}" src="{{islem.resimcek(active_page_details.urun_resmi,600,600)}}" class="img-responsive">
                                    </a>
                                </div>
                            </div> 
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="yazi"> 
                                <h1>{{active_page_details.title}}</h1>
                                <p>{{active_page_details.content}}</p>
                            </div>  
                        </div>
                        </div>
                    </div>
                    <div class="coklu_resimler">
                        <div class="row">
                            {% set gelen_veri = islem.sqlSorgu("SELECT * FROM "~prefix~"urun_resim a JOIN "~prefix~"urun_resim_ayrinti b ON a.boyut_kod=b.boyut_kod WHERE a.urun_id= :urun_id and b.lang= :lang",{":urun_id":active_page_details.urun_id,":lang":sessions.dil}) %}
                            {% for key,value in gelen_veri %}
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12  mb-10" style="display: inline-block;">
                                <div class="resimlist_image">
                                <a data-fancybox="gallery" data-srcset="" data-width="" data-height="" data-caption="{{value['title']}}" href="{{SITE_URL}}{{value.resim_link}}">
                                    <img src="{{islem.resimcek(value.resim_link,400,400,1)}}" alt="{{value.headlines}}">
                                    <div class="buyutec"><i class="icon-zoom-in"></i></div>
                                </a>
                            </div>
                            </div>
                            {%endfor%}
                            <div class="clear"></div>
                        </div>
                    </div> 
                {% set benzerUrunler = islem.sqlSorgu("SELECT * FROM "~prefix~"urun a JOIN "~prefix~"urun_dil b ON a.id=b.urun_id WHERE b.lang= :lang and a.head_ids = :head_ids order by b.urun_id DESC" ,{":lang":sessions.dil,":head_ids":active_page_details.head_ids}) %}
                {% if benzerUrunler|length > 100 %} 
                    <div class="urun-detay-slider-bg">
                        <div class="headlines"></div>
                            <div class="swiper-container diger_urunler_slider">
                                <div class="swiper-wrapper">
                                {% for value in benzerUrunler %}
                                    {% if  value.urun_id != active_page_details.urun_id %}
                                        <div class="swiper-slide">
                                            <a href="{{SITE_URL}}{{value.seflink}}">
                                                <div class="resim"><img src="{{islem.resimcek(value.urun_resmi,200,200,1)}}" alt="{{value.headlines}}" /></div>
                                            </a>
                                        </div>
                                        {% endif %}
                                {% endfor %}
                                </div>
                                <!-- Add Pagination -->
                                <div style="display: none;" class="swiper-pagination"></div>
                            </div>                        
                            <div style="display: block;" class="swiper-button-next"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
                            <div style="display: block;" class="swiper-button-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>


                        <script>
                            var swiper1_diger_urunler_slider = new Swiper('.diger_urunler_slider', {
                                pagination: '.swiper-pagination',
                                nextButton: '.swiper-button-next',
                                prevButton: '.swiper-button-prev',
                                slidesPerView: 6,
                                paginationClickable: true,
                                spaceBetween: 30,
                                autoplay:4000,
                                freeMode: true,
                                loop:true,
                                breakpoints:{ 
                                    600 : { slidesPerView: 2, spaceBetween: 10 }, 
                                    800 : { slidesPerView: 1, spaceBetween: 20 }, 
                                    1024 : { slidesPerView: 3, spaceBetween: 30 } 
                                }
                            });
                        </script>

                    </div>
                    {% endif %}
              </div>
            </div>
        </div>
</section>
{% endblock %}