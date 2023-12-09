## Próximos passos

[X] Aprender a criar tabelas personalizadas na wpdb (Chat GPT respondeu sobre isso)

[X] Implementar um Crud de perguntas e respostas.

[ ] Assistir aquele vídeo sobre otimização de database. Tirar ideias também do Chat GPT.

[ ] Implementar login de usuário

-   A verificação está sendo feita, mas acontecem erros, quando o usuário está errado.

[X] Verificar como resposta vem do WPForms (Vem em JSON normal)

[X] Implementar relatório com 5 perguntas

[X] Terminar de implementar todas perguntas e categorias (CSV e ReportsEndpoints)

[ ] Implementar login front

[X] Implementar listagem de relatórios e pontuações

[X] Adicionar data de criação do relatório no backend e última alteração

[X] Colocar em respostas, mais infos, vou usar apenas o backend para gerar texto (id, categoria, Pergunta, resposta, pontuação, index(A,B,C))

[X] Implementar campo de email em relatórios.

[X] Ícones das sessões

[X] Tabela de todos usuários (pesquisa)

[X] Rotas React

[ ] Página de Login

[ ] Implementar drop table da tabela de questões

## User Stories

1. Eu, como admin, quero ser capaz de acessar as respostas dos usuários em uma lista

2. Eu como admin, quero ser capaz de fazer login na minha conta, criada internamente.

3. Eu como usuário do site, quero ser capaz de preencher o quiz e receber a resposta em meu email.

4. Eu como admin, quero ser informado por e-mail, sempre que um usuário do site responder o meu quiz.

## Classes e Modelos

### Reports

Atributos:

1. Nome
2. Idade
3. Data da Resposta
4. Array Resposta

Funções:

1. Criar
2. Alterar
3. Deletar
4. Listar

.

## Respostas

O formulário envia a resposta com a string inteira.
Então terei que formatar as repostas em: A, B e C, sendo:

A -> Resposta ruim

B -> Resposta neutra

C -> Resposta boa

Problema: Não posso randomizar as respostas.
