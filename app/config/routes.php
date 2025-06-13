<?php
return [
    //CRUD
    'track' => 'track/index',
    'track/create' => 'track/create',
    'track/update/<id:\d+>' => 'track/update',
    'track/delete/<id:\d+>' => 'track/delete',
    'track/<id:\d+>' => 'track/view',
];