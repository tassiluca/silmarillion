
$(document).ready(function () {
    refreshTotalPrice();
});

function refreshTotalPrice(){
    $("#totalPrice").text('');
    $.post("./engines/process-cart.php?request=getCart", function (data) {
        let cart = JSON.parse(data);
        let totalPrice = 0;
        for(let i=0 ;i< cart.length;i++){
            let prod = cart[i];
            price = prod['DiscountedPrice'] !==null ? prod['DiscountedPrice'] : prod['Price'];

            if(!$("article#"+prod['ProductId']).hasClass("notAvaialable")){
                totalPrice += (price*prod['Quantity']);
            }
        }
        $("#totalPrice").text(totalPrice+" €");
    });
}

function checkIfEmptyRefreshCart(actualcartCount){
    if(actualcartCount <= 0){
        $("section > div > div:first-child()").append("<p>Carrello vuoto</p>");
        $("main > section > div > div > a").addClass("disabled");
    }
}