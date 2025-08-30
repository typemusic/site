<?php

function novaConexao()
{

    $hostname = "host";
    $dbname = "nome";
    $username = "usuario";
    $pass = "senha";

    try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn; 
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
    }
}
?>