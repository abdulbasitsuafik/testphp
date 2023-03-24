<div class="col-sm-6">
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">store_id* </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="store_id" class="form-control" value="{{data.store_id|default}}" id="namearea" required autocomplete="off">
        </div>
    </div>
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
            <label class="col-sm-12 col-form-label">logo </label>
        </div>
        <div class="col-sm-3">
            {% if data.logo|default %}
            <img src="{{data.logo|default}}" style="width: 48px;height: 48px;">
            {% else %}
            <img src="{{THEME_PATH}}assets/img/profile_small.jpg">
            {% endif %}
        </div>
        <div class="col-sm-4">
            <input type="text" name="logo" class="form-control" value="{{data.logo|default}}" id="namearea"  autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">Large İmage </label>
        </div>
        <div class="col-sm-3">
            {% if data.large_image|default %}
                <img src="{{SITE_URL}}{{data.large_image|default}}" style="width: 48px;height: 48px;">
            {% else %}
                <img src="{{THEME_PATH}}assets/img/profile_small.jpg">
            {% endif %}
        </div>
        <div class="col-sm-4">
            <input type="file" name="image" class="form-control" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">site_url </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="site_url" class="form-control" value="{{data.site_url|default}}" id="namearea"  autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">status </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="status" class="form-control" value="{{data.status|default}}" id="namearea"  autocomplete="off">
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">currency </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="currency" class="form-control" value="{{data.currency|default}}" id="namearea"  autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">rating </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="rating" class="form-control" value="{{data.rating|default}}" id="namearea"  autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">activation_date </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="activation_date" class="form-control bootstrap-datepicker" value="{{data.activation_date|default}}" id="namearea"  autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">modified_date </label>
        </div>
        <div class="col-sm-7">
            <input type="text" name="modified_date" class="form-control bootstrap-datepicker" value="{{data.modified_date|default}}" id="namearea"  autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label class="col-sm-12 col-form-label">categories </label>
        </div>
        <div class="col-sm-7">
            <select name="categories[]" class="form-control select2" multiple>
                <option value="0">Select</option>
                {% set foo_check1 = data["categories"]|split(',') %}
                {% for value in categories %}
                {% if value.category_id in foo_check1  %} {% set selected = "selected" %}  {% else %} {% set selected = "" %} {% endif %}
                <option value="{{value.category_id}}" {{selected}}>{{value.name}}</option>
                {% endfor %}
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
                {% set foo_check2 = data["regions"]|split(',') %}
                {% for value in regions %}
                {% if value["name"] in foo_check2  %} {% set selected = "selected" %}  {% else %} {% set selected = "" %} {% endif %}
                <option value="{{value.name}}" {{selected}}>{{value.name}}</option>
                {% endfor %}
            </select>
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
