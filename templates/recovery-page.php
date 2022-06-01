<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li><li><a href="login.php">Login</a></li><li>Recupera password</li>
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
                <h3>Dimenticato la password? &#128579; <br/> Niente paura... ci siamo noi &#129321;</h3>
            </li>
            <li>
                <strong>** QUESTA FUNZIONALIT&Agrave; NON &Egrave; ANCORA STATA IMPLEMENTATA **</strong>
                <p>Per ragioni di sicurezza, Silmarillion <strong>**NON**</strong> memorizza la tua password in chiaro.</p>
                <p>Inserisci l'indirizzo e-mail con cui ti eri registrato. Ti invieremo una mail con le istruzioni per resettare la tua password.</p>
            </li>
            <li>
                <label for="email">Email</label><input type="text" id="email" placeholder="giovanni.delnevo@gmail.com" name="email" pattern="^\S+@\S+$" title="Deve contenere un indirizzo mail valido" required />
            </li>
            <li>
                <input type="submit" value="RESETTA PASSWORD" />
            </li>
        </ul>
    </form>
</section>