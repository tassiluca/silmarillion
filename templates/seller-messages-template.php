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
    <h3></h3>
    <table>
        <caption>Posta in arrivo</caption>

        <?php foreach($templateParams['message'] as $message):
            ?>
            <tr>
                <th><a href="../user-messages.php?deleteMessage=<?php echo $message['MessageId']?>" ><img src="./img/user-page/Delete.svg" class="icon" alt="delete"></a></th>
                <th><p class="text"><?php echo $message['Title']; ?></p>
                    <p><?php echo $message['Description']; ?></p></th>
            </tr>
        <?php endforeach; ?>
    </table>
</section>










