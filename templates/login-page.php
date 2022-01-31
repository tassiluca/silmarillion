<!-- Breadcrumb pagination -->
<div>
    <ul>
        <!-- TODO: link -->
        <li><a href="index.html"><img src="./img/home-icon.svg" alt="Home"></a></li><li>Login</li>
    </ul>
</div>
<section>
    <header>
        <div>
            <img src="./img/login/user-men-icon.svg" alt="">
        </div>
        <ul>
            <li id="userloginbtn"><a href="#userlogin">Utente</a></li><li id="sellerloginbtn"><a href="#sellerlogin">Venditore</a></li>
        </ul>
    </header>
    <!-- User login form -->
    <form action="#" method="POST" onsubmit="formHash(this, this.customerPwd, 'customerPwd');">
        <ul id="userlogin">
            <li>
                <label for="username">Username</label>
                <input type="text" placeholder="es. giovadelnevo" id="username" name="customerUsr" required />
            </li>
            <li>
                <label for="userpassword">Password</label>
                <input type="password" placeholder="Password" id="userpassword" name="customerPwd" required />
            </li>
            <li 
                <?php 
                    if (isset($templateParams["loginError"])) :
                        echo 'class=active'; 
                ?> 
            >
                        <strong><?php echo $templateParams["loginError"] ?></strong>
                <?php 
                    endif;
                ?>
            </li>
            <li>
                <a href="">Hai dimenticato la password?</a>
                <input type="submit" name="submit" value="ACCEDI" />
            </li>
            <li>
                <p>Non sei registrato?</p>
                <a href="./registration.php">CREA IL TUO ACCOUNT</a>
            </li>
        </ul>
    </form>
    <!-- Seller login form -->
    <form action="#" method="POST" onsubmit="formHash(this, this.sellerPwd, 'sellerPwd');">
        <ul id="sellerlogin">
            <li>
                <label for="sellername">Username</label>
                <input type="text" placeholder="es. silvymirry" id="sellername" name="sellerUsr" />
            </li>
            <li>
                <label for="sellerpassword">Password</label>
                <input type="password" placeholder="Password" id="sellerpassword" name="sellerPwd" />
            </li>
            <li 
                <?php 
                    if (isset($templateParams["loginError"])) :
                        echo 'class=active'; 
                ?>
            >
                        <strong><?php echo $templateParams["loginError"] ?></strong>
                <?php 
                    endif;
                ?>
            </li>
            <li>
                <a href="">Hai dimenticato la password?</a>
                <input type="submit" name="submit" value="ACCEDI" />
            </li>
        </ul>
    </form>
</section>