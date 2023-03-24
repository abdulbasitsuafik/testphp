{% extends 'base.tpl' %}
{% block action_area %}
    <!--<a href="{{site_adresi}}{{controller}}/add" class="btn btn-primary">Add</a>-->
{% endblock %}
{% block body %}
<div class="row">
    <div class="col-md-4">
        <div class="ibox">
            <div class="ibox-title">
                <h5> {{title}} Ekle</h5>
            </div>
            <div class="ibox-content">
                <form method="post" action="javascript:void(0)" class="form-horizontal post_gonder" id="post_gonder">
                    <div class="row">

                        {% include ""~CONTROLLER~"/form.tpl" %}
                        <div class="col-sm-4">
                            <div class="form-group row">
                                <div class="col-sm-12 col-sm-offset-2 left">
                                    <!--<button class="btn btn-white" type="reset">Reset</button>-->
                                    <a href="javascript:void(0)" class="btn btn-primary enterButtons" onclick="post_gonder('{{CONTROLLER}}/{{METHOD}}')">Save</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="ibox">
            <div class="ibox-title">
                <h5>{{title}} Listesi</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Adı</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>price</th>
                                <th>per_price</th>
                                <th>period</th>
                                <th>sku</th>
                                <th>image</th>
                                <th>color</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="tabletable">

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Adı</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>price</th>
                                <th>per_price</th>
                                <th>period</th>
                                <th>sku</th>
                                <th>image</th>
                                <th>color</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>




{% endblock %}
{% block new_scripts %}
<script>
    $( document ).ready(function() {
        get_table('{{CONTROLLER}}/get_table');
    });
</script>
{% endblock %}
