{% extends 'base.tpl' %}

{% block main %}
    {% set headlinesoku = islem.sqlSorgu("SELECT * FROM "~PREFIX~"headlines a JOIN "~PREFIX~"headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and b.head_id= :head_id order by a.rank ASC limit 1",{":lang":SESSION.lang,":head_id":"1"}) %}
   {% set siniflar = islem.sqlSorgu("SELECT * FROM "~PREFIX~"headlines a JOIN "~PREFIX~"headlines_langs b ON a.id=b.head_id WHERE b.lang= :lang and a.top_head_id= :top_head_id AND a.status = :status  order by a.rank ASC",{":lang":SESSION.lang,":top_head_id":"3",":status":1}) %}

    <div class="container">

        <div class="row">
            <!-- =========================Start Col left section ============================= -->
            <aside  class="col-md-4 col-sm-4">
                <div class="col-left">
                    <h3>İçerik</h3>
                    <ul class="submenu-col">
                        {% for value in siniflar %}
                            <li><a {% if value.seflink == active_page_details.seflink %} id="active" {% endif %} href="{{SITE_URL}}{{value.seflink}}">{{value.title}}</a></li>
                        {% endfor %}
                    </ul>

                    <hr>

                </div>

            </aside>

            <section class="col-md-8 col-sm-8">
                <div class="col-right">
                    <div class="main-img">
                        {% if active_page_details.image %}
                        <div class="about-charity-video img-responsive">
                            <img src="{{islem.resimcek(active_page_details.image,748,315)}}" alt="{{active_page_details.title}}" />
                        </div>
                        {% endif %}
                        <p class="lead">{{active_page_details.title}}</p>
                    </div>
                    <hr>

                    <!-- <div class="text-center">
                        <ul class="pagination">
                            <li><a href="#">Prev</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">Next</a></li>
                        </ul>
                    </div>end pagination-->

                </div><!-- end col right-->

            </section>

        </div><!-- end row-->
    </div> <!-- end container-->
{% endblock %}
