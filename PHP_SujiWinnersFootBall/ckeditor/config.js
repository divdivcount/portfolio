/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	config.resize_minWidth = 200;
	config.resize_maxWidth = 400;
	config.resize_minHeight = 200;
	config.resize_maxHeight = 400;
	config.height = 400; 
	config.toolbarCanCollapse = true; 
	config.font_names = '맑은 고딕/Malgun Gothic;굴림/Gulim;돋움/Dotum;바탕/Batang;궁서/Gungsuh;' + config.font_names; 
	config.filebrowserUploadUrl = '/editor/upload.php';
};

