<?php

namespace backend\repositories;

use yii\db\ActiveRecord;

interface AdminRepositoryInterface
{
    public function auth(int $id, int $is_auth, string $reject_reason);
}