<?php
$mysqli = new mysqli("aaxkg92b5u02es.c1csggh1g5jp.eu-west-2.rds.amazonaws.com:3306","admin","Asdfg12345");
// $mysqli = @new mysqli('localhost','visualappuser','Pa$$w0rd','visualisations');
if ($mysqli->connect_errno) {
echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
if($result = $mysqli->query("SHOW DATABASES")){
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
print_r($row);
}
}
}

?>