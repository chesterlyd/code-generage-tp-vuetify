<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    use SoftDelete;
    protected $type = [
    ];

    protected $hidden = [
        'password',
    ];

    // 自动维护时间戳
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    /**
     * 获取指定id的下级id
     * @param $id
     * @param bool $self
     * @return array
     */
    public static function getChildrenIds($id, $self = true)
    {
        $cacheName = 'Admin:childrenIds:' . $id;
        $ids = \think\facade\Cache::get($cacheName);
        if (!empty($ids)) {
            return $ids;
        }

        if (!is_array($id)) {
            $id = [$id];
        }
        if ($self) {
            $ids = $id;
        } else {
            $ids = [];
        }
        do {
            $id = self::cache(true, 0, 'Admin_cache_data')->where('create_operator_id', 'in', $id)->column('id');
            $ids = array_merge($ids, $id);
        } while (!empty($id));
        $ids = array_unique($ids);
        \think\facade\Cache::tag('Admin_cache_data')->set($cacheName, $ids, 0);
        return $ids;
    }

    public function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    public function authgroup()
    {
        return $this->belongsToMany(AuthGroup::class, 'auth_group_access', 'group_id', 'uid');
    }
}
