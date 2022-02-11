<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/home-icon.svg" alt="Home"></a></li><li><a href="./login.php">Login</a></li><li>Registrazione</li>
    </ul>
</div>
<section>
    <header>
        <div>
            <img src="./img/login/user-men-icon.svg" alt="">
        </div>
    </header>
    <form action="#" method="POST">
        <ul>
            <li>
                <h2>Ciao, <br/>conosciamoci meglio</h2>
            </li>
            <li>
                <p>Silmarillion rispetta la tua privacy &#128525;. La password inserita nel form viene inviata al server solo dopo essere stata precedentemente crittografata. </p>
            </li>
            <li>
                <img src="./img/login/face-id-icon.svg" alt="" />
            </li>
            <li>
                <label for="name">Nome</label><input type="text" placeholder="Nome" id="name" name="name" required /><label for="surname">Cognome</label><input type="text" placeholder="Cognome" id="surname" name="surname" required />
            </li>
            <li>
                <img src="./img/login/birthday-icon.svg" alt="" />
            </li>
            <li>
                <label id="birthdayLabel" for="birthday">Data di nascita</label><input type="date" id="birthday" name="birthday" required />
            </li>
            <li>
                <img src="./img/login/anonymous-icon.svg" alt="" />
            </li>
            <li>
                <label for="username">Username</label><input type="text" placeholder="Username" id="username" name="usr" required />
            </li>
            <li>
                <label for="email">Email</label><input type="text" id="email" placeholder="Email" name="email" pattern="^\S+@\S+$" title="Deve contenere un indirizzo mail valido" required />
            </li>
                <li>
                <label for="password">Password</label><input type="password" placeholder="Password" id="password" name="pwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Deve contenere almeno un numero, una minuscolo e una maiuscola, nonché almeno 8 caratteri" required />
                <section>
                    <p>Ai fini di sicurezza, la password deve contenere almeno:</p>
                    <p id="letter" class="invalid">Una lettera <strong>minuscola</strong></p>
                    <p id="capital" class="invalid">Una lettera <strong>maiuscola</strong></p>
                    <p id="number" class="invalid">Un <strong>numero</strong></p>
                    <p id="length" class="invalid"><strong>8 caratteri</strong></p>
                </section>                        
            </li>
            <li>
                <input type="submit" value="CREA ACCOUNT" />
            </li>
        </ul>
    </form>
</section>
