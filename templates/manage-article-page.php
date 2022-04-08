<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li><li><a href="login.php">Area personale</a></li><li>Gestisci articoli</li>
    </ul>
</div>
<section>
    <header>
        <h2>Gestisci Articoli</h2>
        <div>
            <a href="modify-article.php?action=insert&article=comic">Aggiungi fumetto</a>
            <a href="modify-article.php?action=insert&article=funko">Aggiungi funko</a>
        </div>
        <input type="text" name="search" id="search-articles" placeholder="Cerca..." aria-label="Cerca prodotto" />
    </header>
    <ul id="products">
        <!-- here are inserted all products -->       
    </ul>
    <footer>
        <ul id="pagination">
            <!-- here are inserted the pagination list items -->
        </ul>
    </footer>
</section>