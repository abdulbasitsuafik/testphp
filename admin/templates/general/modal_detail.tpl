
<div class="modal fade bd-example-modal-lg ayrintiModal-" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{title|default}}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <style>
                    .select2-close-mask{z-index: 2099;}
                    .select2-dropdown{z-index: 3051;}
                </style>
                <form action="javascript:void(0)" id="post_gonder_files_detail" class="post_gonder_files_detail" method="post" data-parsley-validate="">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            {% for value in active_languages %}
                                <li role="presentation" {% if value.rank == "1" %}class="active"{% endif %}>
                                    <a href="#lang_{{value.rank}}" aria-controls="lang_{{value.rank}}" role="tab" data-toggle="tab">{{value.code}}</a>
                                </li>
                            {% endfor %}
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content" style="margin-top:50px;">

                            {% for value in files_detail_single %}
                                <div role="tabpanel" class="tab-pane {% if value.lang == "1" %}active{% endif %}" id="lang_{{value.lang}}">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label">Resim Başlığı</label>
                                                    <div class="col-sm-2">
                                                        <div class="thumbnail-box">
                                                            <div class="thumb-overlay bg-black"></div>
                                                            <img style="height:150px;" src="{{SITE_URL}}timthumb.php?src={{files_single.resim_link}}&w=267&h=150&zc=1" alt="{{value.title}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="hidden" name="code_{{value.lang}}" value="{{value.code}}"/>
                                                        <input type="text" name="title_{{value.lang}}" placeholder="Resim Başlığı" class="form-control" value="{{value.title}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 control-label">Resim İçeriği</label>
                                                    <div class="col-sm-6">
                                                        <textarea style="width: 100%;" class="ckeditor" id="ckeditor5555_{{value.lang}}" name="content_{{value.lang}}" rows="10">{{value.content}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                            {% endfor %}

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="post_gonder('general/files_detail_update','post_gonder_files_detail','','','{{table}}')">Save</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>