/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	//config.language = 'vi';
	
	config.width = 'auto';
	config.height = 300;
	config.toolbarCanCollapse = true;

	config.extraPlugins = 'fontawesome,youtube';

	config.contentsCss = base+'/plugins/ckeditor_4.6.0/plugins/fontawesome/font-awesome/css/font-awesome.min.css';

	config.allowedContent = true; 
	
	/*config.filebrowserBrowseUrl = baseURL+'admin/plugin/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = baseURL+'admin/plugin/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = baseURL+'admin/plugin/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = baseURL+'admin/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = baseURL+'admin/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = baseURL+'admin/plugin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';*/

	config.filebrowserBrowseUrl = base+'/plugins/ckfinder_2.6.2.1/ckfinder.html';
	config.filebrowserImageBrowseUrl = base+'/plugins/ckfinder_2.6.2.1/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = base+'/plugins/ckfinder_2.6.2.1/ckfinder.html?type=Flashs';

	config.toolbar = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Preview', 'Print', '-', 'Templates' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
		{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
		{ name: 'insert', items: [ 'Image', 'Youtube', 'Flash', 'Iframe', 'Table', 'HorizontalRule', '-', 'FontAwesome', 'Smiley', 'SpecialChar', 'PageBreak' ] },
		'/',
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
		{ name: 'others', items: [ '-' ] },
		{ name: 'about', items: [ 'About' ] }
	];
	config.font_names = 'Century Gothic/century_gothic;' + 'Roboto/roboto;' + 'UTM Avo/utm_avo;' + config.font_names;
};