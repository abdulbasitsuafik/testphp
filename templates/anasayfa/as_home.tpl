{% extends 'base.tpl' %}
{% block main %}
<div id="layerslider-container-fw">
    <div id="layerslider" style="width: 100%; height: 530px; margin: 0px auto; ">

        <div class="ls-slide" data-ls="transition3d:53; timeshift:-1000;">
            <img src="{{SITE_URL}}uploads/1.png" class="ls-bg" alt="Slide background">
      </div><!-- Slide1 -->
        <div class="ls-slide" data-ls="transition3d:12;timeshift:-1000;">
            <img src="{{SITE_URL}}uploads/2.png" class="ls-bg" alt="Slide background">

        </div><!-- Slide2 -->
        <div class="ls-slide" data-ls="transition3d:35;timeshift:-1000;">
            <img src="{{SITE_URL}}uploads/3.png" class="ls-bg" alt="Slide background">
        </div><!-- Slide3 -->

    </div>
</div><!-- Layer Slider -->
<!--<section>
    <div class="container">
        <div class="message-box">
            <div class="message-box-title">
                <span><i class="icon-envelope-alt"></i></span>
                <p>Bize mesaj atın</p>
                <i class="icon-angle-up"></i>
            </div>
            <div class="message-form">
                <div id="message"></div>
                <form method="post" action="" name="contactform" id="contactform">
                    <input name="name" class="form-control" type="text" id="name" size="30" value=""  placeholder="AD soyad" />
                    <input name="email" class="form-control" type="text" id="email" size="30" value=""  placeholder="Email" />
                    <textarea name="comments" rows="3" id="comments" class="form-control"  placeholder="Mesajınız"></textarea>
                    <input type="submit" class="submit-btn submit" id="submit" value="Mesaj Gönder" />
                </form>
            </div>
        </div>
    </div>
</section>-->
<section class="inner-page">
    <div class="container">
        <div class="page-title">
            <h1>Özel <span>Ürünler</span></h1>
        </div><!-- Page Title -->
        <div class="row">
            <div class="left-content col-md-12">

                <div class="featured-products">
                    <div class="row">
                        {% set products = islem.sqlSorgu("SELECT * FROM "~PREFIX~"products a JOIN "~PREFIX~"products_langs b ON a.id=b.head_id WHERE b.lang= :lang order by a.rank ASC",{":lang":SESSION.lang}) %}

                        {% for value in products %}
                        <div class="col-md-3">
                            <img src="{{islem.resimcek(value.image,270,200)}}" alt="{{value.title}}" style="max-height: 200px;cursor:pointer;" onclick="location.href='{{SITE_URL}}{{value.seflink}}'"/>
                            <h4>{{value.title}}</h4>
                            <div class="ratings">
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star"></i>
                                <i class="icon-star-empty"></i>
                            </div>
                            <div class="product-price">
                                <span>TL {{value.price + 100}}</span>
                                <p>TL {{value.price }}</p>
                                <a href="{{SITE_URL}}{{value.seflink}}" title="">İncele</a>
                            </div>
                        </div>
                        {% endfor %}
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

{% endblock %}