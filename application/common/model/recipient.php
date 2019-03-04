<?php
//namespace说明了该文件位于application\common\model 文件夹中
namespace app\common\model;
use think\Model;    //  导入think\Model类
use think\Db;   // 引用数据库操作类
/**
 * Teacher 教师表
 */
  
// 我的类名叫做Teacher，对应的文件名为Teacher.php，该类继承了Model类，Model我们在文件头中，提前使用use进行了导入。
class Recipient extends Model
{
    /**
     * 添加数据
     * @param    array    $data    数据
     * @return   integer           新增数据的id
    */

    public function getId() {
        $id = Db::table('Recipient')->order('R_Number desc')->select();
        if(empty($id)) {
            return 1;
        }
        return ((int)$id[0]['R_Number'])+1;
    }

    public function addData($data)
    {
        $id = Db::table('Recipient')->insertGetId($data);
        //insertGetId 方法添加成功，返回插入数据的自增id值
        return $id;
    }

    public function deleteData($id)
    {
        Db::table('Recipient')->where('R_Number',$id)->delete(); 
        return "succeed";
    }

    public function editData($id, $data)
    {
        foreach ($data as $key => $value) {
            if($key != 'R_Number') {
                db('Recipient')->where('R_Number', $id)->update([$key => $value]);
            }
        }
        return "修改成功";
    }

    public function getData($name = NULL)
    {
        $test = Db::name('Recipient')->select();
        return $test;
    }

    public function getDataByTag($map)
    {
        foreach ($map as $key => $value) {
            $data = db('Sponsor')->where($key, $value)->select();
        }
        return $data;
    }
}