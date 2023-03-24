{% extends 'base.tpl' %}
{% block action_area %}
    <a href="javascript:void(0)" onclick="modalGetir('{{CONTROLLER}}/add')" class="btn btn-primary">Add</a>
{% endblock %}
{% block body %}
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Authority</th>
            <th>Created At</th>
            <th width="20%">Actions</th>
        </tr>
        </thead>
        <tbody class="tabletable">

        </tbody>
        <tfoot>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Authority</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </tfoot>
    </table>

</div>

{% endblock %}
{% block new_scripts %}
<script>
    $( document ).ready(function() {
        get_table('{{CONTROLLER}}/get_table');
    });
</script>
{% endblock %}