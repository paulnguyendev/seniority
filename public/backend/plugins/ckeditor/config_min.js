/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.allowedContent = true;
    config.extraAllowedContent = '*(*);*{*}';
	config.toolbarGroups = [
	{ name: 'clipboard', groups: [ 'undo' ] },
	{ name: 'document', groups: ['cleanup'] },
	{ name: 'links' },
	{ name: 'insert' },
	// '/',
	{ name: 'paragraph', groups: [ 'list', 'indent', 'align'] },
	 {name: 'basicstyles', groups: [ 'basicstyles'] },
	{ name: 'styles' },
	{ name: 'colors' },
	{ name: 'document', groups: ['mode'] },
	{ name: 'tools'},
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Image,Smiley,HorizontalRule,SpecialChar,PageBreak,Iframe,Font,FontSize,ShowBlocks,Anchor,CreateDiv,Copy,Cut,PasteText,PasteFromWord,CopyFormatting,Paste,Save,NewPage,Preview,Underline,Subscript,Superscript,Flash,About,Print,Source';
	// Set the most common block elements.
	config.format_tags = 'p;h2;h3;h4;h5;h6;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'link:advanced';
	config.language = 'vi';
	config.extraPlugins = 'wordcount,htmlwriter';
	config.embed_provider= '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}';

	config.height = 130;
	config.contentsCss=['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css','https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'];

	config.htmlEncodeOutput = false;
	config.entities = false;
	config.wordcount = {
		showParagraphs: false,
		showCharCount: true,
		countSpacesAsChars: true,
		maxCharCount: 500,
	};
};
