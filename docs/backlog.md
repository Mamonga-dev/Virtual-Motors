# Backlog e auditoria do código — Virtual Motors

Revisado em 2026-10-02 com base nos cartões do quadro da Sprint 1 e nos arquivos do repositório.

> Os status abaixo indicam o que foi encontrado no código. “Implementado” não significa que o fluxo já foi validado em execução com PHP e MySQL.

## Funcionalidades já encontradas

| Funcionalidade | Status no código | Evidência |
|---|---|---|
| Página inicial, catálogo e navbar | Implementado | [index.php](../index.php), [style.css](../style.css) |
| Buscar veículos no banco por nome, cor ou jogo de origem e filtrar por preço máximo | Implementado; falta teste integrado | [script.js](../script.js), [src/pesquisa.php](../src/pesquisa.php) |
| Exibir nome, cor, origem e preço nos resultados | Implementado | [script.js](../script.js) |
| Login, cadastro de usuário e logout | Implementado no código | [src/login.php](../src/login.php), [src/cadastro.php](../src/cadastro.php), [src/logout.php](../src/logout.php) |
| Sessão de autenticação | Implementado; guarda ID e e-mail do usuário | [src/login.php](../src/login.php), [index.php](../index.php) |
| Conexão PHP/MySQL com PDO | Implementado | [src/conexao.php](../src/conexao.php) |
| Estrutura de tabelas para carros, usuários, pedidos e itens de pedido | Existe nos dumps SQL | [dumps/Virtual motors/loja_carros_carros.sql](../dumps/Virtual%20motors/loja_carros_carros.sql), [dumps/Virtual motors/loja_carros_usuario.sql](../dumps/Virtual%20motors/loja_carros_usuario.sql), [dumps/Virtual motors/loja_carros_pedido.sql](../dumps/Virtual%20motors/loja_carros_pedido.sql), [dumps/Virtual motors/loja_carros_item_pedido.sql](../dumps/Virtual%20motors/loja_carros_item_pedido.sql) |
| Cálculo simples do valor de uma parcela | Implementado como endpoint isolado; não é total de carrinho | [src/calcula.php](../src/calcula.php) |

## Pendências priorizadas

| Prioridade | Tarefa | Situação encontrada / próximo passo |
|---|---|---|
| Alta | Criar página de detalhes do veículo | Não há página nem consulta por `id_carro`. Criar a rota de detalhes e ligar os cartões do catálogo a ela. |
| Alta | Cadastrar e gerenciar veículos | Não foram encontradas operações PHP de inclusão, edição ou remoção na tabela `carros`, nem formulário de cadastro. Definir também quem terá permissão para gerenciar o estoque. |
| Alta | Implementar carrinho com sessão | A sessão atual é de autenticação; não existe coleção de itens do carrinho em `$_SESSION`. Definir se o carrinho será mantido na sessão ou persistido no banco. |
| Alta | Adicionar e remover produtos do carrinho | Não há ações ou endpoints de carrinho. Ligar essas ações aos itens do catálogo e validar os IDs no servidor. |
| Alta | Alterar quantidade dos itens | Não implementado. A tabela `item_pedido` contém apenas `id_pedido` e `id_carro`; definir e aplicar a estrutura de quantidade antes de persistir os itens. |
| Alta | Calcular subtotal e total do carrinho | Não implementado. Calcular no servidor usando os preços do banco; `src/calcula.php` calcula somente preço dividido pelo número de parcelas. |
| Alta | Integrar carrinho e pedidos ao banco | As tabelas `pedido` e `item_pedido` existem nos dumps, mas não há consultas PHP para elas. Implementar gravação transacional e associação ao usuário autenticado. |
| Média | Testar integração completa | Pendente. Testar catálogo, filtros, cadastro, login/logout, detalhes, carrinho e gravação de pedido com PHP e MySQL ativos. |
| Baixa | Reutilizar estilos nas telas de autenticação | Parcial. A página inicial usa classes compartilhadas em `style.css`, mas login e cadastro repetem estilos em blocos `<style>` próprios. |

## Cartões duplicados ou parcialmente cobertos

- “Implementar busca de produtos” no grupo Carrinho duplica a busca já implementada no catálogo. Não criar uma segunda busca; encerrar ou substituir esse cartão pelo fluxo de adicionar ao carrinho.
- “Criar acesso aos detalhes” no Catálogo e “Criar página de detalhes” em Detalhes do Produto descrevem o mesmo resultado. Consolidar em uma tarefa: criar a página e ligar os cartões a ela.
- “Criar consultas necessárias para os produtos” está parcialmente atendido pela consulta de listagem/busca em `src/pesquisa.php`. Ainda faltam consulta de detalhe e operações de cadastro/edição/exclusão.
- “Criar estrutura inicial utilizando sessão” está atendido apenas para autenticação. Não deve ser marcado como carrinho concluído: nenhum produto é armazenado na sessão.
- “Calcular subtotal” e “Calcular total” não são cobertos por `src/calcula.php`; esse arquivo calcula o valor de uma parcela simples, sem carrinho ou pedido.

## Critério para concluir

- Validar cada fluxo com PHP e MySQL em execução, além de conferir entradas inválidas e erros de banco.
- Confirmar que preços e totais do pedido são calculados no servidor a partir dos dados do banco.
- Atualizar este backlog quando uma tarefa for implementada e testada; não marcar como concluída apenas por existir uma tabela ou endpoint isolado.
