<?php

namespace app\admin\controller;

use Generate\Traits\JsonReturn;
use think\Controller;
use think\facade\Cache;
use think\Loader;
use think\Request;

/**
 * Class Base
 */
class Base extends Controller
{
    use JsonReturn;

    /**
     * 清除缓存
     * @param string $table 表名
     */
    public function clearCache($table = '')
    {
        if (empty($table)) {
            $this->returnFail('缺少表名');
        }
        $modelName = Loader::parseName($table, 1);
        Cache::clear($modelName . '_cache_data');
        $this->returnSuccess('缓存清除成功');
    }

    /**
     * 验证是否登录
     * @return bool
     */
    protected function isLogin(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token) {
            $res = verifyToken($token);
        } else {
            return false;
        }
        return $res;
    }
}
