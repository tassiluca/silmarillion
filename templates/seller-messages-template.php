<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="./seller-area.php">Area personale</a></li>
        <li><a href="#">Messaggi</a></li>
    </ul>
</div>

<section>
    <button class="inbox">Posta</button>

</section>


<section class="inboxMail">

    <table>
        <caption>Posta in arrivo</caption>

        <?php foreach($templateParams['message'] as $message):
            ?>

            <tr>
                <th><a href="../user-messages.php?deleteMessage=<?php echo $message['MessageId']?>" ><img src="./img/user-page/Delete.svg" class="icon" alt=""></a></th>
                <th><h4><?php echo $message['Title']; ?></h4>
                    <p><?php echo $message['Description']; ?></p></th>
            </tr>
        <?php endforeach; ?>
    </table>
</section>










