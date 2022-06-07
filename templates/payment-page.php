<?php /** @var $templateParams */ ?>
<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li><li><a href="cart.php">Carrello</a></li>
    </ul>
</div>
<section>
    <header><h3>Pagamento Ordine</h3></header>
    <?php if (!isset($templateParams["msg"])): ?>
        <div>
            <div>
                <form id="addressForm" method="POST" action="./engines/process-payment.php">
                    <fieldset>
                        <legend><h4> Indirizzo di spedizione </h4></legend>
                        <ul>
                            <li>
                                <label for="destAddress">Indirizzo</label>
                                <input type="text" name="destAddress" id="destAddress" value="Via Cesare Pavese, 50"required readonly>
                            </li>
                            <li>
                                <label for="cap">CAP</label>
                                <input type="text" name="cap" id="cap" value="47522" pattern="\d{1,5}" maxlength="5" minlength="5" title="Deve contenere un CAP valido" required readonly>
                            </li>
                            <li>
                                <label for="city">Città</label>
                                <input type="text" name="city" id="city" value="Cesena" required readonly>
                            </li>
                            <li>
                                <label for="prov">Provincia</label>
                                <input type="text" name="prov" id="prov" value="FC" pattern="^[A-Z]*$" maxlength="2" minlength="2" title="Deve contenere una sigla di provincia valido (in maiuscolo)" required readonly>
                            </li>
                        </ul>
                        <a href="#" onclick="editAddress()" onkeypress="editAddress()">Modifica indirizzo</a>
                        <a href="#" onclick="editAddress()" onkeypress="editAddress()">Conferma</a>
                    </fieldset>
                    <fieldset>
                        <legend><h4> Metodo di Pagamento </h4></legend>
                        <ul>
                            <li>
                                <input type="radio" name="paymethod" id="cash" value="-1" required />
                                <label for="cash">Contanti, alla consegna &#128176;</label>
                            </li>
                            <?php foreach($templateParams["paymentMethods"] as $method):
                                $methodName = $method['Name'] . (!empty($method['Number'])
                                        ? " nr. " . $method['Number']
                                        : " - " . $method['Mail']);
                                $methodId = $method['MethodId'];
                            ?>
                                <li>
                                    <input type="radio" name="paymethod" id="method-<?php echo $methodId;?>" value="<?php echo $methodId;?>" />
                                    <label for="method-<?php echo $methodId;?>"><?php echo $methodName;?></label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </fieldset>
                </form>
            </div>
            <div>
                <p>Totale:</p><p><?php echo formatPrice($templateParams["totalAmount"]); ?> &euro;</p>
            </div>
            <?php if (isset($_GET['inputError'])): ?>
                <div id="inputError">
                    <p><?php echo $_GET['inputError']; ?></p>
                </div>
            <?php endif; ?>
            <div>
                <input type="submit" form="addressForm" value="ACQUISTA ORA"/>
            </div>
        </div>
    <?php else: ?>
        <div>
            <h3><?php echo $templateParams["msg"]; ?>.</h3>
            <p>Vai nel <a href="cart.php">Carrello</a> o torna nella <a href="index.php">Home</a>.</p>
        </div>
    <?php endif; ?>
</section>