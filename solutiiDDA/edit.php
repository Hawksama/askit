<?php

error_reporting(-1);
ini_set('display_errors', 'On');

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

$date = date("Y-m-d");

$pdo = Database::connect();
$user_id = $_POST['id'];

if ($_POST['token'] == 'observatii') {
    $sql = "SELECT id FROM observatii WHERE user_id=" . $user_id;
    $result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if ($result[0]['id'] <= 0 || !isset($result[0]['id'])) {
        $sql = "INSERT INTO observatii (user_id, content) VALUES (" . $user_id . ", '" . $_POST['value'] . "')";
        $pdo->query($sql);
        echo $_POST['value'];
    } else {
        $sql = "UPDATE observatii SET content='" . $_POST['value'] . "' WHERE user_id=" . $user_id;
        $pdo->query($sql);
        echo $_POST['value'];
    }
} elseif ($_POST['token'] == 'nr_solutii_luna_curenta') {
    if (is_numeric($_POST['value'])) {
        $sql = "SELECT id FROM solutions WHERE user_id=" . $user_id;
        $result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        if (!isset($result[0]['id'])) {
            $result[0]['id'] = 0;
        }
        if ($result[0]['id'] <= 0) {
            $sql = "INSERT INTO solutions (user_id, nr_solutii_luna_curenta, last_update) VALUES (" . $user_id . ", " . $_POST['value'] . ", '" . date("Y-m-d") . "')";
            $pdo->query($sql);
            echo $_POST['value'];
        } else {
            $sql = "UPDATE solutions SET nr_solutii_luna_curenta='" . $_POST['value'] . "', last_update='" . date("Y-m-d") . "' WHERE user_id=" . $user_id;
            $pdo->query($sql);
            echo $_POST['value'];
        }
    } else {
        echo "fail";
        exit();
    }
} elseif ($_POST['token'] == 'nr_solutii_luna_trecuta') {
    if (is_numeric($_POST['value'])) {
        $sql = "SELECT id FROM solutions WHERE user_id=" . $user_id;
        $result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        if (!isset($result[0]['id'])) {
            $result[0]['id'] = 0;
        }
        if ($result[0]['id'] <= 0) {
            $sql = "INSERT INTO solutions (user_id, nr_solutii_luna_trecuta, last_update) VALUES (" . $user_id . ", " . $_POST['value'] . ", '" . date("Y-m-d") . "')";
            $pdo->query($sql);
            echo $_POST['value'];
        } else {
            $sql = "UPDATE solutions SET nr_solutii_luna_trecuta='" . $_POST['value'] . "', last_update='" . date("Y-m-d") . "' WHERE user_id=" . $user_id;
            $pdo->query($sql);
            echo $_POST['value'];
        }
    } else {
        echo "fail";
        exit();
    }
}
Database::disconnect();
?>