{% extends 'base.tpl' %}

{% block main %}

<link href="{{THEME_PATH}}assets/css/style.css" rel="stylesheet">

 <section class="gallery-section">

            <div class="container">

            <div class="galeri_headlines">{{lang.dil_hizmetheadlinesleri}}</div>

                <div class="sortable-masonry">

                    <div class="filters text-center">

                        <ul class="filter-tabs filter-btns clearfix">

                            <li class="active filter" data-role="button" data-filter=".all"><span class="txt">{{lang.dil_tumunugor}}</span></li>
                            
                                <li class="filter" data-role="button" data-filter=".headlines-{{value.head_id}}"><span class="txt">{{value.headlines}}</span></li>
                            

                        </ul>

                    </div>



                    <div class="row items-container">
                        {% set urunler = "bos" %}
                        {% for key,value in urunler %}
                        {% set ust_headlinesogren = "bos" %}
                        <div class="col-md-4 col-sm-4 col-xs-12 all headlines-{{ ust_headlinesogren }}">
                            <!-- Start single-item -->
                            <div class="gallery-item">
                                <img src="{% if value.urun_resmi|length > 0 %}{{islem.resimcek(value.urun_resmi),370,270,1}}{%endif%}" alt="{{value.headlines}}">
                                <!-- Start overlay -->
                                <div class="overlay">
                                    <div class="box">
                                        <div class="image-view">
                                            <a href="{{SITE_URL}}urun-gruplari/detay/{{value.seflink}}"><i class="fa fa-link" aria-hidden="true"></i></a>
                                            <div class="descriptiona">
	                                            <h3>{{value.headlines}}</h3>
	                                            <h4>{{value.headlines}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End overlay -->
                            </div>
                            <!-- End single-item -->
                        </div>
                        {%endfor%}

                    </div>
                </div>

            </div>



			<div class="tumunugorbg hidden">	

				<a class="tumunugor" href="#">{{lang.dil_tumunugor}}<i class="fa fa-arrow-right" aria-hidden="true"></i></a>

			</div>

                       

        </section>





<script src="{{THEME_PATH}}assets/js/isotope.js"></script>

<script src="{{THEME_PATH}}assets/js/custom.js"></script>

{% endblock %}