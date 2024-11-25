<?php

$conn = mysqli_connect('localhost', 'root', '', 'mellodian_park') or die('connection failed');

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>