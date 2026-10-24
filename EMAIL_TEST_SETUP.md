# Configuração do teste isolado de e-mail

O `test.php` é independente do cadastro e do banco de dados do Virtual Motors. Ele valida sintaxe, mostra um diagnóstico DNS e confirma acesso à caixa postal pelo link enviado. Os tokens são aleatórios, armazenados somente como HMAC em um arquivo privado fora do diretório do projeto por padrão, expiram em 30 minutos e são consumidos no primeiro uso. O link não depende de cookie ou da sessão do navegador que o solicitou.

## 1. Instale as dependências

Na pasta do projeto, execute `composer install`. O projeto usa PHPMailer instalado pelo Composer.

## 2. Configure SMTP

Copie `email-test.config.example.php` para `email-test.config.php` e preencha:

- `SMTP_HOST`: servidor SMTP do provedor.
- `SMTP_PORT`: normalmente `587` para TLS ou `465` para SSL.
- `SMTP_SECURITY`: `tls` ou `ssl`.
- `SMTP_USER` e `SMTP_PASS`: credenciais SMTP. Para Gmail, use uma senha de app, não a senha normal da conta.
- `SMTP_FROM_EMAIL`: endereço autorizado pelo provedor para envio.
- `EMAIL_TEST_SECRET`: segredo aleatório com pelo menos 32 caracteres.

O arquivo local `email-test.config.php` está no `.gitignore`; não o adicione ao Git. Alternativamente, defina os mesmos nomes como variáveis de ambiente. Valores de ambiente têm prioridade sobre o arquivo local.

Para gerar um segredo aleatório com PHP:

```powershell
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

Copie o resultado para `EMAIL_TEST_SECRET`.

## 3. Execute isoladamente

Na pasta do projeto, inicie o servidor PHP local:

```powershell
php -S 127.0.0.1:8000
```

Abra `http://127.0.0.1:8000/test.php`, informe uma caixa postal acessível e envie. O link pode ser aberto em qualquer navegador **no mesmo computador**, pois esta página de protótipo aceita somente conexões locais. Não o publique nem disponibilize a página externamente.

Para conferir o fluxo em outro computador, seria necessário hospedar uma instância de teste isolada com HTTPS e um endereço acessível pelo destinatário; a página local, intencionalmente, bloqueia conexões externas.

## Observações

- Se o envio falhar, a página mostra uma mensagem genérica e o detalhe é registrado no log de erros do PHP.
- Registros MX/A/AAAA não provam a existência da caixa postal.
- A confirmação comprova que alguém com acesso à caixa conseguiu abrir o link; o protótipo não cria conta nem altera os dados do site.
