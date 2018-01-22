<?php
  include "check_login.php";

  global $session_username;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Footprint</title>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 20px;
      }
      .navbar {
        margin-bottom: 20px;
      }
      #dropdown {
        margin-left: 15px;
      }
      #btnSubmit {
        float: right;
        margin-right: 15px;
      }
      #tableData {
        table-layout: fixed;
        width: 1000px;
        margin: auto;
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

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Beautiful~</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Footprint</a></li>
              <li><a href="map.php">Map</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <div class="panel panel-info" id="addFootprint" hidden>
        <div class="panel-body">
          <form role="form">
            <input type="hidden" id="username" value="<?php echo $session_username;?>">
            <div class="form-horizontal">
              <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                  <div class="form-group">
                    <label class="col-lg-4 control-label"><p class="text-nowrap">Where have you traveled?</p></label>
                    <div class="col-lg-8">
                      <div class="input-group">
                        <input type="text" class="form-control" id="keyword" placeholder="E.g. 拉萨">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button" id="btnSearch">Search</button>
                        </span>
                      </div>
                      <ul class="dropdown-menu" id="dropdown">
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div id="detail" hidden>
                <hr>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="col-lg-4 control-label"><p class="text-nowrap">Full Name</p></label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" id="fullname" disabled>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="col-lg-5 control-label"><p class="text-nowrap">Latitude</p></label>
                      <div class="col-lg-7">
                        <input type="text" class="form-control" id="latitude">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="col-lg-5 control-label"><p class="text-nowrap">Longitude</p></label>
                      <div class="col-lg-7">
                        <input type="text" class="form-control" id="longitude">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="col-lg-4 control-label"><p class="text-nowrap">Footprint Name</p></label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" id="footprintname">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="form-group">
                      <label class="col-lg-3 control-label"><p class="text-nowrap">Province</p></label>
                      <div class="col-lg-7">
                        <select class="form-control" id="province">
                          <option value="北京市">北京市</option>
                          <option value="天津市">天津市</option>
                          <option value="河北省">河北省</option>
                          <option value="山西省">山西省</option>
                          <option value="内蒙古自治区">内蒙古自治区</option>
                          <option value="辽宁省">辽宁省</option>
                          <option value="吉林省">吉林省</option>
                          <option value="黑龙江省">黑龙江省</option>
                          <option value="上海市">上海市</option>
                          <option value="江苏省">江苏省</option>
                          <option value="浙江省">浙江省</option>
                          <option value="安徽省">安徽省</option>
                          <option value="福建省">福建省</option>
                          <option value="江西省">江西省</option>
                          <option value="山东省">山东省</option>
                          <option value="河南省">河南省</option>
                          <option value="湖北省">湖北省</option>
                          <option value="湖南省">湖南省</option>
                          <option value="广东省">广东省</option>
                          <option value="广西壮族自治区">广西壮族自治区</option>
                          <option value="海南省">海南省</option>
                          <option value="重庆市">重庆市</option>
                          <option value="四川省">四川省</option>
                          <option value="贵州省">贵州省</option>
                          <option value="云南省">云南省</option>
                          <option value="西藏自治区">西藏自治区</option>
                          <option value="陕西省">陕西省</option>
                          <option value="甘肃省">甘肃省</option>
                          <option value="青海省">青海省</option>
                          <option value="宁夏回族自治区">宁夏回族自治区</option>
                          <option value="新疆维吾尔自治区">新疆维吾尔自治区</option>
                          <option value="香港特别行政区">香港特别行政区</option>
                          <option value="澳门特别行政区">澳门特别行政区</option>
                          <option value="台湾省">台湾省</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="col-lg-4 control-label"><p class="text-nowrap">Time</p></label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" id="time" placeholder="E.g. 1969.7.20, any format is ok.">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="form-group">
                      <label class="col-lg-3 control-label"><p class="text-nowrap">Description</p></label>
                      <div class="col-lg-9">
                        <input type="text" class="form-control" id="description" placeholder="Anything you like...">
                      </div>
                    </div>
                  </div>
                </div> 
                <div class="row">
                  <button type="button" class="btn btn-success" id="btnSubmit">Add the footprint</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="panel panel-default">
        <div class="panel-heading">
          My footprint
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="tableData">
              <col width="200px" />
              <col width="200px" />
              <col width="250px" />
              <col width="100%" />
              <col width="50px" />
              <thead>
                <tr>
                  <th>Province</th>
                  <th>Footprint</th>
                  <th>Time</th>
                  <th>Description</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
<?php
  include "api/footprint/function.php";

  $data = getFootprints($session_username);
  foreach ($data as $fp) {
    $footprint = $fp["footprint"];
    $province = $fp["province"];
    $description = $fp["description"];
    $time = $fp["time"];
    $id = $fp["id"];

    echo <<< HTML
                <tr>
                  <td>$province</td>
                  <td>$footprint</td>
                  <td>$time</td>
                  <td>$description</td>
                  <td>
                    <button type="button" class="linkDelete btn btn-default btn-xs" aria-label="Delete" id="$id">
                      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                  </td>
                </tr>
HTML;
  }
?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div id="divAddFootprint">
        <button type="button" class="btn btn-success" id="btnAddFootprint">Add new footprint</button>
      </div>

    </div> <!-- /container -->


    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="footprint.js"></script>
  </body>
</html>
