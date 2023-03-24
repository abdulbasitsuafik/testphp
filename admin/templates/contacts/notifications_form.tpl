<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Başlık* </label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="title" class="form-control" value="{{data.title|default}}" id="namearea" required autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">İçerik *</label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="body" class="form-control" value="{{data.body|default}}" id="username_area" required>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Resim *</label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="image" class="form-control" value="https://admin.tosbaapp.com/admin/static/temalar/default/assets/logo.gif"  >
        </div>
    </div>

</div>

