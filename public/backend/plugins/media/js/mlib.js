// biến này được dùng trong function list thư viện ảnh mlib_create_display
var selected_folder_id = null;
var folders = [];

$(document).ready(function () {
    Dropzone.autoDiscover = false;
    $(window).resize(function () {
        mlib_adjust_iframe();
    });

    $("body").on("change", ".mlib_ipp", function () {
        var ipp = $(this).val();
        var xpage = $("#mlib-lightbox").attr("mlib-page");
        mlib_load_gallery_data_advanced(xpage, ipp);
    });

    $("body").on("click", ".mlib-save-changes", function (e) {
        e.preventDefault();
        let $form = $(this).closest('form');
        $.post(
            media_ajax_action,
            $form.serialize(),
            function (data) {
                alert("Đã lưu thay đổi!");
            }
        );
    });

    $("body").on("click", ".mlib-save-type", function (e) {
        e.preventDefault();
        $.post(
            media_ajax_action,
            $(this)
                .closest("form.mlib-edit-method")
                .serialize(),
            function (data) {
                alert("Đã lưu thay đổi!");
            }
        );
    });

    $("body").on("click", "#mlib_chooser .mlib-import-method", function () {
        var xhtml = "";
        var xhtml2 = "";
        var xhtml_list = new Array();
        var template = $(this)
            .find(".mlib-import-data-raw")
            .html();

        $(".mlib-selected-thumb").each(function (i) {
            var xtitle = $(this).attr("mlib-title");
            var xcaption = $(this).attr("mlib-caption");
            var xtype = $(this).attr("mlib-type");
            var xid = $(this).attr("mlib-id");
            var xurl = $(this).attr("mlib-url");
            var xthumb = $(this).attr("mlib-thumb");
            var bytesize = $(this).attr("mlib-size");
            var fullsize = mlib_size(parseInt(bytesize));
            var thtml = template;

            thtml = mlib_replace_all(thtml, "%%title%%", xtitle);
            thtml = mlib_replace_all(thtml, "%%caption%%", xcaption);
            thtml = mlib_replace_all(thtml, "%%type%%", xtype);
            thtml = mlib_replace_all(thtml, "%%id%%", xid);
            thtml = mlib_replace_all(thtml, "%%url%%", xurl);
            thtml = mlib_replace_all(thtml, "%%thumb%%", xthumb);
            thtml = mlib_replace_all(thtml, "%%bytesize%%", bytesize);
            thtml = mlib_replace_all(thtml, "%%fullsize%%", fullsize);
            xhtml2 = xhtml2 + thtml;
            xhtml_list.push(thtml);
        });
        

        xhtml = xhtml_list.join();
        var rid = $("#mlib-lightbox").attr("mlib-return-to");
        var y = $("#mlib-lightbox").attr("mlib-function");
        var is_element_input = $(rid).is("input");
        if (is_element_input) {
            var maxx = parseInt($("#mlib-lightbox").attr("mlib-max-selection"));
            if (maxx > 1 && $(rid).val() != '') {
                $(rid).val($(rid).val() + ',' + xhtml);
            }
            else {
                $(rid).val(xhtml);
            }
            
        } else {
            
            $(rid).html(xhtml);
        }
        console.log(xhtml);

        // additional block for tinyMCE
        var mcename = $("#mlib-lightbox").attr("mlib-tinymce");
        if (mcename != "" && mcename !== undefined) {
            //tinymce.activeEditor.execCommand('mceInsertContent', false, xhtml);
            tinyMCE.get(mcename).execCommand("mceInsertContent", false, xhtml);
        }

        // additional block for CKEditor
        
        var ckename = $("#mlib-lightbox").attr("mlib-ckename");
        if (ckename != "") {
            CKEDITOR.instances[ckename].insertHtml(xhtml2);
        }

        $(".mlib-close").trigger("click");

        if (y != "null") {
            window[y](xhtml, rid);
        }
    });

    $("body").on("click", ".close-mlib-chooser", function () {
        $("#mlib_chooser").hide();
    });

    $("body").on("click", ".mlib-insert-button", function () {
        
        var allowed_types_string = mlib_replace_all(
            $("#mlib-lightbox").attr("mlib-allowed"),
            " ",
            ""
        );
        var allowed_types = allowed_types_string.split(",");
        var selectedx = $(".mlib-selected-thumb").length;
        var maxx = parseInt($("#mlib-lightbox").attr("mlib-max-selection"));
        var minx = parseInt($("#mlib-lightbox").attr("mlib-min-selection"));
        // if (selectedx > maxx) {
        //     alert("You can select maximum " + maxx + " files.");
        //     return false;
        // }

        if (selectedx < minx) {
            alert("You must select at least " + minx + " files.");
            return false;
        }

        var allowed = 5;

        $(".mlib-selected-thumb").each(function (index) {
            var xtype = $(this).attr("mlib-type");
            if (jQuery.inArray(xtype, allowed_types) == -1) {
                allowed = 0;
            }
        });

        if (allowed == 0) {
            alert(
                "You are allowed to select " +
                allowed_types_string +
                " files only."
            );
            return false;
        }
        // console.log($(this).attr("mlib-type"));

        var x = $("#mlib-lightbox").attr("mlib-return-as");

        if (x != "") {

            if(x==13){
            $(".mlib-selected-thumb").each(function (index) {
            var xtype = $(this).attr("mlib-type");
            //check xtype image
            if (jQuery.inArray(xtype, ['jpg','png','gif','jpeg']) == -1) {
               x=2;
            }
            else {
                x=4;
            }
            });
            }
            if (
                $('#mlib_chooser .mlib-import-method[mlib-id="' + x + '"]').length == 0) {
                $("#mlib_chooser").show();
            } else {
                $(
                    '#mlib_chooser .mlib-import-method[mlib-id="' + x + '"]'
                ).trigger("click");
            }
        }
    });

    // save new import option
    $("body").on("click", "#mlib-create-button", function () {
        $.post(media_ajax_action, $("#newoption").serialize(), function (data) {
            alert(data);
            // clear import option cache
            load_import_options();
        });
    });

    // closing the box
    $("body").on("click", ".mlib-close", function () {
        $("#mlib-lightbox").remove();
    });

    // open extra options
    $("body").on("click", ".mlib-new-option-button", function () {
        $(".mlib-new-option").slideDown("slow");
        $(".mlib-new-option-button").hide();
    });

    $("body").on("click", ".mlib-new-option .mlib-danger", function () {
        $(".mlib-new-option").slideUp("slow", function () {
            $(".mlib-new-option-button").show();
        });
    });

    // selecting all thumbnails by pressing Ctrl+A
    $("body").on("click keyup", ".mlib-delete-all", function () {
        if (
            confirm(
                // "All selected files will be deleted. This cannot be undone. Are you sure to continue?"
                "All files will be deleted. This operation cannot be undone. Do you want to continue ?"
            )
        ) {
            mlib_delete_selected();
        }
    });

    // selecting all thumbnails by pressing Ctrl+A
    $("body").on("keyup", function (e) {
        if ($("#mlib-media-li.mlib-li-active").length == 1) {
            if (e.shiftKey && e.keyCode == 65) {
                $(".mlib-thumbs:last").trigger("mousedown");
                $(".mlib-thumbs").each(function () {
                    if (!$(this).hasClass("mlib-selected-thumb")) {
                        $(this).addClass("mlib-selected-thumb");
                    }
                });
                var tot = $(".mlib-selected-thumb").length;
                $("#mlib-media-tab .mlib-how-many").html(
                    '<b style="color:red;">' +
                    tot +
                    ' file được chọn.</b> Press CTRL / Command sau đó click để chọn nhiều file HOẶC nhấn SHIFT + A chọn tất cả.<div class="mlib-how-many-text"><div style="float: right; margin: 10px 0px;" class="mlib-delete-all">Delete File</div> <div style="float: right; margin: 10px;" class="mlib-button mlib-insert-button">Insert File</div></div>'
                    // ' items selected.</b> Hold CTRL then click to select multiple items OR Press SHIFT + A to select all.<div class="mlib-how-many-text"><div style="float: right; margin: 10px 0px;" class="mlib-delete-all">delete selected</div> <div style="float: right; margin: 10px;" class="mlib-button mlib-insert-button">Insert selected</div></div>'
                );
                //$('.mlib-thumbs').addClass('mlib-selected-thumb');
            }
        }
    });

    $("body").on("mousedown", ".mlib-thumbs", function (e) {
        ctrlKeyHeld = e.ctrlKey;
        commaKeyHeld = e.metaKey;
        if (ctrlKeyHeld || commaKeyHeld) {
            if ($(this).find('input[checked="checked"]').length != 0) {
                $(this).removeClass("mlib-selected-thumb");
                $(this)
                    .find('[type="checkbox"]')
                    .removeAttr("checked");
            } else {
                $(this).addClass("mlib-selected-thumb");
                $(this)
                    .find('[type="checkbox"]')
                    .attr("checked", "checked");
            }
        } else {
            $(this)
                .closest(".mlib-display-canvas")
                .find(".mlib-thumbs")
                .removeClass("mlib-selected-thumb");
            $(this)
                .closest(".mlib-display-canvas")
                .find('[type="checkbox"]')
                .removeAttr("checked");
            $(this).addClass("mlib-selected-thumb");
            $(this)
                .find('[type="checkbox"]')
                .attr("checked", "checked");
        }

        var tot = $(".mlib-selected-thumb").length;
        $("#mlib-media-tab .mlib-how-many").html(
            '<b style="color:red;">' +
            tot +
            ' file được chọn.</b> Press CTRL/Command then click to select multiple files OR press SHIFT + A to select all.<div class="mlib-how-many-text"><div style="float: right; margin: 10px 0px;" class="mlib-delete-all">Delete File</div> <div style="float: right; margin: 10px;" class="mlib-button mlib-insert-button">Insert File</div></div>'
        );
        if($('.insert-file').length == 0 && $(window).width() < 768){
            $("#mlib-media-tab .mlib-load-more").append(
                '<div class="insert-file" style="width: 100%; float: left"><div style="float: left !important; margin: 10px;" class="mlib-button mlib-insert-button">Insert File</div></div>'
            );
        }
        let current_folder_id = $(this).attr('mlib-folder-id');
        var mhtml =
            '<form action="" method="post" name="mlib-single-form" class="mlib-single-edit">' +
                '<label><span>' + mlib_size($(this).attr("mlib-size")) +'" , "' + $(this).attr("mlib-type") + '" file</span></label>' +
                '<label><span>Uploaded in "' +$(this).attr("mlib-time") +'</span></label>' +
                '<label><span>Url</span>'+
                    '<input type="text" readonly="readonly" value="' + storage_url + $(this).attr("mlib-url") +'">'+
                    '<input type="hidden" name="mlibid" value="' +$(this).attr("mlib-id") +'">'+
                    '<input type="hidden" name="func" value="mlib_single_edit">'+
                '</label>'+
                '<label><span>Thumbnail</span>'+
                    '<input type="text" readonly="readonly" value="' +$(this).attr("mlib-thumb") +'">'+
                '</label>'+
                '<label>'+
                    '<span>Title</span>'+
                    '<input type="text" name="title" value="' +$(this).attr("mlib-title") +'">'+
                '</label>'+
               
                '<label>'+
                    '<span>Note</span>'+
                    '<textarea name="caption" rows="6">' +$(this).attr("mlib-caption") +'</textarea>'+
                '</label>'+
                '<input type="submit" class="mlib-save-changes" value="Save Change" name="dfdf">'+
            '</form>';

        $(".mlib-item-properties").html(mhtml);
    });

    $("body").on("click", ".mlib-left li", function () {
        var xid = $(this).attr("id");
        var cid = xid.replace("-li", "-tab");

         if(cid !== 'mlib-input-tab'){
            if(cid !== "mlib-media-tab"){
                $('#mlib-input-li').css('display', 'none')
            }else{
                $('#mlib-input-li').css('display', '')
            }
            $('#input-tab-name').val(cid);
            $(".mlib-left li").removeClass("mlib-li-active");
            $(this).addClass("mlib-li-active");
            $(".mlib-data").hide();
            $("#" + cid).show();
         }

        //mlib_adjust_iframe();
    });

    $("body").on("mousedown", ".mlib-folder-thumbs", function (e) {
        $(this)
            .closest(".mlib-display-folder-canvas")
            .find(".mlib-folder-thumbs")
            .removeClass("mlib-selected-folder-thumb");
        $(this)
            .closest(".mlib-displayfolder-canvas")
            .find('[type="checkbox"]')
            .removeAttr("checked");
        $(this).addClass("mlib-selected-folder-thumb");
        $(this)
            .find('[type="checkbox"]')
            .attr("checked", "checked");

        var tot = $(".mlib-selected-folder-thumb").length;
        $(".mlib-folder-canvas-bottom .mlib-how-many").html(
            '<div class="mlib-how-many-text">' +
                '<div style="float: left; margin: 6px;" class="">'+
                    '<form id="createFolder">'+
                        '<input name="_token" value="'+_token+'" type="hidden">' +
                        '<input type="text" name="folder_name" placeholder="Nhập tên thư mục mới" class="input_create_folder" required="required">' +
                    '</form>'+
                '</div>'+
                '<div style="float: right; margin: 10px 0px;" class="mlib-button mlib-danger mlib-delete-folder">Xóa thư mục</div>'+
                '<div style="float: right; margin: 10px;" class="mlib-button mlib-create-folder">Tạo thư mục mới</div>'+
            '</div>'
        );
        var mhtml =
            '<form action="/admin/media/folders" method="post" class="mlib-single-folder-edit">'+
                '<input name="id" value="'+$(this).data('id')+'" type="hidden">' +
                '<input name="_token" value="'+_token+'" type="hidden">' +
                '<label>' +
                    '<span>Tên thư mục</span>' +
                    '<input type="text" name="name" value="' +$(this).data("name") +'">' +
                '</label>' +
                '<label>' +
                    '<span>Ghi chú</span>' +
                    '<textarea name="note" rows="6">' +$(this).data("note") +'</textarea>' +
                '</label>' +
                '<input type="submit" class="mlib-save-folder-changes" value="Lưu thay đổi" name="dfdf">' +
            '</form>';

        $(".mlib-item-properties").html(mhtml);
    });

    $("body").on("dblclick", ".mlib-folder-thumbs", function (e) {
        let $folder = $(this);
        let folder_id = $folder.data('id');
        selected_folder_id = folder_id;
        $.post(media_ajax_action, {
                func: "load_thumbs",
                page: 1,
                ipp: 30,
                folder_id: folder_id,
            },
            function (data) {
                $("#mlib-media-li").trigger("click");
                mlib_create_display(data);
            }
        );
    });
    $("body").on('dblclick', '#mlib-media-li', function(event) {
        event.preventDefault();
        mlib_load_gallery_data();
    });
    $("body").on("click", ".mlib-create-folder", function () {
        let $form = $('#createFolder');
        let folder_name = $form.find('.input_create_folder').val();
        if (folder_name == "" || folder_name == undefined) {
            alert('Bạn phải nhập tên thư mục');
        } else {
            jQuery.ajax({
                url: media_ajax_folder,
                type: 'POST',
                data: $form.serialize(),
                complete: function(xhr, textStatus) {
                    //called when complete
                },
                success: function(data, textStatus, xhr) {
                    folders.push(data.folder);
                    add_folder_select_to_upload_tab(folders);
                    if (data.success) {
                        let html =  '<div class="mlib-folder-thumbs" style="text-align:center; padding-top:20px;" data-name="'+data.folder.name+'" data-note="" data-id="'+data.folder.id+'">' +
                                        '<i class="fa fa-folder-o fa-5x" aria-hidden="true"></i>' +
                                        '<p> '+data.folder.name+' </p>' +
                                        '<input type="checkbox" name="folder[' +data.folder.id +']">' +
                                    '</div>';
                        $(html).appendTo('.mlib-display-folder-canvas');
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Có lỗi xảy ra, vui lòng thử lại sau!');
                }
            });
        }
    });
    $("body").on("click keyup", "#mlib-folder-tab .mlib-delete-folder", function () {
        if (confirm("Thư mục này sẽ bị xóa, nhưng các file trong thư mục vẫn tồn tại. Thao tác này không thể phục hồi. Bạn có muốn tiếp tục không ?")) {
            mlib_delete_folder();
        }
    });

    $("body").on('click', '#mlib-url-li', function(event) {
        event.preventDefault();
        /* Act on the event */
    });
});

function mlib_delete_folder() {
    let id = $(".mlib-display-folder-canvas").find('.mlib-selected-folder-thumb').data('id');
    jQuery.ajax({
        url: media_ajax_folder,
        type: 'DELETE',
        dataType: 'json',
        data: {
            _token: _token,
            id: id,
        },
        complete: function(xhr, textStatus) {
            //called when complete
        },
        success: function(data, textStatus, xhr) {
            if (data.success) {
                $('.mlib-display-folder-canvas').find('.mlib-folder-thumbs[data-id="'+id+'"]').remove();
                for (var i = 0; i < folders.length; i++) {
                    if(folders[i].id == id) {
                        folders.splice(i, 1);
                        break;
                    }
                }
                add_folder_select_to_upload_tab(folders);
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            //called when there is an error
        }
    });
}

$(document).on('submit', '.mlib-single-folder-edit', function(event) {
    event.preventDefault();
    let $form = $(this);
    let url = $form.attr('action');
    jQuery.ajax({
        url: url,
        type: 'PUT',
        dataType: 'json',
        data: $form.serialize(),
        complete: function(xhr, textStatus) {
            //called when complete
        },
        success: function(data, textStatus, xhr) {
            if (data.success) {
                alert(data.message);
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            //called when there is an error
        }
    });

});

function mlib_url_upload() {
    var url = $('.mlib-urls textarea[name="urls"]').val();
    let folder_id = $('#mlib-url-tab .selectUploadFolder').val();
    $('<input type="hidden" name="folder_id" value="'+folder_id+'">').appendTo('#form-url-upload');
    if (url.length < 4) {
        alert("Nhập một đường dẫn");
        $('.mlib-urls textarea[name="urls"]').trigger("focus");
    } else {
        $("#form-url-upload").hide();
        $(".mlib-ajax-result").html(
            // "<h3>Please wait and do not close this. Files are being processed.</h3>"
            "<h3>Đang xử lý.</h3>"
        );
        $.post(
            media_ajax_action,
            $("#form-url-upload").serialize(),
            function (data) {
                alert(data.message);
                if (data.success == true) {
                    $(".mlib-ajax-result").html(data);
                    $('.mlib-urls textarea[name="urls"]').val("");
                    $("#form-url-upload").show();
                    selected_folder_id = folder_id;
                    $("#mlib-media-li").trigger("click");
                    mlib_load_gallery_data();
                } else {
                    $('#mlib-url-tab').html('');
                    $('#mlib-url-tab').html(
                        '<div class="mlib-top">'+
                            '<div class="mlib-head">Tải File Từ Đường Dẫn</div>' +
                            '<div class="mlib-close">X</div>' +
                        '</div>' +
                        '<div class="mlib-urls">' +
                            '<form onsubmit="return mlib_url_upload()" action="' + media_ajax_action + '" id="form-url-upload" name="xyz" method="post">' +
                                '<p>Nhập đường dẫn để download. Bạn có thể nhập nhiểu đường dẫn bằng cách xuống dòng.</p>' +
                                '<textarea name="urls" placeholder="Nhập đường dẫn ..."></textarea>' +
                                '<input type="hidden" name="func" value="url_upload" />' +
                                '<br />' +
                                '<input type="submit" name="dfdf" value="Tải lên" />' +
                            '</form>' +
                            '<div class="mlib-ajax-result"></div>' +
                        '</div>'
                    );
                    add_folder_select_to_upload_tab(folders);
                }
            }
        );
    }
    return false;
}

function mlib_load_gallery_data() {
    mlib_load_gallery_data_advanced(1, 30);
}

function mlib_load_folder_data() {
    return new Promise((reslove, reject) => {
        jQuery.ajax({
            url: media_ajax_folder,
            type: 'GET',
            complete: function(xhr, textStatus) {
                //called when complete
            },
            success: function(data, textStatus, xhr) {
                folders = data;
                add_folder_select_to_upload_tab(data);
                mlib_create_folder_display(data);
                return reslove();
            },
            error: function(xhr, textStatus, errorThrown) {
                return reject('Load thư mục thất bại!');
            }
        });
    });
}

function add_folder_select_to_upload_tab(folders) {
    let html ='<select class="selectUploadFolder" style="padding:5px;float:right;margin:10px;font-size:15px;"><option value="null">Chưa có thư mục</option>';
                for (var i = 0; i < folders.length; i++) {
                    html += '<option value="'+folders[i].id+'">'+folders[i].name+'</option>'
                }
    html +=   '</select>'+
    $("#mlib-upload-tab").find(".selectUploadFolder").remove();
    $("#mlib-url-tab").find('.selectUploadFolder').remove();
    $(html).appendTo('#mlib-upload-tab .mlib-head');
    $(html).appendTo('#mlib-url-tab .mlib-head');
}
function mlib_create_folder_display(folders = []) {
    let html = "";
    for (var i = 0; i < folders.length; i++) {
         html = html +
            '<div class="mlib-folder-thumbs" style="text-align:center; padding-top:20px;" data-name="'+folders[i].name+'" data-note="'+folders[i].note+'" data-id="'+folders[i].id+'">' +
                '<i class="fa fa-folder-o fa-5x" aria-hidden="true"></i>' +
                '<p> '+folders[i].name+' </p>' +
                '<input type="checkbox" name="folder[' +folders[i].id +']">' +
            '</div>';
    }

    // console.log(html);
    // var load_more = '<div class="mlib-load-more"><div style="float:right;"> File mỗi trang : &nbsp; <select name="mlib_ipp" class="mlib_ipp"><option>30</option><option>50</option><option>100</option><option>200</option><option>500</option><option>1000</option></select></div><div class="mlib-linked-pages"></div></div>';

    if (html == "") {
        html ='<p style="padding:0 10px;"><b>Lỗi!</b> Không có dữ liệu hiển thị.</p>';
    }

    $(".mlib-display-folder-canvas").html(html);
    $(".mlib-folder-canvas-bottom .mlib-how-many").html(
        '<div class="mlib-how-many-text">' +
            '<div style="float: left; margin: 6px;" class="">'+
                '<form id="createFolder">'+
                
                    '<input type="text" name="folder_name" placeholder="Nhập tên thư mục mới" class="input_create_folder" required="required">' +
                '</form>'+
            '</div>'+
            '<div style="float: right; margin: 10px 0px;" class="mlib-button mlib-danger mlib-delete-folder">Xóa thư mục</div>'+
            '<div style="float: right; margin: 10px;" class="mlib-button mlib-create-folder">Tạo thư mục mới</div>'+
        '</div>'
    );
}

function mlib_load_gallery_data_advanced(xpage, xipp) {
    $.post(
        media_ajax_action,{
            func: "load_thumbs",
            page: xpage,
            ipp: xipp,
            folder_id: selected_folder_id,
        },
        function (data) {
            mlib_create_display(data);
        }
    );
}

function mlib_create_display(data) {
   
    var xdata = jQuery.parseJSON(data);
    console.log(xdata);
    var xstr = "";
    let items = xdata.items;
    for (var i = 0; i < parseInt(items.length); ++i) {
        
     
        xstr =
            xstr +
            '<div mlib-size="' +
            items[i].size +
            '" mlib-id="' +
            items[i].id +
            '" mlib-type="' +
            items[i].type +
            '" mlib-time="' +
            items[i].newtime +
            '" mlib-title="' +
            items[i].title +
            '" mlib-caption="' +
            items[i].caption +
            '" mlib-url="' +
            items[i].url +
            '" mlib-thumb="' +
            items[i].thumb +
            '" mlib-folder="' +
            (items[i].folder != null ? items[i].folder.name : "") +
            '" mlib-folder-id="' +
            (items[i].folder != null ? items[i].folder.id : "") +
            '" class="mlib-thumbs" style="background-image:url(\'' + storage_url  +
            items[i].thumb +
            '\')">\
<input type="checkbox" name="img[' +
items[i].id +
            ']">\
<div class="mlib-checkbox"></div></div>';
    }
    var load_more =
        '<div class="mlib-load-more">' +
            
           
            '<div class="mlib-linked-pages">' +
            '</div>' +
        '</div>';

    if (xdata.total == xdata.ipp) {
        var load_more_bottom = load_more;
    } else {
        var load_more_bottom = "";
    }

    if (xstr == "") {
        xstr =
            '<p style="padding:0 10px;"><b>Sorry!</b> Không có dữ liệu hiển thị.</p>';
    }

    $(".mlib-display-canvas").html(load_more + xstr + load_more_bottom);
    $(".mlib-load-more .mlib_ipp").val(xdata.ipp);
    //$( ".mlib-display-canvas" ).prepend( load_more );
    //$( ".mlib-display-canvas" ).after( load_more );
    var mlib_ipp = $(".mlib-load-more .mlib_ipp").val();
    // $(".mlib-load-more .mlib-linked-pages").pagination({
    //     items: xdata.gtotal,
    //     itemsOnPage: mlib_ipp,
    //     hrefTextPrefix: "",
    //     hrefTextSuffix: "",
    //     currentPage: xdata.page,
    //     cssStyle: "light-theme",
    //     onPageClick: function (pageNumber, event) {
    //         mlib_advert_page(pageNumber, event);
    //     }
    // });
    $("#mlib-lightbox").attr("mlib-ipp", xdata.ipp);
    $("#mlib-lightbox").attr("mlib-page", xdata.page);
}

$("body").on('change', '#selectLibraryFolder', function(event) {
    event.preventDefault();
    let folder_id = $(this).val();
    let item_per_page = $('.mlib_ipp').val();
    selected_folder_id = folder_id;
    $.post(
        media_ajax_action,{
            func: "load_thumbs",
            page: 1,
            ipp: item_per_page,
            folder_id: folder_id,
        },
        function (data) {
            mlib_create_display(data);
        }
    );
});

function mlib_advert_page(currpage, e) {
    e.preventDefault();
    var mlib_ipp = $(".mlib-load-more .mlib_ipp").val();
    mlib_load_gallery_data_advanced(currpage, mlib_ipp);
}

function mlib_delete_selected() {
    var mhtml = "";
    // create a hidden for containing all selected images
    $(".mlib-selected-thumb").each(function (index) {
        var mid = $(this).attr("mlib-id");
        mhtml =
            mhtml +
            '<input type="hidden" name="mlibid[]" value="' +
            mid +
            '" />';
    });

    var xhtml =
        '<form name="mlibdelform" id="mlibdelform" action="" method="post">\
<input type="hidden" name="func" value="mlib_delete_items" />' +
        mhtml +
        "</form>";
    $("body").append(xhtml);

    $.post(
        media_ajax_action,
        $("form#mlibdelform").serialize(),
        function (data) {
            alert(data);

            $(".mlib-selected-thumb")
                .addClass("mlib-danger")
                .fadeOut("slow", function () {
                    $(this).remove();
                    $("#mlibdelform").remove();
                    mlib_load_gallery_data();
                });
        }
    );
}

function load_import_options() {
    var xhtml =
        '<form name="0-saveform" method="post" action="" mlib-id="0" class="mlib-edit-method"><input type="hidden" name="mlibtypeid" value="0" /><b>id = 0</b><input readonly="readonly" type="text" name="title" value="Full URL Only" /><textarea readonly="readonly" name="content" rows="5">%%url%%</textarea><input type="hidden" name="func" value="mlib_save_type">Primary Option, cannot be saved or edited</form>';
    var yhtml =
        '<div mlib-id="0" class="mlib-import-method"><h3>Full URL only</h3><div class="mlib-import-data">%%url%%</div><div class="mlib-import-data-raw">%%url%%</div></div>';
    $.post(
        media_ajax_action,
        {func: "mlib_get_import_methods"},
        function (datax) {
            console.log(datax);
            data = jQuery.parseJSON(datax);
            $(".mlib-new-option .mlib-danger").trigger("click");
            for (var i = 0; i < data.total; ++i) {
                xhtml =
                    xhtml +
                    '<form name="' +
                    data[i].id +
                    '-saveform" method="post" action="" mlib-id="' +
                    data[i].id +
                    '" class="mlib-edit-method"><input type="hidden" name="mlibtypeid" value="' +
                    data[i].id +
                    '" /><b>id = ' +
                    data[i].id +
                    '</b><input type="text" name="title" value="' +
                    data[i].title +
                    '" /><textarea name="content" rows="5">' +
                    data[i].content +
                    '</textarea><input type="hidden" name="func" value="mlib_save_type"><input type="submit" name="save" class="mlib-button mlib-save-type" value="Save Changes" /> <input type="reset" name="reset" class="mlib-button mlib-danger" value="Delete Option" /></form>';
                yhtml =
                    yhtml +
                    '<div mlib-id="' +
                    data[i].id +
                    '" class="mlib-import-method"><h3>' +
                    data[i].title +
                    '</h3><div class="mlib-import-data">' +
                    data[i].contentx +
                    '</div><div class="mlib-import-data-raw">' +
                    data[i].content +
                    "</div></div>";
            }
            $("#mlib-import-methods").html(
                '<div style="clear:both;"></div>' + xhtml
            );
            $("#mlib_chooser_data").html(yhtml);
        }
    );
}

function launch_mlib_box(allowed,
                         returnto,
                         returnas,
                         maxselect,
                         minselect,
                         admin,
                         runfunction,
                         xmaxFilesize,
                         xparallelUploads,
                         xthumbnailWidth,
                         xthumbnailHeight,
                         mcename,
                         ckename) {
    if (admin == 1) {
        var admintab = '<li id="mlib-import-li">Import Options</li>';
        var adminbox =
            '<div class="mlib-top"><div class="mlib-head">Manage Import Options</div><div class="mlib-close">X</div></div>\
<div class="mlib-button mlib-new-option-button" style="float:left;margin:10px;">+ Add New Import Option</div>\
<fieldset class="mlib-new-option">\
<legend>Add New import option</legend>\
<form name="newoption" id="newoption" action="" method="post">\
<input type="text" name="name" placeholder="Scheme Title">\
<textarea name="data" rows="8" placeholder="Scheme content for single image. All images will be imported as this scheme when selected."></textarea>\
<input type="button" id="mlib-create-button" class="mlib-button" value="Create" />\
 <input type="reset" class="mlib-button mlib-danger" value="Cancel" />\
<input type="hidden" name="func" value="mlib_create_import_method" />\
</form></fieldset>\
<div id="mlib-import-methods"></div>';
    } else {
        var admintab = "";
        var adminbox = "";
    }
    var xhtml =
        '<style type="text/css">.dropzone .dz-preview .dz-error-message{right:-10px !important; left:-10px !important; width:auto !important;} .dropzone .dz-preview .dz-image{border-radius: 6px !important;height:' +
        xthumbnailHeight +
        "px !important;width:" +
        xthumbnailWidth +
        'px !important;}</style><div mlib-function="' +
        runfunction +
        '" mlib-min-selection="' +
        minselect +
        '" mlib-max-selection="' +
        maxselect +
        '" mlib-allowed="' +
        allowed +
        '" mlib-return-to="' +
        returnto +
        '" mlib-return-as="' +
        returnas +
        '" mlib-tinymce="' +
        mcename +
        '" mlib-ckename="' +
        ckename +
        '" id="mlib-lightbox">\
            <div class="mlib-bg"></div>\
            <div class="mlib-main">\
                <ul class="mlib-left">\
                   <li class="mlib-li-active" id="mlib-upload-li">Upload Files</li>\
                    <li id="mlib-media-li">Choose From Library</li>' +admintab +'\
                </ul>\
                <div class="mlib-right">\
                    <div class="mlib-contents">\
                        <div class="mlib-data" style="display:block;" id="mlib-upload-tab">\
                            <div class="mlib-top">\
                                <div class="mlib-head">Upload Files From Computer\
                                </div>\
                                <div class="mlib-close">X</div>\
                            </div>\
                            <form action="' + media_ajax_upload + '" class="dropzone">\
                                <div class="fallback">\
                                    <div class="mlib_fallback_iframe">\
                                        <iframe id="mlib_fallback_iframe" src="' +mlib_domain +'mlib-iframe.php" onload="javascript:mlib_adjust_iframe()" frameborder="0" width="100%"></iframe>\
                                    </div>\
                                </div>\
                            </form>\
                        </div>\
                        <div class="mlib-data" id="mlib-media-tab">\
                            <div class="mlib-top">\
                                <div class="mlib-head">Choose From Library</div>\
                                <div class="mlib-close">X</div>\
                            </div>\
                            <div class="mlib-bottom">\
                                <div class="mlib-how-many">Press CTRL/Command then click to select multiple files OR press SHIFT + A to select all.</div>\
                            </div>\
                            <div class="mlib-display-canvas">\
                                <form name="myform" action="" method="post">\
                                    <div id="mlib-navi1" class="mlib-navi"></div>\
                                    <div id="mlib-navi2" class="mlib-navi"></div>\
                                </form>\
                            </div>\
                            <div class="mlib-item-properties"></div>\
                        </div>\
                         <div class="mlib-data" id="mlib-folder-tab">\
                            <div class="mlib-top">\
                                <div class="mlib-head">Danh Sách Thư Mục</div>\
                                <div class="mlib-close">X</div>\
                            </div>\
                            <div class="mlib-bottom mlib-folder-canvas-bottom">\
                                <div class="mlib-how-many"></div>\
                            </div>\
                            <div class="mlib-display-folder-canvas">\
                                <form name="myform" action="" method="post">\
                                    <div id="mlib-navi1" class="mlib-navi"></div>\
                                    <div id="mlib-navi2" class="mlib-navi"></div>\
                                </form>\
                            </div>\
                            <div class="mlib-item-properties"></div>\
                        </div>\
                        <div class="mlib-data" id="mlib-import-tab">' +adminbox +'</div>\
                        <div class="mlib-data" id="mlib-url-tab">\
                            <div class="mlib-top">\
                                <div class="mlib-head">Tải File Từ Đường Dẫn</div>\
                                <div class="mlib-close">X</div>\
                            </div>\
                            <div class="mlib-urls">\
                                <form onsubmit="return mlib_url_upload()" action="' + media_ajax_action + '" id="form-url-upload" name="xyz" method="post">\
                                    <p>Nhập đường dẫn để download. Bạn có thể nhập nhiểu đường dẫn bằng cách xuống dòng.</p>\
                                    <textarea name="urls" placeholder="Nhập đường dẫn ..."></textarea>\
                                    <input type="hidden" name="func" value="url_upload" />\
                                    <br />\
                                    <input type="submit" name="dfdf" value="Tải lên" />\
                                </form>\
                                <div class="mlib-ajax-result"></div>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>\
            <div id="mlib_chooser">\
                <div id="mlib_chooser_bg"></div>\
                <div id="mlib_chooser_body">\
                    <div id="mlib_chooser_head">Choose what to import</div>\
                    <div id="mlib_chooser_data"></div>\
                    <a class="mlib-button close-mlib-chooser">Cancel</a>\
                </div>\
            </div>\
        </div>';

    if ($(".mlib-close").length == 1) {
        $(".mlib-close").trigger("click");
    }

    $("body").append(xhtml);
    var mlib_upl_allowed = "." + mlib_replace_all(allowed, ",", "|.");
    mlib_upl_allowed = mlib_replace_all(mlib_upl_allowed, "|", ",");
    if (mlib_is_ie() < 10) {
        // is IE version less than 10
        //mlib_load_gallery_data();
    } else {

        $(function () {
            // is IE 10 and later or not IE
            if (allowed == "") {
                var myDropzone = new Dropzone(".dropzone", {
                    dictDefaultMessage: "Kéo files vào đây <span>hoặc CLICK để upload</span>",
                    maxFilesize: xmaxFilesize,
                    parallelUploads: xparallelUploads,
                    thumbnailWidth: xthumbnailWidth,
                    thumbnailHeight: xthumbnailHeight,
                    acceptedFiles:
                        "jpg,png,gif,jpeg,txt,zip,rar,doc,docx,ppt,pptx,xls,xlsx,csv,tar,gz",
                    url: media_ajax_upload,
                    dictFileTooBig:"Dung lượng file đã vượt quá {{maxFilesize}}Mb",
                });
            } else {
                var myDropzone = new Dropzone(".dropzone", {
                    dictDefaultMessage: "Drag and drop files here or click<span> ( Maximum file size "+xmaxFilesize+"Mb )</span><span> ( Maximum image size 2000px x 2000px )</span>",
                    maxFilesize: xmaxFilesize,
                    parallelUploads: xparallelUploads,
                    thumbnailWidth: xthumbnailWidth,
                    thumbnailHeight: xthumbnailHeight,
                    acceptedFiles: mlib_upl_allowed,
                    // resizeWidth:1920,
                    // resizeHeight:1080,
                    url: media_ajax_upload,
                    dictFileTooBig:"Dung lượng file đã vượt quá {{maxFilesize}}Mb",
                });
            }

            var totalFiles = 0, completeFiles = 0;
            myDropzone.on("sending", function (file, xhr, formData) {
                let folder_id = $('#mlib-upload-tab .selectUploadFolder').val();
                selected_folder_id = folder_id;
                formData.append("folder_id", folder_id);
            });
            myDropzone.on("addedfile", function (file) {
                totalFiles += 1;
            });
            myDropzone.on("complete", function (file) {
                if(file.status !== 'error'){
                    completeFiles += 1;
                }
            });

            myDropzone.on("queuecomplete", function (x) {
                if (completeFiles != totalFiles) {
                    // alert('Bạn đã sử dụng hết dung lượng. Vui lòng nâng cấp lên gói cao hơn.')
                    // totalFiles = completeFiles = 0;
                    mlib_load_gallery_data();
                }
                else {
                    mlib_thumbs_after_upload();
                }

            });

        });
    }

    //$(".dropzone").dropzone({ url: mlib_domain+"mlib-upload.php" });
    mlib_load_folder_data().then(function () {
        mlib_load_gallery_data();
    });
    load_import_options();
}

function mlib_replace_all(inSource, inToReplace, inReplaceWith) {
    var outString = inSource;
    while (true) {
        var idx = outString.indexOf(inToReplace);
        if (idx == -1) {
            break;
        }
        outString =
            outString.substring(0, idx) +
            inReplaceWith +
            outString.substring(idx + inToReplace.length);
    }
    return outString;
}

(function ($) {
    $.fn.mlibready = function (options) {
        // This is the easiest way to have default options.
        var settings = $.extend(
            {
                allowed: "jpg,png,gif,jpeg",
                minselect: 1,
                maxselect: 999999999999,
                returnas: 0,
                admin: 0,
                returnto: "",
                runfunction: "null",
                maxFilesize: 5,
                parallelUploads: 4,
                thumbnailWidth: 150,
                thumbnailHeight: 150,
                mcename: "",
                ckename: ""
            },
            options
        );

        this.click(function () {
            launch_mlib_box(
                settings.allowed,
                settings.returnto,
                settings.returnas,
                settings.maxselect,
                settings.minselect,
                settings.admin,
                settings.runfunction,
                settings.maxFilesize,
                settings.parallelUploads,
                settings.thumbnailWidth,
                settings.thumbnailHeight,
                settings.mcename,
                settings.ckename
            );
        });
    };
    $.fn.mlibreadyCustome = function (options) {
        // This is the easiest way to have default options.
        this.click(function () {
            var settings = $.extend(
            {
                    allowed: "jpg,png,gif,jpeg",
                    minselect: 1,
                    maxselect: 100,
                    returnas: 0,
                    admin: 0,
                    returnto: "#"+$(this).attr('data-input'),
                    runfunction: "null",
                    maxFilesize: 5,
                    parallelUploads: 4,
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    mcename: "",
                    ckename: ""
                },
                options
            );
            launch_mlib_box(
                settings.allowed,
                settings.returnto,
                settings.returnas,
                settings.maxselect,
                settings.minselect,
                settings.admin,
                settings.runfunction,
                settings.maxFilesize,
                settings.parallelUploads,
                settings.thumbnailWidth,
                settings.thumbnailHeight,
                settings.mcename,
                settings.ckename
            );
        });
    };
})(jQuery);

function mlib_size(bytes, precision) {
    var kilobyte = 1024;
    var megabyte = kilobyte * 1024;
    var gigabyte = megabyte * 1024;
    var terabyte = gigabyte * 1024;

    if (bytes >= 0 && bytes < kilobyte) {
        return bytes + " B";
    } else if (bytes >= kilobyte && bytes < megabyte) {
        return (bytes / kilobyte).toFixed(precision) + " KB";
    } else if (bytes >= megabyte && bytes < gigabyte) {
        return (bytes / megabyte).toFixed(precision) + " MB";
    } else if (bytes >= gigabyte && bytes < terabyte) {
        return (bytes / gigabyte).toFixed(precision) + " GB";
    } else if (bytes >= terabyte) {
        return (bytes / terabyte).toFixed(precision) + " TB";
    } else {
        return bytes + " B";
    }
}

/* Used to detect IE version. Wont work for IE 11+ */
function mlib_is_ie() {
    var myNav = navigator.userAgent.toLowerCase();
    return myNav.indexOf("msie") != -1
        ? parseInt(myNav.split("msie")[1])
        : 1000;
}

function mlib_adjust_iframe() {
    if ($("#mlib_fallback_iframe").length == 1) {
        var obj = document.getElementById("mlib_fallback_iframe");
        obj.style.height =
            obj.contentWindow.document.body.scrollHeight + 20 + "px";
    }
}

function mlib_thumbs_after_upload() {
    $("#mlib-media-li").trigger("click");
    $(".mlib-display-canvas").html("");
    mlib_load_gallery_data();
}

function init_ckeditor_medialib(editorx) {
    if ($(".cke_button__ck_mlib_button_" + editorx).length == 0) {
       
        setTimeout(function () {
            init_ckeditor_medialib(editorx);
        }, 5000);
    } else {
        $(".cke_button__ck_mlib_button_" + editorx + "_label").css(
            "display",
            "inline"
        );
        $(".cke_button__ck_mlib_button_" + editorx).mlibready({
            allowed:
                "jpg,png,gif,jpeg,txt,zip,rar,doc,docx,ppt,pptx,xls,xlsx,csv,tar,gz",
            returnas: 4,
            ckename: editorx
        });
    }
}
$("body").on("keyup", "#search-file-name", function (e) {
    let fileName = $("#search-file-name").val();
    let curUrl = window.location.hostname;
    let curUrlProtocol = window.location.protocol;
    $.ajax({
        type: "GET",
        url: curUrlProtocol+"//"+curUrl+"/admin/media/search-file-name",
        data: {
            'name':fileName
        },
        success:function(data){
            mlib_create_display(data);
        }
    });
});
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });