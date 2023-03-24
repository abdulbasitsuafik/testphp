<br>
{% if value.lang|default %}
    {% set deger = value.lang|default %}
{% else %}
    {% set deger = items[0].dil_rank|default %}
{% endif %}
<div class="col-md-4">
    <div class="form-group row">
        <div class="col-sm-12">
            <label >Title</label>
            <input type="text" name="title_{{deger|default}}" placeholder="Title" value="{{value["title"]|default}}" {% if deger == 1 %}required {% endif %} class="form-control enterButton">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <label >Description</label>
                <textarea name="description_{{deger|default}}" placeholder="Description" class="form-control" data-parsley-id="13311">{{value["description"]|default}}</textarea>
        </div>
    </div>

</div>

<div class="col-md-4">
    <div class="form-group row">
        <div class="col-sm-12">
            <label>Keywords</label>
            <input type="text" name="keywords_{{deger|default}}" placeholder="Keywords" value="{{value["keywords"]|default}}" class="form-control enterButton">
        </div>
    </div>
</div>
<div class="col-md-4">

    <div class="form-group row">
        <div class="col-sm-12">
            <label>Seflink</label>
            <input type="text" name="seflink_{{deger|default}}" value="{{value["seflink"]|default}}" placeholder="Seflink alanı boş kalırsa otomatik oluşturulur" class="form-control enterButton">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <label>Açıklama(ek)</label>
            <textarea name="ek_description_{{deger|default}}" placeholder="Kısa Açıklama" class="form-control" data-parsley-id="1331">{{value["ek_description"]|default}}</textarea>
        </div>
    </div>

</div>
<div class="col-md-12">
    <div class="form-group row">

        <div class="col-sm-12">
            <label>İçerik</label>
            <textarea class="ckeditor" id="editor_{{deger|default}}" name="content_{{deger|default}}">
                {{value["content"]|default}}
            </textarea>
        </div>
    </div>
</div>