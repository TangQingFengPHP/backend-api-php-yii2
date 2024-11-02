<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 * @property int $id 主键ID
 * @property string $mobile 手机号
 * @property string $password_hash 登录密码
 * @property string $username 用户名称
 * @property string $realname 真实姓名
 * @property string $email 邮箱
 * @property string $remark 备注
 * @property int $status 状态:-2删除，-1禁用，0正常，2启用
 * @property int $is_auth 是否已审核:0-未审核，1-已审核
 * @property string $reject_reason 驳回原因
 * @property string $last_login_time 最后登录时间
 * @property string $login_ip 最后登录IP
 * @property string $init_password 初始密码
 */
class Admin extends BaseModel implements IdentityInterface
{
//    public int $id;
    public static function tableName(): string
    {
        return '{{%admin}}';
    }

    public function rules(): array
    {
        return [
            [['mobile', 'username',], 'required'],
            ['email', 'email'],
            [['username', 'realname', 'email',], 'string', 'max' => 50],
            [['mobile', 'email',], 'unique'],
            [['remark',], 'string', 'max' => 300],
            [['id',], 'integer'],
        ];
    }
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}