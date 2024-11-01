<?php

namespace backend\forms;

use yii\base\Model;

class AdminSaveForm extends Model
{
    public $id;
    public $mobile;
    public $password;
    public $username;
    public $realname;
    public $email;
    public $remark;

    public function rules(): array
    {
        return [
            [['mobile', 'password', 'username',], 'required'],
            ['email', 'email'],
            [['username', 'realname', 'email',], 'string', 'max' => 50],
            [['remark',], 'string', 'max' => 300],
            [['id',], 'integer'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'mobile' => '手机号',
            'password' => '密码',
            'username' => '用户名',
            'realname' => '真实姓名',
            'email' => '邮箱',
            'remark' => '备注',
        ];
    }
}