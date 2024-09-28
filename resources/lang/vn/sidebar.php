<?php   
return [
    'module' => [
        [
            'title' => 'Dashboard',
            'icon' => 'fa fa-database',
            'name' => ['dashboard'],
            'route' => 'dashboard/index',
            'class' => 'special'
        ],
        [
            'title' => 'QL Homestay',
            'icon' => 'fa fa-home',
            'name' => ['homestay'],
            'subModule' => [
                [
                    'title' => 'QL Homestay',
                    'route' => 'homestay/index'
                ],
            ]
        ],
        [
            'title' => 'QL Màu',
            'icon' => 'fa fa-github',
            'name' => ['color'],
            'subModule' => [
                [
                    'title' => 'QL Màu',
                    'route' => 'color/index'
                ],
            ]
        ],
        [
            'title' => 'QL Thành phố',
            'icon' => 'fa fa-github',
            'name' => ['city'],
            'subModule' => [
                [
                    'title' => 'QL Thành phố',
                    'route' => 'city/index'
                ],
            ]
        ],
        [
            'title' => 'QL Bài viết',
            'icon' => 'fa fa-file',
            'name' => ['post'],
            'subModule' => [
                [
                    'title' => 'QL Nhóm Bài Viết',
                    'route' => 'post/catalogue/index'
                ],
                [
                    'title' => 'QL Bài Viết',
                    'route' => 'post/index'
                ]
            ]
        ],
        [
            'title' => 'QL Nhóm Thành Viên',
            'icon' => 'fa fa-user',
            'name' => ['user','permission'],
            'subModule' => [
                [
                    'title' => 'QL Nhóm Thành Viên',
                    'route' => 'user/catalogue/index'
                ],
                [
                    'title' => 'QL Thành Viên',
                    'route' => 'user/index'
                ],
                [
                    'title' => 'QL Quyền',
                    'route' => 'permission/index'
                ]
            ]
        ],
        [
            'title' => 'QL Banner & Slide',
            'icon' => 'fa fa-picture-o',
            'name' => ['slide'],
            'subModule' => [
                [
                    'title' => 'Cài đặt Slide',
                    'route' => 'slide/index'
                ],
            ]
        ],
        [
            'title' => 'QL Menu',
            'icon' => 'fa fa-bars',
            'name' => ['menu'],
            'subModule' => [
                [
                    'title' => 'Cài đặt Menu',
                    'route' => 'menu/index'
                ],
            ]
        ],
        [
            'title' => 'Cấu hình chung',
            'icon' => 'fa fa-file',
            'name' => ['language', 'system', 'widget'],
            'subModule' => [
                [
                    'title' => 'QL Ngôn ngữ',
                    'route' => 'language/index'
                ],
                [
                    'title' => 'Cấu hình hệ thống',
                    'route' => 'system/index'
                ],
                [
                    'title' => 'Quản lý Widget',
                    'route' => 'widget/index'
                ],
                
            ]
        ]
    ],
];
