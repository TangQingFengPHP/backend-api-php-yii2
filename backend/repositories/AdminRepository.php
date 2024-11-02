<?php

namespace backend\repositories;

use backend\dtos\AdminDto;
use common\enums\CommonStatusEnum;
use common\models\Admin;
use common\repositories\BaseRepository;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    public Admin $model;
    public function __construct(Admin $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    /**
     * 审核
     * @param int $id
     * @param int $is_auth
     * @param string $reject_reason
     * @return bool
     * @throws BadRequestHttpException
     */
    public function auth(int $id, int $is_auth, string $reject_reason = ''): bool
    {
        /** @var Admin $model */
        $model = $this->findById($id);
        if (!$model) {
            throw new BadRequestHttpException('数据不存在');
        }

        if ($model->status != CommonStatusEnum::Normal->value) {
            throw new BadRequestHttpException('非初始状态，无法审核');
        }

        $model->is_auth = $is_auth;
        $model->reject_reason = $reject_reason;

        if (!$model->save()) {
            throw new BadRequestHttpException(current($model->getErrorSummary(true)));
        }

        return true;
    }

}