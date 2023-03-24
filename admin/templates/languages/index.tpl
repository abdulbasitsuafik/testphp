{% extends 'base.tpl' %}
{% block action_area %}
<a href="javascript:void(0)" onclick="modalGetir('{{CONTROLLER}}/add')" class="btn btn-primary">Add</a>
{% endblock %}
{% block body %}
{{dump(general_settings)}}
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example---- dataTables-dataTables-2" >
        <thead>
        <tr>
            <th>Id</th>
            <th>Adı</th>
            <th>Kodu</th>
            <th>Sıra</th>
            <th>Status</th>
            <th width="5%">Actions</th>
        </tr>

        </thead>
        <thead>
        <td><input style='width:100%;' type="text" data-column="0"  class="form-control search-input-text"></th>
        <th><input style='width:100%;' type="text" data-column="1"  class="form-control search-input-text" placeholder=""></th>

        <th><input style='width:100%;' type="text" data-column="2"  class="form-control search-input-text"></th>
        <th><input style='width:100%;' type="text" data-column="3"  class="form-control search-input-text"></th>
        <th></th>
        <th></th>
        </thead>
        <tbody class="tabletable ">

        </tbody>
        <tfoot>
        <tr>
            <th>Id</th>
            <th>Adı</th>
            <th>Kodu</th>
            <th>Sıra</th>
            <th>Status</th>
            <th width="5%">Actions</th>
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
