<?php
return [
    //CRUD
    'track' => 'track/index',
    'track/create' => 'track/create',
    'track/update/<id:\d+>' => 'track/update',
    'track/delete/<id:\d+>' => 'track/delete',
    'track/<id:\d+>' => 'track/view',

    //Track api
    'PUT,PATCH api/tracks/<id>' => 'api/track/update',
    'DELETE api/tracks/<id>' => 'api/track/delete',
    'GET,HEAD api/tracks/<id>' => 'api/track/view',
    'POST api/tracks' => 'api/track/create',
    'GET,HEAD api/tracks' => 'api/track/index',
    'POST api/tracks/batch-status-update' => 'api/track/batch-status-update',

    //JWT авторизация
    'POST api/login' => 'api/auth/login',
];