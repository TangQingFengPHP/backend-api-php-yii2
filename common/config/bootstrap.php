<?php

use common\providers\MappingServiceProvider;
use yii\di\Instance;

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

\Yii::$container->setDefinitions([
    backend\repositories\AdminRepositoryInterface::class => [
        'class' => backend\repositories\AdminRepository::class,
        'model' => Instance::of(common\models\Admin::class),
    ],
    backend\services\AdminServiceInterface::class => [
        'class' => backend\services\AdminService::class,
        'repository' => Instance::of(backend\repositories\AdminRepositoryInterface::class),
    ]
]);

// 注册DTO映射器
MappingServiceProvider::registerMappings();
