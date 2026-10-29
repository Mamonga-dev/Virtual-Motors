<div align="center">

<img src="../assets/virtual-motors.png" width="280" alt="Virtual Motors">

# Virtual Motors

**E-commerce em desenvolvimento com metodologia Scrum**

</div>

---

## Sprint atual

Estamos na **Sprint 1**, com foco em estrutura inicial, protótipo, base de dados e primeiros módulos funcionais.

### Status
- ✅ Estrutura do repositório organizada
- ✅ Protótipo inicial da interface
- ✅ Banco de dados e dumps criados
- ✅ Conexão com MySQL configurada
- ✅ Busca de veículos e cálculo de parcelas implementados
- 🔄 Desenvolvimento de páginas, autenticação e integração entre front-end e back-end

---

## Contexto do projeto

O **Virtual Motors** é um e-commerce de veículos, pensado para oferecer uma experiência simples de busca, seleção e compra de carros.

A equipe está trabalhando em um fluxo Scrum com divisão de tarefas por área: front-end, back-end, banco de dados e documentação.

---

## Histórico e branches

Atualmente, o repositório apresenta os seguintes contextos relevantes:

- `main` e `backup-main`: base compartilhada do projeto
- `rayray`: branch ativa de desenvolvimento com entregas recentes
- branches remotas como `origin/mustyd`, `origin/tony7kq`, `origin/yuri-nuvem`: evolução paralela da equipe

A branch `rayray` está com commits recentes voltados para cálculo de parcelas, busca de veículos e continuidade da base funcional.

---

## Entregas atuais

### Back-end
- Conexão com banco de dados em PHP
- Estrutura de dados para veículos
- Cálculo de parcelas por valor do veículo
- Busca e listagem de produtos

### Dados
- Dumps SQL do banco em `dump/virtualmotors/`
- Base inicial para continuidade do desenvolvimento
- Mapa dos dumps SQL, migrations, relações e arquivos que acessam o banco em [`mapa-banco-de-dados.md`](mapa-banco-de-dados.md)

### Front-end
- Estrutura inicial da landing page
- Prototipação visual e identidade do projeto

---

## Próximos passos

- finalizar estrutura da página inicial
- criar login e cadastro de usuários
- implementar listagem e cadastro de veículos
- integrar front-end com back-end
- validar fluxo completo de compra

---

## Tecnologias

- **Front-end:** HTML, CSS, JavaScript
- **Back-end:** PHP
- **Banco de dados:** MySQL / SQL
- **Estrutura:** estilos e scripts em `public/`, imagens em `assets/`, código PHP em `src/` e documentação em `docs/`. O `index.php` permanece na raiz como entrada do servidor PHP.

---

## Equipe

- RayRay — Developer
- MustyD — Developer
- Antônio Rodrigues — Developer
- Yuri_nuvem — Analista
- mamonga-dev — Scrum Master

---

> O projeto segue em evolução e a documentação será ajustada conforme a Sprint avança.

---

## Como executar

1. Instale PHP com as extensões PDO e PDO MySQL, além de MySQL ou MariaDB.
2. Crie o banco `loja_carros` e importe `dump/virtualmotors/loja_carros_carros.sql`.
3. Para bancos já existentes, execute uma vez `database/migrations/20261015_add_car_image_url.sql` para habilitar links de imagem nos produtos.
4. Execute uma vez `database/migrations/20261022_add_purchase_history.sql` para habilitar o registro e a consulta de compras.
5. Para desenvolvimento local, copie `config/database.config.php.example` para `config/database.config.php` (remova `.example`) e preencha os dados locais. O arquivo real é privado e não deve ser versionado.
6. Na raiz do projeto, execute `php -S localhost:8000` e acesse `http://localhost:8000`.

A listagem e a busca da página inicial consultam a tabela `carros`. O banco deve estar ativo para exibir os veículos.

Para configurar o teste isolado de e-mail, consulte [Configuração do teste isolado de e-mail](EMAIL_TEST_SETUP.md).

### Configuração do servidor

Na hospedagem, copie `config/database.config.php.example` para `config/database.config.php` (remova `.example`) e preencha `production` com as credenciais fornecidas pela hospedagem. O código escolhe `local` para `localhost` e `127.0.0.1`, e `production` para os demais hosts. Envie esse arquivo privado uma única vez pelo SFTP; depois, configure-o como exclusão da sincronização para evitar sobrescrevê-lo. O `.gitignore` impede o envio pelo GitHub, mas não controla as exclusões da extensão SFTP.

---

## Licença

Este projeto está sob a licença **MIT**.