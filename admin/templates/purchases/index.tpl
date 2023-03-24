{% extends 'base.tpl' %}
{% block action_area %}

    <!--<a href="javascript:void(0)" onclick="modalGetir('{{CONTROLLER}}/add')" class="btn btn-primary">Ekle</a>
    -->
{% endblock %}
{% block body %}
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example---- dataTables-dataTables-2" >
        <thead>
        <tr>
            <th>Id</th>
            <th>Kullanıcı</th>
            <th>Ödeme Methodu</th>
            <th>card_id</th>
            <th>Araç</th>
            <th>Ürün</th>
            <th>custom_price</th>
            <th>Başlangıç</th>
            <th>Bitiş</th>
            <th>drive_id</th>
            <th>Kullanım D.</th>
            <th>Ödeme</th>
            <th>Created At</th>
            <th width="20%">Actions</th>
        </tr>

        </thead>
        <thead>
            <td><input style='width:100%;' type="text" data-column="0"  class="form-control search-input-text"></th>
            <th><input style='width:100%;' type="text" data-column="1"  class="form-control search-input-text" placeholder=""></th>

            <th><input style='width:100%;' type="text" data-column="2"  class="form-control search-input-text"></th>
            <th><input style='width:100%;' type="text" data-column="3"  class="form-control search-input-text"></th>
            <th>
                <select data-column="4"  class="search-input-select form-control select2">
                    <option value="">Seçiniz</option>
                    {% for value in roles %}
                        <option value="{{value.id}}">{{value.name}}</option>
                    {% endfor %}
                </select>
            </th>
            <th><input style='width:100%;' type="number" data-column="6"  class="form-control search-input-text"></th>
            <th></th>
            <th><input style='width:100%;' type="text" name="daterange" data-column="5"  class="form-control search-input-text daterange"></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </thead>
        <tbody class="tabletable ">

        </tbody>
        <tfoot>
        <tr>
            <th>Id</th>
            <th>Kullanıcı</th>
            <th>Ödeme Methodu</th>
            <th>card_id</th>
            <th>Araç</th>
            <th>Ürün</th>
            <th>custom_price</th>
            <th>Başlangıç</th>
            <th>Bitiş</th>
            <th>drive_id</th>
            <th>Kullanım D.</th>
            <th>Ödeme</th>
            <th>Created At</th>
            <th width="20%">Actions</th>
        </tr>
        </tfoot>
    </table>

</div>

{% endblock %}
{% block new_scripts %}
<script>
    $( document ).ready(function() {
        //get_table('{{CONTROLLER}}/get_table');
        get_datatable('{{CONTROLLER}}/dataListe','2');
        // $('.datarange').daterangepicker();

    });
</script>
{% endblock %}
