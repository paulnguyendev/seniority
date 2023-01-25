const nav_submit_form = (btn) => {
    const formID = $(btn).data("form");
    const formSubmit = $(`#${formID}`);
    const showLadda = $(btn).hasClass("btn-ladda") ? 1 : 0;
    if (showLadda == 1) {
        var l = Ladda.create(btn);
        l.start();
    }
    formSubmit.ajaxSubmit({
        beforeSubmit: function (formData, formObject, formOptions) {
            var data_attributes = [];
            for (var i = 0; i < formData.length; i++) {
                if (formData[i]["name"].indexOf("attribute[") !== -1) {
                    data_attributes.push(formData[i]);
                    formData.splice(i, 1);
                    i--;
                }
            }
            formData.push({
                name: "data_attributes",
                value: JSON.stringify(data_attributes),
            });
        },
        success: function (data) {
            if (data.success !== "unfriended") {
                if (data.success == false) {
                    warningNotice(data.message);
                    return;
                }
            }
            if (!data.redirect) {
                successSwal("Thông báo","Đăng nhập thành công",() => {
                    location.reload();
                });
            } else {
                $(window).unbind("beforeunload");
                var menu_redirect = "";
                location.href = menu_redirect ? menu_redirect : data.redirect;
            }
        },
        complete: function () {
            if (showLadda == 1) {
                l.stop();
            }
        },
    });
};
