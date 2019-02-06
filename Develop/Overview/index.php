<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_getPrivilege.php';

if($_PRIVILEGE !== FALSE and $_PRIVILEGE !== -1){
	if($_PRIVILEGE == 1 or $_PRIVILEGE == 2){
		//Developer or Admin, but not Head 
		$_title = 'Create new visualisation';
		$_javascript_head = file_get_contents('./DevelopeOverview.js');
		$_main = file_get_contents('./DevelopeOverview.html');
		include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
		echo $_html;
	}else{
		header( 'Location: /developers.php' ) ;
	}
}else{
	header( 'Location: /Tlogin/?from=/Develop/Overview/' ) ;
}
?>
