<?php
setcookie("user", "", time()-3600);
setcookie("username", "", time()-3600);
echo'<script type="text/javascript">window.location.replace("/solutiiDDA/login.php")</script>';
?>