<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_getPrivilege.php';

if($_PRIVILEGE !== FALSE and $_PRIVILEGE !== -1){
	if(isset($_SERVER['HTTP_REFERER'])){
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}else{
		header( 'Location: /developers.php' );
	}
}else{
  $_title = 'Temporary Log in';
  $_javascript_head = file_get_contents('./Tlogin.js');
  $_main = file_get_contents('./Tlogin.html');
  include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
  echo $_html;
}
?>
