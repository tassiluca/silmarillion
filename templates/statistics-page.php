<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li><li><a href="login.php">Area personale</a></li><li>Statistiche</li>
    </ul>
</div>
<div>
<header><h3>Statistiche</h3></header>
<aside>
    <div>
        <div>
            <p>Periodo: </p>
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
        </div>
        <div>
            <label for="year">Scegli Anno: </label>
            <select name="year" id="year_selector">
                <?php if(isset($templateParams["ordersYears"])):
                    foreach($templateParams["ordersYears"] as $year): ?>
                <option value="<?php echo $year['Year']?>"><?php echo $year['Year']?></option>
                <?php endforeach; endif;?>
            </select>
        </div>
        
    </div>
</aside>
<section>
    <article>
        <header><H4>Incassi</H4></header>
        <p>
            <canvas id="cashChart" ></canvas>
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
</div>