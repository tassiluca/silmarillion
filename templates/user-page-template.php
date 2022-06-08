<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="./user-area.php">Area personale</a></li>
    </ul>
</div>

<section>
    <h3>Ciao, <?php echo $_SESSION["username"]; ?> </h3>
    <button> </button>
    <a href="#" class="notification">
        <span><img src="./img/user-page/Letterbox.svg" alt="letterbox"></span>
        <span class="badge">New message</span>
    </a>
</section>

<section>
   <button onclick="window.location.href='./user-profile.php'">
       <img src="./img/user-page/profile.svg" alt="Profilo"><br>
       Profilo
   </button>
    <button onclick="window.location.href='./user-orders.php'">
        <img src="./img/user-page/order.svg" alt="Ordini"><br>
        Ordini
    </button>
    <button onclick="window.location.href='./user-wishlist.php'">
        <img src="./img/user-page/wishlist.svg" alt=""><br>
        Wishlist
    </button>
    <button onclick="window.location.href='./user-messages.php'">
        <img src="./img/user-page/message.svg" alt="" /><br>
        Messaggi
    </button>
    <button onclick="window.location.href='?action=logout'">
        <img src="./img/user-page/Exit.svg" alt=""><br>
        Logout
    </button>
    <button class="review">
        <img src="./img/user-page/star.svg" alt=""><br>
        Recensioni
    </button>
</section>

<aside id="requestForm">
    <form>
        <label for="requestProduct">Richiedi il prodotto</label>
        <button id="closeRequest">x</button>
        <textarea name="help" id="requestProduct" cols="30" rows="10" placeholder="Scrivi..."></textarea>
        <button class="send">INVIA</button>
    </form>
</aside>

<aside id="reviewForm">
    <form>
        <div>
            
        </div>
        <fieldset class="nope">
            <legend class="nope">
                <input type="radio" id="rating-1" name="rating" value="1" class="fa fa-star" /><label for="rating-1"></label>
                <input type="radio" id="rating-2" name="rating" value="2" class="fa fa-star" /><label for="rating-2"></label>
                <input type="radio" id="rating-3" name="rating" value="3" class="fa fa-star" /><label for="rating-3"></label>
                <input type="radio" id="rating-4" name="rating" value="4" class="fa fa-star" checked="checked" /><label for="rating-4"></label>
                <input type="radio" id="rating-5" name="rating" value="5" class="fa fa-star" /><label for="rating-5"></label>

                <button id="closeReview"><img src="../img/user-page/Close%20Window.svg" alt="chiudi" /></button>

                <label for="review" class="hide"></label>
                <textarea name="recensioni" id="review" cols="30" rows="10" placeholder="Scrivi..."></textarea>
                <input type="submit" name="recensioni" class="btn" value="Salva"/>

            </legend>
        </fieldset>

    </form>
</aside>

