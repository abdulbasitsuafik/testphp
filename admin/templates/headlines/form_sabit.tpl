<br>
<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-12">
                <label >EK</label>
                <input type="text" name="ek" value="{{data["ek"]}}"  placeholder="EK" class="form-control enterButton">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label >Üst Başlık</label>
                <select name="top_head_id" class="form-control select2">
                    <option value="0" {% if data['main_head']=="1"%} selected {% endif %}  >Ana Başlık </option>
                    {{actions.headlinesAgaci("0","","0", data["top_head_id"])}}
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Görünürlük</label>
                <select name="status"  class="form-control">
                    <option value="1" id="group5" {% if data["status"]=="1"%}   selected{% endif %}  >Evet</option>
                    <option value="0" id="group4" {% if data["status"]=="0"%}   selected{% endif %}  >Hayır</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Form Ata</label>
                <select name="form_id" class="form-control select2">
                    <option value="0" >Seçim Yapınız</option>
                    {% for formvalue in formlar %}
                    <option value="{{ formvalue["id"]}}" {% if formvalue["id"] == data["form_id"]%}   selected{% endif %}  >{{ formvalue["adi"]}}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Banner Ata</label>
                <select name="slide_id" class="form-control select2">
                    <option value="0">Seçim Yapınız</option>
                    {% for bannervalue in banner %}
                    <option value="{{ bannervalue["id"]}}" {% if bannervalue["id"] == data["slide_id"]%}   selected{% endif %}  >{{ bannervalue["adi"]}}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Galeri Ata</label>
                <select name="galery_id[]" class="form-control select2" multiple>
                    <option value="0">Seçim Yapınız</option>
                    {% set foo_check = data["galery_id"]|split(',') %}
                    {% for value in galeriler %}
                    {% if value["galery_id"] in foo_check  %} {% set selected = "selected" %}  {% else %} {% set selected = "" %} {% endif %}
                    <option value="{{value.id}}" {{selected}}>{{value.name}}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <label>Popup Ata</label>
                <select name="popup_id" class="form-control select2">
                    <option value="0">Seçim Yapınız</option>
                    {% for popupvalue in popuplar %}
                    <option value="{{ popupvalue["id"]}}" {% if data["popup_id"] == popupvalue["id"]%}   selected{% endif %}  >{{ popupvalue["description"]}}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="form-group row">
    <label class="col-sm-2 control-label">Resim</label>
    <div class="col-sm-5">
        <input type="file" name="image" id="fileResim" class="form-control ">
    </div>
    <div class="col-sm-5">
        <div class="thumbnail-box">
            <div class="thumb-overlay bg-black"></div>
            <img id="headlinesResmi" style="width: 200px;height:200px;" src="{{SITE_URL~data["image"]}}" alt="">
        </div>
    </div>
</div>
<hr>
<div class="form-group row">
    <label class="col-sm-2 control-label">Direk Link</label>
    <div class="col-sm-3">
        <select name="link_selected" class="form-control" id="link_selected" onchange="icdissecim(this)">
            <option value="" >Link Şekli Seçiniz</option>
            <option value="ic" {% if data["link_selected"]=="ic"%}selected{% endif %}>İç Link</option>
            <option value="dis" {% if data["link_selected"]=="dis"%}selected{% endif %}>DışLink</option>
        </select>
    </div>
    <div class="col-sm-4" id="disLink" style="{% if data["link_selected"]=="ic" or data["link"]==""%}display: none;{% endif %}">
        <input type="text" name="dislink" value="{% if data["link_selected"]=="dis"%}{{ data["link"]}}{% endif %}" placeholder="http://orneksite.com" class="form-control enterButton">
    </div>
    <div class="col-sm-2" id="in_linkSekli" style="{% if data["link_selected"]=="dis" or data["link"]==""%}display: none;{% endif %}">
        <select name="inlink_type" class="form-control" id="in_linksekliSelec" onchange="in_linksekli(this.value,'{{data["link"]}}')">
            <option value="">Seçim Yapınız</option>
            <option value="headlines" {% if data["inlink_type"]=="headlines"%}selected{% endif %}>Başlık</option>
            <option value="headlines" {% if data["inlink_type"]=="headlines"%}selected{% endif %}>headlines</option>
            <option value="proje_headlines" {% if data["inlink_type"]=="proje_headlines"%}selected{% endif %}>Proje headlines</option>
            <option value="hizmet_headlines" {% if data["inlink_type"]=="hizmet_headlines"%}selected{% endif %}>Hizmet headlines</option>
            <option value="urun" {% if data["inlink_type"]=="urun"%}selected{% endif %}>Ürün</option>
            <option value="proje" {% if data["inlink_type"]=="proje"%}selected{% endif %}>Proje</option>
            <option value="hizmet" {% if data["inlink_type"]=="hizmet"%}selected{% endif %}>Hizmet</option>
            <option value="haber" {% if data["inlink_type"]=="haber"%}selected{% endif %}>Haber</option>
            <option value="etkinlik" {% if data["inlink_type"]=="etkinlik"%}selected{% endif %}>Etkinlik</option>
        </select>
    </div>
    <div class="col-sm-2" id="in_link" style="{% if data["link_selected"]=="dis" or data["link"]==""%}display: none;{% endif %}">
        <select name="in_link" id="in_linkSelect" class="form-control in_linkSelect">
            <option value="">Seçim Yapınız</option>
        </select>
    </div>
    <div class="col-sm-2">
        <select name="link_opening" class="form-control">
            <option value="" {% if data["link_opening"]==""%}selected{% endif %}>Açılma Şekli Seçiniz</option>
            <option value="_self" {% if data["link_opening"]=="_self"%}selected{% endif %}>Aynı Sayfada</option>
            <option value="_blank" {% if data["link_opening"]=="_blank"%}selected{% endif %}>Farklı Sayfada</option>
            <option value="_parent" {% if data["link_opening"]=="_parent"%}selected{% endif %}>Ana Çerçevede</option>
            <option value="_top" {% if data["link_opening"]=="_top"%}selected{% endif %}>Tüm Gövdede</option>
        </select>
    </div>
</div>
<hr>
<script>
    function icdissecim(selected){
        if(selected.value=="dis"){
            $("#disLink").css("display","block");
            $("#in_linkSekli").css("display","none");
            $("#in_link").css("display","none");
        }else if(selected.value=="ic"){
            $("#disLink").css("display","none");
            $("#in_linkSekli").css("display","block");
        }else{
            $("#disLink").css("display","none");
            $("#in_linkSekli").css("display","none");
            $("#in_link").css("display","none");
        }
    }
    function in_linksekli(selected){
        $("#in_link").css("display","block");
        $.ajax({
            type: "POST",
            url: "{{PANEL_URL}}{{CONTROLLER}}/in_links",
            data: {sekil:selected.value},
            success: function(data)
            {
                $(".in_linkSelect").html(data);
                //console.log(data);
            }
        });
    }
</script>
