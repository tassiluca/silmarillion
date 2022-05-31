<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="../user-area.php">Area personale</a></li>
        <li><a href="#">Profilo</a></li>
    </ul>
</div>

<!-- Personal data, view and modify -->
<section>
    <img src="../img/user-page/face-id-icon.svg" alt=""/>
    <fieldset>
        <legend>Dati personali</legend>
        <form action="" method="post" target="" autocomplete="on">
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
                <input type="button" value="Modifica" class="modifyData whiteBtn"/>
                <input type="button" value="Annulla" class="cancelData whiteBtn" disabled/>
                <input type="submit" value="INVIA" class="submitData whiteBtn" disabled/>
            </div>
        </form>
    </fieldset>
</section>

<!-- login form -->
<section>
    <img src="../img/user-page/anonymous-icon.svg" alt=""/>
    <fieldset>
        <legend>Login</legend>
        <form action="" method="post" target="" autocomplete="on">
            <div>
                <span>
                    <label for="userName">Username</label>
                    <input type="text" id="userName" name="userNameUtente" placeholder="Username"
                           value="<?php echo $_SESSION['username'] ?>"
                           disabled readonly />
                </span>
                <!-- TODO - popup username @NalNemesi -->
                <!--Popup
                <div class="miniPop">
                    <span class="miniPopText">Non puoi modificare questo campo!</span>
                </div> -->
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
                <input type="button" value="Modifica" class="modifyLog whiteBtn"/>
                <input type="button" value="Annulla" class="cancelLog whiteBtn" disabled/>
                <input type="submit" value="INVIA" class="submitLog whiteBtn" disabled/>
            </div>
        </form>
    </fieldset>
</section>


