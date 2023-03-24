{% extends 'base.tpl' %}

{% block main %}

        {% include 'sayfalar/dahil/content_headlines.tpl' %}

        <section class="content-section blog-page blog-listing">
            <div class="container">
            	{{islem.breadcrumbCek(active_page_details)}}
                <div class="row">

                    {% include 'sayfalar/dahil/content_form.tpl' %}
                    {% include 'sayfalar/dahil/content_video.tpl' %}

                </div>
            </div>
        </section>



{% endblock %}

