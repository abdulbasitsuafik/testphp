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
            <input type="email" name="email" class="form-control" value="{{data.email|default}}" id="email_area" required>
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

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Role*</label>
        </div>
        <div class="col-sm-7">
            <select class="form-control m-b" name="role" data-placeholder="Select Please">
                <option value="" >Seçiniz</option>
                <option value="1" {% if data.role == "1" %}selected {% endif %}>Authenticated</option>
                <option value="2" {% if data.role == "2" %}selected {% endif %}>Public</option>
                <option value="3" {% if data.role == "3" %}selected {% endif %}>Student</option>
                <option value="4" {% if data.role == "4" %}selected {% endif %}>Teacher</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Reklam*</label>
        </div>
        <div class="col-sm-7">
            <select class="form-control m-b" name="ads_enabled" data-placeholder="Select Please">
                <option value="" >Seçiniz</option>
                <option value="1" {% if data.ads_enabled == true %}selected {% endif %}>Açık</option>
                <option value="0" {% if data.ads_enabled == false %}selected {% endif %}>Kapalı</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-12 col-form-label">Premium Paket Eklensin mi ?</label>
        </div>
        <div class="col-sm-4">
            {% if premium!=1 and data.role == "3" %}
                <select class="form-control m-b" name="premium_competition" data-placeholder="Select Please">
                    <option value="" >Seçiniz</option>
                    <option value="1" >Evet Ekle</option>
                    <option value="0" selected>Hayır Ekleme</option>
                </select>
            {% else %}
                Kullanıcı zaten Premium
            {% endif %}
        </div>
        <div class="col-sm-4">
            {% if premium!=1 and data.role == "3" %}
                <select class="form-control m-b" name="premium_month" data-placeholder="Select Please">
                    <option value="" selected>Kaç ay</option>
                    <option value="1" >1 AY</option>
                    <option value="2" >2 Ay</option>
                    <option value="3" >3 Ay</option>
                    <option value="6" >6 Ay</option>
                    <option value="12" >12 Ay</option>
                </select>
            {% endif %}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-12 col-form-label">Anahtar Eklensin mi ?</label>
        </div>
        <div class="col-sm-4">
            {% if premium!=1 and data.role == "3" %}
            <select class="form-control m-b" name="key_competition" data-placeholder="Select Please">
                <option value="" >Seçiniz</option>
                <option value="1" >Evet Ekle</option>
                <option value="0" selected>Hayır Ekleme</option>
            </select>
            {% else %}
            Kullanıcı zaten Premium, Anahtar eklenmez!
            {% endif %}
        </div>
        <div class="col-sm-4">
            {% if premium!=1 and data.role == "3" %}
            <select class="form-control m-b" name="key_count" data-placeholder="Select Please">
                <option value="" selected>Kaç tane</option>
                {% for i in 1..25 %}
                <option value="{{ i }}" >{{ i }} Tane</option>
                {% endfor %}

            </select>
            {% endif %}
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-12 col-form-label">Bilet Eklensin mi ?</label>
        </div>
        <div class="col-sm-4">
            {% if premium!=1 and data.role == "3" %}
            <select class="form-control m-b" name="ticket_competition" data-placeholder="Select Please">
                <option value="" >Seçiniz</option>
                <option value="1" >Evet Ekle</option>
                <option value="0" selected>Hayır Ekleme</option>
            </select>
            {% else %}
                Kullanıcı zaten Premium, Bilet eklenmez!
            {% endif %}
        </div>
        <div class="col-sm-4">
            {% if premium!=1 and data.role == "3" %}
            <select class="form-control m-b" name="ticket_count" data-placeholder="Select Please">
                <option value="" selected>Kaç tane</option>
                {% for i in 1..25 %}
                <option value="{{ i }}" >{{ i }} Tane</option>
                {% endfor %}

            </select>
            {% endif %}
        </div>
    </div>
    {% if data.role == "4" %}
        <div class="form-group row">
            <div class="col-sm-5">
                <label class="col-sm-12 col-form-label">Öğrenmenlik Onayı*</label>
            </div>
            <div class="col-sm-7">
                <select class="form-control m-b" name="teacher_agreement" data-placeholder="Select Please">
                    <option value="" >Seçiniz</option>
                    <option value="1" {% if data.teacher_agreement == "1" %}selected {% endif %}>Onaylı</option>
                    <option value="0" {% if data.teacher_agreement == "0" %}selected {% endif %}>Onaysız</option>
                </select>
            </div>
        </div>
    {% endif  %}
    <!--<div class="form-group row">
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
    </div>-->
</div>
<div class="col-sm-6">

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">İl</label>
        </div>
        <div class="col-sm-7">
            <select class="form-control m-b il-123" name="city" data-placeholder="Select Please" onchange="ilcegetir('users/get_school_town','ilce-123',this.value);$('.school-123').html('')">
                <option value="" >Seçiniz</option>
                {% for value in cities %}
                    <option value="{{value.id}}" {% if data.city == value.id %} selected {% endif %}>{{value.baslik}}</option>
                {% endfor %}
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">İlçe</label>
        </div>
        <div class="col-sm-7">
            <select class="form-control m-b ilce-123" name="town" data-placeholder="Select Please" onchange="ilcegetir('users/get_school_town','school-123',$('.il-123').val(),this.value)">
                <option value="" >Seçiniz</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Okul</label>
        </div>
        <div class="col-sm-7">
            <select class="form-control m-b school-123" name="school" data-placeholder="Select Please">
                <option value="" >Seçiniz</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Sınıf</label>
        </div>
        <div class="col-sm-7">
            <select class="form-control m-b" name="class" data-placeholder="Select Please">
                <option value="" >Seçiniz</option>
                {% for value in classes %}
                <option value="{{value.id}}" {% if data.class == value.id %} selected {% endif %}>{{value.name}}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Bu ayki Puanı*</label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="point" class="form-control" value="{{data.point|default}}" id="point_area">
        </div>
    </div>
</div>

<script>
    ilcegetir('users/get_school_town','ilce-123','{{data.city}}',null,null,'{{data.town}}')
    ilcegetir('users/get_school_town','school-123','{{data.city}}','{{data.town}}','{{data.school}}')
</script>
