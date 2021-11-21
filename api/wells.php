<?php
// Endpoint format:
// https://vprsrv.org/api/wells.php/{MODULE_NAME}/{METHOD_NAME}?{VARIABLE_NAME}={VARIABLE_VALUE}

require $_SERVER['DOCUMENT_ROOT'] . "/config/wellstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
// var_dump($uri);
if ((isset($uri[3]) && $uri[3] == 'wells'))
{
   // Possible endpoint examples:
  // https://vprsrv.org/api/wells.php/wells/wells
  // https://vprsrv.org/api/wells.php/wells/latest
  // https://vprsrv.org/api/wells.php/wells/shutin
  require PROJECT_ROOT_PATH . "/api/controller/WellsController.php";

  $objFeedController = new WellsController();
  $strMethodName = 'fetch' . ucfirst($uri[4]);
  error_log(print_r($strMethodName,true));
  $objFeedController->{$strMethodName}();
}
elseif ((isset($uri[2]) && $uri[2] == 'notes') || !isset($uri[5]))
{
  // Possible endpoint examples:
  // https://vprsrv.org/api/wells.php/notes/prod
  // https://vprsrv.org/api/wells.php/notes/ddr
  require PROJECT_ROOT_PATH . "/api/controller/NotesController.php";
  $objFeedController = new NotesController();
  $strMethodName = 'put' . ucfirst($uri[3]);
  error_log(print_r($strMethodName,true));
  $objFeedController->{$strMethodName}();
}
elseif ((isset($uri[3]) && $uri[3] == 'production') || !isset($uri[5]))
{
  // Possible endpoint examples:
  // https://vprsrv.org/api/wells.php/production/prod?api=00-000-00000
  // https://vprsrv.org/api/wells.php/production/ddr?api=00-000-00000
  // https://vprsrv.org/api/wells.php/production/dsr?api=00-000-00000
  // https://vprsrv.org/api/wells.php/production/excel?api=00-000-00000
  // https://vprsrv.org/api/wells.php/production/vitals?api=00-000-00000
  // https://vprsrv.org/api/wells.php/production/old?api=00-000-00000&sheet=sa
  // https://vprsrv.org/api/wells.php/production/old?api=00-000-00000&sheet=db
  // https://vprsrv.org/api/wells.php/production/old?api=00-000-00000&sheet=sb
  // https://vprsrv.org/api/wells.php/production/info?api=00-000-00000

  require PROJECT_ROOT_PATH . "/api/controller/ProductionController.php";
  // $qs = parse_str($_SERVER['QUERY_STRING'], $query);
  // isset($_REQUEST['api']) ? $api = $_REQUEST['api'] : $api = null;
  
  $objFeedController = new ProductionController();
  // $params = $objFeedController->getQueryStringParams();
  // error_log(print_r($api,true));
  $strMethodName = 'fetch' . ucfirst($uri[4]);
  // if($strMethodName === 'fetchOld'){
    // $objFeedController->{$strMethodName}($api, $_REQUEST['sheet']);
  // }else
  // {$objFeedController->{$strMethodName}();}
  // $strMethodName = 'listAction';
  // error_log(print_r($strMethodName,true));
  // echo '<pre>'.print_r($_SERVER, TRUE).'</pre>';
  // echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  $objFeedController->{$strMethodName}();
  // echo $qs;
  // echo '<pre>'.print_r($_SERVER, TRUE).'</pre>';
}
// require PROJECT_ROOT_PATH . "/api/controller/ProductionController.php";
// $objFeedController = new ProductionController();
// $strMethodName = 'fetch' . ucfirst($uri[4]);
// $objFeedController->{$strMethodName}();
// else (!isset($uri[2])) {
//   header("HTTP/1.1 404 Not Found");
//   exit();
// }

?>