<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Name* </label>
        </div>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control" value="{{data.name|default}}" id="namearea" required>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Value* </label>
        </div>
        <div class="col-sm-8">
            <select class="form-control m-b " name="value" data-placeholder="Select Please" required>
                <option value="">Seçiniz</option>
                {% for i in 5..8 %}
                    {% if i == data.value  %} {% set selected = "selected" %}  {% else %} {% set selected = "" %} {% endif %}
                    <option value="{{i}}" {{selected}}>{{i}}</option>
                {% endfor %}
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Option Count* </label>
        </div>
        <div class="col-sm-8">
            <select class="form-control m-b " name="option_count" data-placeholder="Select Please" required>
                <option value="">Seçiniz</option>
                {% for i in 4..4 %}
                {% if i == data.option_count  %} {% set selected = "selected" %}  {% else %} {% set selected = "" %} {% endif %}
                    <option value="{{i}}" {{selected}}>{{i}}</option>
                {% endfor %}
            </select>
        </div>
    </div>
</div>

