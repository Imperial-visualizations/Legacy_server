<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_getPrivilege.php';

if($_PRIVILEGE !== FALSE and $_PRIVILEGE !== -1){
		//Developer or Admin, but not Head 
		$_title = 'Developers Home';
		// $_javascript_head = file_get_contents('./DevelopManageVisuals.js');
		// $_main = file_get_contents('./DevelopManageVisuals.html');
		$_main = "";
		if(isset($_COOKIE['SCHOOL_ID'])) {
		  $_main .= "ID:".$_COOKIE['ID'];
		  $_main .= "<br>";
		  $_main .= "FULL_NAME:".$_COOKIE['FULL_NAME'];
		  $_main .= "<br>";
		  $_main .= "SCHOOL_ID:".$_COOKIE['SCHOOL_ID'];
		  $_main .= "<br>";
		  $_main .= "PRIVILEGE:".$_PRIVILEGE;
		  $_main .= "<br>";
		}else{
		  $_main .= "PRIVILEGE:".$_PRIVILEGE;
		}
		include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
		echo $_html;
}else{
	header( 'Location: /Tlogin/?from=/developers.php' ) ;
}
?>
