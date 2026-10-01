<?php
// Inclui a conexão centralizada
include 'conexao.php';

// Inicia a sessão
session_start();

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!empty($email) && !empty($senha)) {

        // Procura o usuário pelo e-mail usando Prepared Statement
        $stmt = $conn->prepare("SELECT id_usuario AS id, email, senha FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $usuario = $resultado->fetch_assoc();

            // Verifica se a senha digitada corresponde ao hash cadastrado
            if (password_verify($senha, $usuario['senha'])) {

                session_regenerate_id(true);

                // Salva os dados do usuário na sessão
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_email'] = $usuario['email'];

                // Redireciona com alerta de sucesso
                echo "<script>
                        alert('Login realizado com sucesso!');
                    window.location.href = '../../index.html';
                      </script>";
                exit();

            } else {
                $mensagem = "E-mail ou senha incorretos.";
            }

        } else {
            $mensagem = "E-mail ou senha incorretos.";
        }

        $stmt->close();

    } else {
        $mensagem = "Preencha todos os campos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Virtual Motors</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        /* Estilos específicos para a tela de login idêntica à referência */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f8f9fa;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            box-sizing: border-box;
            text-align: center;
        }

        .login-logo {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #E50914;
            border-radius: 50%;
            overflow: hidden;
            background: #fff;
        }

        .login-logo img {
            width: 80%;
            object-fit: contain;
        }

        .login-card h2 {
            font-size: 22px;
            color: #111;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .login-card p.subtitle {
            font-size: 13px;
            color: #666;
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #444;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            height: 46px;
            padding: 0 14px;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: #0051ff;
            box-shadow: 0 0 0 3px rgba(0, 81, 255, 0.1);
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 24px;
            margin-top: -10px;
        }

        .forgot-password a {
            font-size: 12px;
            color: #0051ff;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            height: 48px;
            background: #0051ff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: #0040cc;
        }

        .register-link {
            margin-top: 24px;
            font-size: 13px;
            color: #666;
        }

        .register-link a {
            color: #0051ff;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-msg {
            color: #E50914;
            font-size: 12px;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Logotipo Redondo -->
        <div class="login-logo">
            <img src="./VM.png" alt="Virtual Motors">
        </div>

        <h2>VirtualMotors</h2>
        <p class="subtitle">Acesse sua conta para gerenciar seus pedidos</p>

        <?php if (!empty($mensagem)): ?>
            <p class="error-msg"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php" autocomplete="off">
            <div class="form-group">
                <label>E-MAIL</label>
                <input type="email" name="email" autocomplete="off" required placeholder="exemplo@email.com">
            </div>

            <div class="form-group">
                <label>SENHA</label>
                <input type="password" name="senha" autocomplete="new-password" required placeholder="••••••••••••">
            </div>

            <div class="forgot-password">
                <a href="#">Esqueceu a senha?</a>
            </div>

            <button type="submit" class="btn-submit">Entrar</button>
        </form>

        <div class="register-link">
            Não tem uma conta? <a href="cadastro.php">Criar conta</a>
        </div>
        <div style="margin-top: 15px;">
            <a href="../../index.html" style="font-size: 13px; color: #666; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                ← Voltar para a página inicial
            </a>
        </div>
    </div>

</body>
</html>