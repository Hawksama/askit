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

$pdo = Database::connect();
$user_id = $_POST['id'];

if (isset($user_id) && is_numeric($user_id)) {
    $sql = "UPDATE wp_users SET user_status=0 WHERE id=" . $user_id;
    if ($pdo->query($sql)) {
        echo 'success';
    } else {
        echo 'fail';
    }
}
Database::disconnect();
?>