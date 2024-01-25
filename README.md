1.0.2
### Passo a passo
Clone Repositório 
```sh
git clone https://github.com/fabiorcamargo/laravel-dash.git app
```

```sh
cd app
```



Alterne para a branch desejada
```sh
git checkout "nome da branch"
```


Remova o versionamento
```sh
rm -rf .git/
```


Crie o Arquivo .env
```sh
cd example-project/
cp .env.example .env
```


Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME=Profissionaliza
APP_URL=http://localhost:8991

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acessar o container
```sh
docker-compose exec app bash
```


Instalar as dependências do projeto
```sh
composer install
```


Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Observações:

Pode ser necessário mudar o Grupo de Usuário e permissões do bootstrap/cache;
"chgrp -R www-data storage bootstrap/cache"
"chmod -R ug+rwx storage bootstrap/cache"

Se o sitema não tiver o supervisor precisa instalar e carregar o laravel-worker.conf para processar as filas.





Acesse o projeto
[http://localhost:8991](http://localhost:8991)
