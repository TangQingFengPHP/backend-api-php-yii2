<?php

namespace backend\services;

use backend\forms\AdminSaveForm;
use backend\repositories\AdminRepositoryInterface;
use common\models\Admin;
use common\services\BaseService;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;

class AdminService implements AdminServiceInterface
{
    private const PASSWORD = '123456';

    public AdminRepositoryInterface $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
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
        $admin = $form->id > 0 ? $this->adminRepository->findById($form->id) : $this->adminRepository->getModelInstance();
        if (!$admin) {
            throw new BadRequestHttpException("创建失败，管理员不存在");
        }

        $password = $form->password ?? self::PASSWORD;
        $formData = $form->attributes;
        unset($formData['password']);
        $admin->attributes = $formData;

        if ($form->id <= 0) {
            $admin->password_hash = $this->adminRepository->setPassword($password);
        }

        return $this->adminRepository->save($admin);
    }

}