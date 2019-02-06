<?php
setcookie('ID', '', time() - 3600, '/');
setcookie('FULL_NAME', '', time() - 3600, '/');
setcookie('SCHOOL_ID', '', time() - 3600, '/');
setcookie('PRIVILEGE', '', time() - 3600, '/');
$_PRIVILEGE = -1;
$_title = 'Log out';
$_main = '<div class="mx-auto text-center" style="width: 500px; font-size:30px;"><span style="font-size:120px;"><i class="fa fa-sign-out" aria-hidden="true"></i></span><br>You have been logged out succesfully, you will now be redirected to the <a href="/Tlogin/">login page</a>.</div>';
$_javascript_bottom = 'setTimeout(function(){window.location.replace("/Tlogin/");},300);';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
echo $_html;
?>
