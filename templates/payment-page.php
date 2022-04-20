<?php /** @var $templateParams */ ?>
<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li><li><a href="cart.php">Carrello</a></li>
    </ul>
</div>
<section>
    <header><h2>Pagamento Ordine</h2></header>
    <?php if (!isset($templateParams["msg"])): ?>
        <div>
            <div>
                <form id="addressForm" method="POST" action="./engines/process-payment.php">
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
                            <li>
                                <input type="radio" name="paymethod" id="cash" value="-1" required />
                                <label for="cash">Contanti</label>
                            </li>
                            <?php foreach($templateParams["paymentMethods"] as $method):
                                $methodName = $method['Name'] . (!empty($method['Number'])
                                        ? " nr. " . $method['Number']
                                        : " - " . $method['Mail']);
                                $methodId = $method['MethodId'];
                            ?>
                                <li>
                                    <input type="radio" name="paymethod" id="<?php echo $methodName;?>" value="<?php echo $methodId;?>" />
                                    <label for="<?php echo $methodName;?>"><?php echo $methodName;?></label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </form>
            </div>
            <div>
                <p>Totale:</p><p><?php echo formatPrice($templateParams["totalAmount"]); ?></p>
            </div>
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