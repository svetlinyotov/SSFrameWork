<?php

return [
    'displayExceptions' => true,

    'second_step_routing' => true, //if enabled and no route in routes.php is found, then default routing will be used site.com/controller/method/param1/param2/....

    'controller_default_namespace' => 'App',

    'router_default_path' => __DIR__.'/../router.php', //used only for

    'views_default_path' => __DIR__.'/../views',

    'namespaces' => [
        'App' => __DIR__.'/..',
    ],

];