<?php

namespace backend\repositories;

use common\models\Admin;
use common\repositories\BaseRepository;
use yii\db\ActiveRecord;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    public $model;
    public function __construct(Admin $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}