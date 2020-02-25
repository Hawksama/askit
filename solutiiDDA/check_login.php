<?php

$login = array('admin' => '3f76d6c6b8aa132e8306a0b4e6e02916',
    'hr' => 'ef872ac2466ca845aa0547e02554d7e1',
    'conta' => '3b3efb7345b89c6bbef71e5b6f257426',
    'test' => '1bea4e64fdce536ca98453af51a9ce08');
if ($login[$_POST['username']] == md5($_POST['password'])) {
    $date_of_expiry = time() + 60*60;
    setcookie("user", "logged", $date_of_expiry);
    setcookie("username", $_POST['username'], $date_of_expiry);
    echo'<script type="text/javascript">window.location.replace("/solutiiDDA/index.php")</script>';
} else {
    echo'<script type="text/javascript">window.location.replace("/solutiiDDA/login.php")</script>';
}?>