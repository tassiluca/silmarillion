<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="#">Area personale</a></li>
    </ul>
</div>


<section>
    <h2>Ciao, <?php echo $_SESSION["name"]; ?> </h2>
    <button> <img src="../img/user-page/bellNotification.svg"></button>
</section>

<section>
    <button>
        <img src="../img/user-page/profile.svg" alt="Profilo">
        </br>Profilo
    </button>
    <button onclick="window.location.href='./statistics.php'">
        <img src="../img/user-page/money.svg" alt="Contabilità">
        </br>Contabilità
    </button>
    <button onclick="window.location.href='./manage-articles.php'">
        <img src="../img/user-page/wishlist.svg" alt="">
        </br>Articoli
    </button>
    <button>
        <img src="../img/user-page/message.svg" alt="">
        </br>Messaggi
    </button>
    <button>
        <img src="../img/user-page/articles.svg" alt="">
        </br>Gestione ordini
    </button>
    <button>
        <img src="../img/user-page/banner.svg" alt="">
        </br>Pubblicità
    </button>
</section>


<p> Click <a href="?action=logout">here</a> for log out.</p>







<!--
<div style="text-align: center">
    <p> Welcome to the **seller** area. </p>
    <p> Click <a href="?action=logout">here</a> for log out.</p>
    <p> This is just a placeholder waiting for @NalNemesi &#128540; </p>
    <p> Some useful links: </p>
    <ul>
        <li><a href="./manage-articles.php">Gestisci prodotti</a></li>
        <li><a href="./statistics.php">Statistiche introiti</a></li>
    </ul>
</div>

-->