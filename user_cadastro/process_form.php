<?php
require_once '../config/connection.php';


function clean_input($data) {
    return htmlspecialchars(trim($data));
}


function validate_password($password, $confirm_password) {
    if ($password !== $confirm_password) {
        return false;
    }
    return true;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nome = clean_input($_POST['nome']);
    $celular = clean_input($_POST['celular']);
    $email = clean_input($_POST['email']);
    $senha = clean_input($_POST['senha']);
    $confirmar_senha = clean_input($_POST['confirmar-senha']);

   
    if (empty($nome) || empty($celular) || empty($email) || empty($senha) || empty($confirmar_senha)) {
        echo "<h2>Todos os campos são obrigatórios!</h2>";
        echo '<a href="../user_cadastro/index.html" style="display: inline-block; padding: 10px 20px; 
        background-color: #008000; color: white; text-decoration: none; border-radius: 5px;">Voltar</a>';
        exit(); 
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<h2>E-mail inválido!</h2>";
        echo '<a href="../user_cadastro/index.html" style="display: inline-block; padding: 10px 20px; 
        background-color: #008000; color: white; text-decoration: none; border-radius: 5px;">Voltar</a>';
        exit(); 
    }

    if (!validate_password($senha, $confirmar_senha)) {
        echo "<h2>As senhas não coincidem!</h2>";
        echo '<a href="../user_cadastro/index.html" style="display: inline-block; padding: 10px 20px; 
        background-color: #008000; color: white; text-decoration: none; border-radius: 5px;">Voltar</a>';
        exit(); 
    }

    try {
        
        $conn->beginTransaction();

       
        $stmtCliente = $conn->prepare("INSERT INTO Cliente (nome, senha) VALUES (:nome, :senha)");
        $stmtCliente->bindParam(':nome', $nome);
        $stmtCliente->bindParam(':senha', $senha); 
        $stmtCliente->execute();

        $cliente_id = $conn->lastInsertId();

        $stmtContato = $conn->prepare("INSERT INTO Contatos (cliente_id, telefone, email) VALUES (:cliente_id, :telefone, :email)");
        $stmtContato->bindParam(':cliente_id', $cliente_id);
        $stmtContato->bindParam(':telefone', $celular);
        $stmtContato->bindParam(':email', $email);
        $stmtContato->execute();

      
        $conn->commit();

        echo "Conta criada com sucesso!";
        header("Location: ../cadastro_success/index.html");
        exit(); 

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Erro ao criar conta: " . $e->getMessage();
    }
} else {
    echo "Método de requisição inválido!";
}
?>
