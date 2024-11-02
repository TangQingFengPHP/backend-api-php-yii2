<?php

namespace common\forms;

use yii\base\Model;

class GetPageListForm extends Model
{
    public string $keyword;

    public function rules(): array
    {
        return [
            [$this->attributes(),'safe']
        ];
    }
}