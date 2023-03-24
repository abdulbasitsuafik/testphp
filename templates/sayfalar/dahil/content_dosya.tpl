<div class="coklu_dosya">
    <div class="row">

            {% set url_system = sessions.url_system %}
            {% if url_system == "headlines" %} {% set gelen_id = active_page_details.head_id %} {% set tablo = url_system %}
            {% elseif url_system == "headlines" %} {% set gelen_id = active_page_details.head_id %} {% set tablo = url_system %}
            {% elseif url_system == "hizmet_headlines" %} {% set gelen_id = active_page_details.head_id %}{% set tablo = "headlines" %}
            {% elseif url_system == "proje_headlines" %} {% set gelen_id = active_page_details.head_id %}{% set tablo = "headlines" %}
            {% elseif url_system == "urun" %} {% set gelen_id = active_page_details.urun_id %}{% set tablo = url_system %}
            {% elseif url_system == "proje" %} {% set gelen_id = active_page_details.proje_id %}{% set tablo = url_system %}
            {% elseif url_system == "hizmet" %} {% set gelen_id = active_page_details.hizmet_id %}{% set tablo = url_system %}
            {% elseif url_system == "etkinlik" %} {% set gelen_id = active_page_details.etkinlik_id %}{% set tablo = url_system %}
            {% elseif url_system == "makale" %} {% set gelen_id = active_page_details.makale_id %}{% set tablo = url_system %}
            {% endif %}
            {% set dosyalar = islem.sqlSorgu("SELECT * FROM "~prefix~url_system~"_dosya a JOIN "~prefix~url_system~"_dosya_ayrinti b ON a.id=b.dosya_id WHERE a."~tablo~"_id = :head_id and b.lang = :lang",{":head_id":gelen_id,":lang":sessions.dil}) %}
            {% for key,value in dosyalar %}
            {% if value.uzanti ==".pdf" %} {% set icon = "fa fa-file-pdf-o" %}
            {% elseif value.uzanti ==".doc" or value.uzanti ==".docx" %}{% set icon = "fa fa-file-word-o" %}
            {% elseif value.uzanti ==".ppt" %}{% set icon = "fa fa-file-powerpoint-o" %}
            {% elseif value.uzanti ==".zip" or value.uzanti ==".rar" %}{% set icon = "fa fa-file-archive-o" %}
            {% elseif value.uzanti ==".xls" or value.uzanti ==".xlsx" %}{% set icon = "fa fa-file-excel-o" %}
            {% endif %}

		    <div class="col-md-3 col-sm-4 col-xs-12">
			    <div class="dosya_liste">
			        <a href="{{SITE_URL}}{{value.dosya_link}}" download="{{value.dosya_link}}"  rel="alternate">
		            <span class="dosya-icon"><i class="{{icon}}"></i></span>
					  <div class="dosya-description">
					    	<div class="headlines"><i class="{{icon}}"></i>{{islem.kisalt(value.headlines,34)}}</div>
					        <span class="dosya-indir-icon">
					          <div class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></div>
					        </span>
					  </div>
			        </a>
			    </div>
		    </div>

	    {%endfor%}
    </div>
    <div class="clear"></div>
</div>