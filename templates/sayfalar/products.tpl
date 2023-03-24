{% extends 'base.tpl' %}

{% block main %}

{% set gelen_headlinesid = active_page_head_id %}
<div class="content_headlines" style="background: url('{{active_page_details.image}}') center;">
    <div class="kararti"></div>
    <div class="container">
        <div class="row">
            <h1>{{active_page_details.title}}</h1>
        </div>
    </div>
</div>
<section class="content-section content_sol_menu9">
        <div class="container">
            <div class="row">

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="solbolum">{% include 'sayfalar/dahil/sidebar_menu.tpl' %}</div>
                </div>

                <div class="col-md-9 col-sm-12 col-xs-12">
                    {{islem.breadcrumbCek(active_page_details)}}

                    {% set gelen_top_head = islem.sqlSorgu("SELECT * FROM "~prefix~"headlines a JOIN "~prefix~"headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and a.top_head_id = :top_head_id order by a.rank ASC",{":top_head_id":gelen_headlinesid,":lang":sessions.lang}) %}
                    
                    {% if gelen_top_head is not empty %}
                         <div class="headlines_listesi">
                            {% for key,value in gelen_top_head %}
                              {% set ust_headlines_varmi = islem.sqlSorgu("SELECT * FROM "~prefix~"headlines a JOIN "~prefix~"headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and b.head_id = :head_id order by a.rank ASC",{":head_id":value.top_head_id,":lang":sessions.dil}) %}
                              {% if ust_headlines_varmi is not empty %}
                                {% set ust_link = ust_headlines_varmi[0]["seflink"]~"/" %}
                              {% endif %}
                            <div class="col-sm-6 col-md-4">
                                <!-- Start Single portfolio -->
                                <div class="urunlist">
                                    <a href="{{SITE_URL}}{{ust_link}}{{value.seflink}}" class="">
                                        <div class="urunlist_resim">
                                            <img src="{{islem.resimcek(value.headlines_resmi,300,200,1)}}" alt="{{value.headlines}}">
                                            <div class="icon"><i class="icon-link-2"></i></div>
                                        </div>
                                        <div class="urunlist_headlines">{{value.headlines}}</div>
                                    </a>
                                </div>
                                <!-- End Single portfolio -->
                            </div>
                            {% endfor %}
                            
                        </div>
                     {% else %}
                          <div class="headlines_listesi">
                                 <h1>{{verioku[0].headlines}}</h1>
                                    {{verioku[0].content}}
                                    <div class="row">
                                    {% set resimler = islem.sqlSorgu("SELECT * FROM "~prefix~"headlines_resim a JOIN "~prefix~"headlines_resim_ayrinti b ON a.boyut_kod=b.boyut_kod WHERE b.lang = :lang and a.head_id = :head_id and a.boyut= :boyut order by a.rank ASC",{":head_id":verioku[0]["head_id"],":lang":sessions.dil,":boyut":1}) %}
                                    {% for value in resimler %}
                                       
                                        <div class="col-sm-6 col-md-4">
                                            <!-- Start Single portfolio -->
                                            <div class="urunlist">
                                           
                                                <a data-fancybox="gallery" data-srcset="" data-width="" data-height="" data-caption="" href="{{SITE_URL}}{{value.resim_link}}">
                                                    <div class="urunlist_resim">
                                                        <img src="{{islem.resimcek(value.resim_link,'300','200','1')}}" alt="{{value.headlines}}"/>
                                                        <div class="icon"><i class="icon-zoom-in-4"></i></div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!-- End Single portfolio -->
                                        </div>
                                    {%endfor%}
                                </div>

                                    <div class="clear"></div>
                            </div>
                    {% endif %}

                    <div class="urun_listesi"  id="gried-view">
                        {% set head_ids = "%,"~gelen_headlinesid~",%" %}
                        {% set gelen_urun  = islem.sqlSorgu("SELECT * FROM "~prefix~"urun a JOIN "~prefix~"urun_dil b ON a.id=b.urun_id WHERE b.lang = :lang and a.head_ids LIKE :head_ids order by a.rank ASC",{":head_ids":head_ids,":lang":sessions.dil}) %}
                        
                        {% for key,value in gelen_urun  %}

                        <div class="col-sm-6 col-md-4">
                            <!-- Start Single portfolio -->
                            <div class="urunlist">
                                <a href="{{SITE_URL}}{{value.seflink}}" class="">
                                <div class="urunlist_resim">
                                    <img src="{{islem.resimcek(value.urun_resmi,300,300,2)}}" alt="{{value.headlines}}">
                                    <div class="icon"><i class="icon-link-2"></i></div>
                                </div>
                                <div class="urunlist_headlines">{{value.headlines}}</div>
                                </a>
                            </div>
                            <!-- End Single portfolio -->
                        </div>

                        {% endfor %}

                    </div>

                </div>
 
              </div>
            </div>
        </div>
</section>



{% endblock %}

