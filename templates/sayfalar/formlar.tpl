{% extends 'base.tpl' %}
{% block main %}
<div class="iletisim_listele1_maps">
    <div class="maps">{{sitebilgi.harita}}</div>
</div>
<section class="content_section">
    <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="row">
                        {{islem.formCek(form_id)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{% endblock %}