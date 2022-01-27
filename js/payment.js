function editAddress(){
    $(document).ready(function () {
        var fields = $("main > section > div > div > article > form > ul > li > input:not(:first-child)");
        if($("main > section > div > div > article > form > a:first-of-type").is(":visible")){
            fields.attr('disabled', false);
            $("main > section > div > div > article > form > a:first-of-type").hide();
            $("main > section > div > div > article > form > a:last-of-type").show();
        }
        else{
            fields.attr('disabled', true);
            $("main > section > div > div > article > form > a:first-of-type").show();
            $("main > section > div > div > article > form > a:last-of-type").hide();
        }
        
    });    
}