/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	 config.height = '30em';
	 config.language = 'tr';
	 config.contentsLanguage = 'tr';
	 config.toolbarCanCollapse = true;
	 config.extraPlugins = 'lineheight,FMathEditor';
	 // config.extraPlugins = 'FMathEditor';
     config.toolbar = [
		{ name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
		{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'HiddenField' ] },
		'/',
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
		'/',

		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
		{ name: 'about', items: [ 'About','lineheight'] },
		{ name: 'MathEditor', items: [ 'MathEditor','FMathEditor'] }
	];
	// ...
	var don = 0;
    var panel_tema = $("html").attr("data-paneltema");
    var date= new Date();
    var newdate = Date.parse(date);
	$("textarea.ckeditor").each(function () {
	    don++;
	    $(this).attr("id","richeditor-"+don+"-"+newdate);
		config.filebrowserBrowseUrl = panel_tema+'assets/plugins/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
		config.filebrowserImageBrowseUrl = panel_tema+'assets/plugins/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
		config.filebrowserFlashBrowseUrl = panel_tema+'assets/plugins/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
		config.filebrowserUploadUrl = panel_tema+'assets/plugins/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
		config.filebrowserImageUploadUrl = panel_tema+'assets/plugins/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
		config.filebrowserFlashUploadUrl = panel_tema+'assets/plugins/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
	});
};
CKEDITOR.env.isCompatible = true;
CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
CKEDITOR.config.forcePasteAsPlainText = true;
CKEDITOR.config.pasteFromWordPromptCleanup = true;
CKEDITOR.config.pasteFromWordNumberedHeadingToList = true;
CKEDITOR.config.pasteFromWordRemoveStyles = false;
CKEDITOR.on("instanceReady", function(event) {
	event.editor.on("beforeCommandExec", function(event) {
		// Show the paste dialog for the paste buttons and right-click paste
		if (event.data.name == "paste") {
			event.editor._.forcePasteDialog = true;
		}
		// Don't show the paste dialog for Ctrl+Shift+V
		if (event.data.name == "pastetext" && event.data.commandData.from == "keystrokeHandler") {
			event.cancel();
		}
	})
});

