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
- Dumps SQL do banco em `dumps/Virtual motors/`
- Base inicial para continuidade do desenvolvimento

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
- **Estrutura:** organização em `public/`, `src/`, `assets/` e `docs/`

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
2. Crie o banco `loja_carros` e importe `dumps/Virtual motors/loja_carros_carros.sql`.
3. Ajuste servidor, usuário e senha em `src/conexao.php` para o ambiente local.
4. Na raiz do projeto, execute `php -S localhost:8000` e acesse `http://localhost:8000`.

A listagem e a busca da página inicial consultam a tabela `carros`. O banco deve estar ativo para exibir os veículos.

---

## Licença

Este projeto está sob a licença **MIT**.