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

    <title>Uguisudani - Footprint</title>

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/metismenu/dist/metisMenu.min.css">
    <link rel="stylesheet" href="css/sidemenu.css">
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 20px;
      }
      #dropdown {
        margin-left: 15px;
      }
      #btnGroupActions {
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
      <div class="panel panel-info" id="addFootprint" hidden>
        <div class="panel-body">
          <form role="form">
            <input type="hidden" id="recordId" value="">
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
                  <div class="col-lg-5">
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
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="col-lg-4 control-label"><p class="text-nowrap">Longitude</p></label>
                      <div class="col-lg-5">
                        <input type="text" class="form-control" id="longitude">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-5">
                    <div class="form-group">
                      <label class="col-lg-4 control-label"><p class="text-nowrap">Footprint Name</p></label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" id="footprintname">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label class="col-lg-5 control-label"><p class="text-nowrap">Country</p></label>
                      <div class="col-lg-7">
                        <input type="text" class="form-control" id="country">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="col-lg-4 control-label"><p class="text-nowrap">Province</p></label>
                      <div class="col-lg-7">
                        <div id="div-province-others" class="div-province">
                          <input type="text" class="form-control input-province">
                        </div>
                        <div id="div-province-china" class="div-province" style="display: none">
                          <select class="form-control input-province">
                            <option value="">-</option>
<?php
  $provinces = array(
    '北京市', '天津市', '河北省', '山西省', '内蒙古自治区', 
    '辽宁省', '吉林省', '黑龙江省', '上海市', '江苏省', 
    '浙江省', '安徽省', '福建省', '江西省', '山东省', 
    '河南省', '湖北省', '湖南省', '广东省', '广西壮族自治区', 
    '海南省', '重庆市', '四川省', '贵州省', '云南省', 
    '西藏自治区', '陕西省', '甘肃省', '青海省', '宁夏回族自治区', 
    '新疆维吾尔自治区', '香港特别行政区', '澳门特别行政区', '台湾省'
  );
  foreach ($provinces as $province) {
    echo <<< HTML
                            <option value="$province">$province</option>
HTML;
  }
?>
                          </select>
                        </div>
                        <div id="div-province-japan" class="div-province" style="display: none">
                          <select class="form-control input-province">
                            <option value="">-</option>
<?php
  $provinces = array(
    '北海道',
    '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
    '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
    '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県',
    '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県',
    '鳥取県', '島根県', '岡山県', '広島県', '山口県',
    '徳島県', '香川県', '愛媛県', '高知県',
    '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'
  );
  foreach ($provinces as $province) {
    echo <<< HTML
                            <option value="$province">$province</option>
HTML;
  }
?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-5">
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
                  <div id="btnGroupActions">
                    <button type="button" class="btn btn-success" id="btnSubmit">Add the footprint</button>
                    <button type="button" class="btn btn-default" id="btnCancel">Cancel</button>
                  </div>
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
          <div id="divAddFootprint" style="float: right;margin-top: -7px">
            <button type="button" class="btn btn-default" id="btnAddFootprint">Add new footprint</button>
          </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="tableData">
              <col width="80px" />
              <col width="200px" />
              <col width="200px" />
              <col width="250px" />
              <col width="100%" />
              <col width="70px" />
              <thead>
                <tr>
                  <th>Country</th>
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
    $country = $fp["country"];
    $province = $fp["province"];
    $description = $fp["description"];
    $time = $fp["time"];
    $id = $fp["id"];

    echo <<< HTML
                <tr>
                  <td>$country</td>
                  <td>$province</td>
                  <td>$footprint</td>
                  <td>$time</td>
                  <td>$description</td>
                  <td>
                    <button type="button" class="linkEdit btn btn-default btn-xs" aria-label="Edit" record-id="$id">
                      <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="linkDelete btn btn-default btn-xs" aria-label="Delete" record-id="$id">
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
    </div> <!-- /container -->


    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/metismenu"></script>
    <script src="js/sidemenu.js"></script>
    <script src="footprint.js"></script>
  </body>
</html>
