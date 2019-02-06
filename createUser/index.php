<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_getPrivilege.php';

if($_PRIVILEGE !== FALSE and $_PRIVILEGE !== -1){
	if($_PRIVILEGE > 1){
		//Admin + 
		$_title = 'Create User';
		$_javascript_head = file_get_contents('./createUser.js');
		$_main = file_get_contents('./createUserA.html');
		include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
		echo $_html;
	}else{
		header( 'Location: '.rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'developers.php' ) ;
	}
}else{
	$_title = 'Create User';
	$_javascript_head = file_get_contents('./createUser.js');
	$_main = file_get_contents('./createUserP.html');
	include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
	echo $_html;
}
?>
