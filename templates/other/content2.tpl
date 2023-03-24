{% extends 'base.tpl' %}
{% block main %}




<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{active_page_details.title}}</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">{{active_page_details.title}}</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h5>{{active_page_details.title}}</h5>
                <p>{{active_page_details.content}}</p>
                {% include 'sayfalar/dahil/content_form.tpl' %}
                {% include 'sayfalar/dahil/content_resim.tpl' %}
                {% include 'sayfalar/dahil/content_dosya.tpl' %}
                {% include 'sayfalar/dahil/content_video.tpl' %}
            </div>
        </div>
    </div>

</div>
<!-- /Page Content -->

{% endblock %}



