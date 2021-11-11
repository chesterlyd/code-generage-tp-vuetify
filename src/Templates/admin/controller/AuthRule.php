<?php

namespace app\admin\controller;

use Generate\Traits\Admin\Common;
use Generate\Traits\Admin\Curd;
use Generate\Traits\Admin\CurdInterface;
use think\db\Query;
use think\exception\DbException;
use think\facade\Env;
use think\Request;

class AuthRule extends Signin implements curdInterface
{
    /*
     * 特别说明
     * Common中的文件不能直接修改！！！！
     * 如果需要进行业务追加操作，请复制Common中的对应的钩子方法到此控制器中后在进行操作
     * Happy Coding
     **/
    use Curd, Common;

    protected $cache = true;
    protected $modelName = 'AuthRule';  //模型名,用于add和update方法
    protected $orderField = '';
    protected $indexField = ['id', 'name', 'title', 'type', 'status', 'pid', 'sort'];  //查，字段名
    protected $addField = ['name', 'title', 'type', 'pid', 'sort'];    //增，字段名
    protected $editField = ['name', 'title', 'type', 'pid', 'sort'];   //改，字段名
    protected $searchField = []; //条件查询，字段名,例如：无关联查询['name','age']，关联查询['name','age','productId' => 'p.name'],解释：参数名为productId,关联表字段p.name
    protected $pageLimit = 10;               //分页数

    protected $app_path = '';

    //增，数据检测规则
    protected $add_rule = [
        //'nickName|昵称'  => 'require|max:25'
    ];
    //改，数据检测规则
    protected $edit_rule = [
        //'nickName|昵称'  => 'require|max:25'
    ];

    public function initialize()
    {
        $this->app_path = Env::get('app_path');
    }

    /**
     * @throws DbException
     */
    public function getAll()
    {
        $model = new \app\common\model\AuthRule();
        if ($this->isSuperManager()) {
            $rules = $model->select();
        } else {
            //读取用户所属用户组
            $groups = \app\common\model\AuthGroup::where('id', 'in', function (Query $query) {
                $query->name('AuthGroupAccess')->where('uid', $this->getAuthId())->field('group_id');
            })->where('status', 1)->column('rules');
            $ids = []; //保存用户所属用户组设置的所有权限规则id
            foreach ($groups as $g) {
                $ids = array_merge($ids, explode(',', trim($g, ',')));
            }
            $ids = array_unique($ids);
            $rules = $model->where('id', 'in', $ids)->where('status', 1)->select();
        }
        $convertRule = convert_tree($rules, 0, true, true, false);
        $this->returnSuccess($convertRule);
    }

    public function getParent(Request $request)
    {
        if ($request->isGet()) {
            $data = (new \app\common\model\AuthRule())->field('id,id value,title label,pid')->select();
            $list = convert_tree($data, 0, true, true, false);
            foreach ($list as $key => $value) {
                $list[$key]['loading'] = false;
                if (!isset($value['children'])) {
                    $list[$key]['children'] = [];
                }
            }
            $this->returnSuccess($list);
        }
    }

    public function initperm()
    {
        $modules = ['admin'];  //模块名称
        $i = 0;
        $controllerSelect = [];
        $actionSelect = [];
        foreach ($modules as $module) {
            $all_controller = $this->getController($module);

            foreach ($all_controller as $controller) {
                $controllerSelect[] = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $controller));
            }

            foreach ($all_controller as $controller) {
                $all_action = $this->getAction($module, $controller);
                foreach ($all_action as $action) {
                    $controller = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $controller));
                    $data[$i]['module'] = $module;
                    $data[$i]['controller'] = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $controller));
                    $data[$i]['action'] = $action;

                    $actionSelect[$controller][] = $action;

//                    dump($data);exit();
                }
            }
        }
        $this->returnSuccess(['controller' => $controllerSelect, 'action' => $actionSelect]);
    }

    //获取所有控制器名称
    private function getController($module)
    {
        if (empty($module)) {
            return null;
        }

        $module_path = $this->app_path . $module . '/controller';  //控制器路径

        if (!is_dir($module_path)) {
            return null;
        }
        $module_path .= '/*.php';
        $ary_files = glob($module_path);

        foreach ($ary_files as $file) {
            if (is_dir($file)) {
                continue;
            }
            $files[] = basename($file, '.php');
        }
        return $files;
    }

    //获取所有方法名称
    protected function getAction($module, $controller)
    {
        if (empty($controller)) {
            return null;
        }
        $customer_functions = [];
        $file = $this->app_path . $module . '/controller/' . $controller . '.php';
        if (file_exists($file)) {
            $content = file_get_contents($file);
            preg_match_all("/.*?public.*?function(.*?)\(.*?\)/i", $content, $matches);
            $functions = $matches[1];
            //排除部分方法
            $inherents_functions = ['initialize', '__construct', 'getActionName', 'isAjax', 'display', 'show', 'fetch', 'buildHtml', 'assign', '__set', 'get', '__get', '__isset', '__call', 'error', 'success', 'ajaxReturn', 'redirect', '__destruct', '_empty'];
            foreach ($functions as $func) {
                $func = trim($func);
                if (!in_array($func, $inherents_functions)) {
                    $customer_functions[] = $func;
                }
            }
            return $customer_functions;
        }
//            \ticky\Log::record('is not file ' . $file, Log::INFO);
        return false;

        return null;
    }
}
