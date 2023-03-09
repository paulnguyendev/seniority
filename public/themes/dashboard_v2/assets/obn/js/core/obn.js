const loading = $(".loading-wrap");
const showLoading = () => {
    loading.css("display", "flex");
};
const hideLoading = () => {
    loading.hide();
};
// Select2
$(".select2").select2({
    width: "100%",
});
function clickAll(table) {
    
    $(table).on('click', 'input#inputCheckAllObn', function (e) {
        $(table).find('input.check_single_row').prop('checked', $(this).is(":checked"));
        if ($(this).is(":checked")) {
            $(table).find('input.check_single_row').parents('tr').addClass('success');
        } else {
            $(table).find('input.check_single_row').parents('tr').removeClass('success');
        }
        $.uniform.update();
    });
}
