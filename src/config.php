<?php

return [
    'success_code' => 1, //成功返回的code值
    'error_code' => 0, //失败返回的code值
    'back_base_controller' => 'Signin', //后台控制器基类，为空则使用\think\Controller
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
        'text'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input v-model="formData.{{name}}" clearable></el-input></el-form-item>',
        'number'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><<el-input-number v-model="formData.{{name}}"  :min="0" clearable></<el-input-number></el-form-item>',
        'select'      => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-select v-model="formData.{{name}}" placeholder="请选择"><el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option></el-select></el-form-item>',
        'uploadImage' => '<l-upload :uploadAction="path+\'/admin/tools/uploadImage\'" v-model="formData.{{name}}" multiple :max-length="3"></l-upload>',
        'ueditor'     => '<l-editor v-model="formData.{{name}}" :uploadAction="path+\'/admin/tools/uploadImage\'"></l-editor>',
        'date'        => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="formData.{{name}}" type="date" placeholder="选择日期"></el-date-picker></el-form-item>',
        'datetime'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-date-picker v-model="formData.{{name}}" type="datetime" placeholder="选择日期时间"></el-date-picker></el-form-item>',
        'textarea'    => '<el-form-item class="el-form-item input" label="{{label}}" prop="{{name}}"><el-input type="textarea" :rows="2" placeholder="请输入内容" v-model="formData.{{name}}"></el-input></el-form-item>',
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
    'tableColumn' => [
        'column' => '<el-table-column label="tableColumn.{{name}}" prop="tableColumn.{{field}}"></el-table-column>'
    ]
];
