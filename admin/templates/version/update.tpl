{% extends 'base.tpl' %}
{% block body %}
{% if errors %}
<div class="alert alert-close alert-success">
    <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
    <div class="bg-green alert-icon">
        <i class="glyph-icon icon-check"></i>
    </div>
    <div class="alert-content">
        <p>{{errors}}</p>
    </div>
</div>
{% endif %}
{% for value in islenenler %}
    <div class="alert alert-close alert-success">
        <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
        <div class="bg-green alert-icon">
            <i class="glyph-icon icon-check"></i>
        </div>
        <div class="alert-content">
            <!--<h4 class="alert-title">{{value}} Modülü Güncellendi</h4>-->
            <p><code>{{value}}</code> Tablosu Güncellendi</p>
        </div>
    </div>
{% endfor %}
{% endblock %}
