<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Model;    //  导入think\Model类
use app\common\model\volunteer;
// 应用公共文件

function messageNotSuit($postData) {
        if ($postData['password'] != $postData['repassword']) {
            return '两次输入的密码不一致';
        }
        $data=array(
            "V_Number" => '1000',
            "V_Password" => $postData['password'],
            "V_Name" => $postData['name'],
            "V_Sex" => $postData['sex'],
            "V_BornDate" => $postData['bothday'],
            "V_Address" => $postData['address'],
            "V_Telephone" => $postData['phone'],
            "V_Email" => $postData['email'],
            "V_Code" => $postData['zipcode'],
            "V_Level" => '0',
            "A_Number" => '0',
            "V_Attendance" => '0',
            "V_Pass" => '1',
        );
        
        //var_dump($result);
        $User = new volunteer(); 
        $tempUser = $User->create($data);
        return $tempUser;
}

/**
 * http请求
 * @param  string  $url    请求地址
 * @param  boolean|string|array $params 请求数据
 * @param  integer $ispost 0/1，是否post
 * @param  array  $header
 * @param  $verify 是否验证ssl
 * return string|boolean          出错时返回false
 */
function http($url, $params = false, $ispost = 0, $header = [], $verify = false) {
    $httpInfo = array();
    $ch = curl_init();
    if(!empty($header)){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //忽略ssl证书
    if($verify === true){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    } else {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    if ($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
    } else {
        if (is_array($params)) {
            $params = http_build_query($params);
        }
        if ($params) {
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }
    $response = curl_exec($ch);
    if ($response === FALSE) {
        trace("cURL Error: " . curl_errno($ch) . ',' . curl_error($ch), 'error');
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        trace($httpInfo, 'error');
        return false;
    }
    curl_close($ch);
    return $response;
}
