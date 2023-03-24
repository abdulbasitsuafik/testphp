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
                <form method="post" id="post_gonder_settings" class="form-horizontal bordered-row post_gonder_settings" data-parsley-validate="" enctype="multipart/form-data">

                    <div role="tabpanel">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="myTab">
                            <li role="presentation" class="active">
                                <a href="#general" aria-controls="general" role="tab" data-toggle="tab">
                                    General
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#mobil" aria-controls="mobil" role="tab" data-toggle="tab">
                                    Mobil
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#logo_settings" aria-controls="logo_settings" role="tab" data-toggle="tab">
                                    Logo
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#form_mail" aria-controls="form_mail" role="tab" data-toggle="tab">
                                    Form mail
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#contact_information" aria-controls="contact_information" role="tab" data-toggle="tab">
                                    Contact information
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#socail_media" aria-controls="socail_media" role="tab" data-toggle="tab">
                                    Social Media
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#copyright_settings" aria-controls="copyright_settings" role="tab" data-toggle="tab">
                                    Copyright Settings
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#form_languages" aria-controls="form_languages" role="tab" data-toggle="tab">
                                    Languages
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active general" id="general">

                                <div class="row">
                                    {% include 'settings/form_general.tpl' %}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane  mobil" id="mobil">

                                <div class="row">
                                    {% include 'settings/form_mobil.tpl' %}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane  logo_settings" id="logo_settings">

                                <div class="row">
                                    {% include 'settings/form_logo.tpl' %}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane form_mail" id="form_mail">

                                <div class="row">
                                    {% include 'settings/form_email.tpl' %}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane contact_information" id="contact_information">

                                <div class="row">
                                    {% include 'settings/form_contact.tpl' %}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane socail_media" id="socail_media">

                                <div class="row">
                                    {% include 'settings/form_social.tpl' %}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane copyright_settings" id="copyright_settings">

                                <div class="row">
                                    {% include 'settings/form_copyright.tpl' %}
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane form_languages" id="form_languages">

                                <div class="row">
                                    {% include 'settings/form_languages.tpl' %}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="btn btn-primary enterButtons" onclick="post_gonder('{{CONTROLLER}}/{{METHOD}}','post_gonder_settings')">Save</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
