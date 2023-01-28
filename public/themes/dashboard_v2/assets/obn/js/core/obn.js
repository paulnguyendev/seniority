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
