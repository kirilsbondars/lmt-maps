// var input = document.getElementById('name2');
//
// if(this.checked) {
//     input.disabled = false;
//     input.focus();
// } else {
//     input.disabled=true;
// }

$("#colorCheckbox").on("click", function () {
    if(this.checked) {
        $("#strokeColor").attr("disabled", false)
        console.log($("#strokeColor"));
    }
})