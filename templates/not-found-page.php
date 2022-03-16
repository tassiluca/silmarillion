 <!-- Breadcrumb pagination -->
 <div>
    <ul>
        <li><a href="index.php"><img src="./img/home-icon.svg" alt="Home"></a></li>
        <li>Pagina errore</li>
    </ul>
</div>
<section>
    <header>
        <h3>Ops ... Pagina non trovata</h3>
    </header>
    <div>
        <?php
            $images = glob("./img/not-found/*");
            $imgAmount = count($images)-1 < 0 ? 0 : count($images)-1;
        ?>
        <div><p><?php if(isset($templateParams["msgError"])){echo $templateParams["msgError"];}?></p></div>
        <img src="<?php echo $images[random_int(0,$imgAmount)]?>" alt="Cane seduto">
    </div>
</section>