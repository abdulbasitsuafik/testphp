{% extends 'base.tpl' %}
{% block main %}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>{{active_page_details.title}}</h1>
            <p>{{active_page_details.content}}</p>
            <!--{{islem.breadcrumbCek(active_page_details)}}-->
        </div>
    </div><!-- end row-->
</div> <!-- end container-->


{% endblock %}

