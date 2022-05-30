<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="#">Area personale</a></li>
    </ul>
</div>


<!-- TODO
    valutate better choice-->
<section>
    <h2>Ciao, <?php echo $_SESSION["name"]; ?> </h2>
    <button> <img src="../img/user-page/bellNotification.svg"></button>
</section>


<section>
   <button>
       <img src="../img/user-page/profile.svg" alt="Profilo">
       <p>Profilo</p>
   </button>
    <button>
        <img src="../img/user-page/order.svg" alt="Ordini">
        <p>Ordini</p>
    </button>
    <button>
        <img src="../img/user-page/wishlist.svg" alt="">
        <p>Wishlist</p>
    </button>
    <button>
        <img src="../img/user-page/message.svg" alt="">
        <p>Messaggi</p>
    </button>
    <button>
        <img src="../img/user-page/chat.svg" alt="">
        <p>Hai bisogno di aiuto?</p>
    </button>
    <button>
        <img src="../img/user-page/star.svg" alt="">
        <p>Recensioni</p>
    </button>
</section>


<p> Click <a href="?action=logout">here</a> for log out.</p>
