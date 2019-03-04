<?php
namespace app\index\controller;
use app\common\model\admin;
use app\common\model\volunteer;
use app\common\model\sponsor; 
use think\Controller;
use think\Request;            
use think\Session;


class IndexController extends Controller
{
    // 用户登录表单
    public function index()
    {
        // 显示登录表单
        return $this->fetch();
    }

    // 处理用户提交的登录数据
    public function login()
    {
        // 接收post信息
        $request = new Request;
        $postData = $request->post();
        if(empty($postData['userType'])) {
            return $this->error('请选择登录的用户类型！', url('../index'));
        }
        $userType = $postData['userType'];
        if($userType == "1") {
            //验证用户名是否存在
            $map = array('A_Number'  => $postData['username']);
            $admin = new Admin;
            $result = $admin->getDataByTag($map);


            // $admin要么是一个对象，要么是null。
            if (!is_null($result) && count($result) && $result[0]['A_Password'] === $postData['password']) {
                // 用户名密码正确，跳转至activity管理界面
                $session = new Session();
                $session->set('adminId',$result[0]['A_Number']);
                $session->set('name',$result[0]['A_Name']);
                return $this->success('登陆成功！', url('activity/index'));
            } else {
                // 用户名不存在，跳转到登录界面。
                return $this->error('用户名或密码不存在！', url('../index'));
            }
        } else if($userType == "2") {
            //验证用户名是否存在
            $map = array('V_Name'  => $postData['username']);
            $volunteer = new Volunteer;
            $result = $volunteer->getDataByTag($map);

            // $admin要么是一个对象，要么是null。
            if (!is_null($result) && count($result) && $result[0]['V_Password'] === $postData['password']) {
                // 用户名密码正确，跳转至activity管理界面
                $session = new Session();
                $session->set('volunteerId',$result[0]['V_Number']);
                $session->set('name', $result[0]['V_Name']);
                return $this->success('登陆成功！', url('activity/indexV'));
            } else {
                // 用户名不存在，跳转到登录界面。
                return $this->error('用户名或密码不存在！', url('../index'));
            }
        } else if($userType == "3") {
            //验证用户名是否存在
            $map = array('S_Name'  => $postData['username']);
            $sponsor = new Sponsor;
            $result = $sponsor->getDataByTag($map);


            // $admin要么是一个对象，要么是null。
            if (!is_null($result) && count($result) && $result[0]['S_Password'] === $postData['password']) {
                // 用户名密码正确，跳转至activity管理界面
                $session = new Session();
                $session->set('sponsorId',$result[0]['S_Number']);
                $session->set('name', $result[0]['S_Name']);
                return $this->success('登陆成功！', url('activity/indexS'));
            } else {
                // 用户名不存在，跳转到登录界面。
                return $this->error('用户名或密码不存在！', url('../index'));
            }
        } else {
            return $this->error('请选择登录的用户类型！', url('../index'));
        }
        return 'login';
    }
}
