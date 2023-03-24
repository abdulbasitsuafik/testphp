{% extends 'base.tpl' %}

{% block main %}


{% include 'sayfalar/dahil/content_headlines.tpl' %}


        <!--about-section-->
        <section class="content-section">
            <div class="container">
                {{islem.breadcrumbCek(active_page_details)}}
                <div class="row">
                    {{active_page_details.content}}
                </div>
            </div>
        </section>
        <!--about-section end-->

        <section class="fact-counter-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="single-fact-counter clearfix">
                    <div class="text-box">
                        <div class="icon-box">
                            <i class="fa fa-users"></i>
                        </div>
                        <span class="number">
									<span class="timer" data-from="50" data-to="20000" data-speed="5000" data-refresh-interval="50">20000</span>+
                                </span>
                        <p>TOTAL EMPLOYES</p>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-fact-counter clearfix">
                    <div class="text-box">
                        <div class="icon-box">
                            <i class="fa fa-smile-o"></i>
                        </div>
                        <span class="number">
									<span class="timer" data-from="5" data-to="700" data-speed="5000" data-refresh-interval="50">700</span>+
                                </span>
                        <p>HAPPY CUSTOMERS</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-fact-counter clearfix">
                    <div class="text-box">
                        <div class="icon-box">
                            <i class="fa fa-clone"></i>
                        </div>
                        <span class="number">
									<span class="timer" data-from="10" data-to="2450" data-speed="5000" data-refresh-interval="50">2450</span>+
                                </span>
                        <p>FINISHED PROJECTS</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="single-fact-counter clearfix bdrn">
                    <div class="text-box">
                        <div class="icon-box">
                            <i class="fa fa-trophy"></i>
                        </div>
                        <span class="number">
									<span class="timer" data-from="5" data-to="468" data-speed="5000" data-refresh-interval="50">468</span>+
                                </span>
                        <p>Awards Won</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{% endblock %}

