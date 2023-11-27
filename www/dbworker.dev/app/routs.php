<?php

    return [
        'GET'    => [
            '/'          => 'app\c\TablesController::index',
            '/migration' => 'app\c\TablesController::migration',
        ],
        'POST'   => [
            '/all'    => 'app\c\TablesController::all',
            '/get'    => 'app\c\TablesController::get',
            '/update' => 'app\c\TablesController::update',
            '/insert' => 'app\c\TablesController::insert',
            '/delete' => 'app\c\TablesController::delete',
        ],
        'PATCH'  => [
        ],
        'DELETE' => [
        ],
        '_ERROR' => [
            '_error' => "app\\c\\ErrorController::notFound",
        ],


    ];