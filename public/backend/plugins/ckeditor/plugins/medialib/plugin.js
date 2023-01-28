
CKEDITOR.plugins.add( 'medialib', {
    icons: 'medialib',
    init: function( editor,test ) {
    var editorx = editor.name;
            editor.ui.addButton('ck_mlib_button_'+editorx, { // add new button and bind our command
            label: "Chèn hình ảnh từ thư viện",
            command: 'medialib',
            toolbar: 'insert,0',
            icon: CKEDITOR.basePath+'plugins/medialib/icons/medialib.png'
            });

    setTimeout(function() {
     $(".cke_button__ck_mlib_button_" + editorx).mlibready({
            allowed:
                "jpg,png,gif,jpeg,txt,zip,rar,doc,docx,ppt,pptx,xls,xlsx,csv,tar,gz,pdf",
            returnas: 13,
            ckename: editorx,
            maxselect:1
        });
    }, 1000);
    }
});