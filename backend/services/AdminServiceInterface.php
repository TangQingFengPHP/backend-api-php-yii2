<?php

namespace backend\services;

use backend\forms\AdminSaveForm;
use yii\db\ActiveRecord;

interface AdminServiceInterface
{
    public function save(AdminSaveForm $form);
//    public function findById(int $id);
}