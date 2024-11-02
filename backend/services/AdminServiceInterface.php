<?php

namespace backend\services;

use backend\forms\AdminSaveForm;
use common\forms\AuthForm;
use common\forms\EnableForm;
use common\forms\GetPageListForm;
use yii\db\ActiveRecord;

interface AdminServiceInterface
{
    public function save(AdminSaveForm $form);
    public function getList(GetPageListForm $form);
    public function detail(int $id);
    public function delete(int $id);
    public function enable(EnableForm $form);
    public function auth(AuthForm $form);
}