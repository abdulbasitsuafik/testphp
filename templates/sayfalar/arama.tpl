{% extends 'base.tpl' %}

{% block main %}
<style type="text/css">
    .filtre_bilgi .tarihbilgi{color:#df0013;font-weight:700}
    .filtre_bilgi .kelimebilgi{color:#5d5d5d;font-size:13px}
    .arasonuc-headlines{font-weight:700;font-size:16px;margin-top:20px}
    .arasonuc-list{margin:0px;padding:0px;margin-top:10px;}
    .arasonuc-list li a{line-height:24px;overflow:hidden;height:25px;width:100%;text-overflow:ellipsis;white-space:nowrap;display:block;color: #1a202c;}
    .arasonuc-list li a:hover{text-decoration:underline}
</style>


        <!--about-section-->
        <section class="content-section" style="min-height: 350px;">
            <div class="container">
                    {{islem.breadcrumbCek(active_page_details)}}
                    <h1 style="margin-bottom: 0px;">Arama Sonuçları</h1>
                    <div class="filtre_bilgi">
                        <div class="kelimebilgi"><b>Aranacak Kelime :</b>
                            {{gelen_kelime}}
                        </div>
                    </div>

                    <ul class="arasonuc-list">

                        {% for key,value in sonuclar %}
                        <li><a href="{{value.link}}" target="_blank"><i class="fa fa-caret-right"></i> {{value.headlines}}</a></li>
                        {%endfor%}

                    </ul>


            </div>
        </section>
        <!--about-section end-->


{% endblock %}

