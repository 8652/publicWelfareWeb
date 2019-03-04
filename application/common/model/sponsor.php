<?php
//namespace说明了该文件位于application\common\model 文件夹中
namespace app\common\model;
use think\Model;    //  导入think\Model类
use think\Db;   // 引用数据库操作类
/**
 * Teacher 教师表
 */
  
// 我的类名叫做Teacher，对应的文件名为Teacher.php，该类继承了Model类，Model我们在文件头中，提前使用use进行了导入。
class Sponsor extends Model
{
    /**
     * 添加数据
     * @param    array    $data    数据
     * @return   integer           新增数据的id
    */
    public function getId() {
        $id = Db::table('Sponsor')->order('S_Number desc')->select();
        if(empty($id)) {
            return 1;
        }
        return ((int)$id[0]['S_Number'])+1;
    }

    public function addData($data)
    {
        $id = Db::table('Sponsor')->insertGetId($data);
        //insertGetId 方法添加成功，返回插入数据的自增id值
        return $id;
    }

    public function deleteData($id)
    {
        Db::table('Sponsor')->where('S_Number',$id)->delete(); 
        return "succeed";
    }

    public function editData($id, $data)
    {
        foreach ($data as $key => $value) {
            if($key != 'S_Number') {
                db('Sponsor')->where('S_Number', $id)->update([$key => $value]);
            }
        }

        return "修改成功";
        // 更新数据表中的数据
        //db('user')->where('id',1)->update(['name' => 'thinkphp']);

        // 更新某个字段的值
        //db('user')->where('id',1)->setField('name','thinkphp');
        //setField 方法，仅用于更新某一个字段
        // 自增 score 字段
        //db('user')->where('id', 1)->setInc('score');
        //setInc 方法，参数1：是要自增的字段名，参数2[可省略]，默认为1，是每次自增的数目，特别书用于网站点击量啥的
        // 自减 score 字段
        //db('user')->where('id', 1)->setDec('score');
        //setDec 方法，参数1：是要自减的字段名，参数2[可省略]，默认为1，是每次自减的数目，特别适用于商品库存啥的
    }

    public function getData($name = NULL)
    {
        $test = Db::name('Sponsor')->select();
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