<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/OutboardDatabase.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/OutboardAuth.php");

include_once($_SERVER['DOCUMENT_ROOT'] ."/include/char_widths.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/include/common.php");
include($_SERVER['DOCUMENT_ROOT'] . '/include/wsbFunctions.php');
// Create main objects;
$auth = new OutboardAuth();
$ob   = new OutboardDatabase();

// Set some simple variables used later in the page
$baseurl             = $_SERVER['PHP_SELF'];
$current             = getdate();
$version             = $ob->getConfig('version');
$version_date        = $ob->getConfig('version_date');
$max_visible_length  = $ob->getConfig('max_visible_length');
$cookie_time_seconds = $ob->getConfig('cookie_time_seconds');
$body_bg             = $ob->getConfig('body_bg');
$td_bg               = $ob->getConfig('td_bg');
$td_zebra1           = $ob->getConfig('td_zebra1');
$td_zebra2           = $ob->getConfig('td_zebra2');
$zebra_stripe		 = $ob->getConfig('zebra_stripe');
$td_user_bg          = $ob->getConfig('td_user_bg');
$td_text             = $ob->getConfig('td_text');
$td_lines            = $ob->getConfig('td_lines');
$link_text           = $ob->getConfig('link_text');
$windows_font_family = $ob->getConfig('windows_font_family');
$unix_font_family    = $ob->getConfig('unix_font_family');
$windows_bfs         = $ob->getConfig('windows_bfs');
$unix_bfs            = $ob->getConfig('unix_bfs');
$image_dir           = $ob->getConfig('image_dir');
$change_image        = $ob->getConfig('change_image');
$view_image          = $ob->getConfig('view_image');
$empty_image         = $ob->getConfig('empty_image');
$in_image            = $ob->getConfig('in_image');
$out_image           = $ob->getConfig('out_image');
$dot_image           = $ob->getConfig('dot_image');
$right_arrow         = $ob->getConfig('right_arrow');

// Run the installation script if the config says to
if ($ob->getConfig('installtables')) { include("include/install.php"); }


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

// Show the login screen if the user is not authenticated
if (! $username) {
  $auth->setSessionCookie("",$cookie_time_seconds);
  include("include/loginscreen.php");
}

// if 'logout' is set, run the logout functions and go back
// to the login screen.
if (getGetValue('logout')) {
  $ob->setSession("");
  $auth->setSessionCookie("",$cookie_time_seconds);
  include($_SERVER['DOCUMENT_ROOT'] . "/include/loginscreen.php");
}

if (getPostValue('exitadmin')) {
  // trick the page into noupdate mode
  $_GET['noupdate'] = 1;
} elseif (getGetValue('adminscreen') and $ob->isAdmin() ) {
  include($_SERVER['DOCUMENT_ROOT'] . "/include/admin.php");
}

// Get the owner of the dot we want to change (might be someone else's dot)
$userid = getGetValue('userid');

// The user wants to move the dot to the Out column
if ($out = getGetValue('out')) { $ob->setDotOut($userid); }

// The user wants to move the dot to the In column
if ($in = getGetValue('in')) { $ob->setDotIn($userid); }

// 
if ($rw = getGetValue('rw')) { $ob->setDotRW($userid); }

// The user wants to move the dot to the specified "will return by" column. The
// return variable contains the hour in the day that the user will return.
if ($return = getGetValue('return')) { $ob->setDotTime($userid,$return); }

// The user wants to change the remarks. We have to use isset() here first
// to allow for empty remarks.
if (isset($_GET['remarks'])) {
  $remarks = getGetValue('remarks');
  $ob->setRemarks($userid,$remarks);
}


// Appropriately set the update flag.
if (getGetValue('noupdate')) {
  $update = 0;
  if ($current['hours'] >= 6 && $current['hours'] <= 18 ) {
    $update_msec = $ob->getConfig('reload_sec') * 1000;
  } else {
    // Set the update rate to the "night rate" if between 6:00pm and 6:00am
    $update_msec = $ob->getConfig('night_sec') * 1000;
  }
} else {
  $update = 1;
  $update_msec = $ob->getConfig('update_sec') * 1000;
}
$userid = $ob->getOperatingUser();
/* Set some simple variables used later in the page
$baseurl             = $_SERVER['PHP_SELF'];
$current             = getdate();
$cookie_time_seconds = $ob->getConfig('cookie_time_seconds');

// Get the session (if there is one)
$session = $auth->getSessionCookie();
console_log($session);
// console_log($ob->getSession($session));
console_log($ob->getOperatingUser());
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
$check = $ob->getOperatingUser();
// console_log($ob->getSession($session));
console_log($username);
console_log($check);
$userid = getGetValue('userid');
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

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = connect_db();


?>
<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>PLDB</title>
<link rel="stylesheet" type="text/css" href="/assets/css/dashboard.css?v1.0.0.3">
<!-- <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-select-fake.css?v1.0.0.0"> -->
<?php include($_SERVER['DOCUMENT_ROOT'] . '/include/dependencies.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/trumbowyg.min.js" integrity="sha512-sffB9/tXFFTwradcJHhojkhmrCj0hWeaz8M05Aaap5/vlYBfLx5Y7woKi6y0NrqVNgben6OIANTGGlojPTQGEw==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/cleanpaste/trumbowyg.cleanpaste.min.js" integrity="sha512-y7o2DGiZAj5/HOX10rSG1zuIq86mFfnqbus0AASAG1oU2WaF2OGwmkt2XsgJ3oYxJ69luyG7iKlQQ6wlZeV3KQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/colors/trumbowyg.colors.min.js" integrity="sha512-iT7g30i1//3OBZsfoc5XmlULnKQKyxir582Z9fIFWI6+ohfrTdns118QYhCTt0d09aRGcE7IRvCFjw2wngaqRQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.23.0/plugins/history/trumbowyg.history.min.js" integrity="sha512-hvFEVvJ24BqT/WkRrbXdgbyvzMngskW3ROm8NB7sxJH6P4AEN77UexzW3Re5CigIAn2RZr8M6vQloD/JHtwB9A==" crossorigin="anonymous"></script>
<!-- <script src="js/dashboard.js"></script> -->
<!-- <script type="text/javascript" src="/assets/js/datatables.wsb.prod_data.js?v=1.0.2.98"></script> -->
<!-- <script src="/assets/js/wsb.ddr.js?v1.0.0.14"></script> -->
<!-- <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script> -->

<script type="text/javascript">
    window.user = "<?php echo $userid; ?>";
</script>
<script>
    /**@function addEvent works similarly to the jQuery $(parent).on(event, callback)
     * 
     * @param {Object} parent - The parent element
     * @param {string} evt - The event, ex. 'click'
     * @param {string} selector - The selector; examples: .class, #id, tag, etc. 
     * @param {Any} handler - handler function
     */
    addEvent = (parent, evt, selector, handler) => {
        parent.addEventListener(evt, function(event) {
            if (event.target.matches(selector + ', ' + selector + ' *')) {
            handler.apply(event.target.closest(selector), arguments);
            }
        }, false);
    }
    /**
	 * Asynchronous function to POST data; used to replace $.ajax(). Default options for this function are marked with *
	 *
	 * @param {string} url - The location of the request
	 * @param {string|null} data - The data to be sent with the request; body data type must match "Content-Type" header
     * @param {string} method - HTTP request method. Options are GET, *POST, PUT, DELETE, etc. 
     * @param {string} mode - CORS policy. Options are: no-cors, *cors, same-origin
     * @param {string} cache - cache policy to be sent with request. Options are: default, *no-cache, reload, force-cache, only-if-cached.
     * @param {string} credentials - Credentials to be sent. Options are: include, *same-origin, omit
     * @param {obj} headers - headers to be sent with request. Many options, two are: *'Content-Type': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded'
     * @param {string} redirect - Options are: manual, *follow, error
     * @param {string} referrerPolicy - Options are: *no-referrer, no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
     * 
	 * @return parses JSON response into native JavaScript objects
	 */
    async function postData(url = '', data = {}, method = 'POST', 
                            mode = 'cors', cache = 'no-cache', 
                            credentials = 'same-origin', 
                            headers = {'Content-Type': 'application/json'}, 
                            redirect = 'follow', referrerPolicy = 'no-referrer') {
        const response = await fetch(url, {
            method: method, 
            mode: mode, 
            cache: cache,
            credentials: credentials,
            headers: headers,
            redirect: redirect, 
            referrerPolicy: referrerPolicy,
            body: JSON.stringify(data)
        });
        return response.json(); 
    }
    /**
     * Logging function for prettier logging.
     * 
     * @param {string} s - string to be logged.
     * 
     */
    log = (s) => { console.log('\n%c'+s, 'color: #17a2b8;') }
    // function setWindowHeight(minus){
    //     var windowHeight = window.innerHeight;
    //     document.body.style.height = windowHeight - minus + "px";
    //     console.log(document.body.style.height);
    // }
    // window.addEventListener("load",setWindowHeight,false);
    init_n_pop_select = (rd, t, col, num) => {
        for(i =0; i < rd[t].length; i++){
            var cc = rd[t][i][col];
            document.querySelector(`#input${num}`)
            .insertAdjacentHTML("beforeend",
                document.querySelector('option', { 
                    value: cc,
                    text : cc,
                })
            );
        }
        $('#input'+num).selectpicker({width:'100%'});
        // document.querySelector(`#input${num}`).selectpicker({width:'100%'});
    }
    printCSS = (url) => {
        let link = document.createElement('link');
            link.rel = 'stylesheet';
            link.type = 'text/css';
            link.href = url;
        window.frames["print_frame"].document.getElementsByTagName('HEAD')[0].appendChild(link);
        // return link;
    }
    createStyle = (styledContent) => {
        let style = document.createElement('style');
        style.textContent = styledContent;
        document.head.appendChild(style)
        // return style;
    }
    isOdd = (num) => { return (num % 2) == 1; }
    getScrollHeight = () => {
        let scrollHeight = Math.max(
        document.body.scrollHeight, document.documentElement.scrollHeight,
        document.body.offsetHeight, document.documentElement.offsetHeight,
        document.body.clientHeight, document.documentElement.clientHeight,
        document.body.getBoundingClientRect().height, document.documentElement.getBoundingClientRect().height
        );
        return scrollHeight;
    }
    getTransitionEndEventName = () => {
        var transitions = {
            "transition"      : "transitionend",
            "OTransition"     : "oTransitionEnd",
            "MozTransition"   : "transitionend",
            "WebkitTransition": "webkitTransitionEnd"
        }
        let bodyStyle = document.body.style;
        for(let transition in transitions) {
            if(bodyStyle[transition] != undefined) {
                return transitions[transition];
            } 
        }
    }
    countChar = (str, char) => {
        let count = 0;
        for(let i = 0; i < str.length; i++){
            str[i] == char && count++;
        }
        return count;
    }
    hideActive = () => {
        let active = document.querySelectorAll(".active");
        for (var i = 0; i < active.length; i++) { 
            active[i].classList.remove('active');
        }
    }
    /**
     * Printing function
     */
    printReport = () => {
        let reportView = document.querySelector("#searchresults");
        let a = `<style type="text/css" media="print"> @page { size: landscape; }</style>`;
        let b = reportView.innerHTML;
        let pf = document.getElementById('printing-frame');
        pf.classList.remove('d-none');
        window.frames["print_frame"].document.body.innerHTML = a + b;
        window.frames["print_frame"].window.focus();
        window.frames['print_frame'].document.body.focus();
        Notiflix.Loading.pulse('Preparing Report');
        setTimeout(() => {
            Notiflix.Loading.remove();
            window.frames["print_frame"].window.print(); 
            pf.classList.add('d-none');
        }, 1000);
    }
    hasWhiteSpace = (s) => {
        return s.indexOf(' ') >= 0;
    }
    // $(document).ready(function(){
    document.addEventListener("DOMContentLoaded", function(event) {
        /* Document Setup */ 
        window.frames["print_frame"].document.title = document.title;
        let linkDash = printCSS("/assets/css/dashboard.css?v1.0.0.3");
        let link = printCSS("/assets/css/main.min.css");
        let linkDT = printCSS("https://cdn.datatables.net/v/bs4/dt-1.10.25/af-2.3.5/b-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.4/sp-1.2.1/sl-1.3.1/datatables.min.css");
        feather.replace();
        const toggle = document.getElementById('toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarwidth = sidebar.getBoundingClientRect().width;
        const sidebarmenu = document.getElementById('sidebarMenu');
        const fullsidebarwidth = sidebarmenu.getBoundingClientRect().width + sidebarwidth;
        let sidebarOpenWidth = sidebar.getBoundingClientRect().right;
        let sidebarCloseWidth = sidebar.getBoundingClientRect().left;
        let fakesidebar = sidebar.cloneNode(false);
            fakesidebar.id = 'fakesidebar';
            fakesidebar.classList.add('fake-sidebar');
            fakesidebar.classList.remove('col-md-4');
            fakesidebar.classList.remove('col-lg-4');
            fakesidebar.classList.remove('sidebar-dash');
        document.getElementById('main-row').insertBefore(fakesidebar, toggle);
        let fakeSidebarStyle = `
        .fake-sidebar {position:absolute; left:${sidebarCloseWidth}px; width:${sidebarwidth}px; height:${sidebar.getBoundingClientRect().height}px; transform:translateX(-100%); -webkit-transform translateX(-100%);}
        .slide-in {animation: slide-in 0.5s forwards; -webkit-animation: slide-in 0.5s forwards; z-index: auto; }
        .slide-out { animation: slide-out 0.5s forwards; -webkit-animation: slide-out 0.5s forwards; z-index: -1; max-width: 0%!important; padding-right: 0!important; }   
        @keyframes slide-in { 0% { transform: translateX(-100%); opacity: 0;} 100% { transform: translateX(0%); opacity: 1;} }
        @-webkit-keyframes slide-in { 0% { -webkit-transform: translateX(-100%); opacity: 0;} 100% { -webkit-transform: translateX(0%); opacity: 1;} }
        @keyframes slide-out { 0% { transform: translateX(0%); opacity: 1;} 100% { transform: translateX(-100%); opacity: 0;} }
        @-webkit-keyframes slide-out { 0% { -webkit-transform: translateX(0%); opacity: 1;} 100% { -webkit-transform: translateX(-100%); opacity: 0;} }`;
        createStyle(fakeSidebarStyle);
        const bodyheightdifference = document.querySelector("body").scrollHeight - document.querySelector("body").offsetHeight;
        const body = document.querySelector("body").offsetHeight;
        const nav = document.querySelector("body > nav").offsetHeight;
        const div = document.querySelector("body > div").offsetHeight;
        const winheight = body - nav;
        const tableheight = winheight;
        const mainDash = document.getElementById('main-dash');
        let isSidebarVis = 1;
        let transitionEndEventName = getTransitionEndEventName();
        toggle.style.left = `${sidebarOpenWidth}px`;
        mainDash.style.height = winheight;
        toggleVis = (elem, bool = 0) => {
            if(isSidebarVis){
                isSidebarVis = 0;
                elem.classList.remove('visible');
                elem.classList.remove('slide-in')
                elem.classList.add('slide-out')
                toggle.firstChild.classList.add('rotate');
                toggle.style.left = `${sidebarCloseWidth}px`;
            }
            else{
                isSidebarVis = 1;
                elem.classList.add('visible');
                elem.classList.add('slide-in')
                elem.classList.remove('slide-out')
                toggle.firstChild.classList.remove('rotate');
                toggle.style.left = `${sidebarOpenWidth}px`;
            }
        }
        toggle.onclick = () => { toggleVis(sidebar)}
        let btn = document.getElementById('printbutton');
            btn.addEventListener('click', printReport);
        var username = document.getElementById('edit-input-23');
        username.setAttribute("value", user);
        var resultTableBool = false;
        var lTable;
        var pTable;
        var opTable;
        var ocTable;
        var osTable;
        var uTable;
        var qTable;
        var sTable;
        const click = {
                location : 0,
                property : 0,
                opstatus : 0,
                owncomp : 0,
                status : 0,
                update : 0
            }
        var clickquery = 0;
        const table = {
            location : lTable,
            property : pTable,
            opstatus : opTable,
            owncomp : ocTable,
            status : osTable,
            update : uTable
        }
        const check = {
            location : "location",
            property : "property",
            opstatus : "opstatus",
            owncomp :  "owncomp ",
            status :   "status",
            update :  "update"
        }
        tableload = (value) => {
            // $('.forms').addClass('d-none').removeClass('d-md-block')
            
            const dt ={ 
            location : {
                "ajax": {
                "url" : "/ajax/pldb.fetchdata.php",
                // "type" : "POST",
                "data": {
                    "table": 'pldb_locations'
                }
                },
                "sDom": 't',
                "order": [],
                //deferRender: true,
                scrollY: 825,
                scroller: true,
                "searching": true,
                "autoWidth": false,
                // "order": [],
                // "paging": false,
                // "info": false,
                // "searching": true,
                // "sDom": 'd',
                // "autoWidth": false,
                "columns": [
                    {
                    "data": "id", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "state", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "region", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "county", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "block", // can be null or undefined
                    "defaultContent": ""
                    },
                    {
                    "data": "field", // can be null or undefined
                    "defaultContent": ""
                    }
                ],
                "columnDefs": [
                { className: "text-wrap", "targets":  [0,1,2,3,4,5]  }
                ]
            },
            property : {
                "ajax": {
                "url" : "/ajax/pldb.fetchdata.php",
                // "type" : "POST",
                "data": {
                    "table": 'pldb'
                }
                },
                "sDom": 't',
                "order": [],
                //deferRender: true,
                scrollY: 825,
                scroller: true,
                "searching": true,
                "autoWidth": false,
                // "order": [],
                // "paging": false,
                // "info": false,
                // "searching": true,
                // "sDom": 'd',
                // "autoWidth": false,
                "columns": [
                    {
                    "data": "id",
                    "defaultContent": ""
                    },
                    {
                    "data": "location_id",
                    "defaultContent": ""
                    },
                    {
                    "data": "name",
                    "defaultContent": ""
                    },
                    {
                    "data": "status",
                    "defaultContent": ""
                    },
                    {
                    "data": "status_in_depth_update",
                    "defaultContent": ""
                    },
                    {
                    "data": "operating_status",
                    "defaultContent": ""
                    },
                    {
                    "data": "owning_company",
                    "defaultContent": ""
                    },
                    {
                    "data": "purchaser",
                    "defaultContent": ""
                    },
                    {
                    "data": "tx_op_num",
                    "defaultContent": ""
                    },
                    {
                    "data": "operator",
                    "defaultContent": ""
                    },
                    {
                    "data": null, render: function(data)
                    {
                        if(data.wi == 1){
                            return "<i data-feather='check-circle' style='color: #28a745; height: 1.5em; width: 1.5em;'>Yes</i>";
                        }
                        else {
                            return "<i data-feather='x-circle' style='color: red; height: 1.5em; width: 1.5em;'>No</i>";
                        }
                    },
                    "defaultContent": ""
                    },
                    {
                        "data": null, render: function(data)
                    {
                        if(data.ri == 1){
                            return "<i data-feather='check-circle' style='color: #28a745; height: 1.5em; width: 1.5em;'>Yes</i>";
                        }
                        else {
                            return "<i data-feather='x-circle' style='color: red; height: 1.5em; width: 1.5em;'>No</i>";
                        }
                    },
                    "defaultContent": ""
                    },
                    {
                        "data": null, render: function(data)
                    {
                        if(data.orri == 1){
                            return "<i data-feather='check-circle' style='color: #28a745; height: 1.5em; width: 1.5em;'>Yes</i>";
                        }
                        else {
                            return "<i data-feather='x-circle' style='color: red; height: 1.5em; width: 1.5em;'>No</i>";
                        }
                    },
                    "defaultContent": ""
                    },
                    {
                        "data": null, render: function(data)
                    {
                        if(data.biapo == 1){
                            return "<i data-feather='check-circle' style='color: #28a745; height: 1.5em; width: 1.5em;'>Yes</i>";
                        }
                        else {
                            return "<i data-feather='x-circle' style='color: red; height: 1.5em; width: 1.5em;'>No</i>";
                        }
                    },
                    "defaultContent": ""
                    },
                    {
                        "data": null, render: function(data)
                    {
                        if(data.wbo == 1){
                            return "<i data-feather='check-circle' style='color: #28a745; height: 1.5em; width: 1.5em;'>Yes</i>";
                        }
                        else {
                            return "<i data-feather='x-circle' style='color: red; height: 1.5em; width: 1.5em;'>No</i>";
                        }
                    },
                    "defaultContent": ""
                    },
                    {
                    "data": "legal_description",
                    "defaultContent": ""
                    },
                    {
                    "data": "api",
                    "defaultContent": ""
                    },
                    {
                    "data": "gwi_value",
                    "defaultContent": ""
                    },
                    {
                    "data": "nri_value",
                    "defaultContent": ""
                    },
                    {
                    "data": "orri_value",
                    "defaultContent": ""
                    },
                    {
                    "data": "ri_value",
                    "defaultContent": ""
                    },
                    {
                    "data": "wp_code",
                    "defaultContent": ""
                    },
                    {
                    "data": "gross_acres",
                    "defaultContent": ""
                    },
                    {
                    "data": "net_acres",
                    "defaultContent": ""
                    },
                    {
                    "data": "lease_number",
                    "defaultContent": ""
                    },
                    {
                    "data": "comments",
                    "defaultContent": ""
                    },
                    {
                    "data": "combined_name",
                    "defaultContent": ""
                    },
                ],
                "drawCallback": function(settings){
                    feather.replace();
                    tippy('.r-tooltip', { 
                        arrow: false 
                    });
                    tippy('.hours', { 
                        placement: 'right',
                        arrow: false 
                    });
                } 
            },
            opstatus : {
                "ajax": {
                    "url": "/ajax/pldb.fetchdata.php", 
                    "data": {
                        "table": "pldb_lookup_internal_status"
                    } 
                },
                "sDom": 't',
                "order": [],
                "scrollY": 825,
                "scroller": true,
                "searching": true,
                "autoWidth": false,
                "columns": [
                        {
                        "data": "status", // can be null or undefined
                        "defaultContent": ""
                        }
                    ]
            },
            owncomp : {
                "ajax": {
                    "url": "/ajax/pldb.fetchdata.php", 
                    "data": {
                        "table": "pldb_lookup_company_codes"
                    } 
                },
                "sDom": 't',
                "order": [],
                "scrollY": 825,
                "scroller": true,
                "searching": true,
                "autoWidth": false,
                "columns": [
                        {
                        "data": "id", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "company_code", // can be null or undefined
                        "defaultContent": ""
                        }
                    ]
            },
            status : {
                "ajax": {
                    "url": "/ajax/pldb.fetchdata.php", 
                    "data": {
                        "table": "pldb_lookup_entity_status"
                    } 
                },
                "sDom": 't',
                "order": [],
                "scrollY": 825,
                "scroller": true,
                "searching": true,
                "autoWidth": false,
                "columns": [
                        {
                        "data": "status", // can be null or undefined
                        "defaultContent": ""
                        }
                    ]
            },
            update : {
                "ajax": {
                    "url": "/ajax/pldb.fetchdata.php", 
                    "data": {
                        "table": "pldb_update_history"
                    } 
                },
                "sDom": 't',
                "order": [],
                "scrollY": 825,
                "scroller": true,
                "searching": true,
                "autoWidth": false,
                "columns": [
                        {
                        "data": "action_type", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "property_id", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "update_date_time", // can be null or undefined
                        "defaultContent": ""
                        },
                        {
                        "data": "user_id", // can be null or undefined
                        "defaultContent": ""
                        }
                    ]
            }
            }
            hashvalue = '#' + value;
            // log(click[value]);
            // (sidebar.classList.contains("visible")) && toggleVis(sidebar);
            
            load = (value) => {
                if(click[value] < 1){
                click[value]++;
                table[value] = $(hashvalue).DataTable(dt[value]);
                // table[value] = new DataTable(hashvalue, dt[value]);
                } else {
                    table[value].ajax.reload();
                }
            }
            sidebar.addEventListener(transitionEndEventName, load(value));
            // let promise = new Promise((resolve, reject) => {
            //     resolve(dispatchEvent(sidebar.addEventListener(transitionEndEventName, function(){
                    
            //     })))
            // });
            // promise.then(() => {
                
            // })
            
        }
        queryload = (value, datacol) => {
            $('.forms').addClass('d-none').removeClass('d-md-block');
            
            // {
            // "data": "action_type", // can be null or undefined
            // "defaultContent": ""
            // },
            console.log(datacol[1]['data']);
            var qdt = {
                "ajax": {
                    "url" : "/ajax/pldb.queryload.php",
                    // "type" : "POST",
                    "data": {
                        "query": value
                    }
                },
                "sDom": 't',
                "order": [],
                //deferRender: true,
                scrollY: 825,
                // scrollX: 825,
                scroller: true,
                "searching": true,
                "autoWidth": false,
                "columns": [datacol]
                // "order": [],
                // "paging": false,
                // "info": false,
                // "searching": true,
                // "sDom": 'd',
                // "autoWidth": false,
            };
            if(clickquery < 1){ // if a query hasn't been built yet then
                // initialize query datatable for first time
                clickquery++; // add 1 to click so that this check goes to 
                                // else for each consecutive
                qTable = $('#query').DataTable(qdt);
                qTable.rows().invalidate().draw();
                
            } else { // else
                // destroy the datatable & reinitialize one with the new 
                // ajax call
                qTable.destroy();
                qTable = $('#query').DataTable(qdt);
                // qTable.ajax.url(value).load();
            }
        }
        queryLoader = (value) => {
            $('.forms').addClass('d-none').removeClass('d-md-block');
            
            // {
            // "data": "action_type", // can be null or undefined
            // "defaultContent": ""
            // },
            console.log(datacol[1]['data']);
            var qdt = {
                "ajax": {
                    "url" : "/ajax/pldb.queryload.php",
                    // "type" : "POST",
                    "data": {
                        "query": value
                    }
                },
                "sDom": 't',
                "order": [],
                //deferRender: true,
                scrollY: 825,
                // scrollX: 825,
                scroller: true,
                "searching": true,
                "autoWidth": false,
                // "columns": [datacol]
                // "order": [],
                // "paging": false,
                // "info": false,
                // "searching": true,
                // "sDom": 'd',
                // "autoWidth": false,
            };
            if(clickquery < 1){ // if a query hasn't been built yet then
                // initialize query datatable for first time
                clickquery++; // add 1 to click so that this check goes to 
                                // else for each consecutive
                qTable = $('#query').DataTable(qdt);
                qTable.rows().invalidate().draw();
                
            } else { // else
                // destroy the datatable & reinitialize one with the new 
                // ajax call
                qTable.destroy();
                qTable = $('#query').DataTable(qdt);
                // qTable.ajax.url(value).load();
            }
        }
        searchLoad = (value, data) => {
            var sdt = {
                "ajax": {
                    "url" : "/ajax/pldb.formsearch.php",
                    // "type" : "POST",
                    "data": {
                        "query": data
                    }
                },
                "sDom": 't',
                "order": [],
                //deferRender: true,
                scrollY: 825,
                // scrollX: 825,
                scroller: true,
                "searching": true,
                "autoWidth": false,
                // "columns": [{ "data": 'id' },{ "data": 'name' },{ "data": 'county' },{ "data": 'block' }]
                // "order": [],
                // "paging": false,
                // "info": false,
                // "searching": true,
                // "sDom": 'd',
                // "autoWidth": false,
            }
            $("#searchresults").removeClass("d-none");
            $("#result-header").append('<h1 id="rh-h1" class="h2">Results</h1>');
            $("#results").append('<div id="results-div" class="table-responsive">');
            $("#results-div").append('<table id="results-table" class="table table-striped table-sm table-hover">');
            $("#results-table").append('<thead><tr><th>ID</th><th>Name</th><th>County</th><th>Block</th></tr></thead>');

            if(value){ // if results have been shown once destroy and recreate table
                log('table should get destroyed');
                sTable.destroy();
            }
                sTable = $('#results-table').DataTable(sdt);
        }
        addEvent(document, 'click', '.query', function(e){
            qvalue = document.querySelector(this).data('query');
            value = 'query';
            valuetable = value + 'table';
            hideActive();
            document.querySelector(this).classList.add('active');
            document.querySelector('.results').each(function(){ (document.querySelector(this).attr('id') != value)? document.querySelector(this).classList.add('d-none') : document.querySelector(this).classList.remove('d-none'); })
            document.querySelector('.dtables').each(function(){ (document.querySelector(this).attr('id') != valuetable) ? document.querySelector(this).classList.add('d-none') : document.querySelector(this).classList.remove('d-none'); })
            document.querySelector(`#${value}_wrapper > div > div.dataTables_scrollHead > div > table`).classList.contains('d-none') && document.querySelector(`#${value}_wrapper > div > div.dataTables_scrollHead > div > table`).classList.remove('d-none')
            var datacol = {};
            $.ajax({
                url:"/ajax/pldb.queryload.php",  
                method:"POST",  
                data:{t:"fields"},  
                dataType:"json",  
                success:function(response){ 
                    thead = document.querySelector('<thead>');
                    rcl = response['column'];
                    log(rcl);
                    for ( var i=0, ien=response['column'].length ; i<ien ; i++ ) {
                        th = document.querySelector('<td>').text(response['column'][i]);
                        thead.insertAdjacentHTML("beforeend",th)
                        document.querySelector('#query').insertAdjacentHTML("beforeend",thead)
                        datacol[i] = { "data": '"'+rcl+"'" }
                    } 
                    queryload(qvalue, datacol);
                }
            });
        })
        $('#input1').selectpicker({width:'100%'});
        $('#input2.strState').selectpicker({width:'100%'});
        $('#input4').selectpicker({width:'100%'});
        // Owning Company
        $.ajax({
            url:"/ajax/pldb.formload.php",  
            method:"POST",  
            dataType:"json",  
            success:function(response){ 
                rd = response;
                col = 'company_code';
                num = 5;
                t = 'oc';
                console.log(response[t]);
                init_n_pop_select(rd, t, col, num);
                init_n_pop_select(rd, 's', 'status', 6);
                init_n_pop_select(rd, 'os', 'status', 7);
            }
        })
        const WorkZone = () => {
            this;
        }
        let sr_i = 0;
        generateTableHead = (table, data, i = 0) => {
            if(i == 0){
                if(typeof(document.querySelector('results-thead')) != 'undefined' && document.querySelector('results-thead') != null)
                {
                    while (document.querySelector('results-thead').parentElement.firstChild){
                        document.querySelector('results-thead').parentElement.removeChild(document.querySelector('results-thead').parentElement.firstChild);
                    }
                }
                let thead = table.createTHead();
                thead.classList.add('results-thead');
                let row = thead.insertRow();
                row.classList.add('results-thead-tr');
                let i = 0;
                for (let key of data) {
                    let th = document.createElement("th");
                    let text = document.createTextNode(key);
                    th.appendChild(text);
                    row.appendChild(th);
                }
            }
            else if (i == 1){
                if(typeof(document.querySelector('results-thead')) != 'undefined' && document.querySelector('results-thead') != null)
                {
                    while (document.querySelector('results-thead').parentElement.firstChild){
                        document.querySelector('results-thead').parentElement.removeChild(document.querySelector('results-thead').parentElement.firstChild);
                    }
                }
                let thead = table.createTHead();
                    thead.classList.add('results-thead');
                let row = thead.insertRow();
                    row.classList.add('results-thead-tr');
                    row.classList.add('table-border-bottom-white');
                let row2 = thead.insertRow();
                    row2.classList.add('results-thead-tr2');
                let d1 = ["SOG", "Operated Properties", "Non-Operated Properties", "Total", "Percent of Total"]
                let d2 = ["Region", "Gross Acres", "Net Acres", "Gross Acres", "Net Acres", "Gross Acres", "Net Acres", "Gross Acres", "Net Acres"];
                let i = 0;
                let j = 0;
                for (let key of d1) {
                    let th = document.createElement("th");
                    let text = document.createTextNode(key);
                    th.appendChild(text);
                    if (i > 0){
                        th.colSpan = 2;
                        th.classList.add('table-border-left');
                    }
                    row.appendChild(th);
                    i++;
                }
                for (let key of d2) {
                    let th = document.createElement("th");
                    let text = document.createTextNode(key);
                    th.appendChild(text);
                    if (isOdd(j)){
                        th.classList.add('table-border-left');
                    }
                    row2.appendChild(th);
                    j++;
                }
            }
            else if (i == 2){
                if(data == 1){
                    if(typeof(document.querySelector('results-thead')) != 'undefined' && document.querySelector('results-thead') != null)
                    {
                        while (document.querySelector('results-thead').parentElement.firstChild){
                            document.querySelector('results-thead').parentElement.removeChild(document.querySelector('results-thead').parentElement.firstChild);
                        }
                    }
                    let thead = table.createTHead();
                    thead.classList.add('results-thead');
                    let row = thead.insertRow();
                    row.classList.add('results-thead-tr');
                    row.classList.add('table-border-bottom-white');
                    let row2 = thead.insertRow();
                    row2.classList.add('results-thead-tr2');
                    let d1 = [" ", "Undeveloped", "Developed", "Total"]
                    let d2 = ["Entity", "Gross Acres", "Net Acres", "Gross Acres", "Net Acres", "Gross Acres", "Net Acres"];
                    let i = 0;
                    let j = 0;
                    for (let key of d1) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                        th.appendChild(text);
                        
                        if (i > 0){
                            th.colSpan = 2;
                            th.classList.add('table-border-left');
                        }
                        row.appendChild(th);
                        i++;
                    }
                    for (let key of d2) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                        th.appendChild(text);
                        if (isOdd(j)){
                            th.classList.add('table-border-left');
                        }
                        row2.appendChild(th);
                        j++;
                    }
                }
                else {
                    let thead = table.createTHead();
                        thead.classList.add('results-thead2');
                    let row = thead.insertRow();
                        row.classList.add('results-thead-tr2');
                        row.classList.add('table-border-bottom-white');
                    let row2 = thead.insertRow();
                        row2.classList.add('results-thead-tr2');
                    let d1 = ["Total Undeveloped", "Total Developed", "Grand Total"]
                    let d2 = ["Gross Acres", "Net Acres", "Gross Acres", "Net Acres", "Gross Acres", "Net Acres"];
                    let i = 0;
                    let j = 0;
                    for (let key of d1) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                            th.appendChild(text);
                            th.colSpan = 2;
                            th.classList.add('table-border-left');
                        row.appendChild(th);
                        i++;
                    }
                    for (let key of d2) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                            th.appendChild(text);
                        if (!isOdd(j)){
                            th.classList.add('table-border-left');
                        }
                        row2.appendChild(th);
                        j++;
                    }
                }
            }
            else if (i == 3){
                if(data == 1){
                    if(typeof(document.querySelector('results-thead')) != 'undefined' && document.querySelector('results-thead') != null)
                    {
                        log('true');
                        while (document.querySelector('results-thead').parentElement.firstChild){
                            document.querySelector('results-thead').parentElement.removeChild(document.querySelector('results-thead').parentElement.firstChild);
                        }
                    }
                    let thead = table.createTHead();
                    thead.classList.add('results-thead');
                    let row = thead.insertRow();
                    row.classList.add('results-thead-tr');
                    row.classList.add('table-border-bottom-white');
                    let row2 = thead.insertRow();
                    row2.classList.add('results-thead-tr2');

                    let d1 = [" ", "Active Gas Wells", "Active Oil Wells", "Total Active Wells"]
                    let d2 = ["Entity", "Gross", "Net", "Gross", "Net", "Gross", "Net"];
                    let i = 0;
                    let j = 0;
                    for (let key of d1) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                        th.appendChild(text);
                        
                        if (i > 0){
                            th.colSpan = 2;
                            th.classList.add('table-border-left');
                        }
                        // tr.appendChild(th);
                        row.appendChild(th);
                        i++;
                    }
                    for (let key of d2) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                        th.appendChild(text);
                        if (isOdd(j)){
                            th.classList.add('table-border-left');
                        }
                        row2.appendChild(th);
                        j++;
                    }
                }
                else if (data == 2) {
                    let thead = table.createTHead();
                    thead.classList.add('results-thead');
                    let row = thead.insertRow();
                    row.classList.add('results-thead-tr');
                    row.classList.add('table-border-bottom-white');
                    let row2 = thead.insertRow();
                    row2.classList.add('results-thead-tr2');

                    let d1 = [" ", "Shut-in Gas Wells", "Shut-in Oil Wells", "Total Shut-in Wells"]
                    let d2 = ["Entity", "Gross", "Net", "Gross", "Net", "Gross", "Net"];
                    let i = 0;
                    let j = 0;
                    for (let key of d1) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                        th.appendChild(text);
                        
                        if (i > 0){
                            th.colSpan = 2;
                            th.classList.add('table-border-left');
                        }
                        // tr.appendChild(th);
                        row.appendChild(th);
                        i++;
                    }
                    for (let key of d2) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                        th.appendChild(text);
                        if (isOdd(j)){
                            th.classList.add('table-border-left');
                        }
                        row2.appendChild(th);
                        j++;
                    }

                }
                else {
                    let thead = table.createTHead();
                    thead.classList.add('results-thead2');
                    let row = thead.insertRow();
                    row.classList.add('results-thead-tr2');
                    row.classList.add('table-border-bottom-white');
                    let row2 = thead.insertRow();
                    row2.classList.add('results-thead-tr2');

                    let d1 = ["Total Gas Wells", "Total Oil Wells", "Grand Total Wells"]
                    let d2 = ["Gross", "Net", "Gross", "Net", "Gross", "Net"];
                    let i = 0;
                    let j = 0;
                    for (let key of d1) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                        th.appendChild(text);
                        
                        
                            th.colSpan = 2;
                            th.classList.add('table-border-left');
                        
                        // tr.appendChild(th);
                        row.appendChild(th);
                        i++;
                    }
                    for (let key of d2) {
                        let th = document.createElement("th");
                        let text = document.createTextNode(key);
                        th.appendChild(text);
                        if (!isOdd(j)){
                            th.classList.add('table-border-left');
                        }
                        row2.appendChild(th);
                        j++;
                    }

                }

            }
            else if (i == 4){
                if(typeof(document.querySelector('results-thead')) != 'undefined' && document.querySelector('results-thead') != null)
                {
                    log('true');
                    while (document.querySelector('results-thead').parentElement.firstChild){
                        document.querySelector('results-thead').parentElement.removeChild(document.querySelector('results-thead').parentElement.firstChild);
                    }
                }
                let thead = table.createTHead();
                thead.classList.add('results-thead');
                let row = thead.insertRow();
                row.classList.add('results-thead-tr');
                row.classList.add('table-border-bottom-white');
                let row2 = thead.insertRow();
                row2.classList.add('results-thead-tr2');

                let d1 = ['Entity','Oil Wells - Operated','Gas Wells - Operated','Op. - Subtotals','Oil Wells - Non-Operated','Gas Wells - Non-Operated','Non-Op. - Subtotals','Company Totals'];
                let d2 = [" ", " ", "Active", "Inactive", " ", "Active", "Inactive", " ", "Active", "Inactive", " ", "Active", "Inactive", " ", "Active", "Inactive", " ", "Active", "Inactive", ""];
                let i = 0;
                let j = 0;
                for (let key of d1) {
                    let th = document.createElement("th");
                    let text = document.createTextNode(key);
                    th.appendChild(text);
                    
                    if (i > 0){
                        th.colSpan = 3;
                        th.classList.add('table-border-left');
                    }
                    row.appendChild(th);
                    i++;
                }
            }
        }
        const reportAccessLocale = 'default';
        const reportAccessOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const reportAccessAMPM = {hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true};
        generateReportAccess = (locale = reportAccessLocale, options = reportAccessOptions, ampm = reportAccessAMPM) => {
            let date = new Date().toLocaleString('default', options);
            let time = new Date().toLocaleString('default', ampm);
            let report_time = `Accessed on ${date} at ${time}`;
            return report_time;
        }
        generateTable = (table, data,i = 0) => {
            if(i == 0){
                for (let element of data) {
                    let row = table.insertRow();
                    row.classList.add('results-property');
                    row.id = element['id'];
                    for (key in element) {
                        let cell = row.insertCell();
                        let text = document.createTextNode(element[key]);
                        cell.appendChild(text);
                    }
                }
            }
            else {
                let t = table.createTBody();
                let f = table.createTFoot();
                for (let element of data) {
                    let row = t.insertRow();
                    let sr1 = t.insertRow();
                    let active = '<small class="text-muted">active</small>';
                    let inactive = '<small class="text-muted">inactive</small>';
                        row.id = element['id'];
                    let c1 = row.insertCell();
                        c1.rowSpan = 2;
                        c1.appendChild(document.createTextNode(element['Company']));
                    let coo2 = row.insertCell();
                        coo2.rowSpan = 2;
                        coo2.appendChild(document.createTextNode(element['Oil Wells - Operated']));
                    let coo3 = row.insertCell();
                        coo3.classList.add('text-right');
                        coo3.appendChild(document.createTextNode(element['Oil Wells - Active - Operated']));
                    let coo4 = row.insertCell(); //appendChild(document.createTextNode(active));
                        coo4.classList.add('sidebar-dash-heading');
                        coo4.innerHTML = active;
                    let coo5 = sr1.insertCell();
                        coo5.classList.add('text-right');
                        coo5.appendChild(document.createTextNode(element['Oil Wells - Inactive - Operated']));
                    let coo6 = sr1.insertCell(); //.appendChild(document.createTextNode('inactive'));
                        coo6.classList.add('sidebar-dash-heading');
                        coo6.innerHTML = inactive;
                    let cgo2 = row.insertCell();
                        cgo2.rowSpan = 2;
                        cgo2.appendChild(document.createTextNode(element['Gas Wells - Operated']));
                    let cgo3 = row.insertCell();
                        cgo3.classList.add('text-right');
                        cgo3.appendChild(document.createTextNode(element['Gas Wells - Active - Operated']));
                    let cgo4 = row.insertCell(); //appendChild(document.createTextNode(active));
                        cgo4.classList.add('sidebar-dash-heading');
                        cgo4.innerHTML = active;
                    let cgo5 = sr1.insertCell();
                        cgo5.classList.add('text-right');
                        cgo5.appendChild(document.createTextNode(element['Gas Wells - Inactive - Operated']));
                    let cgo6 = sr1.insertCell(); //.appendChild(document.createTextNode('inactive'));
                        cgo6.classList.add('sidebar-dash-heading');
                        cgo6.innerHTML = inactive;
                    let cto2 = row.insertCell();
                        cto2.rowSpan = 2;
                        cto2.appendChild(document.createTextNode(element['Wells - Operated']));
                    let cto3 = row.insertCell();
                        cto3.classList.add('text-right');
                        cto3.appendChild(document.createTextNode(element['Wells - Active - Operated']));
                    let cto4 = row.insertCell(); //appendChild(document.createTextNode(active));
                        cto4.classList.add('sidebar-dash-heading');
                        cto4.innerHTML = active;
                    let cto5 = sr1.insertCell();
                        cto5.classList.add('text-right');
                        cto5.appendChild(document.createTextNode(element['Wells - Inactive - Operated']));
                    let cto6 = sr1.insertCell(); //.appendChild(document.createTextNode('inactive'));
                        cto6.classList.add('sidebar-dash-heading');
                        cto6.innerHTML = inactive;
                    let con2 = row.insertCell();
                        con2.rowSpan = 2;
                        con2.appendChild(document.createTextNode(element['Oil Wells - Non-Operated']));
                    let con3 = row.insertCell();
                        con3.classList.add('text-right');
                        con3.appendChild(document.createTextNode(element['Oil Wells - Active - Non-Operated']));
                    let con4 = row.insertCell(); //appendChild(document.createTextNode(active));
                        con4.classList.add('sidebar-dash-heading');
                        con4.innerHTML = active;
                    let con5 = sr1.insertCell();
                        con5.classList.add('text-right');
                        con5.appendChild(document.createTextNode(element['Oil Wells - Inactive - Non-Operated']));
                    let con6 = sr1.insertCell(); //.appendChild(document.createTextNode('inactive'));
                        con6.classList.add('sidebar-dash-heading');
                        con6.innerHTML = inactive;
                    let cgn2 = row.insertCell();
                        cgn2.rowSpan = 2;
                        cgn2.appendChild(document.createTextNode(element['Gas Wells - Non-Operated']));
                    let cgn3 = row.insertCell();
                        cgn3.classList.add('text-right');
                        cgn3.appendChild(document.createTextNode(element['Gas Wells - Active - Non-Operated']));
                    let cgn4 = row.insertCell(); //appendChild(document.createTextNode(active));
                        cgn4.classList.add('sidebar-dash-heading');
                        cgn4.innerHTML = active;
                    let cgn5 = sr1.insertCell();
                        cgn5.classList.add('text-right');
                        cgn5.appendChild(document.createTextNode(element['Gas Wells - Inactive - Non-Operated']));
                    let cgn6 = sr1.insertCell(); //.appendChild(document.createTextNode('inactive'));
                        cgn6.classList.add('sidebar-dash-heading');
                        cgn6.innerHTML = inactive;
                    let ctn2 = row.insertCell();
                        ctn2.rowSpan = 2;
                        ctn2.appendChild(document.createTextNode(element['Wells - Non-Operated']));
                    let ctn3 = row.insertCell();
                        ctn3.classList.add('text-right');
                        ctn3.appendChild(document.createTextNode(element['Wells - Active - Non-Operated']));
                    let ctn4 = row.insertCell(); //appendChild(document.createTextNode(active));
                        ctn4.classList.add('sidebar-dash-heading');
                        ctn4.innerHTML = active;
                    let ctn5 = sr1.insertCell();
                        ctn5.classList.add('text-right');
                        ctn5.appendChild(document.createTextNode(element['Wells - Inactive - Non-Operated']));
                    let ctn6 = sr1.insertCell(); //.appendChild(document.createTextNode('inactive'));
                        ctn6.classList.add('sidebar-dash-heading');
                        ctn6.innerHTML = inactive;
                    let ct = row.insertCell();
                        ct.classList.add('text-center');
                        ct.classList.add('font-weight-bolder');
                        ct.rowSpan = 2;
                        ct.colSpan = 3;
                        ct.appendChild(document.createTextNode(element['Company Totals'] + " wells"));
                }
                const sumValues = obj => Object.values(data).reduce((a, b) => a + b);
                console.log(sumValues)
                let fr = f.insertRow();
                let oilWellsOpTotal = 0;
                let gasWellsOpTotal = 0;
                let wellsOpTotal = 0;
                let oilWellsNonOpTotal = 0;
                let gasWellsNonOpTotal = 0;
                let wellsNonOpTotal = 0;
                let compTotal = 0;                
                for(i; i < data.length; i++){
                    console.log(parseInt(data[i]['Oil Wells - Operated']));
                    oilWellsOpTotal += parseInt(data[i]['Oil Wells - Operated']);
                    gasWellsOpTotal += parseInt(data[i]['Gas Wells - Operated']);
                    wellsOpTotal += parseInt(data[i]['Wells - Operated']);
                    oilWellsNonOpTotal += parseInt(data[i]['Oil Wells - Non-Operated']);
                    gasWellsNonOpTotal += parseInt(data[i]['Gas Wells - Non-Operated']);
                    wellsNonOpTotal += parseInt(data[i]['Wells - Non-Operated']);
                    compTotal += parseInt(data[i]['Company Totals']);                
                }
                let fc = fr.insertCell();
                fc.appendChild(document.createTextNode('TOTAL: '));
                
                let f1 = fr.insertCell();
                f1.colSpan = 3;
                f1.classList.add('text-center');
                f1.classList.add('font-weight-bolder');
                f1.appendChild(document.createTextNode(`${oilWellsOpTotal} wells`));
                let f2 = fr.insertCell();
                f2.colSpan = 3;
                f2.classList.add('text-center');
                f2.classList.add('font-weight-bolder');
                f2.appendChild(document.createTextNode(`${gasWellsOpTotal} wells`));
                let f3 = fr.insertCell();
                f3.colSpan = 3;
                f3.classList.add('text-center');
                f3.classList.add('font-weight-bolder');
                f3.appendChild(document.createTextNode(`${wellsOpTotal} wells`));
                let f11 = fr.insertCell();
                f11.colSpan = 3;
                f11.classList.add('text-center');
                f11.classList.add('font-weight-bolder');
                f11.appendChild(document.createTextNode(`${oilWellsNonOpTotal} wells`));
                let f21 = fr.insertCell();
                f21.colSpan = 3;
                f21.classList.add('text-center');
                f21.classList.add('font-weight-bolder');
                f21.appendChild(document.createTextNode(`${gasWellsNonOpTotal} wells`));
                let f31 = fr.insertCell();
                f31.colSpan = 3;
                f31.classList.add('text-center');
                f31.classList.add('font-weight-bolder');
                f31.appendChild(document.createTextNode(`${wellsNonOpTotal} wells`));
                let fct = fr.insertCell();
                fct.colSpan = 3;
                fct.classList.add('text-center');
                fct.classList.add('font-weight-bolder');
                fct.appendChild(document.createTextNode(`${compTotal} wells`));
            }
        }
        class genTable {
            constructor(id, data) {
                this.id = id;
                this.data = data;
            }
        }
        generateTableX = (data) => {
            let table = document.createElement('table');
            table.classList.add('table');
            table.classList.add('table-striped');
            table.classList.add('table-sm');
            table.classList.add('table-hover');
            for (let element of data) {
                let row = table.insertRow();
                for (key in element) {
                let cell = row.insertCell();
                let text = document.createTextNode(element[key]);
                cell.appendChild(text);
                }
            }
            generateTableHead(table, data)
        }
        function tableCreate() {
            this.element;
            }
        tableCreate.prototype = {
            create: function(id, rd) {
                // Remember the element
                this.element = generateTableX(rd);
                // This could be chained to the above,
                // but it's a lot easier to read if it isn't
                let t = document.querySelector(id);
                t.append(this.element);
            },
            destroy: function() {
                this.element.remove();
            }
        }
        class searchResults {
            constructor(props) {
                this.h1 =  document.createElement('h1');
                this.p = document.createElement('p');
                this.div = document.createElement('div');
                this.table = document.createElement('table');
            }
            create(id, rd) {
                let data = Object.keys(rd[0]);
                const resultHeader = document.querySelector('#result-header');
                const results = document.querySelector('#results');
                this.h1.id = 'rh-h1';
                this.h1.classList.add('h2');
                this.p.textContent = 'Search results: '+rd.length+' records found';
                resultHeader.appendChild(this.h1);
                this.h1.appendChild(this.p);
                this.div.id = 'results-div';
                this.div.classList.add('table-responsive');
                results.appendChild(this.div);
                this.table.id = 'results-table';
                this.table.classList.add('table');
                this.table.classList.add('table-striped');
                this.table.classList.add('table-sm');
                this.table.classList.add('table-hover');
                generateTable(this.table, rd)
                generateTableHead(this.table, data);
                this.div.appendChild(this.table);
            }
            report(id, rd, r2 = null, rt = null, reportType, reportName){
                // TODO: Add a print button that only prints this section
                //       Will likely need to create a function that will only print this section
                let data = Object.keys(rd[0]);
                const resultHeader = document.querySelector('#result-header');
                const results = document.querySelector('#results');
                const br = document.createElement('br');
                const info = document.createElement('p');
                const info2 = document.createElement('p');
                const t2 = document.createElement('table');
                const t3 = document.createElement('table');
                const btn = document.createElement('button');
                const d1 = document.createElement('div');
                const d2 = document.createElement('div');
                const d3 = document.createElement('div');
                btn.classList.add('btn');
                btn.classList.add('btn-primary');
                btn.textContent = 'Print Report';
                d1.classList.add('col');
                d2.classList.add('col');
                d3.classList.add('row');
                this.h1.id = 'rh-h1';
                this.h1.classList.add('h2');
                if(reportName.substring(reportName.length - 21) == 'Operated/Non-Operated') // Non-Operated
                {
                    let rName = reportName.length - 21;
                    let name = reportName.substring(0, rName);
                    this.h1.innerHTML = `${name} <span class="h5 sidebar-dash-heading text-muted">Operated/Non-Operated</span>`;   
                }
                else if(reportName.substring(reportName.length - 12) == 'Non-Operated') // Non-Operated
                {
                    let rName = reportName.length - 12;
                    let name = reportName.substring(0, rName);
                    this.h1.innerHTML = `${name} <span class="h5 sidebar-dash-heading text-muted">Non-Operated</span>`;   
                }
                else if(reportName.substring(reportName.length - 8) == 'Operated') // Operated
                {
                    let rName = reportName.length - 8;
                    let name = reportName.substring(0, rName);
                    this.h1.innerHTML = `${name} <span class="h5 sidebar-dash-heading text-muted">Operated</span>`;   
                }
                else {
                    this.h1.textContent = reportName;
                }
                resultHeader.appendChild(this.h1);
                this.div.id = 'results-div';
                this.div.classList.add('table-responsive');
                results.appendChild(this.div);
                this.table.id = 'results-table';
                this.table.classList.add('table');
                this.table.classList.add('table-striped');
                this.table.classList.add('table-sm');
                this.table.classList.add('table-hover');
                if(r2 != null){
                    console.log("is not null");
                    t2.id = 'results-table2';
                    t2.classList.add('table');
                    t2.classList.add('table-striped');
                    t2.classList.add('table-sm');
                    t2.classList.add('table-hover');
                    generateTable(t2, r2);
                }
                if(rt != null){
                    console.log("is not null");
                    t3.id = 'results-table3';
                    t3.classList.add('table');
                    t3.classList.add('table-striped');
                    t3.classList.add('table-sm');
                    t3.classList.add('table-hover');
                    generateTable(t3, rt);
                }
                if(reportType == 1){
                    generateTableHead(this.table, data, 1);
                    generateTable(this.table, rd)
                }
                else if(reportType == 2){
                }
                else if(reportType == 3){
                }
                else if(reportType == 4){
                    generateTableHead(this.table, 1, 2);
                    generateTable(this.table, rd)
                }
                else if(reportType == 5 || reportType == 6 || reportType == 7){
                    generateTableHead(this.table, 1, 3);
                    generateTable(this.table, rd)
                }
                else if(reportType == 8){
                    generateTableHead(this.table, data, 4);
                    generateTable(this.table, rd,1);
                }
                this.div.appendChild(this.table);
                if(reportType == 1){
                }
                else if(reportType == 2){
                }
                else if(reportType == 3){
                }
                else if(reportType == 4){
                    info.textContent = "(undrilled HBP acreage and undeveloped leasehold)";
                    this.div.appendChild(info);
                    this.div.appendChild(br);
                    generateTableHead(t3, 2, 2);
                    this.div.appendChild(br);
                    this.div.appendChild(t3);
                    this.div.appendChild(br);
                    info2.innerHTML = "Gross acreage is the total acres in which a working interest is owned." 
                    info2.innerHTML += "<br>Net acreage is the sum of the fractional working interests owned in gross acreage.";
                    info2.innerHTML += "<br><br>Undeveloped acreage is considered to be those lease acres on which wells have not been drilled or completed to a point that would permit the production of commercial quantities of oil & gas regardless of whether or not such acreage contains proved reserves.";
                    this.div.appendChild(info2);
                    this.div.appendChild(br);
                }
                else if(reportType == 5 || reportType == 6 || reportType == 7){
                    this.div.appendChild(br);
                    generateTableHead(t2, 2, 3);
                    this.div.appendChild(br);
                    this.div.appendChild(t2);
                    this.div.appendChild(br);
                    generateTableHead(t3, 3, 3);
                    this.div.appendChild(t3);
                    this.div.appendChild(br);
                    info.innerHTML = "Gross wells is the total number of wells in which a working interest is owned. <br> Net wells is the sum of the fractional working interests owned in gross wells.";
                    this.div.appendChild(info);
                    this.div.appendChild(br);
                }
                else if(reportType == 8){
                }
                this.p.textContent = generateReportAccess();
                this.div.appendChild(this.p);
            }
            destroy (id, x) {
                this.table.remove();
                this.div.remove();
            }
        }
        WorkZone.prototype = {
            create: (id, rd) => {
                // const data = [
                //     'ID', 'Name', 'County', 'Block' 
                // ]
                let data = Object.keys(rd[0]);
                const resultHeader = document.querySelector('#result-header');
                this.h1 =  document.createElement('h1');
                this.h1.id = 'rh-h1';
                this.h1.classList.add('h2');
                this.p = document.createElement('p');
                this.p.textContent = 'Search results: '+rd.length+' records found';
                resultHeader.appendChild(this.h1);
                this.h1.appendChild(this.p);

                const results = document.querySelector('#results');
                this.div = document.createElement('div');
                this.div.id = 'results-div';
                this.div.classList.add('table-responsive');
                results.appendChild(this.div);
                
                this.table = document.createElement('table');
                this.table.id = 'results-table';
                this.table.classList.add('table');
                this.table.classList.add('table-striped');
                this.table.classList.add('table-sm');
                this.table.classList.add('table-hover');
                generateTable(this.table, rd)
                generateTableHead(this.table, data);
                

                // this.tableHead = document.createElement('thead');
                // this.rTableHead = $('<thead><tr><th>ID</th><th>Name</th><th>County</th><th>Block</th></tr></thead>');
                // this.rTableBody =  $('<tbody>', { id: 'results-body' });
                // this.rHead.appendTo('#result-header');
                // this.rDiv.appendTo('#results');
                // this.rTable.appendTo('#results-div');
                // this.rTableHead.appendTo('#results-table');
                // this.rTableBody.appendTo('#results-table');
                // // Remember the element
                // this.element = $('<div>', {
                //                 id: id,
                //                 class: 'work-zone'
                //             });
                // // This could be chained to the above,
                // // but it's a lot easier to read if it isn't
                // this.element.appendTo('body');
            },
            destroy: (id) => {
                this.element.remove();
            }
        }
        let sr = new searchResults();
        let nt = new tableCreate();
        $('#searchdb.sdb').on("submit", function(event){
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"/ajax/pldb.formsearch.php",  
                type:"POST",  
                success: function(response){
                    console.log(response[0]);
                    console.log(response);
                    console.log(response["data"]);
                    rd = response.data;
                    if(resultTableBool){

                        $("#searchresults").removeClass("d-none");
                        let h = document.querySelector('#result-header');
                        h.removeChild(h.firstChild);
                        let t = document.querySelector('#results');
                        while (t.firstChild){ t.removeChild(t.firstChild); }
                        sr_i++;
                        sr = new searchResults();
                        sr.create(`searchresultjs${sr_i}`, rd);
                        // nt.create('results-div', rd);
                    } else {
                        $("#searchresults").removeClass("d-none");
                        
                        sr.create(`searchresultjs${sr_i}`, rd);
                        // nt.create('#results-div', rd);
                        // var sdt = { "sDom": 't', "order": [], scrollY: 825, 
                        //     scroller: true, "searching": true, "autoWidth": false }
                        // sTable = $('#results-table').DataTable(sdt);
                        resultTableBool = true;
                    }
                    // on a successful search, display
                    // number of records found
                    // then a table with the following columns:
                    // PropertyID | Name | County | Block
                    // set an onClick event to each row
                    // which fires a function to pull up the specific data for that well for editing
                },
                error: function(xhr, status, message) 
                {
                    $('#e-details.error-details').text(xhr.status + " " + status + " - " + message);
                    $('#error.alert').addClass('show');
                },        
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false
            });  
            return false;
        }) 
        $('#editableResults.edb').on("submit", function(event){
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"/ajax/pldb.formupdate.php",  
                type:"POST",  
                success: function(response){
                    console.log(response);
                    Notiflix.Notify.success('You have successfully updated this entry.', {
                        position: 'center-bottom',
                        showOnlyTheLastOne: true,
                    });
                },
                error: function(xhr, status, message) 
                {
                    Notiflix.Notify.failure('Error: ' + xhr.status + " " + status + " - " + message, {
                        position: 'center-bottom',
                        showOnlyTheLastOne: true,
                    });
                    $('#e-details.error-details').text(xhr.status + " " + status + " - " + message);
                    $('#error.alert').addClass('show');
                },        
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false
            });  
            return false;
        }) 
        $('#addpropertydb').on("submit", function(event){
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"/ajax/pldb.formupdate.php",  
                type:"POST",  
                success: function(response){
                    console.log(response);
                    Notiflix.Notify.success('You have successfully updated this entry.', {
                        position: 'center-bottom',
                        showOnlyTheLastOne: true,
                    });
                },
                error: function(xhr, status, message) 
                {
                    Notiflix.Notify.failure('Error: ' + xhr.status + " " + status + " - " + message, {
                        position: 'center-bottom',
                        showOnlyTheLastOne: true,
                    });
                    $('#e-details.error-details').text(xhr.status + " " + status + " - " + message);
                    $('#error.alert').addClass('show');

                },        
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false
            });  
            return false;
        }) 
        $('.pldb-sidebar-form').on("click", function(){
            $(".active").removeClass('active');
            $(this).addClass('active');
        });
        $('.tree-group-link').on("click", function(){
            var feather = $(this).children('svg.feather.feather-chevron-right');
            (feather.hasClass('feather-chevron-rotate'))?feather.removeClass('feather-chevron-rotate'):feather.addClass('feather-chevron-rotate');
        })  
        var hideTables = function() {
            let value = this.dataset.value;
            var valuetable = value + 'table';
            hideActive();
            $(this).addClass('active');
            $('.results').each(function(){ ($(this).attr('id') != value)? $(this).addClass('d-none') : $(this).removeClass('d-none'); })
            $('.dtables').each(function(){ ($(this).attr('id') != valuetable) ? $(this).addClass('d-none') : $(this).removeClass('d-none'); })
            $('#'+value+'_wrapper > div > div.dataTables_scrollHead > div > table').hasClass('d-none') && $('#'+value+'_wrapper > div > div.dataTables_scrollHead > div > table').removeClass('d-none')
        }
        let pldbSidebarTable = document.querySelectorAll(".pldb-sidebar-table");
        for (var i = 0; i < pldbSidebarTable.length; i++) { 
            pldbSidebarTable[i].addEventListener('click', function(event) {
                let value = this.dataset.value;
                hideTables.call(this);
                if(isSidebarVis){ toggleVis(sidebar); tableload(value); } else { tableload(value); }
            })
        }
        let queriesSidebar = document.querySelectorAll("#queriesSidebar");
        for (var i = 0; i < queriesSidebar.length; i++) { 
            queriesSidebar[i].addEventListener('click', function(event) {
                hideActive();
                $(this).addClass('active');
            })
        }
        let reportsSidebar = document.querySelectorAll("#reportsSidebar");
        for (var i = 0; i < reportsSidebar.length; i++) { 
            reportsSidebar[i].addEventListener('click', function(event) {
                hideActive();
                $(this).addClass('active');
            })
        }
        let dataquery = document.querySelectorAll(".dataquery");
        for (var i = 0; i < dataquery.length; i++) {
            dataquery[i].addEventListener('click', function(event) {
                isSidebarVis && toggleVis(sidebar);
                hideTables.call(this);
                var datacol = {};
                var qvalue = '"'+this.dataset.query+'"';
                var qvalue = this.dataset.query;
                postData("/ajax/pldb.queryload.php", {"query": qvalue})
                .then(
                    response => {
                        try{ rd = response.data;  }
                        catch (error){ Notiflix.Notify.failure('Error: ' + error, { position: 'center-bottom', showOnlyTheLastOne: true }) }
                        if(rd === undefined)
                        {
                            Notiflix.Notify.failure('Error: No data returned.', 
                            {
                                position: 'center-bottom',
                                showOnlyTheLastOne: true,
                            })
                        }
                        else 
                        {
                            if(resultTableBool)
                            {
                                $("#searchresults").removeClass("d-none");
                                let h = document.querySelector('#result-header');
                                h.removeChild(h.firstChild);
                                let t = document.querySelector('#results');
                                while (t.firstChild){ t.removeChild(t.firstChild); }
                                sr_i++;
                                sr = new searchResults();
                                sr.create(`searchresultjs${sr_i}`, rd);
                            }
                            else 
                            {
                                $("#searchresults").removeClass("d-none");
                                sr.create(`searchresultjs${sr_i}`, rd);
                                resultTableBool = true;
                            }
                        }
                }, error => {
                    Notiflix.Notify.failure('Error: ' + error, {
                        position: 'center-bottom',
                        showOnlyTheLastOne: true,
                    })
                })
            })}
        let datareport = document.querySelectorAll(".datareport");
        for (var i = 0; i < datareport.length; i++) {
            datareport[i].addEventListener('click', function(event) {
                isSidebarVis && toggleVis(sidebar);
                hideTables.call(this);
                let editresults = document.getElementById("editresults");
                editresults.classList.add('d-none');
                var value = this.dataset.query;
                $(this).addClass('active');
                var datacol = {};
                var rvalue = '"'+this.dataset.report+'"';
                var rvalue = this.dataset.report;
                var name = this.innerText;
                postData("/ajax/pldb.reportload.php", {"report": rvalue})
                .then(
                    response => {
                        try{
                            rd = response.data;
                            r2 = response.data2;
                            rt = response.total;
                        }
                        catch (error){
                            Notiflix.Notify.failure('Error: ' + error, {
                                position: 'center-bottom',
                                showOnlyTheLastOne: true,
                            })
                        }
                        if(rd === undefined)
                        {
                            Notiflix.Notify.failure('Error: No data returned.', 
                            {
                                position: 'center-bottom',
                                showOnlyTheLastOne: true,
                            })
                        }
                        else 
                        {
                            if(resultTableBool)
                            {
                                
                                $("#searchresults").removeClass("d-none");
                                btn.parentElement.classList.remove('d-none');
                                let h = document.querySelector('#result-header');
                                h.removeChild(h.firstChild);
                                let t = document.querySelector('#results');
                                while (t.firstChild){ t.removeChild(t.firstChild); }
                                sr_i++;
                                sr = new searchResults();
                                sr.report(`searchresultjs${sr_i}`, rd, r2, rt, rvalue, name);
                            }
                            else 
                            {
                                console.log(`the report clicked is ${name}`)
                                $("#searchresults").removeClass("d-none");
                                btn.parentElement.classList.remove('d-none');
                                sr.report(`searchresultjs${sr_i}`, rd, r2, rt, rvalue, name);
                                resultTableBool = true;
                            }
                        }
                }, error => {
                    Notiflix.Notify.failure('Error: ' + error, {
                        position: 'center-bottom',
                        showOnlyTheLastOne: true,
                    })
                })
                return false;
                });
        }
    })
    addEvent(document, 'click', '.results-property', function(e){
        let id = this.id;
        try{ document.querySelector('tr.table-info').classList.remove("table-info"); } catch(e){ console.log(`Error: ${e}`); }
        document.getElementById(id).classList.add("table-info");
        $.ajax({  
            url:"/ajax/pldb.editdata.php",  
            method:"POST",  
            data:{id:id},  
            dataType:"json",  
            success:function(response){  
                document.querySelector('.edit-results').classList.remove('d-none');
                document.querySelector("#editresults").classList.remove('d-none');
                rd = response.data;
                console.log(response);
                // console.log(rd[0]['id']);
                document.querySelector('#edit-input-1').value = rd[0]['id'];
                document.querySelector('#edit-input-2').value = rd[0]['location_id'];
                document.querySelector('#edit-input-3').value = rd[0]['name'];
                document.querySelector('#edit-input-4').value = rd[0]['wi'];
                document.querySelector('#edit-input-5').value = rd[0]['gwi_value'];
                document.querySelector('#edit-input-6').value = rd[0]['status'];
                document.querySelector('#edit-input-7').value = rd[0]['ri'];
                document.querySelector('#edit-input-8').value = rd[0]['nri_value'];
                document.querySelector('#edit-input-9').value = rd[0]['operating_status'];
                document.querySelector('#edit-input-10').value = rd[0]['orri'];
                document.querySelector('#edit-input-11').value = rd[0]['orri_value'];
                document.querySelector('#edit-input-12').value = rd[0]['owning_company'];
                document.querySelector('#edit-input-13').value = rd[0]['biapo'];
                document.querySelector('#edit-input-14').value = rd[0]['ri_values'];
                document.querySelector('#edit-input-15').value = rd[0]['operator'];
                document.querySelector('#edit-input-16').value = rd[0]['wbo'];
                document.querySelector('#edit-input-17').value = rd[0]['legal_description'];
                document.querySelector('#edit-input-18').value = rd[0]['gross_acres'];
                document.querySelector('#edit-input-19').value = rd[0]['api'];
                document.querySelector('#edit-input-20').value = rd[0]['net_acres'];
                document.querySelector('#edit-input-21').value = rd[0]['lease_number'];
                document.querySelector('#edit-input-22').value = rd[0]['wp_code'];

            }
        })
    })
    addEvent(document, 'click', '.pldb-sidebar-form', function(e){
        // console.dir(e);
        // console.dir(this.dataset.value);
        // console.log(e.path[0]);
        // console.dir(this.id);
        // console.log(`this: ${this}\ne: ${e}\ne.target: ${e.target}`)
        // var value = document.querySelector(e.path[0]).data('value');
        let value = this.dataset.value;
        document.querySelector('#btnUpdate').value = 'Add';
        let nList = document.querySelectorAll('.sdb');
        let forms = document.querySelectorAll('.forms');
        // console.log(nList);
        // console.dir(nList);
        nList.forEach(element => {
            // console.log(forms);
            // console.dir(forms);
            // console.dir(element.id);
            // (document.querySelector(this).attr('id') != value) ? document.querySelector(this).classList.add('d-none') : document.querySelector(this).classList.remove('d-none');
            (element.id != value) ? element.classList.add('d-none') : element.classList.remove('d-none');
            forms.forEach(element => {
                element.classList.add('d-md-block')
                element.classList.contains('d-none') && element.classList.remove('d-none');
            })
            // forms.
            // document.querySelector('.forms').classList.add('d-md-block').classList.remove('d-none');
        })
        // nList.each(function(){

            
        // })
    })
</script>
</head>
<body class="dash">
<?php  include($_SERVER['DOCUMENT_ROOT'] . '/include/header_extensions.php'); ?>
<div id="react_pldb"></div>
<div id="main-div" class="ch">
    <div id="print-div"></div>      
    <main id="main-main" role="main" class="ch">
        <nav id="pldb-nav" class="ch navbar navbar-dark navbar-dash navbar-dash-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand navbar-dash-brandboard navbar-dash-brandboard col col--md-3 col--lg-2 mr-0 px-3" href="#">Property Listing Database</a>
            <button class="navbar-toggler navbar-dash-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Toggle navigation">
                <span class="navbar-toggle-icon navbar-dash-toggler-icon"></span>
            </button>
            <!-- <input class="form-control-dash form-control-dash-dark w-100" type="text" placeholder="Search" aria-label="Search">
            <ul class="navbar-dash nav-dash px-3">
                <li class="nav-dash-item nav-item text-nowrap">
                <a class="nav-dash-link nav-link" href="#">Sign out</a>
                </li>
            </ul> -->
        </nav>
        <style>
            .display-block {
                display: block;
            }
            .table-border-bottom-white {
                border-bottom: 3px solid #fff !important;
            }
            .table-border-left {
                border-left-color: rgb(222, 226, 230);
                border-left-style: solid;
                border-left-width: 2px;
            }
            .table-border-right {
                border-right-color: rgb(222, 226, 230);
                border-right-style: solid;
                border-right-width: 2px;
            }
            .fake-a {
                /* color: #fff!important; */
                cursor: pointer!important;
            }
            .fake-a:hover {
                /* color: #00 */
                border-radius: 0.25rem 0 0 0.25rem!important;
                background-color: rgba(0,0,0,0.1);
            }
            .vh-40 {
                height: 40vh!important;
            }
            .sidebar-dash .nav-dash-link:hover .fas {
                color: inherit;
            }
            .sidebar-dash .nav-dash-link .fas {
                margin-right: 4px;
                color: #999;
            }
            .nav-link.nav-dash-link:hover {
                border-radius: .25rem 0 0 .25rem!important;
                background-color: rgba(0,0,0,0.1);
            }
            .feather-chevron-rotate {
                transform: rotate(90deg);
                transition: 500ms;
            }
            .feather-chevron-right {
                transition: 500ms;
            }
            .feather-chevron-rotate-back {
                transform: rotate(-90deg);
                transition: 500ms;
            }

            .tree-link:focus,
            .tree-link.active {
            color: black;
            background-color: #f9fafb;
            }

            .tree-link:hover,
            .tree-group-link:hover {
            background-color: rgba(0,0,0,0.1);
            }

            .no-transition{
            transition: none !important;
            }
            .sidebar-dash .nav-dash-link.active {
                color: #007bff;
                background-color: rgba(0,0,0,0.1);
                border-radius: .25rem 0 0 .25rem!important;
            }
            /* a:not(.collapsed) > .sidebar-rounded {
                color: #007bff;
                background-color: rgba(0,0,0,0.1);
                border-radius: .25rem 0 0 .25rem!important;
            }
            .nav-dash.nav-dash-link:not(.collapsed){
                color: #007bff;
                background-color: rgba(0,0,0,0.1);
                border-radius: .25rem 0 0 .25rem!important;
            } */
            .closebtn a:hover {
            color: #f1f1f1;
            }
            .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
            }
            .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #111;
            color: white;
            padding: 10px 15px;
            border: none;
            }
            .openbtn:hover {
            background-color: #444;
            }
            #toggle {
                display:block;
                /* font-size: 50px; */
                transition: all 0.5s;
                background-color: #333;
                color: white;
                padding: 10px 15px;
                position:absolute;
                z-index: 1;
            }
            #toggle-icon {
                transition: all 0.5s;
            }
            /* #toggle.enter{
                opacity: 1;
                left: 0;
            } */
            #open {
            display:none;
            }
            /* .translate-rotate {
            background-color: gold;
            transform: translateX(180px) rotate(45deg);
            } */
            .rotate {
                transform:rotate(180deg);
            }
            /* #sidebar {
                transition: all 0.25s;
                animation: fade_in_show 0.5s;
            } */
            #fakesidebar.visible {
                opacity: 1;
                /* left: 0; */
            }

            /* #fakesidebar:not(.visible){
                animation: fade_in_show 0.5s;
            } */

            /* .fake-sidebar:not(.visible) {
                            left: -${sidebarwidth-sidebarCloseWidth}px;
                            animation: fade_in_show 1000ms;
                            animation-timing-function: linear;
                        }
                        @keyframes fade_in_show {
                            from {
                                transform: translateX(0%)
                            }

                            to {
                                transform: translateX(-100%)
                            }
                        }
                        #slider {
                            position: absolute;
                            width: 100px;
                            height: 100px;
                            background: blue;
                            transform: translateX(-100%);
                            -webkit-transform: translateX(-100%);
                        } */
            @keyframes fade_n_show {
                0% {
                    opacity: 0;
                    transform: scale(0);
                    /* transform: translateX(0%) */
                }

                100% {
                    opacity: 1;
                    /* transform: translateX(0%) */
                    transform: scale(1);
                }
            } 
            /* @keyframes fade_in_show {
                from {
                    transform: translateX(0%)
                }

                to {
                    transform: translateX(-100%)
                }
            } */
        </style>
        <div id="main-dash" class="container-fluid ch">
            <div id="main-row" class="row ch">
                <nav id="sidebarMenu" class="ch col-md-3 col-lg-2 d-md--block display-block bg-light sidebar-dash co-llapse enter">
                    <div class="sidebar-dash-sticky pt-3">
                        <ul class="nav nav-dash flex-column">
                            <li class="nav-dash-item nav-item">
                                <a class="pldb-sidebar-form nav-dash-link nav-link active" data-value="searchdb" href="#">
                                <span data-feather="search"></span>
                                Search PLDB
                                </a>
                            </li>
                            <li class="nav-dash-item nav-item">
                                <a class="pldb-sidebar-form nav-dash-link nav-link" data-value="addlocationdb" href="#">
                                <span data-feather="map-pin"></span>
                                Add Location
                                </a>
                            </li>
                            <li class="nav-dash-item nav-item">
                                <a class="pldb-sidebar-form nav-dash-link nav-link" data-value="addpropertydb" href="#">
                                <span data-feather="home"></span>
                                Add Property
                                </a>
                            </li>
                        </ul>
                        
                        <div class="nav nav-dash flex-column" id="queriesSidebar">
                            <a class="fake-a text-muted sidebar-rounded dropdown sidebar-dash-heading d-flex justify-content-between align-items-center px-3 mt-2 py-2 mb-1" href="#queries" data-toggle="collapse">
                                <span>Queries</span><span data-feather="menu"></span>
                            </a>
                        </div>
                        <div class="collapse" id="queries">
                            <ul id="collapsequeries" class="flex-column mb-2">
                                <li class="nav-dash-item nav-item">
                                    <a class="nav-dash-link nav-link dataquery" data-query='0' href="#">
                                    <span data-feather="list"></span>
                                    All Bald Prairie N
                                    </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                    <a class="nav-dash-link nav-link dataquery" data-query='1' href="#">
                                    <span data-feather="list"></span>
                                    All Properties
                                    </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                    <a class="nav-dash-link nav-link dataquery" data-query='2' href="#">
                                        <span data-feather="list"></span>
                                        East Texas
                                    </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                    <a class="nav-dash-link nav-link dataquery" data-query='3' href="#">
                                        <span data-feather="list"></span>
                                        SDC - Active Gas Wells
                                    </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='4' href="#">
                                    <span data-feather="list"></span>
                                    SDC - Active Oil Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='5' href="#">
                                    <span data-feather="list"></span>
                                    SDC - SI Gas Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='6' href="#">
                                    <span data-feather="list"></span>
                                    SDC - SI Oil Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='7' href="#">
                                    <span data-feather="list"></span>
                                    SDC Acres
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='8' href="#">
                                    <span data-feather="list"></span>
                                    SDC Acres Non-Operated
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='9' href="#">
                                    <span data-feather="list"></span>
                                    SDC Acres Operated
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='10' href="#">
                                    <span data-feather="list"></span>
                                    SDC Developed Gross Acreage
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='11' href="#">
                                    <span data-feather="list"></span>
                                    SDC Developed Net Acreage
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='12' href="#">
                                    <span data-feather="list"></span>
                                    SDC Undeveloped Gross Acreage
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='13' href="#">
                                    <span data-feather="list"></span>
                                    SDC Undeveloped Net Acreage
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='14' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Acres Operated ar
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='15' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Active Gas Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='16' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Active Oil Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='17' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres in North Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='18' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in Alabama
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='19' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in Arkansas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='20' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in California
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='21' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in East Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='22' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in Gulf Coast texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='23' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in Louisiana
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='24' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in New mexico
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='25' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in North Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='26' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in Oklahoma
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='27' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in Panhandle texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='28' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Non-Operated Properties in West Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='29' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in Alabama
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='30' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in Arkansas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='31' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in California
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='32' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in East Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='33' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in Gulf Coast texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='34' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in Louisiana
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='35' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in New mexico
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='36' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in North Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='37' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in Oklahoma
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='38' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in Panhandle texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='39' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Gross Acres of Operated Properties in West Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='40' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres in North Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='41' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in Alabama
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='42' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in Arkansas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='43' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in California
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='44' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in East Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='45' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in Gulf Coast texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='46' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in Louisiana
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='47' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in New mexico
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='48' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in North Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='49' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in Oklahoma
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='50' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in Panhandle texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='51' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Non-Operated Properties in West Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='52' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in Alabama
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='53' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in Arkansas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='54' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in California
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='55' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in East Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='56' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in Gulf Coast Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='57' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in Louisiana
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='58' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in New Mexico
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='59' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in North Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='60' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in Oklahoma
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='61' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in Panhandle Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='62' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Acres of Operated Properties in West Texas
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='63' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Net Active Gas Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='64' href="#">
                                    <span data-feather="list"></span>
                                    SOG - SI Gas Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='65' href="#">
                                    <span data-feather="list"></span>
                                    SOG - SI Oil Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='66' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Total Gross Acres
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='67' href="#">
                                    <span data-feather="list"></span>
                                    SOG - Total Net Acres
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='68' href="#">
                                    <span data-feather="list"></span>
                                    SOG & SDC - Total Active Gas Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='69' href="#">
                                    <span data-feather="list"></span>
                                    SOG & SDC - Total Active Oil Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='70' href="#">
                                    <span data-feather="list"></span>
                                    SOG & SDC - Total Gas Wells (Active & SI)
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='71' href="#">
                                    <span data-feather="list"></span>
                                    SOG & SDC - Total Oil Wells (Active & SI)
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='72' href="#">
                                    <span data-feather="list"></span>
                                    SOG & SDC - Total SI Gas Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='73' href="#">
                                    <span data-feather="list"></span>
                                    SOG & SDC - Total SI Oil Wells
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='74' href="#">
                                    <span data-feather="list"></span>
                                    SOG Acres
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='75' href="#">
                                    <span data-feather="list"></span>
                                    SOG Acres Non-Operated
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='76' href="#">
                                    <span data-feather="list"></span>
                                    SOG Acres Non-Operated al
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='77' href="#">
                                    <span data-feather="list"></span>
                                    SOG Acres Non-Operated ar
                                </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                <a class="nav-dash-link nav-link dataquery" data-query='78' href="#">
                                    <span data-feather="list"></span>
                                    SOG Acres Non-Operated ca
                                </a>
                                </li>
                                <!-- <li class="nav-dash-item nav-item " id="sdc-queries">
                                    <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed sidebar-dash-heading d-flex justify-content-between align-items-center sidebar-rounded" id="tree-link-sdc-queries" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sdc-queries">
                                        <span class="d-inline-block text-center tree-icon" data-feather="menu"></span>
                                        <span>SDC</span><span data-feather="chevron-right"></span>
                                    </a>
                                    <div class="ml-4 collapse" id="nav-tree-list-wrapper-sdc-queries" name="new">
                                        <ul class="flex-column mb-2">
                                            <li id="sdc-well-queries" class="nav-item">
                                                <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sdc-well" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sdc-well">
                                                    <span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                    Wells
                                                </a>
                                                <div class="ml-4 collapse" id="nav-tree-list-wrapper-sdc-well">
                                                    <ul class="flex-column mb-2">
                                                    <li id="sdc-well-active" class="nav-item">
                                                        <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sdc-well-active" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sdc-well-active"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                            Active
                                                        </a>
                                                        <div class="ml-4 collapse" id="nav-tree-list-wrapper-sdc-well-active">
                                                            <ul class="flex-column mb-2">
                                                                <li id="sdc-well-active-gas" class="nav-item active">
                                                                <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-well-active-gas"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-well-active-gas"></i></span>
                                                                    Gas
                                                                </a>
                                                                </li>
                                                                <li id="sdc-well-active-oil" class="nav-item active">
                                                                <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-well-active-oil"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-well-active-oil"></i></span>
                                                                    Oil
                                                                </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li id="sdc-well-si" class="nav-item">
                                                        <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sdc-well-si" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sdc-well-si"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                            Shut-in
                                                        </a>
                                                        <div class="ml-4 collapse" id="nav-tree-list-wrapper-sdc-well-si">
                                                            <ul class="flex-column mb-2">
                                                                <li id="sdc-well-si-gas" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-well-si-gas"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-well-si-gas"></i></span>
                                                                        Gas
                                                                    </a>
                                                                </li>
                                                                <li id="sdc-well-si-oil" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-well-si-oil"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-well-si-oil"></i></span>
                                                                        Oil
                                                                    </a>
                                                                </li> 
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </div>
                                            </li>
                                            <li id="sdc-acre-queries" class="nav-item">
                                                <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sdc-acre" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sdc-acre">
                                                    <span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                    Acreage
                                                </a>
                                                <div class="ml-4 collapse" id="nav-tree-list-wrapper-sdc-acre">
                                                    <ul class="flex-column mb-2">
                                                        <li id="sdc-acre-all" class="nav-item">
                                                            <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sdc-acre-all" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sdc-acre-all"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                                All Acreage
                                                            </a>
                                                            <div class="ml-4 collapse" id="nav-tree-list-wrapper-sdc-acre-all">
                                                                <ul class="flex-column mb-2">
                                                                <li id="sdc-acre" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-acre"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-acre"></i></span>
                                                                        Acres
                                                                    </a>
                                                                    </li>
                                                                    <li id="sdc-acre-nonop" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-acre-nonop"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-acre-nonop"></i></span>
                                                                        Acres&nbsp;<span class="d-flex align-items-center text-muted">Non-Operated</span>
                                                                    </a>
                                                                    </li>
                                                                    <li id="sdc-acre-op" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-acre-op"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-acre-op"></i></span>
                                                                        Acres&ensp;<span class="d-flex align-items-center text-muted">Operated</span>
                                                                    </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li id="sdc-acre-dev" class="nav-item">
                                                            <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sdc-acre-dev" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sdc-acre-dev"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                                Developed
                                                            </a>
                                                            <div class="ml-4 collapse" id="nav-tree-list-wrapper-sdc-acre-dev">
                                                                <ul class="flex-column mb-2">
                                                                    <li id="sdc-acre-dev-gross" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-acre-dev-gross"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-acre-dev-gross"></i></span>
                                                                        Gross Acreage
                                                                    </a>
                                                                    </li>
                                                                    <li id="sdc-acre-dev-net" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-acre-dev-net"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-acre-dev-net"></i></span>
                                                                        Net Acreage
                                                                    </a>
                                                                    </li> 
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li id="sdc-acre-undev" class="nav-item">
                                                            <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sdc-acre-undev" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sdc-acre-undev"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                                Undeveloped
                                                            </a>
                                                            <div class="ml-4 collapse" id="nav-tree-list-wrapper-sdc-acre-undev">
                                                                <ul class="flex-column mb-2">
                                                                    <li id="sdc-acre-undev-gross" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-acre-undev-gross"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-acre-undev-gross"></i></span>
                                                                        Gross Acreage
                                                                    </a>
                                                                    </li>
                                                                    <li id="sdc-acre-undev-net" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sdc-acre-undev-net"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sdc-acre-undev-net"></i></span>
                                                                        Net Acreage
                                                                    </a>
                                                                    </li> 
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-dash-item nav-item " id="sog-queries">
                                    <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed sidebar-dash-heading d-flex justify-content-between align-items-center sidebar-rounded" id="tree-link-sog-queries" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sog-queries">
                                        <span class="d-inline-block text-center tree-icon" data-feather="menu"></span>
                                        <span>SOG</span><span data-feather="chevron-right"></span>
                                    </a>
                                    <div class="ml-4 collapse" id="nav-tree-list-wrapper-sog-queries" name="new">
                                        <ul class="flex-column mb-2">
                                            <li id="sog-well-queries" class="nav-item">
                                                <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sog-well" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sog-well">
                                                    <span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                    Wells
                                                </a>
                                                <div class="ml-4 collapse" id="nav-tree-list-wrapper-sog-well">
                                                    <ul class="flex-column mb-2">
                                                    <li id="sog-well-active" class="nav-item">
                                                        <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sog-well-active" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sog-well-active"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                            Active
                                                        </a>
                                                        <div class="ml-4 collapse" id="nav-tree-list-wrapper-sog-well-active">
                                                            <ul class="flex-column mb-2">
                                                                <li id="sog-well-active-gas" class="nav-item active">
                                                                <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='15' id="tree-link-sog-well-active-gas"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-well-active-gas"></i></span>
                                                                    Gas
                                                                </a>
                                                                </li>
                                                                <li id="sog-well-active-oil" class="nav-item active">
                                                                <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='16' id="tree-link-sog-well-active-oil"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-well-active-oil"></i></span>
                                                                    Oil
                                                                </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li id="sog-well-si" class="nav-item">
                                                        <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sog-well-si" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sog-well-si"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                            Shut-in
                                                        </a>
                                                        <div class="ml-4 collapse" id="nav-tree-list-wrapper-sog-well-si">
                                                            <ul class="flex-column mb-2">
                                                                <li id="sog-well-si-gas" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sog-well-si-gas"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-well-si-gas"></i></span>
                                                                        Gas
                                                                    </a>
                                                                </li>
                                                                <li id="sog-well-si-oil" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sog-well-si-oil"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-well-si-oil"></i></span>
                                                                        Oil
                                                                    </a>
                                                                </li> 
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </div>
                                            </li>
                                            <li id="sog-acre-queries" class="nav-item">
                                                <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sog-acre" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sog-acre">
                                                    <span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                    Acreage
                                                </a>
                                                <div class="ml-4 collapse" id="nav-tree-list-wrapper-sog-acre">
                                                    <ul class="flex-column mb-2">
                                                        <li id="sog-acre-all-op" class="nav-item">
                                                            <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sog-acre-all-op" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sog-acre-all-op"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                                Operated
                                                            </a>
                                                            <div class="ml-4 collapse" id="nav-tree-list-wrapper-sog-acre-all-op">
                                                                <ul class="flex-column mb-2">
                                                                <li id="sog-acre" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sog-acre"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre"></i></span>
                                                                        Acres
                                                                    </a>
                                                                    </li>
                                                                    <?php
                                                                    
                                                                    ?>
                                                                    <li id="sog-acre-nonop" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sog-acre-nonop"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-nonop"></i></span>
                                                                        Acres&nbsp;<span class="d-flex align-items-center text-muted">Non-Operated</span>
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-al" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-al"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-al"></i></span>
                                                                        Alabama
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-ar" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-ar"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-ar"></i></span>
                                                                        Arkansas
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-ca" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-ca"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-ca"></i></span>
                                                                        California
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-etx" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-etx"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-etx"></i></span>
                                                                        East Texas
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-gctx" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-gctx"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-gctx"></i></span>
                                                                        Gulf Coast Texas
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-la" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-la"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-la"></i></span>
                                                                        Louisiana
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-ntx" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-ntx"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-tx"></i></span>
                                                                        North Texas
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-nm" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-nm"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-nm"></i></span>
                                                                        New Mexico
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-ok" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-ok"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-ok"></i></span>
                                                                        Oklahoma
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-phtx" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op-phtx"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op-phtx"></i></span>
                                                                        Panhandle Texas
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-op-wtx" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='sog-acres-op' id="tree-link-sog-acre-op"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-op"></i></span>
                                                                        West Texas
                                                                    </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sog-acre-all-nonop" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sog-acre-all-nonop"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                                Non-Operated
                                                            </a>
                                                            <div class="ml-4 collapse" id="nav-tree-list-wrapper-sog-acre-all-nonop">
                                                                <ul id="sog-acre-nonop-group" class="flex-column mb-2">
                                                                    <li id="sog-acre-Total-nonop" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sog-acre"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre"></i></span>
                                                                        Acres
                                                                    </a>
                                                                    </li>
                                                                    <?php
                                                                    
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li id="sog-acre-gross" class="nav-item">
                                                            <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sog-acre-gross" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sog-acre-gross"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                                Developed
                                                            </a>
                                                            <div class="ml-4 collapse" id="nav-tree-list-wrapper-sog-acre-gross">
                                                                <ul class="flex-column mb-2">
                                                                    <li id="sog-acre-gross-ntx" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" data-query='15' id="tree-link-sog-acre-gross-ntx"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-gross-ntx"></i></span>
                                                                        Gross Acreage
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-gross-net" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sog-acre-gross-net"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-gross-net"></i></span>
                                                                        Net Acreage
                                                                    </a>
                                                                    </li> 
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li id="sog-acre-undev" class="nav-item">
                                                            <a class="nav-link nav-dash-link d-inline-block tree-group-link collapsed" id="tree-link-sog-acre-undev" data-toggle="collapse" role="button" href="#nav-tree-list-wrapper-sog-acre-undev"><span class="d-inline-block text-center tree-icon" data-feather="chevron-right" style="width: 25px;"></span>
                                                                Undeveloped
                                                            </a>
                                                            <div class="ml-4 collapse" id="nav-tree-list-wrapper-sog-acre-undev">
                                                                <ul class="flex-column mb-2">
                                                                    <li id="sog-acre-undev-gross" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sog-acre-undev-gross"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-undev-gross"></i></span>
                                                                        Gross Acreage
                                                                    </a>
                                                                    </li>
                                                                    <li id="sog-acre-undev-net" class="nav-item active">
                                                                    <a href="#" class="nav-link nav-dash-link d-inline-block tree-link" id="tree-link-sog-acre-undev-net"><span class="d-inline-block text-center tree-icon" style="width: 25px;"><i class="fas fa-link" id="tree-icon-sog-acre-undev-net"></i></span>
                                                                        Net Acreage
                                                                    </a>
                                                                    </li> 
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li> -->
                            </ul>
                        </div>
                        <a id="reportsSidebar" data-toggle="collapse" href="#reports">
                            <h6 class="fake-a sidebar-dash-heading d-flex justify-content-between align-items-center px-3 py-2 mb-1 text-muted">
                                <span>Reports</span><span data-feather="book"></span>
                            </h6>
                        </a>
                        <div class="collapse" id="reports">
                            <ul class="nav-dash flex-column mb-2">
                                <!-- <li class="ml-4 nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="0">
                                    <span data-feather="file-text"></span>
                                    Summary Report
                                    </a>
                                </li> -->
                                <li class="ml-4 nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="1">
                                    <span data-feather="file-text"></span>
                                    SOG Regions Report
                                    </a>
                                </li>
                                <!-- <li class="nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="2">
                                    <span data-feather="file-text"></span>
                                    SDC Acreage
                                    </a>
                                </li>
                                <li class="nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="3">
                                    <span data-feather="file-text"></span>
                                    SOG Acreage
                                    </a>
                                </li> -->
                                <li class="ml-4 nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="4">
                                    <span data-feather="file-text"></span>
                                    SOG + SDC Acreage
                                    </a>
                                </li>
                                <li class="ml-4 nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="5">
                                    <span data-feather="file-text"></span>
                                    SOG + SDC Well Status
                                    </a>
                                </li>
                                <li class="ml-4 nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="6">
                                    <span data-feather="file-text"></span>
                                    SOG + SDC Well Status<span class="d-flex align-items-center text-muted">Non-Operated</span>
                                    </a>
                                </li>
                                <li class="ml-4 nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="7">
                                    <span data-feather="file-text"></span>
                                    SOG + SDC Well Status<span class="d-flex align-items-center text-muted">Operated</span>
                                    </a>
                                </li>
                                <!-- <li class="ml-4 nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="9">
                                    <span data-feather="file-text"></span>
                                    SOG + SDC Acreage<span class="d-flex align-items-center text-muted">CMM</span>
                                    </a>
                                </li> -->
                                <li class="ml-4 nav-dash-item nav-item">
                                    <a class="datareport nav-dash-link nav-link" href="#" data-report="8">
                                    <span data-feather="file-text"></span>
                                    Well Summary Report<span class="d-flex align-items-center text-muted">Operated/Non-Operated</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <h6 class="sidebar-dash-heading d-flex justify-content-between align-items-center px-3 py-2 mb-1 text-muted">
                            <span>Tables</span><span data-feather="layers"></span>
                        </h6>
                        <ul class="nav nav-dash flex-column">
                            <li class="ml-4 nav-dash-item nav-item">
                                <a class="pldb-sidebar-table nav-dash-link nav-link" data-value="location" id="sidebarlocation" href="#">
                                <span data-feather="map"></span>
                                Locations
                                </a>
                            </li>
                            <li class="ml-4 nav-dash-item nav-item">
                                <a class="pldb-sidebar-table nav-dash-link nav-link" data-value="property" id="sidebarproperty" href="#">
                                <span data-feather="globe"></span>
                                Properties
                                </a>
                            </li>
                            <li class="ml-4 nav-dash-item nav-item">
                                <a class="pldb-sidebar-table nav-dash-link nav-link" data-value="opstatus" id="sidebaropstatus" href="#">
                                <span data-feather="book-open"></span>
                                Operating Status Lookup
                                </a>
                            </li>
                            <li class="ml-4 nav-dash-item nav-item">
                                <a class="pldb-sidebar-table nav-dash-link nav-link" data-value="owncomp" id="sidebarowncomp" href="#">
                                <span data-feather="book-open"></span>
                                Owning Company Lookup
                                </a>
                            </li>
                            <li class="ml-4 nav-dash-item nav-item">
                                <a class="pldb-sidebar-table nav-dash-link nav-link" data-value="status" id="sidebarstatus" href="#">
                                <span data-feather="book-open"></span>
                                Status Lookup
                                </a>
                            </li>
                            <li class="ml-4 nav-dash-item nav-item">
                                <a class="pldb-sidebar-table nav-dash-link nav-link" data-value="update" id="sidebarupdate" href="#">
                                <span data-feather="clock"></span>
                                Update History
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                
                <div id="sidebar" class="ch forms pt-4 col-md-4 col-lg-4 d-md--block display--block bg-dark sidebar-dash co-llapse pr-5 visible">
                    
                    <form id="searchdb" class="sdb" method="POST" enctype="multipart/form-data">
                        <div class="container">
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Name</label></div>
                                <div class="col">
                                    <select id="input1" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchtypeName" size="1" title="Search Type..." data-style="btn-primary btn-sm">
                                        <option value="equals" data-token="Equals">Equals</option>
                                        <option value="begins" data-token="Begins With">Begins With</option>
                                        <option value="contains" data-token="Contains">Contains</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input id="input1b" name="searchName" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                            </div>
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input2">State</label></div>
                                <div class="col">
                                    <select id="input2" class="strState" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchState" size="1" title="Select State..." data-style="btn-primary btn-sm">
                                        <option value="ALL">All</option>
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
                                <select disabled id="strCountyParishFake" class="" data-live-search="true" data-width="100%" data-size="5" width='auto' name="searchCountyFake" size="1" title="Please select a state..." data-style="btn-primary btn-sm"></select>    
                                    <!-- <select id="input3" class="strCountyParishFake selectpicker" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Search Type..." data-style="btn-primary btn-sm">
                                        
                                    </select> -->
                                </div>
                                
                            </div>
                            <div id="county_drop_down" class="row pr-5 hidden">
                                <div class="col-4 text-right "><label id="label2b" class="my-1 mr-2 text-white labelCounty" for="input3">County</label></div>
                                <div class="col">
                                    <select id="input3" class="strCountyParish" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchCounty" size="1" title="Select County..." data-style="btn-primary btn-sm">
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
                                    <select id="input4" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchtypeBlock" size="1" title="Search Type..." data-style="btn-primary btn-sm">
                                        <option value="equals" data-token="Equals">Equals</option>
                                        <option value="begins" data-token="Begins With">Begins With</option>
                                        <option value="contains" data-token="Contains">Contains</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input id="input4b" name="searchBlock" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="" >
                                </div>
                            </div>
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label4" class="my-1 mr-2 text-white" for="input5">Owning Company</label></div>
                                <div class="col">
                                    <select id="input5" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchCompany" size="1" title="Select Company..." data-style="btn-primary btn-sm">
                                        <!-- <option value="equals" data-token="Equals">Equals</option>
                                        <option value="begins" data-token="Begins With">Begins With</option>
                                        <option value="contains" data-token="Contains">Contains</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label5" class="my-1 mr-2 text-white" for="input6">Type</label></div>
                                <div class="col">
                                    <select id="input6" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchEntityType" size="1" title="Select Entity Type..." data-style="btn-primary btn-sm">
                                        <!-- <option value="equals" data-token="Equals">Equals</option>
                                        <option value="begins" data-token="Begins With">Begins With</option>
                                        <option value="contains" data-token="Contains">Contains</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label6" class="my-1 mr-2 text-white" for="input7">Status</label></div>
                                <div class="col">
                                    <select id="input7" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchEntityStatus" size="1" title="Select Entity Status..." data-style="btn-primary btn-sm">
                                        <!-- <option value="equals" data-token="Equals">Equals</option>
                                        <option value="begins" data-token="Begins With">Begins With</option>
                                        <option value="contains" data-token="Contains">Contains</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="row pr-5">
                                <!-- <div class="col"><button type="submit" class="btn btn-block btn-primary mb-2">Search</button></div> -->
                                <div class="col"><button type="submit" id="btnSearch" class="btn btn-block btn-primary mb-2">Search</button></div>
                                <div class="col"><button type="submit" class="btn btn-block btn-primary mb-2">Reset</button></div>
                            </div>
                        </div>
                    </form>
                    <form id="addlocationdb" class="sdb d-none" method="POST" enctype="multipart/form-data">
                        <!-- <span class="h6 sidebar-heading text-white">New Location:</span> -->
                        <div class="container">
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label1l" class="my-1 mr-2 text-white" for="input2l">State</label></div>
                                <div class="col">
                                    <select id="input2l" class="strState" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchState" size="1" title="Select State..." data-style="btn-primary btn-sm">
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
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label5l" class="my-1 mr-2 text-white" for="input6l">Region</label></div>
                                <div class="col">
                                    <select id="input6l" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchEntityType" size="1" title="Select Entity Type..." data-style="btn-primary btn-sm">
                                        <!-- <option value="equals" data-token="Equals">Equals</option>
                                        <option value="begins" data-token="Begins With">Begins With</option>
                                        <option value="contains" data-token="Contains">Contains</option> -->
                                    </select>
                                </div>
                            </div>
                            <div id="county_drop_down_fake" class="row pr-5">
                                <div class="col-4 text-right"><label id="labelCountyFakel" class="my-1 mr-2 text-white" for="strCountyParishFakel">County</label>
                                
                                <!-- <label id="label2a" class="my-1 mr-2 text-white labelCountyFake" for="input3a">County</label>-->
                                </div> 
                                <div class="col">
                                <select disabled id="strCountyParishFakel" class="" data-live-search="true" data-width="100%" data-size="5" width='auto' name="searchCountyFakel" size="1" title="Please select a state..." data-style="btn-primary btn-sm"></select>    
                                    <!-- <select id="input3" class="strCountyParishFake selectpicker" data-live-search="true" data-width="auto" data-size="5" width='auto' name="api" size="1" title="Search Type..." data-style="btn-primary btn-sm">
                                        
                                    </select> -->
                                </div>
                                
                            </div>
                            <div id="county_drop_down" class="row pr-5 hidden">
                                <div class="col-4 text-right "><label id="label2bl" class="my-1 mr-2 text-white labelCounty" for="input3l">County</label></div>
                                <div class="col">
                                    <select id="input3l" class="strCountyParish" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchCounty" size="1" title="Select County..." data-style="btn-primary btn-sm">
                                        <!-- <option value="equals" data-token="Equals">Equals</option>
                                        <option value="begins" data-token="Begins With">Begins With</option>
                                        <option value="contains" data-token="Contains">Contains</option> -->
                                    </select>
                                    <span id="loading_county_drop_downl" style="display: none;"><i data-feather="loader">&nbsp;Loading...</i></span>
                                    <div id="no_county_drop_downl" style="display: none;">This state has no counties.</div>
                                </div>

                            </div>
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label3l" class="my-1 mr-2 text-white" for="input4l">Block</label></div>
                                <div class="col">
                                    <input id="input4l" name="searchBlock" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="" >
                                </div>
                            </div>
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label4l" class="my-1 mr-2 text-white" for="input5l">Field</label></div>
                                <div class="col">
                                    <select id="input5l" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="searchCompany" size="1" title="Select Company..." data-style="btn-primary btn-sm">
                                        <!-- <option value="equals" data-token="Equals">Equals</option>
                                        <option value="begins" data-token="Begins With">Begins With</option>
                                        <option value="contains" data-token="Contains">Contains</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="row pr-5">
                                <div class="col"><button type="submit" id="btnSubmitLocation" class="btn btn-block btn-primary mb-2">Submit</button></div>
                            </div>
                        </div>
                    </form>
                    <form id="addpropertydb" class="sdb d-none" method="POST" enctype="multipart/form-data">
                        <div class="container">
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input2">Location ID:</label></div>
                                <div class="col">
                                    <input id="input2p" name="edit-input-2" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                            </div>
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Name</label></div>
                                <div class="col">
                                    <input id="input1bp" name="edit-input-3" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                                <div class="col-1 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">WI:</label></div>
                                <div class="col-auto">
                                <select id="input5" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="edit-input-4" size="1" title="Select Company..." data-style="btn-primary btn-sm">
                                    <option value="1" data-token="Yes">Yes</option>
                                    <option value="0" data-token="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Status</label></div>
                                <div class="col">
                                    <input id="input1bp" name="edit-input-6" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                                <div class="col-1 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">RI:</label></div>
                                <div class="col-auto">
                                <select id="input5" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="edit-input-7" size="1" title="Select Company..." data-style="btn-primary btn-sm">
                                    <option value="1" data-token="Yes">Yes</option>
                                    <option value="0" data-token="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Operating Status</label></div>
                                <div class="col">
                                    <input id="input1bp" name="edit-input-9" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                                <div class="col-1 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">ORRI:</label></div>
                                <div class="col-auto">
                                <select id="input5" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="edit-input-10" size="1" title="Select Company..." data-style="btn-primary btn-sm">
                                    <option value="1" data-token="Yes">Yes</option>
                                    <option value="0" data-token="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Owning Company</label></div>
                                <div class="col">
                                    <input id="input1bp" name="edit-input-12" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                                <div class="col-1 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">BIAPO:</label></div>
                                <div class="col-auto">
                                <select id="input5" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="edit-input-13" size="1" title="Select Company..." data-style="btn-primary btn-sm">
                                    <option value="1" data-token="Yes">Yes</option>
                                    <option value="0" data-token="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Operator</label></div>
                                <div class="col">
                                    <input id="input1bp" name="edit-input-15" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                                <div class="col-1 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">WBO:</label></div>
                                <div class="col-auto">
                                <select id="input5" class="" data-live-search="true" data-width="auto" data-size="5" width='auto' name="edit-input-16" size="1" title="Select Company..." data-style="btn-primary btn-sm">
                                    <option value="1" data-token="Yes">Yes</option>
                                    <option value="0" data-token="No">No</option>
                                </select>
                                </div>
                            </div>
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input2">Legal Description</label></div>
                                <div class="col">
                                    <input id="input2p" name="edit-input-17" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                            </div>
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">WP Code</label></div>
                                <div class="col-3">
                                    <input id="input1bp" name="edit-input-22" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                                <div class="col-2 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">GWI&nbsp;Value</label></div>
                                <div class="col">
                                <input id="input1bp" name="edit-input-5" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                            </div>
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Lease Number</label></div>
                                <div class="col-3">
                                    <input id="input1bp" name="edit-input-21" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                                <div class="col-2 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">NRI&nbsp;Value</label></div>
                                <div class="col">
                                <input id="input1bp" name="edit-input-8" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                            </div>
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Net Acres</label></div>
                                <div class="col-3">
                                    <input id="input1bp" name="edit-input-20" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                                <div class="col-2 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">ORRI&nbsp;Value</label></div>
                                <div class="col">
                                <input id="input1bp" name="edit-input-11" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                            </div>
                            <div class="row pr-5 justify-content-md-center">
                                <div class="col-4 text-right"><label id="label1" class="my-1 mr-2 text-white" for="input1">Gross Acres</label></div>
                                <div class="col-3">
                                    <input id="input1bp" name="edit-input-18" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                                <div class="col-2 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">RI&nbsp;Value</label></div>
                                <div class="col">
                                <input id="input1bp" name="edit-input-14" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="">
                                </div>
                            </div>
                            <div class="row pr-5">
                                <div class="col-4 text-right"><label id="label3" class="my-1 mr-2 text-white" for="input4">API</label></div>
                                <div class="col">
                                    <input id="input4b" name="edit-input-19" type="search" autocomplete="off" class="form-control form-control-sm" style="height:1.5em" value="" >
                                </div>
                            </div>
                            <div class="row pr-5">
                                <input id="edit-input-23" name="edit-input-23" type="hidden" autocomplete="off" class="" value="<?php echo $userid; ?>">
                                <!-- <div class="col"><button type="submit" class="btn btn-block btn-primary mb-2">Search</button></div> -->
                                <div class="col"><button type="submit" id="btnSubmitProperty" class="btn btn-block btn-primary mb-2">Submit</button></div>
                                <!-- <div class="col"><button type="submit" class="btn btn-block btn-primary mb-2">Reset</button></div> -->
                            </div>
                        </div>
                    </form>
                    
                </div>
                
                <!-- <div id="openSearchSidebar" class="pl-0">
                    <button class="openbtn">&#9776; &#171; &#8810; &#9001; &#10782; &#10096; &#x2770; Open Sidebar</button>
                </div> -->
                <!-- <span class="pl-0 pos--absolute pos-fixed"> -->
                    <!-- <button id="close" data-feather="chevron-left">close</button> -->
                    <button id="toggle" ><span id="toggle-icon" data-feather="chevron-left"></span></button>
                    <!-- <button id="open" data-feather="chevron-right">open</button> -->
                <!-- </div> -->
                <div class="ch col col--lg-10 col--md-5 ml-sm-auto px-md-3">
                    <div class="dtables" id="locationtable">
                    <table class="table table-sm table-striped table-hover d-none results" id="location">
                        <thead>
                            <th>LocationID</th>
                            <th>State</th>
                            <th>Region</th>
                            <th>County</th>
                            <th>Block</th>
                            <th>Field</th>
                        </thead>
                    </table>
                    </div>
                    <div class="dtables" id="propertytable">
                        <table class="table table-sm table-striped table-hover d-none results" id="property">
                            <thead>
                            <th>ID</th>
                            <th>Location ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Specific Status</th>
                            <th>Operating status</th>
                            <th>Owning company</th>
                            <th>Purchaser</th>
                            <th>TX Op #</th>
                            <th>Operator</th>
                            <th>WI</th>
                            <th>RI</th>
                            <th>ORRI</th>
                            <th>BIAPO</th>
                            <th>WBO</th>
                            <th>Legal Description</th>
                            <th>API</th>
                            <th>GWI Value</th>
                            <th>NRI Value</th>
                            <th>ORRI Value</th>
                            <th>RI Value</th>
                            <th>WP Code</th>
                            <th>Gross Acres</th>
                            <th>Net Acres</th>
                            <th>Lease No.</th>
                            <th>Comments</th>
                            <th>Combined Name</th>
                            </thead>
                        </table>
                    </div>
                    <div class="dtables" id="opstatustable">
                        <table class="table table-sm table-striped table-hover d-none results" id="opstatus">
                            <thead>
                                <th>Status</th>
                            </thead>
                        </table>
                    </div>
                    <div class="dtables" id="owncomptable">
                        <table class="table table-sm table-striped table-hover d-none results" id="owncomp">
                            <thead>
                                <th>ID</th>
                                <th>Company Codes</th>
                            </thead>
                        </table>
                    </div>
                    <div class="dtables" id="statustable">
                        <table class="table table-sm table-striped table-hover d-none results" id="status">
                            <thead>
                                <th>Status</th>
                            </thead>
                        </table>
                    </div>
                    <div class="dtables" id="updatetable">
                        <table class="table table-sm table-striped table-hover d-none results" id="update">
                            <thead>
                                <th>Action</th>
                                <th>Property ID</th>
                                <th>Update Date/Time</th>
                                <th>User ID</th>
                            </thead>
                        </table>
                    </div>
                    <div class="dtables" id="querytable">
                        <table class="table table-sm table-striped table-hover d-none results" id="query">
                        </table>
                    </div>
                    <main role="main" class="ch cole-md-5 mle-sm-auto col-elg-6 px--md-4">
                        <div class="results d-none" id="searchresults">
                            <div id="result-header" class="results d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb--2 mb--3 border--bottom"></div>
                            <div id="results" class="results overflow-auto vh-40 d-flex justify-content-between flex-wrap flex-md-nowrap align--items-center pt--3 pb--2 mb-3 border-bottom">
                            
                                <!-- <h1 class="h2">Results</h1>
                                <div class="w-100"> -->
                                <!-- <div class="btn-toolbar mb-2 mb-md-0">
                                <div class="btn-group mr-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                    <span data-feather="calendar"></span>
                                    This week
                                </button>
                                </div> -->
                            </div>

                        
                            <div id="editresults" class="d-none">
                                <h2 id="sectTitle"></h2>
                                <form id="editableResults" class="edb results edit-results d-none d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt--3 pb--2 mb-3 border-bottom" method="POST" enctype="multipart/form-data">
                                    <div class="container">
                                        <div class="row ">
                                            <div class="col-4 text-left"><label id="edit-label-1" class="my-1 mr-2" for="edit-input-1">Property ID</label></div>
                                            <div class="col"><input id="edit-input-1" name="edit-input-1" type="search" autocomplete="off" class="form-control form-control-sm" readonly></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col text-left"><label id="edit-label-2" class="my-1 mr-2" for="edit-input-2">Location ID</label></div>
                                            <div class="col"><input id="edit-input-2" name="edit-input-2" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col text-left"><label id="edit-label-3" class="my-1 mr-2" for="edit-input-3">Name</label></div>
                                            <div class="col-4"><input id="edit-input-3" name="edit-input-3" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col-1 text-left"><label id="edit-label-4" class="my-1 mr-2" for="edit-input-4">WI</label></div>
                                            <div class="col-2"><input id="edit-input-4" name="edit-input-4" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col text-left"><label id="edit-label-5" class="my-1 mr-2" for="edit-input-5">GWI Value</label></div>
                                            <div class="col-2"><input id="edit-input-5" name="edit-input-5" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col text-left"><label id="edit-label-6" class="my-1 mr-2" for="edit-input-6">Status</label></div>
                                            <div class="col-4"><input id="edit-input-6" name="edit-input-6" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col-1 text-left"><label id="edit-label-7" class="my-1 mr-2" for="edit-input-7">RI</label></div>
                                            <div class="col-2"><input id="edit-input-7" name="edit-input-7" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col text-left"><label id="edit-label-8" class="my-1 mr-2" for="edit-input-8">NRI Value</label></div>
                                            <div class="col-2"><input id="edit-input-8" name="edit-input-8" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col text-left"><label id="edit-label-9" class="my-1 mr-2" for="edit-input-9">Status</label></div>
                                            <div class="col-4"><input id="edit-input-9" name="edit-input-9" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col-1 text-left"><label id="edit-label-10" class="my-1 mr-2" for="edit-input-10">ORRI</label></div>
                                            <div class="col-2"><input id="edit-input-10" name="edit-input-10" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col text-left"><label id="edit-label-11" class="my-1 mr-2" for="edit-input-11">ORRI Value</label></div>
                                            <div class="col-2"><input id="edit-input-11" name="edit-input-11" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col text-left"><label id="edit-label-12" class="my-1 mr-2" for="edit-input-12">Company</label></div>
                                            <div class="col-4"><input id="edit-input-12" name="edit-input-12" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col-1 text-left"><label id="edit-label-13" class="my-1 mr-2" for="edit-input-13">BIAPO</label></div>
                                            <div class="col-2"><input id="edit-input-13" name="edit-input-13" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col text-left"><label id="edit-label-14" class="my-1 mr-2" for="edit-input-14">RI Values</label></div>
                                            <div class="col-2"><input id="edit-input-14" name="edit-input-14" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col text-left"><label id="edit-label-15" class="my-1 mr-2" for="edit-input-15">Operator</label></div>
                                            <div class="col"><input id="edit-input-15" name="edit-input-15" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col text-left"><label id="edit-label-16" class="my-1 mr-2" for="edit-input-16">WBO</label></div>
                                            <div class="col"><input id="edit-input-16" name="edit-input-16" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col text-left"><label id="edit-label-17" class="my-1 mr-2" for="edit-input-17">Legal Description</label></div>
                                            <div class="col"><input id="edit-input-17" name="edit-input-17" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col text-left"><label id="edit-label-18" class="my-1 mr-2" for="edit-input-18">Gross Acres</label></div>
                                            <div class="col"><input id="edit-input-18" name="edit-input-18" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col text-left"><label id="edit-label-19" class="my-1 mr-2" for="edit-input-19">API</label></div>
                                            <div class="col"><input id="edit-input-19" name="edit-input-19" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                            <div class="col text-left"><label id="edit-label-20" class="my-1 mr-2" for="edit-input-20">Net Acres</label></div>
                                            <div class="col"><input id="edit-input-20" name="edit-input-20" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-4 text-left"><label id="edit-label-21" class="my-1 mr-2" for="edit-input-21">Lease Number</label></div>
                                            <div class="col"><input id="edit-input-21" name="edit-input-21" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row ">
                                            <div class="col-4 text-left"><label id="edit-label-22" class="my-1 mr-2" for="edit-input-22">WP Code</label></div>
                                            <div class="col"><input id="edit-input-22" name="edit-input-22" type="search" autocomplete="off" class="form-control form-control-sm"></div>
                                        </div>
                                        <div class="row">
                                            <input id="edit-input-23" name="edit-input-23" type="hidden" autocomplete="off" class="" value="<?php echo $userid; ?>">
                                            <div class="col"><button type="submit" id="btnUpdate" class="sdb btn btn-block btn-primary mb-2" val="Update">Update</button></div>
                                            <div class="col"><button type="submit" class="btn btn-block btn-primary mb-2">Cancel</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="printReport" class="row d-none"><button id="printbutton" class="btn btn-primary btn-lg">Print Report</button></div>
                        <div id="printdiv"></div>
                    </main>
                </div>
                
                    
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
        <textarea id="printing-css" style="display:none;">
        body .dash{font-size:.875rem}.feather{width:16px;height:16px;vertical-align:text-bottom}.sidebar-dash{position:fixed;top:0;bottom:0;left:0;z-index:100;padding:48px 0 0;box-shadow:inset -1px 0 0 rgba(0,0,0,.1)}@media (max-width:767.98px){.sidebar-dash{top:5rem}}.sidebar-dash-sticky{position:relative;top:0;height:calc(100vh - 48px);padding-top:.5rem;overflow-x:hidden;overflow-y:auto}@supports ((position:-webkit-sticky) or (position:sticky)){.sidebar-dash-sticky{position:-webkit-sticky;position:sticky}}.sidebar-dash .nav-dash-link{font-weight:500;color:#333}.sidebar-dash .nav-dash-link .feather{margin-right:4px;color:#999}.sidebar-dash .nav-dash-link.active{color:#007bff}.sidebar-dash .nav-dash-link.active .feather,.sidebar-dash .nav-dash-link:hover .feather{color:inherit}.sidebar-dash-heading{font-size:.75rem;text-transform:uppercase}.navbar-dash-brandboard{padding-top:.75rem;padding-bottom:.75rem;font-size:1rem;background-color:rgba(0,0,0,.25);box-shadow:inset -1px 0 0 rgba(0,0,0,.25)}.navbar-dash .navbar-dash-toggler{top:.25rem;right:1rem}.navbar-dash .form-control-dash{padding:.75rem 1rem;border-width:0;border-radius:0}.form-control-dash-dark{color:#fff;background-color:rgba(255,255,255,.1);border-color:rgba(255,255,255,.1)}.form-control-dash-dark:focus{border-color:transparent;box-shadow:0 0 0 3px rgba(255,255,255,.25)}.file-upload{position:relative;height:8rem;margin-bottom:2rem;margin-top:2rem}.file-upload .file-upload-input{border-radius:.25rem;width:100%;border:.125rem dashed rgba(0,0,0,.2);height:8rem;text-align:center;cursor:pointer;position:relative;display:inline-block;padding:8rem 0 0 0;overflow:hidden;z-index:1;transition:.3s ease}.file-upload .file-upload-input:hover{border-color:rgba(0,0,0,.4);background-color:rgba(0,0,0,.05)}.file-upload span{position:absolute;top:0;bottom:0;line-height:8rem;width:100%;text-align:center;margin:auto;z-index:0;left:0;color:rgba(0,0,0,.5)}.file-upload span i{color:#00f;margin-right:1rem}.file-upload-previews>.MultiFile-label{border-radius:.1875rem;background-color:rgba(0,0,0,.03);display:inline-block;border:.125rem solid rgba(0,0,0,.1);padding:1rem;position:relative;margin-right:1rem;margin-bottom:1rem;width:100%}.file-upload-previews span.MultiFile-label{position:relative;text-align:center;margin:1rem}.file-upload-previews span.MultiFile-label .MultiFile-subtitle{background-color:rgba(0,0,0,.4);color:#fff;padding:1rem;bottom:0;font-size:.75rem;text-align:center;width:100%;border-radius:.5rem}.file-upload-previews span.MultiFile-label .MultiFile-title{color:#fff;padding:1rem;bottom:0;font-size:.75rem;text-align:center;width:100%;border-radius:.5rem}.file-upload-previews span.MultiFile-label .MultiFile-preview{max-width:14rem!important;max-height:7rem!important}.file-uploaded-images .image{height:15rem;display:inline-block;margin-bottom:1.8rem;margin-right:1.5rem;position:relative}.file-uploaded-images .image figure{box-shadow:0 .125rem .3125rem rgba(0,0,0,.1);border-radius:50%;cursor:pointer;background-color:red;width:2rem;height:2rem;position:absolute;right:-1rem;top:-1rem;content:"";text-align:center;line-height:1.5rem}.file-uploaded-images .image figure i{color:#fff;font-size:1rem}.file-uploaded-images .image img{height:100%}.file-uploaded-images .image{box-shadow:0 .125rem .3125rem rgba(0,0,0,.1);height:10rem;display:inline-block;margin-bottom:1rem;margin-right:1rem;position:relative}.file-uploaded-images .image figure{box-shadow:0 .125rem .3125rem rgba(0,0,0,.1);border-radius:50%;cursor:pointer;background-color:red;width:1.5rem;height:1.5rem;position:absolute;right:-.75rem;top:-.75rem;content:"";text-align:center;line-height:1.375rem}.file-uploaded-images .image figure i{color:#fff;font-size:.75rem}.file-uploaded-images .image img{height:100%}.MultiFile-remove{line-height:.625rem!important}.fs-1{font-size:1px}.fs-2{font-size:2px}.fs-3{font-size:3px}.fs-4{font-size:4px}.fs-5{font-size:5px}.fs-6{font-size:6px}.fs-7{font-size:7px}.fs-8{font-size:8px}.fs-9{font-size:9px}.fs-10{font-size:10px}.fs-11{font-size:11px}.fs-12{font-size:12px}.fs-13{font-size:13px}.fs-14{font-size:14px}.fs-15{font-size:15px}.fs-16{font-size:16px}.fs-17{font-size:17px}.fs-18{font-size:18px}.fs-19{font-size:19px}.fs-20{font-size:20px}.fs-21{font-size:21px}.fs-22{font-size:22px}.fs-23{font-size:23px}.fs-24{font-size:24px}.fs-25{font-size:25px}.fs-26{font-size:26px}.fs-27{font-size:27px}.fs-28{font-size:28px}.fs-29{font-size:29px}.fs-30{font-size:30px}.fs-31{font-size:31px}.fs-32{font-size:32px}.fs-33{font-size:33px}.fs-34{font-size:34px}.fs-35{font-size:35px}.fs-36{font-size:36px}.fs-37{font-size:37px}.fs-38{font-size:38px}.fs-39{font-size:39px}.fs-40{font-size:40px}.fs-41{font-size:41px}.fs-42{font-size:42px}.fs-43{font-size:43px}.fs-44{font-size:44px}.fs-45{font-size:45px}.fs-46{font-size:46px}.fs-47{font-size:47px}.fs-48{font-size:48px}.fs-49{font-size:49px}.fs-50{font-size:50px}.fs-51{font-size:51px}.fs-52{font-size:52px}.fs-53{font-size:53px}.fs-54{font-size:54px}.fs-55{font-size:55px}.fs-56{font-size:56px}.fs-57{font-size:57px}.fs-58{font-size:58px}.fs-59{font-size:59px}.fs-60{font-size:60px}.fs-61{font-size:61px}.fs-62{font-size:62px}.fs-63{font-size:63px}.fs-64{font-size:64px}.fs-65{font-size:65px}.fs-66{font-size:66px}.fs-67{font-size:67px}.fs-68{font-size:68px}.fs-69{font-size:69px}.fs-70{font-size:70px}.fs-71{font-size:71px}.fs-72{font-size:72px}.fs-73{font-size:73px}.fs-74{font-size:74px}.fs-75{font-size:75px}.fs-76{font-size:76px}.fs-77{font-size:77px}.fs-78{font-size:78px}.fs-79{font-size:79px}.fs-80{font-size:80px}.fs-81{font-size:81px}.fs-82{font-size:82px}.fs-83{font-size:83px}.fs-84{font-size:84px}.fs-85{font-size:85px}.fs-86{font-size:86px}.fs-87{font-size:87px}.fs-88{font-size:88px}.fs-89{font-size:89px}.fs-90{font-size:90px}.fs-91{font-size:91px}.fs-92{font-size:92px}.fs-93{font-size:93px}.fs-94{font-size:94px}.fs-95{font-size:95px}.fs-96{font-size:96px}.fs-97{font-size:97px}.fs-98{font-size:98px}.fs-99{font-size:99px}.fs-100{font-size:100px}.fs-101{font-size:101px}.fs-102{font-size:102px}.fs-103{font-size:103px}.fs-104{font-size:104px}.fs-105{font-size:105px}.fs-106{font-size:106px}.fs-107{font-size:107px}.fs-108{font-size:108px}.fs-109{font-size:109px}.fs-110{font-size:110px}.fs-111{font-size:111px}.fs-112{font-size:112px}.fs-113{font-size:113px}.fs-114{font-size:114px}.fs-115{font-size:115px}.fs-116{font-size:116px}.fs-117{font-size:117px}.fs-118{font-size:118px}.fs-119{font-size:119px}.fs-120{font-size:120px}.fs-121{font-size:121px}.fs-122{font-size:122px}.fs-123{font-size:123px}.fs-124{font-size:124px}.fs-125{font-size:125px}.fs-126{font-size:126px}.fs-127{font-size:127px}.fs-128{font-size:128px}.fs-129{font-size:129px}.fs-130{font-size:130px}.fs-131{font-size:131px}.fs-132{font-size:132px}.fs-133{font-size:133px}.fs-134{font-size:134px}.fs-135{font-size:135px}.fs-136{font-size:136px}.fs-137{font-size:137px}.fs-138{font-size:138px}.fs-139{font-size:139px}.fs-140{font-size:140px}.fs-141{font-size:141px}.fs-142{font-size:142px}.fs-143{font-size:143px}.fs-144{font-size:144px}.fs-145{font-size:145px}.fs-146{font-size:146px}.fs-147{font-size:147px}.fs-148{font-size:148px}.fs-149{font-size:149px}.fs-150{font-size:150px}.fs-151{font-size:151px}.fs-152{font-size:152px}.fs-153{font-size:153px}.fs-154{font-size:154px}.fs-155{font-size:155px}.fs-156{font-size:156px}.fs-157{font-size:157px}.fs-158{font-size:158px}.fs-159{font-size:159px}.fs-160{font-size:160px}.fs-161{font-size:161px}.fs-162{font-size:162px}.fs-163{font-size:163px}.fs-164{font-size:164px}.fs-165{font-size:165px}.fs-166{font-size:166px}.fs-167{font-size:167px}.fs-168{font-size:168px}.fs-169{font-size:169px}.fs-170{font-size:170px}.fs-171{font-size:171px}.fs-172{font-size:172px}.fs-173{font-size:173px}.fs-174{font-size:174px}.fs-175{font-size:175px}.fs-176{font-size:176px}.fs-177{font-size:177px}.fs-178{font-size:178px}.fs-179{font-size:179px}.fs-180{font-size:180px}.fs-181{font-size:181px}.fs-182{font-size:182px}.fs-183{font-size:183px}.fs-184{font-size:184px}.fs-185{font-size:185px}.fs-186{font-size:186px}.fs-187{font-size:187px}.fs-188{font-size:188px}.fs-189{font-size:189px}.fs-190{font-size:190px}.fs-191{font-size:191px}.fs-192{font-size:192px}.fs-193{font-size:193px}.fs-194{font-size:194px}.fs-195{font-size:195px}.fs-196{font-size:196px}.fs-197{font-size:197px}.fs-198{font-size:198px}.fs-199{font-size:199px}.fs-200{font-size:200px}.p-t-0{padding-top:0}.p-t-1{padding-top:1px}.p-t-2{padding-top:2px}.p-t-3{padding-top:3px}.p-t-4{padding-top:4px}.p-t-5{padding-top:5px}.p-t-6{padding-top:6px}.p-t-7{padding-top:7px}.p-t-8{padding-top:8px}.p-t-9{padding-top:9px}.p-t-10{padding-top:10px}.p-t-11{padding-top:11px}.p-t-12{padding-top:12px}.p-t-13{padding-top:13px}.p-t-14{padding-top:14px}.p-t-15{padding-top:15px}.p-t-16{padding-top:16px}.p-t-17{padding-top:17px}.p-t-18{padding-top:18px}.p-t-19{padding-top:19px}.p-t-20{padding-top:20px}.p-t-21{padding-top:21px}.p-t-22{padding-top:22px}.p-t-23{padding-top:23px}.p-t-24{padding-top:24px}.p-t-25{padding-top:25px}.p-t-26{padding-top:26px}.p-t-27{padding-top:27px}.p-t-28{padding-top:28px}.p-t-29{padding-top:29px}.p-t-30{padding-top:30px}.p-t-31{padding-top:31px}.p-t-32{padding-top:32px}.p-t-33{padding-top:33px}.p-t-34{padding-top:34px}.p-t-35{padding-top:35px}.p-t-36{padding-top:36px}.p-t-37{padding-top:37px}.p-t-38{padding-top:38px}.p-t-39{padding-top:39px}.p-t-40{padding-top:40px}.p-t-41{padding-top:41px}.p-t-42{padding-top:42px}.p-t-43{padding-top:43px}.p-t-44{padding-top:44px}.p-t-45{padding-top:45px}.p-t-46{padding-top:46px}.p-t-47{padding-top:47px}.p-t-48{padding-top:48px}.p-t-49{padding-top:49px}.p-t-50{padding-top:50px}.p-t-51{padding-top:51px}.p-t-52{padding-top:52px}.p-t-53{padding-top:53px}.p-t-54{padding-top:54px}.p-t-55{padding-top:55px}.p-t-56{padding-top:56px}.p-t-57{padding-top:57px}.p-t-58{padding-top:58px}.p-t-59{padding-top:59px}.p-t-60{padding-top:60px}.p-t-61{padding-top:61px}.p-t-62{padding-top:62px}.p-t-63{padding-top:63px}.p-t-64{padding-top:64px}.p-t-65{padding-top:65px}.p-t-66{padding-top:66px}.p-t-67{padding-top:67px}.p-t-68{padding-top:68px}.p-t-69{padding-top:69px}.p-t-70{padding-top:70px}.p-t-71{padding-top:71px}.p-t-72{padding-top:72px}.p-t-73{padding-top:73px}.p-t-74{padding-top:74px}.p-t-75{padding-top:75px}.p-t-76{padding-top:76px}.p-t-77{padding-top:77px}.p-t-78{padding-top:78px}.p-t-79{padding-top:79px}.p-t-80{padding-top:80px}.p-t-81{padding-top:81px}.p-t-82{padding-top:82px}.p-t-83{padding-top:83px}.p-t-84{padding-top:84px}.p-t-85{padding-top:85px}.p-t-86{padding-top:86px}.p-t-87{padding-top:87px}.p-t-88{padding-top:88px}.p-t-89{padding-top:89px}.p-t-90{padding-top:90px}.p-t-91{padding-top:91px}.p-t-92{padding-top:92px}.p-t-93{padding-top:93px}.p-t-94{padding-top:94px}.p-t-95{padding-top:95px}.p-t-96{padding-top:96px}.p-t-97{padding-top:97px}.p-t-98{padding-top:98px}.p-t-99{padding-top:99px}.p-t-100{padding-top:100px}.p-t-101{padding-top:101px}.p-t-102{padding-top:102px}.p-t-103{padding-top:103px}.p-t-104{padding-top:104px}.p-t-105{padding-top:105px}.p-t-106{padding-top:106px}.p-t-107{padding-top:107px}.p-t-108{padding-top:108px}.p-t-109{padding-top:109px}.p-t-110{padding-top:110px}.p-t-111{padding-top:111px}.p-t-112{padding-top:112px}.p-t-113{padding-top:113px}.p-t-114{padding-top:114px}.p-t-115{padding-top:115px}.p-t-116{padding-top:116px}.p-t-117{padding-top:117px}.p-t-118{padding-top:118px}.p-t-119{padding-top:119px}.p-t-120{padding-top:120px}.p-t-121{padding-top:121px}.p-t-122{padding-top:122px}.p-t-123{padding-top:123px}.p-t-124{padding-top:124px}.p-t-125{padding-top:125px}.p-t-126{padding-top:126px}.p-t-127{padding-top:127px}.p-t-128{padding-top:128px}.p-t-129{padding-top:129px}.p-t-130{padding-top:130px}.p-t-131{padding-top:131px}.p-t-132{padding-top:132px}.p-t-133{padding-top:133px}.p-t-134{padding-top:134px}.p-t-135{padding-top:135px}.p-t-136{padding-top:136px}.p-t-137{padding-top:137px}.p-t-138{padding-top:138px}.p-t-139{padding-top:139px}.p-t-140{padding-top:140px}.p-t-141{padding-top:141px}.p-t-142{padding-top:142px}.p-t-143{padding-top:143px}.p-t-144{padding-top:144px}.p-t-145{padding-top:145px}.p-t-146{padding-top:146px}.p-t-147{padding-top:147px}.p-t-148{padding-top:148px}.p-t-149{padding-top:149px}.p-t-150{padding-top:150px}.p-t-151{padding-top:151px}.p-t-152{padding-top:152px}.p-t-153{padding-top:153px}.p-t-154{padding-top:154px}.p-t-155{padding-top:155px}.p-t-156{padding-top:156px}.p-t-157{padding-top:157px}.p-t-158{padding-top:158px}.p-t-159{padding-top:159px}.p-t-160{padding-top:160px}.p-t-161{padding-top:161px}.p-t-162{padding-top:162px}.p-t-163{padding-top:163px}.p-t-164{padding-top:164px}.p-t-165{padding-top:165px}.p-t-166{padding-top:166px}.p-t-167{padding-top:167px}.p-t-168{padding-top:168px}.p-t-169{padding-top:169px}.p-t-170{padding-top:170px}.p-t-171{padding-top:171px}.p-t-172{padding-top:172px}.p-t-173{padding-top:173px}.p-t-174{padding-top:174px}.p-t-175{padding-top:175px}.p-t-176{padding-top:176px}.p-t-177{padding-top:177px}.p-t-178{padding-top:178px}.p-t-179{padding-top:179px}.p-t-180{padding-top:180px}.p-t-181{padding-top:181px}.p-t-182{padding-top:182px}.p-t-183{padding-top:183px}.p-t-184{padding-top:184px}.p-t-185{padding-top:185px}.p-t-186{padding-top:186px}.p-t-187{padding-top:187px}.p-t-188{padding-top:188px}.p-t-189{padding-top:189px}.p-t-190{padding-top:190px}.p-t-191{padding-top:191px}.p-t-192{padding-top:192px}.p-t-193{padding-top:193px}.p-t-194{padding-top:194px}.p-t-195{padding-top:195px}.p-t-196{padding-top:196px}.p-t-197{padding-top:197px}.p-t-198{padding-top:198px}.p-t-199{padding-top:199px}.p-t-200{padding-top:200px}.p-t-201{padding-top:201px}.p-t-202{padding-top:202px}.p-t-203{padding-top:203px}.p-t-204{padding-top:204px}.p-t-205{padding-top:205px}.p-t-206{padding-top:206px}.p-t-207{padding-top:207px}.p-t-208{padding-top:208px}.p-t-209{padding-top:209px}.p-t-210{padding-top:210px}.p-t-211{padding-top:211px}.p-t-212{padding-top:212px}.p-t-213{padding-top:213px}.p-t-214{padding-top:214px}.p-t-215{padding-top:215px}.p-t-216{padding-top:216px}.p-t-217{padding-top:217px}.p-t-218{padding-top:218px}.p-t-219{padding-top:219px}.p-t-220{padding-top:220px}.p-t-221{padding-top:221px}.p-t-222{padding-top:222px}.p-t-223{padding-top:223px}.p-t-224{padding-top:224px}.p-t-225{padding-top:225px}.p-t-226{padding-top:226px}.p-t-227{padding-top:227px}.p-t-228{padding-top:228px}.p-t-229{padding-top:229px}.p-t-230{padding-top:230px}.p-t-231{padding-top:231px}.p-t-232{padding-top:232px}.p-t-233{padding-top:233px}.p-t-234{padding-top:234px}.p-t-235{padding-top:235px}.p-t-236{padding-top:236px}.p-t-237{padding-top:237px}.p-t-238{padding-top:238px}.p-t-239{padding-top:239px}.p-t-240{padding-top:240px}.p-t-241{padding-top:241px}.p-t-242{padding-top:242px}.p-t-243{padding-top:243px}.p-t-244{padding-top:244px}.p-t-245{padding-top:245px}.p-t-246{padding-top:246px}.p-t-247{padding-top:247px}.p-t-248{padding-top:248px}.p-t-249{padding-top:249px}.p-t-250{padding-top:250px}.p-b-0{padding-bottom:0}.p-b-1{padding-bottom:1px}.p-b-2{padding-bottom:2px}.p-b-3{padding-bottom:3px}.p-b-4{padding-bottom:4px}.p-b-5{padding-bottom:5px}.p-b-6{padding-bottom:6px}.p-b-7{padding-bottom:7px}.p-b-8{padding-bottom:8px}.p-b-9{padding-bottom:9px}.p-b-10{padding-bottom:10px}.p-b-11{padding-bottom:11px}.p-b-12{padding-bottom:12px}.p-b-13{padding-bottom:13px}.p-b-14{padding-bottom:14px}.p-b-15{padding-bottom:15px}.p-b-16{padding-bottom:16px}.p-b-17{padding-bottom:17px}.p-b-18{padding-bottom:18px}.p-b-19{padding-bottom:19px}.p-b-20{padding-bottom:20px}.p-b-21{padding-bottom:21px}.p-b-22{padding-bottom:22px}.p-b-23{padding-bottom:23px}.p-b-24{padding-bottom:24px}.p-b-25{padding-bottom:25px}.p-b-26{padding-bottom:26px}.p-b-27{padding-bottom:27px}.p-b-28{padding-bottom:28px}.p-b-29{padding-bottom:29px}.p-b-30{padding-bottom:30px}.p-b-31{padding-bottom:31px}.p-b-32{padding-bottom:32px}.p-b-33{padding-bottom:33px}.p-b-34{padding-bottom:34px}.p-b-35{padding-bottom:35px}.p-b-36{padding-bottom:36px}.p-b-37{padding-bottom:37px}.p-b-38{padding-bottom:38px}.p-b-39{padding-bottom:39px}.p-b-40{padding-bottom:40px}.p-b-41{padding-bottom:41px}.p-b-42{padding-bottom:42px}.p-b-43{padding-bottom:43px}.p-b-44{padding-bottom:44px}.p-b-45{padding-bottom:45px}.p-b-46{padding-bottom:46px}.p-b-47{padding-bottom:47px}.p-b-48{padding-bottom:48px}.p-b-49{padding-bottom:49px}.p-b-50{padding-bottom:50px}.p-b-51{padding-bottom:51px}.p-b-52{padding-bottom:52px}.p-b-53{padding-bottom:53px}.p-b-54{padding-bottom:54px}.p-b-55{padding-bottom:55px}.p-b-56{padding-bottom:56px}.p-b-57{padding-bottom:57px}.p-b-58{padding-bottom:58px}.p-b-59{padding-bottom:59px}.p-b-60{padding-bottom:60px}.p-b-61{padding-bottom:61px}.p-b-62{padding-bottom:62px}.p-b-63{padding-bottom:63px}.p-b-64{padding-bottom:64px}.p-b-65{padding-bottom:65px}.p-b-66{padding-bottom:66px}.p-b-67{padding-bottom:67px}.p-b-68{padding-bottom:68px}.p-b-69{padding-bottom:69px}.p-b-70{padding-bottom:70px}.p-b-71{padding-bottom:71px}.p-b-72{padding-bottom:72px}.p-b-73{padding-bottom:73px}.p-b-74{padding-bottom:74px}.p-b-75{padding-bottom:75px}.p-b-76{padding-bottom:76px}.p-b-77{padding-bottom:77px}.p-b-78{padding-bottom:78px}.p-b-79{padding-bottom:79px}.p-b-80{padding-bottom:80px}.p-b-81{padding-bottom:81px}.p-b-82{padding-bottom:82px}.p-b-83{padding-bottom:83px}.p-b-84{padding-bottom:84px}.p-b-85{padding-bottom:85px}.p-b-86{padding-bottom:86px}.p-b-87{padding-bottom:87px}.p-b-88{padding-bottom:88px}.p-b-89{padding-bottom:89px}.p-b-90{padding-bottom:90px}.p-b-91{padding-bottom:91px}.p-b-92{padding-bottom:92px}.p-b-93{padding-bottom:93px}.p-b-94{padding-bottom:94px}.p-b-95{padding-bottom:95px}.p-b-96{padding-bottom:96px}.p-b-97{padding-bottom:97px}.p-b-98{padding-bottom:98px}.p-b-99{padding-bottom:99px}.p-b-100{padding-bottom:100px}.p-b-101{padding-bottom:101px}.p-b-102{padding-bottom:102px}.p-b-103{padding-bottom:103px}.p-b-104{padding-bottom:104px}.p-b-105{padding-bottom:105px}.p-b-106{padding-bottom:106px}.p-b-107{padding-bottom:107px}.p-b-108{padding-bottom:108px}.p-b-109{padding-bottom:109px}.p-b-110{padding-bottom:110px}.p-b-111{padding-bottom:111px}.p-b-112{padding-bottom:112px}.p-b-113{padding-bottom:113px}.p-b-114{padding-bottom:114px}.p-b-115{padding-bottom:115px}.p-b-116{padding-bottom:116px}.p-b-117{padding-bottom:117px}.p-b-118{padding-bottom:118px}.p-b-119{padding-bottom:119px}.p-b-120{padding-bottom:120px}.p-b-121{padding-bottom:121px}.p-b-122{padding-bottom:122px}.p-b-123{padding-bottom:123px}.p-b-124{padding-bottom:124px}.p-b-125{padding-bottom:125px}.p-b-126{padding-bottom:126px}.p-b-127{padding-bottom:127px}.p-b-128{padding-bottom:128px}.p-b-129{padding-bottom:129px}.p-b-130{padding-bottom:130px}.p-b-131{padding-bottom:131px}.p-b-132{padding-bottom:132px}.p-b-133{padding-bottom:133px}.p-b-134{padding-bottom:134px}.p-b-135{padding-bottom:135px}.p-b-136{padding-bottom:136px}.p-b-137{padding-bottom:137px}.p-b-138{padding-bottom:138px}.p-b-139{padding-bottom:139px}.p-b-140{padding-bottom:140px}.p-b-141{padding-bottom:141px}.p-b-142{padding-bottom:142px}.p-b-143{padding-bottom:143px}.p-b-144{padding-bottom:144px}.p-b-145{padding-bottom:145px}.p-b-146{padding-bottom:146px}.p-b-147{padding-bottom:147px}.p-b-148{padding-bottom:148px}.p-b-149{padding-bottom:149px}.p-b-150{padding-bottom:150px}.p-b-151{padding-bottom:151px}.p-b-152{padding-bottom:152px}.p-b-153{padding-bottom:153px}.p-b-154{padding-bottom:154px}.p-b-155{padding-bottom:155px}.p-b-156{padding-bottom:156px}.p-b-157{padding-bottom:157px}.p-b-158{padding-bottom:158px}.p-b-159{padding-bottom:159px}.p-b-160{padding-bottom:160px}.p-b-161{padding-bottom:161px}.p-b-162{padding-bottom:162px}.p-b-163{padding-bottom:163px}.p-b-164{padding-bottom:164px}.p-b-165{padding-bottom:165px}.p-b-166{padding-bottom:166px}.p-b-167{padding-bottom:167px}.p-b-168{padding-bottom:168px}.p-b-169{padding-bottom:169px}.p-b-170{padding-bottom:170px}.p-b-171{padding-bottom:171px}.p-b-172{padding-bottom:172px}.p-b-173{padding-bottom:173px}.p-b-174{padding-bottom:174px}.p-b-175{padding-bottom:175px}.p-b-176{padding-bottom:176px}.p-b-177{padding-bottom:177px}.p-b-178{padding-bottom:178px}.p-b-179{padding-bottom:179px}.p-b-180{padding-bottom:180px}.p-b-181{padding-bottom:181px}.p-b-182{padding-bottom:182px}.p-b-183{padding-bottom:183px}.p-b-184{padding-bottom:184px}.p-b-185{padding-bottom:185px}.p-b-186{padding-bottom:186px}.p-b-187{padding-bottom:187px}.p-b-188{padding-bottom:188px}.p-b-189{padding-bottom:189px}.p-b-190{padding-bottom:190px}.p-b-191{padding-bottom:191px}.p-b-192{padding-bottom:192px}.p-b-193{padding-bottom:193px}.p-b-194{padding-bottom:194px}.p-b-195{padding-bottom:195px}.p-b-196{padding-bottom:196px}.p-b-197{padding-bottom:197px}.p-b-198{padding-bottom:198px}.p-b-199{padding-bottom:199px}.p-b-200{padding-bottom:200px}.p-b-201{padding-bottom:201px}.p-b-202{padding-bottom:202px}.p-b-203{padding-bottom:203px}.p-b-204{padding-bottom:204px}.p-b-205{padding-bottom:205px}.p-b-206{padding-bottom:206px}.p-b-207{padding-bottom:207px}.p-b-208{padding-bottom:208px}.p-b-209{padding-bottom:209px}.p-b-210{padding-bottom:210px}.p-b-211{padding-bottom:211px}.p-b-212{padding-bottom:212px}.p-b-213{padding-bottom:213px}.p-b-214{padding-bottom:214px}.p-b-215{padding-bottom:215px}.p-b-216{padding-bottom:216px}.p-b-217{padding-bottom:217px}.p-b-218{padding-bottom:218px}.p-b-219{padding-bottom:219px}.p-b-220{padding-bottom:220px}.p-b-221{padding-bottom:221px}.p-b-222{padding-bottom:222px}.p-b-223{padding-bottom:223px}.p-b-224{padding-bottom:224px}.p-b-225{padding-bottom:225px}.p-b-226{padding-bottom:226px}.p-b-227{padding-bottom:227px}.p-b-228{padding-bottom:228px}.p-b-229{padding-bottom:229px}.p-b-230{padding-bottom:230px}.p-b-231{padding-bottom:231px}.p-b-232{padding-bottom:232px}.p-b-233{padding-bottom:233px}.p-b-234{padding-bottom:234px}.p-b-235{padding-bottom:235px}.p-b-236{padding-bottom:236px}.p-b-237{padding-bottom:237px}.p-b-238{padding-bottom:238px}.p-b-239{padding-bottom:239px}.p-b-240{padding-bottom:240px}.p-b-241{padding-bottom:241px}.p-b-242{padding-bottom:242px}.p-b-243{padding-bottom:243px}.p-b-244{padding-bottom:244px}.p-b-245{padding-bottom:245px}.p-b-246{padding-bottom:246px}.p-b-247{padding-bottom:247px}.p-b-248{padding-bottom:248px}.p-b-249{padding-bottom:249px}.p-b-250{padding-bottom:250px}.p-l-0{padding-left:0}.p-l-1{padding-left:1px}.p-l-2{padding-left:2px}.p-l-3{padding-left:3px}.p-l-4{padding-left:4px}.p-l-5{padding-left:5px}.p-l-6{padding-left:6px}.p-l-7{padding-left:7px}.p-l-8{padding-left:8px}.p-l-9{padding-left:9px}.p-l-10{padding-left:10px}.p-l-11{padding-left:11px}.p-l-12{padding-left:12px}.p-l-13{padding-left:13px}.p-l-14{padding-left:14px}.p-l-15{padding-left:15px}.p-l-16{padding-left:16px}.p-l-17{padding-left:17px}.p-l-18{padding-left:18px}.p-l-19{padding-left:19px}.p-l-20{padding-left:20px}.p-l-21{padding-left:21px}.p-l-22{padding-left:22px}.p-l-23{padding-left:23px}.p-l-24{padding-left:24px}.p-l-25{padding-left:25px}.p-l-26{padding-left:26px}.p-l-27{padding-left:27px}.p-l-28{padding-left:28px}.p-l-29{padding-left:29px}.p-l-30{padding-left:30px}.p-l-31{padding-left:31px}.p-l-32{padding-left:32px}.p-l-33{padding-left:33px}.p-l-34{padding-left:34px}.p-l-35{padding-left:35px}.p-l-36{padding-left:36px}.p-l-37{padding-left:37px}.p-l-38{padding-left:38px}.p-l-39{padding-left:39px}.p-l-40{padding-left:40px}.p-l-41{padding-left:41px}.p-l-42{padding-left:42px}.p-l-43{padding-left:43px}.p-l-44{padding-left:44px}.p-l-45{padding-left:45px}.p-l-46{padding-left:46px}.p-l-47{padding-left:47px}.p-l-48{padding-left:48px}.p-l-49{padding-left:49px}.p-l-50{padding-left:50px}.p-l-51{padding-left:51px}.p-l-52{padding-left:52px}.p-l-53{padding-left:53px}.p-l-54{padding-left:54px}.p-l-55{padding-left:55px}.p-l-56{padding-left:56px}.p-l-57{padding-left:57px}.p-l-58{padding-left:58px}.p-l-59{padding-left:59px}.p-l-60{padding-left:60px}.p-l-61{padding-left:61px}.p-l-62{padding-left:62px}.p-l-63{padding-left:63px}.p-l-64{padding-left:64px}.p-l-65{padding-left:65px}.p-l-66{padding-left:66px}.p-l-67{padding-left:67px}.p-l-68{padding-left:68px}.p-l-69{padding-left:69px}.p-l-70{padding-left:70px}.p-l-71{padding-left:71px}.p-l-72{padding-left:72px}.p-l-73{padding-left:73px}.p-l-74{padding-left:74px}.p-l-75{padding-left:75px}.p-l-76{padding-left:76px}.p-l-77{padding-left:77px}.p-l-78{padding-left:78px}.p-l-79{padding-left:79px}.p-l-80{padding-left:80px}.p-l-81{padding-left:81px}.p-l-82{padding-left:82px}.p-l-83{padding-left:83px}.p-l-84{padding-left:84px}.p-l-85{padding-left:85px}.p-l-86{padding-left:86px}.p-l-87{padding-left:87px}.p-l-88{padding-left:88px}.p-l-89{padding-left:89px}.p-l-90{padding-left:90px}.p-l-91{padding-left:91px}.p-l-92{padding-left:92px}.p-l-93{padding-left:93px}.p-l-94{padding-left:94px}.p-l-95{padding-left:95px}.p-l-96{padding-left:96px}.p-l-97{padding-left:97px}.p-l-98{padding-left:98px}.p-l-99{padding-left:99px}.p-l-100{padding-left:100px}.p-l-101{padding-left:101px}.p-l-102{padding-left:102px}.p-l-103{padding-left:103px}.p-l-104{padding-left:104px}.p-l-105{padding-left:105px}.p-l-106{padding-left:106px}.p-l-107{padding-left:107px}.p-l-108{padding-left:108px}.p-l-109{padding-left:109px}.p-l-110{padding-left:110px}.p-l-111{padding-left:111px}.p-l-112{padding-left:112px}.p-l-113{padding-left:113px}.p-l-114{padding-left:114px}.p-l-115{padding-left:115px}.p-l-116{padding-left:116px}.p-l-117{padding-left:117px}.p-l-118{padding-left:118px}.p-l-119{padding-left:119px}.p-l-120{padding-left:120px}.p-l-121{padding-left:121px}.p-l-122{padding-left:122px}.p-l-123{padding-left:123px}.p-l-124{padding-left:124px}.p-l-125{padding-left:125px}.p-l-126{padding-left:126px}.p-l-127{padding-left:127px}.p-l-128{padding-left:128px}.p-l-129{padding-left:129px}.p-l-130{padding-left:130px}.p-l-131{padding-left:131px}.p-l-132{padding-left:132px}.p-l-133{padding-left:133px}.p-l-134{padding-left:134px}.p-l-135{padding-left:135px}.p-l-136{padding-left:136px}.p-l-137{padding-left:137px}.p-l-138{padding-left:138px}.p-l-139{padding-left:139px}.p-l-140{padding-left:140px}.p-l-141{padding-left:141px}.p-l-142{padding-left:142px}.p-l-143{padding-left:143px}.p-l-144{padding-left:144px}.p-l-145{padding-left:145px}.p-l-146{padding-left:146px}.p-l-147{padding-left:147px}.p-l-148{padding-left:148px}.p-l-149{padding-left:149px}.p-l-150{padding-left:150px}.p-l-151{padding-left:151px}.p-l-152{padding-left:152px}.p-l-153{padding-left:153px}.p-l-154{padding-left:154px}.p-l-155{padding-left:155px}.p-l-156{padding-left:156px}.p-l-157{padding-left:157px}.p-l-158{padding-left:158px}.p-l-159{padding-left:159px}.p-l-160{padding-left:160px}.p-l-161{padding-left:161px}.p-l-162{padding-left:162px}.p-l-163{padding-left:163px}.p-l-164{padding-left:164px}.p-l-165{padding-left:165px}.p-l-166{padding-left:166px}.p-l-167{padding-left:167px}.p-l-168{padding-left:168px}.p-l-169{padding-left:169px}.p-l-170{padding-left:170px}.p-l-171{padding-left:171px}.p-l-172{padding-left:172px}.p-l-173{padding-left:173px}.p-l-174{padding-left:174px}.p-l-175{padding-left:175px}.p-l-176{padding-left:176px}.p-l-177{padding-left:177px}.p-l-178{padding-left:178px}.p-l-179{padding-left:179px}.p-l-180{padding-left:180px}.p-l-181{padding-left:181px}.p-l-182{padding-left:182px}.p-l-183{padding-left:183px}.p-l-184{padding-left:184px}.p-l-185{padding-left:185px}.p-l-186{padding-left:186px}.p-l-187{padding-left:187px}.p-l-188{padding-left:188px}.p-l-189{padding-left:189px}.p-l-190{padding-left:190px}.p-l-191{padding-left:191px}.p-l-192{padding-left:192px}.p-l-193{padding-left:193px}.p-l-194{padding-left:194px}.p-l-195{padding-left:195px}.p-l-196{padding-left:196px}.p-l-197{padding-left:197px}.p-l-198{padding-left:198px}.p-l-199{padding-left:199px}.p-l-200{padding-left:200px}.p-l-201{padding-left:201px}.p-l-202{padding-left:202px}.p-l-203{padding-left:203px}.p-l-204{padding-left:204px}.p-l-205{padding-left:205px}.p-l-206{padding-left:206px}.p-l-207{padding-left:207px}.p-l-208{padding-left:208px}.p-l-209{padding-left:209px}.p-l-210{padding-left:210px}.p-l-211{padding-left:211px}.p-l-212{padding-left:212px}.p-l-213{padding-left:213px}.p-l-214{padding-left:214px}.p-l-215{padding-left:215px}.p-l-216{padding-left:216px}.p-l-217{padding-left:217px}.p-l-218{padding-left:218px}.p-l-219{padding-left:219px}.p-l-220{padding-left:220px}.p-l-221{padding-left:221px}.p-l-222{padding-left:222px}.p-l-223{padding-left:223px}.p-l-224{padding-left:224px}.p-l-225{padding-left:225px}.p-l-226{padding-left:226px}.p-l-227{padding-left:227px}.p-l-228{padding-left:228px}.p-l-229{padding-left:229px}.p-l-230{padding-left:230px}.p-l-231{padding-left:231px}.p-l-232{padding-left:232px}.p-l-233{padding-left:233px}.p-l-234{padding-left:234px}.p-l-235{padding-left:235px}.p-l-236{padding-left:236px}.p-l-237{padding-left:237px}.p-l-238{padding-left:238px}.p-l-239{padding-left:239px}.p-l-240{padding-left:240px}.p-l-241{padding-left:241px}.p-l-242{padding-left:242px}.p-l-243{padding-left:243px}.p-l-244{padding-left:244px}.p-l-245{padding-left:245px}.p-l-246{padding-left:246px}.p-l-247{padding-left:247px}.p-l-248{padding-left:248px}.p-l-249{padding-left:249px}.p-l-250{padding-left:250px}.p-r-0{padding-right:0}.p-r-1{padding-right:1px}.p-r-2{padding-right:2px}.p-r-3{padding-right:3px}.p-r-4{padding-right:4px}.p-r-5{padding-right:5px}.p-r-6{padding-right:6px}.p-r-7{padding-right:7px}.p-r-8{padding-right:8px}.p-r-9{padding-right:9px}.p-r-10{padding-right:10px}.p-r-11{padding-right:11px}.p-r-12{padding-right:12px}.p-r-13{padding-right:13px}.p-r-14{padding-right:14px}.p-r-15{padding-right:15px}.p-r-16{padding-right:16px}.p-r-17{padding-right:17px}.p-r-18{padding-right:18px}.p-r-19{padding-right:19px}.p-r-20{padding-right:20px}.p-r-21{padding-right:21px}.p-r-22{padding-right:22px}.p-r-23{padding-right:23px}.p-r-24{padding-right:24px}.p-r-25{padding-right:25px}.p-r-26{padding-right:26px}.p-r-27{padding-right:27px}.p-r-28{padding-right:28px}.p-r-29{padding-right:29px}.p-r-30{padding-right:30px}.p-r-31{padding-right:31px}.p-r-32{padding-right:32px}.p-r-33{padding-right:33px}.p-r-34{padding-right:34px}.p-r-35{padding-right:35px}.p-r-36{padding-right:36px}.p-r-37{padding-right:37px}.p-r-38{padding-right:38px}.p-r-39{padding-right:39px}.p-r-40{padding-right:40px}.p-r-41{padding-right:41px}.p-r-42{padding-right:42px}.p-r-43{padding-right:43px}.p-r-44{padding-right:44px}.p-r-45{padding-right:45px}.p-r-46{padding-right:46px}.p-r-47{padding-right:47px}.p-r-48{padding-right:48px}.p-r-49{padding-right:49px}.p-r-50{padding-right:50px}.p-r-51{padding-right:51px}.p-r-52{padding-right:52px}.p-r-53{padding-right:53px}.p-r-54{padding-right:54px}.p-r-55{padding-right:55px}.p-r-56{padding-right:56px}.p-r-57{padding-right:57px}.p-r-58{padding-right:58px}.p-r-59{padding-right:59px}.p-r-60{padding-right:60px}.p-r-61{padding-right:61px}.p-r-62{padding-right:62px}.p-r-63{padding-right:63px}.p-r-64{padding-right:64px}.p-r-65{padding-right:65px}.p-r-66{padding-right:66px}.p-r-67{padding-right:67px}.p-r-68{padding-right:68px}.p-r-69{padding-right:69px}.p-r-70{padding-right:70px}.p-r-71{padding-right:71px}.p-r-72{padding-right:72px}.p-r-73{padding-right:73px}.p-r-74{padding-right:74px}.p-r-75{padding-right:75px}.p-r-76{padding-right:76px}.p-r-77{padding-right:77px}.p-r-78{padding-right:78px}.p-r-79{padding-right:79px}.p-r-80{padding-right:80px}.p-r-81{padding-right:81px}.p-r-82{padding-right:82px}.p-r-83{padding-right:83px}.p-r-84{padding-right:84px}.p-r-85{padding-right:85px}.p-r-86{padding-right:86px}.p-r-87{padding-right:87px}.p-r-88{padding-right:88px}.p-r-89{padding-right:89px}.p-r-90{padding-right:90px}.p-r-91{padding-right:91px}.p-r-92{padding-right:92px}.p-r-93{padding-right:93px}.p-r-94{padding-right:94px}.p-r-95{padding-right:95px}.p-r-96{padding-right:96px}.p-r-97{padding-right:97px}.p-r-98{padding-right:98px}.p-r-99{padding-right:99px}.p-r-100{padding-right:100px}.p-r-101{padding-right:101px}.p-r-102{padding-right:102px}.p-r-103{padding-right:103px}.p-r-104{padding-right:104px}.p-r-105{padding-right:105px}.p-r-106{padding-right:106px}.p-r-107{padding-right:107px}.p-r-108{padding-right:108px}.p-r-109{padding-right:109px}.p-r-110{padding-right:110px}.p-r-111{padding-right:111px}.p-r-112{padding-right:112px}.p-r-113{padding-right:113px}.p-r-114{padding-right:114px}.p-r-115{padding-right:115px}.p-r-116{padding-right:116px}.p-r-117{padding-right:117px}.p-r-118{padding-right:118px}.p-r-119{padding-right:119px}.p-r-120{padding-right:120px}.p-r-121{padding-right:121px}.p-r-122{padding-right:122px}.p-r-123{padding-right:123px}.p-r-124{padding-right:124px}.p-r-125{padding-right:125px}.p-r-126{padding-right:126px}.p-r-127{padding-right:127px}.p-r-128{padding-right:128px}.p-r-129{padding-right:129px}.p-r-130{padding-right:130px}.p-r-131{padding-right:131px}.p-r-132{padding-right:132px}.p-r-133{padding-right:133px}.p-r-134{padding-right:134px}.p-r-135{padding-right:135px}.p-r-136{padding-right:136px}.p-r-137{padding-right:137px}.p-r-138{padding-right:138px}.p-r-139{padding-right:139px}.p-r-140{padding-right:140px}.p-r-141{padding-right:141px}.p-r-142{padding-right:142px}.p-r-143{padding-right:143px}.p-r-144{padding-right:144px}.p-r-145{padding-right:145px}.p-r-146{padding-right:146px}.p-r-147{padding-right:147px}.p-r-148{padding-right:148px}.p-r-149{padding-right:149px}.p-r-150{padding-right:150px}.p-r-151{padding-right:151px}.p-r-152{padding-right:152px}.p-r-153{padding-right:153px}.p-r-154{padding-right:154px}.p-r-155{padding-right:155px}.p-r-156{padding-right:156px}.p-r-157{padding-right:157px}.p-r-158{padding-right:158px}.p-r-159{padding-right:159px}.p-r-160{padding-right:160px}.p-r-161{padding-right:161px}.p-r-162{padding-right:162px}.p-r-163{padding-right:163px}.p-r-164{padding-right:164px}.p-r-165{padding-right:165px}.p-r-166{padding-right:166px}.p-r-167{padding-right:167px}.p-r-168{padding-right:168px}.p-r-169{padding-right:169px}.p-r-170{padding-right:170px}.p-r-171{padding-right:171px}.p-r-172{padding-right:172px}.p-r-173{padding-right:173px}.p-r-174{padding-right:174px}.p-r-175{padding-right:175px}.p-r-176{padding-right:176px}.p-r-177{padding-right:177px}.p-r-178{padding-right:178px}.p-r-179{padding-right:179px}.p-r-180{padding-right:180px}.p-r-181{padding-right:181px}.p-r-182{padding-right:182px}.p-r-183{padding-right:183px}.p-r-184{padding-right:184px}.p-r-185{padding-right:185px}.p-r-186{padding-right:186px}.p-r-187{padding-right:187px}.p-r-188{padding-right:188px}.p-r-189{padding-right:189px}.p-r-190{padding-right:190px}.p-r-191{padding-right:191px}.p-r-192{padding-right:192px}.p-r-193{padding-right:193px}.p-r-194{padding-right:194px}.p-r-195{padding-right:195px}.p-r-196{padding-right:196px}.p-r-197{padding-right:197px}.p-r-198{padding-right:198px}.p-r-199{padding-right:199px}.p-r-200{padding-right:200px}.p-r-201{padding-right:201px}.p-r-202{padding-right:202px}.p-r-203{padding-right:203px}.p-r-204{padding-right:204px}.p-r-205{padding-right:205px}.p-r-206{padding-right:206px}.p-r-207{padding-right:207px}.p-r-208{padding-right:208px}.p-r-209{padding-right:209px}.p-r-210{padding-right:210px}.p-r-211{padding-right:211px}.p-r-212{padding-right:212px}.p-r-213{padding-right:213px}.p-r-214{padding-right:214px}.p-r-215{padding-right:215px}.p-r-216{padding-right:216px}.p-r-217{padding-right:217px}.p-r-218{padding-right:218px}.p-r-219{padding-right:219px}.p-r-220{padding-right:220px}.p-r-221{padding-right:221px}.p-r-222{padding-right:222px}.p-r-223{padding-right:223px}.p-r-224{padding-right:224px}.p-r-225{padding-right:225px}.p-r-226{padding-right:226px}.p-r-227{padding-right:227px}.p-r-228{padding-right:228px}.p-r-229{padding-right:229px}.p-r-230{padding-right:230px}.p-r-231{padding-right:231px}.p-r-232{padding-right:232px}.p-r-233{padding-right:233px}.p-r-234{padding-right:234px}.p-r-235{padding-right:235px}.p-r-236{padding-right:236px}.p-r-237{padding-right:237px}.p-r-238{padding-right:238px}.p-r-239{padding-right:239px}.p-r-240{padding-right:240px}.p-r-241{padding-right:241px}.p-r-242{padding-right:242px}.p-r-243{padding-right:243px}.p-r-244{padding-right:244px}.p-r-245{padding-right:245px}.p-r-246{padding-right:246px}.p-r-247{padding-right:247px}.p-r-248{padding-right:248px}.p-r-249{padding-right:249px}.p-r-250{padding-right:250px}.m-t-0{margin-top:0}.m-t-1{margin-top:1px}.m-t-2{margin-top:2px}.m-t-3{margin-top:3px}.m-t-4{margin-top:4px}.m-t-5{margin-top:5px}.m-t-6{margin-top:6px}.m-t-7{margin-top:7px}.m-t-8{margin-top:8px}.m-t-9{margin-top:9px}.m-t-10{margin-top:10px}.m-t-11{margin-top:11px}.m-t-12{margin-top:12px}.m-t-13{margin-top:13px}.m-t-14{margin-top:14px}.m-t-15{margin-top:15px}.m-t-16{margin-top:16px}.m-t-17{margin-top:17px}.m-t-18{margin-top:18px}.m-t-19{margin-top:19px}.m-t-20{margin-top:20px}.m-t-21{margin-top:21px}.m-t-22{margin-top:22px}.m-t-23{margin-top:23px}.m-t-24{margin-top:24px}.m-t-25{margin-top:25px}.m-t-26{margin-top:26px}.m-t-27{margin-top:27px}.m-t-28{margin-top:28px}.m-t-29{margin-top:29px}.m-t-30{margin-top:30px}.m-t-31{margin-top:31px}.m-t-32{margin-top:32px}.m-t-33{margin-top:33px}.m-t-34{margin-top:34px}.m-t-35{margin-top:35px}.m-t-36{margin-top:36px}.m-t-37{margin-top:37px}.m-t-38{margin-top:38px}.m-t-39{margin-top:39px}.m-t-40{margin-top:40px}.m-t-41{margin-top:41px}.m-t-42{margin-top:42px}.m-t-43{margin-top:43px}.m-t-44{margin-top:44px}.m-t-45{margin-top:45px}.m-t-46{margin-top:46px}.m-t-47{margin-top:47px}.m-t-48{margin-top:48px}.m-t-49{margin-top:49px}.m-t-50{margin-top:50px}.m-t-51{margin-top:51px}.m-t-52{margin-top:52px}.m-t-53{margin-top:53px}.m-t-54{margin-top:54px}.m-t-55{margin-top:55px}.m-t-56{margin-top:56px}.m-t-57{margin-top:57px}.m-t-58{margin-top:58px}.m-t-59{margin-top:59px}.m-t-60{margin-top:60px}.m-t-61{margin-top:61px}.m-t-62{margin-top:62px}.m-t-63{margin-top:63px}.m-t-64{margin-top:64px}.m-t-65{margin-top:65px}.m-t-66{margin-top:66px}.m-t-67{margin-top:67px}.m-t-68{margin-top:68px}.m-t-69{margin-top:69px}.m-t-70{margin-top:70px}.m-t-71{margin-top:71px}.m-t-72{margin-top:72px}.m-t-73{margin-top:73px}.m-t-74{margin-top:74px}.m-t-75{margin-top:75px}.m-t-76{margin-top:76px}.m-t-77{margin-top:77px}.m-t-78{margin-top:78px}.m-t-79{margin-top:79px}.m-t-80{margin-top:80px}.m-t-81{margin-top:81px}.m-t-82{margin-top:82px}.m-t-83{margin-top:83px}.m-t-84{margin-top:84px}.m-t-85{margin-top:85px}.m-t-86{margin-top:86px}.m-t-87{margin-top:87px}.m-t-88{margin-top:88px}.m-t-89{margin-top:89px}.m-t-90{margin-top:90px}.m-t-91{margin-top:91px}.m-t-92{margin-top:92px}.m-t-93{margin-top:93px}.m-t-94{margin-top:94px}.m-t-95{margin-top:95px}.m-t-96{margin-top:96px}.m-t-97{margin-top:97px}.m-t-98{margin-top:98px}.m-t-99{margin-top:99px}.m-t-100{margin-top:100px}.m-t-101{margin-top:101px}.m-t-102{margin-top:102px}.m-t-103{margin-top:103px}.m-t-104{margin-top:104px}.m-t-105{margin-top:105px}.m-t-106{margin-top:106px}.m-t-107{margin-top:107px}.m-t-108{margin-top:108px}.m-t-109{margin-top:109px}.m-t-110{margin-top:110px}.m-t-111{margin-top:111px}.m-t-112{margin-top:112px}.m-t-113{margin-top:113px}.m-t-114{margin-top:114px}.m-t-115{margin-top:115px}.m-t-116{margin-top:116px}.m-t-117{margin-top:117px}.m-t-118{margin-top:118px}.m-t-119{margin-top:119px}.m-t-120{margin-top:120px}.m-t-121{margin-top:121px}.m-t-122{margin-top:122px}.m-t-123{margin-top:123px}.m-t-124{margin-top:124px}.m-t-125{margin-top:125px}.m-t-126{margin-top:126px}.m-t-127{margin-top:127px}.m-t-128{margin-top:128px}.m-t-129{margin-top:129px}.m-t-130{margin-top:130px}.m-t-131{margin-top:131px}.m-t-132{margin-top:132px}.m-t-133{margin-top:133px}.m-t-134{margin-top:134px}.m-t-135{margin-top:135px}.m-t-136{margin-top:136px}.m-t-137{margin-top:137px}.m-t-138{margin-top:138px}.m-t-139{margin-top:139px}.m-t-140{margin-top:140px}.m-t-141{margin-top:141px}.m-t-142{margin-top:142px}.m-t-143{margin-top:143px}.m-t-144{margin-top:144px}.m-t-145{margin-top:145px}.m-t-146{margin-top:146px}.m-t-147{margin-top:147px}.m-t-148{margin-top:148px}.m-t-149{margin-top:149px}.m-t-150{margin-top:150px}.m-t-151{margin-top:151px}.m-t-152{margin-top:152px}.m-t-153{margin-top:153px}.m-t-154{margin-top:154px}.m-t-155{margin-top:155px}.m-t-156{margin-top:156px}.m-t-157{margin-top:157px}.m-t-158{margin-top:158px}.m-t-159{margin-top:159px}.m-t-160{margin-top:160px}.m-t-161{margin-top:161px}.m-t-162{margin-top:162px}.m-t-163{margin-top:163px}.m-t-164{margin-top:164px}.m-t-165{margin-top:165px}.m-t-166{margin-top:166px}.m-t-167{margin-top:167px}.m-t-168{margin-top:168px}.m-t-169{margin-top:169px}.m-t-170{margin-top:170px}.m-t-171{margin-top:171px}.m-t-172{margin-top:172px}.m-t-173{margin-top:173px}.m-t-174{margin-top:174px}.m-t-175{margin-top:175px}.m-t-176{margin-top:176px}.m-t-177{margin-top:177px}.m-t-178{margin-top:178px}.m-t-179{margin-top:179px}.m-t-180{margin-top:180px}.m-t-181{margin-top:181px}.m-t-182{margin-top:182px}.m-t-183{margin-top:183px}.m-t-184{margin-top:184px}.m-t-185{margin-top:185px}.m-t-186{margin-top:186px}.m-t-187{margin-top:187px}.m-t-188{margin-top:188px}.m-t-189{margin-top:189px}.m-t-190{margin-top:190px}.m-t-191{margin-top:191px}.m-t-192{margin-top:192px}.m-t-193{margin-top:193px}.m-t-194{margin-top:194px}.m-t-195{margin-top:195px}.m-t-196{margin-top:196px}.m-t-197{margin-top:197px}.m-t-198{margin-top:198px}.m-t-199{margin-top:199px}.m-t-200{margin-top:200px}.m-t-201{margin-top:201px}.m-t-202{margin-top:202px}.m-t-203{margin-top:203px}.m-t-204{margin-top:204px}.m-t-205{margin-top:205px}.m-t-206{margin-top:206px}.m-t-207{margin-top:207px}.m-t-208{margin-top:208px}.m-t-209{margin-top:209px}.m-t-210{margin-top:210px}.m-t-211{margin-top:211px}.m-t-212{margin-top:212px}.m-t-213{margin-top:213px}.m-t-214{margin-top:214px}.m-t-215{margin-top:215px}.m-t-216{margin-top:216px}.m-t-217{margin-top:217px}.m-t-218{margin-top:218px}.m-t-219{margin-top:219px}.m-t-220{margin-top:220px}.m-t-221{margin-top:221px}.m-t-222{margin-top:222px}.m-t-223{margin-top:223px}.m-t-224{margin-top:224px}.m-t-225{margin-top:225px}.m-t-226{margin-top:226px}.m-t-227{margin-top:227px}.m-t-228{margin-top:228px}.m-t-229{margin-top:229px}.m-t-230{margin-top:230px}.m-t-231{margin-top:231px}.m-t-232{margin-top:232px}.m-t-233{margin-top:233px}.m-t-234{margin-top:234px}.m-t-235{margin-top:235px}.m-t-236{margin-top:236px}.m-t-237{margin-top:237px}.m-t-238{margin-top:238px}.m-t-239{margin-top:239px}.m-t-240{margin-top:240px}.m-t-241{margin-top:241px}.m-t-242{margin-top:242px}.m-t-243{margin-top:243px}.m-t-244{margin-top:244px}.m-t-245{margin-top:245px}.m-t-246{margin-top:246px}.m-t-247{margin-top:247px}.m-t-248{margin-top:248px}.m-t-249{margin-top:249px}.m-t-250{margin-top:250px}.m-b-0{margin-bottom:0}.m-b-1{margin-bottom:1px}.m-b-2{margin-bottom:2px}.m-b-3{margin-bottom:3px}.m-b-4{margin-bottom:4px}.m-b-5{margin-bottom:5px}.m-b-6{margin-bottom:6px}.m-b-7{margin-bottom:7px}.m-b-8{margin-bottom:8px}.m-b-9{margin-bottom:9px}.m-b-10{margin-bottom:10px}.m-b-11{margin-bottom:11px}.m-b-12{margin-bottom:12px}.m-b-13{margin-bottom:13px}.m-b-14{margin-bottom:14px}.m-b-15{margin-bottom:15px}.m-b-16{margin-bottom:16px}.m-b-17{margin-bottom:17px}.m-b-18{margin-bottom:18px}.m-b-19{margin-bottom:19px}.m-b-20{margin-bottom:20px}.m-b-21{margin-bottom:21px}.m-b-22{margin-bottom:22px}.m-b-23{margin-bottom:23px}.m-b-24{margin-bottom:24px}.m-b-25{margin-bottom:25px}.m-b-26{margin-bottom:26px}.m-b-27{margin-bottom:27px}.m-b-28{margin-bottom:28px}.m-b-29{margin-bottom:29px}.m-b-30{margin-bottom:30px}.m-b-31{margin-bottom:31px}.m-b-32{margin-bottom:32px}.m-b-33{margin-bottom:33px}.m-b-34{margin-bottom:34px}.m-b-35{margin-bottom:35px}.m-b-36{margin-bottom:36px}.m-b-37{margin-bottom:37px}.m-b-38{margin-bottom:38px}.m-b-39{margin-bottom:39px}.m-b-40{margin-bottom:40px}.m-b-41{margin-bottom:41px}.m-b-42{margin-bottom:42px}.m-b-43{margin-bottom:43px}.m-b-44{margin-bottom:44px}.m-b-45{margin-bottom:45px}.m-b-46{margin-bottom:46px}.m-b-47{margin-bottom:47px}.m-b-48{margin-bottom:48px}.m-b-49{margin-bottom:49px}.m-b-50{margin-bottom:50px}.m-b-51{margin-bottom:51px}.m-b-52{margin-bottom:52px}.m-b-53{margin-bottom:53px}.m-b-54{margin-bottom:54px}.m-b-55{margin-bottom:55px}.m-b-56{margin-bottom:56px}.m-b-57{margin-bottom:57px}.m-b-58{margin-bottom:58px}.m-b-59{margin-bottom:59px}.m-b-60{margin-bottom:60px}.m-b-61{margin-bottom:61px}.m-b-62{margin-bottom:62px}.m-b-63{margin-bottom:63px}.m-b-64{margin-bottom:64px}.m-b-65{margin-bottom:65px}.m-b-66{margin-bottom:66px}.m-b-67{margin-bottom:67px}.m-b-68{margin-bottom:68px}.m-b-69{margin-bottom:69px}.m-b-70{margin-bottom:70px}.m-b-71{margin-bottom:71px}.m-b-72{margin-bottom:72px}.m-b-73{margin-bottom:73px}.m-b-74{margin-bottom:74px}.m-b-75{margin-bottom:75px}.m-b-76{margin-bottom:76px}.m-b-77{margin-bottom:77px}.m-b-78{margin-bottom:78px}.m-b-79{margin-bottom:79px}.m-b-80{margin-bottom:80px}.m-b-81{margin-bottom:81px}.m-b-82{margin-bottom:82px}.m-b-83{margin-bottom:83px}.m-b-84{margin-bottom:84px}.m-b-85{margin-bottom:85px}.m-b-86{margin-bottom:86px}.m-b-87{margin-bottom:87px}.m-b-88{margin-bottom:88px}.m-b-89{margin-bottom:89px}.m-b-90{margin-bottom:90px}.m-b-91{margin-bottom:91px}.m-b-92{margin-bottom:92px}.m-b-93{margin-bottom:93px}.m-b-94{margin-bottom:94px}.m-b-95{margin-bottom:95px}.m-b-96{margin-bottom:96px}.m-b-97{margin-bottom:97px}.m-b-98{margin-bottom:98px}.m-b-99{margin-bottom:99px}.m-b-100{margin-bottom:100px}.m-b-101{margin-bottom:101px}.m-b-102{margin-bottom:102px}.m-b-103{margin-bottom:103px}.m-b-104{margin-bottom:104px}.m-b-105{margin-bottom:105px}.m-b-106{margin-bottom:106px}.m-b-107{margin-bottom:107px}.m-b-108{margin-bottom:108px}.m-b-109{margin-bottom:109px}.m-b-110{margin-bottom:110px}.m-b-111{margin-bottom:111px}.m-b-112{margin-bottom:112px}.m-b-113{margin-bottom:113px}.m-b-114{margin-bottom:114px}.m-b-115{margin-bottom:115px}.m-b-116{margin-bottom:116px}.m-b-117{margin-bottom:117px}.m-b-118{margin-bottom:118px}.m-b-119{margin-bottom:119px}.m-b-120{margin-bottom:120px}.m-b-121{margin-bottom:121px}.m-b-122{margin-bottom:122px}.m-b-123{margin-bottom:123px}.m-b-124{margin-bottom:124px}.m-b-125{margin-bottom:125px}.m-b-126{margin-bottom:126px}.m-b-127{margin-bottom:127px}.m-b-128{margin-bottom:128px}.m-b-129{margin-bottom:129px}.m-b-130{margin-bottom:130px}.m-b-131{margin-bottom:131px}.m-b-132{margin-bottom:132px}.m-b-133{margin-bottom:133px}.m-b-134{margin-bottom:134px}.m-b-135{margin-bottom:135px}.m-b-136{margin-bottom:136px}.m-b-137{margin-bottom:137px}.m-b-138{margin-bottom:138px}.m-b-139{margin-bottom:139px}.m-b-140{margin-bottom:140px}.m-b-141{margin-bottom:141px}.m-b-142{margin-bottom:142px}.m-b-143{margin-bottom:143px}.m-b-144{margin-bottom:144px}.m-b-145{margin-bottom:145px}.m-b-146{margin-bottom:146px}.m-b-147{margin-bottom:147px}.m-b-148{margin-bottom:148px}.m-b-149{margin-bottom:149px}.m-b-150{margin-bottom:150px}.m-b-151{margin-bottom:151px}.m-b-152{margin-bottom:152px}.m-b-153{margin-bottom:153px}.m-b-154{margin-bottom:154px}.m-b-155{margin-bottom:155px}.m-b-156{margin-bottom:156px}.m-b-157{margin-bottom:157px}.m-b-158{margin-bottom:158px}.m-b-159{margin-bottom:159px}.m-b-160{margin-bottom:160px}.m-b-161{margin-bottom:161px}.m-b-162{margin-bottom:162px}.m-b-163{margin-bottom:163px}.m-b-164{margin-bottom:164px}.m-b-165{margin-bottom:165px}.m-b-166{margin-bottom:166px}.m-b-167{margin-bottom:167px}.m-b-168{margin-bottom:168px}.m-b-169{margin-bottom:169px}.m-b-170{margin-bottom:170px}.m-b-171{margin-bottom:171px}.m-b-172{margin-bottom:172px}.m-b-173{margin-bottom:173px}.m-b-174{margin-bottom:174px}.m-b-175{margin-bottom:175px}.m-b-176{margin-bottom:176px}.m-b-177{margin-bottom:177px}.m-b-178{margin-bottom:178px}.m-b-179{margin-bottom:179px}.m-b-180{margin-bottom:180px}.m-b-181{margin-bottom:181px}.m-b-182{margin-bottom:182px}.m-b-183{margin-bottom:183px}.m-b-184{margin-bottom:184px}.m-b-185{margin-bottom:185px}.m-b-186{margin-bottom:186px}.m-b-187{margin-bottom:187px}.m-b-188{margin-bottom:188px}.m-b-189{margin-bottom:189px}.m-b-190{margin-bottom:190px}.m-b-191{margin-bottom:191px}.m-b-192{margin-bottom:192px}.m-b-193{margin-bottom:193px}.m-b-194{margin-bottom:194px}.m-b-195{margin-bottom:195px}.m-b-196{margin-bottom:196px}.m-b-197{margin-bottom:197px}.m-b-198{margin-bottom:198px}.m-b-199{margin-bottom:199px}.m-b-200{margin-bottom:200px}.m-b-201{margin-bottom:201px}.m-b-202{margin-bottom:202px}.m-b-203{margin-bottom:203px}.m-b-204{margin-bottom:204px}.m-b-205{margin-bottom:205px}.m-b-206{margin-bottom:206px}.m-b-207{margin-bottom:207px}.m-b-208{margin-bottom:208px}.m-b-209{margin-bottom:209px}.m-b-210{margin-bottom:210px}.m-b-211{margin-bottom:211px}.m-b-212{margin-bottom:212px}.m-b-213{margin-bottom:213px}.m-b-214{margin-bottom:214px}.m-b-215{margin-bottom:215px}.m-b-216{margin-bottom:216px}.m-b-217{margin-bottom:217px}.m-b-218{margin-bottom:218px}.m-b-219{margin-bottom:219px}.m-b-220{margin-bottom:220px}.m-b-221{margin-bottom:221px}.m-b-222{margin-bottom:222px}.m-b-223{margin-bottom:223px}.m-b-224{margin-bottom:224px}.m-b-225{margin-bottom:225px}.m-b-226{margin-bottom:226px}.m-b-227{margin-bottom:227px}.m-b-228{margin-bottom:228px}.m-b-229{margin-bottom:229px}.m-b-230{margin-bottom:230px}.m-b-231{margin-bottom:231px}.m-b-232{margin-bottom:232px}.m-b-233{margin-bottom:233px}.m-b-234{margin-bottom:234px}.m-b-235{margin-bottom:235px}.m-b-236{margin-bottom:236px}.m-b-237{margin-bottom:237px}.m-b-238{margin-bottom:238px}.m-b-239{margin-bottom:239px}.m-b-240{margin-bottom:240px}.m-b-241{margin-bottom:241px}.m-b-242{margin-bottom:242px}.m-b-243{margin-bottom:243px}.m-b-244{margin-bottom:244px}.m-b-245{margin-bottom:245px}.m-b-246{margin-bottom:246px}.m-b-247{margin-bottom:247px}.m-b-248{margin-bottom:248px}.m-b-249{margin-bottom:249px}.m-b-250{margin-bottom:250px}.m-l-0{margin-left:0}.m-l-1{margin-left:1px}.m-l-2{margin-left:2px}.m-l-3{margin-left:3px}.m-l-4{margin-left:4px}.m-l-5{margin-left:5px}.m-l-6{margin-left:6px}.m-l-7{margin-left:7px}.m-l-8{margin-left:8px}.m-l-9{margin-left:9px}.m-l-10{margin-left:10px}.m-l-11{margin-left:11px}.m-l-12{margin-left:12px}.m-l-13{margin-left:13px}.m-l-14{margin-left:14px}.m-l-15{margin-left:15px}.m-l-16{margin-left:16px}.m-l-17{margin-left:17px}.m-l-18{margin-left:18px}.m-l-19{margin-left:19px}.m-l-20{margin-left:20px}.m-l-21{margin-left:21px}.m-l-22{margin-left:22px}.m-l-23{margin-left:23px}.m-l-24{margin-left:24px}.m-l-25{margin-left:25px}.m-l-26{margin-left:26px}.m-l-27{margin-left:27px}.m-l-28{margin-left:28px}.m-l-29{margin-left:29px}.m-l-30{margin-left:30px}.m-l-31{margin-left:31px}.m-l-32{margin-left:32px}.m-l-33{margin-left:33px}.m-l-34{margin-left:34px}.m-l-35{margin-left:35px}.m-l-36{margin-left:36px}.m-l-37{margin-left:37px}.m-l-38{margin-left:38px}.m-l-39{margin-left:39px}.m-l-40{margin-left:40px}.m-l-41{margin-left:41px}.m-l-42{margin-left:42px}.m-l-43{margin-left:43px}.m-l-44{margin-left:44px}.m-l-45{margin-left:45px}.m-l-46{margin-left:46px}.m-l-47{margin-left:47px}.m-l-48{margin-left:48px}.m-l-49{margin-left:49px}.m-l-50{margin-left:50px}.m-l-51{margin-left:51px}.m-l-52{margin-left:52px}.m-l-53{margin-left:53px}.m-l-54{margin-left:54px}.m-l-55{margin-left:55px}.m-l-56{margin-left:56px}.m-l-57{margin-left:57px}.m-l-58{margin-left:58px}.m-l-59{margin-left:59px}.m-l-60{margin-left:60px}.m-l-61{margin-left:61px}.m-l-62{margin-left:62px}.m-l-63{margin-left:63px}.m-l-64{margin-left:64px}.m-l-65{margin-left:65px}.m-l-66{margin-left:66px}.m-l-67{margin-left:67px}.m-l-68{margin-left:68px}.m-l-69{margin-left:69px}.m-l-70{margin-left:70px}.m-l-71{margin-left:71px}.m-l-72{margin-left:72px}.m-l-73{margin-left:73px}.m-l-74{margin-left:74px}.m-l-75{margin-left:75px}.m-l-76{margin-left:76px}.m-l-77{margin-left:77px}.m-l-78{margin-left:78px}.m-l-79{margin-left:79px}.m-l-80{margin-left:80px}.m-l-81{margin-left:81px}.m-l-82{margin-left:82px}.m-l-83{margin-left:83px}.m-l-84{margin-left:84px}.m-l-85{margin-left:85px}.m-l-86{margin-left:86px}.m-l-87{margin-left:87px}.m-l-88{margin-left:88px}.m-l-89{margin-left:89px}.m-l-90{margin-left:90px}.m-l-91{margin-left:91px}.m-l-92{margin-left:92px}.m-l-93{margin-left:93px}.m-l-94{margin-left:94px}.m-l-95{margin-left:95px}.m-l-96{margin-left:96px}.m-l-97{margin-left:97px}.m-l-98{margin-left:98px}.m-l-99{margin-left:99px}.m-l-100{margin-left:100px}.m-l-101{margin-left:101px}.m-l-102{margin-left:102px}.m-l-103{margin-left:103px}.m-l-104{margin-left:104px}.m-l-105{margin-left:105px}.m-l-106{margin-left:106px}.m-l-107{margin-left:107px}.m-l-108{margin-left:108px}.m-l-109{margin-left:109px}.m-l-110{margin-left:110px}.m-l-111{margin-left:111px}.m-l-112{margin-left:112px}.m-l-113{margin-left:113px}.m-l-114{margin-left:114px}.m-l-115{margin-left:115px}.m-l-116{margin-left:116px}.m-l-117{margin-left:117px}.m-l-118{margin-left:118px}.m-l-119{margin-left:119px}.m-l-120{margin-left:120px}.m-l-121{margin-left:121px}.m-l-122{margin-left:122px}.m-l-123{margin-left:123px}.m-l-124{margin-left:124px}.m-l-125{margin-left:125px}.m-l-126{margin-left:126px}.m-l-127{margin-left:127px}.m-l-128{margin-left:128px}.m-l-129{margin-left:129px}.m-l-130{margin-left:130px}.m-l-131{margin-left:131px}.m-l-132{margin-left:132px}.m-l-133{margin-left:133px}.m-l-134{margin-left:134px}.m-l-135{margin-left:135px}.m-l-136{margin-left:136px}.m-l-137{margin-left:137px}.m-l-138{margin-left:138px}.m-l-139{margin-left:139px}.m-l-140{margin-left:140px}.m-l-141{margin-left:141px}.m-l-142{margin-left:142px}.m-l-143{margin-left:143px}.m-l-144{margin-left:144px}.m-l-145{margin-left:145px}.m-l-146{margin-left:146px}.m-l-147{margin-left:147px}.m-l-148{margin-left:148px}.m-l-149{margin-left:149px}.m-l-150{margin-left:150px}.m-l-151{margin-left:151px}.m-l-152{margin-left:152px}.m-l-153{margin-left:153px}.m-l-154{margin-left:154px}.m-l-155{margin-left:155px}.m-l-156{margin-left:156px}.m-l-157{margin-left:157px}.m-l-158{margin-left:158px}.m-l-159{margin-left:159px}.m-l-160{margin-left:160px}.m-l-161{margin-left:161px}.m-l-162{margin-left:162px}.m-l-163{margin-left:163px}.m-l-164{margin-left:164px}.m-l-165{margin-left:165px}.m-l-166{margin-left:166px}.m-l-167{margin-left:167px}.m-l-168{margin-left:168px}.m-l-169{margin-left:169px}.m-l-170{margin-left:170px}.m-l-171{margin-left:171px}.m-l-172{margin-left:172px}.m-l-173{margin-left:173px}.m-l-174{margin-left:174px}.m-l-175{margin-left:175px}.m-l-176{margin-left:176px}.m-l-177{margin-left:177px}.m-l-178{margin-left:178px}.m-l-179{margin-left:179px}.m-l-180{margin-left:180px}.m-l-181{margin-left:181px}.m-l-182{margin-left:182px}.m-l-183{margin-left:183px}.m-l-184{margin-left:184px}.m-l-185{margin-left:185px}.m-l-186{margin-left:186px}.m-l-187{margin-left:187px}.m-l-188{margin-left:188px}.m-l-189{margin-left:189px}.m-l-190{margin-left:190px}.m-l-191{margin-left:191px}.m-l-192{margin-left:192px}.m-l-193{margin-left:193px}.m-l-194{margin-left:194px}.m-l-195{margin-left:195px}.m-l-196{margin-left:196px}.m-l-197{margin-left:197px}.m-l-198{margin-left:198px}.m-l-199{margin-left:199px}.m-l-200{margin-left:200px}.m-l-201{margin-left:201px}.m-l-202{margin-left:202px}.m-l-203{margin-left:203px}.m-l-204{margin-left:204px}.m-l-205{margin-left:205px}.m-l-206{margin-left:206px}.m-l-207{margin-left:207px}.m-l-208{margin-left:208px}.m-l-209{margin-left:209px}.m-l-210{margin-left:210px}.m-l-211{margin-left:211px}.m-l-212{margin-left:212px}.m-l-213{margin-left:213px}.m-l-214{margin-left:214px}.m-l-215{margin-left:215px}.m-l-216{margin-left:216px}.m-l-217{margin-left:217px}.m-l-218{margin-left:218px}.m-l-219{margin-left:219px}.m-l-220{margin-left:220px}.m-l-221{margin-left:221px}.m-l-222{margin-left:222px}.m-l-223{margin-left:223px}.m-l-224{margin-left:224px}.m-l-225{margin-left:225px}.m-l-226{margin-left:226px}.m-l-227{margin-left:227px}.m-l-228{margin-left:228px}.m-l-229{margin-left:229px}.m-l-230{margin-left:230px}.m-l-231{margin-left:231px}.m-l-232{margin-left:232px}.m-l-233{margin-left:233px}.m-l-234{margin-left:234px}.m-l-235{margin-left:235px}.m-l-236{margin-left:236px}.m-l-237{margin-left:237px}.m-l-238{margin-left:238px}.m-l-239{margin-left:239px}.m-l-240{margin-left:240px}.m-l-241{margin-left:241px}.m-l-242{margin-left:242px}.m-l-243{margin-left:243px}.m-l-244{margin-left:244px}.m-l-245{margin-left:245px}.m-l-246{margin-left:246px}.m-l-247{margin-left:247px}.m-l-248{margin-left:248px}.m-l-249{margin-left:249px}.m-l-250{margin-left:250px}.m-r-0{margin-right:0}.m-r-1{margin-right:1px}.m-r-2{margin-right:2px}.m-r-3{margin-right:3px}.m-r-4{margin-right:4px}.m-r-5{margin-right:5px}.m-r-6{margin-right:6px}.m-r-7{margin-right:7px}.m-r-8{margin-right:8px}.m-r-9{margin-right:9px}.m-r-10{margin-right:10px}.m-r-11{margin-right:11px}.m-r-12{margin-right:12px}.m-r-13{margin-right:13px}.m-r-14{margin-right:14px}.m-r-15{margin-right:15px}.m-r-16{margin-right:16px}.m-r-17{margin-right:17px}.m-r-18{margin-right:18px}.m-r-19{margin-right:19px}.m-r-20{margin-right:20px}.m-r-21{margin-right:21px}.m-r-22{margin-right:22px}.m-r-23{margin-right:23px}.m-r-24{margin-right:24px}.m-r-25{margin-right:25px}.m-r-26{margin-right:26px}.m-r-27{margin-right:27px}.m-r-28{margin-right:28px}.m-r-29{margin-right:29px}.m-r-30{margin-right:30px}.m-r-31{margin-right:31px}.m-r-32{margin-right:32px}.m-r-33{margin-right:33px}.m-r-34{margin-right:34px}.m-r-35{margin-right:35px}.m-r-36{margin-right:36px}.m-r-37{margin-right:37px}.m-r-38{margin-right:38px}.m-r-39{margin-right:39px}.m-r-40{margin-right:40px}.m-r-41{margin-right:41px}.m-r-42{margin-right:42px}.m-r-43{margin-right:43px}.m-r-44{margin-right:44px}.m-r-45{margin-right:45px}.m-r-46{margin-right:46px}.m-r-47{margin-right:47px}.m-r-48{margin-right:48px}.m-r-49{margin-right:49px}.m-r-50{margin-right:50px}.m-r-51{margin-right:51px}.m-r-52{margin-right:52px}.m-r-53{margin-right:53px}.m-r-54{margin-right:54px}.m-r-55{margin-right:55px}.m-r-56{margin-right:56px}.m-r-57{margin-right:57px}.m-r-58{margin-right:58px}.m-r-59{margin-right:59px}.m-r-60{margin-right:60px}.m-r-61{margin-right:61px}.m-r-62{margin-right:62px}.m-r-63{margin-right:63px}.m-r-64{margin-right:64px}.m-r-65{margin-right:65px}.m-r-66{margin-right:66px}.m-r-67{margin-right:67px}.m-r-68{margin-right:68px}.m-r-69{margin-right:69px}.m-r-70{margin-right:70px}.m-r-71{margin-right:71px}.m-r-72{margin-right:72px}.m-r-73{margin-right:73px}.m-r-74{margin-right:74px}.m-r-75{margin-right:75px}.m-r-76{margin-right:76px}.m-r-77{margin-right:77px}.m-r-78{margin-right:78px}.m-r-79{margin-right:79px}.m-r-80{margin-right:80px}.m-r-81{margin-right:81px}.m-r-82{margin-right:82px}.m-r-83{margin-right:83px}.m-r-84{margin-right:84px}.m-r-85{margin-right:85px}.m-r-86{margin-right:86px}.m-r-87{margin-right:87px}.m-r-88{margin-right:88px}.m-r-89{margin-right:89px}.m-r-90{margin-right:90px}.m-r-91{margin-right:91px}.m-r-92{margin-right:92px}.m-r-93{margin-right:93px}.m-r-94{margin-right:94px}.m-r-95{margin-right:95px}.m-r-96{margin-right:96px}.m-r-97{margin-right:97px}.m-r-98{margin-right:98px}.m-r-99{margin-right:99px}.m-r-100{margin-right:100px}.m-r-101{margin-right:101px}.m-r-102{margin-right:102px}.m-r-103{margin-right:103px}.m-r-104{margin-right:104px}.m-r-105{margin-right:105px}.m-r-106{margin-right:106px}.m-r-107{margin-right:107px}.m-r-108{margin-right:108px}.m-r-109{margin-right:109px}.m-r-110{margin-right:110px}.m-r-111{margin-right:111px}.m-r-112{margin-right:112px}.m-r-113{margin-right:113px}.m-r-114{margin-right:114px}.m-r-115{margin-right:115px}.m-r-116{margin-right:116px}.m-r-117{margin-right:117px}.m-r-118{margin-right:118px}.m-r-119{margin-right:119px}.m-r-120{margin-right:120px}.m-r-121{margin-right:121px}.m-r-122{margin-right:122px}.m-r-123{margin-right:123px}.m-r-124{margin-right:124px}.m-r-125{margin-right:125px}.m-r-126{margin-right:126px}.m-r-127{margin-right:127px}.m-r-128{margin-right:128px}.m-r-129{margin-right:129px}.m-r-130{margin-right:130px}.m-r-131{margin-right:131px}.m-r-132{margin-right:132px}.m-r-133{margin-right:133px}.m-r-134{margin-right:134px}.m-r-135{margin-right:135px}.m-r-136{margin-right:136px}.m-r-137{margin-right:137px}.m-r-138{margin-right:138px}.m-r-139{margin-right:139px}.m-r-140{margin-right:140px}.m-r-141{margin-right:141px}.m-r-142{margin-right:142px}.m-r-143{margin-right:143px}.m-r-144{margin-right:144px}.m-r-145{margin-right:145px}.m-r-146{margin-right:146px}.m-r-147{margin-right:147px}.m-r-148{margin-right:148px}.m-r-149{margin-right:149px}.m-r-150{margin-right:150px}.m-r-151{margin-right:151px}.m-r-152{margin-right:152px}.m-r-153{margin-right:153px}.m-r-154{margin-right:154px}.m-r-155{margin-right:155px}.m-r-156{margin-right:156px}.m-r-157{margin-right:157px}.m-r-158{margin-right:158px}.m-r-159{margin-right:159px}.m-r-160{margin-right:160px}.m-r-161{margin-right:161px}.m-r-162{margin-right:162px}.m-r-163{margin-right:163px}.m-r-164{margin-right:164px}.m-r-165{margin-right:165px}.m-r-166{margin-right:166px}.m-r-167{margin-right:167px}.m-r-168{margin-right:168px}.m-r-169{margin-right:169px}.m-r-170{margin-right:170px}.m-r-171{margin-right:171px}.m-r-172{margin-right:172px}.m-r-173{margin-right:173px}.m-r-174{margin-right:174px}.m-r-175{margin-right:175px}.m-r-176{margin-right:176px}.m-r-177{margin-right:177px}.m-r-178{margin-right:178px}.m-r-179{margin-right:179px}.m-r-180{margin-right:180px}.m-r-181{margin-right:181px}.m-r-182{margin-right:182px}.m-r-183{margin-right:183px}.m-r-184{margin-right:184px}.m-r-185{margin-right:185px}.m-r-186{margin-right:186px}.m-r-187{margin-right:187px}.m-r-188{margin-right:188px}.m-r-189{margin-right:189px}.m-r-190{margin-right:190px}.m-r-191{margin-right:191px}.m-r-192{margin-right:192px}.m-r-193{margin-right:193px}.m-r-194{margin-right:194px}.m-r-195{margin-right:195px}.m-r-196{margin-right:196px}.m-r-197{margin-right:197px}.m-r-198{margin-right:198px}.m-r-199{margin-right:199px}.m-r-200{margin-right:200px}.m-r-201{margin-right:201px}.m-r-202{margin-right:202px}.m-r-203{margin-right:203px}.m-r-204{margin-right:204px}.m-r-205{margin-right:205px}.m-r-206{margin-right:206px}.m-r-207{margin-right:207px}.m-r-208{margin-right:208px}.m-r-209{margin-right:209px}.m-r-210{margin-right:210px}.m-r-211{margin-right:211px}.m-r-212{margin-right:212px}.m-r-213{margin-right:213px}.m-r-214{margin-right:214px}.m-r-215{margin-right:215px}.m-r-216{margin-right:216px}.m-r-217{margin-right:217px}.m-r-218{margin-right:218px}.m-r-219{margin-right:219px}.m-r-220{margin-right:220px}.m-r-221{margin-right:221px}.m-r-222{margin-right:222px}.m-r-223{margin-right:223px}.m-r-224{margin-right:224px}.m-r-225{margin-right:225px}.m-r-226{margin-right:226px}.m-r-227{margin-right:227px}.m-r-228{margin-right:228px}.m-r-229{margin-right:229px}.m-r-230{margin-right:230px}.m-r-231{margin-right:231px}.m-r-232{margin-right:232px}.m-r-233{margin-right:233px}.m-r-234{margin-right:234px}.m-r-235{margin-right:235px}.m-r-236{margin-right:236px}.m-r-237{margin-right:237px}.m-r-238{margin-right:238px}.m-r-239{margin-right:239px}.m-r-240{margin-right:240px}.m-r-241{margin-right:241px}.m-r-242{margin-right:242px}.m-r-243{margin-right:243px}.m-r-244{margin-right:244px}.m-r-245{margin-right:245px}.m-r-246{margin-right:246px}.m-r-247{margin-right:247px}.m-r-248{margin-right:248px}.m-r-249{margin-right:249px}.m-r-250{margin-right:250px}.m-l-r-auto{margin-left:auto;margin-right:auto}.m-l-auto{margin-left:auto}.m-r-auto{margin-right:auto}.text-white{color:#fff}.text-black{color:#000}.text-hov-white:hover{color:#fff}.text-up{text-transform:uppercase}.text-center{text-align:center}.text-left{text-align:left}.text-right{text-align:right}.text-middle{vertical-align:middle}.lh-1-0{line-height:1}.lh-1-1{line-height:1.1}.lh-1-2{line-height:1.2}.lh-1-3{line-height:1.3}.lh-1-4{line-height:1.4}.lh-1-5{line-height:1.5}.lh-1-6{line-height:1.6}.lh-1-7{line-height:1.7}.lh-1-8{line-height:1.8}.lh-1-9{line-height:1.9}.lh-2-0{line-height:2}.lh-2-1{line-height:2.1}.lh-2-2{line-height:2.2}.lh-2-3{line-height:2.3}.lh-2-4{line-height:2.4}.lh-2-5{line-height:2.5}.lh-2-6{line-height:2.6}.lh-2-7{line-height:2.7}.lh-2-8{line-height:2.8}.lh-2-9{line-height:2.9}.dis-none{display:none}.dis-block{display:block}.dis-inline{display:inline}.dis-inline-block{display:inline-block}.dis-flex{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex}.pos-relative{position:relative}.pos-absolute{position:absolute}.pos-fixed{position:fixed}.float-l{float:left}.float-r{float:right}.sizefull{width:100%;height:100%}.w-full{width:100%}.h-full{height:100%}.max-w-full{max-width:100%}.max-h-full{max-height:100%}.min-w-full{min-width:100%}.min-h-full{min-height:100%}.top-0{top:0}.bottom-0{bottom:0}.left-0{left:0}.right-0{right:0}.top-auto{top:auto}.bottom-auto{bottom:auto}.left-auto{left:auto}.right-auto{right:auto}.op-0-0{opacity:0}.op-0-1{opacity:.1}.op-0-2{opacity:.2}.op-0-3{opacity:.3}.op-0-4{opacity:.4}.op-0-5{opacity:.5}.op-0-6{opacity:.6}.op-0-7{opacity:.7}.op-0-8{opacity:.8}.op-0-9{opacity:.9}.op-1-0{opacity:1}.bgwhite{background-color:#fff}.bgblack{background-color:#000}.wrap-pic-w img{width:100%}.wrap-pic-max-w img{max-width:100%}.wrap-pic-h img{height:100%}.wrap-pic-max-h img{max-height:100%}.wrap-pic-cir{border-radius:50%;overflow:hidden}.wrap-pic-cir img{width:100%}.hov-pointer:hover{cursor:pointer}.hov-img-zoom{display:block;overflow:hidden}.hov-img-zoom img{width:100%;-webkit-transition:all .6s;-o-transition:all .6s;-moz-transition:all .6s;transition:all .6s}.hov-img-zoom:hover img{-webkit-transform:scale(1.1);-moz-transform:scale(1.1);-ms-transform:scale(1.1);-o-transform:scale(1.1);transform:scale(1.1)}.bo-cir{border-radius:50%}.of-hidden{overflow:hidden}.visible-false{visibility:hidden}.visible-true{visibility:visible}.trans-0-1{-webkit-transition:all .1s;-o-transition:all .1s;-moz-transition:all .1s;transition:all .1s}.trans-0-2{-webkit-transition:all .2s;-o-transition:all .2s;-moz-transition:all .2s;transition:all .2s}.trans-0-3{-webkit-transition:all .3s;-o-transition:all .3s;-moz-transition:all .3s;transition:all .3s}.trans-0-4{-webkit-transition:all .4s;-o-transition:all .4s;-moz-transition:all .4s;transition:all .4s}.trans-0-5{-webkit-transition:all .5s;-o-transition:all .5s;-moz-transition:all .5s;transition:all .5s}.trans-0-6{-webkit-transition:all .6s;-o-transition:all .6s;-moz-transition:all .6s;transition:all .6s}.trans-0-9{-webkit-transition:all .9s;-o-transition:all .9s;-moz-transition:all .9s;transition:all .9s}.trans-1-0{-webkit-transition:all 1s;-o-transition:all 1s;-moz-transition:all 1s;transition:all 1s}.flex-w{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-wrap:wrap;-moz-flex-wrap:wrap;-ms-flex-wrap:wrap;-o-flex-wrap:wrap;flex-wrap:wrap}.flex-l{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:flex-start}.flex-r{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:flex-end}.flex-c{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center}.flex-sa{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:space-around}.flex-sb{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:space-between}.flex-t{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-ms-align-items:flex-start;align-items:flex-start}.flex-b{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-ms-align-items:flex-end;align-items:flex-end}.flex-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-ms-align-items:center;align-items:center}.flex-str{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-ms-align-items:stretch;align-items:stretch}.flex-row{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:row;-moz-flex-direction:row;-ms-flex-direction:row;-o-flex-direction:row;flex-direction:row}.flex-row-rev{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:row-reverse;-moz-flex-direction:row-reverse;-ms-flex-direction:row-reverse;-o-flex-direction:row-reverse;flex-direction:row-reverse}.flex-col{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column}.flex-col-rev{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse}.flex-c-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;-ms-align-items:center;align-items:center}.flex-c-t{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;-ms-align-items:flex-start;align-items:flex-start}.flex-c-b{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;-ms-align-items:flex-end;align-items:flex-end}.flex-c-str{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:center;-ms-align-items:stretch;align-items:stretch}.flex-l-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:flex-start;-ms-align-items:center;align-items:center}.flex-r-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:flex-end;-ms-align-items:center;align-items:center}.flex-sa-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:space-around;-ms-align-items:center;align-items:center}.flex-sb-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;justify-content:space-between;-ms-align-items:center;align-items:center}.flex-col-l{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:flex-start;align-items:flex-start}.flex-col-r{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:flex-end;align-items:flex-end}.flex-col-c{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:center;align-items:center}.flex-col-l-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:flex-start;align-items:flex-start;justify-content:center}.flex-col-r-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:flex-end;align-items:flex-end;justify-content:center}.flex-col-c-m{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:center;align-items:center;justify-content:center}.flex-col-str{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;-ms-align-items:stretch;align-items:stretch}.flex-col-sb{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-moz-flex-direction:column;-ms-flex-direction:column;-o-flex-direction:column;flex-direction:column;justify-content:space-between}.flex-col-rev-l{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse;-ms-align-items:flex-start;align-items:flex-start}.flex-col-rev-r{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse;-ms-align-items:flex-end;align-items:flex-end}.flex-col-rev-c{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse;-ms-align-items:center;align-items:center}.flex-col-rev-str{display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-flex-direction:column-reverse;-moz-flex-direction:column-reverse;-ms-flex-direction:column-reverse;-o-flex-direction:column-reverse;flex-direction:column-reverse;-ms-align-items:stretch;align-items:stretch}.ab-c-m{position:absolute;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);-o-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.ab-c-t{position:absolute;top:0;left:50%;-webkit-transform:translateX(-50%);-moz-transform:translateX(-50%);-ms-transform:translateX(-50%);-o-transform:translateX(-50%);transform:translateX(-50%)}.ab-c-b{position:absolute;bottom:0;left:50%;-webkit-transform:translateX(-50%);-moz-transform:translateX(-50%);-ms-transform:translateX(-50%);-o-transform:translateX(-50%);transform:translateX(-50%)}.ab-l-m{position:absolute;left:0;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%)}.ab-r-m{position:absolute;right:0;top:50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%)}.ab-t-l{position:absolute;left:0;top:0}.ab-t-r{position:absolute;right:0;top:0}.ab-b-l{position:absolute;left:0;bottom:0}.ab-b-r{position:absolute;right:0;bottom:0}@media only screen and (max-width:600px){.smol a,.smol p,.smol td,.smol th{padding-top:.3rem;padding-bottom:.3rem;font-size:.6rem!important;font-family:Poppins-Regular}body{font-size:.6rem!important}}@media only screen and (min-width:600px){.smol a,.smol p,.smol td,.smol th{padding-top:.1rem;padding-bottom:.1rem;font-size:.65rem!important;font-family:Poppins-Regular}body{font-size:.65rem!important}}@media only screen and (min-width:768px){.smol a,.smol p,.smol td,.smol th{padding-top:.2rem;padding-bottom:.2rem;font-size:.7rem!important;font-family:Poppins-Regular}body{font-size:.7rem!important}}@media only screen and (min-width:1440px){.smol a,.smol p,.smol td,.smol th{padding-top:.3rem;padding-bottom:.3rem;font-size:.75rem!important;font-family:Poppins-Regular}body{font-size:.75rem!important}}@media only screen and (min-width:1910px){.smol a,.smol p,.smol td,.smol th{padding-top:.3rem;padding-bottom:.3rem;font-size:.85rem!important;font-family:Poppins-Regular}body{font-size:.85rem!important}}.datatable-tab-correct{margin-top:0!important}.datatable-tab-correct1{margin-top:0!important}.nav-tabs{border-bottom:1px solid #dee2e6;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#6496e1!important}.nav-tabs .nav-item.show .nav-link,.nav-tabs .nav-link.active{color:#fff!important;background-color:#6496e1!important;border-color:#6496e1!important}.nav-tabs .nav-link:focus,.nav-tabs .nav-link:hover{border-color:#e9ecef #e9ecef #dee2e6}.nav-tabs .nav-link{border:1px solid transparent;border-top-left-radius:.25rem;border-top-right-radius:.25rem;color:#fff!important;background-color:navy!important}.nav-link:focus,.nav-link:hover{text-decoration:none}.bg-sog{background-color:#6496e1!important}thead.bg-sog{background-color:#6496e1!important}a.bg-sog:focus,a.bg-sog:hover,button.bg-sog:focus,button.bg-sog:hover{background-color:#6496e1!important}.carded{position:relative;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box}.carded-body{-ms-flex:1 1 auto;flex:1 1 auto;padding:1.25rem}.carded-title{margin-bottom:.75rem}.carded-subtitle{margin-top:-.375rem;margin-bottom:0}.carded-text:last-child{margin-bottom:0}.carded-link:hover{text-decoration:none}.carded-link+.carded-link{margin-left:1.25rem}.carded-header{padding:.75rem 1.25rem;margin-bottom:0;background-color:rgba(0,0,0,.03);border-bottom:1px solid rgba(0,0,0,.125)}.carded-footer{padding:.75rem 1.25rem;background-color:rgba(0,0,0,.03);border-top:1px solid rgba(0,0,0,.125)}.carded-header-tabs{margin-right:-.625rem;margin-bottom:-.75rem;margin-left:-.625rem;border-bottom:0}.carded-header-pills{margin-right:-.625rem;margin-left:-.625rem}.carded-img-overlay{position:absolute;top:0;right:0;bottom:0;left:0;padding:1.25rem}.carded-img{width:100%}.carded-img-top{width:100%;border-top-left-radius:calc(.25rem - 1px);border-top-right-radius:calc(.25rem - 1px)}.carded-img-bottom{width:100%;border-bottom-right-radius:calc(.25rem - 1px);border-bottom-left-radius:calc(.25rem - 1px)}@media(min-width:576px){.carded-deck{display:-ms-flexbox;display:flex;-ms-flex-flow:row wrap;flex-flow:row wrap;margin-right:-15px;margin-left:-15px}.carded-deck .carded{display:-ms-flexbox;display:flex;-ms-flex:1 0 0;flex:1 0 0;-ms-flex-direction:column;flex-direction:column;margin-right:15px;margin-left:15px}}@media(min-width:576px){.carded-group{display:-ms-flexbox;display:flex;-ms-flex-flow:row wrap;flex-flow:row wrap}.carded-group .carded{-ms-flex:1 0 0;flex:1 0 0}.carded-group .carded+.carded{margin-left:0;border-left:0}.carded-group .carded:first-child{border-top-right-radius:0;border-bottom-right-radius:0}.carded-group .carded:first-child .carded-img-top{border-top-right-radius:0}.carded-group .carded:first-child .carded-img-bottom{border-bottom-right-radius:0}.carded-group .carded:last-child{border-top-left-radius:0;border-bottom-left-radius:0}.carded-group .carded:last-child .carded-img-top{border-top-left-radius:0}.carded-group .carded:last-child .carded-img-bottom{border-bottom-left-radius:0}.carded-group .carded:not(:first-child):not(:last-child){border-radius:0}.carded-group .carded:not(:first-child):not(:last-child) .carded-img-bottom,.carded-group .carded:not(:first-child):not(:last-child) .carded-img-top{border-radius:0}}.carded-columns .carded{margin-bottom:.75rem}@media(min-width:576px){.carded-columns{-webkit-column-count:3;column-count:3;-webkit-column-gap:1.25rem;column-gap:1.25rem}.carded-columns .carded{display:inline-block;width:100%}}.nav-underline .active{font-weight:500;color:#fff;background-color:#343a40!important;box-shadow:0 0 1rem 0 rgba(0,0,0,.175) inset!important}.nav-pills .nav-link{border-radius:0 0 .25rem .25rem!important}.btn-floating{position:relative;z-index:1;display:inline-block;padding:0;margin:10px;overflow:hidden;vertical-align:middle;cursor:pointer;border-radius:50%!important;-webkit-box-shadow:0 5px 11px 0 rgba(0,0,0,.18),0 4px 15px 0 rgba(0,0,0,.15);box-shadow:0 5px 11px 0 rgba(0,0,0,.18),0 4px 15px 0 rgba(0,0,0,.15);-webkit-transition:all .2s ease-in-out;transition:all .2s ease-in-out;width:47px;height:47px}.btn-floating i{font-size:1.25rem;line-height:47px}.btn-floating i{display:inline-block;width:inherit;color:#fff;text-align:center}.btn-floating:hover{-webkit-box-shadow:0 8px 17px 0 rgba(0,0,0,.2),0 6px 20px 0 rgba(0,0,0,.19);box-shadow:0 8px 17px 0 rgba(0,0,0,.2),0 6px 20px 0 rgba(0,0,0,.19)}.btn-floating:before{border-radius:0}.btn-floating.btn-sm{width:36.15385px;height:36.15385px}.btn-floating.btn-sm i{font-size:.96154rem;line-height:36.15385px}.btn-floating.btn-lg{width:61.1px;height:61.1px}.btn-floating.btn-lg i{font-size:1.625rem;line-height:61.1px}.fixed-action-btn{position:fixed;bottom:35px;z-index:998;margin-bottom:0;overflow:hidden;height:110px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:end;-ms-flex-align:end;align-items:flex-end;padding:15px 15px 15px 15px;padding-bottom:15px;padding-left:15px;padding-right:15px;-webkit-transition:height .4s;transition:height .4s}.fixed-action-btn ul{position:absolute;right:0;bottom:64px;left:0;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;height:0;padding:0;margin:0 0 15px;text-align:center;-webkit-transition:.4s all;transition:.4s all;opacity:0;margin-bottom:0}.fixed-action-btn ul li{z-index:0;display:-webkit-box;display:-ms-flexbox;display:flex;margin-right:auto;margin-bottom:15px;margin-left:auto}.fixed-action-btn ul a.btn-floating{opacity:0;-webkit-transition-duration:.4s;transition-duration:.4s;-webkit-transform:scale(.4) translate(0);transform:scale(.4) translate(0)}.fixed-action-btn ul a.btn-floating.shown{opacity:1;-webkit-transform:scale(1) translate(0);transform:scale(1) translate(0)}.fixed-action-btn.active ul{height:10rem;margin-bottom:40px;opacity:1}.fixed-action-btn.active{height:500px}.btn-floating.btn-flat{padding:0;color:#fff;background:#4285f4}.btn-floating.btn-flat:hover{-webkit-box-shadow:none;box-shadow:none}.btn-floating.btn-flat:focus,.btn-floating.btn-flat:hover{background-color:#5a95f5}.btn-floating.btn-flat.active{background-color:#0b51c5;-webkit-box-shadow:0 5px 11px 0 rgba(0,0,0,.18),0 4px 15px 0 rgba(0,0,0,.15);box-shadow:0 5px 11px 0 rgba(0,0,0,.18),0 4px 15px 0 rgba(0,0,0,.15)}html{overflow:overlay}.dataTables_scrollBody,.dataTables_wrapper,table{overflow:overlay!important}::-webkit-scrollbar{width:8px}::-webkit-scrollbar-track{background:rgba(0,0,0,0);border-radius:0;display:none;scrollbar-width:none}::-webkit-scrollbar-thumb{background:rgba(33,37,41,.5);border-radius:10px;box-shadow:0 0 6px rgba(0,0,0,.5)}::-webkit-scrollbar-track:hover+::-webkit-scrollbar-thumb{background:#212529;border-radius:10px;box-shadow:0 0 6px rgba(0,0,0,.5)}
        </textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" class="d-none"></iframe>
	</main>
    <?php 
    // include 'include/floating_action_button.php';
    // include 'modals/ddr_add_modal.php'; 
    // include 'include/ddr_datepicker.php'; 
    ?>
</div>

</body>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>   
<script src="/assets/js/bottom_scripts.js?v1.0.0.1"></script>
<script type="text/javascript" src="/assets/js/pldb_county_selectpicker.js?v1.0.0.62"></script>
<!-- Load our React component. -->
<!-- <script src="pldb/react_pldb.js"></script> -->
</html>

