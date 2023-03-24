{% extends 'base.tpl' %}
{% block main %}

<style type="text/css">
.modal-body {
	position: relative;
	padding: 15px;
	display: inline-block;
}
</style>

{% include 'sayfalar/dahil/content_headlines.tpl' %}

<section class="content_section">
    <div class="container">
        {{islem.breadcrumbCek(active_page_details)}}
        <div class="row">

        	<div class="ekibim">
                    {% set kadrolar = islem.sqlSorgu("SELECT * FROM "~prefix~"kadro") %}
                    {% for ke,val in kadrolar %}
        		<div class="liste">
        		<h3>{{val.adi}}</h3>	
                        {% set kadro_grup_id  = val.id %}
                        {% set ekibimiz = islem.sqlSorgu("SELECT * FROM "~prefix~"kadro_kisi a JOIN "~prefix~"kadro_kisi_dil b ON a.id=b.kisi_id WHERE a.kadro_id = :kadro_id and b.lang= :lang order by a.rank ASC",{":kadro_id":kadro_grup_id,":lang":sessions.dil}) %}
                                <div class="row">
                                     {% for key,value in ekibimiz %}
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="ekibimiz_listele">
                                                    <button type="button" class="detay" onclick="modalKadro('{{value.kisi_id}}')"><i class="icon-zoom-in"></i></button>
                                                    <div class="resim"><img src="{{islem.resimcek(value.presmi,370,370,1)}}" alt="{{value.kisi_adi}}"/></div>
                                                    <div class="description">
                                                            <h4>{{value.kisi_adi}}</h4>
                                                            <h5>{{value.meslek}}</h5>
                                                            <ul class="sosyal">
                                                                    <li><a href="{{value.facebook}}"><i class="icon-facebook-2"></i></a></li>
                                                                    <li><a href="{{value.twitter}}"><i class="icon-twitter-2"></i></a></li>
                                                                    <li><a href="{{value.instagram}}"><i class="icon-instagram-1"></i></a></li>
                                                                    <li><a href="{{value.pinterest}}"><i class="icon-pinterest"></i></a></li>
                                                            </ul>
                                                    </div>
                                            </div>
                                        </div>
                                     {% endfor %}
		        	</div>
	        	</div>
                    {% endfor %}
        	</div>


            <div class="yazi">{{active_page_details.content}}</div>
            {% include 'sayfalar/dahil/content_resim.tpl' %}
            {% include 'sayfalar/dahil/content_dosya.tpl' %}
            {% include 'sayfalar/dahil/content_video.tpl' %}
        </div>
    </div>
</section>
<script>
    function modalKadro(id){
        $.ajax({
            type: "POST",
            url: "{{SITE_URL}}genel/modalKadro",
            data: {id:id},
            success: function(data) {
                $(".modalgetir").html(data);
                $("#modalKadro-"+id).modal();
            }
        });
    }
</script>
{% endblock %}



