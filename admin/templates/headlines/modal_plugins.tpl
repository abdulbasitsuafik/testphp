
<div class="modal fade bd-example-modal-lg modalGetir-" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{title|default}}
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
                <form method="post" id="post_gonder100" class="form-horizontal bordered-row post_gonder100" data-parsley-validate="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Eklenti Klasörü Seç</label>
                                <div class="col-sm-6">
                                    <input type="hidden" name="head_id" value="{{id}}">
                                    <select name="folder" class="form-control select2" onchange="get_data_from_data('{{CONTROLLER}}/plugins_files','modulsec_select',this.value);">
                                        <option value=""  style="display: none;">Seçim Yapınız</option>
                                        {{plugins_folders}}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Modül Seç (.tpl)</label>
                                <div class="col-sm-6">
                                    <select name="tpl_path" class="form-control select2" id="modulsec_select">
                                        <option value="" style="display: none;">Önce klasör seçimi yapınız</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Alt Başlıklara Uygulansınmı ?</label>
                                <div class="col-sm-6">
                                    <select name="altauygula" class="form-control select2">
                                        <option value="">Seçim Yapınız</option>
                                        <option value="1">Evet</option>
                                        <option value="0" selected>Hayır</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="infom"></div>
                        <div class="myadmin-dd-empty dd" id="nestable2">
                            <ol class="dd-list">
                                {{nestable_items_for_plugins}}
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="btn btn-primary enterButtons" onclick="post_gonder('{{CONTROLLER}}/{{METHOD}}','post_gonder100')">Save</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>