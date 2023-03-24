{% extends 'base.tpl' %}
{% block main %}

<div class="hidden-sm hidden-md hidden-lg">
<style type="text/css">
  .btn{border-radius: 0px;}
</style>
  <div class="btn-group btn-group-justified" role="group" aria-label="...">
    <div class="btn-group" role="group">
      <a href="tel:{{sitebilgi.mobil_telefon}}">
        <button type="button" class="btn btn-danger vel"><span class="fa fa-phone btn-lg" aria-hidden="true"></span></button>
      </a>
    </div>
    <div class="btn-group" role="group">
      <a href="{{sitebilgi.mobil_harita}}" target="_top">
        <button type="button" class="btn btn-primary vel"><span class="fa fa-map-marker btn-lg" aria-hidden="true"></span></button>
      </a>
    </div>
    <div class="btn-group" role="group">
      <a href="mailto:{{sitebilgi.mobil_email}}" target="_blank">
        <button type="button" class="btn btn-success vel"><span class="fa fa-envelope btn-lg" aria-hidden="true"></span></button>
      </a>
    </div>
  </div>
</div>

{% endblock %}