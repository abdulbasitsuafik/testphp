{% extends 'base.tpl' %}
{% block main %}

<section class="inner-page">
    <div class="container">
        <div class="page-title">
            <h1>404 </h1>
        </div><!--Page Title-->
    </div>
    <section class="block remove-bottom">
        <div class="container">
            <div class="row">
                <div class="about-charity">
                    <div class="container">

                        <div class="row">
                            <div class="about-charity-desc col-md-7">
                                <h2>404</h2>
                               <p>{{lang.dil_sayfabulunamadidescription}}</p>

                                <a href="{{SITE_URL}}" class="btn btn-primary view-inv-btn">{{lang.dil_geridon}}</a>
                            </div>
                            <div class="col-md-5">
                                <div class="about-charity-video">
                                    <img src="{{THEME_PATH}}lifeline/images/about-video.jpg" alt="" />
                                </div>
                            </div> <!-- Video -->
                        </div>
                    </div>
                </div> <!--About Charity-->
            </div>
        </div>
    </section>
</section>



{% endblock %}



