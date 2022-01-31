
            <section>
                <!-- here put all images to be shown in banner-->
                <?php if(isset($templateParams["homeBanner"])):
                        foreach($templateParams["homeBanner"] as $banner):
                    ?>
                    <img src="img/banner/<?php echo $banner ?>" class="banner fade"  alt="banner-<?php echo $banner?>"/>
                <?php endforeach;
                    endif;?>
                <!--end of element of banner-->
                <input type="image" src="img/Back.svg" onclick="updateBanner(-1)" onkeypress="updateBanner(-1)" alt="banner precedente" />
                <input type="image" src="img/Forward.svg" onclick="updateBanner(1)" onkeypress="updateBanner(-1)" alt="banner successivo" />

            </section>
            <aside>   
                <div>
                    <!--insert div to add banner-->
                    <div class="infoBanner">
                        <div><img src="img/Gift.png" alt=""></div>
                        <p>Spedizione gratuita sopra i 50 €</p>
                    </div>
                    <div class="infoBanner">
                        <div><img src="img/bankCards.svg" alt=""></div>
                        <p>Pagamenti online o in contanti</p>
                    </div>
                    <div class="infoBanner">
                        <div><img src="img/onlineSupport.svg" alt=""></div>
                        <p>Qualche dubbio ? Scrivici!</p>
                    </div>
                    <!--end of aside banner-->
                </div>
                <!--index aside-->
                <div>
                    <div class="current" onclick="showSlide(1)" onkeypress="showSlide(1)"></div>
                    <div onclick="showSlide(2)" onkeypress="showSlide(2)"></div>
                    <div onclick="showSlide(3)" onkeypress="showSlide(3)"></div>
                </div>
            </aside>
            <?php if(isset($templateParams["newArrival"] )):?>
            <section class="comics newArrival">
                <header>
                    <h2>Nuovi Arrivi</h2>
                </header>
                <div>
                <!--
                    here insert other article to be scrolled
                -->
                <?php foreach($templateParams["newArrival"] as $product):?>
                <article class="fade">
                    <div>
                        <img src="comics/<?php echo $product["CoverImg"]?>" alt="copertina <?php echo $product["CoverImg"]?>">
                    </div>
                    <header><?php echo $product["Title"]?></header>
                    <div><a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p><?php if(isset($product["DiscountedPrice"])){echo $product["DiscountedPrice"];}
                                            else{ echo $product["Price"];}?>€</p></div>
                    </div>
                </article>
                <?php endforeach;?>
                <!--
                    end group of article
                -->
                <input type="image" src="img/sort-left.svg" onclick="updateComic('newArrival',-1)" onkeypress="updateComic('newArrival',-1)" alt="fumetto precedente" >
                <input type="image" src="img/sort-right.svg" onclick="updateComic('newArrival',1)" onkeypress="updateComic('newArrival',1)" alt="fumetto successivo" >

                </div>
            </section>
            <?php endif ?>
            
            <section class="comics manga">
                <header>
                    <h2>Manga</h2>
                </header>
                <div>
                <!--
                    here insert other article to be scrolled
                -->
                <article class="fade">
                    <div>
                        <img src="develop/0.png" alt="">
                    </div>
                    <header>The Seven deadly sins</header>
                    <div>
                        <a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p>4,90€</p></div>
                    </div>
                </article>

                <article class="fade">
                    <div>
                        <img src="develop/1.png" alt="">
                    </div>
                    <header>The Seven deadly sins</header>
                    <div>
                        <a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p>4,90€</p></div>
                    </div>
                </article>
                <!--
                    end group of article
                -->
                <!--gli alt degli input vanno cambiati in base alla section in cui si trovano-->
                <input type="image" src="img/sort-left.svg" onclick="updateComic('manga',-1)" onkeypress="updateComic('manga',-1)" alt="manga precedente" >
                <input type="image" src="img/sort-right.svg" onclick="updateComic('manga',1)" onkeypress="updateComic('manga',1)" alt="manga successivo" >

                </div>
            </section>
            <section class="comics hero">
                <header>
                    <h2>Supoereroi</h2>
                </header>
                <div>
                <!--
                    here insert other article to be scrolled
                -->
                <article class="fade">
                    <div>
                        <img src="develop/0.png" alt="">
                    </div>
                    <header>The Seven deadly sins</header>
                    <div>
                        <a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p>4,90€</p></div>
                    </div>
                </article>

                <article class="fade">
                    <div>
                        <img src="develop/1.png" alt="">
                    </div>
                    <header>The Seven deadly sins</header>
                    <div>
                        <a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p>4,90€</p></div>
                    </div>
                </article>
                <article class="fade">
                    <div>
                        <img src="develop/2.png" alt="">
                    </div>
                    <header>The Seven deadly sins</header>
                    <div>
                        <a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p>4,90€</p></div>
                    </div>
                </article>
                <article class="fade">
                    <div>
                        <img src="develop/4.png" alt="">
                    </div>
                    <header>The Seven deadly sins</header>
                    <div>
                        <a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p>4,90€</p></div>
                    </div>
                </article>
                <article class="fade">
                    <div>
                        <img src="develop/5.png" alt="">
                    </div>
                    <header>The Seven deadly sins</header>
                    <div>
                        <a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p>4,90€</p></div>
                    </div>
                </article>
                <!--
                    end group of article
                -->
                <!--gli alt degli input vanno cambiati in base alla section in cui si trovano-->
                <input type="image" src="img/sort-left.svg" onclick="updateComic('hero',-1)" onkeypress="updateComic('hero',-1)" alt="fumetto precedente" >
                <input type="image" src="img/sort-right.svg" onclick="updateComic('hero',1)" onkeypress="updateComic('hero',1)" alt="fumetto successivo" >

                </div>
            </section>
            <section class="comics funko">
                <header>
                    <h2>Funko Pop</h2>
                </header>
                <div>
                <!--
                    here insert other article to be scrolled
                -->
                <article class="fade">
                    <div>
                        <img src="develop/0.png" alt="">
                    </div>
                    <header>The Seven deadly sins</header>
                    <div>
                        <a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p>4,90€</p></div>
                    </div>
                </article>

                <article class="fade">
                    <div>
                        <img src="develop/1.png" alt="">
                    </div>
                    <header>The Seven deadly sins</header>
                    <div>
                        <a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="Aggiungi al carrello"/></a><div><p>4,90€</p></div>
                    </div>
                </article>
                <!--
                    end group of article
                -->
                <!--gli alt degli input vanno cambiati in base alla section in cui si trovano-->
                <input type="image" src="img/sort-left.svg" onclick="updateComic('funko',-1)" onkeypress="updateComic('funko',-1)" alt="funko precedente" >
                <input type="image" src="img/sort-right.svg" onclick="updateComic('funko',1)" onkeypress="updateComic('funko',1)" alt="funko successivo" >

                </div>
            </section>
            <section class="review">
                <header>
                    <h2>Cosa dicono di noi</h2>
                </header>
                <div>
                <!--
                    here insert other article to be scrolled
                -->
                    <article class="fade">
                        <header><img src="img/commons/circleUser.svg" alt=""><h3>Username 1</h3></header>
                        <div>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <p>
                            Sito davvero affidabilissimo, consegna veloce e la pizza buonissima!!
                        </p>
                    </article>
                    <article class="fade">
                        <header><img src="img/commons/circleUser.svg" alt=""><h3>Marcolino</h3></header>
                        <div>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <p>
                            Sito davvero affidabilissimo, consegna veloce e la pizza buonissima!!
                        </p>
                    </article>
                    <article class="fade">
                        <header><img src="img/commons/circleUser.svg" alt=""><h3>Pane e vino</h3></header>
                        <div>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                        <p>
                            Sito davvero affidabilissimo, consegna veloce e la pizza buonissima!!
                        </p>
                    </article>
                <!--
                    end group of article
                -->
                <!--gli alt degli input vanno cambiati in base alla section in cui si trovano-->
                <input type="image" src="img/Back.svg" onclick="updateComic('review',-1)" onkeypress="updateComic('review',-1)" alt="recensione precedente" >
                <input type="image" src="img/Forward.svg" onclick="updateComic('review',1)" onkeypress="updateComic('review',1)" alt="recensione successivo" >

                </div>
            </section>
            <section >
                <header><h2>I Nostri partner</h2></header>
                <!-- here put all divs with partners to be shown in banner-->
                <div class="partner">
                    <div>
                        <img src="img/partners/Feltrinelli Comics.svg" alt="" class="fade">
                        <img src="img/partners/Planet MAnga.svg" alt="" class="fade">
                        <img src="img/partners/Feltrinelli Comics.svg" alt="" class="fade">
                    </div> 
                </div>
                <!--end of element of banner-->
                <input type="image" src="img/Back.svg" onclick="updatePartner(-1)" onkeypress="updatePartner(-1)" alt="partner indietro" >
                <input type="image" src="img/Forward.svg" onclick="updatePartner(1)" onkeypress="updatePartner(1)" alt="partner avanti" >

            </section>

