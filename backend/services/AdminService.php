<?php

namespace backend\services;

use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use backend\dtos\AdminDto;
use backend\forms\AdminSaveForm;
use backend\repositories\AdminRepositoryInterface;
use common\consts\CommonConst;
use common\enums\CommonAuthEnum;
use common\forms\AuthForm;
use common\forms\EnableForm;
use common\forms\GetPageListForm;
use common\models\Admin;
use common\services\BaseService;
use common\utils\AutoMapperFactory;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;

class AdminService implements AdminServiceInterface
{
    public AdminRepositoryInterface $repository;

    /** @var ActiveRecord $model */
    private ActiveRecord $model;

    private AutoMapperInterface $mapper;


    public function __construct(AdminRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->model = $repository->getModelInstance();
        $this->mapper = AutoMapperFactory::getAutoMapper(AdminDto::class);
    }

    /**
     * 新增/编辑用户
     * @param AdminSaveForm $form
     * @return bool
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function save(AdminSaveForm $form): bool
    {
        /** @var Admin $admin */
        $admin = $form->id > 0 ? $this->repository->findById($form->id) : $this->model;
        if (!$admin) {
            throw new BadRequestHttpException("创建失败，管理员不存在");
        }

        $password = $form->password ?? CommonConst::PASSWORD;
        $formData = $form->attributes;
        unset($formData['password']);
        $admin->attributes = $formData;

        if ($form->id <= 0) {
            $admin->password_hash = $this->repository->setPassword($password);
            $admin->init_password = $admin->password_hash;
        }

        return $this->repository->save($admin);
    }

    /**
     * 列表
     * @param GetPageListForm $form
     * @return ActiveDataProvider
     * @throws UnregisteredMappingException
     */
    public function getList(GetPageListForm $form): ActiveDataProvider
    {
        $query = $this->model::find();
        $query->andFilterWhere([
            'or',
            ['like', 'mobile', $form->keyword],
            ['like', 'username', $form->keyword],
            ['like', 'realname', $form->keyword],
            ['like', 'email', $form->keyword],
        ]);

        $query->orderBy(['id' => SORT_DESC]);

        $dp = $this->repository->findPaginatedList($query);

        $dp->setModels(
            array_map(function ($model) {
                return $this->mapper->map($model->toArray(), AdminDto::class);
            }, $dp->getModels())
        );

        return $dp;
    }

    /**
     * 详情
     * @param int $id
     * @return AdminDto|null
     * @throws UnregisteredMappingException
     */
    public function detail(int $id): ?AdminDto
    {
        $model = $this->repository->findById($id);
        if (!$model) {
            return null;
        }

        return $this->mapper->map($model->toArray(), AdminDto::class);
    }

    /**
     * 软删除
     * @param int $id
     * @return bool
     * @throws BadRequestHttpException
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * 启用/禁用
     * @param EnableForm $form
     * @return bool
     * @throws BadRequestHttpException
     */
    public function enable(EnableForm $form): bool
    {
        /** @var Admin $model */
        $model = $this->repository->findById($form->id);
        if (!$model) {
            throw new BadRequestHttpException("数据不存在");
        }

        if ($model->is_auth != CommonAuthEnum::Pass->value) {
            throw new BadRequestHttpException("该用户未通过审核，无法启用");
        }

        return $this->repository->enable($form->id, $form->status);
    }

    /**
     * 审核
     * @param AuthForm $form
     * @return bool
     */
    public function auth(AuthForm $form): bool
    {
        return $this->repository->auth($form->id, $form->is_auth, $form->reject_reason);
    }
}