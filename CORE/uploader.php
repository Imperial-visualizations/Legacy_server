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

// if( $stmt = $mysqli->prepare("INSERT INTO `VISUALISATIONSxSelfLIBRARY` (`TABLE_ID`, `visualisationsID`, `FilePath`, `type`, `IsAsync`) VALUES (NULL, ?, ?, ?, ?)") ){
// 	$stmt->bind_param("issi", $visualisationsID, $FilePath, $type, $IsAsync);
// 	if (!$stmt->execute()) {
// 		echo json_encode(array('error' => array(
// 		    'message' => "Execute failed: (" . $stmt->errno . ") " . $stmt->error,
// 		    'code' => 902
// 		)));
// 		exit();
// 	}else{
// 		$stmt->close();
// 		$mysqli->close();
// 		exit();
// 	}
// }else{
// 	echo json_encode(array('error' => array(
// 	    'message' => "Prepared failed.",
// 	    'code' => 901
// 	)));
// 	exit();
// }

header('Content-Type: application/json');

if( $_SERVER['REQUEST_METHOD'] === 'POST' ){

	if($_POST['type']=="screenshot"){
		$valid_exts = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		$max_size = 30* 1024 * 1024; // max file size in bytes

		$returnJson = array('totalFileUploaded'=>0,'totalFileSuccessed'=>0,'totalFileFailed'=>0,'fileInfos'=>array());
		for($i=0;$i<count($_FILES['image']['tmp_name']);$i++){
			$path=rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$_POST['location']."/assets/";
			$returnJson['totalFileUploaded'] += 1;
			if(is_uploaded_file($_FILES['image']['tmp_name'][$i]) ){
				// get uploaded file extension
				$ext = strtolower(pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION));
				// looking for format and size validity
				if (in_array($ext, $valid_exts) AND $_FILES['image']['size'][$i] < $max_size){
					// unique file path
					if(file_exists($path."SCREENSHOT.png")){unlink($path."SCREENSHOT.png");}
					if(file_exists($path."SCREENSHOT.gif")){unlink($path."SCREENSHOT.gif");}
					if(file_exists($path."SCREENSHOT.jpg")){unlink($path."SCREENSHOT.jpg");}
					if(file_exists($path."SCREENSHOT.jpeg")){unlink($path."SCREENSHOT.jpeg");}
					$path = $path."SCREENSHOT.".$ext;

					$filename = "SCREENSHOT.".$ext;
					// move uploaded file from temp to uploads directory
					if (move_uploaded_file($_FILES['image']['tmp_name'][$i], $path)){
						//$status = 'Image successfully uploaded!';

						if($ext != "gif"){
							$cropped = new Imagick($path);

							$cropped->resizeImage(1064,640,Imagick::FILTER_LANCZOS,0.8,True);
							$cropped->writeImage($path);

							$cropped->destroy();
						}

						$returnJson['totalFileSuccessed'] += 1;
						$path = "/".str_replace($_SERVER['DOCUMENT_ROOT'],"",$path);
						// $path = str_replace("\\","",$path);
						$returnJson['fileInfos'][(String)$i] = array('fileName'=>$filename,'filePath'=>$path,'fileType'=>$ext);

						//perform sql updates here


					}else {
						$status = 'Upload Fail: Unknown error occurred!';
						$returnJson['fileInfos'][(String)$i] = array('error' => $status );
						$returnJson['totalFileFailed'] += 1;
					}


				}else {
					$status = 'Upload Fail: Unsupported file format or It is too large to upload!';
					$returnJson['fileInfos'][(String)$i] = array('error' => $status );
					$returnJson['totalFileFailed'] += 1;
				}
			}else {
				$status = 'Upload Fail: File not uploaded!';
				$returnJson['fileInfos'][(String)$i] = array('error' => $status );
				$returnJson['totalFileFailed'] += 1;
			}
		}
		echo json_encode($returnJson);
	}elseif($_POST['type']=="JSV"){
		$valid_exts = array('js', 'css','jpeg', 'jpg', 'png', 'gif','json','csv','md','txt'); // valid extensions
		$max_size = 30* 1024 * 1024; // max file size in bytes

		$returnJson = array('totalFileUploaded'=>0,'totalFileSuccessed'=>0,'totalFileFailed'=>0,'fileInfos'=>array(),'folderTree'=>'');
		for($i=0;$i<count($_FILES['filess']['tmp_name']);$i++){
			$path=rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$_POST['location']."/";
			$returnJson['totalFileUploaded'] += 1;
			if(is_uploaded_file($_FILES['filess']['tmp_name'][$i]) ){
				// get uploaded file extension
				$ext = strtolower(pathinfo($_FILES['filess']['name'][$i], PATHINFO_EXTENSION));
				// looking for format and size validity
				if (in_array($ext, $valid_exts) AND $_FILES['filess']['size'][$i] < $max_size){
					// unique file path


					if($ext == 'css'){
						$path .= "styles/";
					}elseif($ext == 'js'){
						$path .= "scripts/";
					}else{
						$path .= "assets/";
					}
					$path = $path.$_FILES['filess']['name'][$i];
					$filename = $_FILES['filess']['name'][$i];
					// move uploaded file from temp to uploads directory
					if (move_uploaded_file($_FILES['filess']['tmp_name'][$i], $path)){
						//$status = 'Image successfully uploaded!';

						$returnJson['totalFileSuccessed'] += 1;
						$path = "/".str_replace($_SERVER['DOCUMENT_ROOT'],"",$path);
						// $path = str_replace("\\","",$path);
						$returnJson['fileInfos'][(String)$i] = array('fileName'=>$filename,'filePath'=>$path,'fileType'=>$ext);
						//perform sql updates here

					}else {
						$status = 'Upload Fail: Unknown error occurred!';
						$returnJson['fileInfos'][(String)$i] = array('error' => $status );
						$returnJson['totalFileFailed'] += 1;
					}


				}else{
					$status = 'Upload Fail: Unsupported file format or It is too large to upload!';
					$returnJson['fileInfos'][(String)$i] = array('error' => $status );
					$returnJson['totalFileFailed'] += 1;
				}
			}else {
				$status = 'Upload Fail: File not uploaded!';
				$returnJson['fileInfos'][(String)$i] = array('error' => $status );
				$returnJson['totalFileFailed'] += 1;
			}
		}
		$returnJson['folderTree'] = $_POST['location'].'/'.dirToArray(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'/visuals/'.$_POST['location'].'/');
		echo json_encode($returnJson);
	}elseif($_POST['type']=="JNV"){
		$valid_exts = array('ipynb', 'py','jpeg', 'jpg', 'png', 'gif','json','csv','md','txt'); // valid extensions
		$max_size = 30* 1024 * 1024; // max file size in bytes

		$returnJson = array('totalFileUploaded'=>0,'totalFileSuccessed'=>0,'totalFileFailed'=>0,'fileInfos'=>array(),'folderTree'=>'');
		for($i=0;$i<count($_FILES['filess']['tmp_name']);$i++){
			$path=rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$_POST['location']."/jnotebook/";
			$returnJson['totalFileUploaded'] += 1;
			if(is_uploaded_file($_FILES['filess']['tmp_name'][$i]) ){
				// get uploaded file extension
				$ext = strtolower(pathinfo($_FILES['filess']['name'][$i], PATHINFO_EXTENSION));
				// looking for format and size validity
				if (in_array($ext, $valid_exts) AND $_FILES['filess']['size'][$i] < $max_size){
					// unique file path


					$path = $path.$_FILES['filess']['name'][$i];
					$filename = $_FILES['filess']['name'][$i];
					// move uploaded file from temp to uploads directory
					if (move_uploaded_file($_FILES['filess']['tmp_name'][$i], $path)){
						//$status = 'Image successfully uploaded!';

						$returnJson['totalFileSuccessed'] += 1;
						$path = "/".str_replace($_SERVER['DOCUMENT_ROOT'],"",$path);
						// $path = str_replace("\\","",$path);
						$returnJson['fileInfos'][(String)$i] = array('fileName'=>$filename,'filePath'=>$path,'fileType'=>$ext);
						//perform sql updates here

					}else {
						$status = 'Upload Fail: Unknown error occurred!';
						$returnJson['fileInfos'][(String)$i] = array('error' => $status );
						$returnJson['totalFileFailed'] += 1;
					}


				}else {
					$status = 'Upload Fail: Unsupported file format or It is too large to upload!';
					$returnJson['fileInfos'][(String)$i] = array('error' => $status );
					$returnJson['totalFileFailed'] += 1;
				}
			}else {
				$status = 'Upload Fail: File not uploaded!';
				$returnJson['fileInfos'][(String)$i] = array('error' => $status );
				$returnJson['totalFileFailed'] += 1;
			}
		}
		$returnJson['folderTree'] = $_POST['location'].'/'.dirToArray(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'/visuals/'.$_POST['location'].'/');
		echo json_encode($returnJson);
	}elseif($_POST['type']=="PV"){
		$valid_exts = array('py','jpeg', 'jpg', 'png', 'gif','json','csv','md','txt'); // valid extensions
		$max_size = 30* 1024 * 1024; // max file size in bytes

		$returnJson = array('totalFileUploaded'=>0,'totalFileSuccessed'=>0,'totalFileFailed'=>0,'fileInfos'=>array(),'folderTree'=>'');
		for($i=0;$i<count($_FILES['filess']['tmp_name']);$i++){
			$path=rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/"."visuals/".$_POST['location']."/python/";
			$returnJson['totalFileUploaded'] += 1;
			if(is_uploaded_file($_FILES['filess']['tmp_name'][$i]) ){
				// get uploaded file extension
				$ext = strtolower(pathinfo($_FILES['filess']['name'][$i], PATHINFO_EXTENSION));
				// looking for format and size validity
				if (in_array($ext, $valid_exts) AND $_FILES['filess']['size'][$i] < $max_size){
					// unique file path


					$path = $path.$_FILES['filess']['name'][$i];
					$filename = $_FILES['filess']['name'][$i];
					// move uploaded file from temp to uploads directory
					if (move_uploaded_file($_FILES['filess']['tmp_name'][$i], $path)){
						//$status = 'Image successfully uploaded!';

						$returnJson['totalFileSuccessed'] += 1;
						$path = "/".str_replace($_SERVER['DOCUMENT_ROOT'],"",$path);
						// $path = str_replace("\\","",$path);
						$returnJson['fileInfos'][(String)$i] = array('fileName'=>$filename,'filePath'=>$path,'fileType'=>$ext);
						//perform sql updates here

					}else {
						$status = 'Upload Fail: Unknown error occurred!';
						$returnJson['fileInfos'][(String)$i] = array('error' => $status );
						$returnJson['totalFileFailed'] += 1;
					}


				}else {
					$status = 'Upload Fail: Unsupported file format or It is too large to upload!';
					$returnJson['fileInfos'][(String)$i] = array('error' => $status );
					$returnJson['totalFileFailed'] += 1;
				}
			}else {
				$status = 'Upload Fail: File not uploaded!';
				$returnJson['fileInfos'][(String)$i] = array('error' => $status );
				$returnJson['totalFileFailed'] += 1;
			}
		}
		$returnJson['folderTree'] = $_POST['location'].'/'.dirToArray(rtrim($_SERVER['DOCUMENT_ROOT'],'/')."/".'/visuals/'.$_POST['location'].'/');
		echo json_encode($returnJson);
	}	
}else {
	echo json_encode(array('error' => array(
	'message' => 'Bad request!',
	'code' => 900,
	)));
}

?>
