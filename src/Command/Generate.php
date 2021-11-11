<?php

namespace Generate\Command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\facade\Env;

class Generate extends Command
{
    protected function configure()
    {
        $this->setName('generate')->setDescription('open code generator');
    }

    protected function execute(Input $input, Output $output)
    {
        //询问是否需要其他功能
        /*if (function_exists('system')) {
            $needPay = $output->confirm($input, 'Do you need payment in your project?', false);
            if ($needPay) {
                system('composer require hxc/qt-pay');
                $output->writeln('---------------------------------------');
                $output->writeln('Payment function has been introduced, please check the documentation for detailed usage.');
            }
            $needSms = $output->confirm($input, 'Do you need SMS in your project?', false);
            if ($needSms) {
                system('composer require hxc/qt-sms');
                $output->writeln('---------------------------------------');
                $output->writeln('SMS has been introduced, please see the documentation for detailed usage.');
            }
            $needQueue = $output->confirm($input, 'Do you need the queue in your project?', false);
            if ($needQueue) {
                system('composer require topthink/think-queue:~2.0');
                $output->writeln('---------------------------------------');
                $output->writeln('Queue function has been introduced, please see the documentation for detailed usage.');
            }
        } else {
            $output->writeln('---------------------------------------');
            $output->writeln('The system function has been disabled, please execute the following code according to your project needs:');
            $output->writeln('payment：composer require hxc/qt-pay');
            $output->writeln('sms：composer require hxc/qt-sms');
            $output->writeln('queue：composer require topthink/think-queue:~1.0');
        }*/
        $doc = '这是代码生成器所需文件。';

        file_put_contents(Env::get('root_path') . 'generate.lock', $doc);
        $output->writeln('---------------------------------------');
        $output->writeln('Code generation tool url：/generate');
        $targetPath = Env::get('root_path') . 'config/';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        if (file_exists($targetPath . 'curd.php')) {
            //配置文件已存在
            $file = realpath(__DIR__ . '/../config.php');
            $output->writeln('---------------------------------------');
            $output->warning('The configuration file(' . realpath($targetPath . 'curd.php') . ') already exists. Please check ' . $file . ' to confirm if it is updated.');
        } else {
            copy(__DIR__ . '/../config.php', $targetPath . 'curd.php');
        }
        if (!file_exists(Env::get('root_path') . '/env.php')) {
            file_put_contents(Env::get('root_path') . '/env.php', "<?php\nreturn [\n    'view_root' => '',\n    'api_token' => '',\n    'api_uri' => ''\n];");
        }

        $sql = "
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `account` varchar(128) NOT NULL COMMENT '账号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `is_disable` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '是否禁用',
  `create_operator_id` int(11) NOT NULL DEFAULT '',
  `super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建日期',
  `update_time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `accountUnique` (`account`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
 DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `name` char(80) NOT NULL DEFAULT '',
    `title` char(20) NOT NULL DEFAULT '',
    `type` tinyint(1) NOT NULL DEFAULT '1',
    `status` tinyint(1) NOT NULL DEFAULT '1',
    `condition` char(100) NOT NULL DEFAULT '',  # 规则附件条件,满足附加条件的规则,才认为是有效的规则
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4;

 DROP TABLE IF EXISTS `auth_group`;
CREATE TABLE `auth_group` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `title` char(100) NOT NULL DEFAULT '',
    `status` tinyint(1) NOT NULL DEFAULT '1',
    `rules` char(80) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8mb4;

INSERT INTO `auth_group` VALUES ('1', '默认分组', '1', '1');

DROP TABLE IF EXISTS `auth_group_access`;
CREATE TABLE `auth_group_access` (
    `uid` mediumint(8) unsigned NOT NULL,
    `group_id` mediumint(8) unsigned NOT NULL,
    UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
    KEY `uid` (`uid`),
    KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

INSERT INTO `auth_group_access` VALUES ('1', '1');
";

        Db::execute($sql);

        $appControllerPath = Env::get('app_path') . 'app/controller/';

        if (!$appControllerPath) {
            $this->createPath($appControllerPath);

            copy(__DIR__ . '/../Templates/app/controller/SignIn.php', $appControllerPath . 'SignIn.php');
        }
        $adminControllerPath = Env::get('app_path') . 'admin/controller/';
        if (!$adminControllerPath) {
            $this->createPath($adminControllerPath);

            copy(__DIR__ . '/../Templates/admin/controller/Admin.php', $adminControllerPath . 'Admin.php');
            copy(__DIR__ . '/../Templates/admin/controller/AuthGroup.php', $adminControllerPath . 'AuthGroup.php');
            copy(__DIR__ . '/../Templates/admin/controller/AuthGroupAccess.php', $adminControllerPath . 'AuthGroupAccess.php');
            copy(__DIR__ . '/../Templates/admin/controller/AuthRule.php', $adminControllerPath . 'AuthRule.php');
            copy(__DIR__ . '/../Templates/admin/controller/Base.php', $adminControllerPath . 'Base.php');
            copy(__DIR__ . '/../Templates/admin/controller/Login.php', $adminControllerPath . 'Login.php');
            copy(__DIR__ . '/../Templates/admin/controller/Signin.php', $adminControllerPath . 'Signin.php');
        }
        $commonPath = Env::get('app_path') . 'common/';
        if (!$commonPath) {
            $this->createPath($commonPath);
            $this->createPath($commonPath . 'model/');
            $this->createPath($commonPath . 'library/');

            copy(__DIR__ . '/../Templates/common/model/Admin.php', $commonPath . 'model/Admin.php');
            copy(__DIR__ . '/../Templates/common/model/AuthGroup.php', $commonPath . 'model/AuthGroup.php');
            copy(__DIR__ . '/../Templates/common/model/AuthGroupAccess.php', $commonPath . 'model/AuthGroupAccess.php');
            copy(__DIR__ . '/../Templates/common/model/AuthRule.php', $commonPath . 'model/AuthRule.php');
            copy(__DIR__ . '/../Templates/common/library/Auth.php', $commonPath . 'library/Auth.php');
        }

        file_put_contents(Env::get('app_path') . 'common.php', "use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use think\exception\HttpResponseException;

function verifyToken($authorization)
{
    $key = \think\facade\Config::get('curd.jwt_salt');
    try {
        JWT::decode($authorization, new Key($key, 'HS256')); //解密jwt
    } catch (\Firebase\JWT\ExpiredException $e) {
        $data = [
            'code' => -1,
            'msg' => '重新登录'
        ];
        throw new HttpResponseException(json($data));
    } catch (\Exception $e) {
        $data = [
            'code' => 0,
            'msg' => $e->getMessage()
        ];
        throw new HttpResponseException(json($data));
    }

    return true;
}", FILE_APPEND);
    }

    /**
     * 创建目录
     * @param $path
     */
    private function createPath($path)
    {
        if (file_exists($path)) {
            return;
        }
        mkdir($path, 0777, true);
    }
}
