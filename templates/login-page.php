            <!-- Breadcrumb pagination -->
            <div>
                <ul>
                    <li><a href="index.html"><img src="./img/home-icon.svg" alt="Home"></a></li><li>Login</li>
                </ul>
            </div>
            <form action="#" method="POST">
                <header>
                    <div>
                        <img src="./img/login/user-men-icon.svg" alt="">
                    </div>
                    <ul>
                        <li id="userloginbtn"><a href="#userlogin">Utente</a></li><li id="sellerloginbtn"><a href="#sellerlogin">Venditore</a></li>
                    </ul>
                </header>
                <!-- User login form -->
                <ul id="userlogin">
                    <li>
                        <label for="username">Username</label>
                        <input type="text" placeholder="es. giovanni.delnevo@gmail.com" id="username" name="usr" required />
                    </li>
                    <li>
                        <label for="userpassword">Password</label>
                        <input type="password" placeholder="Password" id="userpassword" name="pwd" required />
                    </li>
                    <li>
                        <a href="">Hai dimenticato la password?</a>
                        <input type="submit" name="submit" value="ACCEDI" />
                    </li>
                    <li>
                        <p>Non sei registrato?</p>
                        <a href="./register.html">CREA IL TUO ACCOUNT</a>
                    </li>
                </ul>
                <!-- Seller login form -->
                <ul id="sellerlogin">
                    <li>
                        <label for="sellername">Username</label>
                        <input type="text" placeholder="es. silvia.mirri@silmarillion.com" id="sellername" name="usr" />
                    </li>
                    <li>
                        <label for="sellerpassword">Password</label>
                        <input type="password" placeholder="Password" id="sellerpassword" name="pwd" />
                    </li>
                    <li>
                        <a href="">Hai dimenticato la password?</a>
                        <input type="submit" name="submit" value="ACCEDI" />
                    </li>
                </ul>
            </form>