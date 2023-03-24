

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
            <label class="col-sm-12 col-form-label">short_name </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="short_name" class="form-control" value="{{data.short_name|default}}" id="namearea" required autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">description </label>
        </div>
        <div class="col-sm-7">
            <textarea class="form-control" name="description" id="addComment" rows="5">{{data.description|default}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">start_date </label>
        </div>
        <div class="col-sm-7 ">
            <input type="text" name="start_date" class="form-control bootstrap-datepicker" value="{{data.start_date}}" autocomplete="off" required>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">end_date </label>
        </div>
        <div class="col-sm-7 ">
            <input type="text" name="end_date" class="form-control bootstrap-datepicker" value="{{data.end_date}}" autocomplete="off" required>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">promocode </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="promocode" class="form-control" value="{{data.promocode|default}}" id="namearea" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">promolink </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="promolink" class="form-control" value="{{data.promolink|default}}" id="namearea" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">discount </label>
        </div>
        <div class="col-sm-7">
            <select name="discount" class="form-control ">
                {% for i in 1..100 %}
                <option value="{{ i }}%" >{{ i }}%</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">species </label>
        </div>
        <div class="col-sm-7">
            <select name="species" class="form-control ">
                <option value="0">Select</option>
                <option value="promocode" {% if data["species"] == "promocode" %}   selected{% endif %}  >Code</option>
                <option value="action" {% if data["species"] == "action" %}   selected{% endif %}  >Action</option>
                <option value="special offer" {% if data["species"] == "special offer" %}   selected{% endif %}  >Special offer</option>
                <option value="deal" {% if data["species"] == "deal" %}   selected{% endif %}  >Deal</option>
            </select>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">code_type </label>
        </div>
        <div class="col-sm-7">
            <select name="code_type" class="form-control ">
                <option value="0">Select</option>
                <option value="code" {% if data["code_type"] == "code" %}   selected{% endif %}  >Code</option>
                <option value="deal" {% if data["code_type"] == "deal" %}   selected{% endif %}  >Deal</option>
            </select>
        </div>

    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">cashback </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="cashback" class="form-control" value="{{data.cashback|default}}" id="namearea" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">source </label>
        </div>
        <div class="col-sm-7">
            <select name="source" class="form-control ">
                <option value="0">Select</option>
                <option value="panel" {% if data["source"] == "panel" %}   selected{% else %} selected {% endif %}  >Panel</option>
                <option value="admitad" {% if data["source"] == "admitad" %}   selected{% endif %}  >Admitad</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">regions </label>
        </div>
        <div class="col-sm-7">
            <select name="regions[]" class="form-control select2" multiple>
                <option value="0">Select</option>
                {% set foo_check = data["regions"]|split(',') %}
                {% for value in regions %}
                {% if value["name"] in foo_check  %} {% set selected = "selected" %}  {% else %} {% set selected = "" %} {% endif %}
                    <option value="{{value.name}}" {{selected}}>{{value.name}}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">categories</label>
        </div>
        <div class="col-sm-7">
            <select name="categories_id" class="form-control ">
                <option value="0">Select</option>
                {% for value in categories %}
                    <option value="{{value.id}}" {% if data["categories_id"] == value.id %}   selected{% endif %}>{{value.name}}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">store_id </label>
        </div>
        <div class="col-sm-7">
            <select name="store_id" class="form-control ">
                <option value="0">Select</option>
                {% for value in stores %}
                <option value="{{value.id}}" {% if data["store_id"] == value.id %}   selected{% endif %}>{{value.name}}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">rating </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="rating" class="form-control" value="{{data.rating|default}}" id="namearea" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">exclusive </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="exclusive" class="form-control" value="{{data.exclusive|default}}" id="namearea" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">language </label>
        </div>
        <div class="col-sm-7">
            <select name="language" class="form-control ">
                <option value="0">Select</option>
                <option value="EN" {% if data["language"] == "EN" %}   selected{% else %} selected {% endif %} >EN</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">types </label>
        </div>
        <div class="col-sm-7">
            <select name="types" class="form-control ">
                <option value="0">Select</option>
                <option value="Discount on an order" {% if data["types"] == "Discount on an order" %}   selected{% endif %}  >Discount on an order</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">coupon_id </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="coupon_id" class="form-control" value="{{data.coupon_id|default}}" id="namearea" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">image </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="image" class="form-control" value="{{data.image|default}}" id="namearea" autocomplete="off">
        </div>
    </div>
</div>
<script>
    $('.bootstrap-datepicker').datepicker({
        format: 'yyyy-mm-dd',
        weekStart: 1,
        changeYear: false,
        startDate: "-80:+0",
        language: "en",
        //daysOfWeekDisabled: "0,6",
        //daysOfWeekHighlighted: "0,6",
        todayHighlight: true,
        autoclose:true
    });
</script>
