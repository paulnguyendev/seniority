const getFormData = ($form) => {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    jQuery.map(unindexed_array, function (n, i) {
        indexed_array[n["name"]] = n["value"];
    });
    return indexed_array;
};
const showError = (msg) => {
    for (let key in msg) {
        const msg_item = msg[key];
        const current = jQuery(`input[name='${key}']`);
        const next = current.next();
        current.addClass('has-error');
        next.text(msg_item);
        // parent = jQuery(`input[name='${key}']`).parent();
        // parent.append(
        //     `<label id='${key}-error' class="error" for='${key}'>${msg_item}</label>`
        // );
    }
};
