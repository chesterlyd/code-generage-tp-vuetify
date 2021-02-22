<?php

return [
    'success_code' => 1, //成功返回的code值
    'error_code' => 0, //失败返回的code值
    'back_base_controller' => 'Right', //后台控制器基类，为空则使用\think\Controller
    'front_base_controller' => '', //前台无需登录的控制器基类,为空则使用\think\Controller
    'front_sign_controller' => 'SignIn', //前台带登录验证的控制器基类,为空则使用front_base_controller的值
    'index_template' => '', //列表页模板，为空则使用默认
    'add_template' => '', //添加页模板，为空则使用默认
    'edit_template' => '', //修改页模板，为空则使用默认
    /*
     * form表单字段模板，指定使用以下占位符
     * {{name}}{{label}}{{value}}{{attr}}
     */
    'form' => [
        'text'        => '<l-input dense v-model="formData.{{name}}" :rules="\'rules.\'+formData.{{name}}" label="{{label}}"></l-input>',
        'number'      => '<l-input dense type="number" v-model="formData.{{name}}" :rules="\'rules.\'+formData.{{name}}" label="{{label}}"></l-input>',
        'select'      => '<l-select dense label="select" v-model="formData.{{name}}" :items="{{name}}List"></l-select>',
        'uploadImage' => '<l-upload :uploadAction="path+\'/admin/tools/uploadImage\'" v-model="formData.{{name}}" multiple :max-length="3"></l-upload>',
        'ueditor'     => '<l-editor v-model="formData.{{name}}" :uploadAction="path+\'/admin/tools/uploadImage\'"></l-editor>',
        'date'        => '<l-date v-model="formData.{{name}}" label="{{label}}"></l-date>',
        'datetime'    => '<l-date-time v-model="formData.{{name}}" label="{{label}}"></l-date-time>',
        'textarea'    => '<v-textarea v-model="formData.{{name}}" label="{{label}}" solo rows="3" auto-grow></v-textarea>',
    ],
    /*
     * 搜索字段模板，指定使用以下占位符
     * {{name}}{{label}}{{value}}
     */
    'search' => [
        'text'     => '<l-input dense v-model="formData.{{name}}" :rules="\'rules.\'+formData.{{name}}" label="{{label}}"></l-input>',
        'number'   => '<l-input dense type="number" v-model="formData.{{name}}" :rules="\'rules.\'+formData.{{name}}" label="{{label}}"></l-input>',
        'select'   => '<l-select dense label="select" v-model="formData.{{name}}" :items="{{name}}List"></l-select>',
        'date'     => '<l-date v-model="formData.{{name}}" label="{{label}}"></l-date>',
        'datetime' => '<l-date-time v-model="formData.{{name}}" label="{{label}}"></l-date-time>',
        'textarea' => '<v-textarea v-model="formData.{{name}}" label="{{label}}" solo rows="3" auto-grow></v-textarea>',
    ],
    'yapi' => [
        'domain' => '', //yapi域名
        'token' => '', //项目token,
    ],
];
