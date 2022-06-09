<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="./seller-area.php">Area personale</a></li>
        <li><a href="#">Ordini</a></li>
    </ul>
</div>

<h3>Ordini</h3>


<?php
    $dark = true;
    foreach ($templateParams["order"] as $order):
        $dark = !$dark;
?>


<div class="container <?php echo $dark? "darker":"" ?>">
    <img src="../img/user-page/Supplier.svg" alt="Avatar" <?php echo  "class='right'" ?>>
    <p class="text"><?php echo $order['Name'] . " " .  $order['Surname'] ?></p>
    <p>ha effettuato un ordine per un totale di: <?php echo formatPrice($order['Price'])?> € <br>Prodotti acquistati:</p>
    <?php $templateParams["detail"] = $dbh->detailOrder($order['OrderId']);
        foreach ($templateParams['detail'] as $detail): ?>
            <img class="ord" src="<?php echo UPLOAD_DIR_PRODUCTS .  $detail['CoverImg'];?>"   alt="orders">
        <?php endforeach; ?><br>

    <span class="<?php echo $dark? "time-right":"time-right" ?>"><?php echo $order['OrderDate'] ?></span>
</div>

<?php endforeach; ?>