<?php
if (!isset($_COOKIE['user']) || $_COOKIE['user'] !== 'logged') {
    echo "<p style='color:red'>Access Denied!</p>";
    echo "<p style='color:red'>Please login <a href='login.php'>here</a></p>";
    exit();
}
include_once('/database.php');
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
    </style>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <h3>Inactive Users</h3>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="margin-top:1%;">
                    <p style="color:#601f1f">Welcome,<b> <?php echo ucfirst($_COOKIE['username']); ?></b></p>
                    <a href="https://askit.ro/solutiiDDA" style="color:#333; font-size:17px;">See Active Users</a>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                    <a href="https://askit.ro/solutiiDDA/logout.php" style="color:#b30000;"><i class="fa fa-power-off" aria-hidden="true" style="color:#b30000"></i> Logout</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-2">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'database.php';
                            $pdo = Database::connect();
                            $sql = "SELECT wp_users.id, wp_users.display_name "
                                    . "FROM wp_users "
                                    . "WHERE wp_users.user_status!=0 "
                                    . "ORDER BY wp_users.display_name";
                            foreach ($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC) as $row) {
                                $users[] = $row;
                            }

                            foreach ($users as $user) {
                                echo '<tr class="users_list">';
                                echo '<td class="names">' . $user['display_name'] . '</td>';
                                echo '<td><button type="button" class="remove" data-id="' . $user['id'] . '" style="background:transparent; border:none;">'
                                . '<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>'
                                . '</button></td>';
                                echo '</tr>';
                            }

                            Database::disconnect();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- /container -->
        <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Activate User</h4>
                    </div>
                    <div class="modal-body">
                        <form id="revealForm" class="form-horizontal labelcustomize" method="POST" action="">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12 control-label">Are you sure you want to activate this user?</label>
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
        <script src="/wp-content/themes/helpguru-childtheme/js/bootstrap.min.js"></script>
    </body>

    <script type="text/javascript">
        $(".remove").on("click", function () {
            var id = $(this).data("id");
            $('#removeModal').modal('show');
            $("#removeBtn").on("click", function () {
                $.ajax({
                    url: "activate.php",
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
                })
            })
        })
    </script>
</html>
