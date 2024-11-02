<?php

namespace common\forms;

use yii\base\Model;

class AuthForm extends Model
{
    public int $id;

    public int $is_auth;

    public string $reject_reason;

    public function rules(): array
    {
        return [
            [['id', 'is_auth',], 'required'],
            ['is_auth', 'in', 'range' => [-1, 1]],
            [['reject_reason',], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'is_auth' => '审核状态',
            'reject_reason' => '驳回原因',
        ];
    }
}