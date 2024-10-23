<?php
require_once '../config/connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

   
    if (empty($email) || empty($senha)) {
        echo "Por favor, preencha todos os campos.";
        exit();
    }

    
    $stmt = $conn->prepare("
        SELECT Cliente.id, Cliente.nome, Cliente.senha, Contatos.email, Contatos.telefone
        FROM Cliente
        INNER JOIN Contatos ON Cliente.id = Contatos.cliente_id
        WHERE Contatos.email = :email AND Cliente.senha = :senha
    ");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha); 

    $stmt->execute();

   
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

       
        $_SESSION['user'] = $user;

    
        header("Location: profile.php");
        exit();
    } else {
        echo "<h2>Email ou senha incorretos.</h2>";
        echo '<a href="../user_login/index.html" style="display: inline-block; padding: 10px 20px; 
        background-color: #008000; color: white; text-decoration: none; border-radius: 5px;">Voltar</a>';
        exit();
    }
}
?>
