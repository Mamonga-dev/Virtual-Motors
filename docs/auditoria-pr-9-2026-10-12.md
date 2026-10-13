# Registro de auditoria — Virtual Motors (PR #9)

**Data:** 12/10/2026  
**PR:** [#9 — vitrine, autenticação e interface](https://github.com/Mamonga-dev/Virtual-Motors/pull/9)  
**Branch revisada:** `rayray` → `main`  
**Commit revisado:** `7660811a941b899d4f5bb2471973033ac90c20f2`  
**Base revisada:** `main` em `56411e9d91431f1de038c4d8adaa5263b670a338`

## Parecer

As mudanças do PR são compatíveis com as tabelas existentes e não incluem alterações de esquema ou gravações de pedidos. O GitHub reporta o PR como mesclável, sem conflito com `main`. A tela nova de pagamento funciona apenas como prévia; ela não envia formulário, registra endereço, cria pedido ou processa pagamento. Isso precisa continuar explícito para não ser confundido com compra implementada.

Foi corrigida nesta revisão a exposição de existência de contas no login: agora credenciais inválidas recebem uma única mensagem genérica. O código revisado está pronto para seguir como interface e refatoração incremental, mas o produto ainda não atende a todos os requisitos funcionais do projeto; os itens abaixo precisam orientar o próximo desenvolvimento.

## Escopo conferido

- As 12 alterações do PR: catálogo, imagens, cabeçalho compartilhado, tema, autenticação, repositório de veículos, conexão PDO, carrinho, tela de prévia de pagamento e backlog.
- Repositórios PHP e pontos de entrada de login, cadastro, pesquisa, carrinho e pagamento.
- Dumps SQL de usuários, carros, pedidos e itens de pedido.
- Requisitos funcionais documentados e backlog versionado.
- Estado de merge e verificações do commit no GitHub.

## Compatibilidade e dados

- Nenhuma tabela ou coluna é alterada pelo PR. A tabela `carros` no dump possui os campos consultados pelo repositório (`id_carro`, `nome`, `cor`, `preco`, `jogo_origem`).
- O carrinho continua guardado na sessão e os totais exibidos usam o preço retornado pelo banco. Não há escrita em `pedido` ou `item_pedido`.
- O checkout exige usuário autenticado, mas os dados de endereço e a opção de pagamento não são enviados nem salvos.
- O catálogo de demonstração é visual. Quando o banco está indisponível, os botões ainda tentam adicionar IDs no carrinho; a operação falha no servidor e não cria um item de demonstração como produto real.
- O esquema atual de `item_pedido` não tem coluna de quantidade nem preço histórico. Antes de persistir pedidos, o time deve decidir como registrar quantidade e preço praticado e atualizar o esquema de forma coordenada.

## Achados e encaminhamentos

1. **Enumeração de contas no login — corrigido nesta revisão.** O PR distinguia “conta inexistente” de “senha incorreta”. O login agora exibe “E-mail ou senha incorretos” em ambos os casos. O serviço não expõe mais o método de consulta de existência usado apenas para essa distinção. O cadastro continua verificando e-mail duplicado.
2. **Compra ainda não finaliza — pendente por escopo.** A tela é uma prévia e não persiste endereço, pedido ou pagamento. Próximo passo: desenhar fluxo e validações de servidor, transação de pedido, associação ao usuário e integração de pagamento antes de anunciar finalização.
3. **API externa obrigatória — pendente.** O botão de CEP informa que a integração virá depois; não há chamada a serviço externo. O requisito funcional pede uma API realmente integrada. Usar consulta de CEP é uma opção natural, mas precisa preencher/validar dados de entrega no fluxo real.
4. **Controle administrativo — pendente.** O cadastro público define perfil `cliente`; o login não guarda o tipo do usuário na sessão e não há área/rotas de administração. Não implementar telas administrativas sem primeiro aplicar autorização no servidor baseada no perfil.
5. **Detalhes, gestão de estoque e histórico de compras — pendentes.** Não foram encontrados fluxo de detalhes do veículo, CRUD de estoque, nem leitura de histórico. Manter essas tarefas no backlog, sem duplicar a busca que já existe no catálogo.
6. **Configuração de banco para deploy — requer definição antes de publicar.** `src/database.php` usa endereço local, usuário `root` e senha vazia. Isso corresponde ao ambiente local descrito, mas não é configuração adequada para hospedagem; separar configuração por ambiente e usar credenciais próprias antes de deploy real.
7. **Identificação de usuário no carrinho — alinhar com requisito.** O backlog diz que adicionar exige login, mas `src/carrinho.php` não valida sessão antes de adicionar. O checkout redireciona usuários sem login. Scrum Master/Analista deve decidir se carrinho anônimo é permitido; depois alinhar backlog e fluxo.

## Verificações executadas

- GitHub marcou `mergeable: true`; nenhuma divergência de merge foi reportada.
- Nenhuma execução de workflow de CI foi encontrada para o commit revisado.
- `node --check script.js`: passou.
- `git diff --check`: passou.
- Não foi possível executar lint ou fluxo integrado PHP/MySQL: PHP não está instalado neste ambiente e não havia serviço MySQL disponível para validar login, cadastro, pesquisa ou carrinho.
- Nenhum teste automatizado foi adicionado.

## Próximas decisões para o Scrum Master

1. Aprovar o escopo da Sprint: começar por administração de produtos e detalhes, ou fechar primeiro a compra com pedido e quantidade persistida.
2. Definir se carrinho aceita visitantes ou exige login desde o primeiro item.
3. Definir o modelo de `item_pedido` (quantidade e preço no momento da compra) e campos necessários para endereço/status/pagamento.
4. Escolher e integrar uma API externa, provavelmente CEP, somente no fluxo real de entrega.
5. Definir perfis e autorização no servidor antes de criar a área administrativa.
6. Preparar variáveis de ambiente e credenciais de deploy, sem reaproveitar `root` sem senha.
