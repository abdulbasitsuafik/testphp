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
            <label class="col-sm-12 col-form-label">Body *</label>
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
            <input type="text" name="image" class="form-control" value="http://18.197.115.104/osmanhamid-admin-api/uploads/logo.png"  >
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Campaings *</label>
        </div>
        <div class="col-sm-9">
            <select class="form-control select2" name="store_id" data-placeholder="Select Please" required>
                <option value="" >Seçiniz</option>
                {% for value in campaigns %}
                    <option value="{{value.store_id}}">{{value.name}}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <!--<div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">iller *</label>
        </div>
        <div class="col-sm-9">
            <select class="form-control m-b il-123" name="city" data-placeholder="Select Please" onchange="ilcegetir('users/get_school_town','ilce-123',this.value);$('.school-123').html('')">
                <option value="" >Seçiniz</option>
                {% for value in cities %}
                <option value="{{value.id}}" {% if data.city == value.id %} selected {% endif %}>{{value.baslik}}</option>
                {% endfor %}
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Kullanıcı Tipi *</label>
        </div>
        <div class="col-sm-9">
            <select class="form-control m-b select2" name="user_premium" data-placeholder="Select Please">
                <option value="" >Seçiniz</option>
                <option value="1" {% if data.role == "1" %}selected {% endif %}>Free</option>
                <option value="2" {% if data.role == "2" %}selected {% endif %}>Premium</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Kullanıcı Rol  *</label>
        </div>
        <div class="col-sm-9">
            <select class="form-control m-b select2" name="user_role" data-placeholder="Select Please">
                <option value="" >Seçiniz</option>
                <option value="3" {% if data.role == "1" %}selected {% endif %}>Öğrenci</option>
                <option value="4" {% if data.role == "2" %}selected {% endif %}>Öğretmen</option>
            </select>
        </div>
    </div>-->

</div>

<script>
    if($(".select2")){
        $(document).ready(function() {
            // $(".select2").select2("destroy");
            // $(".select2").select2();
            $(".select2").select2({
                dropdownParent: $('.modalGetir-'),
                placeholder: "Select Please",
                allowClear: true
            });
            // $(".select2").trigger('change.select2');
        });
    }
</script>
