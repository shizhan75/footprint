<?php
  if (isset($_POST["action"]) && $_POST["action"] === "login" &&
      isset($_POST["username"]) && $_POST["username"] !== '') {
    session_start();
    $_SESSION['state'] = 'login';
    $_SESSION['username'] = $_POST['username'];

    setcookie("username", $_POST['username'], time()+3600*24*365);

    header("Location: index.php");
    exit; 
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Signin</title>

    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style type="text/css">
      body {
        background-image: url(images/background.jpg);
        background-size: cover;
      }
      .container {
        margin-top: 150px;
        font-family: 'Source Sans Light', 'Apple LiSung Light', 'STHeiti Light', 'SimSun', sans-serif;
        font-size: 16px;
      }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <div class="panel panel-default">
            <div class="panel-body">
              <form role="form" action="login.php" method="post">
                <input type="hidden" name="action" value="login">
                <div class="form-horizontal">
                  <div class="form-group">
                    <label class="col-lg-6 control-label"><p class="text-nowrap">Hey, choose a beautiful name for yourself~</p></label>
                    <div class="col-lg-4 col-xs-9">
                      <input type="text" name="username" id="username" class="form-control" placeholder="User name" required autofocus>
                    </div>
                    <button class="col-lg-1 col-xs-2 btn btn-success" type="submit">OK</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- /container -->

  </body>
</html>
