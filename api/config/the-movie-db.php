<?php

return [

    'token' => env('THE_MOVIE_DB_TOKEN', null),

    'base-path' => env('THE_MOVIE_DB_URL', null),

    'default-params' => [
        'include_adult' => false,
        'language' => 'pt-BR',
        'page' => 1,
        'sort_by' => 'popularity.desc'
    ],
];
