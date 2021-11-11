<?php

namespace app\common\model;

use think\Model;

class AuthGroup extends Model
{
    protected $type = [
    ];

    // 自动维护时间戳
    protected $autoWriteTimestamp = false;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
}
