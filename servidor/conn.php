<?php

function novaConexao()
{
    $hostname = "br612.hostgator.com.br";
    $dbname = "hubsap45_bd_typemusic";
    $username = "hubsap45_usrtypemusic";
    $pass = "y7s}perfume*7JJ";

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $username, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn; // importante: retornar a conexão
    } catch (PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
    }
}
?>