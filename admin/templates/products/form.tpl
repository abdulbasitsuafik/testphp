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
            <label class="col-sm-2 col-form-label">Type* </label>
        </div>
        <div class="col-sm-8">
            <select class="form-control m-b " name="type" data-placeholder="Select Please" required>
                <option value=""></option>
                <!--<option value="subscription" {% if "subscription" == data.type  %} selected {% endif %}>subscription</option>
                <option value="product" {% if "product" == data.type  %} selected {% endif %}>product</option>-->
                <option value="kontor" {% if "kontor" == data.type  %} selected {% endif %}>Kontor</option>
                <option value="surus" {% if "surus" == data.type  %} selected {% endif %}>Sürüş</option>
                <option value="rezervasyon" {% if "rezervasyon" == data.type  %} selected {% endif %}>Rezervasyon</option>
                <option value="rezervasyon_iptal" {% if "rezervasyon_iptal" == data.type  %} selected {% endif %}>Rezervasyon İptal</option>
                <option value="teslimat" {% if "teslimat" == data.type  %} selected {% endif %}>Teslimat</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Description* </label>
        </div>
        <div class="col-sm-8">
            <input type="text" name="description" class="form-control" value="{{data.description|default}}" id="description" required>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Price* </label>
        </div>
        <div class="col-sm-8">
            <input type="number" name="price" class="form-control" value="{{data.price|default}}" id="price" required>
        </div>
    </div><hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Per Price* </label>
        </div>
        <div class="col-sm-8">
            <input type="number" name="per_price" class="form-control" value="{{data.per_price|default}}" id="per_price" required>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Period* </label>
        </div>
        <div class="col-sm-8">
            <select class="form-control m-b " name="period" data-placeholder="Select Please">
                <option value=""></option>
                <option value="30" {% if "30" == data.period  %} selected {% endif %}>30</option>
                <option value="60" {% if "60" == data.period  %} selected {% endif %}>60</option>
                <option value="90" {% if "90" == data.period  %} selected {% endif %}>90</option>
                <option value="120" {% if "120" == data.period  %} selected {% endif %}>120</option>
                <option value="150" {% if "150" == data.period  %} selected {% endif %}>150</option>
                <option value="180" {% if "180" == data.period  %} selected {% endif %}>180</option>
                <option value="210" {% if "210" == data.period  %} selected {% endif %}>210</option>
                <option value="240" {% if "240" == data.period  %} selected {% endif %}>240</option>
                <option value="270" {% if "270" == data.period  %} selected {% endif %}>270</option>
                <option value="300" {% if "300" == data.period  %} selected {% endif %}>300</option>
                <option value="330" {% if "330" == data.period  %} selected {% endif %}>330</option>
                <option value="360" {% if "360" == data.period  %} selected {% endif %}>360</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">SKU* </label>
        </div>
        <div class="col-sm-8">
            <input type="text" name="sku" class="form-control" value="{{data.sku|default}}" id="sku" required>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Image* </label>
        </div>
        <div class="col-sm-8">
            <select class="form-control m-b " name="image" data-placeholder="Select Please">
                <option value=""></option>
                <option value="green" {% if "green" == data.image  %} selected {% endif %}>green</option>
                <option value="purple" {% if "purple" == data.image  %} selected {% endif %}>purple</option>
                <option value="blue" {% if "blue" == data.image  %} selected {% endif %}>blue</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Color* </label>
        </div>
        <div class="col-sm-8">
            <select class="form-control m-b " name="color" data-placeholder="Select Please">
                <option value=""></option>
                <option value="green" {% if "green" == data.color  %} selected {% endif %}>green</option>
                <option value="purple" {% if "purple" == data.color  %} selected {% endif %}>purple</option>
                <option value="blue" {% if "blue" == data.color  %} selected {% endif %}>blue</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-4">
            <label class="col-sm-2 col-form-label">Ios ID* </label>
        </div>
        <div class="col-sm-8">
            <input type="number" name="ios_id" class="form-control" value="{{data.ios_id|default}}" id="ios_id">
        </div>
    </div>
</div>

