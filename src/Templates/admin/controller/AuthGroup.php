<?php

namespace app\admin\controller;

use app\common\model\AuthGroupAccess;
use Generate\Traits\Admin\Common;
use Generate\Traits\Admin\Curd;
use Generate\Traits\Admin\CurdInterface;
use think\Db;
use think\db\Query;
use think\Exception;
use think\exception\DbException;
use think\exception\HttpResponseException;
use think\Model;
use think\Request;

class AuthGroup extends Signin implements curdInterface
{
    /*
     * 特别说明
     * Common中的文件不能直接修改！！！！
     * 如果需要进行业务追加操作，请复制Common中的对应的钩子方法到此控制器中后在进行操作
     * Happy Coding
     **/
    use Curd, Common;

    protected $cache = false; //是否使用缓存
    protected $modelName = 'AuthGroup';  //模型名
    protected $indexField = ['id', 'title'];  //查，字段名
    protected $addField = ['title', 'rules'];    //增，字段名
    protected $editField = ['title', 'rules'];   //改，字段名
    /**
     * 条件查询，字段名,例如：无关联查询['name','age']，关联查询['name','age',['productId' => 'product.name']],解释：参数名为productId,关联表字段p.name
     * 默认的类型为输入框，如果有下拉框，时间选择等需求可以这样定义['name',['type' => ['type','select']]];目前有select,time_start,time_end三种可被定义
     * 通过模型定义的关联查询，可以这样定义['name',['memberId'=>['member.nickname','relation']]],只能有一个关联方法被定义为relation，且字段前的表别名必须为关联的方法名
     * @var array
     */
    protected $searchField = ['title'];
    protected $orderField = '';  //排序字段
    protected $pageLimit = 10;               //分页数

    //增，数据检测规则
    protected $add_rule = [
        //'nickName|昵称'  => 'require|max:25'
        'title|角色名称' => 'require',
        'rules|权限'   => 'require',
    ];
    //改，数据检测规则
    protected $edit_rule = [
        //'nickName|昵称'  => 'require|max:25'
        'title|角色名称' => 'require',
        'rules|权限'   => 'require',
    ];

    /**
     * @param Query|Model $sql
     * @return Query|Model
     */
    public function indexQuery($sql)
    {
        if (!$this->isSuperManager()) {
            $sql->where('create_operator_id', $this->getAuthId());
        }
        return $sql;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function addData($data)
    {
        $data['create_operator_id'] = $this->getAuthId();
        return $data;
    }

    /**
     * @param $data
     * @return mixed|void
     * @throws DbException
     */
    public function editData($data)
    {
        $group = \app\common\model\AuthGroup::get($data['id']);
        if (empty($group)) {
            $this->returnFail('数据不存在');
        }
        if (!$this->isSuperManager() && $group->create_operator_id != $this->getAuthId()) {
            //不是超级管理员也不是创建者
            $this->returnFail('您没有权限修改此数据');
        }

        $data['rules'] = implode(',', $data['rules']);

        return $data;
    }

    /**
     * @throws DbException
     */
    public function getAll()
    {
        $model = new \app\common\model\AuthGroup();
        if ($this->isSuperManager()) {
            $data = $model->select();
        } else {
            $data = $model->where('id', 'in', function (Query $query) {
                $query->name('AuthGroupAccess')->where('uid', $this->getAuthId())->field('group_id');
            })->select();
        }
        $this->returnSuccess($data);
    }

    /**
     * 删除
     * @throws Exception
     */
    public function delete(Request $request)
    {
        $model = model($this->modelName);
        $id = $request->param('id');

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
                $this->returnFail('您没有权限删除此角色');
            }
            $count = AuthGroupAccess::where('group_id', $id)->count();
            if ($count > 0) {
                $this->returnFail('已有用户配置为此角色，无法删除');
            }
            $data->delete();
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
}
