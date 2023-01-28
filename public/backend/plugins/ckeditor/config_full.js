/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.dtd.$removeEmpty.i=0;
CKEDITOR.dtd.$removeEmpty.span=0;
CKEDITOR.editorConfig = function( config ) {
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.allowedContent = true;
    config.extraAllowedContent = '*(*);*{*}';
	config.toolbarGroups = [
	{ name: 'clipboard', groups: [ 'undo','clipboard' ] },
	{ name: 'editing', groups: [ 'find'] },
	{ name: 'document', groups: [ 'cleanup'  ] },
	{ name: 'links'},
	{ name: 'insert'},
	{ name: 'others' },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align'] },
	{ name: 'colors' },
	{ name: 'basicstyles', groups: [ 'basicstyles'] },
	{ name: 'styles' },
	{ name: 'document', groups: [ 'mode' ] },
	{ name: 'tools'}
	];

	// // Remove some buttons provided by the standard plugins, which are
	// // not needed in the Standard(s) toolbar.
	config.removeButtons = 'NewPage,Copy,CopyFormatting,Cut,Paste,Image,Save,Smiley,CreateDiv,Flash,About,Print,PasteFromWord,PasteText,ShowBlocks,Preview';
	// // Set the most common block elements.divarea,
	config.format_tags = 'p;h2;h3;h4;h5;h6;pre';

	// // Simplify the dialog windows.
	config.removeDialogTabs = 'link:advanced';
	config.language = 'vi';
	config.extraPlugins = 'youtube,medialib,wordcount,htmlwriter,btbutton';
	config.embed_provider= '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}';
	config.contentsCss=['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css','https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'];

	config.height = 400;
	config.htmlEncodeOutput = false;
	config.entities = false;
	config.wordcount = {
		showParagraphs: false,
	};
};


