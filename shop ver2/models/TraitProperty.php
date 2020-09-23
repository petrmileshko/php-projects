<?php

namespace site\models;

trait TraitProperty {
    
        private $query = [
        //контроллер => массив типов запросов данного контроллера
        'Catalog'=>[
    //  метод => команда запроса
        'index'=>'SELECT * FROM',
        'more'=>'SELECT * FROM',
        'order'=>'SELECT * FROM',
        'complete'=>''
        ],
        'User'=>[
        'index'=>'SELECT * FROM',
        'users'=>'SELECT * FROM'
        ],
        'Main'=>[
        'index'=>'SELECT * FROM',
        'complete'=>'INSERT INTO'
        ]
    ];
    private $tables = [
    //контроллер => массив связанных таблиц с данным контроллером
        'Catalog'=>[
    //  метод => таблица БД
        'index'=>'goods',
        'more'=>'goods',
        'order'=>'orders',
        'complete'=>'orders'
        ],
        'User'=>[
        'index'=>'users',
        'users'=>'users'
        ],
        'Main'=>[
        'index'=>'goods',
        'complete'=>'orders'
        ]
    ];
    
    private $filters = [
    //контроллер => массив условий запросов данного контроллера
        'Catalog'=>[
    //  метод => условия в запросе
        'index'=>'LIMIT 0,6',
        'more'=>'WHERE id=:id',
        'order'=>'',
        'complete'=>''
        ],
        'User'=>[
        'index'=>'WHERE 1',
        'users'=>''
        ],
        'Main'=>[
        'index'=>'LIMIT 0,3',
        'complete'=>'(%s) VALUES(%s)'
        ]
    ];

     
}

?>