<?php

namespace common\utils;

use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Configuration\AutoMapperConfig;
use AutoMapperPlus\Configuration\Mapping;
use backend\dtos\AdminDto;
use common\enums\CommonAuthEnum;
use common\enums\CommonStatusEnum;
use common\models\Admin;
use yii\helpers\VarDumper;

class AutoMapperFactory
{
    /**
     * 获取AutoMapper实例
     * @param string $dtoClassName
     * @return AutoMapperInterface
     */
    public static function getAutoMapper(string $dtoClassName): AutoMapperInterface
    {
        $config = new AutoMapperConfig();
        $mapping = $config->registerMapping('array', $dtoClassName);

        // 注册映射配置
        MappingRegistry::applyMappingConfig($dtoClassName, $mapping);

        return new AutoMapper($config);
    }
}