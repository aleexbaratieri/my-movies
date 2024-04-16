# Configurar Ambiente

Clonando o repositório

```sh
git clone git@github.com:aleexbaratieri/my-movies.git
```

Instando Containers

```sh
docker-compose up -d
```

Instalação de dependências e configuração da API

```sh
cp api/.env.example api/.env
```

Ajuste as variáveis de ambiente em `api/.env`

```
DB_DATABASE=favorite_movies
DB_USERNAME=username
DB_PASSWORD=secret
```

Instando dependências

```sh
docker-compose exec api composer install
docker-compose exec api php artisan key:generate
docker-compose exec api php artisan jwt:secret
docker-compose exec api php artisan migrate
```

Instalando dependencias do app

```sh
touch app/.env
```

Adicione as variaveis de ambiente em `app/.env`

```
VITE_API_URL=http://localhost:8000
```

```sh
docker-compose exec app yarn install
```

Hosts

API: [http://localhost:8000](http://localhost:8000)
APP: [http://localhost](http://localhost)