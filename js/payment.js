function editAddress(){
    $(document).ready(function () {
        var fields = $("main > section > div > div > article > form > ul > li > input");
        fields.attr('disabled', false);
        $("main > section > div > div > article > form > a:first-of-type").hide();
        $("main > section > div > div > article > form > a:last-of-type").show();
    });    
}