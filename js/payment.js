
function editAddress(){
    $(document).ready(function () {
        var fields = $("main > section > div > div > form > div:first-of-type > ul > li > input");
        if($("main > section > div > div > form > div:first-of-type > a:first-of-type").is(":visible")){
            fields.attr('readonly', false);
            $("main > section > div > div > form > div:first-of-type > a:first-of-type").hide();
            $("main > section > div > div > form > div:first-of-type > a:last-of-type").show();
        }
        else{
            fields.attr('readonly', true);
            $("main > section > div > div > form > div:first-of-type > a:first-of-type").show();
            $("main > section > div > div > form > div:first-of-type > a:last-of-type").hide();
        }
    });    
}