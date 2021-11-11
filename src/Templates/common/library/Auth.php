<?php
/**
 * DateTime: 2020/9/5 23:38
 */

namespace app\common\library;

class Auth extends \think\Auth
{
    public function getAuthList($uid, $type = 1)
    {
        return parent::getAuthList($uid, $type);
    }
}
