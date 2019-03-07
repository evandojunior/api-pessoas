
## API Pessoas

Aplicação desenvolvida para o Teste da vaga de PHP Pleno.

Foram usados no desenvolvimento: 
- PHP versão minima requerida 7.1.3
- [Laravel 5.8](https://laravel.com/)
- [Swagger](https://github.com/DarkaOnLine/L5-Swagger)
- Banco de dados integrado: SQLite

## Instalação

Após realizar o clone do projeto, execute os seguintes comandos:


```bash
$ cd api-pessoas
```
```bash
$ composer install
```

```bash
$ php artisan key:generate
```

Para criar a base de dados execute o comando:

```bash
$ touch database/database.sqlite
```

Para subir a estrutura do banco rode:
```bash
$ php artisan migrate
```

Caso deseje popular a base com dados ficticios execute:
```bash
$ php artisan db:seed
```

Para rodar o projeto execute:
```bash
$ php artisan serve
```

O comando executará o serviço no endereço: http://localhost:8000

E por fim, para executar os testes basta executar:
```bash
$ vendor/bin/phpunit
```
