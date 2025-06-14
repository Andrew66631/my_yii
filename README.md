<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Тестовый проект Yii2</h1>
    <br>
</p>


Развертывание
-------------------
КЛОНИРОВАТЬ РЕПОЗИТОРИЙ
------------


### Установка

1

    docker-compose build

2

    composer install   


3

    docker-compose up -d

4

    docker-compose run --rm php composer update --prefer-dist


    
Открыть проект по адресу

    http://127.0.0.1:8080




Тестовое задание - git ветка track
------------

выполнить миграции внутри контейнера php

    php yii migrate

выполнить 

    composer install


На домашней странице функционал регистрации пользователей и посылок
------------
Разработан crud интерфейс
------------
API
------------
JWT авторизация
------------

# Route Documentation

## CRUD интерфейс 

| Method | Endpoint                | Описание               |
|--------|-------------------------|------------------------|
| GET    | /track                | Просмотр всех посылок  |
| POST   | /track/create         | Создание новой посылки |
| GET    | /track/<id>           | Просмотр посылки       |
| PUT    | /track/update/<id>    | Обновение посылки      |
| DELETE | /track/delete/<id>    | Удаление посылки       |

## API 

| Method      | Endpoint                              | Описание                            |
|-------------|---------------------------------------|-------------------------------------|
| GET, HEAD   | /api/tracks                         | Просмотр всех посылок               |
| POST        | /api/tracks                         | Создание новой посылки              |
| GET, HEAD   | /api/tracks/<id>                   | Просмотр посылки                    |
| PUT, PATCH  | /api/tracks/<id>                   | Обновение посылки                   |
| DELETE      | /api/tracks/<id>                   | Удаление посылки                    |
| POST        | /api/tracks/batch-status-update     | Массовое обновление статуса посылок |

## JWT авторизация

| Method | Endpoint        | Описание                                                 |
|--------|-----------------|----------------------------------------------------------|
| POST   | /api/login    | Для получения токена, в теле запроса {username,password} |




