<?php
$file = 'log.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= http_build_query($_POST);
// Write the contents back to the file
file_put_contents($file, $current);
echo json_encode(array('received' => $_POST));
?>
