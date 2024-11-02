<?php

namespace common\forms;

use common\enums\CommonStatusEnum;
use yii\base\Model;

class EnableForm extends Model
{
    public int $id;

    public int $status;

    public function rules(): array
    {
        return [
            [$this->attributes(),'required'],
            ['status', 'in', 'range' => [CommonStatusEnum::Disabled->value, CommonStatusEnum::Active->value]],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'status' => '状态',
        ];
    }
}