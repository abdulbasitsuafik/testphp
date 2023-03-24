<br>
<div class="form-group row">
    <label class="col-sm-3 control-label">Yayın Durumu</label>
    <div class="col-sm-6">
        <label>
            <input type="radio" id="inlineRadio111" name="yayin_durumu" value="1" class="custom-radio" {% if data.yayin_durumu == 1 %} checked {% endif %}>
            Yayında
        </label>
        <label>
            <input type="radio" id="inlineRadio111" name="yayin_durumu" value="0" class="custom-radio" {% if data.yayin_durumu == 0 %} checked {% endif %}>
            Bakım Modu
        </label>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label">Analytics</label>
    <div class="col-sm-6">
        <textarea name='analytics' rows='5' class='form-control textarea-autosize'>{{data.analytics|default}}</textarea>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 control-label">Firma Ünvanı</label>
    <div class="col-sm-6">
        <input type="text" name="unvani" placeholder="Firma Ünvanı"  class="form-control" value="{{data["unvani"]|default}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label">Copyright Firması</label>
    <div class="col-sm-6">
        <input type="text" name="telif" placeholder="Yalnızca firma adı giriniz örn:'Tolga Bilgi Teknolojileri'"  class="form-control" value="{{data["telif"]|default}}">
    </div>
</div>

