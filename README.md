## Sistema de gerencimento e aluguel de veículos Rent Car

### Introdução

Olá, este é o sistema de gerenciamento de veículos criado por mim. É um sistema baseado no aluguel de veículos, seja ele carro, moto, barcos dentre muitos outros. Fiz este sistema para mostrar um pouco das minhas habilidades com desenvolvimento, portanto, por mais que seja um projeto relativamente simples procurei criar um layout agradável acompanhado de um backend robusto. Logo, o sistema permite o registro de usuários tanto pelo painel web quanto pela API, assim como, a criação de anúncios e a locação de veículos.

### Ferramentas utilizadas

Para conseguir desenvolver o projeto eu utilizei diversar ferramentas para me auxiliar, dentre elas as principais foram:

- PHP 7.4
- Laravel 8
- mysql 8
- Node 16
- Jquery
- laravel mix para compilação dos arquivos
- bootstrap 5 (para estilização do front-end)
- JWT (Para controlar a autenticação da API)

## Como começar

Para inciar o sistema é necessário configurar as tecnologias listadas anteriormente, após a instalção é necessário criar um novo banco de dados com o nome 'rent' e senha 'password'. Após isso basta fazer o download do repositório e rodar os seguintes comandos após o download:

composer install (instala os pacotes do composer)
npm install (instala os pacotes do npm)
php artisan migrate:fresh --seed (cria as tabelas no banco de dados e popula elas com o Seeder)
npm run build (Compila os arquivos css e js)
php artisan serve (Roda o projeto, por padrão na porta 8000)
## Rotas API

Para todas as rotas, em excessão as rotas de registro e geração de token, é necessário colocar nos headers um Authorization do tipo Bearer Token

### Rotas de acesso

#### Registro

POST - localhost:8000/api/auth/register/fromApi

(obrigatório) name
(obrigatório) email
(obrigatório) phone
(obrigatório) password
(obrigatório) password_confirmation

#### Gerar token

POST - localhost:8000/api/auth/login

(obrigatório) email
(obrigatório) password

### Rotas de criação de anúncio

#### Obter todos os anúncios do usuário autenticado

GET - localhost:8000/api/ads

#### Criar Anúncio

POST - localhost:8000/api/ads

(obrigatório) brand_id - numeric
(obrigatório) vehicle_type_id - numeric
              is_avaliable - boolean
(obrigatório) name - string
(obrigatório) year - string
(obrigatório) color - string
(obrigatório) price_per_day - double
              informations - string
(obrigatório) begin_avaliable_date - string format d/m/Y
(obrigatório) end_avaliable_date - string format d/m/Y

#### Editar Anúncio

POST - localhost:8000/api/ads

(obrigatório) _method="PUT"
(obrigatório) id - numeric 
              brand_id - numeric
              vehicle_type_id - numeric
              is_avaliable - boolean
              name - string
              year - string
              color - string
              price_per_day - double
              informations - string
              begin_avaliable_date - string format d/m/Y
              end_avaliable_date - string format d/m/Y

#### Remover Anúncio

DELETE - localhost:8000/api/ads/{id do anúncio}

### Rotas de criação de locação

#### Obter todas as locações do usuário

GET - localhost:8000/api/ads

#### Criar Locação

POST - localhost:8000/api/rents

(obrigatório) ad_id - numeric
(obrigatório) begin_date - string format d/m/Y
(obrigatório) end_date - string format d/m/Y

#### Editar Locação

POST - localhost:8000/api/rents

(obrigatório) _method="PUT"
(obrigatório) id - numeric
              begin_date - string format d/m/Y
              end_date - string format d/m/Y           

#### Remover Locação

DELETE - localhost:8000/api/{id da locação}
