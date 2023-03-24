<style>
    .modal-dialog2 {width: 100%;height: 100%;margin: 0;padding: 0;}
    .modal-content2 {height: auto;min-height: 100%;border-radius: 0;}
</style>
<div class="modal fade bd-example-modal-lg modalGetir-" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg modal-dialog2" role="document">
        <div class="modal-content modal-content2">
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
                    .select2-close-mask{z-index: 2099;}
                    .select2-dropdown{z-index: 3051;}
                </style>
                <form method="post" id="post_gonder_headlines" class="form-horizontal bordered-row post_gonder_headlines" data-parsley-validate="" enctype="multipart/form-data">
                    <input type="hidden" name="b_id" value="{{data["id"]|default}}">
                    <div role="tabpanel">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist" id="myTab">
                                    {% for value in languages %}
                                        <li role="presentation" {% if value.rank == 1 %}class="active" {% endif %}>
                                            <a href="#dil_{{value.rank}}" aria-controls="dil_{{value.rank}}" role="tab" data-toggle="tab">
                                                {{value.code}}
                                            </a>
                                        </li>
                                    {% endfor %}
                                    <li role="presentation" {% if value.rank == 1 %}class="active" {% endif %}>
                                        <a href="#genel_ayarlar" aria-controls="genel_ayarlar" role="tab" data-toggle="tab">
                                            Genel Ayarlar
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#multimedia" aria-controls="multimedia" role="tab" data-toggle="tab">
                                            MultiMedia
                                        </a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->

                                    <div class="tab-content">
                                        {% if page_type == "edit" %}
                                            {% for value in language_content %}
                                                <div role="tabpanel" class="tab-pane {% if value.lang == 1 %}active{% endif %}" id="dil_{{value.lang}}">

                                                        <div class="row">
                                                            {% include 'headlines/form.tpl' with value %}
                                                        </div>
                                                </div>
                                            {% endfor %}
                                        {% elseif page_type == "add"  %}
                                            {% for dil in languages %}
                                                {% set dil_rank = dil.rank %}
                                                {% set items = [{ 'dil_rank': dil_rank}] %}
                                                <div role="tabpanel" class="tab-pane {% if dil_rank == 1 %}active{% endif %}" id="dil_{{dil_rank}}">
                                                    <div class="row">
                                                        {% include 'headlines/form.tpl' with items %}
                                                    </div>
                                                </div>
                                            {% endfor %}
                                        {% endif %}
                                        <div role="tabpanel" class="tab-pane genel_ayarlar" id="genel_ayarlar">

                                            <div class="row">
                                                {% include 'headlines/form_sabit.tpl' %}
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane multimedia" id="multimedia">

                                            <div class="row">
                                                {% include 'general/include_multimedia.tpl' %}
                                            </div>
                                        </div>

                                    </div>



                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="btn btn-primary enterButtons" onclick="post_gonder('{{CONTROLLER}}/{{METHOD}}','post_gonder_headlines')">Save</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>