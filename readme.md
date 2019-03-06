## API Pessoas

Aplicação desenvolvida para o Teste da vaga de PHP Pleno.

## Instalação

Após realizar o clone do projeto, execute os seguintes comandos:

$ cd api-pessoas

$ composer install

$ php artisan key:generate

Para criar a base de dados execute o comando:

$ touch database/database.sqlite

Para realizar subir a estrutura do banco rode:

$ php artisan migrate

Caso deseje popular a base com dados ficticios execute:

$ php artisan db:seed

Para rodar o projeto execute:

$ php artisan serve

O comando executará o serviço no endereço: http://localhost:8000

E por fim, para executar os testes basta executar:

$ vendor/bin/phpunit
