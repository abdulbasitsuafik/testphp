{% extends 'base.tpl' %}
{% block main %}
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#olustur">Şikayet Oluştur</a></li>
    <li><a data-toggle="tab" href="#gecmis">Geçmiş Şikayetleri</a></li>
  </ul>

  <div class="tab-content">
    <div id="olustur" class="tab-pane fade in active">   
			<form class="form1" method="post" id="sikayetGonder" style="margin-top: 30px;">
                <div class="form-group">
                    <label for="formalan_name1">Konu<small>*</small></label>
                    <div class="input-group">
                      <input type="hidden" name="uye_id" value="{{sessions.uye_id}}">
                      <input type="text" autocomplete="off" name="konu" required="required" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                    <label for="formalan_name1">Şikayet <small>*</small></label>
                    <div class="input-group">
                      <textarea name="sikayet" class="form-control" required="required" rows="8"></textarea>
                  </div>
                </div>
                <div class="form-group" style="margin-top:20px;">         
                	<div class="col-xs-12 col-md-12"><div class="row"><div class="alert alert-info gelencevap" role="alert" style="display: none;"></div></div></div>                    
                    <button type="button" id="submit_10" autocomplete="off" class="btn btn-inter" onclick="sikayetGonder()">Gönder</button>
                </div>
        </form>
    </div>
    <div id="gecmis" class="tab-pane fade" style="margin-top: 30px;">
    	{% set sikayetler = islem.sqlSorgu("SELECT * FROM "~prefix~"sikayet WHERE uye_id= :uye_id",{":uye_id":sessions.uye_id}) %}
      	<ul class="list-group">
      		{% for key,value in sikayetler %}
    		  <li class="list-group-item d-flex justify-content-between align-items-center">
    		    {{value.konu}}
    		    <span class="badge badge-primary badge-pill">{{islem.tarih(value.kayit_tarihi)}}</span>
    		    <span class="badge badge-danger badge-pill">{{value.okundu}}</span>
    		  </li>
		    {% endfor %}
		  </ul>
    </div>
  </div>
  <script type="text/javascript">
      function sikayetGonder(){
          var form = $("#sikayetGonder").serialize();
          $.ajax({
              type: "POST",
              url: "{{SITE_URL}}uyelik/sikayetGonder",
              data: form,
              success: function(data) { 
                  $(".gelencevap").css("display","block");
                  try{
                     jsonData = JSON.parse(data);
                     $(".gelencevap").html(jsonData["mesaj"]);
                  }catch(e){
                    //console.log(data);
                  } 
              }
          });
      }
    </script>
{% endblock %}



