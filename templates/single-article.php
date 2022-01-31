            
            <?php if(isset($templateParams["product"])):?>
                <div><ul>
                    <li><a href="index.html"><img src="./img/home-icon.svg" alt="Home"></a></li><li><a href="catalog.html">Catalogo</a></li><li><?php echo $templateParams["product"]["Title"]?></li>
                </ul>
            </div>
            <h2><?php echo $templateParams["product"]["Title"]?></h2>
            <aside>
                <div>
                    <img src="./img/comics/<?php echo $templateParams["product"]["CoverImg"]?>" alt="">
                </div>
            </aside><section>
                <header>
                    <ul id="productInfo">
                        <!-- NOTE: if the article is not available implement "soldout" class, otherwise "available" class -->
                        <!-- TODO: implement link with php -->
                        <li class="soldout">Non disponibile</li><li><a href="#notificationArea"><img src="./img/favourite.svg" alt="Preferito" /></a></li>
                        <li><a href="#notificationArea">Avvisami quando questo prodotto sarà disponibile</a></li>
                    </ul>
                    <div id="notificationArea" class="warning">
                        <!-- NOTE: if an error message must be displayed add a class error, otherwise message -->
                        <span></span>
                        <strong>Per svolgere questa azione devi essere loggato!</strong>
                    </div>
                    <ul>
                        <li><strong>Autore:</strong><?php echo $templateParams["product"]["Author"]?></li>
                        <li><strong>Editore:</strong><?php echo $templateParams["product"]["Author"]?></li>
                        <li><strong>Anno:</strong><?php echo $templateParams["product"]["PublishDate"]?></li>
                        <li><strong>Lingua:</strong><?php echo $templateParams["product"]["Lang"]?></li>
                        <li><strong>ISBN:</strong><?php echo $templateParams["product"]["ISBN"]?></li>
                    </ul>
                </header>
                <p><strong>Descrizione:</strong><?php echo $templateParams["product"]["Description"]?></p>
                <footer>
                    <ul>
                        <li><span><?php echo $templateParams["product"]["Price"]?>€</span><?php echo $templateParams["product"]["DiscountedPrice"]?>€</li><li><a href="#notificationArea"><span>Aggiungi al carrello</span><img src="./img/add-to-cart.svg" alt="Aggiungi al carrello"></a></li>
                    </ul>
                </footer>
            </section>
        <?php endif ?>