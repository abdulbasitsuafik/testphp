{% extends 'base.tpl' %}
{% block main %}

{{ islem.altsayfa_kontrol(active_page_details,true) }}
{% include 'sayfalar/dahil/content_headlines.tpl' %}

<section class="content_section">
    <div class="container">
        {{islem.breadcrumbCek(active_page_details)}}
        <div class="row">
   
            <table class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                    <th>{{lang.dil_reffirmaadi}}</th>
                    <th>{{lang.dil_refdescription}}</th>
                    <th>{{lang.dil_refsehir}}</th>
                    <th>{{lang.dil_reftarih}}</th>
                    <th style="width: 5%;">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    {% set gelen_veri = islem.sqlSorgu("SELECT * FROM "~prefix~"referanslar order by rank ASC") %}
                    {% for key,value in gelen_veri %}
                    <tr>
                        <td>{{value.firma_adi}}</td>
                        <td>{{value.yapilan_is}}</td>
                        <td>{{value.sehir}}</td>
                        <td>{{ value.tarih|date("d-m-Y") }}</td>
                        <td><a href="#" class="btn btn-default">Resimler</a></td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>

        </div>
    </div>
</section>

{% endblock %}



