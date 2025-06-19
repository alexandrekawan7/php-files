<?php

if (!(isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['image']))) {
    header('Location: /php-files/index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rede Social</title>
</head>
<body>
    <h1>Bem-vindo à sua conta!</h1>
    <img src="<?php echo $_COOKIE['image']; ?>" alt="Foto de perfil" />
    <p>Nome de usuário: <?php echo htmlspecialchars($_COOKIE['username']); ?></p>
    <p>Senha: <?php echo htmlspecialchars($_COOKIE['password']); ?></p>
</body>