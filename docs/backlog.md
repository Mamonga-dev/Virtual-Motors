# Backlog e auditoria do código — Virtual Motors

Revisado em 2026-10-08 com base nos cartões do quadro da Sprint 1 e nos arquivos do repositório.

> Os status abaixo indicam o que foi encontrado no código. “Implementado” não significa que o fluxo já foi validado em execução com PHP e MySQL.

## Funcionalidades já encontradas

| Funcionalidade | Status no código | Evidência |
|---|---|---|
| Página inicial, catálogo e navbar | Implementado | [index.php](../index.php), [style.css](../style.css) |
| Buscar veículos no banco por nome, cor ou jogo de origem e filtrar por preço máximo | Implementado; refatoração para repositório em teste, falta teste integrado | [script.js](../script.js), [src/pesquisa.php](../src/pesquisa.php), [src/carrorepository.php](../src/carrorepository.php) |
| Exibir nome, cor, origem e preço nos resultados | Implementado | [script.js](../script.js) |
| Login, cadastro de usuário e logout | Implementado no código; refatoração para serviço em teste | [src/login.php](../src/login.php), [src/cadastro.php](../src/cadastro.php), [src/logout.php](../src/logout.php), [src/authservice.php](../src/authservice.php) |
| Sessão de autenticação | Implementado; guarda ID, e-mail e perfil do usuário; o guard administrativo confirma o perfil atual no banco | [src/login.php](../src/login.php), [src/admin_guard.php](../src/admin_guard.php) |
| Painel administrativo e gerenciamento de produtos | Implementados no código: indicadores e listas recentes; cadastro, pesquisa, paginação, edição, exclusão protegida para produtos em pedidos e URL opcional de imagem. As alterações de produto usam CSRF; o catálogo usa a URL salva e mantém imagens padrão quando vazia. Falta validar os fluxos com MySQL ativo | [admin/dashboard.php](../admin/dashboard.php), [admin/produtos.php](../admin/produtos.php), [src/admin_guard.php](../src/admin_guard.php), [database/migrations/20261015_add_car_image_url.sql](../database/migrations/20261015_add_car_image_url.sql) |
| Carrinho de sessão | Implementado no código; adicionar exige login, permite atualizar/remover itens e calcula total com preços atuais do banco; integração em teste | [src/carrinho.php](../src/carrinho.php), [script.js](../script.js), [index.php](../index.php) |
| Conexão PHP/MySQL com PDO | Implementado | [src/conexao.php](../src/conexao.php) |
| Estrutura de tabelas para carros, usuários, pedidos e itens de pedido | Existe nos dumps SQL | [dump/virtualmotors/loja_carros_carros.sql](../dump/virtualmotors/loja_carros_carros.sql), [dump/virtualmotors/loja_carros_usuario.sql](../dump/virtualmotors/loja_carros_usuario.sql), [dump/virtualmotors/loja_carros_pedido.sql](../dump/virtualmotors/loja_carros_pedido.sql), [dump/virtualmotors/loja_carros_item_pedido.sql](../dump/virtualmotors/loja_carros_item_pedido.sql) |
| Cálculo simples do valor de uma parcela | Implementado como endpoint isolado; não é total de carrinho | [src/calcula.php](../src/calcula.php) |

## Refatoração para orientação a objetos — em teste

A refatoração reorganiza o acesso ao banco no login, cadastro e pesquisa de veículos. A página inicial segue o layout da implementação de teste, mas conserva a pesquisa e o catálogo do banco atual; o carrinho usa somente a sessão e consulta os preços atuais. A sintaxe PHP foi verificada; ainda falta validar os fluxos com o banco ativo. As demais funcionalidades continuarão sendo implementadas gradualmente conforme as pendências abaixo.

| Arquivo | Responsabilidade |
|---|---|
| [index.php](../index.php) | Exibe a página inicial, o estado da sessão e o catálogo carregado pelo JavaScript. |
| [script.js](../script.js) | Envia filtros para `pesquisa.php` e renderiza os veículos e mensagens de status. |
| [src/login.php](../src/login.php) | Valida credenciais via `AuthService` e mantém os dados do usuário na sessão. |
| [src/cadastro.php](../src/cadastro.php) | Valida os dados recebidos e registra o usuário via `AuthService`. |
| [src/pesquisa.php](../src/pesquisa.php) | Valida o filtro de preço e retorna resultados JSON obtidos pelo repositório. |
| [src/carrinho.php](../src/carrinho.php) | Adiciona, lista, atualiza e remove itens do carrinho na sessão; consulta os dados e preços dos carros existentes. |
| [src/carrorepository.php](../src/carrorepository.php) | Consulta carros por nome, cor, jogo de origem, preço máximo e IDs com prepared statements. |
| [src/authservice.php](../src/authservice.php) | Valida credenciais e registra usuários através do repositório de usuários. |
| [src/userrepository.php](../src/userrepository.php) | Busca, verifica e cria usuários no banco. |
| [src/database.php](../src/database.php) | Fornece a conexão PDO compartilhada com o banco de dados. |

## Pendências priorizadas

| Prioridade | Tarefa | Situação encontrada / próximo passo |
|---|---|---|
| Alta | Testar a refatoração orientada a objetos | Em teste. Validar login, cadastro e pesquisa com PHP e MySQL ativos, incluindo e-mail existente, credenciais incorretas, filtros e erros de banco. |
| Alta | Criar página de detalhes do veículo | Não há página nem consulta por `id_carro`. Criar a rota de detalhes e ligar os cartões do catálogo a ela. |
| Alta | Testar gerenciamento administrativo de produtos | CRUD administrativo implementado usando as colunas atuais de `carros`; testar criação, edição, pesquisa, paginação, CSRF e exclusão de itens com e sem referência em pedidos com MySQL ativo. |
| Média | Administrar usuários e pedidos | O painel exibe dados recentes sem expor hashes de senha; telas e operações para gerenciar usuários e pedidos ainda não foram implementadas. |
| Alta | Testar o carrinho de sessão | Implementado no código; testar adicionar com e sem login, atualizar/remover itens, sessão vazia e banco indisponível. O carrinho usa uma chave de sessão própria e não altera tabelas. |
| Alta | Alterar quantidade dos itens | Implementado apenas na sessão. A tabela `item_pedido` contém apenas `id_pedido` e `id_carro`; definir/aplicar quantidade antes de persistir pedidos. |
| Alta | Integrar carrinho e pedidos ao banco | Pendente. As tabelas `pedido` e `item_pedido` existem nos dumps, mas ainda não há gravação PHP de pedidos. Implementar transação e associação ao usuário autenticado. |
| Média | Finalizar compra | A tela de entrega e pagamento está disponível em `src/pagamento.php`, integrada ao carrinho. O CEP é apenas visual e ainda não consulta serviços externos; pedidos e pagamentos continuam sem integração. |
| Alta | Integrar carrinho e pedidos ao banco | As tabelas `pedido` e `item_pedido` existem nos dumps, mas não há consultas PHP para elas. Implementar gravação transacional e associação ao usuário autenticado. |
| Média | Testar integração completa | Pendente. Após testar a refatoração, validar catálogo, filtros, cadastro, login/logout, detalhes, carrinho e gravação de pedido com PHP e MySQL ativos. |
| Baixa | Reutilizar estilos nas telas de autenticação | Parcial. A página inicial usa classes compartilhadas em `style.css`, mas login e cadastro repetem estilos em blocos `<style>` próprios. |

## Cartões duplicados ou parcialmente cobertos

- “Implementar busca de produtos” no grupo Carrinho duplica a busca já implementada no catálogo. Não criar uma segunda busca; encerrar ou substituir esse cartão pelo fluxo de adicionar ao carrinho.
- “Criar acesso aos detalhes” no Catálogo e “Criar página de detalhes” em Detalhes do Produto descrevem o mesmo resultado. Consolidar em uma tarefa: criar a página e ligar os cartões a ela.
- “Criar consultas necessárias para os produtos” está parcialmente atendido pela consulta de listagem/busca em `src/pesquisa.php`; o CRUD administrativo da tabela `carros` foi implementado em `admin/produtos.php`. Ainda falta consulta pública de detalhes.
- “Criar estrutura inicial utilizando sessão” está implementado para autenticação e para manter itens do carrinho; o carrinho ainda não é persistido entre sessões nem integrado a pedidos.
- O total mostrado no carrinho é calculado usando os preços consultados no banco. `src/calcula.php` continua calculando somente o valor de parcelas simples, sem criar pedidos.

## Critério para concluir

- Validar cada fluxo com PHP e MySQL em execução, além de conferir entradas inválidas e erros de banco.
- Confirmar que preços e totais do pedido são calculados no servidor a partir dos dados do banco.
- Atualizar este backlog quando uma tarefa for implementada e testada; não marcar como concluída apenas por existir uma tabela ou endpoint isolado.
