<?php
    if (!empty($_POST)) {
        if (!(isset($_POST['username']) && isset($_POST['password']) && isset($_FILES['image']))) {
            echo "Dados ausentes.";
            exit();
        }

        $diretorioDestino = "uploads/";

        $arquivoDestino   = $diretorioDestino . basename($_FILES["image"]["name"]);
        $uploadOk         = 1;

        $tipoArquivo      = strtolower(pathinfo($arquivoDestino, PATHINFO_EXTENSION));

        if (isset($_POST["enviar"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                echo "Arquivo é uma imagem - " . $check["mime"] . ".<br>";
                $uploadOk = 1;
            } else {
                echo "Arquivo não é uma imagem.<br>";
                $uploadOk = 0;
            }
        }

        if (file_exists($arquivoDestino)) {
            echo "Desculpe, o arquivo já existe.<br>";
            $uploadOk = 0;
        }

        if ($_FILES["image"]["size"] > 500000) {
            echo "Desculpe, seu arquivo é muito grande.<br>";
            $uploadOk = 0;
        }

        if (
            $tipoArquivo !== "jpg" &&
            $tipoArquivo !== "png" &&
            $tipoArquivo !== "jpeg" &&
            $tipoArquivo !== "gif" &&
            $tipoArquivo !== "tiff"
        ) {
            echo "Desculpe, apenas arquivos JPG, JPEG, PNG, TIFF e GIF são permitidos.<br>";
            $uploadOk = 0;
        }

        if ($uploadOk === 0) {
            echo "Desculpe, seu arquivo não foi enviado.<br>";
        } else {
            // Se todas as validações passaram, tenta mover o arquivo para o diretório de destino
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $arquivoDestino)) {
                setcookie('username', $_POST['username']);
                setcookie('password', $_POST['password']);
                setcookie('image', $arquivoDestino);

                header('Location: /php-files/dashboard.php');
                exit();
            } else {
                echo "Desculpe, ocorreu um erro ao enviar seu arquivo.<br>";
            }
        }

        exit();
    }

    if (isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['image'])) {
        header('Location: /php-files/dashboard.php');
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
    <form action="/php-files/index.php" method="POST" enctype="multipart/form-data">
        <label>Digite suas informações para entrar na rede social</label>

        <div>
            <label>Nome de usuário:</label>
            <input type="text" name="username" required/>
        </div>

        <div>    
            <label>Senha:</label>
            <input type="password" name="password" required/>
        </div>

        <div>
            <label>Foto de perfil:</label>
            <input type="file" name="image" required/>
        </div>

        <div>
            <button type="submit">Entrar</button>
        </div>
    </form>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            row-gap: 1vh;
        }

        form > label {
            font-weight: bolder;
            font-size: x-large;
        }

        form > div > label {
            display: block;
        }
    </style>
</body>
</html>