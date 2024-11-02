<?php

namespace common\enums;

enum CommonAuthEnum: int
{
    case No = 0;
    case Pass = 1;
    case Reject = -1;

    /**
     * 获取枚举值对应的标签
     * @param $value
     * @return string
     */
    public static function getLabel($value): string
    {
        return match($value) {
            self::No->value => '未审核',
            self::Pass->value => '已审核',
            self::Reject->value => '已拒绝',
            default => '未知',
        };
    }
}
