<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_getPrivilege.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_mysql.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."CORE/_variables.php";

function dateInText($input){
	$now = new DateTime("now");
	$timeDifference = $input->getTimestamp() - $now->getTimestamp();
	if($timeDifference >= 0){
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


if($_PRIVILEGE !== FALSE and $_PRIVILEGE !== -1){
	if($_PRIVILEGE >= 2){
		//Head or Admin, but not Developers 
		$_title = 'Manage Works';
		$_javascript_head = file_get_contents('./ManageManageWorks.js');
		$_style = file_get_contents('./style.css');
		$_main = '
<h1>Manage Works</h1>
<div class="row">
  <div class="col-12">
<div class="grid"><div class="grid-sizer"></div>
  <div class="gutter-sizer"></div>';   

				if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE STATE='1'")){
					$count = $result->num_rows;
				}else{
					$count = "error";
				}

				$_main .= '
				<div class="card border border-danger" class="previewCard" style="height:200px;">
					<div class="card-body">
						<h4 class="card-title text-danger">Works waiting to be approved ('.$count.')</h4>
					</div>
				</div>';


				if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE STATE='1'")){
					while($row = $result->fetch_assoc()){
						$visualisation_id = $row["ID"];
						$text_id = $row["TEXT_ID"];
						$title = $row["TITLE"];
						$course = $row["COURSE"];
						$course = array_search($course,$course_code);
						$html_body = $row["HTML_BODY"];
						$created_time = date_create($row["CREATED_TIME"], timezone_open('Europe/London'));
						$last_modified = date_create($row["LAST_MODIFIED"], timezone_open('Europe/London'));
						$description = $row["DESCRIPTION"];
						$logged = $row["LOGGED"];
						$state = $row["STATE"];
						if(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.jpg")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.jpg';
						}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.jpeg")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.jpeg';
						}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.png")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.png';
						}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.gif")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.gif';
						}else{
							$screenshot_src = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22266%22%20height%3D%22160%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20266%20160%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15e9adc4c9e%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15e9adc4c9e%22%3E%3Crect%20width%3D%22266%22%20height%3D%22160%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2299.7578125%22%20y%3D%2286%22%3E266x160%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E';
						}

						$userIDs = "";
						if($result3 = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."'")){
							$i = 1;
							while($row3 = $result3->fetch_assoc()){
								if($i == $result3->num_rows){
									$connectString = "";
								}else{
									$connectString = "','";
								}
								$userIDs .= $row3['usersID'].$connectString;
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
						if($result4 = $mysqli->query("SELECT * FROM `users` WHERE ID IN ('".$userIDs."')")){
							$i = 1;
							while($row4 = $result4->fetch_assoc()){
								if($i == $result4->num_rows-1){
									$connectString = " & ";
								}elseif($i == $result4->num_rows){
									$connectString = "";
								}else{
									$connectString = ", ";
								}
								$collaboratorString .= $row4['FULL_NAME'].$connectString;
								$i += 1;
							}
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Excute query failed.",
							    'code' => "262"
							)));
							exit();
						}
						$_main .= '
						<div class="card border border-danger" class="previewCard" id="'.$text_id.'">
							<img class="card-img-top" src="'.$screenshot_src.'">
							<div class="card-body">
								<h4 class="card-title">'.$title.'&nbsp<small class="text-muted hover-light-up" title="Pending for approval. Please approve or reject."><i class="fa fa-clock-o" aria-hidden="true"></i></small></h4>
								<p class="card-text">'.$description.'</p>
								<small class="text-muted d-block mb-1">
								 Created <span title="'.date_format($created_time, 'H:i:s d/m/Y').'">'.dateInText($created_time).'</span>, last edited: <span title="'.date_format($last_modified, 'H:i:s d/m/Y').'">'.dateInText($last_modified).'</span> 
								</small>
								<small class="text-muted d-block mb-4">
								 Done by <span class="font-italic">'.$collaboratorString.'</span> for <span class="font-weight-bold">'.$course.'</span>.
								</small>
								<div class="btn-group float-right ml-1">
								  <button type="button" class="btn btn-primary" onclick="window.open(\'/visuals/'.$text_id.'/\',\'_blank\')">Visit ☞</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item text-primary approve-and-publish-buttons" data-visual-id="'.$visualisation_id.'" data-text-id="'.$text_id.'">Approve and Publish <i class="fa fa-globe" aria-hidden="true"></i></a>
								    <a class="dropdown-item text-secondary reject-buttons" data-visual-id="'.$visualisation_id.'" data-text-id="'.$text_id.'">Reject <i class="fa fa-hand-paper-o" aria-hidden="true"></i></a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item text-danger delete_buttons disabled" data-visual-id="'.$visualisation_id.'">Delete <i class="fa fa-trash" aria-hidden="true"></i></a>
								  </div>
								</div>
								<div class="dropdown float-right">
									<button class="btn btn-info dropdown-toggle" type="button" id="Options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Options
									</button>
									<div class="dropdown-menu" aria-labelledby="Options">
										<a class="dropdown-item" href="#">Download Js Version <i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
										<a class="dropdown-item" href="#">Download Jupyter Notebook Version <i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
										<a class="dropdown-item" href="#">Visit Jupyter Notebook Version <i class="fa fa-external-link" aria-hidden="true"></i></a>
										<a class="dropdown-item" href="#">Download Python Version <i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
						</div>';
					}
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Excute query failed.",
					    'code' => "262"
					)));
					exit();
				}



				if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE STATE='2'")){
					$count = $result->num_rows;
				}else{
					$count = "error";
				}

				$_main .= '
				<div class="card border border-primary" class="previewCard" style="height:200px;">
					<div class="card-body">
						<h4 class="card-title text-primary">Published Works ('.$count.')</h4>
					</div>
				</div>';



				if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE STATE='2'")){
					while($row = $result->fetch_assoc()){
						$visualisation_id = $row["ID"];
						$text_id = $row["TEXT_ID"];
						$title = $row["TITLE"];
						$course = $row["COURSE"];
						$course = array_search($course,$course_code);
						$html_body = $row["HTML_BODY"];
						$created_time = date_create($row["CREATED_TIME"], timezone_open('Europe/London'));
						$last_modified = date_create($row["LAST_MODIFIED"], timezone_open('Europe/London'));
						$description = $row["DESCRIPTION"];
						$logged = $row["LOGGED"];
						$state = $row["STATE"];
						if(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.jpg")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.jpg';
						}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.jpeg")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.jpeg';
						}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.png")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.png';
						}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.gif")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.gif';
						}else{
							$screenshot_src = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22266%22%20height%3D%22160%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20266%20160%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15e9adc4c9e%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15e9adc4c9e%22%3E%3Crect%20width%3D%22266%22%20height%3D%22160%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2299.7578125%22%20y%3D%2286%22%3E266x160%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E';
						}

						$userIDs = "";
						if($result3 = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."'")){
							$i = 1;
							while($row3 = $result3->fetch_assoc()){
								if($i == $result3->num_rows){
									$connectString = "";
								}else{
									$connectString = "','";
								}
								$userIDs .= $row3['usersID'].$connectString;
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
						if($result4 = $mysqli->query("SELECT * FROM `users` WHERE ID IN ('".$userIDs."')")){
							$i = 1;
							while($row4 = $result4->fetch_assoc()){
								if($i == $result4->num_rows-1){
									$connectString = " & ";
								}elseif($i == $result4->num_rows){
									$connectString = "";
								}else{
									$connectString = ", ";
								}
								$collaboratorString .= $row4['FULL_NAME'].$connectString;
								$i += 1;
							}
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Excute query failed.",
							    'code' => "262"
							)));
							exit();
						}
						$_main .= '
						<div class="card border border-primary" class="previewCard" id="'.$text_id.'">
							<img class="card-img-top" src="'.$screenshot_src.'">
							<div class="card-body">
								<h4 class="card-title">'.$title.'&nbsp<small class="text-muted hover-light-up" title="Published. Everyone can see it"><i class="fa fa-globe" aria-hidden="true"></i></small></h4>
								<p class="card-text">'.$description.'</p>
								<small class="text-muted d-block mb-1">
								 Created <span title="'.date_format($created_time, 'H:i:s d/m/Y').'">'.dateInText($created_time).'</span>, last edited: <span title="'.date_format($last_modified, 'H:i:s d/m/Y').'">'.dateInText($last_modified).'</span> 
								</small>
								<small class="text-muted d-block mb-4">
								 Done by <span class="font-italic">'.$collaboratorString.'</span> for <span class="font-weight-bold">'.$course.'</span>.
								</small>
								<div class="btn-group float-right ml-1">
								  <button type="button" class="btn btn-primary" onclick="window.open(\'/visuals/'.$text_id.'/\',\'_blank\')">Visit ☞</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item text-secondary take-down-button" data-visual-id="'.$visualisation_id.'" data-text-id="'.$text_id.'">Take down <i class="fa fa-cloud-download" aria-hidden="true"></i></a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item text-danger delete_buttons disabled" data-visual-id="'.$visualisation_id.'">Delete <i class="fa fa-trash" aria-hidden="true"></i></a>
								  </div>
								</div>
								<div class="dropdown float-right">
									<button class="btn btn-info dropdown-toggle" type="button" id="Options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Options
									</button>
									<div class="dropdown-menu" aria-labelledby="Options">
										<a class="dropdown-item" href="#">Download Js Version <i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
										<a class="dropdown-item" href="#">Download Jupyter Notebook Version <i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
										<a class="dropdown-item" href="#">Visit Jupyter Notebook Version <i class="fa fa-external-link" aria-hidden="true"></i></a>
										<a class="dropdown-item" href="#">Download Python Version <i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
						</div>';
					}
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Excute query failed.",
					    'code' => "262"
					)));
					exit();
				}


				if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE STATE='0'")){
					$count = $result->num_rows;
				}else{
					$count = "error";
				}
				$_main .= '
				<div class="card" class="previewCard" style="height:200px;">
					<div class="card-body">
						<h4 class="card-title text-secondary">Works in progress ('.$count.')</h4>
					</div>
				</div>';



				if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE STATE='0'")){
					while($row = $result->fetch_assoc()){
						$visualisation_id = $row["ID"];
						$text_id = $row["TEXT_ID"];
						$title = $row["TITLE"];
						$course = $row["COURSE"];
						$course = array_search($course,$course_code);
						$html_body = $row["HTML_BODY"];
						$created_time = date_create($row["CREATED_TIME"], timezone_open('Europe/London'));
						$last_modified = date_create($row["LAST_MODIFIED"], timezone_open('Europe/London'));
						$description = $row["DESCRIPTION"];
						$logged = $row["LOGGED"];
						$state = $row["STATE"];
						if(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.jpg")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.jpg';
						}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.jpeg")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.jpeg';
						}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.png")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.png';
						}elseif(file_exists(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$text_id."/assets/SCREENSHOT.gif")){
							$screenshot_src = '/visuals/'.$text_id.'/assets/SCREENSHOT.gif';
						}else{
							$screenshot_src = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22266%22%20height%3D%22160%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20266%20160%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_15e9adc4c9e%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A13pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_15e9adc4c9e%22%3E%3Crect%20width%3D%22266%22%20height%3D%22160%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2299.7578125%22%20y%3D%2286%22%3E266x160%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E';
						}

						$userIDs = "";
						if($result3 = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."'")){
							$i = 1;
							while($row3 = $result3->fetch_assoc()){
								if($i == $result3->num_rows){
									$connectString = "";
								}else{
									$connectString = "','";
								}
								$userIDs .= $row3['usersID'].$connectString;
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
						if($result4 = $mysqli->query("SELECT * FROM `users` WHERE ID IN ('".$userIDs."')")){
							$i = 1;
							while($row4 = $result4->fetch_assoc()){
								if($i == $result4->num_rows-1){
									$connectString = " & ";
								}elseif($i == $result4->num_rows){
									$connectString = "";
								}else{
									$connectString = ", ";
								}
								$collaboratorString .= $row4['FULL_NAME'].$connectString;
								$i += 1;
							}
						}else{
							echo json_encode(array('error' => array(
							    'message' => "Excute query failed.",
							    'code' => "262"
							)));
							exit();
						}
						$_main .= '
						<div class="card" class="previewCard" id="'.$text_id.'">
							<img class="card-img-top" src="'.$screenshot_src.'">
							<div class="card-body">
								<h4 class="card-title">'.$title.'&nbsp<small class="text-muted hover-light-up" title="Not published, only the developer and Admin/Head can see it."><i class="fa fa-lock" aria-hidden="true"></i></small></h4>
								<p class="card-text">'.$description.'</p>
								<small class="text-muted d-block mb-1">
								 Created <span title="'.date_format($created_time, 'H:i:s d/m/Y').'">'.dateInText($created_time).'</span>, last edited: <span title="'.date_format($last_modified, 'H:i:s d/m/Y').'">'.dateInText($last_modified).'</span> 
								</small>
								<small class="text-muted d-block mb-4">
								 Done by <span class="font-italic">'.$collaboratorString.'</span> for <span class="font-weight-bold">'.$course.'</span>.
								</small>
								 <button type="button" class="btn btn-primary float-right ml-1" onclick="window.open(\'/visuals/'.$text_id.'/\',\'_blank\')">Visit ☞</button>
								<div class="dropdown float-right">
									<button class="btn btn-info dropdown-toggle" type="button" id="Options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Options
									</button>
									<div class="dropdown-menu" aria-labelledby="Options">
										<a class="dropdown-item" href="#">Download Js Version <i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
										<a class="dropdown-item" href="#">Download Jupyter Notebook Version <i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
										<a class="dropdown-item" href="#">Visit Jupyter Notebook Version <i class="fa fa-external-link" aria-hidden="true"></i></a>
										<a class="dropdown-item" href="#">Download Python Version <i class="fa fa-file-archive-o" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>
						</div>';
					}
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Excute query failed.",
					    'code' => "262"
					)));
					exit();
				}






		$_main .= '
</div>
</div>
</div>';   
		$_main .= file_get_contents('./ManageManageWorks.html');
		include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_dashboardHTML.php';
		echo $_html;
	}elseif($_PRIVILEGE == 3){
		header( 'Location: /developers.php' ) ;
	}
}else{
	header( 'Location: /Tlogin/?from=/Develop/ManageVisuals/' ) ;
}
?>
