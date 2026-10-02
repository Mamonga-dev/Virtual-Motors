<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loja_carros";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Define o charset para garantir suporte correto a caracteres especiais
$conn->set_charset("utf8mb4");
?>