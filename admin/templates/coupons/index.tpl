{% extends 'base.tpl' %}
{% block action_area %}

    <a href="javascript:void(0)" onclick="modalGetir('{{CONTROLLER}}/add')" class="btn btn-primary">Add</a>
{% endblock %}
{% block body %}
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example---- dataTables-dataTables-2" >
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>short_name</th>
            <th>description</th>
            <th>start_date</th>
            <th>end_date</th>
            <th>promocode</th>
            <th>promolink</th>
            <th>discount</th>
            <th>species</th>
            <th>code_type</th>
            <th>cashback</th>
            <th>source</th>
            <th>rating</th>
            <th>exclusive</th>
            <th>language</th>
            <th>types</th>
            <th>coupon_id</th>
            <th>image</th>
            <th>categories</th>
            <th>regions</th>
            <th>store_id</th>
            <th>updated_by</th>
            <th>created_at</th>
            <th width="20%">Actions</th>
        </tr>

        </thead>
        <thead>
            <td><input style='width:100%;' type="text" data-column="0"  class="form-control search-input-text"></th>
            <th><input style='width:100%;' type="text" data-column="1"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="2"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="3"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="4"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="5"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="6"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="7"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="8"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="9"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="10"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="11"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="12"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="13"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="14"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="15"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="16"  class="form-control search-input-text" placeholder=""></th>
            <th><input style='width:100%;' type="text" data-column="17"  class="form-control search-input-text" placeholder=""></th>

            <th></th>
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
            <th>Name</th>
            <th>short_name</th>
            <th>description</th>
            <th>start_date</th>
            <th>end_date</th>
            <th>promocode</th>
            <th>promolink</th>
            <th>discount</th>
            <th>species</th>
            <th>code_type</th>
            <th>cashback</th>
            <th>source</th>
            <th>rating</th>
            <th>exclusive</th>
            <th>language</th>
            <th>types</th>
            <th>coupon_id</th>
            <th>image</th>
            <th>categories</th>
            <th>regions</th>
            <th>store_id</th>
            <th>updated_by</th>
            <th>created_at</th>
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
