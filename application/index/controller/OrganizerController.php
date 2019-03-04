<?php
namespace app\index\controller;     //命名空间，也说明了文件所在的文件夹
use think\Controller;   // 引用数据库操作类
use app\common\model\organizer;
use think\Db;   // 引用数据库操作类

// Index既是类名，也是文件名，说明这个文件的名字为Index.php。
class OrganizerController extends Controller
{
    public function index()
    {
    	$organizer = new Organizer; 
        $test = $organizer->getData();
        dump($test); //获取数据表数据
    }

    //增删改查之
    public function add()
    {
        // 接收传入数据
        $postData = $this->request->post();    

        // 实例化volunteer空对象
        $Organizer = new Organizer;
        
        //赋值
        $array = [
            "O_Number" => $postData['O_Number'],
            "O_Name" => $postData['O_Name'],
            "O_Address" => $postData['O_Address'],
            "O_Telephone" => $postData['O_Telephone'],
            "O_Email" => $postData['O_Email'],
            "O_Head" => $postData['O_Head'],
        ];
        
        // 新增对象至数据表
        $Organizer->addData($array);

        // 反馈结果
        return  '新增成功。新增ID为:' . $Organizer->id;
    }

    public function delete()
    {
    	// 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // “/d”表示将数值转化为“整形”

        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到ID信息');
        }

        // 获取要删除的对象
        $Organizer = Organizer::get($id);

        // 要删除的对象不存在
        if (is_null($Organizer)) {
            return $this->error('不存在id' . $id . '删除失败');
        }

        // 删除对象
        if (!$Organizer->delete()) {
            return $this->error('删除失败:' . $Organizer->getError());
        }

        // 进行跳转
        return $this->success('删除成功', url('index'));
    }

    public function edit()
    {
    	$test = Db::name('Organizer')->select();
        dump($test); //获取数据表数据
    }

    public function find()
    {
    	$test = Db::name('Organizer')->select();
        dump($test); //获取数据表数据
    }
}