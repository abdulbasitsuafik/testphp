
<div class="modal fade bd-example-modal-lg modalGetir-" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{data[0].name}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <style>
                    .select2-close-mask{
                        z-index: 2099;
                    }
                    .select2-dropdown{
                        z-index: 3051;
                    }
                </style>
                <form method="post" action="javascript:void(0)" class="post_gonder100" id="post_gonder100">
                    <input type="hidden" name="b_id" value="{{data.id|default}}">
                    <div class="row">
                        {% include ""~CONTROLLER~"/form.tpl" %}
                        <div class="col-sm-4">
                            <div class="form-group row">
                                <div class="col-sm-12 col-sm-offset-2 left">
                                    <!--<button class="btn btn-white" type="reset">Reset</button>-->
                                    <a href="javascript:void(0)" class="btn btn-primary enterButtons" onclick="post_gonder('{{CONTROLLER}}/{{METHOD}}','post_gonder100')">Save</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <!--<button type="button" class="btn btn-primary" onclick="post_gonder('{{CONTROLLER}}/{{METHOD}}','post_gonder3')">Kaydet</button>-->
            </div>
        </div>
    </div>
</div>
