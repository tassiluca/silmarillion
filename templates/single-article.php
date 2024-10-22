<?php if(isset($templateParams["product"])):?>
    <div>
        <ul>
            <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li><li><a href="catalog.php">Catalogo</a></li><li><?php echo $templateParams["product"]["Title"]?></li>
        </ul>
    </div>
    <section>
        <header><h3><?php echo $templateParams["product"]["Title"]?></h3></header>
        <aside>
            <div>
                <img src="<?php echo UPLOAD_DIR_PRODUCTS.$templateParams["product"]["CoverImg"]?>" alt="">
            </div>
        </aside><div>
            <header>
                <ul id="productInfo">
                    <?php
                    $isFavourite = isProdFavourite($dbh, $templateParams["product"]['ProductId']);
                    $favImg = $isFavourite ? "./img/products/favourite.svg" : "./img/products/un-favourite.svg";
                    $favDescr = $isFavourite ? "Rimuovi preferito" : "Salva preferito" ;
                    ?>
                    <!-- NOTE: if the article is not available implement "soldout" class, otherwise "available" class -->
                    <li class="<?php if($templateParams["copies"] > 0){ echo "available"; } else { echo "soldout"; }?>">
                        <?php echo $templateParams["copies"] > 0
                            ? $templateParams["copies"] ." copie disponibili"
                            : "Non disponibile";
                        ?>
                    </li><li>
                        <a href="./engines/process-request.php?action=wish&id=<?php echo $templateParams["product"]["ProductId"]?>" class="wishButton">
                            <img src="<?php echo $favImg?>" alt="<?php echo $favDescr?>" />
                        </a>
                    </li><li>
                        <a href="./engines/process-request.php?action=notify&id=<?php echo $templateParams["product"]["ProductId"]?>">
                            <?php echo $templateParams["isAlertActive"]
                                ? 'Avvisami quando questo prodotto sarà disponibile'
                                : 'Rimuovi notifica';
                            ?>
                        </a>
                        <div><p>Per effettuare questa operazione devi aver fatto Login. <br><a href="login.php">Pagina di login</a></p></div>
                    </li>
                </ul>
                <?php if($dbh -> isComic($templateParams["product"]["ProductId"])):?>
                    <ul>
                        <li><strong>Autore:</strong><?php echo $templateParams["product"]["Author"]?></li>
                        <li><strong>Editore:</strong><?php echo $templateParams["product"]["PublisherName"]?></li>
                        <li><strong>Anno:</strong><?php echo $templateParams["product"]["PublishDate"]?></li>
                        <li><strong>Lingua:</strong><?php echo $templateParams["product"]["Lang"]?></li>
                        <li><strong>ISBN:</strong><?php echo $templateParams["product"]["ISBN"]?></li>
                    </ul>
                <?php endif?>
            </header>
            <p><strong>Descrizione:</strong><?php echo $templateParams["product"]["Description"]?></p>
            <footer>
                <ul>
                    <li>
                        <?php if(isset($templateParams["product"]["DiscountedPrice"])):?>
                            <span><?php echo formatPrice($templateParams["product"]["Price"])?>€</span>
                            <?php echo formatPrice($templateParams["product"]["DiscountedPrice"])?>€
                            <?php else:?>
                                <?php echo formatPrice($templateParams["product"]["Price"])?>€
                            <?php endif?>
                        </li>
                    <li><a <?php if($templateParams["copies"] <=0){ echo 'class="disabled"';}?>href="./engines/process-request.php?action=addtoCart&id=<?php echo $templateParams["product"]["ProductId"]?>" class="cartButton"><span>Aggiungi al carrello</span><img src="./img/products/add-to-cart.svg" alt="Aggiungi al carrello"></a></li>
                </ul>
            </footer>
        </div>
    </section>
<?php endif ?>