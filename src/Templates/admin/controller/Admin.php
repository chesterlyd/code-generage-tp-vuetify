<?php

namespace app\admin\controller;

use app\common\model\AuthGroupAccess;
use Generate\Traits\Admin\Common;
use Generate\Traits\Admin\Curd;
use Generate\Traits\Admin\CurdInterface;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\db\Query;
use think\Exception;
use think\exception\DbException;
use think\exception\HttpResponseException;
use think\facade\Cache;
use think\facade\Request;
use think\response\Json;

class Admin extends Signin implements CurdInterface
{
    /*
     * 特别说明
     * Common中的文件不能直接修改！！！！
     * 如果需要进行业务追加操作，请复制Common中的对应的钩子方法到此控制器中后在进行操作
     * Happy Coding
     **/
    use Curd, Common;
    protected $cache = true;
    protected $modelName = 'Admin';  //模型名,用于add和update方法
    protected $orderField = 'create_time desc';
    protected $indexField = ['id', 'account', 'name', 'member_id', 'is_disable', 'create_operator_id', 'super_admin', 'create_time'];  //查，字段名
    protected $addField = ['account', 'password', 'name', 'is_disable', 'super_admin'];    //增，字段名
    protected $editField = ['account', 'password', 'name', 'is_disable', 'super_admin'];   //改，字段名
    protected $searchField = ['account']; //条件查询，字段名,例如：无关联查询['name','age']，关联查询['name','age','productId' => 'p.name'],解释：参数名为productId,关联表字段p.name
    protected $pageLimit = 10;               //分页数

    //增，数据检测规则
    protected $add_rule = [
        'account|账号'  => 'require|unique:admin',
        'password|密码' => 'require',
        'name|名称'     => 'require',
        'group_id|角色' => 'require',
    ];
    //改，数据检测规则
    protected $edit_rule = [
        'account|账号'  => 'require',
        'name|名称'     => 'require',
        'group_id|角色' => 'require',
    ];

    /**
     * 列表查询sql捕获
     * @param Query $sql
     * @return Query
     */
    public function indexQuery($sql)
    {
        if (!$this->isSuperManager()) {
//            $sql->where('create_operator_id', $this->getAuthId());
            $sql->where('id', $this->getAuthId());
        }
        return $sql->with('authgroup');
    }

    /**
     * 输出到编辑视图的数据捕获
     * @param $data
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function editAssign($data)
    {
        $groupId = AuthGroupAccess::where('uid', $data['id'])->column('group_id');
        // 角色
        $model = \app\common\model\AuthGroup::field('id,title');
        if ($this->isSuperManager()) {
            $roles = $model->select();
        } else {
            $roles = $model->where('id', 'in', function (Query $query) {
                $query->name('AuthGroupAccess')->where('uid', $this->getAuthId())->field('group_id');
            })->select();
        }

        $data['data']['group_id'] = $groupId;
        $data['lists'] = [
            'rolelist' => $roles,
        ];
        return $data;
    }

    /**
     * 编辑数据插入数据库前数据捕获（注意：在数据验证之前）
     * @param $data
     * @return mixed
     * @throws DbException
     */
    public function editData($data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $request = Request::instance();
        $group_id = $request->post('group_id/a', []);
        $data['group_id'] = $group_id;

        $admin = \app\common\model\Admin::get($data['id']);
        if (empty($admin)) {
            $this->returnFail('数据不存在');
        }
        if (!$this->isSuperManager() && $admin->create_operator_id != $this->getAuthId()) {
            //不是超级管理员也不是创建者
            $this->returnFail('您没有权限修改此数据');
        }

        return $data;
    }

    public function addData($data)
    {
        $group_id = Request::post('group_id/a', []);
        $data['group_id'] = $group_id;
        $data['create_operator_id'] = $this->getAuthId();
        return $data;
    }

    /**
     * 成功编辑数据后的数据捕获
     * @param $id @desc 编辑数据的id
     * @param $data @desc 接受的参数，包含追加的
     * @return mixed|Json|void
     */
    public function editEnd($id, $data)
    {
        AuthGroupAccess::where('uid', $id)->delete();
        $this->addEnd($id, $data);
    }

    /**
     * 成功添加数据后的数据捕获
     * @param $id @desc 添加后的id
     * @param $data @desc 接受的参数，包含追加的
     * @return mixed|void
     */
    public function addEnd($id, $data)
    {
        $insert = [];
        foreach ($data['group_id'] as $group) {
            $insert[] = [
                'uid'      => $id,
                'group_id' => $group,
            ];
        }
        Db::name('AuthGroupAccess')->insertAll($insert);
        Cache::clear('AuthGroupAccess_cache_data');
    }

    /**
     * 删除
     * @throws Exception
     */
    public function delete(Request $request)
    {
        $model = model($this->modelName);
        $id = $request::param('id');

        if (empty($id)) {
            $this->returnFail('参数有误，缺少id');
        }
        $data = $model->find($id);
        if (empty($data)) {
            $this->returnFail();
        }
        Db::startTrans();
        try {
            if (!$this->isSuperManager() && $data->create_operator_id != $this->getAuthId()) {
                $this->returnFail('您没有权限删除此用户');
            }
            $data->delete();
            //删除用户
            $childrens = \app\common\model\Admin::getChildrenIds($id);
            \app\common\model\Admin::where('id', 'in', $childrens)
                ->update(['delete_time' => time()]);
            Db::name('AuthGroupAccess')->where('uid', 'in', $id)->delete();
            //删除这些用户添加的角色
            \app\common\model\AuthGroup::where('create_operator_id', 'in', $childrens)->delete();
        } catch (HttpResponseException $e) {
            Db::rollback();
            throw $e;
        } catch (\Exception $e) {
            Db::rollback();
            $this->returnFail($e->getMessage());
        }
        Db::commit();
        $this->returnSuccess();
    }

    /**
     * @throws DbException
     */
    public function changePassword(Request $request)
    {
        if (!$request::isPost()) {
            $this->returnFail('请求方式错误');
        }
        $old = $request::post('old_password');
        $newpass = $request::post('new_password');
        $repass = $request::post('repeat_password');
        if (empty($old)) {
            $this->returnFail('请输入旧密码');
        }
        if (empty($newpass)) {
            $this->returnFail('新密码不能为空');
        }
        if ($newpass != $repass) {
            $this->returnFail('两次密码不一致');
        }
        $user = \app\common\model\Admin::get($this->getAuthId());
        if (empty($user)) {
            $this->returnFail('数据错误，请重新登录');
        }
        if (!password_verify($old, $user->password)) {
            $this->returnFail('旧密码错误');
        }
        $user->password = $newpass;
        $user->save();
        $this->returnSuccess();
    }

    /**
     * 禁用用户
     * @param int $id 用户id
     * @throws DbException
     */
    public function disable($id = 0)
    {
        $admin = \app\common\model\Admin::get($id);
        $admin->is_disable = 1;
        $admin->save();
        $this->returnSuccess();
    }

    /**
     * 启用用户
     * @param int $id 用户id
     * @throws DbException
     */
    public function enable($id = 0)
    {
        $admin = \app\common\model\Admin::get($id);
        $admin->is_disable = 2;
        $admin->save();
        $this->returnSuccess();
    }
}
