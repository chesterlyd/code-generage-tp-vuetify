<?php
/**
 * DateTime: 2020/12/22 16:43
 */

namespace app\app\controller;

use Generate\Traits\App\Common;
use think\Controller;
use think\exception\HttpResponseException;
use think\facade\Session;

class SignIn extends Controller
{
    use Common;

    private $notLogin = [];

    public function initialize()
    {
        $moduleName = \request()->module();
        $controllerName = \request()->controller();
        $actionName = \request()->action();
        $activeUrl = $moduleName . '/' . $controllerName . '/' . $actionName;
        Session::prefix('app');
        if (!in_array($activeUrl, $this->notLogin)) {
            $this->check();
        }
    }

    protected function check()
    {
        $token = \request()->header('Authorization');

        if ($token) {
            $res = verifyToken($token);
            if (!$res) {
                throw new HttpResponseException($this->notLogin());
            }
        } else {
            throw new HttpResponseException($this->notLogin());
        }
        return $res;
    }
}
