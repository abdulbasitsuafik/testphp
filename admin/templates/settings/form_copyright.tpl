<br>
<div class="col-md-9">
    <div class="row">
        <div class='col-md-6'>
            <div class="thumbnail-box" style="float: right;">
                <div class="thumb-overlay bg-black"></div>
                <img src="{{SITE_URL}}{{data.logo}}" alt="">
            </div>
        </div>
        <div class='col-md-6'>
            <div class="form-group row">
                <label class="col-sm-3 control-label">Resimler için Telif Resmi</label>
                <div class="col-sm-9">
                    <input type="file" name="telif_resmi" class="form-control" >
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label class="col-sm-3 control-label">Resimler için Telif fontu yükle</label>
        <div class="col-sm-6">
            <input type="file" name="font" class="form-control" >
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label class="col-sm-3 control-label">Telif Tipi Seçeneği</label>
        <div class="col-sm-6">
            <select name="telif_resmi_secim" id="selectbox" class="form-control chosen-select" onchange="secim()">
                <option value="">Seçim Yapınız</option>
                <option value="resim" {% if data.yayin_durumu == "resim" %} selected {% endif %}>Resim</option>
                <option value="yazi" {% if data.yayin_durumu == "yazi" %} selected {% endif %}>Yazı</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Telif Resmi Konum</label>
        <div class="col-sm-6">
            <select name="telif_resmi_konum" class="form-control chosen-select">
                <option value="">Seçim Yapınız</option>
                <option value="orta" {% if data.yayin_durumu == "orta" %} selected {% endif %}>Ortala</option>
                <option value="solust" {% if data.yayin_durumu == "solust" %} selected {% endif %}>Sol Üst</option>
                <option value="ortaust" {% if data.yayin_durumu == "ortaust" %} selected {% endif %}>Orta Üst</option>
                <option value="sagust" {% if data.yayin_durumu == "sagust" %} selected {% endif %}>Sağ Üst</option>
                <option value="solorta" {% if data.yayin_durumu == "solorta" %} selected {% endif %}>Sol Orta</option>
                <option value="sagorta" {% if data.yayin_durumu == "sagorta" %} selected {% endif %}>Sağ Orta</option>
                <option value="solalt" {% if data.yayin_durumu == "solalt" %} selected {% endif %}>Sol Alt</option>
                <option value="ortaalt" {% if data.yayin_durumu == "ortaalt" %} selected {% endif %}>Orta Alt</option>
                <option value="sagalt" {% if data.yayin_durumu == "sagalt" %} selected {% endif %}>Sağ Alt</option>
            </select>
        </div>
    </div>
    <div id="yaziicerigi" style="{% if data.telif_resmi_secim == "resim" %} display:none;{% endif %}">
        <div class="form-group">
            <label class="col-sm-3 control-label">Telif Resmi Yazı</label>
            <div class="col-sm-6">
                <input type="text" name="telif_resmi_yazi" placeholder="Telif Resmi Yazı"  class="form-control" value="{{data.telif_resmi_yazi}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telif Resmi Yazı Arkplan Rengi</label>
            <div class="col-sm-6">
                <input type="text" name="telif_resmi_yazi_bg" value="{{data.telif_resmi_yazi_bg}}" class="form-control color-picker-tlg">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telif Resmi Yazı Rengi</label>
            <div class="col-sm-6">
                <input type="text" name="telif_resmi_yazi_renk" value="{{data.telif_resmi_yazi_renk}}" class="form-control color-picker-tlg">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telif Resmi Yazı alanı Genişliği</label>
            <div class="col-sm-6">
                <input type="text" name="telif_resmi_yazi_width" placeholder="Telif Resmi Yazı alanı Genişliği"  class="form-control" value="{{data.telif_resmi_yazi_width}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telif Resmi Yazı Alanı Yüksekliği</label>
            <div class="col-sm-6">
                <input type="text" name="telif_resmi_yazi_height" placeholder="telif Resmi Yazı Alanı Yüksekliği"  class="form-control" value="{{data.telif_resmi_yazi_height}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telif Resmi Yazı Fontu</label>
            <div class="col-sm-6">
                <select name="telif_resmi_yazi_font" class="form-control chosen-select">
                    <option value="">Seçim Yapınız</option>
                    {% for val in fontlar %}
                        <option value="{{val.yolu}}" {% if data.telif_resmi_yazi_font == val.yolu %} selected {% endif %} >{{val.adi}}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telif Resmi Yazı Fontu Boyutu</label>
            <div class="col-sm-6">
                <input type="number" name="telif_resmi_yazi_font_size" placeholder="25"  class="form-control" value="{{data.telif_resmi_yazi_font_size}}">
            </div>
        </div>
    </div>
</div>