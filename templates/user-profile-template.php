<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="./index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="./user-area.php">Area personale</a></li>
        <li><a href="#">Profilo</a></li>
    </ul>
</div>

<!-- Personal data, view and modify -->
<section>
    <img src="./img/user-page/face-id-icon.svg" alt=""/>
    <fieldset>
        <legend>Dati personali</legend>
        <form  method="post"  autocomplete="on">
            <div>
                <span>
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nomeUtente" placeholder="Nome"
                           value="<?php echo $_SESSION["name"] ?>" class="notDisData"
                           disabled required/>
                </span>
                <span>
                    <label for="cognome">Cognome</label>
                     <input type="text" id="cognome" name="cognomeUtente" placeholder="Cognome"
                            value="<?php echo $_SESSION["surname"] ?>" class="notDisData"
                            disabled required/>
                </span>
            </div>
            <div>
                <label for="compleanno">Data di nascita</label>
                <input type="date" id="compleanno" name="compleannoUtente" min="1900-01-01" max="2012-12-31"
                       value="<?php echo $_SESSION['datebirth'] ?>" class="notDisData"
                       disabled required/>
            </div>
            <div>
                <input type="button" value="Modifica" id="modifyData" class="whiteBtn"/>
                <input type="button" value="Annulla" id="cancelData" class="whiteBtn" />
                <input type="submit" name="confirmData" value="INVIA" id="submitData" class="whiteBtn" />
            </div>
        </form>
    </fieldset>
</section>

<!-- login form -->
<section>
    <img src="./img/user-page/anonymous-icon.svg" alt=""/>
    <fieldset>
        <legend>Login</legend>
        <form method="post"  autocomplete="on">
            <div>
                <span>
                    <label for="userName">Username</label>
                    <input type="text" id="userName" name="userNameUtente" placeholder="Username"
                           value="<?php echo $_SESSION['username'] ?>"
                           disabled readonly />
                </span>
            </div>

            <div>
                <span>
                    <label class="textInsideBold" for="email">Email</label>
                    <input type="email" id="email" name="emailUtente" placeholder="email"
                           value="<?php echo $_SESSION['mail'] ?>" class="notDisLog"
                           disabled required/>
                </span>
                <span>
                    <label for="userType">Profilo</label>
                    <input type="text" id="userType" name="passwordUtente" placeholder="password"
                           value="<?php if (!empty($templateParams)) {
                               echo $templateParams["type-user"];
                           } ?> " class="notDisLog"
                           disabled required/>
                </span>
            </div>
            <div>
                <input type="button" value="Modifica" id="modifyLog" class="whiteBtn"/>
                <input type="button" value="Annulla" id="cancelLog" class="whiteBtn" disabled/>
                <input type="submit" value="INVIA" id="submitLog" name="confirmLog" class="whiteBtn" disabled/>
            </div>
        </form>
    </fieldset>
</section>



<aside>
    <p>Metodi di pagamento:</p>
    <select id="choice">
        <option value="0">Paypal</option>
        <option value="1">Carta di credito</option>
    </select>

    <fieldset id="paypal">
        <legend>Salvati</legend>
        <form action="" method="post" target="" autocomplete="on">
            <div>
                <label for="id1"></label>
                <input type="text" id="id1" name="" readonly required>
                <button class="erasePaypal"><img src="./img/user-page/Delete.svg" alt=""/></button>
                <button class="confirmPaypal"><img src="./img/user-page/Done.svg" alt=""/></button>
            </div>
            <div>
                <label for="id2"></label>
                <input type="text" id="id2" name="" readonly required>
                <button class="erasePaypal"><img src="./img/user-page/Delete.svg" alt=""/></button>
                <button class="confirmPaypal"><img src="./img/user-page/Done.svg" alt=""/></button>
            </div>
            <div>
                <label for="id3"></label>
                <input type="text" id="id3" name="" readonly required>
                <button class="erasePaypal"><img src="./img/user-page/Delete.svg" alt=""/></button>
                <button class="confirmPaypal"><img src="./img/user-page/Done.svg" alt=""/></button>
            </div>
            <div>
                <label for="id4"></label>
                <input type="text" id="id4" name="" readonly required>
                <button class="erasePaypal"><img src="./img/user-page/Delete.svg" alt=""/></button>
                <button class="confirmPaypal"><img src="./img/user-page/Done.svg" alt=""/></button>
            </div>
        </form>
    </fieldset>

    <fieldset id="creditCard">
        <legend>Dati</legend>
        <form action="" method="post" target="" autocomplete="on">
            <div>
                <label for="nameCred">Nome</label>
                <input type="text" id="nameCred" name=""  readonly required>
            </div>
            <div>
                <label for="numCred">N.Carta</label>
                <input type="text" id="numCred" name="" readonly required>
            </div>
            <div>
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="" readonly required>
            </div>
            <div>
                <label for="expDate">Exp.Date</label>
                <input type="text" id="expDate" name="" readonly required>
            </div>
        </form>
    </fieldset>
</aside>

<aside>
    <fieldset>
        <legend>Indirizzo di spedizione</legend>
        <form action="" method="post" target="" autocomplete="on">
            <div>
                <label for="strada">Via/Piazza</label>
                <input type="text" id="strada" name="" value="Via Cesare Pavese, 50" readonly required>
            </div>
            <div>
                <label for="citta">Città</label>
                <input type="text" id="citta" name="" value="Cesena" readonly required>
            </div>
            <div>
                <label for="cap">CAP</label>
                <input type="text" id="cap" name="" value="47522" readonly required>
            </div>
            <div>
                <label for="provincia">Provincia</label>
                <input type="text" id="provincia" name="" value="FC" readonly required>
            </div>
        </form>
    </fieldset>
</aside>


