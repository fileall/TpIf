<?php
// 这是系统自动生成的admin应用middleware定义文件
use think\middleware\{
    LoadLangPack,
    SessionInit,
    TraceDebug
};
use app\admin\middleware\AccessCheck;

return [

    LoadLangPack::class, // 多语言加载

    SessionInit::class,  // Session初始化

    TraceDebug::class,   // 页面Trace调试

    AccessCheck::class   // 入口权限检查
];
