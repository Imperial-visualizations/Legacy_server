<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_getPrivilege.php';
header('Content-Type: text/html; charset=utf-8');
function dirToArray($dir) {   
   $result = ''; 

   $cdir = scandir($dir); 
   foreach ($cdir as $key => $value) 
   { 
      if (!in_array($value,array(".","..",".DS_Store"))) 
      { 
	   $result .= '<li>'; 
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
         { 
            $result .= $value.'/<ul>'.dirToArray($dir . DIRECTORY_SEPARATOR . $value).'</ul>'; 
         } 
         else 
         { 
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

function dateInText($input){
	$now = new DateTime("now");
	$timeDifference = $input->getTimestamp() - $now->getTimestamp();
	if($timeDifference > 0){
		return "in the future";
	}elseif($timeDifference > -60){
		return abs($timeDifference)." second".($timeDifference==-1?"":"s")." ago";
	}elseif($timeDifference > -60*60){
		return floor(abs($timeDifference/60))." minute".(floor(abs($timeDifference/60))==1?"":"s")." ago";
	}elseif($timeDifference > -60*60*24){
		return floor(abs($timeDifference/(60*60)))." hour".(floor(abs($timeDifference/(60*60)))==1?"":"s")." ago";
	}elseif($timeDifference > -60*60*24*30){
		return floor(abs($timeDifference/(60*60*24)))." day".(floor(abs($timeDifference/(60*60*24)))==1?"":"s")." ago";
	}elseif($timeDifference > -60*60*24*365){
		return floor(abs($timeDifference/(60*60*24*30)))." month".(floor(abs($timeDifference/(60*60*24*30)))==1?"":"s")." ago";
	}elseif($timeDifference > -60*60*24*365*10){
		return floor(abs($timeDifference/(60*60*24*365)))." year".(floor(abs($timeDifference/(60*60*24*365)))==1?"":"s")." ago";
	}elseif($timeDifference > -60*60*24*365*10){
		return floor(abs($timeDifference/(60*60*24*365)))." year".(floor(abs($timeDifference/(60*60*24*365)))==1?"":"s")." ago";
	}else{
		return floor(abs($timeDifference/(60*60*24*365*10)))." decade".(floor(abs($timeDifference/(60*60*24*365*10)))==1?"":"s")." ago";
	}
}


include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."CORE/_variables.php";

if(!isset($_GET['visual_id'])){
	header( 'Location: /Develop/ManageVisuals/' ) ;
}

if($_PRIVILEGE !== FALSE and $_PRIVILEGE !== -1){
	if($_PRIVILEGE == 1 or $_PRIVILEGE == 2){
		//Developer or Admin, but not Head 
		if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE TEXT_ID='".$_GET['visual_id']."'")){
			if ($result->num_rows == 1) {
				while($row = $result->fetch_assoc()){
					$visualisation_id = $row["ID"];
					$text_id = $row["TEXT_ID"];
					$title = $row["TITLE"];
					$course_db = $row["COURSE"];
					$course = ''. $course_code[(int)substr($course_db , 0, 2)][(int)substr($course_db , 2, 5)]['Department'].'Y'. $course_code[(int)substr($course_db , 0, 2)][(int)substr($course_db , 2, 5)]['Year'].': '.$course_code[(int)substr($course_db , 0, 2)][(int)substr($course_db , 2, 5)]['Name'].'';
					$html_body = addslashes(html_entity_decode($row["HTML_BODY"]));
					$html_body = preg_replace("/\n/m", '\n', $html_body);
					$created_time = date_create($row["CREATED_TIME"], timezone_open('Europe/London'));
					$last_modified = date_create($row["LAST_MODIFIED"], timezone_open('Europe/London'));
					$description = $row["DESCRIPTION"];
					$logged = $row["LOGGED"];
					$state = $row["STATE"];
					$azure_link = $row["AZURE_LINK"];

					if($result2 = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."'")){
						$canEdit = 0;
						while($row2 = $result2->fetch_assoc()){
							if($row2['usersID'] == $_COOKIE['ID']){
								$canEdit += 1;
							}
						}
					}else{
						echo json_encode(array('error' => array(
						    'message' => "Excute query failed.",
						    'code' => "262"
						)));
						exit();
					}


					$userIDs = "";
					if($result6 = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."'")){
						$i = 1;
						while($row6 = $result6->fetch_assoc()){
							if($i == $result6->num_rows){
								$connectString = "";
							}else{
								$connectString = "','";
							}
							$userIDs .= $row6['usersID'].$connectString;
							$i += 1;
						}
					}else{
						echo json_encode(array('error' => array(
						    'message' => "Excute query failed.",
						    'code' => "262"
						)));
						exit();
					}
					$collaboratorString = "";
					if($result7 = $mysqli->query("SELECT * FROM `users` WHERE ID IN ('".$userIDs."')")){
						$i = 1;
						while($row7 = $result7->fetch_assoc()){
							if($i == $result7->num_rows-1){
								$connectString = " & ";
							}elseif($i == $result7->num_rows){
								$connectString = "";
							}else{
								$connectString = ", ";
							}
							$collaboratorString .= $row7['FULL_NAME'].$connectString;
							$i += 1;
						}
					}else{
						echo json_encode(array('error' => array(
						    'message' => "Excute query failed.",
						    'code' => "262"
						)));
						exit();
					}


					if($canEdit == 1){
						if($state == 0){
							$_title = 'Update Visualisation';
							$_javascript_head = file_get_contents('./DevelopUpdateVisual.js');
							$_main = file_get_contents('./DevelopUpdateVisual.html');
							$_style = file_get_contents('./style.css');
							$_javascript_bottom = file_get_contents('./DevelopUpdateVisual_bottom.js');

							$_javascript_bottom .= '
							$("#bigTitle").html("You are editing <code>'.$text_id.'/index.php</code><br><small class=\"text-muted\">Last saved: <span title=\"'.date_format($last_modified, 'H:i:s d/m/Y').'\">'.dateInText($last_modified).'</span></small>");
							$("#previewLink").attr("href","/visuals/'.$text_id.'");
							$("#AddCollaboratorButton").attr("data-visual-id","'.$visualisation_id.'");
							$("#save_changes").attr("data-visual-id","'.$visualisation_id.'");
                       		$("#dateInfo").html(\'Created <span title="'.date_format($created_time, 'H:i:s d/m/Y').'">'.dateInText($created_time).'</span>, last edited: <span title="'.date_format($last_modified, 'H:i:s d/m/Y').'">'.dateInText($last_modified).'</span>\');
                       		$("#collaboratorAndDepartmentInfo").html(\'Done by <span class="font-italic">'.$collaboratorString.'</span> for <span class="font-weight-bold">'.$course.'</span>.\');
                       		$("#azure-url").val("'.str_replace("https://notebooks.azure.com","",$azure_link).'");
							$("input[name=\'location\']").val("'.$text_id.'");
							$("#deleteConfirmationDeleteButton").attr("data-text-id","'.$text_id.'");
							$("#visualisation_title").val("'.$title.'");
							$("#previewTitle").text("'.$title.'");
							$("#description").val("'.$description.'");
							$("#limit-160-char").attr("data-limit-display",($("#description").val().length+"/160"));
							$("#previewDescription").html("'.$description.'");
							$("#bodyHtml").val("'.($html_body).'");
							$("#logged").prop("checked",'.(($logged==1)?'true':'false').');
							';
							$_javascript_bottom .= '$("#CSSLibraries").html(\'';
							for ($i=0; $i < count($CSS); $i++) { 
								$_javascript_bottom .= '<div class="form-check '.(($CSS[$i][4]==1)?'disabled':'').'"><label class="form-check-label font-weight-bold"><input class="form-check-input libraries-checkboxes" data-file-path="'.$CSS[$i][3].'" data-type="CSS" data-isAsync="1" type="checkbox" id="'.$CSS[$i][0].'" value="'.$i.'" '.(($CSS[$i][4]==1)?"disabled":"").'> '.$CSS[$i][1].' <a href="'.$CSS[$i][2].'" target="_blank">docs <i class="fa fa-external-link" aria-hidden="true"></i></a></label></div>';
							}             
							$_javascript_bottom .= '\');
							';
							$_javascript_bottom .= '$("#JSLibraries").html(\'';
							for ($i=0; $i < count($JS); $i++) { 
								$_javascript_bottom .= '<div class="form-check '.(($JS[$i][4]==1)?"disabled":"").'"><label class="form-check-label font-weight-bold"><input class="form-check-input libraries-checkboxes" data-file-path="'.$JS[$i][3].'" data-type="JS" data-isAsync="'.$JS[$i][5].'" type="checkbox" id="'.$JS[$i][0].'" value="'.$i.'" '.(($JS[$i][4]==1)?"disabled":"").'> '.$JS[$i][1].' <a href="'.$JS[$i][2].'" target="_blank">docs <i class="fa fa-external-link" aria-hidden="true"></i></a></label><label class="headOrBottom text-secondary"><input class="headOrBottomRadios" type="radio" name="'.$JS[$i][0].'RADIO" id="headOrBottomLabelB'.$JS[$i][0].'" data-file-path="'.$JS[$i][3].'" value="Sync" '.(($JS[$i][5] == 1)?'':'checked').' disabled><label for="headOrBottomLabelB'.$JS[$i][0].'" class="headOrBottomLabel">Sync</label>/<input class="headOrBottomRadios" type="radio" name="'.$JS[$i][0].'RADIO" id="headOrBottomLabelH'.$JS[$i][0].'" data-file-path="'.$JS[$i][3].'" value="Async" '.(($JS[$i][5] == 1)?'checked':'').' disabled><label for="headOrBottomLabelH'.$JS[$i][0].'" class="headOrBottomLabel">Async</label></label></div>';
							}             
							$_javascript_bottom .= '\');
							';

							if($result3 = $mysqli->query("SELECT * FROM `VISUALISATIONSxLIBRARY` WHERE visualisationsID='".$visualisation_id."'")){
								while ($row3 = $result3->fetch_assoc()) {
									$LibraryID = $row3["LibraryID"];
									$_javascript_bottom .= '$("#'.$LibraryID.'").prop("checked",true);
									';
									if($row3["type"] == "CSS"){
										for ($i=0; $i < count($CSS); $i++) { 
											if($CSS[$i][0] == $LibraryID ){
												$href = $CSS[$i][3];
												$_javascript_bottom .= '$("#headInsert").html($("#headInsert").html()+\'\n    '.htmlentities('<link rel="stylesheet" href="'.$href.'">').'\');
												';
											}
										}
									}elseif($row3["type"] == "JS"){
										for ($i=0; $i < count($JS); $i++) { 
											if($JS[$i][0] == $LibraryID ){
												$href = $JS[$i][3];
												if($JS[$i][5] == 1){
													$_javascript_bottom .= '$("#headInsert").html($("#headInsert").html()+\'\n    '.htmlentities('<script type="text/javascript" src="'.$href.'" '.(( ($LibraryID == 'js_mathjax_html') or ($LibraryID  == 'js_mathjax_svg'))?'async':'').'></script>').'\');
													';

												}elseif($JS[$i][5] == 0){
													$_javascript_bottom .= '$("#bottomInsert").html($("#bottomInsert").html()+\'\n    '.htmlentities('<script type="text/javascript" src="'.$href.'"></script>').'\');
													';
												}
											}
										}
									}
								}
							}else{
								echo json_encode(array('error' => array(
								    'message' => "Excute query failed.",
								    'code' => "264"
								)));
								exit();
							}
							$_javascript_bottom .= '$("#CSSFiles").html(\'\');
							';
							$_javascript_bottom .= '$("#JSFiles").html(\'\');
							';

							$cdir = scandir(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/styles/"); 
							foreach ($cdir as $key => $value){ 
								if (!in_array($value,array(".","..",".DS_Store"))){ 
									$_javascript_bottom .= '$("#CSSFiles").html($("#CSSFiles").html()+\'<div class="form-check"><label class="form-check-label font-italic"><input class="form-check-input libraries-checkboxes" type="checkbox" data-file-path="/visuals/'.$text_id.'/styles/'.$value.'" data-type="selfCSS" data-isAsync="1" value="'.$value.'"> styles/'.$value.'</label></div>\');
									';
								} 
							}  
							$cdir = scandir(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/scripts/"); 
							foreach ($cdir as $key => $value){ 
								if (!in_array($value,array(".","..",".DS_Store"))){ 
									$_javascript_bottom .= '$("#JSFiles").html($("#JSFiles").html()+\'<div class="form-check"><label class="form-check-label font-italic"><input class="form-check-input libraries-checkboxes" type="checkbox"  data-file-path="/visuals/'.$text_id.'/scripts/'.$value.'" data-type="selfJS" data-isAsync="0" value="'.$value.'"> scripts/'.$value.'</label><label class="headOrBottom"><input class="headOrBottomRadios" type="radio" name="'.$value.'RADIO" id="headOrBottomLabelB'.$value.'" data-file-path="/visuals/'.$text_id.'/scripts/'.$value.'" value="Sync" checked><label for="headOrBottomLabelB'.$value.'" class="headOrBottomLabel">Sync</label>/<input class="headOrBottomRadios" type="radio" name="'.$value.'RADIO" id="headOrBottomLabelH'.$value.'" data-file-path="/visuals/'.$text_id.'/scripts/'.$value.'" value="Async"><label for="headOrBottomLabelH'.$value.'" class="headOrBottomLabel">Async</label></label></div>\');
									';
								} 
							}

							if($result4 = $mysqli->query("SELECT * FROM `VISUALISATIONSxSelfLIBRARY` WHERE visualisationsID='".$visualisation_id."'")){
								while ($row4 = $result4->fetch_assoc()) {
									$FilePath = $row4["FilePath"];
									$Type = $row4["type"];
									$IsAsync = $row4["IsAsync"];
									$_javascript_bottom .= '$("input[type=\'checkbox\'][data-file-path=\''.$FilePath.'\']").prop("checked",true);';
									$_javascript_bottom .= '$("input[type=\'radio\'][data-file-path=\''.$FilePath.'\'][value=\'Async\']").prop("checked",'.($IsAsync==1?"true":"").');';
									if($row4["type"] == "CSS"){
										$_javascript_bottom .= '$("#headInsert").html($("#headInsert").html()+\'\n    '.htmlentities('<link rel="stylesheet" href="'.$FilePath.'">').'\');';
									}elseif($row4["type"] == "JS"){
										if($IsAsync == 1){
											$_javascript_bottom .= '$("#headInsert").html($("#headInsert").html()+\'\n    '.htmlentities('<script type="text/javascript" src="'.$FilePath.'"></script>').'\');';
										}elseif($IsAsync == 0){
											$_javascript_bottom .= '$("#bottomInsert").html($("#bottomInsert").html()+\'\n    '.htmlentities('<script type="text/javascript" src="'.$FilePath.'"></script>').'\');';
										}
									}
								}
							}



							if($result2 = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."'")){
								$_javascript_bottom .= '$("#collaborator_list").html(\'';
								while($row2 = $result2->fetch_assoc()){
									// print_r($row2);
									if($result5 = $mysqli->query("SELECT * FROM `users` WHERE ID='".$row2['usersID']."'")){
										while($row5 = $result5->fetch_assoc()){
											$_javascript_bottom .= '<li class="">'.$row5['FULL_NAME'].' ('.$row5['SCHOOL_ID'].') ';
											if($row5['ID'] == $_COOKIE['ID']){
											}else{
												$_javascript_bottom .= '<a class="text-danger delete_collaborator_button" data-visual-id="'.$visualisation_id.'" data-user-id="'.$row5['ID'].'" data-user-name="'.$row5['FULL_NAME'].' ('.$row5['SCHOOL_ID'].')"><i class="fa fa-user-times" aria-hidden="true"></i></a>';
											}
											$_javascript_bottom .= '</li>';
										}
									}
								}
								$_javascript_bottom .= '\');';
							}else{
								echo json_encode(array('error' => array(
								    'message' => "Excute query failed.",
								    'code' => "265"
								)));
								exit();
							}


							if(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$_GET['visual_id']."/assets/SCREENSHOT.jpg")){
								$_javascript_bottom .= '$("#previewImg").attr("src","/visuals/'.$_GET['visual_id'].'/assets/SCREENSHOT.jpg");
								';
							}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$_GET['visual_id']."/assets/SCREENSHOT.jpeg")){
								$_javascript_bottom .= '$("#previewImg").attr("src","/visuals/'.$_GET['visual_id'].'/assets/SCREENSHOT.jpeg");
								';
							}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$_GET['visual_id']."/assets/SCREENSHOT.png")){
								$_javascript_bottom .= '$("#previewImg").attr("src","/visuals/'.$_GET['visual_id'].'/assets/SCREENSHOT.png");
								';
							}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$_GET['visual_id']."/assets/SCREENSHOT.gif")){
								$_javascript_bottom .= '$("#previewImg").attr("src","/visuals/'.$_GET['visual_id'].'/assets/SCREENSHOT.gif");
								';
							}
							$_javascript_bottom .= '$("#directory_tree").html("'.$_GET['visual_id'].'/'.dirToArray(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'/visuals/'.$_GET['visual_id'].'/').'");
							';

							include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
							echo $_html;
						}elseif($state == 1){
							$_title = 'Update Visualisation';
							$_main = '<div class="mx-auto text-center" style="width: 500px; font-size:30px;"><span style="font-size:120px;"><i class="fa fa-clock-o" aria-hidden="true"></i></span><br>You have published this visualisation and it\'s now waiting for approval from one of the admins. Talk to an Admin to revert it. Click <a href="/Develop/ManageVisuals/">here</a> tp go back to Manage Visualisations.</div>';

							include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
							echo $_html;
						}elseif($state == 2){
							$_title = 'Update Visualisation';
							$_main = '<div class="mx-auto text-center" style="width: 500px; font-size:30px;"><span style="font-size:120px;"><i class="fa fa-globe" aria-hidden="true"></i></span><br>Congratuation! You have published this visualisation and it has been approved by one of the admins! Ask an Admin to "unpublish" the visualisation if you need to change anything. Click <a href="/Develop/ManageVisuals/">here</a> to go back to Manage Visualisations.</div>';

							include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
							echo $_html;
						}else{
							$_title = 'Update Visualisation';
							$_main = '<div class="mx-auto text-center" style="width: 500px; font-size:30px;"><span style="font-size:120px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span><br>Something went wrong and I don\'t know why... Click <a href="/Develop/ManageVisuals/">here</a> to go back to Manage Visualisations.</div>';

							include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
							echo $_html;
						}					
					}elseif($canEdit == 0){
						$_title = 'Update Visualisation';
						$_main = '<div class="mx-auto text-center" style="width: 500px; font-size:30px;"><span style="font-size:120px;"><i class="fa fa-ban" aria-hidden="true"></i></span><br>It looks like you don\'t have the permission to edit this visualisation. Click <a href="/Develop/ManageVisuals/">here</a> to go back to Manage Visualisations.</div>';

						include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
						echo $_html;
					}else{
						$_title = 'Update Visualisation';
						$_main = '<div class="mx-auto text-center" style="width: 500px; font-size:30px;"><span style="font-size:120px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span><br>Something went wrong and I don\'t know why... Click <a href="/Develop/ManageVisuals/">here</a> to go back to Manage Visualisations.</div>';

						include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
						echo $_html;
					}

				}
			}else{
				$_title = 'Update Visualisation';
				$_main = '<div class="mx-auto text-center" style="width: 500px; font-size:30px;"><span style="font-size:120px;"><i class="fa fa-meh-o" aria-hidden="true"></i></span><br>Oops. The visualisation you are looking for doesn\'t exist or have more than one copy. Talk to an Admin if you think it\'s the latter problem. Click <a href="/Develop/ManageVisuals/">here</a> tp go back to Manage Visualisations.</div>';

				include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
				echo $_html;
			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Excute query failed.",
			    'code' => "263"
			)));
			exit();
		}
	}else{
		header( 'Location: /developers.php' ) ;
	}
}else{
	header( 'Location: /Tlogin/?from='.$_SERVER['REQUEST_URI'] ) ;
}
$mysqli->close();
?>
