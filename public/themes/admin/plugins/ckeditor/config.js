/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	 config.allowedContent = true;
         config.contentCss = [
             '/themes/front/css/style.default.css',
             '/themes/front/css/custom.css'
         ];
         config.embed_provider = '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}';
         config.filebrowserBrowseUrl = '/elfinder/ckeditor';
};
