<?php
//namespace说明了该文件位于application\common\model 文件夹中
namespace app\common\model;
use think\Model;    //  导入think\Model类
use think\Db;   // 引用数据库操作类

class Activity extends Model
{
    /**
     * 添加数据
     * @param    array    $data    数据
     * @return   integer           新增数据的id
    */

    //获得自增的注册ID
    public function getId() {
        //$sql = "SELECT * FROM `activity` ORDER BY `A_Number1`  DESC";
        $id = Db::table('activity')->order('A_Number1 desc')->select();
        if(empty($id)) {
            return 1;
        }
        return ((int)$id[0]['A_Number1'])+1;
    }

    //新建方法添加成功，返回插入数据的自增id值
    public function addData($data)
    {
        $id = Db::table('Activity')->insertGetId($data);
        return $id;
    }

    //删除方法
    public function deleteData($id)
    {
        Db::table('Activity')->where('A_Number1',$id)->delete(); 
        return "删除成功";
    }


    // 更新数据表中的数据
    public function editData($id, $data)
    {
        /*        $data = [
            "A_Number1" => $id,
            "A_Theme" => $postData['theme'],
            "A_Namet" => $postData['namet'],
            "A_Meaning" => $postData['meaning'],
            "A_Purpose" => $postData['purpose'],
            "A_Object" => $postData['object'],
            "A_Time" => $postData['ddl'],
            "A_Place" => $postData['place'],
            "A_Organizer" => $postData['organizer'],
            "A_Prepare" => $postData['prepare'],
            "A_Pay" => $postData['warning'],
            "A_Budget" => $postData['budget'],
            "S_Number" => (int)0,
            "C_Comment" => (int)-1,
        ];*/
        db('Activity')->where('A_Number1',$id)->update(['A_Theme' => $data['A_Theme']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Namet' => $data['A_Namet']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Meaning' => $data['A_Meaning']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Purpose' => $data['A_Purpose']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Object' => $data['A_Object']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Time' => $data['A_Time']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Place' => $data['A_Place']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Organizer' => $data['A_Organizer']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Prepare' => $data['A_Prepare']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Pay' => $data['A_Pay']]);
        db('Activity')->where('A_Number1',$id)->update(['A_Budget' => $data['A_Budget']]); 
    }

    public function getData($name = NULL)
    {
        $test = Db::name('Activity')->select();
        return $test;
    }

    //查询
    public function getDataByTag($map)
    {
        foreach ($map as $key => $value) {
            $data = db('Activity')->where($key, $value)->select();
        }
        return $data;
    }
}