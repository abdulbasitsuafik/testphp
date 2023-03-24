
<option value="">Seçiniz</option>
{% for value in array %}
    <option value="{{value.id}}" {% if selected == value.id %} selected {% endif %}>{{value.baslik}}</option>
{% endfor %}
