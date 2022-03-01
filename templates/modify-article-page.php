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
        <!-- TODO nel caso di modifica metti modifica !-->
        <h2>Inserisci articolo</h2>
        <ul>
            <li id=""><button type="button">Fumetto</button></li><li id=""><button type="button">Funko</button></li>
        </ul>
    </header>
    <!-- Comic insertion form -->
    <form action="process-article.php" method="POST" enctype="multipart/form-data" id="comicForm">
        <ul>
            <li>
                <label for="comicTitle">Titolo</label>
                <input type="text" placeholder="es. Two Moons 1" id="comicTitle" name="title" />
            </li>
            <li>
                <label for="comicAuthor">Autore</label>
                <input type="text" placeholder="es. John Arcudi" id="comicAuthor" name="author" />
            </li>
            <li>
                <label for="comicLanguage">Lingua</label>
                <input type="text" placeholder="es. Italiano" id="comicLanguage" name="language" />
            </li>
            <li>
                <label for="comicPublishDate">Data di pubblicazione</label>
                <input type="date" id="publishDate" name="comicPublishDate" />
            </li>
            <li>
                <label for="isbn">ISBN</label>
                <input type="text" placeholder="es. 9781534319110" id="isbn" name="isbn" />
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
                <input type="text" placeholder="es. 15,00" id="price" name="price" />
            </li>
            <li>
                <label for="discountedPrice">Prezzo Scontato</label>
                <input type="text" placeholder="es. 14,00" id="discountedPrice" name="discountedPrice" />
            </li>
            <li>
                <label for="desc">Descrizione</label>
                <textarea placeholder="Descrizione sintetica del prodotto" id="desc" name="desc" ></textarea>
            </li>
            <li>
                <label for="coverImg">Immagine Articolo</label>
                <input type="file" name="coverImg" id="coverImg" />
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
    <hr>
    <!-- Funko insertion form -->
    <form action="process-article.php" method="POST" enctype="multipart/form-data" id="funkoForm">
        <ul>
            <li>
                <label for="funkoName">Nome</label>
                <input type="text" placeholder="es. Joan Jett Pop" id="funkoName" name="funkoName" />
            </li>
            <li>
                <label for="category">Categoria</label>
                <!-- TODO: consider using a datalist -->
                <select id="category" name="category">
                    <option selected value=""> -- seleziona un'opzione -- </option>
                    <?php foreach ($templateParams["categories"] as $category): ?>
                        <option value="<?php echo $category['Name']; ?>"><?php echo $category['Name']; ?></option>
                    <?php endforeach; ?>
                </select>
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
                <input type="text" placeholder="es. 15,00" id="price" name="price" />
            </li>
            <li>
                <label for="discountedPrice">Prezzo Scontato</label>
                <input type="text" placeholder="es. 14,00" id="discountedPrice" name="discountedPrice" />
            </li>
            <li>
                <label for="desc">Descrizione</label>
                <textarea placeholder="Descrizione sintetica del prodotto" id="desc" name="desc" ></textarea>
            </li>
            <li>
                <label for="coverImg">Immagine Articolo</label>
                <input type="file" name="coverImg" id="coverImg" />
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