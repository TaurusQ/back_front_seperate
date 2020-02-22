<?php

return [
    [
        'name' => '管理员后台首页',
        'guard_name' => 'admin',
        'pid' => null,
        'type' => 1,
        //'route_name' => 'api.admin.index',
        'child' => []
    ],

    [
        'name' => '管理员后台权限',
        'guard_name' => 'admin',
        'pid' => null,
        'type' => 1,
        'child' => [

            [
                'name' => '管理员账号管理',
                'type' => 1,
                'child' => [
                    [
                        'name' => '管理员账号列表数据',
                        'route_name' => 'api.admin.admins.list',
                        'type' => 2,
                    ]
                ]
            ],

            [
                'name' => '管理员权限管理',
                'type' => 1,
                'child' => [
                    [
                        'name' => '管理员账号列表数据',
                        'route_name' => 'api.admin.permissions.list',
                        'type' => 2,
                    ]
                ]
            ]

        ]
    ]
];
