<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="#">Area personale</a></li>
    </ul>
</div>


<section>
    <h2>Ciao, <?php echo $_SESSION["username"]; ?> </h2>
    <button> <img src="../img/user-page/bellNotification.svg"></button>
</section>

<section>
   <button onclick="window.location.href='./user-profile.php'">
       <img src="../img/user-page/profile.svg" alt="Profilo"></br>
       Profilo
   </button>
    <button onclick="window.location.href='./profile-template.php'">
        <img src="../img/user-page/order.svg" alt="Ordini"></br>
        Ordini
    </button>
    <button>
        <img src="../img/user-page/wishlist.svg" alt=""></br>
        Wishlist
    </button>
    <button>
        <img src="../img/user-page/message.svg" alt=""></br>
        Messaggi
    </button>
    <button>
        <img src="../img/user-page/chat.svg" alt=""></br>
        Hai bisogno di aiuto?
    </button>
    <button>
        <img src="../img/user-page/star.svg" alt=""></br>
        Recensioni
    </button>
</section>




<p> Click <a href="?action=logout">here</a> for log out.</p>
