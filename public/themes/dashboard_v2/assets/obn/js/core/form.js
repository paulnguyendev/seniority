const getFormData = ($form) => {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    jQuery.map(unindexed_array, function (n, i) {
        indexed_array[n["name"]] = n["value"];
    });
    return indexed_array;
};
const deleteError = () => {
    const inputError = $(".form-control.has-error");
    const helpBlock = inputError.next();
    helpBlock.text("");
    inputError.removeClass("has-error");
};
const showError = (msg) => {
    const inputError = $(".form-control.has-error");
    const helpBlock = inputError.next();
    if (inputError) {
        helpBlock.text("");
        inputError.removeClass("has-error");
    }
    for (let key in msg) {
        const msg_item = msg[key];
        const current = jQuery(`.form-control[name='${key}']`);
        const next = current.parent().find(".help-block");
        current.addClass("has-error");
        next.text(msg_item);
        // parent = jQuery(`input[name='${key}']`).parent();
        // parent.append(
        //     `<label id='${key}-error' class="error" for='${key}'>${msg_item}</label>`
        // );
    }
};
