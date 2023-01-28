/* Path to the folder where mlib-config.php exists */
let base_domain = $(`meta[name='base_domain']`).attr('content');
let  assets_url = $(`meta[name='assets_url']`).attr('content');
let  storage_url = $(`meta[name='storage_url']`).attr('content');
mlib_domain = base_domain+'/Modules/Media/Library/mlib/';
var mlib_parent_init = '';
var media_ajax_upload = base_domain+'admin/media/upload';
var media_ajax_action = base_domain+'admin/media/action';
var media_ajax_folder = base_domain+'admin/media/folders';
var media_asset_url = assets_url+'/backend/plugins/media/';
var core_asset_url = media_asset_url;

$( document ).ready(function() {

if(mlib_parent_init=='1'){
window.top.mlib_adjust_iframe();
setTimeout("mlib_reload_frame()", 500);
}

$('body').on('click', '#addmoreupload', function(){
$(this).closest('.mlib-extra-upload').after('<div class="mlib-extra-upload"><input type="file" name="file[]" /> <input type="button" class="mlib_delete_upload" value="x Remove" /></div>');
window.top.mlib_adjust_iframe();
});


$('body').on('click', ".mlib_delete_upload", function(){
$(this).parent().remove();
window.top.mlib_adjust_iframe();
});

});


function mlib_reload_frame(){
window.top.mlib_thumbs_after_upload();
}


/* Load jQuery if not already loaded */
if(!window.jQuery){
var script = document.createElement('script');
script.type = "text/javascript";
script.src = media_asset_url+'js/jquery-1.11.1.min.js';
document.getElementsByTagName('head')[0].appendChild(script);
}

// <link href="'+media_asset_url+'dropzone/css/basic.css" rel="stylesheet" type="text/css" />\
// <link href="'+media_asset_url+'dropzone/css/dropzone.min.css" rel="stylesheet" type="text/css" />\
// <script src="'+media_asset_url+'dropzone/dropzone.min.js" type="text/javascript"></script>\
/* Include required JS/CSS Files asynchronously to improve server response time of web-pages and reduce hassle */
var mlib_includes = '<link href="'+media_asset_url+'pagination/simplePagination.css" rel="stylesheet" type="text/css" />\
<link href="'+media_asset_url+'css/mlib.css?v=1.1" rel="stylesheet" type="text/css" />\
<script src="'+core_asset_url+'dropzone/dropzone.min.js" type="text/javascript"></script>\
<script src="'+media_asset_url+'pagination/jquery.simplePagination.js" type="text/javascript"></script>\
<script src="'+media_asset_url+'js/mlib.js?v=1.4.3" type="text/javascript"></script>';
document.write(mlib_includes);

function fillImage(url,target){
    url = storage_url + url;
    $(target).parent().find('.img-thumbnail').attr('src',url);
 }

function fillGallery(url,target){
    var items = url.split(",");
    $.each(items, function(index, val) {
       $(target).parent().find('.media-container').append('<div class="media-item"><img class="img-thumbnail" src="' + val + '""><span class="close"><i class="fa fa-remove"></i></span></div>');
   });
}

function fillSliderImage(url, target) {
    $(target).parent().find('img').attr('src',url);
}