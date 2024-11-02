<?php

namespace common\utils;

use AutoMapperPlus\Configuration\Mapping;

class MappingRegistry
{
    private static array $mappingConfigs = [];

    /**
     * 注册映射配置
     * @param string $dtoClassName
     * @param callable $configurator
     * @return void
     */
    public static function registerMappingConfig(string $dtoClassName, callable $configurator): void
    {
        self::$mappingConfigs[$dtoClassName] = $configurator;
    }

    /**
     * 应用映射配置
     * @param string $dtoClassName
     * @param Mapping $mapping
     * @return void
     */
    public static function applyMappingConfig(string $dtoClassName, Mapping $mapping): void
    {
        if (isset(self::$mappingConfigs[$dtoClassName]))
        {
            call_user_func(self::$mappingConfigs[$dtoClassName], $mapping);
        }
    }
}