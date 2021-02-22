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
        'text'     => '<v-col cols="12" lg="3"><l-input dense v-model="searchData.{{name}}" :rules="rules.{{name}}" label="{{label}}"></l-input></v-col>',
        'number'   => '<v-col cols="12" lg="3"><l-input dense type="number" v-model="searchData.{{name}}" :rules="rules.{{name}}" label="{{label}}"></l-input></v-col>',
        'select'   => '<v-col cols="12" lg="3"><l-select dense label="select" v-model="searchData.{{name}}" :items="{{name}}List"></l-select></v-col>',
        'date'     => '<v-col cols="12" lg="3"><l-date v-model="searchData.{{name}}" label="{{label}}"></l-date></v-col>',
        'datetime' => '<v-col cols="12" lg="3"><l-date-time v-model="searchData.{{name}}" label="{{label}}"></l-date-time></v-col>',
        'textarea' => '<v-col cols="12" lg="3"><v-textarea v-model="searchData.{{name}}" label="{{label}}" solo rows="3" auto-grow></v-textarea></v-col>',
    ],
    'yapi' => [
        'domain' => '', //yapi域名
        'token' => '', //项目token,
    ],
];
