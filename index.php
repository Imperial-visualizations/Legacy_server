<?php

include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'/CORE/_mysql.php';
include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'/CORE/_variables.php';

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
		$_title = 'Imperial Visualisations';
		$_javascript_head = file_get_contents('./assets/index.js');
		$_style = file_get_contents('./assets/index.css');
		$_javascript_bottom = file_get_contents('./assets/index_b.js');
		$_main = '
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-ic" id="nav">
        <span id="menu">
        <div class="bar top"></div>
        <div class="bar mid"></div>
        <div class="bar bottom"></div>
        <div class="del left"></div>
        <div class="del right"></div>
        </span>
		<a href="/">
			<img class="logo" src="/assets/imgs/iv-logo-v4.svg" height="36" alt="">
		</a>
        <span id="search"><input id="searchBar" placeholder="Search Here..."><span id="magnifier"><i class="fa fa-search fa-fw" aria-hidden="true"></i></span></span>
    </nav>

    <div class="container-fluid">
	    <div class="row">
		    <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar" id="courses-nav">
			    <div class="input-group input-group-sm" id="searchBar2Wrapper">
			      <input type="text" id="searchBar2" class="form-control" placeholder="Search">
			      <a id="searchBar2Reset">&times;</a>
			      <span class="input-group-btn">
			        <button class="btn btn-secondary" id="magnifier2" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
			      </span>
			    </div>
			    <hr>
			    <span class="navbar-brand">Courses</span>
			    <nav class="nav nav-pills flex-column">';
foreach ($course_code as $key => $value){

	$_main .= '
    	<a class="nav-link my-1 py-0 courses" href="#'.$value[0]['Department'].'">'.$value[0]['Department'].'<span class="nav-link-float" href="#'.$value[0]['Department'].'Collapse" data-toggle="collapse" aria-expanded="false" aria-controls="'.$value[0]['Department'].'Collapse">+</span></a>
    	<div class="collapse" id="'.$value[0]['Department'].'Collapse">';
	    foreach ($value as $key2 => $value2) {
	    	$code = str_pad($key, 2, '0', STR_PAD_LEFT).str_pad($key2, 3, '0', STR_PAD_LEFT);
	    	if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE `STATE`='2' AND `COURSE` REGEXP '([0-9]{5}\s)*(".$code.")(\s[0-9]{5})*'")){
			    if ($result->num_rows > 0) {
					$_main .= '
		    	<a class="nav-link ml-3 my-2 py-0 courses" style="font-size:0.7rem;" href="#'.$value2['Name'].'">'.$value2['Name'].' (Y'.$value2['Year'].')</a>';
			    }
		    }else{
				echo json_encode(array('error' => array(
				    'message' => "Excute query failed.",
				    'code' => "262"
				)));
				exit();
			}
	    }
    $_main .= '
       	</div>';
}
			    $_main .= '
			    </nav>
			    <hr>
			    <span class="navbar-brand">Links</span>
			    <nav class="nav nav-pills flex-column">
				    <a class="nav-link my-1 py-0" href="">About</a>
				    <a class="nav-link my-1 py-0" href="">T&C</a>
				    <a class="nav-link my-1 py-0" href="">Contact</a>
			    </nav>
			    <hr>
			    <div class="text-center">&copy; Imperial Visualisations</div>
			    <h6 class="mt-1 mb-2 text-center font-italic text-muted">as part of</h6>
			    <img src="../assets/imgs/ICL_logo.svg" class="icl-logo">
		    </nav>  
		    <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
			  <div style="padding-top: 4px;">';   
foreach ($course_code as $key => $value){

	$_main .= '
    	<h1 id="'.$value[0]['Department'].'">'.$value[0]['Department'].'</h1>
		    	<div class="grid">
					<div class="grid-sizer"></div>
					<div class="gutter-sizer"></div>
    	';
	    	// $code = str_pad($key, 2, '0', STR_PAD_LEFT).str_pad($key2, 3, '0', STR_PAD_LEFT);
		    	$dep_code = str_pad($key, 2, '0', STR_PAD_LEFT);
				if($result = $mysqli->query("SELECT * FROM `visualisations` WHERE `STATE`='2' AND `COURSE` REGEXP '(((".$dep_code.")[0-9]{3})|([0-9]{5}\s)+((".$dep_code.")[0-9]{3})(\s[0-9]{5})*)'")){
					$j = 0;
					while($row = $result->fetch_assoc()){
						$visualisation_id = $row["ID"];
						$text_id = $row["TEXT_ID"];
						$title = $row["TITLE"];
						$course_db = $row["COURSE"];
						$courses = explode(" ", $course_db);
						$course = '';
						$i = 1;
						foreach ($courses as $key => $value) {
							$course .= '<a href="'.$course_code[(int)substr($value , 0, 2)][(int)substr($value , 2, 5)]['Department'].'Y'. $course_code[(int)substr($value , 0, 2)][(int)substr($value , 2, 5)]['Year'].': '.$course_code[(int)substr($value , 0, 2)][(int)substr($value , 2, 5)]['Name'].'" class="courses">'.$course_code[(int)substr($value , 0, 2)][(int)substr($value , 2, 5)]['Department'].'Y'. $course_code[(int)substr($value , 0, 2)][(int)substr($value , 2, 5)]['Year'].': '.$course_code[(int)substr($value , 0, 2)][(int)substr($value , 2, 5)]['Name'].'</a>';
							if($i == count($courses)){
								$connectString = "";
							}else{
								$connectString = ' & ';
							}
							$course = $course.$connectString;
							$i += 1;
						}
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
								$collaboratorString .= '<a href="#'.$row4['FULL_NAME'].'" class="courses">'.$row4['FULL_NAME'].'</a>'.$connectString;
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
						<div class="card border" class="previewCard" id="'.$text_id.'">
							<img class="card-img-top" src="'.$screenshot_src.'">
							<div class="card-body">
								<h4 class="card-title">'.$title.'</h4>
								<p class="card-text">'.$description.'</p>
								<small class="text-muted d-block mb-1">
								 Done by <span class="font-italic">'.$collaboratorString.'</span>
								</small>
								<small class="text-muted d-block mb-1">
								 For <span class="font-weight-bold">'.$course.'</span>.
								</small>
								<small class="text-muted d-block mb-4">
								 Created <span title="'.date_format($created_time, 'H:i:s d/m/Y').'">'.dateInText($created_time).'</span>, last edited: <span title="'.date_format($last_modified, 'H:i:s d/m/Y').'">'.dateInText($last_modified).'</span> 
								</small>
								<div class="card-button">
									<div class="btn-group float-right ml-1">
									  <button type="button" class="btn btn-primary" onclick="window.open(\'/visuals/'.$text_id.'/\',\'_blank\')">Visit ☞</button>
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
							</div>
						</div>';
						$j += 1;
					}
				}else{
					echo json_encode(array('error' => array(
					    'message' => "Excute query failed.",
					    'code' => "262"
					)));
					exit();
				}

		$_main .= '
				</div><br>';

}



		$_main .= '
		    </div>
	    </main>
	</div>
</div>
<div id="menu-items">
    <div class="menu-item about">About</div><br>
    <div class="menu-item feedback"><a href="./termsAndConditions/">Terms & Cons</a></div><br>
    <div class="menu-item contact"><a href="mailto:c.clewley@imperial.ac.uk">Contact</a></div>
</div>
<br><br>
<center>Imperial Visualisations  &copy; MMXVII</center>
<h6 class="mt-1 mb-2 text-center font-italic text-muted">as part of</h6>
<div class="icl-logo-2-w"><img src="../assets/imgs/ICL_logo.svg" class="icl-logo-2"></div><br>';   
		// $_main .= file_get_contents('./ManageManageWorks.html');
		include rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'/CORE/_dashboardHTML.php';
		echo $_html;
?>