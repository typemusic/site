<?php
$config = require 'config.php';

$servername = $config[$servername];
$username = $config[$username];
$password = $config[$password];
$dbname = $config[$dbname];



$conn = new mysqli($servername, $username, $password, $dbname);    

if ($conn->connect_error) {
    die("". $conn->connect_error);
}

// Só pra ver se funcionou

echo " DEU CERTO PORRAAAAAAAAAAAAAAA ";

?>