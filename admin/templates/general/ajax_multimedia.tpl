<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="myTab" style="margin-bottom: 30px;">
        <li role="presentation" class="active">
            <a href="#images" aria-controls="images" role="tab" data-toggle="tab">
                Resimler
            </a>
        </li>
        <li role="presentation">
            <a href="#files" aria-controls="files" role="tab" data-toggle="tab">
                Dosyalar
            </a>
        </li>
        <li role="presentation">
            <a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">
                Videolar
            </a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active images" id="images">
            <div class="row">
                <div class="col-md-12" id="sortable_images">
                    {% if images %}
                        {% for value in images %}
                            <div class="file-box file_response-{{value.code|replace({'.': ""})}} sonucune-{{value.code|replace({'.': ""})}}" id="{{value.code|replace({'.': ""})}}" data-rank="{{value.rank}}">
                                <div class="file">
                                    <a href="{{SITE_URL}}{{value.file_path}}" title="{{value.title}}" data-gallery="">
                                        <span class="corner"></span>
                                        <div class="image">
                                            <img alt="image" class="img-fluid"
                                                 src="{{PANEL_URL}}timthumb.php?src={{value.file_path}}&w=267&h=150&zc=2">
                                        </div>
                                    </a>
                                    <div class="file-name">
                                        {{value.title}}
                                        <br>
                                        <small>Added: {{ value.created_at|date("M, d, Y") }} </small>
                                    </div>
                                    <div class="file-name">
                                        <button type="button" onclick="resimDondur('{{value.title}}','90','{{value.id}}','{{table}}')" class="btn btn-xs btn-round btn-black" title="Sola Döndür"><i class="fa fa-rotate-left"></i></button>
                                        <button type="button" onClick="modalGetir('general/modal_multimedia_detail','{{value.code}}','ayrintiModal','{{table}}')" class="btn btn-xs btn-round btn-black" title="Resmin Ayrıntılarını düzenle"><i class="fa fa-edit"></i></button>
                                        <button type="button" onclick="delete_files('general/delete_files', '{{value.code}}','{{value.file_path}}','{{value.code|replace({'.': ""})}}','{{table}}')" class="btn btn-xs btn-round btn-black" title="Resmi Sil"><i class="fa fa-close"></i></button>
                                        <button type="button" onclick="resimDondur('{{value.title}}','-90','{{value.id}}','{{table}}')" class="btn btn-xs btn-round btn-black" title="Sağa Döndür"><i class="fa fa-rotate-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                    {% else %}

                        Upload From Select Files Button

                    {% endif %}
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane files" id="files">
            <div class="row">
                <div class="col-md-12" id="sortable_files">
                    {% if files %}
                        {% for value in files %}
                        <div class="file-box file_response-{{value.code|replace({'.': ""})}} sonucune-{{value.code|replace({'.': ""})}}" id="{{value.code|replace({'.': ""})}}" data-rank="{{value.rank}}">
                            <div class="file">
                                <a href="{{PANEL_URL}}{{value.file_path}}" title="{{value.title}}" data-gallery="">
                                    <span class="corner"></span>
                                    <div class="image">
                                        <img alt="image" class="img-fluid" src="{{PANEL_URL}}timthumb.php?src=static/images/{{value.file_type}}.png&w=267&h=150&zc=2">
                                    </div>
                                </a>
                                <div class="file-name">
                                    {{value.title}}
                                    <br>
                                    <small>Added: {{ value.created_at|date("M, d, Y") }} </small>
                                </div>
                                <div class="file-name">
                                    <button type="button" onClick="modalGetir('general/modal_multimedia_detail','{{value.code}}','ayrintiModal','{{table}}')" class="btn btn-xs btn-round btn-black" title="Resmin Ayrıntılarını düzenle"><i class="fa fa-edit"></i></button>
                                    <button type="button" onclick="delete_files('general/delete_files', '{{value.code}}','{{value.file_path}}','{{value.code|replace({'.': ""})}}','{{table}}')" class="btn btn-xs btn-round btn-black" title="Resmi Sil"><i class="fa fa-close"></i></button>
                                </div>
                            </div>
                        </div>
                        {% endfor %}
                    {% else %}

                        Upload From Select Files Button

                    {% endif %}
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane videos" id="videos">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" id="post_gonder_videos" class="form-horizontal bordered-row post_gonder_videos" data-parsley-validate="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label >Video Link</label>
                                                <input type="hidden" name="b_id" value="{{id|default}}"/>
                                                <input type="text" name="file_path" placeholder="http://Youtube Link" value="" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label >Title</label>
                                                <input type="text" name="title" placeholder="Title" value="{{value["title"]|default}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label >Description</label>
                                                <textarea name="description" placeholder="Description" class="form-control" data-parsley-id="13311"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="javascript:void(0)" class="btn btn-primary enterButtons" onclick="post_gonder('general/add_videos','post_gonder_videos','{{id}}','resimler','{{table}}')">Save</a>
                                    </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="col-md-12" id="sortable_videos">
                    {% for value in videos %}
                        <div class="file-box file_response-{{value.code|replace({'.': ""})}} sonucune-{{value.code|replace({'.': ""})}}" id="{{value.code|replace({'.': ""})}}" data-rank="{{value.rank}}">
                            <div class="file">
                                <a href="{{value.file_path}}" target="_blank" title="{{value.title}}">
                                    <span class="corner"></span>
                                    <div class="image">
                                        <img alt="image" class="img-fluid" src="{{PANEL_URL}}timthumb.php?src={{actions.video_resim_getir(value.file_path)}}&w=267&h=150&zc=2">
                                    </div>
                                </a>
                                <div class="file-name">
                                    {{actions.kisalt(value.title,10)}}
                                    <br>
                                    <small>Added: {{ value.created_at|date("M, d, Y") }} </small>
                                </div>
                                <div class="file-name">
                                    <button type="button" onClick="modalGetir('general/modal_multimedia_detail','{{value.code}}','ayrintiModal','{{table}}')" class="btn btn-xs btn-round btn-black" title="Resmin Ayrıntılarını düzenle"><i class="fa fa-edit"></i></button>
                                    <button type="button" onclick="delete_files('general/delete_files', '{{value.code}}','{{value.file_path}}','{{value.code|replace({'.': ""})}}','{{table}}')" class="btn btn-xs btn-round btn-black" title="Video Sil"><i class="fa fa-close"></i></button>
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $( document ).ready(function() {
        nabtabs();
        console.log(window.location.hash);
        if(window.location.hash == "#files"){
            ranklama('general/files_rank','{{id}}','sortable_files','{{table}}');
        }else if(window.location.hash == "#videos"){
            ranklama('general/files_rank','{{id}}','sortable_videos','{{table}}');
        }else{
            ranklama('general/files_rank','{{id}}','sortable_images','{{table}}');
        }
        $('.nav-tabs li a').click(function (e) {
            if(this.hash == "#files"){
                ranklama('general/files_rank','{{id}}','sortable_files','{{table}}');
            }else if(this.hash == "#videos"){
                ranklama('general/files_rank','{{id}}','sortable_videos','{{table}}');
            }else{
                ranklama('general/files_rank','{{id}}','sortable_images','{{table}}');
            }
        });
    });
</script>