<style>
    .modal-dialog2 {width: 100%;height: 100%;margin: 0;padding: 0;}
    .modal-content2 {height: auto;min-height: 100%;border-radius: 0;}
</style>
<div class="modal fade bd-example-modal-lg modalGetir-" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg modal-dialog2" role="document">
        <div class="modal-content modal-content2">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.modalgetir').html('');location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">
                    {{title|default}}
                </h5>
            </div>
            <div class="modal-body">
                <div style="width:100%;">
                    <style>
                        .video-js {
                            width: 720px;
                            height: 480px;
                            margin-left: auto;
                            margin-right: auto;
                        }
                    </style>
                    <video id="example_video_1" class="video-js vjs-default-skin"
                           controls preload="auto" width="1280" height="720"
                           poster="http://video-js.zencoder.com/oceans-clip.png"
                           data-setup='{"controls":true,"autoplay":false,"preload":"auto"}' autoplay>
                        <source src="{{url}}" type="video/mp4" />
                        <source src="{{url}}" type="video/webm" />
                        <source src="{{url}}" type="video/ogg" />
                        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                    </video>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('.modalgetir').html('');location.reload();">Kapat</button>
            </div>
        </div>
    </div>
</div>
