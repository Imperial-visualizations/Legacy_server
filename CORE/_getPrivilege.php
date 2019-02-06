<?php

include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_mysql.php';
	
if(isset($_COOKIE['SCHOOL_ID'])) {
	if($stmt = $mysqli->prepare("SELECT * FROM `users` WHERE SCHOOL_ID=?")){
		$stmt->bind_param("s", $school_id);
		if(!preg_match("/^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$/",$_COOKIE['SCHOOL_ID'])){
			echo json_encode(array('error' => array(
			    'message' => 'Format invalid',
			    'code' => 121,
			)));
			$_PRIVILEGE = FALSE;
		}else{
			$school_id = $_COOKIE['SCHOOL_ID'];
			$stmt->bind_result($ID_r, $SCHOOL_ID_r, $FULL_NAME_r, $PRIVILEGE_r, $PASSPHRASE_r);
			if (!$stmt->execute()) {
				echo json_encode(array('error' => array(
				    'message' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error,
				    'code' => 122,
				)));
				$_PRIVILEGE = FALSE;
			}else{
				if($stmt->fetch()){
					$_PRIVILEGE = $PRIVILEGE_r;
					$stmt->close();
				}else{
					echo json_encode(array('error' => array(
					    'message' => "No matched school ID",
					    'code' => 123,
					)));
					$_PRIVILEGE = FALSE;
				}
			}
		}
	}else{
		echo json_encode(array('error' => array(
		    'message' => "Prepared failed.",
		    'code' => 110,
		)));
		$_PRIVILEGE = FALSE;
	}
} else {
	$_PRIVILEGE = -1;
}

?>
