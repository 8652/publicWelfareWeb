<?php
namespace app\index\controller;     //命名空间，也说明了文件所在的文件夹
use app\common\model\activity;
use think\Controller;

//既是类名，也是文件名，说明这个文件的名字为Index.php。
class AdminController extends Controller
{
    public function index()
    {
    	$activity = new Activity; 
        $test = $activity->getData();
        $this->assign('activitys', $test);
        $session = new Session();
        $user = $session->get('name');
        $this->assign('user', $user);
        return $this->fetch();
    }
        //增删改查之
    public function add()
    {
        // 接收传入数据
        $postData = $this->request->post();    

        // 实例化volunteer空对象
        $Admin = new Admin;
        
        //赋值
        $array = [
            "A_Number" => $postData['A_Number'],
            "A_Password" => $postData['A_Password'],
            "A_Name" => $postData['A_Name'],
            "A_Sex" => $postData['A_Sex'],
            "A_BornDate" => $postData['A_BornDate'],
            "A_Address" => $postData['A_Address'],
            "A_Telephone" => $postData['A_Telephone'],
            "A_Email" => $postData['A_Email'],
            "A_Marriage" => $postData['A_Marriage'],
            "A_PoliticsVisage" => $postData['A_PoliticsVisage'],
            "A_SchoolAge" => $postData['A_SchoolAge'],
        ];
        
        // 新增对象至数据表
        $Admin->addData($array);

        // 反馈结果
        return  '新增成功。新增ID为:' . $Admin->id;
    }

    public function delete()
    {
    	// 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // “/d”表示将数值转化为“整形”

        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到ID信息');
        }

        // 获取要删除的对象
        $Admin = Admin::get($id);

        // 要删除的对象不存在
        if (is_null($Admin)) {
            return $this->error('不存在id' . $id . '删除失败');
        }

        // 删除对象
        if (!$Admin->delete()) {
            return $this->error('删除失败:' . $Admin->getError());
        }

        // 进行跳转
        return $this->success('删除成功', url('index'));
    }

    public function edit()
    {
    	// 获取传入ID
        $id = Request::instance()->param('id/d');

        // 在Admin表模型中获取当前记录
        if (is_null($Admin = Admin::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        } 
        
        // 将数据传给V层
        $this->assign('Admin', $Admin);

        // 获取封装好的V层内容
        $htmls = $this->fetch();

        // 将封装好的V层内容返回给用户
        return $htmls;
    }

    public function find()
    {
    	$test = Db::name('volunteer')->select();

        return $test;
    }

    public function makeSignUp()
    {
        //$test = Db::name('volunteer')->select();
        //dump($test); //获取数据表数据
    }

    public function makeMessage()
    {
        //$test = Db::name('volunteer')->select();
        //dump($test); //获取数据表数据
    }

    public function logOut()
    {
        $session = new Session();
        $session->set('name', null);
        $session->set('sponsorId', null);
        $session->set('volunteerId', null);
        $session->set('adminId', null);

        return $this->success('成功退出！', url('../index'));
    }
}
