📝 WorkPlan4y

O projeto WorkPlan4y é uma aplicação web para gerenciamento de tarefas, com CRUD de usuários, projetos e tarefas. Ele conta com um sistema de autenticação de usuários e permite que somente usuários autenticados possam acessar os módulos de projetos e tarefas e a maioria das rotas de usuários via accessToken. A aplicação oferece a funcionalidade de atribuição de tarefas a diferentes usuários, notificação por e-mail a cada atualização de tarefa e exportação de relatórios em formatos Excel e PDF, com filtros por status, data de validade e data de criação.

==============================================================================

🧪 Tecnologias

Este projeto foi desenvolvido utilizando as seguintes tecnologias:
Laravel 11: O framework PHP escolhido por sua robustez, simplicidade e eficiência para construir aplicações web completas.
SQL Server: Utilizado como banco de dados relacional para armazenar os usuários, projetos e tarefas.
Laravel Breeze: Kit starter simples e minimalista para autenticação de usuários.
Eloquent ORM: Ferramenta ORM utilizada no Laravel para interagir de forma simples e intuitiva com o banco de dados.
Laravel Queues: Utilizado para o envio de e-mails em fila para otimizar o processamento de notificações de tarefas.
HTML & CSS: Utilizados para a criação do template de envio de email.

==============================================================================

🚀 Funcionalidades

Autenticação de Usuários: Registro, login e gerenciamento de sessão com Laravel Breeze.
CRUD de Usuários, Projetos e Tarefas: Gerencie usuários, crie projetos e atribua tarefas a diferentes membros.
Relacionamento entre Tarefas e Projetos: Cada tarefa está vinculada a um projeto específico e a um usuário responsável. Cada projeto e usuário pode possuir diversas tarefas.
Prazo de Entrega: Tarefas e projetos têm prazos de entrega definidos.
Notificações por E-mail: O usuário responsável recebe um e-mail toda vez que uma tarefa é atualizada. Os e-mails são enviados por meio de uma fila, sendo processados a cada 1 minuto.
Exportação de Relatórios: Relatórios podem ser exportados em formato Excel e PDF, com filtros por status, data de validade e data de criação.

==============================================================================

🏗️ Infraestrutura

Banco de Dados: SQL Server para armazenar usuários, projetos e tarefas.
Filas de E-mail: Laravel Queues para envio de e-mails em segundo plano.

==============================================================================

🛠️ Passo a Passo para Executar o Projeto

Pré-requisitos
Certifique-se de ter os seguintes softwares instalados na sua máquina:

PHP 8.2
Composer
SQL Server
Node.js e NPM

Clone o repositório:
`git clone https://github.com/leandrosillos/workplan4y.git`
`cd workplan4y`

Instale as dependências do PHP:
`composer install`

Instale as dependências do Node:
`npm install`

Renomeie o arquivo .env.example para .env:
`cp .env.example .env`

Atualize o arquivo .env com as credenciais do seu banco de dados SQL Server:

DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

Gere a chave da aplicação:
`php artisan key:generate`

Rode as migrações e seeders:
Para criar as tabelas no banco de dados e popular com dados iniciais:
`php artisan migrate --seed`

Inicie o servidor de desenvolvimento:
`php artisan serve`
O projeto estará acessível em http://localhost:8000.

Para processar as filas de e-mails, execute o seguinte comando:
`php artisan queue:work`

Isso garantirá que as notificações de atualização de tarefas sejam enviadas aos usuários.

==============================================================================

📄 Perguntas e Respostas

1. Diferença entre Eloquent ORM e Query Builder no Laravel
Eloquent ORM é uma implementação do Active Record em que cada modelo mapeia diretamente uma tabela do banco de dados, e cada instância do modelo representa uma linha nessa tabela. Ele oferece um nível mais alto de abstração e permite trabalhar com as relações entre tabelas de maneira natural através de métodos orientados a objetos.

Query Builder é mais próximo do SQL puro e oferece uma maneira mais manual de construir consultas ao banco de dados. Ele não requer a criação de um modelo e é útil para consultas mais complexas ou de alta performance, quando a simplicidade do Eloquent não é suficiente.

Prós e Contras:

Eloquent ORM:
Prós: Simplicidade ao manipular dados, fácil integração com as relações entre modelos, sintaxe orientada a objetos.
Contras: Pode ser menos eficiente em consultas complexas, pois gera mais sobrecarga de memória.
Query Builder:
Prós: Maior controle sobre as consultas, melhor performance em casos complexos.
Contras: Menos intuitivo para manipular relações entre tabelas, mais verboso.


2. Como garantir a segurança de uma aplicação Laravel?
Validação de Entrada: Sempre validar dados de entrada, especialmente os enviados por formulários. Use os recursos nativos de validação do Laravel (Request ou Validator) para garantir que apenas dados permitidos sejam aceitos.

Proteção contra SQL Injection: O Eloquent e o Query Builder do Laravel automaticamente protegem contra SQL Injection usando bindings. Isso significa que os parâmetros são escapados corretamente.

Criptografia de Dados Sensíveis: Senhas e outros dados sensíveis devem ser sempre criptografados. O Laravel usa bcrypt para senhas, mas outras informações também podem ser criptografadas utilizando Hash ou Crypt.


3. Papel dos Middlewares no Laravel
Os Middlewares no Laravel são responsáveis por filtrar as requisições HTTP que entram na aplicação. Eles fazem parte do pipeline de requisições e podem modificar ou interromper a requisição antes que ela atinja o controlador. Um exemplo comum é a autenticação de usuários.


4. Gerenciamento de Migrations no Laravel
Migrations no Laravel são uma maneira de versionar e controlar a estrutura do banco de dados. Eles permitem que você crie, modifique e remova tabelas e colunas de forma organizada.

Boas práticas:

Sempre mantenha as migrations em controle de versão (Git).
Faça rollback e teste suas migrations em ambiente de desenvolvimento antes de rodá-las em produção.
Use migrations para criar a estrutura básica de tabelas e seeders para popular dados iniciais.


5. Diferença entre Transações e Savepoints no SQL Server
Transações: São blocos de operações que podem ser confirmados (committed) ou revertidos (rollback) de uma vez. Se qualquer operação dentro de uma transação falhar, todas as operações podem ser revertidas.

Savepoints: Permitem criar "pontos de salvamento" dentro de uma transação. Você pode reverter até o savepoint sem desfazer toda a transação.

Exemplo em Laravel:

php
Copiar código
DB::transaction(function () {
    // Executa uma série de operações
    User::create([...]);
    Project::create([...]);
    
    // Se qualquer erro acontecer, o rollback será executado automaticamente.
});

==============================================================================

📱 Contato
Linkedin: https://www.linkedin.com/in/leandro-sillos/
E-mail: sillosadm@gmail.com