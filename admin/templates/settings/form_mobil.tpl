<br>
<div class="form-group row">
    <label class="col-sm-3 control-label">Ios Ödeme Yöntemi</label>
    <div class="col-sm-6">
        <label>
            <input type="radio" id="inlineRadio111" name="payment_method" value="1" class="custom-radio" {% if data.payment_method == 1 %} checked {% endif %}>
            Paytr Ödeme
        </label>
        <label>
            <input type="radio" id="inlineRadio111" name="payment_method" value="0" class="custom-radio" {% if data.payment_method == 0 %} checked {% endif %}>
            Ios Ödeme
        </label>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label">Aktif ANDROID Versiyon</label>
    <div class="col-sm-6">
        <input type="text" name="active_android_version" placeholder="1.5.8"  class="form-control" value="{{data["active_android_version"]|default}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label">Aktif APPLE Versiyon</label>
    <div class="col-sm-6">
        <input type="text" name="active_ios_version" placeholder="1.5.8"  class="form-control" value="{{data["active_ios_version"]|default}}">
    </div>
</div>
