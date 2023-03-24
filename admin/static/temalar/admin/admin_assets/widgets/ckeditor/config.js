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
	 config.extraPlugins = 'lineheight';
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
		{ name: 'about', items: [ 'About','lineheight'] }
	];
	// ...
	var don = 0;
	var panel_public = $("html").attr("data-panelpublic");
	$("textarea.ckeditor").each(function () {
	    don++;
	    $(this).attr("id","richeditor"+don);
		config.filebrowserBrowseUrl = panel_public+'assets/widgets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
		config.filebrowserImageBrowseUrl = panel_public+'assets/widgets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
		config.filebrowserFlashBrowseUrl = panel_public+'assets/widgets/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
		config.filebrowserUploadUrl = panel_public+'assets/widgets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
		config.filebrowserImageUploadUrl = panel_public+'assets/widgets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
		config.filebrowserFlashUploadUrl = panel_public+'assets/widgets/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
	});
};
CKEDITOR.env.isCompatible = true;
CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
CKEDITOR.config.forcePasteAsPlainText = true;

