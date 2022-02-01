 <!-- Breadcrumb pagination -->
 <div>
                <ul>
                    <li><a href="index.html"><img src="./img/home-icon.svg" alt="Home"></a></li><li>Catalogo</li>
                </ul>
            </div>
            <h2>Catalogo</h2>
            <p>Benvenuto nel nostro catalogo, contenenti le più svariate tipologie di fumetti, funko e molto altro...</p>
            <aside>
                <button>Categoria</button>
                <ul>
                    <?php if(isset($templateParams["categories"])):
                    foreach($templateParams["categories"] as $category):
                        $idcategory= getIdFromName($category["Name"]);?>
                        <li><input type="checkbox" id="<?php echo $idcategory?>" name="<?php echo $category["Name"]?>" />
                        <label for="<?php echo $idcategory?>"><?php echo $category["Name"]?></label></li><?php endforeach;endif;?>  
                </ul>
                <button>Prezzo</button>
                <ul>
                    <li>
                        <input type="checkbox" id="cheap" name="0€ - 100€" />
                        <label for="cheap">0€ - 99,99€</label>
                    </li>
                    <li>
                        <input type="checkbox" id="medium" name="100€ - 199,99€" />
                        <label for="medium">100€ - 199,99€</label>
                    </li>   
                    <li>
                        <input type="checkbox" id="expensive" name="Più di 200,00€" />
                        <label for="expensive">Più di 200,00€</label>
                    </li>
                </ul>
                <button>Disponibilità</button>
                <ul>
                    <li>
                        <input type="checkbox" id="available" name="Disponibile" />
                        <label for="available">Disponibile</label>
                    </li>
                    <li>
                        <input type="checkbox" id="notavailable" name="Non Disponibile" />
                        <label for="notavailable">Non Disponibile</label>
                    </li>   
                </ul>
                <button>Editore</button>
                <ul>
                    <?php if(isset($templateParams["publisher"])):
                    foreach($templateParams["publisher"] as $publisher):
                        $idname= getIdFromName($publisher["Name"]);?>
                        <li><input type="checkbox" id="<?php echo $idname?>" name="<?php echo $publisher["Name"]?>" />
                        <label for="<?php echo $idname?>"><?php echo $publisher["Name"]?></label></li><?php endforeach;endif;?>
                </ul>
                <button>Lingua</button>
                <ul>
                    <?php if(isset($templateParams["languages"])):
                    foreach($templateParams["languages"] as $lang): 
                        $idlang= getIdFromName($lang['Lang']); ?>
                        <li>
                        <input type="checkbox" id="<?php echo $idlang?>" name="<?php echo $lang['Lang']?>" />
                        <label for="<?php echo $idlang?>"><?php echo $lang['Lang']?></label>
                    </li> 
                    <?php endforeach;endif;?>
                </ul>
                <button>Autore</button>
                <ul>
                    <?php if(isset($templateParams["authors"])):
                    foreach($templateParams["authors"] as $lang): 
                        $idlang= getIdFromName($lang['Author']); ?>
                        <li>
                        <input type="checkbox" id="<?php echo $idlang?>" name="<?php echo $lang['Author']?>" />
                        <label for="<?php echo $idlang?>"><?php echo $lang['Author']?></label>
                    </li> 
                    <?php endforeach;endif;?>
                </ul>
            </aside><section>
                <?php if(isset($templateParams["products"])): foreach($templateParams["products"] as $product): ?>
                    <?php $countC = $dbh -> getAvaiableCopiesOfProd($product['ProductId'])?>
                <article>
                    <div>
                        <img src="img/comics/<?php echo $product['CoverImg']?>" alt="<?php echo $product['CoverImg']?>">
                    </div>
                    <header><a href="article.php?id=<?php echo $product["ProductId"]?>"><h3><?php echo $product["Title"]?></h3></a></header>
                    <footer>
                        <div>
                            <a <?php if((isset($templateParams["logged"])&& !$templateParams["logged"]) ||$countC <= 0){ echo 'class="disabled"';}?> href="gestisci-richieste.php?action=wish&id=<?php echo $product['ProductId']?>" ><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a>
                        </div>
                        <div>
                            <a <?php if((isset($templateParams["logged"])&& !$templateParams["logged"]) ||$countC <= 0){ echo 'class="disabled"';}?>href="gestisci-richieste.php?action=addtoCart&id=<?php echo $product['ProductId']?>"><img src="./img/add.svg" alt="Aggiungi al carrello"/></a>
                        </div>
                        <div>
                            <p><?php if(isset($product["DiscountedPrice"])){echo $product["DiscountedPrice"];}else{ echo $product["Price"];}?></p>
                        </div>
                    </footer>
                </article>
                    <?php endforeach; endif;?>
                <footer>
                    <!-- Pagination -->
                    <ul>
                        <li><a href="">&laquo;</a></li>
                        <li><a href="">1</a></li>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="">&raquo;</a></li>
                    </ul>
                </footer>
            </section>