<?php
    $shem   = [
        'first_table'  => [
            'id'    => [
                'type'          => 'int',
                'length'        => 10,
                'nullable'      => false,
                'autoincrement' => true,
                'primary'       => true,
            ],
            'color' => [
                'type'     => 'varchar',
                'length'   => 50,
                'default'  => '#FFFFFF',
                'nullable' => true,
            ],
            'test'  => [
                'type'     => 'varchar',
                'length'   => 50,
                'default'  => '#FFFFFF',
                'nullable' => true,
            ],

        ],
        'second_table' => [
            'id'    => [
                'type'          => 'int',
                'length'        => 50,
                'default'       => null,
                'nullable'      => false,
                'autoincrement' => true,
                'primary'       => true,
            ],
            'color' => [
                'type'     => 'varchar',
                'length'   => 50,
                'default'  => '#FFFFFF',
                'nullable' => false,
            ],
            'test'  => [
                'type'     => 'varchar',
                'length'   => 50,
                'nullable' => false,
            ],
            'test2' => [
                'type'     => 'varchar',
                'length'   => 50,
                'nullable' => false,
            ],
            'test3' => [
                'type'     => 'varchar',
                'length'   => 50,
                'nullable' => false,
            ],
        ],
    ];
    $values = [
        'second_table' => [
            [
                'test' => 'second test data ',
                'test2' => 'second test2 data ',
                'test3' => 'second test3 data ',
            ],
            [
                'test' => 'second test data 123',
                'test2' => 'second test2 data 123',
                'test3' => 'second test3 data 123',
            ],
            [
                'test' => 'second test data 321',
                'test2' => 'second test2 data 321',
                'test3' => 'second test3 data 321',
            ],
        ],
        'first_table' => [
            [
                'test' => 'first_table_data ',
            ],
            [
                'test' => 'first_table_data 123',
            ],
            [
                'test' => 'first_table_data 321',
            ],
        ],
    ];
    return [$shem,$values];