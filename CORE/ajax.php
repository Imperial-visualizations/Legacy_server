<?php
function dirToArray($dir) { 
   $result = ''; 
   $cdir = scandir($dir); 
   foreach ($cdir as $key => $value){ 
      if (!in_array($value,array(".","..",".DS_Store"))) { 
	   $result .= '<li>'; 
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)){ 
            $result .= $value."/<ul>".dirToArray($dir . DIRECTORY_SEPARATOR . $value)."</ul>"; 
         }else{ 
			$path2 = str_replace($_SERVER['DOCUMENT_ROOT'],"",$dir);
			$path2 = str_replace("//","/",$path2);
			if($value != "index.php"){
	            $result .= $value.'<a class=\'text-danger file_delete_buttons\' data-file-path=\''.$path2.'/'.$value.'\'><i class=\'fa fa-times-circle\' aria-hidden=\'true\'></i></a>'; 
			}else{
	            $result .= $value; 
			}
         } 
	   $result .= '</li>';
      } 
   }  
   return $result; 
} 


include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_mysql.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_getPrivilege.php';	

if(isset($_POST['type'])){
	if($_POST['type']=="create_a_user"){

		if($stmt1 = $mysqli->prepare("INSERT INTO `users` (`ID`, `SCHOOL_ID`, `FULL_NAME`, `PRIVILEGE`, `PASSPHRASE`) VALUES (NULL, ?, ?, ?, ?)") and $stmt2 = $mysqli->prepare("SELECT * FROM `users` WHERE SCHOOL_ID=?")){
			$stmt1->bind_param("ssis", $school_id, $full_name, $privilege, $passphrase_hashed);
			$stmt2->bind_param("s", $school_id);

			if(!preg_match("/^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$/",$_POST['school_id']) and !preg_match("/^[A-z\'\-]+(\s[A-z\'\-]+){1,3}$/",$_POST['full_name']) ){
				echo json_encode(array('error' => array(
				    'message' => 'Input format invalid',
				    'code' => "011"
				)));
			}else{
				$school_id = $_POST['school_id'];
				$full_name = $_POST['full_name'];
				$passphrase =  $_POST['password'];
				$passphrase_hashed =  password_hash($passphrase, PASSWORD_DEFAULT);
				if($_PRIVILEGE > 1 and $_PRIVILEGE >= (int)$_POST['privilege']){
					$privilege = (int)$_POST['privilege'];
				}else{
					$privilege = 0;
				}
				if (!$stmt2->execute()) {
					echo json_encode(array('error' => array(
					    'message' => "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error,
					    'code' => "012"
					)));
					exit();
				}else{
					$stmt2->bind_result($ID_r, $SCHOOL_ID_r, $FULL_NAME_r, $PRIVILEGE_r, $PASSPHRASE_r);
					if($stmt2->fetch()){
						echo json_encode(array('error' => array(
						    'message' => "School id already exist",
						    'code' => "013"
						)));
						exit();
					}else{
						if (!$stmt1->execute()) {
							echo json_encode(array('error' => array(
							    'message' => "Execute failed: (" . $stmt1->errno . ") " . $stmt1->error,
							    'code' => "012"
							)));
							exit();
						}else{
							echo json_encode(array('success' => array(
							    'message' => 'User successfully created.'
							)));
							$stmt1->close();
							$mysqli->close();
							exit();
						}
					}
				}
			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Prepared failed.",
			    'code' => "010"
			)));
			exit();
		}
	}elseif($_POST['type']=="delete_users"){
		if($_PRIVILEGE > 1){

			$school_id_list = implode("','", $_POST['school_id_list']);

			$isInputValid = 1;
			foreach ($_POST['school_id_list'] as &$value) {
				if(!preg_match("/^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$/",$value)){
					$isInputValid *= 0;
				}else{
					$isInputValid *= 1;
				}
			}

			if($isInputValid == 0){
				echo json_encode(array('error' => array(
				    'message' => 'Input format invalid',
				    'code' => "032"
				)));
			}else{

				if($result = $mysqli->query("SELECT * FROM `users` WHERE SCHOOL_ID IN ('".$school_id_list."')")){
					if ($result->num_rows > 0) {
						$isEnoughPrivilege = 1;
						$listOfUserIDs = "";
						$k = 0;
						while($row = $result->fetch_assoc()) {
							if($row["PRIVILEGE"] > $_PRIVILEGE){
								$isEnoughPrivilege *= 0;
							}else{
								$isEnoughPrivilege *= 1;
								$listOfUserIDs .= (($k != 0)?"','":"").$row["ID"];
							}
							$k += 1;
						}
						if($isEnoughPrivilege == 1){
							if($mysqli->query("DELETE FROM `users` WHERE `SCHOOL_ID` IN ('".$school_id_list."')") === TRUE){
								if($mysqli->query("DELETE FROM `VISUALISATIONSxUSERS` WHERE `usersID` IN ('".$listOfUserIDs."')") === TRUE){
									echo json_encode(array('success' => array(
									    'message' => 'Users successfully deleted.',
									    'data' => $school_id_list
									)));
									$mysqli->close();
									exit();
								}else{
									echo json_encode(array('error' => array(
									    'message' => "Excute mysqli query failed.",
									    'code' => "030"
									)));
									exit();
								}
							}else{
								echo json_encode(array('error' => array(
								    'message' => "Excute mysqli query failed.",
								    'code' => "030"
								)));
								exit();
							}							
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Action denied, not enough privilege.",
							    'code' => "031"
							)));
							exit();
						}
					}else{
						echo json_encode(array('error' => array(
						    'message' => "Input School Id doesn't exist",
						    'code' => "032"
						)));
						exit();
					}	
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Excute mysqli query failed.",
					    'code' => "030"
					)));
					exit();
				}	
			}


		}else{
			echo json_encode(array('error' => array(
			    'message' => "Action denied, not enough privilege.",
			    'code' => "031"
			)));
			exit();
		}
		
	}elseif($_POST['type']=="update_full_name"){
		if($_PRIVILEGE > 1){			
			if(!preg_match("/^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$/",$_POST['school_id']) and !preg_match("/^[A-z\']+(\s[A-z\']+){1,3}$/",$_POST['full_name']) ){
				echo json_encode(array('error' => array(
				    'message' => 'Input format invalid',
				    'code' => "041"
				)));
			}else{
				if($result = $mysqli->query("SELECT * FROM `users` WHERE `SCHOOL_ID` = '".$_POST['school_id']."'")){
					if ($result->num_rows == 1) {
						$row = $result->fetch_assoc();
						if($row["PRIVILEGE"] <= $_PRIVILEGE){	
							if($stmt = $mysqli->prepare("UPDATE `users` SET `FULL_NAME` = ? WHERE `users`.`SCHOOL_ID` = ?;")){
								$stmt->bind_param("ss", $full_name, $school_id);	
								$school_id = $_POST['school_id'];
								$full_name = $_POST['full_name'];
								if (!$stmt->execute()) {
									echo json_encode(array('error' => array(
									    'message' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error,
									    'code' => "044"
									)));
									exit();
								}else{
									echo json_encode(array('success' => array(
										'message' => "successfully updated full name"
									)));
									$stmt->close();
									$mysqli->close();
									exit();
								}
							}else{
								echo json_encode(array('error' => array(
								    'message' => "Prepared failed.",
								    'code' => "040"
								)));
								exit();
							}		
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Action denied, not enough privilege.",
							    'code' => "042"
							)));
							exit();
						}
					}else{
						echo json_encode(array('error' => array(
						    'message' => "No matching results for the school id",
						    'code' => "043"
						)));
						exit();
					}	
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Excute mysqli query failed.",
					    'code' => "040"
					)));
					exit();
				}	
			}

		}else{
			echo json_encode(array('error' => array(
			    'message' => "Action denied, not enough privilege.",
			    'code' => "042"
			)));
			exit();
		}
	}elseif($_POST['type']=="update_privilege"){
		if($_PRIVILEGE > 1){			
			$school_id = $_POST['school_id'];
			$privilege = $_POST['privilege'];
			if(!preg_match("/^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$/",$school_id) and !preg_match("/^[0-3]$/",$privilege) ){
				echo json_encode(array('error' => array(
				    'message' => 'Input format invalid',
				    'code' => "051"
				)));
			}else{
				if($result = $mysqli->query("SELECT * FROM `users` WHERE SCHOOL_ID='".$_POST['school_id']."'")){
					if ($result->num_rows == 1) {
						$row = $result->fetch_assoc();
						if($row["PRIVILEGE"] <= $_PRIVILEGE){	

							if($mysqli->query("UPDATE `users` SET `PRIVILEGE` = '".$privilege."' WHERE `users`.`SCHOOL_ID` = '".$school_id."'")){
								
									echo json_encode(array('success' => array(
										'message' => "successfully updated privilege"
									)));
									$mysqli->close();
									exit();
							}else{
								echo json_encode(array('error' => array(
								    'message' => "Prepared failed.",
								    'code' => "050"
								)));
								exit();
							}		
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Action denied, not enough privilege.",
							    'code' => "052"
							)));
							exit();
						}
					}else{
						echo json_encode(array('error' => array(
						    'message' => "No matching results for the school id",
						    'code' => "053"
						)));
						exit();
					}	
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Excute mysqli query failed.",
					    'code' => "050"
					)));
					exit();
				}	
			}

		}else{
			echo json_encode(array('error' => array(
			    'message' => "Action denied, not enough privilege.",
			    'code' => "052"
			)));
			exit();
		}
	}elseif($_POST['type']=="create_a_visual"){

		if($result0 = $mysqli->query("SELECT * FROM `visualisations` WHERE TEXT_ID='".$_POST['text_id']."'")){
			if ($result0->num_rows == 0) {
				if( ($stmt1 = $mysqli->prepare("INSERT INTO `visualisations` (`ID`, `TEXT_ID`, `TITLE`, `COURSE`, `HTML_BODY`, `CREATED_TIME`, `LAST_MODIFIED`, `DESCRIPTION`, `STATE`, `AZURE_LINK`) VALUES (NULL, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, ?, '0', ?)")) and ($stmt2 = $mysqli->prepare("INSERT INTO `VISUALISATIONSxUSERS` (`TABLE_ID`, `visualisationsID`, `usersID`) VALUES (NULL, ?, ?)")) and ($stmt3 = $mysqli->prepare("INSERT INTO `VISUALISATIONSxLIBRARY` (`TABLE_ID`, `visualisationsID`, `LibraryID`, `type`) VALUES (NULL, ?, ?, ?)"))  ){
					$stmt1->bind_param("ssssss", $text_id, $title, $course, $html_body, $description, $azure_link);
					$stmt2->bind_param("ii", $visualisationsID, $usersID);
					$stmt3->bind_param("iss", $visualisationsID, $LibraryID, $LibraryType);

					include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_variables.php';
					$course = $_POST['course'];
					$text_id = $_POST['text_id'];
					$title = $_POST['title'];
					$azure_link = "";

					$html_body = "";
					$description = "Gravitational waves spread at the speed of light, filling the universe, as Albert Einstein described in his general theory of relativity.";
					$collaborator1 = $_POST['collaborator_school_id_1'];
					$collaborator2 = $_POST['collaborator_school_id_2'];

					if (!$stmt1->execute()) {
						echo json_encode(array('error' => array(
						    'message' => "Execute failed: (" . $stmt1->errno . ") " . $stmt1->error,
						    'code' => "061"
						)));
						exit();
					}else{
						if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE TEXT_ID='".$text_id."'")){
							if ($result->num_rows == 1) {
								$row = $result->fetch_assoc();
								$visualisationsID = $row["ID"];
								$usersID = $_COOKIE['ID'];
								$additional = "";
								if (!$stmt2->execute()) {
									echo json_encode(array('error' => array(
									    'message' => "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error,
									    'code' => "062"
									)));
									exit();
								}else{		
									$additional .= "m1:Creator and Visual linked;\n";
								}
								if($collaborator1 != "" and preg_match("/^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$/",$collaborator1) ){
									if($result1 = $mysqli->query("SELECT * FROM `users` WHERE SCHOOL_ID='".$collaborator1."'")){
										$row1 = $result1->fetch_assoc();
										$usersID = $row1["ID"];
										if (!$stmt2->execute()) {
											echo json_encode(array('error' => array(
											    'message' => "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error,
											    'code' => "062"
											)));
											exit();
										}else{
											$additional .= "m2:Collaborator1 and Visual linked\n";
										}
									}else{
										echo json_encode(array('error' => array(
										    'message' => "collaborator1 not found.",
										    'code' => "064"
										)));
										exit();
									}
								}
								if($collaborator2 != "" and preg_match("/^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$/",$collaborator2) ){
									if($result2 = $mysqli->query("SELECT * FROM `users` WHERE SCHOOL_ID='".$collaborator2."'")){
										$row2 = $result2->fetch_assoc();
										$usersID = $row2["ID"];
										if (!$stmt2->execute()) {
											echo json_encode(array('error' => array(
											    'message' => "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error,
											    'code' => "062"
											)));
											exit();
										}else{
											$additional .= "m3:Collaborator2 and Visual linked\n";
										}
									}else{
										echo json_encode(array('error' => array(
										    'message' => "collaborator2 not found.",
										    'code' => "064"
										)));
										exit();
									}
								}

								for ($i=0; $i < count($CSS); $i++) { 
									if($CSS[$i][4] == 1){
										//compulsory
										$LibraryID = $CSS[$i][0];
										$LibraryType = 'CSS';
										if (!$stmt3->execute()) {
											echo json_encode(array('error' => array(
											    'message' => "Execute failed: (" . $stmt3->errno . ") " . $stmt3->error,
											    'code' => "061"
											)));
											exit();
										}else{
											$additional .= "m4:CSS Library Linked\n";
										}
									}
								} 

								for ($i=0; $i < count($JS); $i++) { 
									if($JS[$i][4] == 1){
										//compulsory
										$LibraryID = $JS[$i][0];
										$LibraryType=  'JS';
										if (!$stmt3->execute()) {
											echo json_encode(array('error' => array(
											    'message' => "Execute failed: (" . $stmt3->errno . ") " . $stmt3->error,
											    'code' => "061"
											)));
											exit();
										}else{
											$additional .= "m4:JS Library Linked\n";
										}
									}
								} 


								mkdir(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/", 0777);
								mkdir(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/", 0777);
								mkdir(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/scripts/", 0777);
								mkdir(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/styles/", 0777);
								mkdir(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/python/", 0777);
								mkdir(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/jnotebook/", 0777);
								$file = rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."CORE/index8asd124hd.txt";
								$newfile = rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/index.php";

								if (!copy($file, $newfile)) {
									echo json_encode(array('error' => array(
									    'message' => "index.php create failed.",
									    'code' => "065"
									)));
									exit();
								}

								echo json_encode(array('success' => array(
								    'message' => 'Visual successfully created.',
								    'additional' => $additional,
								    'folderCreated' => (rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id)
								)));
								// $file = fopen(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/index.php","w");
								// fwrite($file,"");
								// fclose($file);
								exit();
							}
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Excute query failed.",
							    'code' => "063"
							)));
							exit();
						}
					}

					$stmt1->close();
					$stmt2->close();
					$mysqli->close();
					exit();
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Prepared failed.",
					    'code' => "060"
					)));
					exit();
				}
			}else{
				echo json_encode(array('error' => array(
				    'message' => "Text ID already in use",
				    'code' => "066"
				)));
				exit();
			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Excute query failed.",
			    'code' => "063"
			)));
			exit();
		}
	}elseif($_POST['type'] == "getDirectoryTree"){
		echo $_POST['visual_id'].'/'.dirToArray(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'/visuals/'.$_POST['visual_id'].'/');
	}elseif($_POST['type'] == "delete_a_file"){
		if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE TEXT_ID='".$_POST['text_id']."'")){
			if ($result->num_rows == 1) {
				while($row = $result->fetch_assoc()){
					$visualisation_id = $row["ID"];
					if($result2 = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."' AND usersID='".$_COOKIE['ID']."'")){
						if($row2 = $result2->fetch_assoc()){

							if( file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".ltrim($_POST['path'], '/')) ){
								unlink(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".ltrim($_POST['path'], '/'));
								echo json_encode(array('success' => array(
								    'message' => "File ".$_POST['path']." deleted.",
								)));
								$mysqli->close();
								exit();
							}else{
								echo json_encode(array('error' => array(
								    'message' => "File doesn't exist.",
								    'code' => "074"
								)));
								exit();
							}
						}else{
							echo json_encode(array('error' => array(
							    'message' => "You don't have the permission to edit this visualisation.",
							    'code' => "071"
							)));
							exit();
						}
					}else{
						echo json_encode(array('error' => array(
						    'message' => "Excute query failed.",
						    'code' => "072"
						)));
						exit();
					}
				}
			}else{
				echo json_encode(array('error' => array(
				    'message' => "No visualisations found.",
				    'code' => "073"
				)));
				exit();
			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Excute query failed.",
			    'code' => "070"
			)));
			exit();
		}
	}elseif($_POST['type']=="unlink_a_user"){
		$visualisation_id = (int)$_POST['visual_id'];
		$user_id_TBDeleted = (int)$_POST['user_id'];
		$user_id_operator = (int)$_COOKIE['ID'];
		if($result = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."' AND usersID='".$user_id_operator."'")){
			if($row = $result->fetch_assoc()){
				if($stmt_D = $mysqli->prepare("DELETE FROM `VISUALISATIONSxUSERS` WHERE `visualisationsID`=? AND `usersID`=?")){
					$stmt_D->bind_param("ii", $visualisation_id, $user_id_TBDeleted);
					if (!$stmt_D->execute()) {
						echo json_encode(array('error' => array(
						    'message' => "Execute failed: (" . $stmt_D->errno . ") " . $stmt_D->error,
						    'code' => "082"
						)));
						exit();
					}else{
						echo json_encode(array('success' => array(
						    'message' => "Unlinked user with ID #" . $user_id_TBDeleted . " from the visualisation with ID #" . $visualisation_id
						)));
						$stmt_D->close();
						$mysqli->close();
						exit();
					}
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Prepared failed",
					    'code' => "080"
					)));
					exit();
				}
				 
			}else{
				echo json_encode(array('error' => array(
				    'message' => "You don't have the permission to edit this visualisation.",
				    'code' => "081"
				)));
				exit();
			}
		}

	}elseif($_POST['type']=="link_a_user"){
		$visualisation_id = (int)$_POST['visual_id'];
		$user_id_TBAdded = (int)$_POST['user_id_TBAdded'];
		$user_id_operator = (int)$_COOKIE['ID'];
		if($result = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."' AND usersID='".$user_id_operator."'")){
			if($row = $result->fetch_assoc()){

				if( ($stmt = $mysqli->prepare("SELECT * FROM `users` WHERE ID=?")) and ($stmt2 = $mysqli->prepare("INSERT INTO `VISUALISATIONSxUSERS` (`TABLE_ID`, `visualisationsID`, `usersID`) VALUES (NULL, ?, ?)")) ){
					$stmt->bind_param("i", $user_id_TBAdded);
					$stmt2->bind_param("ii", $visualisation_id, $user_id_TBAdded);
					$stmt->bind_result($ID_r, $SCHOOL_ID_r, $FULL_NAME_r, $PRIVILEGE_r, $PASSPHRASE_r);
					if (!$stmt->execute()) {
						echo json_encode(array('error' => array(
						    'message' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error,
						    'code' => "103"
						)));
						exit();
					}else{
						if($stmt->fetch()){
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Developer with this school ID doesn't exist",
							    'code' => "106"
							)));
							exit();
						}
						$stmt->close();
						if($PRIVILEGE_r == 1 or $PRIVILEGE_r == 2){

							if (!$stmt2->execute()) {
								echo json_encode(array('error' => array(
								    'message' => "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error,
								    'code' => "104"
								)));
								exit();
							}else{
								$HTML_r = '<li class="">'.$FULL_NAME_r.' ('.$SCHOOL_ID_r.') <a class="text-danger delete_collaborator_button" data-visual-id="'.$visualisation_id.'" data-user-id="'.$ID_r.'" data-user-name="'.$FULL_NAME_r.' ('.$SCHOOL_ID_r.')"><i class="fa fa-user-times" aria-hidden="true"></i></a></li>';
								echo json_encode(array('success' => array(
								    'message' => "Linked user with ID #" . $user_id_TBAdded . " with the visualisation with ID #" . $visualisation_id,
									'new_collaborator_html' => $HTML_r
								)));
								$stmt2->close();
								$mysqli->close();
								exit();
							}	
						}else{
							echo json_encode(array('error' => array(
							    'message' => "school ID exist, but she/he is not a developer.",
							    'code' => "105"
							)));
							exit();
						}
					}
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Prepared failed.",
					    'code' => "102"
					)));
					exit();
				}
				 
			}else{
				echo json_encode(array('error' => array(
				    'message' => "You don't have the permission to edit this visualisation.",
				    'code' => "101"
				)));
				exit();
			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Excute query failed.",
			    'code' => "100"
			)));
			exit();
		}
	
	}elseif($_POST['type']=="get_user_info"){
		if($stmt = $mysqli->prepare("SELECT * FROM `users` WHERE SCHOOL_ID=?")){
			$stmt->bind_param("s", $school_id);
			if(!preg_match("/^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$/",$_POST['school_id'])){
				echo json_encode(array('error' => array(
				    'message' => 'Input format invalid',
				    'code' => "091"
				)));
			}else{
				$school_id = $_POST['school_id'];
				$stmt->bind_result($ID_r, $SCHOOL_ID_r, $FULL_NAME_r, $PRIVILEGE_r, $PASSPHRASE_r);
				if (!$stmt->execute()) {
					echo json_encode(array('error' => array(
					    'message' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error,
					    'code' => "092"
					)));
					exit();
				}else{
					if($stmt->fetch()){
						if($PRIVILEGE_r == 1 or $PRIVILEGE_r == 2){
							echo json_encode(array('success' => array(
								'message' => "User exist: ".$FULL_NAME_r." (".$SCHOOL_ID_r.") with privilege ".$PRIVILEGE_r,
								'info' => array(
									'ID' => $ID_r, 
									'SCHOOL_ID' => $SCHOOL_ID_r, 
									'FULL_NAME' => $FULL_NAME_r,
									'PRIVILEGE' => $PRIVILEGE_r
							) )));
							$stmt->close();
							$mysqli->close();
							exit();
						}else{
							echo json_encode(array('error' => array(
							    'message' => "school ID exist, but she/he is not a developer.",
							    'code' => "093"
							)));
							exit();
						}
					}else{
						echo json_encode(array('error' => array(
						    'message' => "Developer with this school ID doesn't exist",
						    'code' => "093"
						)));
						exit();
					}
				}
			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Prepared failed.",
			    'code' => "090"
			)));
			exit();
		}
	}elseif($_POST['type']=="update_visual"){
		$visual_id = $_POST['visual_id'];
		$title = $_POST['title'];
		$description = $_POST['description'];
		$bodyHtml = htmlentities($_POST['bodyHtml']);
		$isLogged = $_POST['isLogged'];
		$azure_link = $_POST['azure_url'];
		if(isset($_POST['visualisationsXlibrary'])){$visualisationsXlibrary = $_POST['visualisationsXlibrary'];}else{$visualisationsXlibrary = [];}
		if(isset($_POST['visualisationsXselflibrary'])){$visualisationsXselflibrary = $_POST['visualisationsXselflibrary'];}else{$visualisationsXselflibrary = [];}

		if( ($stmt1 = $mysqli->prepare("UPDATE `visualisations` SET `TITLE` = ?, `LAST_MODIFIED` = CURRENT_TIME(), `DESCRIPTION` = ?, `HTML_BODY` = ?, `LOGGED` = ?, `AZURE_LINK` = ? WHERE `visualisations`.`ID` = ?")) and ($stmt2 = $mysqli->prepare("INSERT INTO `VISUALISATIONSxLIBRARY` (`TABLE_ID`, `visualisationsID`, `LibraryID`, `type`) VALUES (NULL, ?, ?, ?)")) and ($stmt3 = $mysqli->prepare("INSERT INTO `VISUALISATIONSxSelfLIBRARY`(`TABLE_ID`, `visualisationsID`, `FilePath`, `type`, `IsAsync`) VALUES (NULL,?,?,?,?)")) and ($stmt_D = $mysqli->prepare("DELETE FROM `VISUALISATIONSxLIBRARY` WHERE visualisationsID=? AND LibraryID=?")) and ($stmt_D2 = $mysqli->prepare("DELETE FROM `VISUALISATIONSxSelfLIBRARY` WHERE visualisationsID=? AND FilePath=?"))){
					$stmt1->bind_param("sssssi", $title, $description, $bodyHtml, $isLogged, $azure_link, $visual_id);
					$stmt2->bind_param("iss", $visual_id, $library_id, $library_type);
					$stmt3->bind_param("isss", $visual_id, $file_path, $type, $isasync);
					$stmt_D->bind_param("is", $visual_id, $library_id_TBD);
					$stmt_D2->bind_param("is", $visual_id, $file_path_TBD);

					include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_variables.php';

					if (!$stmt1->execute()) {
						echo json_encode(array('error' => array(
						    'message' => "Execute failed: (" . $stmt1->errno . ") " . $stmt1->error,
						    'code' => "111"
						)));
						exit();
					}else{
						for ($i=0; $i < count($visualisationsXlibrary); $i++) { 
							if($result1 = $mysqli->query("SELECT * FROM `VISUALISATIONSxLIBRARY` WHERE visualisationsID='".$visual_id."' AND LibraryID='".$visualisationsXlibrary[$i]['id']."'")){
								$j =0;
								while ($row1 = $result1->fetch_assoc()) {
									$j += 1;
								}
								if($j > 0){

								}else{
									$library_id = $visualisationsXlibrary[$i]['id'];
									$library_type = $visualisationsXlibrary[$i]['type'];
									if (!$stmt2->execute()) {
										echo json_encode(array('error' => array(
										    'message' => "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error,
										    'code' => "112"
										)));
									}else{

									}
								}
							}else{
								echo json_encode(array('error' => array(
								    'message' => "Excute query failed.",
								    'code' => "113"
								)));
								exit();
							}
						}
						if($result2 = $mysqli->query("SELECT * FROM `VISUALISATIONSxLIBRARY` WHERE visualisationsID='".$visual_id."'")){
							while ($row2 = $result2->fetch_assoc()) {
								$hasVisual = 0;
								for ($i=0; $i < count($visualisationsXlibrary); $i++) { 
									if($row2['LibraryID'] == $visualisationsXlibrary[$i]['id']){
										$hasVisual += 1;
									}
								}
								if($hasVisual == 1){

								}elseif($hasVisual == 0){
									$library_id_TBD = $row2['LibraryID'];
									if (!$stmt_D->execute()) {
										echo json_encode(array('error' => array(
										    'message' => "Execute failed: (" . $stmt_D->errno . ") " . $stmt_D->error,
										    'code' => "114"
										)));
										exit();
									}else{
									}
								}else{
									echo json_encode(array('error' => array(
									    'message' => "Library linked more than once for the given visual ID.",
									    'code' => "116"
									)));
									exit();
								}
							}
						}		




						for ($i=0; $i < count($visualisationsXselflibrary); $i++) { 
							if($result3 = $mysqli->query("SELECT * FROM `VISUALISATIONSxSelfLIBRARY` WHERE visualisationsID='".$visual_id."' AND FilePath='".$visualisationsXselflibrary[$i]['file_path']."'")){
								$j =0;
								while ($row3 = $result3->fetch_assoc()) {
									$j += 1;
								}
								if($j == 1){
									if($mysqli->query("UPDATE `VISUALISATIONSxSelfLIBRARY` SET `IsAsync` = '".$visualisationsXselflibrary[$i]['isAsync']."'  WHERE visualisationsID='".$visual_id."' AND FilePath='".$visualisationsXselflibrary[$i]['file_path']."'") === TRUE){
									}else{
										echo json_encode(array('error' => array(
										    'message' => "Execute query failed",
										    'code' => "119"
										)));
										exit();
									}
								}elseif($j == 0){
									$file_path = $visualisationsXselflibrary[$i]['file_path'];
									$type = $visualisationsXselflibrary[$i]['type'];
									$isasync = $visualisationsXselflibrary[$i]['isAsync'];
									if (!$stmt3->execute()) {
										echo json_encode(array('error' => array(
										    'message' => "Execute failed: (" . $stmt3->errno . ") " . $stmt3->error,
										    'code' => "117"
										)));
										exit();
									}else{
									}
								}else{
									echo json_encode(array('error' => array(
									    'message' => "multiple items for the same file path in the selfLibrary databse",
									    'code' => "110"
									)));
									exit();
								}
							}else{
								echo json_encode(array('error' => array(
								    'message' => "Excute query failed.",
								    'code' => "118"
								)));
								exit();
							}
						}
						if($result4 = $mysqli->query("SELECT * FROM `VISUALISATIONSxSelfLIBRARY` WHERE visualisationsID='".$visual_id."'")){
							while ($row4 = $result4->fetch_assoc()) {
								$hasVisual = 0;
								for ($i=0; $i < count($visualisationsXselflibrary); $i++) { 
									if($row4['FilePath'] == $visualisationsXselflibrary[$i]['file_path']){
										$hasVisual += 1;
									}
								}
								if($hasVisual == 1){

								}elseif($hasVisual == 0){
									$file_path_TBD = $row4['FilePath'];
									if (!$stmt_D2->execute()) {
										echo json_encode(array('error' => array(
										    'message' => "Execute failed: (" . $stmt_D2->errno . ") " . $stmt_D2->error,
										    'code' => "114"
										)));
										exit();
									}else{
									}
								}else{
									echo json_encode(array('error' => array(
									    'message' => "Self Library linked more than once for the given visual ID.",
									    'code' => "116"
									)));
									exit();
								}
							}
						}

						echo json_encode(array('success' => array(
							'message' => "successfully updated"
						)));
						$stmt1->close();
						$stmt2->close();
						$stmt3->close();
						$stmt_D->close();
						$stmt_D2->close();
						$mysqli->close();
						exit();				
					}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Prepared failed.",
			    'code' => "110"
			)));
			exit();
		}
	}elseif($_POST['type']=="publish_a_visual_1"){
		$visual_id = $_POST['visual_id'];
		$text_id = $_POST['text_id'];

		if( ($stmt1 = $mysqli->prepare("UPDATE `visualisations` SET `LAST_MODIFIED` = CURRENT_TIME(), `STATE` = '1' WHERE `visualisations`.`ID` = ?")) ){
					$stmt1->bind_param("i", $visual_id);
					if (!$stmt1->execute()) {
						echo json_encode(array('error' => array(
						    'message' => "Execute failed: (" . $stmt1->errno . ") " . $stmt1->error,
						    'code' => "121"
						)));
						exit();
					}else{

						if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE STATE='1'")){
							$i=0;
							while($row = $result->fetch_assoc()){$i+=1;}
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Excute query failed.",
							    'code' => "122"
							)));
							exit();
						}
						include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_sendEmail.php';
						sendEmail('You have '.$i.' visualisations waiting to be approved','<p>Please visit the Imperial Visualisation Developers Dashboard <a href="https://visualisations.ph.ic.ac.uk/Manage/ManageWorks/#'.$text_id.'">Manage Works</a> section to preview the visualisation.</p><p>Thank you.</p>');
						echo json_encode(array('success' => array(
							'message' => "successfully published (state1)"
						)));
						$stmt1->close();
						$mysqli->close();
						exit();				
					}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Prepared failed.",
			    'code' => "120"
			)));
			exit();
		}
	}elseif($_POST['type']=="publish_a_visual_2"){
		$visual_id = $_POST['visual_id'];
		if( $_PRIVILEGE >= 2 ){
			if( ($stmt1 = $mysqli->prepare("UPDATE `visualisations` SET `LAST_MODIFIED` = CURRENT_TIME(), `STATE` = '2' WHERE `visualisations`.`ID` = ?")) ){
						$stmt1->bind_param("i", $visual_id);
						if (!$stmt1->execute()) {
							echo json_encode(array('error' => array(
							    'message' => "Execute failed: (" . $stmt1->errno . ") " . $stmt1->error,
							    'code' => "131"
							)));
							exit();
						}else{
							echo json_encode(array('success' => array(
								'message' => "successfully published (state2)"
							)));
							$stmt1->close();
							$mysqli->close();
							exit();				
						}
			}else{
				echo json_encode(array('error' => array(
				    'message' => "Prepared failed.",
				    'code' => "130"
				)));
				exit();
			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "You don't have the permission to publish.",
			    'code' => "132"
			)));
			exit();
		}
	}elseif($_POST['type']=="unpublish_a_visual"){
		$text_id = $_POST['text_id'];
		if( $_PRIVILEGE >= 2 ){
			if( ($stmt1 = $mysqli->prepare("UPDATE `visualisations` SET `LAST_MODIFIED` = CURRENT_TIME(), `STATE` = '0' WHERE `visualisations`.`TEXT_ID` = ?")) ){
						$stmt1->bind_param("s", $text_id);
						if (!$stmt1->execute()) {
							echo json_encode(array('error' => array(
							    'message' => "Execute failed: (" . $stmt1->errno . ") " . $stmt1->error,
							    'code' => "131"
							)));
							exit();
						}else{
							echo json_encode(array('success' => array(
								'message' => "successfully published (state2)"
							)));
							$stmt1->close();
							$mysqli->close();
							exit();				
						}
			}else{
				echo json_encode(array('error' => array(
				    'message' => "Prepared failed.",
				    'code' => "130"
				)));
				exit();
			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "You don't have the permission to publish.",
			    'code' => "132"
			)));
			exit();
		}
	}elseif($_POST['type']=="log_in"){
		if($stmt = $mysqli->prepare("SELECT * FROM `users` WHERE SCHOOL_ID=?")){
			$stmt->bind_param("s", $school_id);

			if(!preg_match("/^([a-z]{1,3}[0-9]{1,6})|([a-z]{4,10})$/",$_POST['school_id'])){
				echo json_encode(array('error' => array(
				    'message' => 'Input format invalid',
				    'code' => "021"
				)));
			}else{
				$school_id = $_POST['school_id'];
				$stmt->bind_result($ID_r, $SCHOOL_ID_r, $FULL_NAME_r, $PRIVILEGE_r, $PASSPHRASE_r);
				if (!$stmt->execute()) {
					echo json_encode(array('error' => array(
					    'message' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error,
					    'code' => "022"
					)));
					exit();
				}else{
					if($stmt->fetch()){
						if(password_verify($_POST['password'],$PASSPHRASE_r)){
							echo json_encode(array('success' => array(
								'message' => "success",
								'data' => array(
									'ID' => $ID_r, 
									'SCHOOL_ID' => $SCHOOL_ID_r, 
									'FULL_NAME' => $FULL_NAME_r,
									'PRIVILEGE' => $PRIVILEGE_r
							) )));
							setcookie('ID', $ID_r, time() + (86400 * 30), '/');
							setcookie('SCHOOL_ID', $SCHOOL_ID_r, time() + (86400 * 30), '/');
							setcookie('FULL_NAME', $FULL_NAME_r, time() + (86400 * 30), '/');
							setcookie('PRIVILEGE', $PRIVILEGE_r, time() + (86400 * 30), '/');
							$stmt->close();
							$mysqli->close();
							exit();
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Wrong password",
							    'code' => "023"
							)));
							exit();
						}
					}else{
						echo json_encode(array('error' => array(
						    'message' => "No matched school ID",
						    'code' => "023"
						)));
						exit();
					}
				}
			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Prepared failed.",
			    'code' => "010"
			)));
			exit();
		}
	}
}else{
	echo json_encode(array('error' => array(
	    'message' => '"type" is not set.',
	    'code' => "000"
	)));
}
$mysqli->close();
exit();
?>
