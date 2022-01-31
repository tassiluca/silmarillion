
 <section>
    <!-- here put all images to be shown in banner-->
    <?php if(isset($templateParams["newsBanner"])):
            foreach($templateParams["newsBanner"] as $banner):
        ?>
        <img src="img/banner/<?php echo $banner["Img"] ?>" class="banner fade"  alt="<?php echo $banner["Description"]?>"/>
    <?php endforeach;
        endif;?>
    <!--end of element of banner-->
    <input type="image" src="img/Back.svg" onclick="updateBanner(-1)" onkeypress="updateBanner(-1)" alt="notizia precedente" />
    <input type="image" src="img/Forward.svg" onclick="updateBanner(1)" onkeypress="updateBanner(-1)" alt="notizia successivo" />

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

<?php if(isset($templateParams["sections"]) && isset($templateParams["sectionTitle"])):
    foreach($templateParams["sections"] as $section):?>

        <?php if(isset($templateParams[$section]) && count($templateParams[$section]) > 0):?>
            <section class="comics <?php echo $section?>">
                <header><h2><?php echo $templateParams["sectionTitle"][$section]?></h2></header>
                <div>
                <!--here insert other article to be scrolled-->
                    <?php foreach($templateParams[$section] as $product):?>
                        <article class="fade">
                            <div><img src="img/comics/<?php echo $product["CoverImg"]?>" alt="copertina <?php echo $product["CoverImg"]?>"></div>
                            <header><?php echo $product["Title"]?></header>
                            <div><a href="#" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a><a href="#" ><img src="./img/add.svg" alt="aggiungi al carrello"/></a><div><p><?php if(isset($product["DiscountedPrice"])){echo $product["DscountPrice"];}else{ echo $product["Price"];}?>€</p></div>
                            </div>
                        </article>
        <?php endforeach;?>
                <!--end group of article-->
                    <input type="image" src="img/sort-left.svg" onclick="updateComic('<?php echo $section?>',-1)" onkeypress="updateComic('<?php echo $section?>',-1)" at="<?php echo $templateParams["sectionTitle"][$section]?> precedente" >
                    <input type="image" src="img/sort-right.svg" onclick="updateComic('<?php echo $section?>',1)" onkeypress="updateComic('<?php echo $section?>',1)" at="<?php echo $templateParams["sectionTitle"][$section]?> successivo" >
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
    <input type="image" src="img/Back.svg" onclick="updateComic('review',-1)" onkeypress="updateComic('review',-1)" alt="recensione precedente" >
    <input type="image" src="img/Forward.svg" onclick="updateComic('review',1)" onkeypress="updateComic('review',1)" alt="recensione precedente" >
     </div>
</section>
<section id="partners">
    <header><h2>I Nostri partner</h2></header>
    <!-- here put all divs with partners to be shown in banner-->
    <div class="partner">
        <div>
            <?php if(isset($templateParams["partners"])):?>
                <?php foreach($templateParams["partners"] as $partner):?>
                <img src="img/partners/<?php echo $partner['ImgLogo']?>" alt="<?php echo $partner['Name']?>" class="fade">
            <?php endforeach;endif?>
        </div> 
    </div>
    <!--end of element of banner-->
    <input type="image" src="img/Back.svg" onclick="updatePartner(-1)" onkeypress="updatePartner(-1)" alt="partner indietro" >
    <input type="image" src="img/Forward.svg" onclick="updatePartner(1)" onkeypress="updatePartner(1)" alt="partner avanti" >
</section>