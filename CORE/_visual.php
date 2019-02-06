<?php
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'CORE/_getPrivilege.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."CORE/_variables.php";
$title = "";
$description = "";
$head = "";
$html_body = "";
$notif = "";
$bottom = "";
if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE TEXT_ID='".$text_id."'")){
		if ($result->num_rows == 1) {
			while($row = $result->fetch_assoc()){
				$visualisation_id = $row["ID"];
				$text_id = $row["TEXT_ID"];
				$title = $row["TITLE"];
				$course_db = $row["COURSE"];
				$course = ''. $course_code[(int)substr($course_db , 0, 2)][(int)substr($course_db , 2, 5)]['Department'].': '.$course_code[(int)substr($course_db , 0, 2)][(int)substr($course_db , 2, 5)]['Name'].' (Y'. $course_code[(int)substr($course_db , 0, 2)][(int)substr($course_db , 2, 5)]['Year'].')';
				$html_body = (html_entity_decode($row["HTML_BODY"]));
				$description = $row["DESCRIPTION"];
				$logged = $row["LOGGED"];
				$state = $row["STATE"];
				$head = "";
				$bottom = "";


				if($result3 = $mysqli->query("SELECT * FROM `VISUALISATIONSxLIBRARY` WHERE visualisationsID='".$visualisation_id."' ORDER BY `TABLE_ID`")){
					while ($row3 = $result3->fetch_assoc()) {
						$LibraryID = $row3["LibraryID"];
						if($row3["type"] == "CSS"){
							for ($i=0; $i < count($CSS); $i++) { 
								if($CSS[$i][0] == $LibraryID ){
									$href = $CSS[$i][3];
									$head .= '
<link rel="stylesheet" href="'.$href.'">';
								}
							}
						}elseif($row3["type"] == "JS"){
							for ($i=0; $i < count($JS); $i++) { 
								if($JS[$i][0] == $LibraryID ){
									$href = $JS[$i][3];
									if($JS[$i][5] == 1){
										$head .= '
<script type="text/javascript" src="'.$href.'" '.(( ($JS[$i][0] == 'js_mathjax_html') or ($JS[$i][0]  == 'js_mathjax_svg') )?'async':'').'></script>';

									}elseif($JS[$i][5] == 0){
										$bottom .= '
<script type="text/javascript" src="'.$href.'" '.(( ($JS[$i][0] == 'js_mathjax_html') or ($JS[$i][0]  == 'js_mathjax_svg') )?'async':'').'></script>';
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

				if($result4 = $mysqli->query("SELECT * FROM `VISUALISATIONSxSelfLIBRARY` WHERE visualisationsID='".$visualisation_id."' ORDER BY FilePath")){
					while ($row4 = $result4->fetch_assoc()) {
						$FilePath = $row4["FilePath"];
						$Type = $row4["type"];
						$IsAsync = $row4["IsAsync"];
						if($row4["type"] == "CSS"){
							$head .= '
<link rel="stylesheet" href="'.$FilePath.'">';
						}elseif($row4["type"] == "JS"){
							if($IsAsync == 1){
								$head .= '
<script type="text/javascript" src="'.$FilePath.'"></script>';
							}elseif($IsAsync == 0){
								$bottom .= '
<script type="text/javascript" src="'.$FilePath.'"></script>';
							}
						}
					}
				}


				if($result2 = $mysqli->query("SELECT * FROM `VISUALISATIONSxUSERS` WHERE visualisationsID='".$visualisation_id."'")){
					$canEdit = 0;
					if(isset($_COOKIE['ID'])){
						while($row2 = $result2->fetch_assoc()){
							if($row2['usersID'] == $_COOKIE['ID']){
								$canEdit += 1;
							}
						}
					}

				}else{
					echo json_encode(array('error' => array(
					    'message' => "Excute query failed.",
					    'code' => "262"
					)));
					exit();
				}

				if($state == 0 or $state == 1){
					if($canEdit == 1){
						$notif = '<div style="height:20px;width:100%;background-color:#fff;border:1px solid #007bff;color:#007bff;text-align:center;line-height:20px;position:fixed;top:0;left:0;">You are previewing this page as a developer. This page has not been published yet.</div>';
					}elseif($canEdit == 0){
						if($_PRIVILEGE == 2 or $_PRIVILEGE == 3){
						$notif = '<div style="height:20px;width:100%;background-color:#fff;border:1px solid #007bff;color:#007bff;text-align:center;line-height:20px;position:fixed;top:0;left:0;">You are previewing this page as an admin/head. This page has not been published yet.</div>';
						}else{
							$title = "";
							$description = "";
							$head = '
        <link rel="stylesheet" href="/assets/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">';
							$html_body = '<div class="mx-auto text-center" style="width: 500px; font-size:30px;"><span style="font-size:120px;"><i class="fa fa fa-cloud-download" aria-hidden="true"></i></span><br>Oops. The visualisation you are looking for is either unavailable or currently offline due to maintenance work. Click <a href="/">here</a> to go back to the index page to see all our online visualisations.</div>';
							$notif = "";
							$bottom = '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>';
						}
					}else{
						// Error
						echo json_encode(array('error' => array(
						    'message' => "Multiple match in the database VISUALISATIONSxUSERS. ",
						    'code' => "265"
						)));
						exit();
					}
				}elseif($state==2){
					//Public
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
				
				$html = '<!doctype html>
				<html>
				<head>
				    <title>'.$title.'</title>
				    <meta charset="utf-8"> <!-- Use utf-8 to decode -->
				    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
				    <!-- Mobile Friendly -->

				    <meta name="description" content="'.$description.' Done by '.$collaboratorString.' for '.$course.'"><!-- Search Engine Friendly -->

				    <link rel="icon" href="https://www.imperial.ac.uk/T4Assets/favicon-196x196.png" type="image/x-icon">
				    <!-- Favicon -->'.$head.'
				    <!-- Global site tag (gtag.js) - Google Analytics -->
					<script async src="https://www.googletagmanager.com/gtag/js?id=UA-42929523-2"></script>
					<script>
					  window.dataLayer = window.dataLayer || [];
					  function gtag(){dataLayer.push(arguments);}
					  gtag(\'js\', new Date());

					  gtag(\'config\', \'UA-42929523-2\');
					</script>

				</head>
				<body>
				'.$html_body.'
				'.$notif.'
				'.$bottom.'
				<script>  
					var version = detectIE();
					if (version === false || version >= 12) {
					} else {
					alert("It\'s interesting that you are still using IE "+version+"...\n we suggest you try modern browsers like Chrome.");
					}
					function detectIE() {
					var ua = window.navigator.userAgent;
					var msie = ua.indexOf("MSIE ");
					if (msie > 0) {
					// IE 10 or older => return version number
					return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
					}
					var trident = ua.indexOf("Trident/");
					if (trident > 0) {
					// IE 11 => return version number
					var rv = ua.indexOf("rv:");
					return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
					}
					var edge = ua.indexOf("Edge/");
					if (edge > 0) {
					// Edge (IE 12+) => return version number
					return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
					}
					// other browser
					return false;
					}
				</script>
				</body>
				</html>
				';
				echo $html;
				// file_put_contents('./index.html', $html);

			}
		}else{
			echo json_encode(array('error' => array(
			    'message' => "Repeated visual_id in database. Please talk to an Admin.",
			    'code' => "264"
			)));
			exit();
		}
}else{
	echo json_encode(array('error' => array(
	    'message' => "Excute query failed.",
	    'code' => "263"
	)));
	exit();
}
$mysqli->close();
?>
