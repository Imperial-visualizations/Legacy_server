<?php

// $mysqli = new mysqli("localhost","localTestAccount","localTestPassword","visualisations");
$mysqli = @new mysqli('localhost','visualappuser','Pa$$w0rd','visualisations');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>