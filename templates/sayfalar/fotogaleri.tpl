{% extends 'base.tpl' %}

{% block main %}

<link rel="stylesheet" type="text/css" href="{{THEME_PATH}}assets/css/galeri.css">
<div class="galeri_genel_tekstil6">
                <div class="container">
                    {{islem.breadcrumbCek(active_page_details)}}
                    <div class="row">
                        <div id="exTab2" class="container"> 
                            {% set headlinesler = islem.sqlSorgu("SELECT * FROM "~prefix~"headlines a JOIN "~prefix~"headlines_langs b ON a.id=b.head_id WHERE b.lang = :lang and a.top_head_id = :top_head_id order by a.rank ASC",{":top_head_id":0,":lang":sessions.dil}) %}
                            <ul class="nav nav-tabs">
                                <li class="active"><a id="tabAll" href="#" data-toggle="tab">{{lang.dil_tumunugor}}</a></li>
                                {% for key,value in headlinesler %}
                                    <li class=""><a href="#{{value.seflink}}" data-toggle="tab">{{value.headlines}}</a></li>
                                {% endfor %}
                            </ul>
                            <div class="tab-content " >
                                {% for key2,value2 in headlinesler %}
                                    <div class="tab-pane " id="{{value2.seflink}}"> 
                                        {% set resimler = islem.sqlSorgu("SELECT * FROM "~prefix~"headlines_resim a JOIN "~prefix~"headlines_resim_ayrinti b ON a.boyut_kod=b.boyut_kod WHERE b.lang = :lang and a.boyut= :boyut and a.head_id= :head_id order by a.rank ASC limit 1,100",{":lang":sessions.dil,":boyut":1,":head_id":value2.head_id}) %}
                                        {% for value in resimler %}                                        
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <div class="row">
                                                        <div class="gallery-item">
                                                            <img src="{{islem.resimcek(value.resim_link,378,278,1)}}" alt="{{value.headlines}}">
                                                            <div class="overlay">
                                                                <div class="box">      
                                                                    <div class="image-view">
                                                                        <div class="descriptiona">
                                                                             <a data-fancybox="gallery[{{value2.seflink}}]" data-srcset="{{SITE_URL}}{{value.resim_link}}" data-width="" data-height="" data-caption="" href="{{SITE_URL}}{{value.resim_link}}">
                                                                                 <i class="fa fa-search-plus" aria-hidden="true"></i>
                                                                             </a>
                                                                            <h1></h1>
                                                                            <h2></h2>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {%endfor%}
                                    </div>
                                {% endfor %}
                        </div>
                    </div>
                <div class="galeri_detaylar_button">
                    <a href="buldan-galeri" class="degisenDil" data-content="dil_tumunugor">{{lang.dil_tumunugor}}</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">        
        $( document ).ready(function() {
            document.getElementById("tabAll").click();
        });
        $('#tabAll').on('click',function(){
          $('#tabAll').parent().addClass('active');  
          $('.tab-pane').addClass('active in');  
          $('[data-toggle="tab"]').parent().removeClass('active');
        });
    </script>



{% endblock %}

