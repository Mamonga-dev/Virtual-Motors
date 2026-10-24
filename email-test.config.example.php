<?php
declare(strict_types=1);

/* Copie este arquivo para email-test.config.php e substitua os exemplos. */
return [
    // Exemplo para Gmail: smtp.gmail.com, porta 587, tls.
    // Use uma senha de app SMTP; não use a senha normal da conta.
    'SMTP_HOST' => 'smtp.gmail.com',
    'SMTP_PORT' => '587',
    'SMTP_SECURITY' => 'tls',
    'SMTP_USER' => 'sua-conta@gmail.com',
    'SMTP_PASS' => 'senha-de-app-do-provedor',
    'SMTP_FROM_EMAIL' => 'sua-conta@gmail.com',
    'SMTP_FROM_NAME' => 'Virtual Motors - teste',

    // Gere uma chave aleatória exclusiva com pelo menos 32 caracteres.
    'EMAIL_TEST_SECRET' => '',

    // Opcional. Sem valor, a URL é montada com o endereço local usado no navegador.
    // Se configurar, informe a URL completa da página test.php.
    'EMAIL_TEST_BASE_URL' => '',

    // Opcional. Por padrão, os tokens ficam em uma pasta temporária privada do sistema.
    'EMAIL_TEST_STORAGE_PATH' => '',
];
