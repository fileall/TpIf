<?php
// 这是系统自动生成的admin应用middleware定义文件

use app\event\FacadeConfig;
use think\middleware\{
    LoadLangPack,
    SessionInit
};

return [

    LoadLangPack::class, // 多语言加载

    SessionInit::class,  // Session初始化

    // FacadeConfig::class, //加载面板配置文件


];
