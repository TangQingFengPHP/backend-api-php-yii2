<?php

namespace common\forms;

use yii\base\Model;

class DetailForm extends Model
{
    public int $id;

    public function rules(): array
    {
        return [
            [['id'], 'required'],
        ];
    }
}