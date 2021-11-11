<?php

return [
    'success_code'          => 1, //成功返回的code值
    'error_code'            => 0, //失败返回的code值
    'back_base_controller'  => 'Signin', //后台控制器基类，为空则使用\think\Controller
    'front_base_controller' => '', //前台无需登录的控制器基类,为空则使用\think\Controller
    'front_sign_controller' => 'SignIn', //前台带登录验证的控制器基类,为空则使用front_base_controller的值
    'index_template'        => '', //列表页模板，为空则使用默认
    'add_template'          => '', //添加页模板，为空则使用默认
    'edit_template'         => '', //修改页模板，为空则使用默认
    /*
     * form表单字段模板，指定使用以下占位符
     * {{name}}{{label}}{{value}}{{attr}}
     */
    'form' => [
        'text'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input v-model="formData.{{name}}" clearable></el-input></el-form-item>',
        'number'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><<el-input-number v-model="formData.{{name}}"  :min="0" clearable></<el-input-number></el-form-item>',
        'select'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-select v-model="formData.{{name}}" placeholder="请选择"><el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option></el-select></el-form-item>',
        'uploadImage' => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><v-upload v-model="formData.{{name}}"></v-upload></el-form-item>',
        'ueditor'     => '<el-form-item class="el-form-item editor" label="{{label}}" prop="{{name}}"><v-editor v-model="formData.{{name}}"></v-editor></el-form-item>',
        'date'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="formData.{{name}}" type="date" placeholder="选择日期"></el-date-picker></el-form-item>',
        'datetime'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="formData.{{name}}" type="datetime" placeholder="选择日期时间"></el-date-picker></el-form-item>',
        'textarea'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input type="textarea" :rows="2" placeholder="请输入内容" v-model="formData.{{name}}"></el-input></el-form-item>',
    ],
    /*
     * 搜索字段模板，指定使用以下占位符
     * {{name}}{{label}}{{value}}
     */
    'search' => [
        'text'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input v-model="search.{{name}}" clearable></el-input></el-form-item>',
        'number'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><<el-input-number v-model="search.{{name}}"  :min="0" clearable></<el-input-number></el-form-item>',
        'select'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-select v-model="search.{{name}}" placeholder="请选择"><el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option></el-select></el-form-item>',
        'date'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="search.{{name}}" type="date" placeholder="选择日期"></el-date-picker></el-form-item>',
        'datetime'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="search.{{name}}" type="datetime" placeholder="选择日期时间"></el-date-picker></el-form-item>',
        'textarea'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input type="textarea" :rows="2" placeholder="请输入内容" v-model="search.{{name}}"></el-input></el-form-item>',
    ],
    'yapi' => [
        'domain' => '', //yapi域名
        'token'  => '', //项目token,
    ],
    'tableColumn' => [
        'column' => '{title: "{{name}}", key: "{{field}}"},',
    ],
    'jwt_salt' => 'cYubwGpetWHBJQP2smdvzkKCKxa9Mu1z',
];
