<div class="col-sm-12">
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
            <input type="password" name="password" class="form-control" value="" {% if data.password|default %} {% else %} id="password_area" required {% endif %}>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Password Repeat*</label>
        </div>
        <div class="col-sm-7">
            <input type="password" name="password_repeat" class="form-control" value="" {% if data.password|default %} {% else %}id="password_repeat_area" required{% endif %}>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Email*</label>
        </div>
        <div class="col-sm-7">
            <input type="email" name="email" class="form-control" value="{{data.email|default}}" id="email_area" required>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Phone*</label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="phone" class="form-control" value="{{data.phone|default}}" id="phone_area">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Authority*</label>
        </div>
        <div class="col-sm-7">
            <select class="form-control m-b" name="authority" data-placeholder="Select Please">
                <option value="" >Seçiniz</option>
                <option value="0" {% if data.authority == "0" %}selected {% endif %}>Editor</option>
                <!--<option value="1" {% if data.authority == "1" %}selected {% endif %}>Super User</option>-->
                <option value="2" {% if data.authority == "2" %}selected {% endif %}>Admin</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Profile Image*</label>
        </div>
        <div class="col-sm-3">
            {% if data.image|default %}
                <img src="{{PANEL_URL}}{{data.image|default}}" style="width: 48px;height: 48px;">
            {% else %}
                <img src="{{THEME_PATH}}assets/img/profile_small.jpg">
            {% endif %}
        </div>
        <div class="col-sm-4">
            <input type="file" name="image" class="form-control" value="" id="profile_image_area">
        </div>
    </div>
</div>

