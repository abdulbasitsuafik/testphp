{% extends 'base.tpl' %}
{% block main %}

<!--<meta http-equiv="refresh" content="2;URL={{SITE_URL}}">-->

<script>
function goBack() {
    window.history.back();
}
</script>

<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">404</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">404 </h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<div class="content success-page-cont" style="min-height: 519px;">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-6">

                <!-- Success Card -->
                <div class="card success-card">
                    <div class="card-body">
                        <div class="success-cont">
                            <i class="fas fa-check"></i>
                            <h3>{{lang.dil_sayfabulunamadidescription}}</h3>
                            <p>{{lang.dil_sayfabulunamadidescription}}</p>
                            <a href="invoice-view.html" class="btn btn-primary view-inv-btn">{{lang.dil_geridon}}</a>
                        </div>
                    </div>
                </div>
                <!-- /Success Card -->

            </div>
        </div>

    </div>
</div>
<!-- /Page Content -->
{% endblock %}

