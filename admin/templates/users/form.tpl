<div class="col-sm-6">
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Name* </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="name" class="form-control" value="{{data.name|default}}" id="namearea" required autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">SurName* </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="surname" class="form-control" value="{{data.surname|default}}" id="namearea" required autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Full Name* </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="surname" class="form-control" value="{{data.full_name|default}}" disabled autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Username *</label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="username" class="form-control" value="{{data.username|default}}" id="username_area" required>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Password *</label>
        </div>
        <div class="col-sm-7">
            <input type="password" name="password" class="form-control" value="" >
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Password Repeat*</label>
        </div>
        <div class="col-sm-7">
            <input type="password" name="password_repeat" class="form-control" value="">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Email*</label>
        </div>
        <div class="col-sm-7">
            <input type="email" name="email" class="form-control" value="{{data.email|default}}" id="email_area" >
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Phone*</label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="phone" class="form-control" value="{{data.phone_number|default}}" id="phone_area">
        </div>
    </div>


</div>
<div class="col-sm-6">

    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Kod* </label>
        </div>
        <div class="col-sm-6">
            <input type="text" placeholder="KOD" name="my_ref_code" value="{{data.my_ref_code}}" {% if data.my_ref_code %} disabled{% endif %} class="form-control code_input" autocomplete="off">
        </div>
        <div class="col-sm-3">
            <a href="javascript:void(0)" class="btn btn-warning" onclick="addCode('{{CONTROLLER}}/getCode')">Kod Oluştur</a>
        </div>
    </div>

</div>

<script>
</script>
