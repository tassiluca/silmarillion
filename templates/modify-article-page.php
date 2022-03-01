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
    <header>
        <!-- TODO nel caso di modifica metti modifica, in caso di fumetto metti fumetto, altrimenti funko !-->
        <h2>Inserisci articolo</h2>
    </header>
    <!-- Comic insertion form -->
    <form action="process-article.php?" method="POST" enctype="multipart/form-data" id="comicForm">
        <ul>
            <?php 
                if (isset($templateParams['article']) && $templateParams['article'] == 'comic'):
            ?>
                <li>
                    <input type="hidden" name="articleToInsert" value="comic" />
                </li>
                <li>
                    <label for="title">Titolo</label>
                    <input type="text" placeholder="es. Two Moons 1" id="title" name="title" required />
                </li>
                <li>
                    <label for="author">Autore</label>
                    <input type="text" placeholder="es. John Arcudi" id="author" name="author" required />
                </li>
                <li>
                    <label for="language">Lingua</label>
                    <input type="text" placeholder="es. Italiano" id="language" name="language" required />
                </li>
                <li>
                    <label for="publishDate">Data di pubblicazione</label>
                    <input type="date" id="publishDate" name="publishDate" required />
                </li>
                <li>
                    <label for="isbn">ISBN</label>
                    <input type="text" placeholder="es. 9781534319110" id="isbn" name="isbn" required />
                </li>
                <li>
                    <label for="publisher">Editore</label>
                    <input list="publishers" name="publisher" id="publisher" />
                    <datalist id="publishers">
                        <?php foreach ($templateParams["publishers"] as $publisher): ?>
                            <option value="<?php echo $publisher["PublisherId"]; ?>"><?php echo $publisher["Name"]; ?></option>
                        <?php endforeach; ?>
                    </datalist>
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
            <?php
                elseif (isset($templateParams['article']) && $templateParams['article'] == 'funko') :
            ?>
                <li>
                    <input type="hidden" name="articleToInsert" value="funko" />
                </li>
                <li>
                    <label for="funkoName">Nome</label>
                    <input type="text" placeholder="es. Joan Jett Pop" id="funkoName" name="funkoName" required />
                </li>
            <?php
                endif;
            ?>
            <li>
                <label for="category">Categoria</label>
                <input list="categories" name="category" id="category" />
                <datalist id="categories">
                    <?php foreach ($templateParams["categories"] as $category): ?>
                        <option value="<?php echo $category['Name']; ?>"><?php echo $category['Name']; ?></option>
                    <?php endforeach; ?>
                </datalist>
                <button id="addCategoryBtn" aria-label="Aggiungi Categoria"></button>
                <ul>
                    <li>
                        <label for="categoryName">Nome Categoria</label>
                        <input type="text" id="categoryName" name="categoryName" placeholder="es. Manga" />
                    </li>
                    <li>
                        <label for="categoryDesc">Descrizione Categoria</label>
                        <textarea id="categoryDesc" name="categoryDesc" placeholder="Descrizione della categoria: es. fumetti di piccolo formato originari del Giappone."></textarea>
                    </li>
                </ul>
            </li>
            <li>
                <label for="price">Prezzo</label>
                <input type="text" placeholder="es. 15,00" id="price" name="price" required />
            </li>
            <li>
                <label for="discountedPrice">Prezzo Scontato</label>
                <input type="text" placeholder="es. 14,00" id="discountedPrice" name="discountedPrice" />
            </li>
            <li>
                <label for="desc">Descrizione</label>
                <textarea placeholder="Descrizione sintetica del prodotto" id="desc" name="desc" required ></textarea>
            </li>
            <li>
                <label for="coverImg">Immagine Articolo</label>
                <input type="file" name="coverImg" id="coverImg" required />
                <!-- TODO <img src="" alt=""> -->
            </li>
            <?php if(isset($templateParams["formMsg"])):?>
                <li>
                    <p><?php echo $templateParams["formMsg"]; ?></p>
                </li>
            <?php endif; ?>
            <li>
                <!-- TODO nel caso di modifica metti modifica !-->
                <input type="submit" value="INSERISCI" />
            </li>
        </ul>
    </form>
</section>