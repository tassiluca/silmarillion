
 <section>
    <!-- here put all images to be shown in banner-->
    <?php if(isset($templateParams["newsBanner"])):
            foreach($templateParams["newsBanner"] as $banner):
        ?>
        <img src="img/banner/<?php echo $banner["Img"] ?>" class="banner fade"  alt="<?php echo $banner["Description"]?>"/>
    <?php endforeach;
        endif;?>
    <!--end of element of banner-->
    <input type="image" src="img/commons/back.svg" onclick="updateBanner(-1)" onkeypress="updateBanner(-1)" alt="notizia precedente" />
    <input type="image" src="img/commons/forward.svg" onclick="updateBanner(1)" onkeypress="updateBanner(-1)" alt="notizia successivo" />

   </section>
<aside>   
    <div>
        <!--insert div to add banner-->
        <div class="infoBanner">
            <div><img src="img/commons/gift.png" alt=""></div>
            <p>Spedizione gratuita sopra i 50 €</p>
        </div>
        <div class="infoBanner">
            <div><img src="img/commons/bankCards.svg" alt=""></div>
            <p>Pagamenti online o in contanti</p>
        </div>
        <div class="infoBanner">
            <div><img src="img/commons/onlineSupport.svg" alt=""></div>
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

<?php if(isset($templateParams["sections"]) && isset($templateParams["sectionTitle"])):
    foreach($templateParams["sections"] as $section):?>

        <?php if(isset($templateParams[$section]) && count($templateParams[$section]) > 0):?>
            <section class="comics <?php echo $section?>">
                <header><h2><?php echo $templateParams["sectionTitle"][$section]?></h2></header>
                <div>
                <!--here insert other article to be scrolled-->
                    <?php foreach($templateParams[$section] as $product):?>
                        <article class="fade">
                            <?php 
                                $countC = $dbh -> getAvaiableCopiesOfProd($product['ProductId']);
                                $favImg = isProdFavourite($dbh,$product['ProductId']) ? "./img/products/favourite.svg" : "./img/products/un-favourite.svg";
                            ?>

                            <div> <a href="article.php?id=<?php echo $product['ProductId']?>"><img src="<?php echo UPLOAD_DIR_PRODUCTS.$product["CoverImg"]?>" alt="copertina <?php echo $product["CoverImg"]?>"></a></div>
                            <header><a href="article.php?id=<?php echo $product['ProductId']?>"><h3><?php echo $product["Title"]?></h3></a></header>
                            <footer>
                                <div>
                                    <a href="utils/process-request.php?action=wish&id=<?php echo $product['ProductId']?>" class="wishButton"><img src="<?php echo $favImg?>" alt="Aggiungi ai preferiti"/></a>
                                </div>
                                <div>
                                    <a <?php if($countC <= 0){ echo 'class="disabled"';}?>href="utils/process-request.php?action=addtoCart&id=<?php echo $product['ProductId']?>" class="cartButton"><img src="./img/products/add.svg" alt="aggiungi al carrello"/></a>
                                </div>
                                <div><p><?php if(isset($product["DiscountedPrice"])){echo $product["DiscountedPrice"];}else{ echo $product["Price"];}?>€</p></div>
                            </footer>
                        </article>
        <?php endforeach;?>
                <!--end group of article-->
                    <input type="image" src="img/commons/sort-left.svg" onclick="updateComic('<?php echo $section?>',-1)" onkeypress="updateComic('<?php echo $section?>',-1)" alt="<?php echo $templateParams["sectionTitle"][$section]?> precedente" >
                    <input type="image" src="img/commons/sort-right.svg" onclick="updateComic('<?php echo $section?>',1)" onkeypress="updateComic('<?php echo $section?>',1)" alt="<?php echo $templateParams["sectionTitle"][$section]?> successivo" >
                </div>
            </section>
        <?php endif ?>
    <?php endforeach?>
<?php endif ?>

 <section class="review" id="reviews">
    <header>
        <h2>Cosa dicono di noi</h2>
    </header>
    <div>
    <!--
        here insert other article to be scrolled
    -->
    <?php if(isset($templateParams['reviews'])):
        foreach($templateParams['reviews'] as $review):?>
            <article class="fade">
                <header><img src="img/commons/circleUser.svg" alt=""><h3><?php echo $review['Username']?></h3></header>
                <div>
                    <?php for($i=0;$i<$review['Vote'];$i++){ ?>
                    <span class="fa fa-star checked"></span>
                    <?php } for($i=0;$i<5-$review['Vote'];$i++){ ?>
                        <span class="fa fa-star"></span>
                    <?php }?>
                </div>
                <p><?php echo $review['Description']?></p>
        </article>
    <?php endforeach; endif;?>
    <!--end group of article-->
    <input type="image" src="img/commons/back.svg" onclick="updateReview(-1)" onkeypress="updateReview(-1)" alt="recensione precedente" >
    <input type="image" src="img/commons/forward.svg" onclick="updateReview(1)" onkeypress="updateReview(1)" alt="recensione precedente" >
     </div>
</section>
<section id="partners">
    <header><h2>I Nostri partner</h2></header>
    <!-- here put all divs with partners to be shown in banner-->
    <div class="partner">
        <div>
            <?php if(isset($templateParams["publisher"])): ?>
                <?php foreach($templateParams["publisher"] as $publisher): 
                    $pubStringNoSpace = str_replace(" ","%20",$publisher['Name']);?>

                    <a href="catalog.php?publisher=<?php echo $pubStringNoSpace?>" title="Apri prodotti di <?php echo $publisher['Name']?>">
                        <img src="<?php echo UPLOAD_DIR_PUBLISHERS.$publisher['ImgLogo']?>" alt="<?php echo $publisher['Name']?>" class="fade">
                    </a>
                    
            <?php endforeach;endif?>
        </div> 
    </div>
    <!--end of element of banner-->
    <input type="image" src="img/commons/back.svg" onclick="updatePartner(-1)" onkeypress="updatePartner(-1)" alt="pagina editori indietro" >
    <input type="image" src="img/commons/forward.svg" onclick="updatePartner(1)" onkeypress="updatePartner(1)" alt="pagina editori avanti" >
</section>