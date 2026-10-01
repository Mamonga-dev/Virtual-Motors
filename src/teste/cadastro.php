<?php
// Inclui a conexão centralizada
include 'conexao.php';

$mensagem = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $confirma_senha = trim($_POST['confirma_senha'] ?? '');

    if (!empty($email) && !empty($senha) && !empty($confirma_senha)) {

        if ($senha === $confirma_senha) {
            // Verifica se o e-mail já existe
            $stmt_check = $conn->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                $mensagem = "Este e-mail já está cadastrado.";
            } else {
                // Criptografa a senha
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                // Insere o novo usuário
                $nome = substr(strstr($email, '@', true) ?: 'Cliente', 0, 100);
                $tipo_usuario = 'cliente';
                $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nome, $email, $senha_hash, $tipo_usuario);

                if ($stmt->execute()) {
                    echo "<script>
                            alert('Cadastro realizado com sucesso! Faça login para continuar.');
                            window.location.href = 'login.php';
                          </script>";
                    exit();
                } else {
                    $mensagem = "Erro ao cadastrar. Tente novamente.";
                }
                $stmt->close();
            }
            $stmt_check->close();

        } else {
            $mensagem = "As senhas não coincidem.";
        }

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
    <title>Cadastro - Virtual Motors</title>
    <link rel="stylesheet" href="../../style.css">
    <style>
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
            margin-top: 10px;
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

        <h2>Criar Conta</h2>
        <p class="subtitle">Cadastre-se para aproveitar nossos recursos</p>

        <?php if (!empty($mensagem)): ?>
            <p class="error-msg"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form method="POST" action="cadastro.php" autocomplete="off">
            <div class="form-group">
                <label>E-MAIL</label>
                <input type="email" name="email" autocomplete="off" required placeholder="exemplo@email.com">
            </div>

            <div class="form-group">
                <label>SENHA</label>
                <input type="password" name="senha" autocomplete="new-password" required placeholder="••••••••••••">
            </div>

            <div class="form-group">
                <label>CONFIRMAR SENHA</label>
                <input type="password" name="confirma_senha" autocomplete="new-password" required placeholder="••••••••••••">
            </div>

            <button type="submit" class="btn-submit">Cadastrar</button>
        </form>

        <div class="register-link">
            Já tem uma conta? <a href="login.php">Faça login</a>
        </div>
        <div style="margin-top: 15px;">
            <a href="../../index.html" style="font-size: 13px; color: #666; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                ← Voltar para a página inicial
            </a>
        </div>
    </div>

</body>
</html>