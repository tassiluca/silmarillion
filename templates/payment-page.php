
<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.html"><img src="./img/home-icon.svg" alt="Home"></a></li><li>Carrello</li>
    </ul>
</div>
<section>
    <header><h2>Pagamento Ordine</h2></header>
    <div>
        <div>
            <article>
                <header></header>
                <form id="addressForm" method="post" action="#">
                    <h3>Indirizzo di spedizione</h3>
                    <div>
                        <ul>
                            <li><label for="destAddress">Indirizzo</label><input type="text" name="destAddress" id="destAddress" alt="Indirizzo" value="Via Cesare Pavese, 50"required readonly></li>
                            <li><label for="cap">CAP</label><input type="text" name="cap" id="cap" alt="CAP" value="47522" required readonly></li>
                            <li><label for="city">Città</label><input type="text" name="city" id="city" alt="Città"  value="Cesena" required readonly></li>
                            <li><label for="prov">Provincia</label><input type="text" name="prov" id="prov" alt="Provincia" value="FC" required readonly></li>
                        </ul>
                        <a href="#" onclick="editAddress()" onkeypress="editAddress()">Modifica indirizzo</a>
                        <a href="#" onclick="editAddress()" onkeypress="editAddress()">Conferma</a>
                    </div>
                    <h3>Metodo di Pagamento</h3>
                    <div>
                        <ul>
                        <li><input type="radio" name="paymethod" id="paypal" value="paypal" required><label for="paypal">PayPal</label></li>
                        <li><input type="radio" name="paymethod" id="card" value="card" required><label for="card">Carta</label></li>
                    </ul>
                    </div>
                </form>
            </article>
        </div>
        <div>
            <p>Totale:</p><p>94,89€</p>
        </div>
        <div><input type="submit" form="addressForm" value="ACQUISTA ORA"></input></div>
    </div>
</section>