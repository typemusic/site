<?php

$servername = "br612.hostgator.com.br";
$username = "hubsap45_usrtypemusic";
$password = "y7s}perfume*7JJ";
$dbname = "hubsap45_bd_typemusic";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("". $conn->connect_error);
}

// Só pra ver se funcionou

echo " DEU CERTO PORRAAAAAAAAAAAAAAAAAAAAAA";

?>