<?php

use yii\db\Migration;

/**
 * Class m241027_024638_add_admin_table
 */
class m241027_024638_add_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'mobile' => $this->string(30)->notNull()->defaultValue('')->comment('手机号'),
            'password_hash' => $this->string(100)->notNull()->defaultValue('')->comment('登录密码'),
            'username' => $this->string(50)->notNull()->defaultValue('')->comment('用户名称'),
            'realname' => $this->string(50)->notNull()->defaultValue('')->comment('真实姓名'),
            'email' => $this->string(50)->defaultValue('')->comment('邮箱'),
            'remark' => $this->string(300)->defaultValue('')->comment('备注'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0)->comment("状态:-2删除，-1禁用，0正常，2启用"),
            'is_auth' => $this->tinyInteger()->notNull()->defaultValue(0)->comment("是否已审核:0-未审核，1-已审核, -1-审核驳回"),
            'reject_reason' => $this->string(100)->defaultValue('')->comment('驳回原因'),
            'last_login_time' => 'timestamp not null default current_timestamp comment "上次登录时间"',
            'login_ip' => $this->string(255)->defaultValue('')->comment('最后登录IP'),
            'init_password' => $this->string(100)->notNull()->defaultValue('')->comment('初始密码'),
            'create_time' => 'timestamp not null default current_timestamp comment "创建时间"',
            'update_time' => 'timestamp not null default current_timestamp on update current_timestamp comment "更新时间"',
        ], 'engine=innodb character set utf8mb4 collate utf8mb4_unicode_ci comment "落地公司端管理员表"');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin}}');
    }
}
