<?php

namespace common\repositories;

use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;

class BaseRepository
{
    /**
     * @var ActiveRecord
     */
    private ActiveRecord $model;

    /**
     * @param ActiveRecord $model
     */
    public function __construct(ActiveRecord $model)
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
     * @param int $id
     * @return bool
     * @throws \yii\db\StaleObjectException
     */
    public function delete(int $id): bool
    {
        $model = $this->findById($id);
        if (!$model) {
            return false;
        }
        return $model->delete();
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