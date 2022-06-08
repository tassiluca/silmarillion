<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="./user-area.php">Area personale</a></li>
        <li><a href="#">Ordini</a></li>
    </ul>
</div>




<div class="timeline">

    <?php
    $pos = false;
    foreach ($templateParams['orderDetails'] as $orderDetails):
        $pos = !$pos;

    ?>


    <div class="container <?php echo $pos?"left":"right" ?>">
        <div class="content">
            <h2><?php $date = new DateTime($orderDetails['OrderDate']);
                 echo $date->format(' l jS F Y');  ?></h2>
            <p>Hai acquistato:</p>
            <?php
            $covers = $dbh->detailOrder($orderDetails['OrderId']);
            foreach ($covers as $cover):
            ?>
            <img class="imgOrders" src="<?php echo UPLOAD_DIR_PRODUCTS . $cover['CoverImg']; ?>" alt="FunkoPop">

            <?php endforeach; ?>

            <p>Totale: <?php echo formatPrice($orderDetails['Price']); ?></p>

            <a class="" href="#">Visualizza ordine</a>
        </div>
    </div>

    <?php endforeach;?>


</div>


<div class="firstContainer">
    <div class="firstContent">
        <h2>Fine storico</h2>
    </div>
</div>