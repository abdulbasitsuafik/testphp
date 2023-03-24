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
                {% include 'general/include_multimedia.tpl' %}
            </div>
            <div class="modal-footer">
                <!--<a href="javascript:void(0)" class="btn btn-primary enterButtons" onclick="post_gonder('{{CONTROLLER}}/{{METHOD}}','post_gonder100')">Save</a>-->
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>