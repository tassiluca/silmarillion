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
    <button onclick="window.location.href='./user-orders.php'">
        <img src="../img/user-page/order.svg" alt="Ordini"></br>
        Ordini
    </button>
    <button onclick="window.location.href='./user-wishlist.php'">
        <img src="../img/user-page/wishlist.svg" alt=""></br>
        Wishlist
    </button>
    <button onclick="window.location.href='./user-messages.php'">
        <img src="../img/user-page/message.svg" alt="" /></br>
        Messaggi
    </button>
    <button class="request">
        <img src="../img/user-page/chat.svg" alt=""></br>
        Hai bisogno di aiuto?
    </button>
    <button class="review">
        <img src="../img/user-page/star.svg" alt=""></br>
        Recensioni
    </button>
</section>

<aside id="requestForm">
    <form>
        <label for="requestProduct">Richiedi il prodotto</label>
        <button id="closeRequest">x</button>
        <textarea name="" id="requestProduct" cols="30" rows="10" placeholder="Scrivi..."></textarea>
        <button>INVIA</button>
    </form>
</aside>

<aside id="reviewForm">
    <form>
        <label for="review"><img src="" alt="./img">Metti stelle</label>
        <button id="closeReview">x</button>
        <textarea name="" id="review" cols="30" rows="10" placeholder="Scrivi..."></textarea>
        <button>INVIA</button>
    </form>
</aside>




<p> Click <a href="?action=logout">here</a> for log out.</p>
