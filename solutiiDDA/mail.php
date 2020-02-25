<?php

class Database {

        private static $dbName = 'c0askit';
        private static $dbHost = 'localhost';
        private static $dbUsername = 'c0askit_usr';
        private static $dbUserPassword = '7bd!XYHkXjMs';
        private static $cont = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function connect() {
        // One connection through whole application
        if (null == self::$cont) {
            try {
                self::$cont = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect() {
        self::$cont = null;
    }

}

$luna = array(
    1 => 'Ianuarie',
    2 => 'Februarie',
    3 => 'Martie',
    4 => 'Aprilie',
    5 => 'Mai',
    6 => 'Iunie',
    7 => 'Iulie',
    8 => 'August',
    9 => 'Septembrie',
    10 => 'Octombrie',
    11 => 'Noiembrie',
    12 => 'Decembrie'
);
$luna_curenta = $luna[intval(date('m'))];
$luna_trecuta = $luna[intval(date('m')) - 1];

$pdo = Database::connect();
$user_id = $_POST['id'];
$mailtext = $_POST['mailtext'];

$sql = "SELECT user_email FROM wp_users WHERE id=$user_id";
$email_address = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$to = $email_address[0]['user_email'];
$subject = 'Solutii Askit';
$message = $mailtext;
$headers = 'From: solutii@askit.ro' . "\r\n" .
        'Reply-To: solutii@askit.ro' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
Database::disconnect();
echo 'success';
