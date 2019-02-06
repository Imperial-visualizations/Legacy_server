<?php

if(!isset($_title)){$_title="";}
if(!isset($_style)){$_style="";}
if(!isset($_javascript_head)){$_javascript_head="";}
if(!isset($_main)){$_main="";}
if(!isset($_javascript_bottom)){$_javascript_bottom="";}
if($_title == 'Imperial Visualisations'){

    $_html = '
    <!doctype html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>'.$_title.'</title>
        <link rel="icon" href="/assets/imgs/iv-logo-v4-small-black@0.5x.png" type="image/x-icon">
        <script src="/assets/js/js.cookie.js"></script>
        <link rel="stylesheet" href="/assets/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <style type="text/css">
          /*
     * Base structure
     */

    /* Move down content because we have a fixed navbar that is 3.5rem tall */
    body {
      padding-top: 3.76rem;
    }
    header{
      position: fixed;
      top: -10em;
      width: 100%;
      height: 10em;
      display: block;
      background: #002147;
      z-index: 2000000;
      background-image: url(/assets/imgs/iv-logo-v4-small.svg);
      background-repeat: no-repeat;
      background-attachment: local;
      background-position: 50% 90%;
      background-size: 24px; 
    }

    /*
     * Typography
     */

    h1 {
      margin-bottom: 20px;
      padding-bottom: 9px;
      border-bottom: 1px solid #eee;
    }

    /*
     * Sidebar
     */

    .sidebar {
      position: fixed;
      top: 51px;
      bottom: 0;
      left: 0;
      z-index: 1000;
      padding: 20px;
      overflow-x: hidden;
      overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
      border-right: 1px solid #eee;
    }

    /* Sidebar navigation */
    .sidebar {
      padding-left: 0;
      padding-right: 0;
    }

    .sidebar .nav {
      margin-bottom: 20px;
    }

    .sidebar .nav-item {
      width: 100%;
    }

    .sidebar .nav-item + .nav-item {
      margin-left: 0;
    }

    .sidebar .nav-link {
      border-radius: 0;
    }

    /*
     * Dashboard
     */

     /* Placeholders */
    .placeholders {
      padding-bottom: 3rem;
    }

    .placeholder img {
      padding-top: 1.5rem;
      padding-bottom: 1.5rem;
    }
    
    '.$_style.'
    </style>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script>
    '.$_javascript_head.'
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-42929523-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'UA-42929523-2\');
</script>

    </head>
     <body data-spy="scroll" data-target="#courses-nav" data-offset="66">
    '.$_main.'
    <header></header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="/assets/js/masonry.pkgd.min.js"></script>
    <script src="./assets/js/anime.min.js"></script>
    <script>
    '.$_javascript_bottom.'
      
    </script>
    </body>
    </html>';
}else{
  if($_PRIVILEGE !== FALSE and $_PRIVILEGE !== -1){
    $_privileges = ["Unapproved Developer","Developer","Admin","Head"];

    $_full_name = $_COOKIE['FULL_NAME'];
    $_school_username = $_COOKIE['SCHOOL_ID'];
    $_greetings = "<span id='greetings'>Hello,</span> <span class='font-weight-bold'>".$_full_name."</span> (".$_privileges[$_PRIVILEGE].")";
    if($_title == 'Developers Home'){
      $_nav1 = ['active','','',''];
      $_nav2 = ['active','','',''];
    }elseif($_title == "Create User" or $_title == "Manage User"){
      $_nav1 = ['','','','active'];
      $_nav2 = ['','active','',''];
    }elseif($_title == "Manage Visualisations" ){
      $_nav1 = ['','active','',''];
      $_nav2 = ['active','','',''];
    }elseif($_title == "Update Visualisation" ){
      $_nav1 = ['','active','',''];
      $_nav2 = ['','active','',''];
    }elseif($_title == "Manage Works" ){
      $_nav1 = ['','','','active'];
      $_nav2 = ['active','','',''];
    }
    $_nav1HTML = '<li class="nav-item '.$_nav1[0].'">
                <a class="nav-link" href="/developers.php">Home</span></a>
              </li>
              '.(($_PRIVILEGE<3)?'<li class="nav-item '.$_nav1[1].'"><a class="nav-link" href="/Develop/ManageVisuals/">Develop</a></li>':'').'
              <li class="nav-item '.$_nav1[2].'">
                <a class="nav-link" href="#">Help</a>
              </li>'.( ($_PRIVILEGE>=2)?'<li class="nav-item '.$_nav1[3].'"><a class="nav-link" href="/Manage/ManageWorks/">Manage</a></li>':'');
    $_nav2HTML = ['
                <li class="nav-item">
                  <a class="nav-link '.$_nav2[0].'" href="developers.php">Overview</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link '.$_nav2[1].'" href="/Home/Notifications/">Notifications</a>
                </li>'
                ,'
                <li class="nav-item">
                  <a class="nav-link '.$_nav2[0].'" href="/Develop/ManageVisuals/">Manage Visualisations</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link '.$_nav2[1].'" href="/Develop/UpdateVisual/">Update Visualisation</a>
                </li>'
                ,'
                <li class="nav-item">
                  <a class="nav-link '.$_nav2[0].'" href="#">My bookmarks</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link '.$_nav2[1].'" href="#">Tutorials</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link '.$_nav2[2].'" href="#">Useful Links</a>
                </li>'
                ,'
                <li class="nav-item">
                  <a class="nav-link '.$_nav2[0].'" href="/Manage/ManageWorks/">Manage Works</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link '.$_nav2[1].'" href="/Manage/ManageUsers/">Manage Users</a>
                </li>'];

    $_InterfaceOptions = [
    '
       <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
          <a class="navbar-brand" href="#">IV Developers Dashboard</a>
          <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          </div>
        </nav>
    '.$_main
    ,'
      <!-- interface for developers -->
       <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">  
          <a class="navbar-brand" href="/developers.php">
            <img src="/assets/imgs/iv-logo-v4-small.svg" height="36" alt="">&nbsp;&nbsp;&nbsp;&nbsp;Developers Dashboard
          </a>
          <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
              '.$_nav1HTML.'
            </ul>
            <div class="text-light mt-2 mt-md-0">'.$_greetings.'&nbsp;&nbsp;&nbsp;<a class="text-light" href="/logout.php"><button type="button" class="btn btn-outline-secondary">Log out</button></a></div>
          </div>
        </nav>

        <div class="container-fluid">
          <div class="row">
            <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
              <ul class="nav nav-pills flex-column">
                '.$_nav2HTML[array_search('active', $_nav1)].'
              </ul>
            </nav>

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
            '.$_main.'
            </main>
          </div>
        </div>
    ','
      <!-- interface for admin -->
       <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">  
          <a class="navbar-brand" href="/developers.php">
            <img src="/assets/imgs/iv-logo-v4-small.svg" height="36" alt="">&nbsp;&nbsp;&nbsp;&nbsp;Developers Dashboard
          </a>
          <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
              '.$_nav1HTML.'
            </ul>
            <div class="text-light mt-2 mt-md-0">'.$_greetings.'&nbsp;&nbsp;&nbsp;<a class="text-light" href="/logout.php"><button type="button" class="btn btn-outline-secondary">Log out</button></a></div>
          </div>
        </nav>

        <div class="container-fluid">
          <div class="row">
            <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
              <ul class="nav nav-pills flex-column">
                '.$_nav2HTML[array_search('active', $_nav1)].'
              </ul>
            </nav>

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
            '.$_main.'
            </main>
          </div>
        </div>
    ','
      <!-- interface for head -->
       <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">  
          <a class="navbar-brand" href="/developers.php">
            <img src="/assets/imgs/iv-logo-v4-small.svg" height="36" alt="">&nbsp;&nbsp;&nbsp;&nbsp;Developers Dashboard
          </a>
          <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
              '.$_nav1HTML.'
            </ul>
            <div class="text-light mt-2 mt-md-0">'.$_greetings.'&nbsp;&nbsp;&nbsp;<a class="text-light" href="/logout.php"><button type="button" class="btn btn-outline-secondary">Log out</button></a></div>
          </div>
        </nav>

        <div class="container-fluid">
          <div class="row">
            <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
              <ul class="nav nav-pills flex-column">
                '.$_nav2HTML[array_search('active', $_nav1)].'
              </ul>
            </nav>

            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
            '.$_main.'
            </main>
          </div>
        </div>
    '];

    $_html = '
    <!doctype html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>'.$_title.'</title>
        <link rel="icon" href="/assets/imgs/iv-logo-v4-small-black@0.5x.png" type="image/x-icon">
        <script src="/assets/js/js.cookie.js"></script>

        <link rel="stylesheet" href="/assets/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <style type="text/css">
          /*
     * Base structure
     */

    /* Move down content because we have a fixed navbar that is 3.5rem tall */
    body {
      padding-top: 3.76rem;
    }
    header{
      position: fixed;
      top: -10em;
      width: 100%;
      height: 10em;
      display: block;
      background: #002147;
      z-index: 2000000;
      background-image: url(/assets/imgs/iv-logo-v4-small.svg);
      background-repeat: no-repeat;
      background-attachment: local;
      background-position: 50% 90%;
      background-size: 24px; 
    }

    /*
     * Typography
     */

    h1 {
      margin-bottom: 20px;
      padding-bottom: 9px;
      border-bottom: 1px solid #eee;
    }

    /*
     * Sidebar
     */

    .sidebar {
      position: fixed;
      top: 51px;
      bottom: 0;
      left: 0;
      z-index: 1000;
      padding: 20px;
      overflow-x: hidden;
      overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
      border-right: 1px solid #eee;
    }

    /* Sidebar navigation */
    .sidebar {
      padding-left: 0;
      padding-right: 0;
    }

    .sidebar .nav {
      margin-bottom: 20px;
    }

    .sidebar .nav-item {
      width: 100%;
    }

    .sidebar .nav-item + .nav-item {
      margin-left: 0;
    }

    .sidebar .nav-link {
      border-radius: 0;
    }

    /*
     * Dashboard
     */

     /* Placeholders */
    .placeholders {
      padding-bottom: 3rem;
    }

    .placeholder img {
      padding-top: 1.5rem;
      padding-bottom: 1.5rem;
    }

    '.$_style.'
        </style>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script>
    '.$_javascript_head.'
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-42929523-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'UA-42929523-2\');
</script>

    </head>
     <body>
     '.$_InterfaceOptions[$_PRIVILEGE].'
     <header></header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="/assets/js/masonry.pkgd.min.js"></script>
    <script>
    '.$_javascript_bottom.'
    var now = new Date();
    var hrs = now.getHours();
    var msg = "";
    if (hrs >  0) msg = "I guess this IS coding hours,"; // REALLY early
    if (hrs >  6) msg = "Good morning,";      // After 6am
    if (hrs > 12) msg = "Good afternoon,";    // After 12pm
    if (hrs > 17) msg = "Good evening,";      // After 5pm
    if (hrs > 22) msg = "Go to bed!";
    $("#greetings").text(msg);

    </script>
    </body>
    </html>';


  }else{


    $_html = '
    <!doctype html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>'.$_title.'</title>
        <link rel="icon" href="/assets/imgs/iv-logo-v4-small-black@0.5x.png" type="image/x-icon">
        <script src="/assets/js/js.cookie.js"></script>
        <link rel="stylesheet" href="/assets/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <style type="text/css">
          /*
     * Base structure
     */

    /* Move down content because we have a fixed navbar that is 3.5rem tall */
    body {
      padding-top: 3.76rem;
    }
    header{
      position: fixed;
      top: -10em;
      width: 100%;
      height: 10em;
      display: block;
      background: #002147;
      z-index: 2000000;
      background-image: url(/assets/imgs/iv-logo-v4-small.svg);
      background-repeat: no-repeat;
      background-attachment: local;
      background-position: 50% 90%;
      background-size: 24px; 
    }

    /*
     * Typography
     */

    h1 {
      margin-bottom: 20px;
      padding-bottom: 9px;
      border-bottom: 1px solid #eee;
    }

    /*
     * Sidebar
     */

    .sidebar {
      position: fixed;
      top: 51px;
      bottom: 0;
      left: 0;
      z-index: 1000;
      padding: 20px;
      overflow-x: hidden;
      overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
      border-right: 1px solid #eee;
    }

    /* Sidebar navigation */
    .sidebar {
      padding-left: 0;
      padding-right: 0;
    }

    .sidebar .nav {
      margin-bottom: 20px;
    }

    .sidebar .nav-item {
      width: 100%;
    }

    .sidebar .nav-item + .nav-item {
      margin-left: 0;
    }

    .sidebar .nav-link {
      border-radius: 0;
    }

    /*
     * Dashboard
     */

     /* Placeholders */
    .placeholders {
      padding-bottom: 3rem;
    }

    .placeholder img {
      padding-top: 1.5rem;
      padding-bottom: 1.5rem;
    }
    
    '.$_style.'
    </style>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script>
    '.$_javascript_head.'
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-42929523-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'UA-42929523-2\');
</script>

    </head>
     <body>
       <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
          <a class="navbar-brand" style="margin: 0 auto;" href="/">
            <img src="/assets/imgs/iv-logo-v4.svg" height="36" alt="">
          </a>
          <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          </div>
        </nav>
    '.$_main.'
    <header></header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="/assets/js/masonry.pkgd.min.js"></script>
    <script>
    '.$_javascript_bottom.'
      
    </script>
    </body>
    </html>';
  }
}

?>
