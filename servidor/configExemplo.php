<?php

define('DB_HOST', 'hostname');
define('DB_USER', 'usrname');
define('DB_PASS', 'senha');
define('DB_NAME', 'nome');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>