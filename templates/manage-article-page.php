<?php 
    define("PRODUCTS_PER_PAGE", 10);
    $totalAmountOfProducts = count(array_merge($dbh->getComics(), $dbh->getFunkos()));
    $totalPages = ceil($totalAmountOfProducts / PRODUCTS_PER_PAGE);
?>
<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/home-icon.svg" alt="Home"></a></li><li><a href="login.php">Area personale</a></li><li>Gestisci articoli</li>
    </ul>
</div>
<section>
    <header>
        <h2>Gestisci Articoli</h2>
        <input type="text" name="search" placeholder="Cerca..." aria-label="Cerca prodotto" />
    </header>
    <ul id="products">
        <!-- here are inserted all products -->       
    </ul>
    <footer>
        <ul>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li><a href=""><?php echo $i; ?></a></li>
            <?php endfor; ?>
        </ul>
    </footer>
</section>