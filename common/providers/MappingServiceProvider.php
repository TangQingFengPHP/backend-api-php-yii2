<?php

namespace common\providers;

use AutoMapperPlus\Configuration\Mapping;
use backend\dtos\AdminDto;
use common\enums\CommonAuthEnum;
use common\enums\CommonStatusEnum;
use common\utils\MappingRegistry;

class MappingServiceProvider
{
    /**
     * 注册映射配置
     * @return void
     */
    public static function registerMappings() : void
    {
        MappingRegistry::registerMappingConfig(
            AdminDto::class,
            function (Mapping $mapping) {
                $mapping->forMember('status', function (array $source) {
                    return CommonStatusEnum::getLabel($source['status']);
                })->forMember('is_auth', function (array $source) {
                    return CommonAuthEnum::getLabel($source['is_auth']);
                });
            }
        );
    }
}