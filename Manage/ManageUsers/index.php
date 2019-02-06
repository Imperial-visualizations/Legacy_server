<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_getPrivilege.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_mysql.php';
if($_PRIVILEGE !== FALSE and $_PRIVILEGE !== -1){
  $_privileges = ["Unapproved Developer","Developer","Admin","Head"];
	if($_PRIVILEGE >= 2){
		//Admin + 
		$_title = 'Manage User';
		$_javascript_head = file_get_contents('./ManageManageUsers.js');
		$_main = '
<h1>Manage Users</h1>
<div class="row">
<div class="col-10">
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th style="width:40px;text-align:center;"><div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox" id="check_all" value="check_all" aria-label="..."></label></div></th>
      <th>ID</th>
      <th>School ID</th>
      <th>Full Name</th>
      <th>Privilege</th>
    </tr>
  </thead>
  <tbody>';   
		if($stmt = $mysqli -> prepare("SELECT `ID`, `SCHOOL_ID`, `FULL_NAME`, `PRIVILEGE` FROM `users`")) {
		    $stmt -> execute();
		    $stmt -> bind_result($id, $school_id, $full_name, $privilege);
		    while($stmt->fetch()) {
		    	if($school_id != $_COOKIE['SCHOOL_ID']){
			    	$_button1 = '<button type="button" data-old-name="'.$full_name.'" class="btn btn-link btn-sm buttons_edit_full_name'.(($privilege<=$_PRIVILEGE)?"":" d-none").'" id="'.$school_id .'">Edit</button>';
			    	$_button2 = '<button type="button" class="btn btn-link btn-sm buttons_edit_privilege'.(($privilege<=$_PRIVILEGE)?"":" d-none").'" id="'.$school_id .'">Edit</button>';
		    	}else{
		    		$_button1 = '';
		    		$_button2 = '';
		    	}

		        $_main .= '<tr><td style="width:40px;text-align:center;">  <div class="form-check"><label class="form-check-label">
    <input class="form-check-input table-checkboxes" type="checkbox" id="' . $school_id . '" value="' . $school_id . '" aria-label="...">
  </label>
</div></td><th scope="row">' . $id . '</th><td>' . $school_id . '</td><td>' . $full_name .''.$_button1.'</td><td>' . $privilege . ' ('.$_privileges[$privilege].')'.$_button2.'</td></tr>';
		    }
		    $stmt -> close();
			$mysqli->close();
		}
		$_main .= '
  </tbody>
</table>
</div>
<div class="col-2" id="manageUserOptions">
';
		$_main .= file_get_contents('./ManageManageUsers.html');
		if($_PRIVILEGE == 3){
			$_main .= '
              <option value="3">3: Heads: manage works and users</option>';
		}
		$_main .= file_get_contents('./ManageManageUsers2.html');
		include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
		echo $_html;
	}else{
		
	}
}else{
	header( 'Location: /Tlogin/?from=/Manage/ManageUsers/' ) ;
}
?>
