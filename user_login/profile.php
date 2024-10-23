<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="../assets/css/user_login_style.css">
</head>
<body>
    <div class="form-container">
        <div class="input-group">
            <label>Nome:</label>
            <p><?php echo $user['nome']; ?></p>
        </div>
        <div class="input-group">
            <label>Email:</label>
            <p><?php echo $user['email']; ?></p>
        </div>

        <a href="../user_consulta/index.html" class="submit-btn">Minhas Consultas</a>
        <a href="logout.php" class="submit-btn">Sair</a>
        
    </div>
</body>
</html>
