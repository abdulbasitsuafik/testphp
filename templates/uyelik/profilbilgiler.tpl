{% extends 'base.tpl' %}

{% block main %}

{% set iller = islem.sqlSorgu("SELECT * FROM "~prefix~"iller order by headlines ASC") %}
{% set uye = islem.sqlSorgu("SELECT * FROM "~prefix~"uyeler WHERE id= :id",{":id":sessions.uye_id}) %}
<form class="form1" method="post" id="uyeduzenle">
                          <h2>Profil Bilgilerim</h2>
                          <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">    
                            <div class="col-xs-12 col-md-12"><div class="row"><div class="alert formAlert_10" role="alert" style="display: none;"></div></div></div>
                            <div class="form-group">
                                <label for="formalan_name1" id="labelid_65">Adınız Soyadınız <small>*</small></label>
                                <div class="input-group">
                                  <input type="hidden" name="id" value="{{uye.0.id}}">
                                  <input type="text" autocomplete="off" name="adi" id="inputid_65" value="{{uye.0.adi}}" required="required" class="form-control" aria-required="true">
                              </div>
                            </div>
                            <div class="form-group">
                                <label for="formalan_name1" id="labelid_66">Email <small>*</small></label>
                                <div class="input-group">
                                  <input type="email" autocomplete="off" name="email" id="inputid_66" value="{{uye.0.email}}" required="required" class="form-control" aria-required="true">
                              </div>
                            </div>                            
                            <div class="form-group">
                                <label for="formalan_name1" id="labelid_67">Telefon <small>*</small></label>
                                <div class="input-group">
                                  <input type="text" id="inputid_67" name="telefon" required="required" value="{{uye.0.telefon}}" class="form-control" data-inputmask='"mask": "0(999) 999-9999"' data-mask>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="formalan_name1" id="labelid_76">Hangi ilde Yaşıyorsunuz? <small>*</small></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-globe" aria-hidden="true"></i></span>
                                    <select name="il" class="form-control selectpicker" data-live-search="true" title="Lütfen Seçiniz...">
                                        <option value="">Seçim Yapınız</option>
                                        {% for value in iller %}
                                        <option value="{{value.id}}" {% if value.id == uye.0.il %}selected{% endif %}>{{value.headlines}}</option>
                                        {% endfor %}
                                    </select>
                                </div>
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <div class="row">
                                        <span class="help-block" id="uyariid_76" style="position: absolute;"></span>    
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="formalan_name1" id="labelid_65333">Doğum Tarihi <small>*</small></label>
                                <div class="input-group">
                                  {% set tarih = islem.tarih(uye.0.dogum_tarihi) %}
                                  <input type="text" name="dogum_tarihi" id="inputid_0000000" class="form-control bootstrap-datepicker" value='{{ tarih }}' required="required" aria-required="true">
                                  
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="formalan_name1" id="labelid_6666">Sigara Kullanıyormusunuz? <small>*</small></label>
                                <div class="input-group">
                                  <select class="form-control selectpicker" name="sigara" data-live-search="true" title="Lütfen Seçiniz...">
                                    <option value="">Seçim Yapınız</option>
                                    <option value="1" {% if uye.0.sigara == '1' %}selected{% endif %}>Evet</option>
                                    <option value="0" {% if uye.0.sigara == '0' %}selected{% endif %}>Hayır</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="formalan_name1" id="labelid_655555">Kanser öykünüz varmı? <small>*</small></label>
                                <div class="input-group">
                                  <select class="form-control selectpicker" name="kanser" data-live-search="true" title="Lütfen Seçiniz...">
                                    <option value="">Seçim Yapınız</option>
                                    <option value="1" {% if uye.0.kanser == '1' %}selected{% endif %}>Evet</option>
                                    <option value="0" {% if uye.0.kanser == '0' %}selected{% endif %}>Hayır</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="formalan_name1" id="labelid_68">Parola <small>*</small></label>
                                <div class="input-group">
                                  <input type="password" autocomplete="off" name="parola" id="inputid_68" placeholder="Parola" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="formalan_name1" id="labelid_69">Parola Tekrar<small>*</small></label>
                                <div class="input-group">
                                  <input type="password" autocomplete="off" name="parola_tekrar" id="inputid_69" placeholder="Parola" class="form-control" >
                              </div>
                            </div>
                              <div class="col-xs-12 col-md-12"><div class="row"><div class="alert alert-info gelencevap" role="alert" style="display: none;"></div></div></div>
                            <div class="form-group" style="margin-top:20px;">                            
                                <button type="button" id="submit_10" autocomplete="off" class="btn btn-inter" onclick="uyeduzenle()">Düzenle</button>
                            </div>
                    </form>
                    <script type="text/javascript">
                      function uyeduzenle(){
                          var form = $("#uyeduzenle").serialize();
                          $.ajax({
                              type: "POST",
                              url: "{{SITE_URL}}uyelik/duzenlerun",
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

