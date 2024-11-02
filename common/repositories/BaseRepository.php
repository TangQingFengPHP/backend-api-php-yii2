<?php

namespace common\repositories;

use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use common\dtos\BaseDto;
use common\enums\CommonStatusEnum;
use common\models\BaseModel;
use common\utils\AutoMapperFactory;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;

class BaseRepository
{
    /**
     * @var BaseModel $model
     */
    private BaseModel $model;

    /**
     * @param BaseModel $model
     */
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    public function findById(int $id): ?ActiveRecord
    {
        return $this->model->findOne($id);
    }

    /**
     * @param ActiveRecord $model
     * @return bool
     * @throws BadRequestHttpException
     */
    public function save(ActiveRecord $model): bool
    {
        if (!$model->save()) {
            throw new BadRequestHttpException(current($model->getErrorSummary(true)));
        }
        return true;
    }

    /**
     * 通用分页列表查询
     * @param ActiveQuery $query
     * @return ActiveDataProvider
     */
    public function findPaginatedList(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'validatePage' => false,
            ]
        ]);
    }

    /**
     * 软删除
     * @param int $id
     * @return bool
     * @throws BadRequestHttpException
     */
    public function delete(int $id): bool
    {
        /** @var BaseModel $model */
        $model = $this->findById($id);
        if (!$model) {
            throw new BadRequestHttpException('数据不存在');
        }
        if ($model->status == CommonStatusEnum::Active->value) {
            throw new BadRequestHttpException('启用状态下不能删除');
        }

        $model->status = CommonStatusEnum::Deleted->value;
        if (!$model->save()) {
            throw new BadRequestHttpException(current($model->getErrorSummary(true)));
        }
        return true;
    }

    /**
     * 启用/禁用
     * @param int $id
     * @param int $status
     * @return bool
     * @throws BadRequestHttpException
     */
    public function enable(int $id, int $status): bool
    {
        /** @var BaseModel $model */
        $model = $this->findById($id);
        if (!$model) {
            throw new BadRequestHttpException('数据不存在');
        }

        if ($model->status == CommonStatusEnum::Deleted->value) {
            throw new BadRequestHttpException('已删除状态下不能启用');
        }

        $model->status = $status;
        if (!$model->save()) {
            throw new BadRequestHttpException(current($model->getErrorSummary(true)));
        }

        return true;
    }

    /**
     * 生成密码哈希值
     * @param string $password
     * @return string
     * @throws \yii\base\Exception
     */
    public function setPassword(string $password): string
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 获取模型实例
     * @return ActiveRecord
     */
    public function getModelInstance(): ActiveRecord
    {
        return $this->model;
    }
}