<br>
<div class="form-group row">
    <label class="col-sm-3 control-label">Form Mail Alıcılar</label>
    <div class="col-sm-6">
        <textarea name='formmail_alicilar' rows='5' class='form-control textarea-autosize'>{{data["formmail_alicilar"]|default}}</textarea>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label">Form Mail Host</label>
    <div class="col-sm-6">
        <input type="text" name="formmail_host" placeholder="Form Mail Host"  class="form-control" value="{{data["formmail_host"]|default}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label">Form Mail Mail</label>
    <div class="col-sm-6">
        <input type="text" name="formmail_mail" placeholder="Form Mail Mail"  class="form-control" value="{{data["formmail_mail"]|default}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label">Form Mail Şifre</label>
    <div class="col-sm-6">
        <input type="password" name="formmail_sifre" placeholder="Form Mail Şifre"  class="form-control" value="{{data["formmail_sifre"]|default}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label">Form Mail Secure</label>
    <div class="col-sm-6">
        <input type="text" name="formmail_secure" placeholder="Form Mail Secure"  class="form-control" value="{{data["formmail_secure"]|default}}">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label">Form Mail Port</label>
    <div class="col-sm-6">
        <input type="text" name="formmail_port" placeholder="Form Mail Port"  class="form-control" value="{{data["formmail_port"]|default}}">
    </div>
</div>