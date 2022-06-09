<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="#">Area personale</a></li>
    </ul>
</div>


<section>
    <h3>Ciao, <?php echo $_SESSION["name"]; ?> </h3>
    <a href="#" class="notification">
        <span><img src="./img/user-page/Letterbox.svg" alt="letterbox"></span>
        <span class="badge">New message</span>
    </a>
</section>

<section>
    <button onclick="window.location.href='./seller-profile.php'">
        <img src="./img/user-page/profile.svg" alt="Profilo">
        <br>Profilo
    </button>
    <button onclick="window.location.href='./statistics.php'">
        <img src="./img/user-page/money.svg" alt="Contabilità">
        <br>Contabilità
    </button>
    <button onclick="window.location.href='./manage-articles.php'">
        <img src="./img/user-page/articles.svg" alt="">
        <br>Articoli
    </button>
    <button onclick="window.location.href='./seller-messages.php'">
        <img src="./img/user-page/message.svg" alt="">
        <br>Messaggi
    </button>
    <button onclick="window.location.href='?action=logout'">
        <img src="./img/user-page/Exit.svg" alt=""><br>
        Logout
    </button>
    <button onclick="window.location.href='./seller-manage-orders.php'">
        <img src="./img/user-page/order.svg" alt="">
        <br>Gestione ordini
    </button>

</section>

