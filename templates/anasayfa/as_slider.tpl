{% extends 'base.tpl' %}
{% block main %}
<!---Slider Bölüm Başlangıç-->

<link href="{{THEME_PATH}}assets/css/slider.css" rel="stylesheet">
<link rel="stylesheet" href="{{THEME_PATH}}assets/swiper/css/swiper.min.css">

<div class="swiper-container as_banner">
    <div class="swiper-wrapper">

        {% if islem.mobilKontrol() =="0" %}
            {% for key,value in slayt %}     
            <div class="swiper-slide"> 
                <img class="img-responsive" src="{{SITE_URL}}{{ value.bg }}" alt="{{ value.slogan1 }}"/>
                <div class="banner_bg">
                    <div class="description">
                        <h3>{{ value.slogan1 }}</h3>
                        <h4>{{ value.slogan2 }}</h4>
                        <h5>{{ value.slogan3 }}</h5>
                         {% if value.link1 !=""%}
                            <a class="detay1 hidden-xs hidden-sm" href="{{value.link1}}"><i class="licon-arrow-right"></i>{{value.buton1}}</a>
                        {% endif %}
                        {% if value.link2 !=""%}
                            <a class="detay2 hidden-xs hidden-sm" href="{{value.link2}}"><i class="licon-car2"></i>{{value.buton2}}</a>
                        {% endif %}
                    </div>
                </div>
            </div>
            {% endfor %}
        {% else %}
            {% for key,value in slayt %}     
            <div class="swiper-slide"> 
                <img class="img-responsive" src="{{SITE_URL}}{{ value.bgmobil }}" alt="{{ value.slogan1 }}"/>
                <div class="banner_bg">
                    <div class="description">
                        <h3>{{ value.slogan1 }}</h3>
                        <h4>{{ value.slogan2 }}</h4>
                        <h5>{{ value.slogan3 }}</h5>
                         {% if value.link1 !=""%}
                            <a class="detay1 hidden-xs hidden-sm" href="{{value.link1}}"><i class="licon-arrow-right"></i>{{value.buton1}}</a>
                        {% endif %}
                        {% if value.link2 !=""%}
                            <a class="detay2 hidden-xs hidden-sm" href="{{value.link2}}"><i class="licon-car2"></i>{{value.buton2}}</a>
                        {% endif %}
                    </div>
                </div>
            </div>
            {% endfor %}
        {% endif %}

    </div>

    <div class="swiper-pagination"></div>
    <div style="display: none;" class="swiper-button-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
    <div style="display: none;" class="swiper-button-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>

</div>

  
<script src="{{THEME_PATH}}assets/js/swiper.min.js"></script>

<script>
var swiper1_as_banner = new Swiper('.as_banner', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    autoplay: 4000,
	loop:true,
    spaceBetween: 30
});
</script>
<img src="{{ islem.resimcek(slayt[0].bg,800,500,1) }}" alt="{{title}}">
<!---Slider Bölüm Son-->
{% endblock %}