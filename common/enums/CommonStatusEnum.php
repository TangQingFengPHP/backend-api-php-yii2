<?php

namespace common\enums;


enum CommonStatusEnum: int
{
    case Deleted = -2;
    case Disabled = -1;
    case Normal = 0;
    case Active = 2;
    case Unknown = -99;

    /**
     * 获取状态文本
     * @param int $value
     * @return string
     */
    public static function getLabel(int $value): string
    {
        return match ($value) {
            self::Deleted->value => '已删除',
            self::Disabled->value => '已禁用',
            self::Normal->value => '正常',
            self::Active->value => '已启用',
            default => '未知',
        };
    }
}
