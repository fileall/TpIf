<?php
// 这是系统自动生成的admin应用event定义文件
use app\admin\event\
{
    ReadConfig
};

return [
    'listen' => [
        'HttpRun' => [ReadConfig::class],
    ],
];
