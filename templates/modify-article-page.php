<?php 
    if (isset($templateParams["product"])) {
        $product = $templateParams["product"];
    }
?>
<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/home-icon.svg" alt="Home"></a></li><li><a href="login.php">Area personale</a></li><li>Modifica Articolo</li>
    </ul>
</div>
<section>
    <?php if ($product == null): ?>
        <header>
            <h2>Articolo non trovato</h2>
        </header>
    <?php else: ?>
        <header>
            <h2>
                <?php echo ($_GET['action'] === 'insert' ? 'Inserisci' : 'Modifica'); ?> 
                <?php echo ($templateParams['article'] === 'funko' ? 'Funko' : 'Fumetto'); ?>
            </h2>
        </header>
        <!-- Comic insertion form -->
        <form action="process-article.php" method="POST" enctype="multipart/form-data" id="comicForm">
            <ul>
                <?php if ($templateParams['article'] == 'comic'): ?>
                    <li>
                        <input type="hidden" name="articleToInsert" value="comic" />
                    </li>
                    <li>
                        <label for="title">Titolo</label>
                        <input type="text" placeholder="es. Two Moons 1" id="title" name="title" value="<?php echo $product['Title']; ?>" required />
                    </li>
                    <li>
                        <label for="author">Autore</label>
                        <input type="text" placeholder="es. John Arcudi" id="author" name="author" value="<?php echo $product['Author']; ?>" required />
                    </li>
                    <li>
                        <label for="language">Lingua</label>
                        <input type="text" placeholder="es. Italiano" id="language" name="language" value="<?php echo $product['Lang']; ?>" required />
                    </li>
                    <li>
                        <label for="publishDate">Data di pubblicazione</label>
                        <input type="date" id="publishDate" name="publishDate" value="<?php echo $product['PublishDate']; ?>" required />
                    </li>
                    <li>
                        <label for="isbn">ISBN</label>
                        <input type="text" placeholder="es. 9781534319110" id="isbn" name="isbn" value="<?php echo $product['ISBN']; ?>" required />
                    </li>
                    <li>
                        <label for="publisher">Editore</label>
                        <select id="publisher" name="publisher">
                            <!-- default option -->
                            <option value="">
                                <?php echo (empty($product['PublisherName']) 
                                    ? '-- Seleziona Editore --' 
                                    : $product['PublisherName']); ?>
                            </option>
                            <?php foreach ($templateParams["publishers"] as $publisher): 
                                if ($publisher['Name'] != $product['PublisherName']):
                            ?>
                                <option value="<?php echo $publisher["PublisherId"]; ?>"><?php echo $publisher["Name"]; ?></option>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </select>
                        <button id="addPublisherBtn" aria-label="Aggiungi Editore"></button>
                        <ul>
                            <li>
                                <label for="publisherName">Nome Editore</label>
                                <input type="text" id="publisherName" name="publisherName" placeholder="es. Panini Comics" />
                            </li>
                            <li>
                                <label for="publisherLogo">Logo Editore</label>
                                <input type="file" id="publisherLogo" name="publisherLogo" />
                            </li>
                        </ul>
                    </li>
                <?php elseif ($templateParams['article'] == 'funko') : ?>
                    <li>
                        <input type="hidden" name="articleToInsert" value="funko" />
                    </li>
                    <li>
                        <label for="funkoName">Nome</label>
                        <input type="text" placeholder="es. Joan Jett Pop" id="funkoName" name="funkoName" value="<?php echo $product['Name']; ?>" required />
                    </li>
                <?php endif; ?>
                <li>
                    <label for="category">Categoria</label>
                    <select id="category" name="category">
                        <!-- default option -->
                        <option value="">
                            <?php echo (empty($product['CategoryName']) 
                                ? '-- Seleziona Categoria --' 
                                : $product['CategoryName']); ?>
                        </option>
                        <?php 
                        foreach ($templateParams['categories'] as $category): 
                            if ($category['Name'] != $product['CategoryName']):
                        ?>
                                <option value="<?php echo $category['Name']; ?>"><?php echo $category['Name']; ?></option>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </select>
                    <button id="addCategoryBtn" aria-label="Aggiungi Categoria"></button>
                    <ul>
                        <li>
                            <label for="categoryName">Nome Categoria</label>
                            <input type="text" id="categoryName" name="categoryName" placeholder="es. Manga" />
                        </li>
                        <li>
                            <label for="categoryDesc">Descrizione Categoria</label>
                            <textarea id="categoryDesc" name="categoryDesc" placeholder="es. fumetti di piccolo formato originari del Giappone."></textarea>
                        </li>
                    </ul>
                </li>
                <li>
                    <label for="price">Prezzo</label>
                    <input type="text" placeholder="es. 15,00" id="price" name="price" value="<?php echo $product['Price']; ?>" required />
                </li>
                <li>
                    <label for="discountedPrice">Prezzo Scontato</label>
                    <input type="text" placeholder="es. 14,00" id="discountedPrice" name="discountedPrice" value="<?php echo $product['DiscountedPrice']; ?>" />
                </li>
                <li>
                    <label for="desc">Descrizione</label>
                    <textarea placeholder="Descrizione sintetica del prodotto" id="desc" name="desc" required ><?php echo $product['Description']; ?></textarea>
                </li>
                <li>
                    <?php if ($_GET['action'] == 'insert'): ?>
                        <label for="coverImg">Immagine Articolo</label>
                        <input type="file" name="coverImg" id="coverImg" required />
                    <?php else: ?>
                        <p>Immagine Articolo</p>
                        <img src="<?php echo UPLOAD_DIR_PRODUCTS . $product['CoverImg']; ?>" alt="Immagine articolo <?php echo $product['CoverImg']; ?>" id="coverImg" />
                    <?php endif; ?>
                </li>
                <li>
                    <?php  if ($_GET['action'] !== 'insert'): ?>
                        <input type="submit" value="ELIMINA" />
                    <?php endif; ?>
                    <input type="submit" value="<?php echo ($_GET['action'] === 'insert' ? 'INSERISCI' : 'MODIFICA'); ?>" />
                </li>
            </ul>
        </form>
    <?php endif; ?>
</section>