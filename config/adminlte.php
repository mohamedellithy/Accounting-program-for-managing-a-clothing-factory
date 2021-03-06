<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

     'title' => 'الحسابات',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => '<b>ادارة المصنع</b>',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'AdminLTE',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#661-authentication-views-classes
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#662-admin-panel-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    'password_reset_url' => 'password/reset',

    'password_email_url' => 'password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

   'menu' => [
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
       /* [
            'text'        => 'الرئيسية',
            'url'         => 'main',
            'icon'        => 'fas fa-tachometer-alt',
        ],*/
        [
            'text'        => 'تجار القماش',
            'url'         => 'merchants',
            'icon'        => 'fas fa-users',
            'submenu' => [
                            [
                                'text' => 'اضافة تجار',
                                'url'  => 'merchants/create',
                                'icon' => 'fas fa-user-plus text-danger',

                            ],
                            [
                                'text' => 'عرض التجار',
                                'url'  => 'merchants',
                                'icon' => 'fas fa-users text-success',

                            ],
            ]
        ],
         [
            'text'        => 'الاصناف',
            'url'         => 'show-categories',
            'icon'        => 'fas fa-tags',
            'submenu' => [
                            [
                                'text' => 'اضافة صنف',
                                'url'  => 'categories/create',
                                'icon' => 'fas fa-tags text-danger',

                            ],
                            [
                                'text' => 'عرض الاصناف',
                                'url'  => 'categories',
                                'icon' => 'fas fa-tags text-success',

                            ],
            ]
        ],
        [
            'text'        => 'فواتير القماش',
            'icon'        => 'fas fa-tasks',
            'url'         => '#',
            'submenu' => [
                            [
                                'text' => 'اضافة فواتير القماش',
                                'url'  => 'orders-clothes/create',
                                'icon' => 'fas fa-plus-square text-danger',

                            ],
                            [
                                'text' => 'عرض فواتير القماش',
                                'url'  => 'orders-clothes',
                                'icon' => 'fas fa-tasks text-success',

                            ],
            ]
        ],
        [
            'text'        => 'الزبائن / العملاء',
            'icon'        => 'fas fa-user-friends',
            'submenu' => [
                            [
                                'text' => 'اضافة عميل',
                                'url'  => 'clients/create',
                                'icon' => 'fas fa-user-plus text-danger',

                            ],
                            [
                                'text' => 'عرض العملاء',
                                'url'  => 'clients',
                                'icon' => 'fas fa-user-friends text-success',

                            ],
            ]

        ],
        [
            'text'        => 'قصات القماش',
            'icon'        => 'fas fa-tasks',
            'submenu' => [
                            [
                                'text' => 'اضافة قصات',
                                'url'  => 'piecies/create',
                                'icon' => 'fas fa-plus-square text-danger',
                            ],
                            [
                                'text' => 'عرض القصات',
                                'url'  => 'piecies',
                                'icon' => 'fas fa-tasks text-success',
                            ],
            ]
        ],
         [
            'text'        => 'المنتجات',
            'icon'        => 'fas fa-boxes',
            'submenu' => [
                            [
                                'text' => 'اضافة منتج',
                                'url'  => 'products/create',
                                 'icon' => 'fas fa-plus-square text-danger',
                            ],
                            [
                                'text' => 'عرض المنتجات',
                                'url'  => 'products',
                                'icon' => 'fas fa-boxes text-success',
                            ],
            ]
        ],
        [
            'text'        => 'المبيعات',
            'icon'        => 'fas fa-dolly-flatbed',
            'submenu' => [
                            [
                                'text' => 'اضافة طلب',
                                'url'  => 'orders/create',
                                 'icon' => 'fas fa-plus-square text-danger',
                            ],
                            [
                                'text' => 'عرض المبيعات',
                                'url'  => 'orders',
                                'icon' => 'fas fa-dolly-flatbed text-success',
                            ],
            ]
        ],

        [
            'text'        => 'المرتجع',
            'icon'        => 'fas fa-boxes',
            'submenu' => [
                            [
                                'text' => 'اضافة مرتجع',
                                'url'  => 'reactionists/create',
                                'icon' => 'fas fa-plus-square text-danger',
                            ],
                            [
                                'text' => 'عرض المرتجع',
                                'url'  => 'reactionists',
                                'icon' => 'fas fa-boxes text-success',
                            ],
            ]
        ],
           [
            'text'        => 'المصانع',
            'url'         => 'show-suppliers',
            'icon'        => 'fas fa-industry',
            'submenu' => [
                            [
                                'text' => 'اضافة مصنع',
                                'url'  => 'suppliers/create',
                                'icon' => 'fas fa-plus-square text-danger',

                            ],
                            [
                                'text' => 'عرض المصانع',
                                'url'  => 'suppliers',
                                'icon' => 'fas fa-industry text-success',

                            ],
            ]
        ],
            [
            'text'        => 'المديونات',
            'url'         => 'show-debit',
            'icon'        => 'fas fa-wallet',
            'submenu' => [
                            [
                                'text' => 'دائن',
                                'url'  => 'show-credit',
                                'icon' => 'fas fa-wallet text-danger',

                            ],
                            [
                                'text' => 'مدين',
                                'url'  => 'show-debit',
                                'icon' => 'fas fa-wallet text-success',

                            ],
                            [
                                'text' => 'اضافة دائن / مدين',
                                'url'  => 'add-credit-debit',
                                'icon' => 'fas fa-plus-square text-info',

                            ],
            ]
        ],
        [
            'text'        => 'شيكات',
            'icon'        => 'fas fa-money-check',
            'submenu' => [
                            [
                                'text' => 'شيكات طلبات القماش',
                                'url'  => 'bank-check-clothes',
                                'icon' => 'fas fa-money-check text-danger',
                            ],
                            [
                                'text' => 'شيكات طلبات المبيعات',
                                'url'  => 'bank-check-orders',
                                'icon' => 'fas fa-money-check text-success',
                            ],
            ]
        ],
        [
            'text'        => 'المصروفات',
            'icon'        => 'fas fa-money-bill-alt',
            'url'         => 'Expances',
        ],
        [
            'text'        => 'خزنة المصنع',
            'icon'        => 'fas fa-coins',
            'url'         => 'money-safe',
        ],

        [
            'text'        => 'المخزن',
            'icon'        => 'fas fa-dolly-flatbed',
            'url'         => 'inventory',

        ],
        [
            'text'        => 'تقارير البيع',
            'icon'        => 'fas fa-receipt',
            'url'         => 'sales',
        ],
         [
            'text'        => 'راس المال و الارصدة',
            'icon'        => 'fas fa-funnel-dollar',
            'url'         => 'factory-capital',
        ],
        [
            'text'        => 'نسب الشركاء',
            'icon'        => 'far fa-handshake',
            'submenu' => [
                            [
                                'text' => 'اضافة شريك',
                                'url'  => 'partners/create',
                                 'icon' => 'fas fa-plus-square text-danger',
                            ],
                            [
                                'text' => 'عرض جميع النسب',
                                'url'  => 'partners',
                                'icon' => 'far fa-circle text-success',
                            ],
                             [
                                'text'        => 'سحب من رأس مال الشركاء',
                                'icon'        => 'far fa-circle text-warning',
                                'url'         => 'withdraws',
                            ],
            ]
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
