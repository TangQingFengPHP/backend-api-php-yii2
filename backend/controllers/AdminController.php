<?php

namespace backend\controllers;

use backend\forms\AdminSaveForm;
use backend\services\AdminServiceInterface;
use common\controllers\BaseController;
use common\forms\AuthForm;
use common\forms\EnableForm;
use common\forms\GetPageListForm;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;

class AdminController extends BaseController
{
    private AdminServiceInterface $adminService;

    public function __construct($id, $module, AdminServiceInterface $adminService, $config = [])
    {
        $this->adminService = $adminService;
        parent::__construct($id, $module, $config);
    }

    /**
     * 注册
     * @return void
     * @throws BadRequestHttpException
     */
    public function actionRegister(): void
    {
        $form = new AdminSaveForm();
        $form->load(\Yii::$app->request->post(), '');
        if (!$form->validate()) {
            throw new BadRequestHttpException(current($form->getErrorSummary(true)));
        }

        $this->adminService->save($form);
    }

    /**
     * 分页列表
     * @return ActiveDataProvider
     */
    public function actionGetList(): ActiveDataProvider
    {
        $form = new GetPageListForm();
        $form->load(\Yii::$app->request->get(), '');

        return $this->adminService->getList($form);
    }

    /**
     * 详情
     * @throws BadRequestHttpException
     */
    public function actionDetail()
    {
        $id = \Yii::$app->request->get('id');
        if (!$id) {
            throw new BadRequestHttpException('id不能为空');
        }

        return $this->adminService->detail($id);
    }

    /**
     * 软删除
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionDel(): bool
    {
        $id = \Yii::$app->request->post('id');
        if (!$id) {
            throw new BadRequestHttpException('id不能为空');
        }

        return $this->adminService->delete($id);
    }

    /**
     * 启用/禁用
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionEnable(): bool
    {
        $form = new EnableForm();
        $form->load(\Yii::$app->request->post(), '');
        if (!$form->validate()) {
            throw new BadRequestHttpException(current($form->getErrorSummary(true)));
        }

        return $this->adminService->enable($form);
    }

    /**
     * 审核
     * @return bool
     * @throws BadRequestHttpException
     */
    public function actionAuth(): bool
    {
        $form = new AuthForm();
        $form->load(\Yii::$app->request->post(), '');
        if (!$form->validate()) {
            throw new BadRequestHttpException(current($form->getErrorSummary(true)));
        }

        return $this->adminService->auth($form);
    }
}