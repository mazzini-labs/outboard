<?php

require_once("lib/OutboardDatabase.php");
require_once("lib/OutboardAuth.php");

//include_once("include/char_widths.php");
include_once("include/common.php");

// Create main objects;
$auth = new OutboardAuth();
$ob   = new OutboardDatabase();

// Set some simple variables used later in the page
$baseurl             = $_SERVER['PHP_SELF'];
$current             = getdate();

// Get the session (if there is one)
$session = $auth->getSessionCookie();

if ($ob->getConfig('authtype') == "internal") {
  $BasicAuthInUse = false;
  if ($username = getPostValue('username') and $password = getPostValue('password')) {
    $session = $ob->checkPassword($username,$password);
  }
} else {
  $BasicAuthInUse = true;
  if (! $session) {
    $username = $auth->checkBasic();
    if ($ob->isBoardMember($username)) {
      $ob->setOperatingUser($username);
      $session = $ob->setSession();
    }
  }
}

$auth->setSessionCookie($session,$cookie_time_seconds);
$username = $ob->getSession($session);
########## This crashes the browser!!!! Do not implement until cause is figured out. 
/* // Show the login screen if the user is not authenticated
if (! $username) {
  $auth->setSessionCookie("",$cookie_time_seconds);
  header("Location: outboard.php"); 
}

// if 'logout' is set, run the logout functions and go back
// to the login screen.
if (getGetValue('logout')) {
  $ob->setSession("");
  $auth->setSessionCookie("",$cookie_time_seconds);
  header("Location: outboard.php"); 
} */
##########
include 'include/wsbFunctions.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = connect_db();


?>
<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>WSB</title>
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css?v1.0.0.3">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-select-fake.css?v1.0.0.0">
    <?php include 'include/dependencies.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/trumbowyg.min.js" integrity="sha512-sffB9/tXFFTwradcJHhojkhmrCj0hWeaz8M05Aaap5/vlYBfLx5Y7woKi6y0NrqVNgben6OIANTGGlojPTQGEw==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/cleanpaste/trumbowyg.cleanpaste.min.js" integrity="sha512-y7o2DGiZAj5/HOX10rSG1zuIq86mFfnqbus0AASAG1oU2WaF2OGwmkt2XsgJ3oYxJ69luyG7iKlQQ6wlZeV3KQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/colors/trumbowyg.colors.min.js" integrity="sha512-iT7g30i1//3OBZsfoc5XmlULnKQKyxir582Z9fIFWI6+ohfrTdns118QYhCTt0d09aRGcE7IRvCFjw2wngaqRQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/history/trumbowyg.history.min.js" integrity="sha512-hvFEVvJ24BqT/WkRrbXdgbyvzMngskW3ROm8NB7sxJH6P4AEN77UexzW3Re5CigIAn2RZr8M6vQloD/JHtwB9A==" crossorigin="anonymous"></script>
    <!-- <script src="js/dashboard.js"></script> -->
    <script type="text/javascript" src="/assets/js/datatables.wsb.prod_data.js?v=1.0.2.98"></script>
    <!-- <script src="/assets/js/wsb.ddr.js?v1.0.0.14"></script> -->
</head>

<body class="dash">
<?php  include 'include/header_extensions.php' ?>
<div class=' '>      
    <main role="main" class="">
        <nav class="navbar navbar-dark navbar-dash navbar-dash-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand navbar-dash-brandboard navbar-dash-brandboard col-md-3 col-lg-2 mr-0 px-3" href="#">Property Listing Database</a>
    <button class="navbar-toggler navbar-dash-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggle-icon navbar-dash-toggler-icon"></span>
    </button>
    <input class="form-control-dash form-control-dash-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-dash nav-dash px-3">
        <li class="nav-dash-item nav-item text-nowrap">
        <a class="nav-dash-link nav-link" href="#">Sign out</a>
        </li>
    </ul>
    </nav>

    <div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar-dash collapse">
        <div class="sidebar-dash-sticky pt-3">
            <ul class="nav nav-dash flex-column">
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link active" href="#">
                <span data-feather="home"></span>
                Search PLDB <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link" href="#">
                <span data-feather="file"></span>
                Orders
                </a>
            </li>
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link" href="#">
                <span data-feather="shopping-cart"></span>
                Products
                </a>
            </li>
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link" href="#">
                <span data-feather="users"></span>
                Customers
                </a>
            </li>
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link" href="#">
                <span data-feather="bar-chart-2"></span>
                Reports
                </a>
            </li>
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link" href="#">
                <span data-feather="layers"></span>
                Integrations
                </a>
            </li>
            </ul>

            <h6 class="sidebar-dash-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Saved reports</span>
            <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle"></span>
            </a>
            </h6>
            <ul class="nav-dash flex-column mb-2">
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link" href="#">
                <span data-feather="file-text"></span>
                Current month
                </a>
            </li>
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link" href="#">
                <span data-feather="file-text"></span>
                Last quarter
                </a>
            </li>
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link" href="#">
                <span data-feather="file-text"></span>
                Social engagement
                </a>
            </li>
            <li class="nav-dash-item nav-item">
                <a class="nav-dash-link nav-link" href="#">
                <span data-feather="file-text"></span>
                Year-end sale
                </a>
            </li>
            </ul>
        </div>
        </nav>
        
        <div class="pt-4 col-md-4 col-lg-4 d-md-block bg-dark sidebar--dash collapse pr-5">
            <form id="frmSearchDB">
            <!-- <div class="row mx-auto form--group mt-4">
                <div class="col--md-6 mb-2">
                    <label id="labelName" class="my-1 mr-2 text-white" for="searchTypeName">Name</label>
                    <select id="searchTypeName" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Search Type" data-style="btn-primary btn-sm">
                        <option value="equals" data-token="Equals">Equals</option>
                        <option value="begins" data-token="Begins With">Begins With</option>
                        <option value="contains" data-token="Contains">Contains</option>
                    </select> 
                </div>
                <div class="col-md-6 mb-2 pr-3">
                    <input id="strName" name="strName" type="search" autocomplete="off" class="form-control form-control-sm" value="" required>
                </div>
            </div>
            <div class="row mx-auto form--group mt-4">
            
                <div class="col--md-6 mb-2 w-100 mr-5">
                    <label id="labelState" class="my-1 mr-2 text-white" for="strState">State</label>
                    <select id="strState1" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select State..." data-style="btn-primary btn-sm">
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select> 
                </div>

            </div>
            <div class="row mx-auto form--group mt-4">
                <div id="county_drop_down_fake1"class="col--md-6 mb-2 w-100 mr-5">
                    <label id="labelCountyFake" class="my-1 mr-2 text-white" for="strCountyParishFake">County</label><select id="strCountyParishFake" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm"></select>
                    
                    
                
                <div id="county_drop_down1" class="input-group input-group-sm hidden">
                    <label id="labelCounty" class="my-1 mr-2 text-white" for="strCountyParish">County</label>
                        <select id="strCountyParish" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select County..." data-style="btn-primary btn-sm">
                            
                        </select>

                    </div>
                    <span id="loading_county_drop_down" style="display: none;"><i data-feather="loader">&nbsp;Loading...</i></span>
                    <div id="no_county_drop_down" style="display: none;">This state has no counties.</div>
                    <div id="county_drop_down" class="input-group input-group-sm">
                        <label class="my-1 mr-2 text-white" for="county_parish">County</label>
                        <select id="county_parish" class="form-control" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                            
                        </select>
                        
                    </div>
                    <span id="loading_county_drop_down" style="display: none;"><i data-feather="loader">&nbsp;Loading...</i></span>
                    <div id="no_county_drop_down" style="display: none;">This state has no counties.</div> 
                </div>

            </div>
            <div class="row mx-auto form--group mt-4">
                <div class="col--md-6 mb-2">
                    <label id="labelBlock" class="my-1 mr-2 text-white" for="searchTypeBlock">Block</label>
                    <select id="searchTypeBlock" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                        <option value="equals" data-token="Equals">Equals</option>
                        <option value="begins" data-token="Begins With">Begins With</option>
                        <option value="contains" data-token="Contains">Contains</option>
                    </select> 
                </div>
                <div class="col-md-6 mb-2 pr-3">
                    <input id="strName" name="strName" type="search" autocomplete="off" class="form-control form-control-sm" value="" required>
                </div>
            </div>
            <div class="row mx-auto form--group mt-4">
                <div class="col--md-6 mb-2 w-100 mr-5">
                    <label id="labelCompanyCode" class="my-1 mr-2 text-white" for="searchTypeCompanyCode">Owning Company</label>
                    <select id="searchTypeCompanyCode" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                        <option value="equals" data-token="Equals">Equals</option>
                        <option value="begins" data-token="Begins With">Begins With</option>
                        <option value="contains" data-token="Contains">Contains</option>
                    </select> 
                </div>

            </div>
            <div class="row mx-auto form--group mt-4">
                <div class="col--md-6 mb-2 w-100 mr-5">
                    <label id="labelEntityStatus" class="my-1 mr-2 text-white" for="searchTypeEntityStatus">Type</label>
                    <select id="searchTypeEntityStatus" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                        <option value="equals" data-token="Equals">Equals</option>
                        <option value="begins" data-token="Begins With">Begins With</option>
                        <option value="contains" data-token="Contains">Contains</option>
                    </select> 
                </div>

            </div>
            <div class="row mx-auto form--group mt-4">
                <div class="col--md-6 mb-2 w-100 mr-5">
                    <label id="labelTypeStatus" class="my-1 mr-2 text-white" for="searchTypeStatus">Status</label>
                    <select id="searchTypeStatus" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                        <option value="equals" data-token="Equals">Equals</option>
                        <option value="begins" data-token="Begins With">Begins With</option>
                        <option value="contains" data-token="Contains">Contains</option>
                    </select> 
                </div>

            <div id="labelWidthElement" class="w-75"></div>
            </div>
            <div class="row mx-auto mt-4 pr-5">
            <div class="col"><input id="frmSearchDBSubmit" type="button" class="btn btn-primary btn-block">Search</input></div>
            <div class="col"><input id="frmSearchDBReset" type="button" class="btn btn-secondary btn-block mr-4">Reset</input></div>
            </div> -->
            <div class="container">
                <div class="row pr-5 justify-content-md-center">
                    <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Name</label></div>
                    <div class="col">
                        <select id="input1" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                            <option value="equals" data-token="Equals">Equals</option>
                            <option value="begins" data-token="Begins With">Begins With</option>
                            <option value="contains" data-token="Contains">Contains</option>
                        </select>
                    </div>
                    <div class="col">
                        <input id="input1b" name="strName" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="" required>
                    </div>
                </div>
                <div class="row pr-5">
                    <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input2">State</label></div>
                    <div class="col">
                        <select id="input2" class="strState" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select State..." data-style="btn-primary btn-sm">
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>
                <div id="county_drop_down_fake" class="row pr-5">
                    <div class="col-4 text-right"><label id="labelCountyFake" class="my-1 mr-2 text-white" for="strCountyParishFake">County</label>
                    
                    <!-- <label id="label2a" class="my-1 mr-2 text-white labelCountyFake" for="input3a">County</label>-->
                    </div> 
                    <div class="col">
                    <select disabled id="strCountyParishFake" class="" data-live-search="true" data-width="100%" data-size="5" width='auto' name="api" size="1" title="Please select a state..." data-style="btn-primary btn-sm"></select>    
                        <!-- <select id="input3" class="strCountyParishFake selectpicker" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                            
                        </select> -->
                    </div>
                    
                </div>
                <div id="county_drop_down" class="row pr-5 hidden">
                    <div class="col-4 text-right "><label id="label2b" class="my-1 mr-2 text-white labelCounty" for="input3">County</label></div>
                    <div class="col">
                        <select id="input3" class="strCountyParish" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select County..." data-style="btn-primary btn-sm">
                            <!-- <option value="equals" data-token="Equals">Equals</option>
                            <option value="begins" data-token="Begins With">Begins With</option>
                            <option value="contains" data-token="Contains">Contains</option> -->
                        </select>
                        <span id="loading_county_drop_down" style="display: none;"><i data-feather="loader">&nbsp;Loading...</i></span>
                        <div id="no_county_drop_down" style="display: none;">This state has no counties.</div>
                    </div>

                </div>
                <div class="row pr-5">
                    <div class="col-4 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">Block</label></div>
                    <div class="col">
                        <select id="input4" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                            <option value="equals" data-token="Equals">Equals</option>
                            <option value="begins" data-token="Begins With">Begins With</option>
                            <option value="contains" data-token="Contains">Contains</option>
                        </select>
                    </div>
                    <div class="col">
                        <input id="input4b" name="strName" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="" required>
                    </div>
                </div>
                <div class="row pr-5">
                    <div class="col-4 text-right"><label id="label4" class="my-1 mr-2 text-white" for="input5">Owning Company</label></div>
                    <div class="col">
                        <select id="input5" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                            <option value="equals" data-token="Equals">Equals</option>
                            <option value="begins" data-token="Begins With">Begins With</option>
                            <option value="contains" data-token="Contains">Contains</option>
                        </select>
                    </div>
                </div>
                <div class="row pr-5">
                    <div class="col-4 text-right"><label id="label5" class="my-1 mr-2 text-white" for="input6">Type</label></div>
                    <div class="col">
                        <select id="input6" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                            <option value="equals" data-token="Equals">Equals</option>
                            <option value="begins" data-token="Begins With">Begins With</option>
                            <option value="contains" data-token="Contains">Contains</option>
                        </select>
                    </div>
                </div>
                <div class="row pr-5">
                    <div class="col-4 text-right"><label id="label6" class="my-1 mr-2 text-white" for="input7">Status</label></div>
                    <div class="col">
                        <select id="input7" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-sm">
                            <option value="equals" data-token="Equals">Equals</option>
                            <option value="begins" data-token="Begins With">Begins With</option>
                            <option value="contains" data-token="Contains">Contains</option>
                        </select>
                    </div>
                </div>
                <div class="row pr-5">
                    <div class="col"><button type="submit" class="btn btn-block btn-primary mb-2">Search</button></div>
                    <div class="col"><button type="submit" class="btn btn-block btn-primary mb-2">Reset</button></div>
                </div>
            </div>
            <!-- <div class="row mx-auto form--group mt-4">
                <div class="col--md-6 mb-2">
                    <label class="my-1 mr-2 text-white" for="searchTypeName">Preference</label>
                    <select id="searchTypeName" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Select Well..." data-style="btn-primary btn-lg">
                    <?php
                                
                    $table = "list";
                    $sql = "SELECT api, entity_common_name FROM $table";// ORDER BY well_lease ASC";
                    $result = mysqli_query($mysqli,$sql) or die(mysql_error());
                        //console_log($result);
                    ?>
                    <?php 
                    while ($row = mysqli_fetch_array($result)) {
                        // $wellname = $row['well_lease'] . "# " . $row['well_no']; 
                        $wellname = $row['entity_common_name'];
                        $conditional = ($row['api'] == $apino) ?  '"' . $row['api'] . '" selected' :  '"' . $row['api'] . '"';
                        ?>
                    <option name="api" id="api" value=<?php echo $conditional;  ?> data-token=<?php echo $conditional;  ?>><?php echo $wellname; //$row['api']; // . $row['well_no'];?></option> 
                    
                    <?php } ?>
                    <option value="equals" data-token="Equals">Equals</option>
                    <option value="equals" data-token="Equals">Equals</option>
                    <option value="equals" data-token="Equals">Equals</option>
                    </select> 
                </div>
                <div class="col-md-6 mb-2">
                    <input id="strName" name="strName" type="search" autocomplete="off" class="form-control form-control-sm" value="" required>
                </div>
            </div> -->
        </form>
                    </div>
        <main role="main" class="col-md-5 ml-sm-auto col-lg-6 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                    <span data-feather="calendar"></span>
                    This week
                </button>
                </div>
            </div>
            <h2>Section Title</h2>
            
        <!-- <main role="main" class="col-md-5 ml-sm-auto col-lg-6 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                    <span data-feather="calendar"></span>
                    This week
                </button>
                </div>
            </div>


            <h2>Section title</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Header</th>
                    <th>Header</th>
                    <th>Header</th>
                    <th>Header</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>1,001</td>
                    <td>random</td>
                    <td>data</td>
                    <td>placeholder</td>
                    <td>text</td>
                    </tr>
                    <tr>
                    <td>1,002</td>
                    <td>placeholder</td>
                    <td>irrelevant</td>
                    <td>visual</td>
                    <td>layout</td>
                    </tr>
                    <tr>
                    <td>1,003</td>
                    <td>data</td>
                    <td>rich</td>
                    <td>dashboard</td>
                    <td>tabular</td>
                    </tr>
                    <tr>
                    <td>1,003</td>
                    <td>information</td>
                    <td>placeholder</td>
                    <td>illustrative</td>
                    <td>data</td>
                    </tr>
                    <tr>
                    <td>1,004</td>
                    <td>text</td>
                    <td>random</td>
                    <td>layout</td>
                    <td>dashboard</td>
                    </tr>
                    <tr>
                    <td>1,005</td>
                    <td>dashboard</td>
                    <td>irrelevant</td>
                    <td>text</td>
                    <td>placeholder</td>
                    </tr>
                    <tr>
                    <td>1,006</td>
                    <td>dashboard</td>
                    <td>illustrative</td>
                    <td>rich</td>
                    <td>data</td>
                    </tr>
                    <tr>
                    <td>1,007</td>
                    <td>placeholder</td>
                    <td>tabular</td>
                    <td>information</td>
                    <td>irrelevant</td>
                    </tr>
                    <tr>
                    <td>1,008</td>
                    <td>random</td>
                    <td>data</td>
                    <td>placeholder</td>
                    <td>text</td>
                    </tr>
                    <tr>
                    <td>1,009</td>
                    <td>placeholder</td>
                    <td>irrelevant</td>
                    <td>visual</td>
                    <td>layout</td>
                    </tr>
                    <tr>
                    <td>1,010</td>
                    <td>data</td>
                    <td>rich</td>
                    <td>dashboard</td>
                    <td>tabular</td>
                    </tr>
                    <tr>
                    <td>1,011</td>
                    <td>information</td>
                    <td>placeholder</td>
                    <td>illustrative</td>
                    <td>data</td>
                    </tr>
                    <tr>
                    <td>1,012</td>
                    <td>text</td>
                    <td>placeholder</td>
                    <td>layout</td>
                    <td>dashboard</td>
                    </tr>
                    <tr>
                    <td>1,013</td>
                    <td>dashboard</td>
                    <td>irrelevant</td>
                    <td>text</td>
                    <td>visual</td>
                    </tr>
                    <tr>
                    <td>1,014</td>
                    <td>dashboard</td>
                    <td>illustrative</td>
                    <td>rich</td>
                    <td>data</td>
                    </tr>
                    <tr>
                    <td>1,015</td>
                    <td>random</td>
                    <td>tabular</td>
                    <td>information</td>
                    <td>text</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </main> -->
    </div>
    </div>
	</main>
    <?php 
    include 'include/floating_action_button.php';
    include 'modals/ddr_add_modal.php'; 
    include 'include/ddr_datepicker.php'; 
    ?>
</div>

</body>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>   
<script src="/assets/js/bottom_scripts.js?v1.0.0.1"></script>
<script type="text/javascript" src="/assets/js/pldb_county_selectpicker.js?v1.0.0.61"></script>
</html>


