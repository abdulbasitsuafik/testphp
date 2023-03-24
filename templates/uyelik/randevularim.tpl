{% extends 'base.tpl' %}
{% block main %}
{% set uye = islem.sqlSorgu("SELECT * FROM "~prefix~"uyeler WHERE id= :id",{":id":sessions.uye_id}) %}
{% set randevular = islem.sqlSorgu("SELECT * FROM "~prefix~"randevular WHERE uye_id= :uye_id",{":uye_id":sessions.uye_id}) %}
{% set gecenrandevular = islem.sqlSorgu("SELECT * FROM "~prefix~"randevular WHERE uye_id= :uye_id and randevu_tarihi= :randevu_tarihi",{":uye_id":sessions.uye_id,":randevu_tarihi":"now"}) %}
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#yeni">Yeni Randevularım</a></li>
    <li><a data-toggle="tab" href="#gecmis">Geçmiş Randevularım</a></li>
  </ul>

  <div class="tab-content">
    <div id="yeni" class="tab-pane fade in active">   
			  <ul class="list-group">
          {% for key,value in randevular %}
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {% set checkuplar = islem.sqlSorgu("SELECT * FROM "~prefix~"checkup a JOIN "~prefix~"checkup_dil b ON a.id=b.checkup_id WHERE b.checkup_id= :checkup_id and b.lang= :lang",{":checkup_id":value.checkup_id,":lang":sessions.dil}) %}
            {{ checkuplar[0].headlines }}
            <span class="badge badge-primary badge-pill">{{islem.tarih(value.randevu_tarihi)}}</span>
            <span class="badge badge-danger badge-pill">{{value.onay}}</span>
             <span class="badge badge-danger badge-pill">{{value.durum}}</span>
              <span class="badge badge-danger badge-pill">tekrar randevu al</span>
          </li>
        {% endfor %}
      </ul>
    </div>
    <div id="gecmis" class="tab-pane fade">
      <ul class="list-group">
          {% for key,value in gecenrandevular %}
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {% set checkuplar = islem.sqlSorgu("SELECT * FROM "~prefix~"checkup a JOIN "~prefix~"checkup_dil b ON a.id=b.checkup_id WHERE b.checkup_id= :checkup_id and b.lang= :lang",{":checkup_id":value.checkup_id,":lang":sessions.dil}) %}
            {{ checkuplar[0].headlines }}
            <span class="badge badge-primary badge-pill">{{islem.tarih(value.randevu_tarihi)}}</span>
            <span class="badge badge-danger badge-pill">{{value.onay}}</span>
             <span class="badge badge-danger badge-pill">{{value.durum}}</span>
              <span class="badge badge-danger badge-pill">tekrar randevu al</span>
          </li>
        {% endfor %}
      </ul>
    </div>
  </div>
{% endblock %}



