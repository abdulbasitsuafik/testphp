<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Adı * </label>
        </div>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control" value="{{data.name|default}}" id="namearea" required>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Kodu * </label>
        </div>
        <div class="col-sm-8">
            <input type="text" name="code" class="form-control" value="{{data.code|default}}" id="namearea" required>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Sıra * </label>
        </div>
        <div class="col-sm-8">
            <input type="text" name="rank" class="form-control" value="{{data.rank|default}}" id="namearea" required>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Durum </label>
        </div>
        <div class="col-sm-8">
            <select class="form-control m-b " name="status" data-placeholder="Select Please">
                <option value="">Seçiniz</option>
                <option value="1">Aktif</option>
                <option value="0">Pasif</option>
            </select>
        </div>
    </div>
</div>

