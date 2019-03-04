<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::rule('volunteerSignUp','volunteer/index');
Route::rule('sponsorSignUp','sponsor/index');
Route::rule('activity','activity/index');
Route::rule('training','training/index'); 
Route::rule('showVolunteer','volunteer/manage'); 
Route::rule('showSponsor','sponsor/manage'); 
Route::rule('showRecipient','recipient/manage'); 


return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    
    // 首页 定位到 Login控制器下的index触发器, 方法为get
    ''         => ['index/index', ['method' => 'get']],

    // logout 定位到 Login控制器下的logout控制器， 方法为get
    'logout'    => ['Login/logout', ['method' => 'get']],
];

return [

];
