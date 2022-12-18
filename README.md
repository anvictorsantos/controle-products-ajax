# laravel 6.20.44

## Sobre o projeto
O projeto controle de artigos é um projeto desenvolvido em Laravel 6.20.44 e AJAX. O projeto tem como objetivo ser uma aplicação para a criação, visualização, atualização e deleção de produtos.

Além disso, o objetivo desse projeto é servir como base de estudos sobre o framework laravel e suas respectivas mudanças ao longo das versões.

## Build setup
```bash
# instalar as dependências do composer
$ composer install

# criar arquivo de environment
$ cp .env.example .env

# gerar a chave única da aplicação
$ php artisan key:generate

# criar as tabelas e popular com dados falsos
$ php artisan migrate:refresh --seed

# inicializar a aplicação
$ php artisan serve
```

## Sqlite
Este projeto utiliza o SQLite para armazenamento, logo, as variáveis de ambiente foram alteradas com esse intuito. Se você quiser usar o mesmo banco relacional, digitar o seguinte comando:
```bash
# criar o arquivo de database
$ touch database/database.sqlite

# substituir variávesi de conexão com o banco
$ DB_CONNECTION=sqlite
```

## PHP versão
Eu utilizei a versão 7.4.30 do PHP