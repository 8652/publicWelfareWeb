<?php
namespace app\index\controller;     //命名空间，也说明了文件所在的文件夹
use think\Controller;   // 引用数据库操作类
use app\common\model\message;
use think\Db;   // 引用数据库操作类

// Index既是类名，也是文件名，说明这个文件的名字为Index.php。
class MessageController extends Controller
{
    public function index()
    {
    	$message = new Message; 
        $test = $message->getData();
    }

    //增删改查之
    public function add()
    {
    	        // 接收传入数据
        $postData = $this->request->post();    

        // 实例化volunteer空对象
        $Message = new Message;
        
        //赋值
        $array = [
            "M_Number" => $postData['M_Number'],
            "M_Approval" => $postData['M_Approval'],
            "M_Contant" => $postData['M_Contant'],
            "M_ReleaseDate" => $postData['M_ReleaseDate'],
            "V_Number" => $postData['V_Number'],
        ];
        
        // 新增对象至数据表
        $Message->addData($array);

        // 反馈结果
        return  '新增成功。新增ID为:' . $Message->id;
    }

    public function delete()
    {
    	// 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // “/d”表示将数值转化为“整形”

        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到ID信息');
        }

        // 获取要删除的对象
        $Message = Message::get($id);

        // 要删除的对象不存在
        if (is_null($Message)) {
            return $this->error('不存在id' . $id . '删除失败');
        }

        // 删除对象
        if (!$Message->delete()) {
            return $this->error('删除失败:' . $Message->getError());
        }

        // 进行跳转
        return $this->success('删除成功', url('index'));
    }

    public function edit()
    {
    	$test = Db::name('Message')->select();
    }

    public function find()
    {
    	$test = Db::name('Message')->select();
    }
}