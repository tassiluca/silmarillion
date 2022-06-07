function editAddress(){
    $(document).ready(function () {
        const editBtn = $("form#addressForm > fieldset:first-of-type a:first-of-type");
        const confirmBtn = $("form#addressForm > fieldset:first-of-type a:nth-of-type(2)");
        const fields = $("form#addressForm > fieldset:first-of-type input");
        if (editBtn.is(":visible")){
            fields.attr('readonly', false);
            editBtn.hide();
            confirmBtn.show();
        } else {
            fields.attr('readonly', true);
            editBtn.show();
            confirmBtn.hide();
        }
    });    
}