<?php

namespace backend\dtos;

use common\dtos\BaseDto;

class AdminDto extends BaseDto
{
    public int $id;

    public string $mobile;

    public string $username;

    public string $realname;

    public string $email;

    public string $remark;

    public string $status;

    public string $is_auth;
}