<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Signin</title>

        <!-- Bootstrap core CSS -->
        <link href="/wp-content/themes/helpguru-childtheme/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-md-4 col-lg-4 col-xs-offset-0 col-sm-offset-1 col-md-offset-4 col-lg-offset-4" style="margin-top:15%;">
                    <form class="form-signin" method="POST" action="check_login.php">
                        <h2 class="form-signin-heading">Please sign in</h2>
                        <label for="username" class="sr-only">Username</label>
                        <input type="username" id="username" name="username" class="form-control" placeholder="username" required autofocus>
                        <br />
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                        <br />
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        </div> <!-- /container -->
    </body>
</html>

