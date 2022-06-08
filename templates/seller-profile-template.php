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
        <form method="post" autocomplete="on">
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
    <h3></h3>
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
