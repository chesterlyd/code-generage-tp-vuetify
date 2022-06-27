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
        'text'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input v-model="formData.{{name}}" placeholder="请输入{{label}}" clearable></el-input></el-form-item>',
        'number'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input-number v-model="formData.{{name}}" :min="0" clearable></el-input-number></el-form-item>',
        'select'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><v-select v-model="formData.{{name}}" placeholder="请选择"></v-select></el-form-item>',
        'uploadImage' => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><v-upload max="1" v-model="formData.{{name}}" type="image"></v-upload></el-form-item>',
        'uploadVideo' => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><v-upload max="1" v-model="formData.{{name}}" type="video"></v-upload></el-form-item>',
        'upload'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><v-upload max="1" v-model="formData.{{name}}" type="file"></v-upload></el-form-item>',
        'ueditor'     => '<el-form-item class="el-form-item editor" label="{{label}}" prop="{{name}}"><v-editor v-model="formData.{{name}}"></v-editor></el-form-item>',
        'date'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="formData.{{name}}" type="date" placeholder="选择日期" value-format="YYYY-MM-DD"></el-date-picker></el-form-item>',
        'datetime'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="formData.{{name}}" type="datetime" placeholder="选择日期时间" value-format="YYYY-MM-DD hh:mm:ss"></el-date-picker></el-form-item>',
        'textarea'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input type="textarea" :rows="2" placeholder="请输入内容" v-model="formData.{{name}}"></el-input></el-form-item>',
        'radio'       => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><v-radio v-model="formData.{{name}}" dict=""></v-radio></el-form-item>',
        'checkbox'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><v-checkbox v-model="formData.{{name}}" dict=""></v-checkbox></el-form-item>',
        'switch'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-switch v-model="formData.{{name}}" :active-value="1" :inactive-value="2" active-text="开" inactive-text="关"></el-switch></el-form-item>',
    ],
    /*
     * 搜索字段模板，指定使用以下占位符
     * {{name}}{{label}}{{value}}
     */
    'search' => [
        'text'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input prefix-icon="search" v-model="search.{{name}}" autocomplete="off" placeholder="请输入" clearable></el-input></el-form-item>',
        'number'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input type="number" prefix-icon="search" v-model="search.{{name}}" autocomplete="off" placeholder="请输入数字" clearable></<el-input-number></el-form-item>',
        'select'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><v-select v-model="search.{{name}}" placeholder="请选择" dict="" clearable filterable></v-select></el-form-item>',
        'date'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="search.{{name}}" type="date" placeholder="选择日期" value-format="yyyy-MM-dd" clearable></el-date-picker></el-form-item>',
        'datetime'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="search.{{name}}" type="datetime" placeholder="选择日期时间" value-format="yyyy-MM-dd HH:mm:ss" clearable></el-date-picker></el-form-item>',
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
