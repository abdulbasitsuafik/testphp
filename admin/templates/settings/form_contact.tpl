<br>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-sm-3 control-label">Telefon</label>
            <div class="col-sm-6">
                <input type="text" name="telefon" placeholder="Telefon"  class="form-control" value="{{data.telefon|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telefon 1</label>
            <div class="col-sm-6">
                <input type="text" name="telefon1" placeholder="Telefon 1"  class="form-control" value="{{data.telefon1|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telefon 2</label>
            <div class="col-sm-6">
                <input type="text" name="telefon2" placeholder="Telefon 2"  class="form-control" value="{{data.telefon2|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telefon 3</label>
            <div class="col-sm-6">
                <input type="text" name="telefon3" placeholder="Telefon 3"  class="form-control" value="{{data.telefon3|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telefon 4</label>
            <div class="col-sm-6">
                <input type="text" name="telefon4" placeholder="Telefon 4"  class="form-control" value="{{data.telefon4|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Telefon 5</label>
            <div class="col-sm-6">
                <input type="text" name="telefon5" placeholder="Telefon 5"  class="form-control" value="{{data.telefon5|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Fax</label>
            <div class="col-sm-6">
                <input type="text" name="fax" placeholder="Fax"  class="form-control" value="{{data.fax|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Gsm</label>
            <div class="col-sm-6">
                <input type="text" name="gsm" placeholder="Gsm"  class="form-control" value="{{data.gsm|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Email</label>
            <div class="col-sm-6">
                <input type="email" name="email" placeholder="Email"  class="form-control" value="{{data.email|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Adres (1)</label>
            <div class="col-sm-6">
                <textarea name='adres1' rows='3' class='form-control textarea-autosize'>{{data.adres1|default}}</textarea>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-sm-3 control-label">Harita İframe</label>
            <div class="col-sm-6">
                <textarea name='harita' rows='5' class='form-control textarea-autosize haritaiframe'>{{data.harita|default}}</textarea>
            </div>
        </div>
        <div class='divider'></div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Mobil Telefon</label>
            <div class="col-sm-6">
                <input type="text" name="mobil_telefon" placeholder="Mobil Telefon"  class="form-control" value="{{data.mobil_telefon|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Mobil Harita</label>
            <div class="col-sm-6">
                <textarea name='mobil_harita' rows='5' class='form-control textarea-autosize'>{{data.mobil_harita|default}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Mobil Email</label>
            <div class="col-sm-6">
                <input type="text" name="mobil_email" placeholder="Mobil Email"  class="form-control" value="{{data.mobil_email|default}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Adres (2)</label>
            <div class="col-sm-6">
                <textarea name='adres2' rows='3' class='form-control textarea-autosize'>{{data.adres2|default}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Adres (3)</label>
            <div class="col-sm-6">
                <textarea name='adres3' rows='3' class='form-control textarea-autosize'>{{data.adres3|default}}</textarea>
            </div>
        </div>
    </div>
</div>

<div class='divider'></div>

<script type="text/javascript">
    function haritaiframe() {
        var harita = $(".haritaiframe").val();
        console.log(harita.indexOf("iframe"));
        if(harita.indexOf("iframe") > 0 ){
            var encodedData = window.btoa(harita);
            $(".haritaiframe").val(encodedData);
        }
    }
    </script>