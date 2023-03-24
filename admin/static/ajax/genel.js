var SITE_URL = $("body").attr("data-site");
var PANEL_URL = $("body").attr("data-panel");
$(document).ready(function () {

});
alertify.defaults.glossary.title = 'Açıklama';
alertify.defaults.glossary.ok = 'Tamam';
alertify.defaults.glossary.cancel = 'İptal';
alertify.set('notifier','delay', 5);
alertify.set('notifier','position', 'bottom-right');
//alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";
function alertCagir(jsonData){
    if(jsonData["status"]==true){
        alertify.success(jsonData["message"]);
    }else if(jsonData["status"]==false){
        alertify.error(jsonData["message"]);
    }
}
function bigAlertCagir(jsonData){
    if(!alertify.myAlert){
        //define a new dialog
        alertify.dialog('myAlert',function factory(){
            return{
                main:function(message){
                    this.message = message;
                },
                setup:function(){
                    return {
                        buttons:[{text: "Süper!", key:27/*Esc*/}],
                        focus: { element:0 }
                    };
                },
                prepare:function(){
                    this.setContent(this.message);
                }
            }});
    }
    if(!alertify.errorAlert){
        //define a new errorAlert base on alert
        alertify.dialog('errorAlert',function factory(){
            return{
                build:function(){
                    var errorHeader = '<span class="fa fa-times-circle fa-2x" '
                        +    'style="vertical-align:middle;color:#e10000;">'
                        + '</span> HATA';
                    this.setHeader(errorHeader);
                }
            };
        },true,'alert');
    }
    if(jsonData["status"]==true){
        alertify.myAlert(jsonData["message"]);
        alertCagir(jsonData);
    }else if(jsonData["status"]==false){
        alertify
            .errorAlert(jsonData["message"]);
        alertCagir(jsonData);
    }
}
function form_enter() {
    $(".form-control").keypress(function (e) {
        if (e.which == "13") {
            $(".enterButtons").trigger("click");
        }
    });
}
function modalGetir(dizin,id,modalgetir=null,table=null){
    if(modalgetir){
        modalgetirClass = "modalgetir2";
        modalgetirClass2 = modalgetir+"-";
    }else{
        modalgetirClass = "modalgetir";
        modalgetirClass2 = "modalGetir-";
    }
    $.ajax({
        url: PANEL_URL+dizin,
        type: "post",
        data: {id:id,modal_getir:"modal_getir",table:table} ,
        success: function (data) {
            newData = JSON.parse(data);
            try {
                $("."+modalgetirClass).html(newData["renderView"]);
                $("."+modalgetirClass2).modal();
                //form_enter();
                if($(".select2")){
                    $(document).ready(function() {
                        // $(".select2").select2("destroy");
                        // $(".select2").select2();
                        $(".select2").select2({
                            dropdownParent: $('.'+modalgetirClass2),
                            placeholder: "Select Please",
                            allowClear: true
                        });
                        // $(".select2").trigger('change.select2');
                    });
                }
                if ($(".ckeditor")){
                    $(document).ready(function() {
                        $(".ckeditor").each(function( index, value ) {
                            CKEDITOR.replace(this.id);
                        });
                    });
                }
            }
            catch(err) {
                var jsonData = {"message": "Permission Denied 404","status": false};
                alertCagir(jsonData);
            }
        }
    });
}
function sayfaGetir(dizin,id){
    $.ajax({
        url: PANEL_URL+dizin,
        type: "post",
        data: {id:id} ,
        success: function (data){
            try {
                var htmlData = $.parseHTML(data);
                $('.sayfagetir').append( htmlData );

                //form_enter();
            }
            catch(err) {
                var jsonData = {"message": data+"Permission Denied 404","status": false};
                alertCagir(jsonData);
            }
        }
    });
}
function addCode(dizin=null){
    console.log("dizin",dizin);

    $.ajax({
        type:'POST',
        url: PANEL_URL+dizin,
        data:{id:"0"},
        success:function(response){
            console.log(response);
            var jsonData=JSON.parse(response);
            try {
                $(".code_input").val(jsonData["data"]);
            }
            catch(err) {
                jsonData = {"message": data+"Permission Denied 404","status": false};
                alertCagir(jsonData);
            }
        }
    });
}
function add_line_form(dizin,type=null,id=null,real_id=null){
    $.ajax({
        url: PANEL_URL+dizin,
        type: "post",
        data: {id:id,type:type,real_id:real_id} ,
        success: function (data){
            try {
                var JsonData = JSON.parse(data)
                var htmlData = $.parseHTML(JsonData["renderView"]);

                // if($('.delete_line_form_'+id)){
                //     $('.delete_line_form_'+id).empty();
                //     if(type==null){
                //         $('.delete_line_form_'+id).remove();
                //     }else{
                //         $('.add_line_form').html( htmlData );
                //     }
                // }else{
                //     $('.add_line_form').append( htmlData );
                // }

                $('.delete_line_form_'+id).empty();
                $('.delete_line_form_'+id).remove();
                $('.add_line_form').append( htmlData );
                setTimeout(function(){
                    if ($(".ckeditor2")){
                        $(document).ready(function() {
                            CKEDITOR.replace("new_editor_"+id);
                        });
                    }
                }, 500);

            }
            catch(err) {
                var jsonData = {"message": data+"Permission Denied 404","status": false};
                alertCagir(jsonData);
            }
        }
    });
}
function get_units(dizin,id,class_id){
    $.ajax({
        url: PANEL_URL+dizin,
        type: "post",
        data: {id:id} ,
        success: function (data){
            try {
                var htmlData = JSON.parse(data)["renderView"]
                $('.'+class_id).html( htmlData );

                //form_enter();
            }
            catch(err) {
                var jsonData = {"message": data+"Permission Denied 404","status": false};
                alertCagir(jsonData);
            }
        }
    });
}
function updateURLParameter(url, param, paramVal)
{
    var TheAnchor = null;
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";

    if (additionalURL)
    {
        var tmpAnchor = additionalURL.split("#");
        var TheParams = tmpAnchor[0];
        TheAnchor = tmpAnchor[1];
        if(TheAnchor)
            additionalURL = TheParams;

        tempArray = additionalURL.split("&");

        for (var i=0; i<tempArray.length; i++)
        {
            if(tempArray[i].split('=')[0] != param)
            {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }
    else
    {
        var tmpAnchor = baseURL.split("#");
        var TheParams = tmpAnchor[0];
        TheAnchor  = tmpAnchor[1];

        if(TheParams)
            baseURL = TheParams;
    }

    if(TheAnchor)
        paramVal += "#" + TheAnchor;

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
    // window.location = PANEL_URL + replaceQueryParam('rows', 55, window.location.search)
    // var newURL = updateURLParameter(window.location.href, 'locId', 'newLoc');
    // newURL = updateURLParameter(newURL, 'resId', 'newResId');

    // window.history.replaceState('', '', updateURLParameter(window.location.href, type, id));
}
function select_action(ids,selectall=null){
    if (selectall){
        // Select all
        $('.'+ids).select2('destroy').find('option').prop('selected', 'selected').end().select2();
    }else{
        // Unselect all
        $('.'+ids).select2('destroy').find('option').prop('selected', false).end().select2();
    }
}
function ogretmenGetir(dizin,allserialized,newtype=null){
    var formData = new FormData();
    var submitData = $(allserialized).serializeArray();
    $.each(submitData,function(key,input){
        formData.append(input.name,input.value);
    });
    if (newtype){
        formData.append("type",newtype);
    }else{
        formData.append("type","teachers");
    }
    $.ajax({
        type: "POST",
        url: PANEL_URL+dizin,
        contentType: false,
        processData: false,
        data: formData,
        success: function (data){
            var htmlData = JSON.parse(data);
            // console.log(htmlData);
            try {
               htmlData = JSON.parse(data);
               // console.log(htmlData);
                $('.' + "teachers").html(htmlData["renderView"]);
                if($(".select2")){
                    $(document).ready(function() {
                        // $(".select2").select2("destroy");
                        // $(".select2").select2();
                        $(".select2").select2({
                            dropdownParent: $('.modalGetir-'),
                            placeholder: "Select Please",
                            allowClear: true
                        });
                        // $(".select2").trigger('change.select2');
                    });
                }
            }
            catch(err) {
                var jsonData = {"message": data+"Permission Denied 404","status": false};
                alertCagir(jsonData);
            }
        }
    });
}
function secenekGetir(dizin,type,classes,id=null,class_id=null,lesson_id=null,degree=null,dizinnew=null,selected=null){
    $.ajax({
        url: PANEL_URL+dizin,
        type: "post",
        data: {type:classes,class_id:class_id,lesson_id:lesson_id,id:id,degree:degree,selected:selected} ,
        success: function (data){
            try {
                var htmlData;
                if(dizinnew!==null){
                    if(classes == "class"){
                        $('.lessons').val(null);
                        $('.units').val(null);
                        $('.all-subjects').val(null);
                        $('.all-sub-subjects').val(null);
                        $('.teachers').val(null);
                    }else if(classes == "lessons"){
                        $('.units').val(null);
                        $('.all-subjects').val(null);
                        $('.all-sub-subjects').val(null);
                        $('.teachers').val(null);
                    }else if(classes == "units"){
                        $('.all-subjects').val(null);
                        $('.all-sub-subjects').val(null);
                        $('.teachers').val(null);
                    }else if(classes == "all-subjects"){
                        $('.all-sub-subjects').val(null);
                        $('.teachers').val(null);
                    }else if(classes == "all-sub-subjects"){
                        $('.teachers').val(null);
                    }
                }
                if (classes == "subjects"){
                    htmlData = JSON.parse(data);
                    $('.' + classes).html(htmlData["renderView"]);
                    // $('.units').find('[value="'+id+'"]').remove();
                    document.getElementById("units").disabled = true;
                }else{
                    htmlData = JSON.parse(data);
                    $('.' + classes).html(htmlData["renderView"]);
                }



                //form_enter();
            }
            catch(err) {
                // var jsonData = {"message": data+"Permission Denied 404","status": false};
                // alertCagir(jsonData);
            }
        }
    });
}
function get_table(dizin,id,tabletable=null){
    $.ajax({
        url: PANEL_URL+dizin,
        type: "post",
        data: {id:id} ,
        success: function (data){
            try {
                jsonData = JSON.parse(data);
                // console.log(jsonData);
                if (tabletable){
                    $('.'+tabletable).html("");
                    var htmlData = $.parseHTML(jsonData["renderView"]);
                    $('.'+tabletable).append( htmlData );
                }else{
                    $('.tabletable').html("");
                    var htmlData = $.parseHTML(jsonData["renderView"]);
                    $('.tabletable').append( htmlData );
                }


            }
            catch(err) {
                var jsonData = {"message": data+"Permission Denied 404","status": false};
                alertCagir(jsonData);
                console.log(data);
            }
        }
    });
}
function loadEditor(){
    var myinstances = [];
    for(var i in CKEDITOR.instances) {
        CKEDITOR.instances[i];
        CKEDITOR.instances[i].name;
        CKEDITOR.instances[i].value;
        CKEDITOR.instances[i].updateElement();
        myinstances[CKEDITOR.instances[i].name] = CKEDITOR.instances[i].getData();
    }
    return myinstances;
}
function save_first(button_classes) {
    $("."+button_classes).hide();
    $(".response_content").html("Please save first");
}
function post_gonder(dizin,formclass,id=null,resimler=null,table=null){
    var formlar = "";
    var form_i = "";
    if(typeof formclass=="undefined" || formclass==null){
        formlar = $(".post_gonder");
    }else{
        formlar = $("."+formclass);
    }
    var mecburiAlanlar = [];
    var mecburiAlanlarid = [];
    var tumalanlar = [];
    var deger;
    /* $ Can Alan Kısım Başladı () */

    if ($(".ckeditor")){
        for(kaydet in CKEDITOR.instances)
            CKEDITOR.instances[kaydet].updateElement();
    }
    /* $ Can Alan Kısım Bitti () */
    var formData = new FormData();
    $.each(formlar,function(key2,value){
        var form = document.getElementById(value.id);
        for(var i=0; i < form.elements.length; i++){
            if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')){
                mecburiAlanlar.push(form.elements[i].name);
            }
            if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')){
                mecburiAlanlarid.push(form.elements[i].id);
            }
            tumalanlar.push(form.elements[i].id);
        }
        //console.log(mecburiAlanlar);
        var submitData = $('#'+value.id).serializeArray();
        $.each(submitData,function(key,input){
            formData.append(input.name,input.value);
        });
        formData.append("mecburiAlanlar",mecburiAlanlar);
        formData.append("mecburiAlanlarid",mecburiAlanlarid);
        //console.log(submitData);
    });
    var fileData = $('input[type="file"]');
    $.each(fileData,function(key,input){
        input_name = $(this).attr('name');
        input_files = this.files[0];
        formData.append(input_name,input_files);
    });
    var files = $('input[type="file"]');
    if (files){
        formData.append('files',files);
    }
    if(table) {
        formData.append('table',table);
    }
    // var files_count = files.length;
    // for (var i = 0; i < files_count; i++) {
    //     formData.append(files[i].files[0].name,files[i].files[0].value);
    //     console.log(files[i]);
    // }

    $.ajax({
        type: "POST",
        url: PANEL_URL+dizin,
        contentType: false,
        processData: false,
        data: formData,
        beforeSend: function( xhr ) {
            $(".enterButtons").css("display","none");
        },
        success: function(data)
        {
            try
            {

                var jsonData = JSON.parse(data);
                // alertCagir(jsonData);
                if(jsonData["post_type"]=="edit") {
                    bigAlertCagir(jsonData);
                    // alertCagir(jsonData);
                }else{
                    bigAlertCagir(jsonData);
                    // alertCagir(jsonData);
                }
                if(jsonData["post_type"]=="add" && jsonData["status"]==true) {
                    bigAlertCagir(jsonData);
                    // alertCagir(jsonData);
                    location.reload();
                }
                if(jsonData["status"]==true && jsonData["return"]==true){
                    location.href = jsonData["return"];
                }
                if(jsonData["seflinkdegistir"]==true && jsonData["seflink"]!=false){
                    $(".seflinkdegistir").val(jsonData["seflink"]);
                }
                if(jsonData["status"]==true && jsonData["get_table"]){
                    // get_table(dizin);
                    // location.reload();
                }
                if(jsonData["status"]==false || jsonData["post_type"]=="edit"){
                    if($(".enterButtons")){
                        $(".enterButtons").css("display","");
                    }
                    // if($("#units")){
                    //     document.getElementById("units").disabled = false;
                    // }
                }
                if(jsonData["status"]==true){
                    if($(".enterButtons")){
                        $(".enterButtons").css("display","");
                    }
                    // if($("#units")){
                    //     document.getElementById("units").disabled = false;
                    // }
                }
                if (resimler && id && jsonData["status"]==true){
                    console.log("burda")
                    resimlerGelsin(id,table);
                }
                if (jsonData["status"]==true && jsonData["slides_area"]==true){
                    get_slide_page('slides/page_design','get-page-design',jsonData["head_id"],jsonData["page_no"]);
                }
                if (jsonData["status"]==true && jsonData["forms_area"]==true){
                    get_slide_page('forms/page_design','get-page-design',jsonData["head_id"],jsonData["page_no"]);
                }
            }
            catch(e)
            {
                var jsonData = {"message": "Permission Denied 404","status": false};
                alertCagir(jsonData);
                console.log(data);
            }
        }
    });
}
function kullanıcı_puanı_sifirla(dizin,id=null){
    alertify.confirm('Sıfırlamak istediğinize Eminmisiniz?', 'Bu işlem ayda bir kez yapılır. ', function(){
            $.ajax({
                type: "POST",
                url: PANEL_URL+dizin,
                data: {"id":id},
                success: function(data)
                {
                    try {
                        jsonData = JSON.parse(data);
                        bigAlertCagir(jsonData);
                        if (jsonData["status"]==true && jsonData["refresh"]==true){
                            location.reload();
                        }
                    }catch (e) {
                        $("#tableline-"+id).remove();
                        var jsonData = {"message": "Successfully Deleted","status": true};
                        alertCagir(jsonData);
                    }
                    // console.log(jsonData);
                }
            });
        }
        , function(){
            var jsonData = {"message": "Failed to delete","status": false};
            alertCagir(jsonData);
        }).setting({
        ok: 'OKkkk',
        // cancel button text
        cancel: 'Cancel'
    });
}
function item_delete(dizin,id,sub_headers=null,page_no=null){
    if (sub_headers){
        var jsonData = {"message": "Lütfen Önce Alt Başlıkları Siliniz!","status": false};
        alertCagir(jsonData);
        return false;
    }
    alertify.confirm('Eminmisiniz?', 'Silmek istediğinize Eminmisiniz ? ', function(){
            $.ajax({
                type: "POST",
                url: PANEL_URL+dizin,
                data: {"id":id,page_no:page_no},
                beforeSend: function() {
                    //$('#sifirlandi'+result.alannid).html(mesaj);
                },
                success: function(data)
                {
                    try {
                        jsonData = JSON.parse(data);
                        if(jsonData['status'] == true){
                            $("#tableline-"+id).remove();
                            $("#"+id).remove();
                            alertCagir(jsonData);
                        }else{
                            alertify.confirm(jsonData['message'], function (ev) {
                                alertCagir(jsonData);
                            });
                        }
                        if (jsonData["status"]==true && jsonData["refresh"]==true){
                            location.reload();
                        }
                        if (jsonData["status"]==true && jsonData["get_table"]==true){
                            location.reload();
                        }
                        if (jsonData["status"]==true && jsonData["slides_area"]==true){
                            get_slide_page('slides/page_design','get-page-design',jsonData["head_id"],jsonData["page_no"]);
                        }
                        if (jsonData["status"]==true && jsonData["forms_area"]==true){
                            get_slide_page('forms/page_design','get-page-design',jsonData["head_id"],jsonData["field_no"]);
                        }
                    }catch (e) {
                        $("#tableline-"+id).remove();
                        var jsonData = {"message": "Successfully Deleted","status": true};
                        alertCagir(jsonData);
                    }
                    // console.log(jsonData);
                }
            });
    }
    , function(){
        var jsonData = {"message": "Failed to delete","status": false};
        alertCagir(jsonData);
    }).setting({
        ok: 'OKkkk',
        // cancel button text
        cancel: 'Cancel'
    });
}
function change_status(dizin,id,type){
    var jsonData,buttons;
    $.ajax({
        type: "POST",
        url: PANEL_URL+dizin,
        data: {id:id,type:type},
        success: function(data)
        {
            jsonnewData = JSON.parse(data);
            status =jsonnewData["status"];
            if (type){
                if (type=="sub_status"){
                    if(status=="1"){
                        buttons =  '<span class="fa fa-eye check"></span> Alt Başlıkları Gizle ';
                        jsonData = {"message": "Active ","status": true};
                    }else{
                        buttons = '<span class="fa fa-eye-slash ban"></span> Alt Başlıkları Göster ';
                        jsonData = {"message": "Passive ","status": false};
                    }
                    $(".sub_statusdegistirbuttons-"+id).html(buttons);
                }else if(type=="first_sub_status"){
                    if(status=="1"){
                        renk = "btn-warning";
                        renk2 = "btn-ddd";
                        buttons =  '<span class="fa fa-eye check"></span>  İlk Alt Başlığı Gizle ';
                        jsonData = {"message": "Active ","status": true};
                    }else{
                        renk = "btn-ddd";
                        renk2 = "btn-warning";
                        buttons = '<span class="fa fa-eye-slash ban"></span> İlk Alt Başlığı Göster ';
                        jsonData = {"message": "Passive ","status": false};
                    }
                    $(".first_sub_statusdegistirbuttons-"+id).html(buttons);
                }
                alertCagir(jsonData);

            }else{
                if(status=="1"){
                    renk = "btn-warning";
                    renk2 = "btn-ddd";
                    buttons =  '<span class="fa fa-eye check"></span> Passive ';
                    jsonData = {"message": "Active ","status": true};
                    if($(".onaysiz-id-"+id)){
                        $(".onaysiz-id-"+id).remove();
                    }
                }else{
                    renk = "btn-ddd";
                    renk2 = "btn-warning";
                    buttons = '<span class="fa fa-eye-slash ban"></span> Active ';
                    jsonData = {"message": "Passive ","status": false};
                }
                alertCagir(jsonData);
                $(".durumdegistirbuttons-"+id).html(buttons);
                $(".durumdegistir-"+id).removeClass(renk).addClass(renk2);


            }

        }
    });
}
function find_by_xpath(STR_XPATH) {
    var xresult = document.evaluate(STR_XPATH, document, null, XPathResult.ANY_TYPE, null);
    var xnodes = [];
    var xres;
    while (xres = xresult.iterateNext()) {
        xnodes.push(xres);
    }

    return xnodes;
}
function upload_files(dizin=null,id=null,table=null,multiple=true,allowedTypes="jpg,png,gif,jpeg",file_title=null,refresh=null){
    var settings = {
        url: PANEL_URL+dizin,
        method: "POST",
        enctype: "multipart/form-data", // Upload Form enctype.
        returnType: null,
        allowedTypes: allowedTypes, // List of comma separated file extensions: Default is "*". Example: "jpg,png,gif"
        fileName: "myfile",
        formData: {id:id,table:table,file_title:file_title},
        //maxFileSize:1024*100, // Allowed Maximum file Size in bytes.
        //maxFileCount: 2, // Allowed Maximum number of files to be uploaded
        multiple: true, // If it is set to true, multiple file selection is allowed.
        dragDrop: true, // Drag drop is enabled if it is set to true
        autoSubmit: true, // If it is set to true, files are uploaded automatically. Otherwise you need to call .startUpload function. Default istrue
        showCancel: true,
        showAbort: true,
        showDone: true,
        showDelete: false,
        showError: true,
        showStatusAfterSuccess: false,
        showStatusAfterError: true,
        showFileCounter: true, // Hide the counting of files
        fileCounterStyle: "). ",
        showProgress: true,// Show the progress
        nestedForms: true,
        showDownload:false,
        showPreview:true, // Show images preview
        previewWidth: "100px",
        allowDuplicates: false, // Prevent duplicate files
        duplicateStrict: true, // Note sure?
        downloadCallback:false,
        deleteCallback: false,
        uploadButtonClass: "ajax-file-upload",
        dragDropStr: "<span><b>Drag And Drop</b></span>",
        abortStr: "Cancel",
        cancelStr: "Cancel",
        deletelStr: "Delete",
        doneStr: "Successfull",
        multiDragErrorStr: "Çoklu Dosya Sürükle ve Bırakmaya izin verilmez.",
        extErrorStr: "Müsade edilmez. İzin verilen uzantılar: ",
        sizeErrorStr: "Müsade edilmez. İzin verilen maksimum boyut: ",
        uploadErrorStr: "Yüklemeye izin verilmiyor",
        maxFileCountErrorStr: " Müsade edilmez. İzin verilen maksimum dosya sayısı:",
        downloadStr:"Download",
        showQueueDiv:false,
        statusBarWidth:500,
        dragdropWidth:500,
        onLoad:function(obj){},
        onSelect: function (files) {
            return true;
        },
        onSubmit: function (files, xhr) {},
        onSuccess:function(files, response, xhr,pd)
        {
            console.log(xhr);
            console.log(table);
            $("#status").html("<font color='green'>Running</font>");
            // $("#eventdata").html($("#eventdata").html()+"<br/>Success for: "+JSON.stringify(data));
            // console.log(response);
            // jsonData = JSON.parse(response);
            // if(tablo!="urun"){
            //     $(".resimYukleClass").val(jsonData["id"]);
            //     $(".resimGosterClass").attr("src",SITE_URL+jsonData["resim"]);
            // }else{
            //     resimlerGelsin(table,id);
            // }
        },
        onError: function (files, status, message,pd) {},
        onCancel: function(files,pd) {},
        afterUploadAll:function()
        {
            $("#status").hide();
            $("#status").show();
            $("#status").html("<font color='green'>Completed!</font>");

            var jsonData = {"message": "Completed","status": true};
            alertCagir(jsonData);
            if (refresh){
                location.reload();
            }else{
                if (table){
                    resimlerGelsin(id,table);
                }
            }

        },
        dynamicFormData: function () { // To provide form data dynamically
            return {};
        }
    }
    $("#multiple_file_uploader").uploadFile(settings);
    //resimlerGelsin(id,tablo,grup);
    //ranklama(id,tablo,grup);
    // console.log("welcome");
}
function resimlerGelsin(id,table=null){
    $.ajax({
        type: "POST",
        data: {id:id,table:table},
        url: PANEL_URL+"general/all_files",
        success: function(msg){
            $('.resimlergelsin').html(msg);
        }
    });
}
function delete_files(dizin,id,file_path=null,code=null,table=null){
    alertify.confirm('Are you sure?', 'Are you sure you want to delete it?', function(){
        $.ajax({
            type: "POST",
            url: PANEL_URL+dizin,
            data: {id:id,file_path:file_path,table:table},
            success: function(data)
            {
                jsonData = JSON.parse(data);
                alertCagir(jsonData);
                $(".file_response-"+code).remove();
            }
        });
    }
    , function(){
        var jsonData = {"message": "Failed to delete","status": false};
        alertCagir(jsonData);
    }).setting({
        ok: 'OK',
        // cancel button text
        cancel: 'Cancel'
    });
}
function seflink_kontrol(dizin,seflink,id){
    $.ajax({
        type: "POST",
        data: {seflink:seflink,k_id:id},
        url: PANEL_URL+dizin,
        success: function(data){
            jsonData = JSON.parse(data);
            console.log(jsonData);
            alertCagir(jsonData);
        }
    });
}
function resimDondur(tablo,id,boyut,derece){
    $.ajax({
        type: "POST",
        data: {tablo:tablo,boyut:boyut,derece:derece},
        url: PANEL_URL+"general/resimDondur",
        success: function(msg){
            $(".image-"+id).attr("src",msg);
            //console.log(msg);
        }
    });
}

function ranklama(dizin,id,new_id=null,table=null){
    if (new_id){
        sortable_id = new_id;
    }else{
        sortable_id = "sortable";
    }
    $( "#"+sortable_id ).sortable({
        revert: true,
        update: function(event, ui) {
            var yenirank = $( "#"+sortable_id ).sortable( "toArray" );
            $.ajax({
                type: "POST",
                url: PANEL_URL+dizin,
                data: {rank:yenirank,id:id,table:table}, // serializes the form's elements.
                success: function(data)
                {
                    var jsonData = JSON.parse(data)
                    if (jsonData["status"]==true && jsonData["slides_area"]==true){
                        get_slide_page(table+'/page_design','get-page-design',jsonData["head_id"],jsonData["page_no"]);
                    }if (jsonData["status"]==true && jsonData["forms_area"]==true){
                        get_slide_page(table+'/page_design','get-page-design',jsonData["head_id"],jsonData["page_no"]);
                    }else{
                        jsonData = {"mesaj": "sıralama Başarılı","durum": true};
                        alertCagir(jsonData);
                    }
                }
            });
        },
        stop : function(event, ui){
            //alert($(this).sortable('serialize'));
            //alert($( "#sortable" ).sortable( "toArray", {attribute: 'data-rank'} ).toSource());
        }
    });
    $( "#"+sortable_id ).disableSelection();
}
function desihesapla(id,formclass){
    var formlar = "";
    if(typeof formclass=="undefined" || formclass==null){
        formlar = $(".post_gonder").serialize();
    }else{
        formlar = $("."+formclass).serialize();;
    }
    var formData = new FormData();
    var submitData = $('#post_gonder-12'+id).serializeArray();
    $.each(submitData,function(key,input){
        formData.append(input.name,input.value);
    });
    formData.append("id",id);
    $.ajax({
        type: "POST",
        url: PANEL_URL+"genel/desihesapla",
        contentType: false,
        processData: false,
        data: formData,
        success: function(data)
        {
            var jsonData = JSON.parse(data);
            alertCagir(jsonData);
            console.log(jsonData);
            $(".desihesapla"+id).val(jsonData["desi"]);
        }
    });
}
function secilenler() {
    var secilenler;
}
function ilcegetir(dizin,classVariable,il_kod,ilce_kod=null,okul=null,town_id=null){
    $.ajax({
        type:'POST',
        url: PANEL_URL+dizin,
        data:{county:il_kod,town:ilce_kod,school:okul,town_id:town_id},
        success:function(data){
            var jsonData = JSON.parse(data);
            $('.'+classVariable).html(jsonData["renderView"]);
            if($(".select2")){
                $(document).ready(function() {
                    // $(".select2").select2("destroy");
                    // $(".select2").select2();
                    // jQuery('.select2').remove();
                    // $(".select2").select2({
                    //     dropdownParent: $('.modalGetir-'),
                    //     placeholder: "Select Please",
                    //     allowClear: true
                    // });
                    // $('.select2').val('').trigger('change')
                    // $(".select2").trigger('change.select2');
                    // $('.select2').select2('refresh')
                });
            }
        }
    });
}
function setPageToLeftSidebar() {
    var url = document.URL;
    var sideBar = $('#side-menu');
    var li = sideBar.find("li");
    li.removeClass("active");
    li.removeClass("open");

    var a = sideBar.find("li a");
    var href,baseURI,$a,dataActive,parentLi,parentLiUl;
    $.each(a,function(i,val){
        baseURI = val.baseURI;
        href = null;
        href = val.href;
        $a = $(val);
        dataActive = $a.data("active");

        if(href == baseURI ||  href!=null && href!="undefined" && baseURI.indexOf(dataActive) !== -1 || (dataActive != null && baseURI.indexOf(dataActive.toLocaleLowerCase()) !== -1)){
            parentLi = $a.parents("li");
            parentLiUl = $a.parents("li ul");
            parentLi.addClass("active");
            parentLiUl.addClass("in");
            // console.log(parentLi)
            // parentLi.addClass("open")

            // console.log(href+"-"+i,dataActive);
        }
        // console.log(baseURI);

    })
}
function get_data_from_data(dizin,idVariable,id,input_value=null){
    $.ajax({
        type:'POST',
        url: PANEL_URL+dizin,
        data:{id:id},
        success:function(response){
            if (input_value){
                $('#'+idVariable).val(response);
            }else{
                $('#'+idVariable).html(response);
            }

            if($(".select2")){
                $(document).ready(function() {
                    // $(".select2").select2("destroy");
                    // $(".select2").select2();
                    $(".select2").select2({
                        dropdownParent: $('.modalGetir-'),
                        placeholder: "Select Please",
                        allowClear: true
                    });
                    // $(".select2").trigger('change.select2');
                });
            }
        }
    });
}
function add_new_page(dizin,idVariable,id,table=null,page_no=null){
    alertify.confirm('Slayt Sayfası Eklensin mi?','Eminmisiniz?', function(){
            $.ajax({
                type:'POST',
                url: PANEL_URL+dizin,
                data:{id:id},
                success:function(response){
                    var jsonData;
                    try {
                        jsonData = JSON.parse(response);
                        alertCagir(jsonData);
                        if(table){
                            get_slide_page(table+"/page_design","get-page-design",id,page_no);
                        }else{
                            get_slide_page("slides/page_design","get-page-design",id,page_no);
                        }
                    }
                    catch(err) {
                        jsonData = {"message": data+"Permission Denied 404","status": false};
                        alertCagir(jsonData);
                    }
                }
            });
        }
        , function(){
            var jsonData = {"message": "Eklenemedi","status": false};
            alertCagir(jsonData);
        }).setting({
        ok: 'OK',
        // cancel button text
        cancel: 'Cancel'
    });
}
function get_slide_page(dizin,idVariable,id,page_no,table=null){
    $.ajax({
        type:'POST',
        url: PANEL_URL+dizin,
        data:{id:id,page_no:page_no},
        success:function(response){
            var jsonData;
            try {
                $('#'+idVariable).html(response);
                if(table){
                    get_slide_page_count(table+"/page_count","get-page-count",id,page_no);
                }else{
                    get_slide_page_count("slides/page_count","get-page-count",id,page_no);
                }

            }
            catch(err) {
                jsonData = {"message": data+"Permission Denied 404","status": false};
                alertCagir(jsonData);
            }
        }
    });
}
function get_slide_page_count(dizin,idVariable,id,page_no=null){
    if(page_no==null){
        page_no = 1;
    }
    console.log(page_no);
    $.ajax({
        type:'POST',
        url: PANEL_URL+dizin,
        data:{id:id,page_no:page_no},
        success:function(response){
            var jsonData;
            try {
                $('#'+idVariable).html(response);
            }
            catch(err) {
                jsonData = {"message": data+"Permission Denied 404","status": false};
                alertCagir(jsonData);
            }
        }
    });
}
function get_datatable(dizin,id=null,type=null){
    // console.log(dizin);
    var dataTable = $('.dataTables-dataTables-'+id).DataTable( {
        "order": [[ 0, "desc" ]],
        "pageLength": 50,
        "processing": true,
        "serverSide": true,
        "aLengthMenu": [[25, 50, 100,100000], [25, 50, 100, "Tümü"]],
        responsive: true,
        destroy:true,
        columnDefs: [
            {targets: 0, responsivePriority: 0 },
            // {targets: 2, responsivePriority: 1 },
            // {targets: 5, responsivePriority: 2 },
            {targets:-1,orderable:false}
        ],
        rowId: 0,
        // stateSave: true,
        // "bStateSave": true,
        // "stateDuration": -1,
        dom: '<"html5buttons"B>lTfgtpi',
        buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},

            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
        "ajax":{
            url :PANEL_URL+dizin, // json datasource
            type: "post",  // method  , by default get
            data: {id:id,status:"1",type:type},
            error: function(){  // error handling
                $(".dataTables-dataTables-"+id+"-error").html("");
                $("#dataTables-dataTables-"+id).append('<tbody class="dataTables-dataTables-error"><tr><th colspan="6">Veri Bulunamadı</th></tr></tbody>');
                $("#dataTables-dataTables-"+id+"_processing").css("display","none");
            }
        },
        "fnInitComplete": function(oSettings, json) {
            var cols = oSettings.aoPreSearchCols;
            //var columns = oSettings.aoColumns;
            var input = document.querySelectorAll('.dataTables-dataTables-'+id+' .search-input-text');
            var select = document.querySelectorAll('.dataTables-dataTables-'+id+' .search-input-select');
            $( input ).each(function( index,value ) {
                var i = ( this ).getAttribute("data-column");
                //console.log(i);
                var value = cols[i].sSearch;
                if (value!=null || value!="undefined" ) {
                    try {
                        (this).value = value;
                    }
                    catch(err) {
                        //document.getElementById("demo").innerHTML = err.message;
                    }
                }
            });
            var event = new Event('change');
            $( select ).each(function( index,value ) {
                var i = ( this ).getAttribute("data-column");
                //console.log(i);
                var value = cols[i].sSearch;
                if (value!=null || value!="undefined" ) {
                    try {
                        (this).value = value;
                        //$('.dataTables-dataTables-'+id).DataTable().columns(i).search(value).draw();
                        ( this ).dispatchEvent(event);
                    }
                    catch(err) {
                        //document.getElementById("demo").innerHTML = err.message;
                    }
                }
            });
            //console.log(cols);
        },
        // "language": {
        //     "lengthMenu": "_MENU_ Tane Göster",
        //     "zeroRecords": "Hiçbir şey bulunamadı - üzgünüm",
        //     "info": "_PAGE_ ile _PAGES_ arası _MAX_ içerik",
        //     "infoEmpty": "uygun içerik bulunamadı",
        //     "infoFiltered": "(filtrelenen _MAX_ içerik)",
        //     "paginate": {
        //         "first": "Birinci",
        //         "last": "Son",
        //         "next": "İleri",
        //         "previous": "Geri"
        //     },
        //     "loadingRecords": "Yükleniyor...",
        //     "processing":     "İşleniyor...",
        //     "search":         "Arama:",
        //     "aria": {
        //         "sortAscending":  ": sütunu artan olarak ranklamak için etkinleştir",
        //         "sortDescending": ": sütunu azalan olarak ranklamak için etkinleştir"
        //     }
        // }
    });
    $(".dataTables_filter").css("display","none");  // hiding global search box
    $(".dataTables-dataTables-"+id+" .search-input-text").on( 'change', function () {   // for text boxes
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        dataTable.columns(i).search(v).draw();
    });
    $(".dataTables-dataTables-"+id+" .search-input-select").on( 'change', function () {   // for select box
        var i =$(this).attr('data-column');
        var v =$(this).val();
        dataTable.columns(i).search(v).draw();
    });
}

function clear_function_disabled(){
    console.log("burda");
    document.getElementById("units").disabled = false;
    document.getElementById("units").removeAttribute("disabled");
    document.getElementById("units").setAttribute("disabled","false");
    console.log("burda 2");
}
function nabtabs(){
    $(function(){
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        $('.nav-tabs li a').click(function (e) {
            $(this).tab('show');
            var scrollmem = $('body').scrollTop();
            window.location.hash = this.hash;
            $('html,body').scrollTop(scrollmem);
        });
    });
}
$(function(){
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    $('.nav-tabs li a').click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
    });
});
