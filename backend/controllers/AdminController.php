<?php

namespace backend\controllers;

use backend\forms\AdminSaveForm;
use backend\services\AdminServiceInterface;
use common\controllers\BaseController;
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
    public function actionRegister()
    {
        $form = new AdminSaveForm();
        $form->load(\Yii::$app->request->post(), '');
        if (!$form->validate()) {
            throw new BadRequestHttpException(current($form->getErrorSummary(true)));
        }

        $this->adminService->save($form);
    }
}