<?php 
    require_once 'bootstrap.php';
    if (isset($_POST['lang'])) {
        $da= $_POST['lang'];
      echo "ricevuto". json_encode($da);//json_encode(login($userData, $_POST['customerPwd']));
    }

?>