<?php
// 事件定义文件


use app\event\FacadeConfig;

return [
    'bind' => [
    ],

    'listen' => [
        'AppInit'  => [],
        'HttpRun'  => [FacadeConfig::class],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
    ],

    'subscribe' => [
    ],
];
