{% extends 'base.tpl' %}

{% block main %}

{{ islem.altsayfa_kontrol(active_page_details,true) }}


{% include 'sayfalar/dahil/content_headlines.tpl' %}

<!--about-section-->
<section class="content-section">
    <div class="container">
    	{{islem.breadcrumbCek(active_page_details)}}
        <div class="row">

            {{active_page_details.content}}

           {% include 'sayfalar/dahil/content_form.tpl' %}


        </div>
    </div>
</section>
<!--about-section end-->


{% endblock %}

