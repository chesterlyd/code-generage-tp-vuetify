<?php

namespace app\admin\controller;

use Generate\Traits\JsonReturn;
use PDOStatement;
use think\Auth;
use think\Collection;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\facade\Cache;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;
use think\Loader;

class Signin extends Base
{
    use JsonReturn;

    /**
     * 无需权限认证部分
     * @var array
     */
    protected $unblock = [];

    public function initialize()
    {
        parent::initialize();
        // 是否登录
//        if ($this->isLogin() === false) {
//            $this->returnFail('未登录', -1);
//        }
//        // 是否拥有访问权限(超级管理员除外)
        if (!$this->isSuperManager() && !$this->authCheck()) {
            $this->returnFail('无权限访问！');
        }
    }

    /**
     * 判断当前用户是否为超级管理员
     */
    protected function isSuperManager(): bool
    {
//        $superManagers = Config::get('supermanager');
        $superManagers = (new \app\common\model\Admin())->where('super_admin', 1)->where('is_disable')->column('id');
        if (in_array($this->getAuthId(), $superManagers)) {
            return true;
        }
        return false;
    }

    public function getAuthUserType()
    {
        static $user_type = null;
        if (is_null($user_type)) {
            $user_type = $this->getAuth()['user_type'];
        }
        return $user_type;
    }

    /**
     * 获取当前登录用户的id
     * @return mixed
     */
    public function getAuthId()
    {
        static $id = null;
        if (is_null($id)) {
            $id = $this->getAuth()['id'];
        }
        return $id;
    }

    public function getAuthGroupTitle()
    {
        $id = $this->getAuth()['id'];
        $groupAccess = (new \app\common\model\AuthGroupAccess())->where('uid', $id)->find();
        $groupTitle = (new \app\common\model\AuthGroup())->where('id', $groupAccess['group_id'])->value('title');
        return $groupTitle;
    }

    public function getMemberId()
    {
        $id = $this->getAuth()['id'];
        $memberId = (new \app\common\model\Member())->where('admin_id', $id)->value('id');
        return $memberId;
    }

    /**
     * 获取当前登录用的数据
     * @return mixed
     */
    public function getAuth()
    {
        $token = Request::param('token');
        if ($token) {//token登录
            $res = Cache::get($token);
        } else {//web登录
            $res = Session::get('data');
        }
        return $res;
    }

    /**
     * 权限检测
     * @return bool
     */
    protected function authCheck()
    {
        $controller = request()->controller();
        $action = request()->action();
        $auth = new Auth();
        // 首页 登出 无需权限检测
        $url = strtolower(Loader::parseName($controller) . '/' . $action);
        if (!in_array($url, $this->unblock)) {
            if (!$auth->check($url, $this->getAuthId())) {
                return false;
            }
        }
        return true;
    }

    public function getAuthList()
    {
        $auth = new \app\common\library\Auth();
        $authList = $auth->getAuthList($this->getAuthId());
        $data = [
            'auth'  => array_merge($authList),
            'super' => false,
        ];
        if ($this->isSuperManager()) {
            $data['super'] = true;
        }
        $this->returnSuccess($data);
    }

    /**
     * 获取菜单
     * @return array|false|PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    protected function getMenu()
    {
        // 所有菜单
        $menu = Db::name('authrule')->field('id,name,title,status,pid,sort')->order('sort ASC')->select();
        // 拥有权限菜单
        $auth = new Authority();
        $uid = Session::get('uid', 'admin');
        $ruleList = $auth->getAuthList($uid, 1);

        if ($this->isSuperManager()) {
            // 超级管理员
            return $menu;
        }
        // 后台用户
        return $ruleList;
    }
}
