<div>
    <ul>
        <li><a href="index.php"><img src="./img/home-icon.svg" alt="Home"></a></li><li>Statistiche</li>
    </ul>
</div>
<aside>
    <form action="">
        <p>Visualizzazione per: </p>
        <ul>
            <li>
                <input type="radio" id="day" name="data_view" value="0">
                <label for="day">Giorni</label>
            </li>
            <li>
                <input type="radio" id="month" name="data_view" value="1" checked>
                <label for="month">Mesi</label>
            </li>
            <li>
                <input type="radio" id="year" name="data_view" value="2">
                <label for="year">Anni</label>
            </li>
        </ul>
        <label for="year">Scegli Anno: </label>
        <select name="year" id="year_selector">
            <?php if(isset($templateParams["ordersYears"])):
                foreach($templateParams["ordersYears"] as $year): ?>
            <option value="<?php echo $year['Year']?>"><?php echo $year['Year']?></option>
            <?php endforeach; endif;?>
        </select>
    </form>
</aside>
<section>
    <header><h3>Statistiche</h3></header>
    <article>
        <header><H4>Incassi</H4></header>
        <p>
            <canvas id="collChart" ></canvas>
        </p>
    </article>
    <article>
        <header><H4>Ordini</H4></header>
        <p>
            <canvas id="orderChart"></canvas>
        </p>
    </article>
    <footer></footer>
</section>