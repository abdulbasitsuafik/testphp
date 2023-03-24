<div style="margin-top:25px;">
    <div class="row">
        <div class="col-sm-9 file_titles_area">
            <div class="controls-row">
                <div class="col-md-3"><strong>Select Files :</strong></div>
                <div class="col-md-9">
                    <div id="status"></div>
                    <div id="multiple_file_uploader">Select Files </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                <div class="col-lg-12 resimlergelsin">

                </div>
            </div>
            <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
            <div id="blueimp-gallery" class="blueimp-gallery">
                <div class="slides"></div>
                <h3 class="title"></h3>
                <a class="prev">‹</a>
                <a class="next">›</a>
                <a class="close">×</a>
                <a class="play-pause"></a>
                <ol class="indicator"></ol>
            </div>

        </div>
    </div>
</div>
<script>
    $( document ).ready(function() {
        upload_files('general/upload_files', '{{id}}', "{{CONTROLLER}}", "", "jpg,jpeg,png,gif,pdf,docx,doc","file_title");
        resimlerGelsin('{{id}}','{{CONTROLLER}}');
    });
</script>