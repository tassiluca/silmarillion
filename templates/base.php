<!DOCTYPE html>
<html lang="it">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="./css/style.css" />
        <!-- insert here all the style sheets needed by page -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/navbar.js"></script>
        <!-- insert here all the scripts needed by page -->
        <title>Silmarillion</title>
    </head>
    <body>
        <header>
            <h1 class="hide">Silmarillion Comics</h1>
            <nav>
                <ul>
                    <li><button type="button"><img src="./img/commons/menu.svg" alt="Menu"/></button></li><li><button type="button"><img src="./img/commons/menu-search.svg" alt="Cerca"/></button></li><li><button type="button"><img src="./img/commons/menu-login.svg" alt="Login"/></button></li><li><button type="button" ><img src="./img/commons/menu-cart.svg" alt="Carrello"/></button></li>
                </ul>
                <div id="navMenu">
                    <ul><li><a href="catalog.html">Nuovi Arrivi</a></li><li><a href="catalog.html">Manga</a></li><li><a href="catalog.html">Supoereroi</a></li><li><a href="catalog.html">Funko Pop</a></li><li id="login"><a href="login.html">Login</a></li><li><a href="">Recensioni</a></li><li><a href="">Partner</a></li><li><a href="">Supporto</a></li>
                    </ul> 
                </div>
                <div id="navCart">
                    <ul>
                        <li><img src="img/cart/Deadpool_Cake_POP_GLAM-1-WEB_700x 1.svg" alt="">
                        <div><p>Deadpool_Cake_POP_GLAM</p><div><p>15,99€</p><p>x2</p></div></div></li>
                        <li><img src="img/cart/Deadpool_Cake_POP_GLAM-1-WEB_700x 1.svg" alt="">
                            <div><p>Deadpool_Cake_POP_GLAM</p><div><p>15,99€</p><p>x2</p></div></div></li>
                    </ul>
                    <a href="cart.html">Visualizza carrello</a>
                </div>
                <!-- search dropdown menu -->
                <div id="navSearch">
                    <form action="#" method="GET">
                        <h2>Cerca</h2>
                        <ul>
                            <li>
                                <label for="search">Cerca</label>
                                <input type="text" placeholder="Cerca..." id="search" name="search" required /><button type="submit"><img src="./img/commons/search-icon.svg" alt="Vai!"/></button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- login dropdown menu -->
                <div id="navLogin">
                    <form action="#" method="POST">
                        <h2>Login</h2>
                        <ul>
                            <li>
                                <label for="usernameNav">Username</label>
                                <input type="text" placeholder="es. giovanni.delnevo@gmail.com" id="usernameNav" name="usr" required />
                            </li>
                            <li>
                                <label for="userpasswordNav">Password</label>
                                <input type="password" placeholder="Password" id="userpasswordNav" name="pwd" required />
                            </li>
                            <li>
                                <div>
                                    <a href="">Dimenticato la password?</a>
                                    <a href="login.html">Accedi come venditore</a>
                                </div>
                                <input type="submit" name="submit" value="ACCEDI" />
                            </li>
                            <li>
                                <p>Non sei registrato?</p>
                                <a href="./register.html">CREA IL TUO ACCOUNT</a>
                            </li>
                        </ul>
                    </form>
                </div>
            </nav>
        </header>
        <main>
            <!-- insert here main -->
        </main>
        <footer>
            <h4 class="hide">Silmarillion Comics</h4>
            <div>
                <h4>INFO</h4> 
                <ul>
                    <li>Chi Siamo</li>
                    <li>Contattaci</li>
                    <li>FAQs</li>
                </ul>
            </div><div>
                <h4>ACCOUNT</h4>
                <ul>
                    <li>Account utente</li>
                    <li>Account venditore</li>
                </ul>
                <h4>CONDIZIONI</h4>
                <ul>
                    <li>Termini e condizioni di utilizzo</li>
                    <li>Reso di un ordine</li>
                </ul>
            </div><div>
                <h4>CONTATTI</h4>
                <ul>
                    <li>Via del Campus 5814</li>
                    <li><a href="mailto:info@silmarillion.it">info@silmarillion.it</a></li>
                    <li> <a href="tel:+390587932451"> 05 879 32 451</a></li>
                </ul>
            </div>
        </footer>
    </body>
</html>