<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Title* </label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="title" class="form-control" value="{{data.title|default}}" id="namearea" required autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Description *</label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="body" class="form-control" value="{{data.body|default}}" id="username_area" required>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Image *</label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="image" class="form-control" value=""  >
        </div>
    </div>

</div>

