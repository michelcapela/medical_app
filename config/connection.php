<?php

$host = 'seu_host';
$dbname = 'seu_db';
$user = 'seu_user';
$pass = 'sua_senha';

try {
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
