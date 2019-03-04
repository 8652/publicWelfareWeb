<?php
// 简单的原理重复记： namespace说明了该文件位于application\common\model 文件夹中
namespace app\common\model;
use think\Model;    //  导入think\Model类
use think\Db;   // 引用数据库操作类
/**
 * Teacher 教师表
 */

class admin extends Model
{
	public function addData($data)
    {
        $id = Db::table('Admin')->insertGetId($data);
        //insertGetId 方法添加成功，返回插入数据的自增id值
        return $id;
    }

    public function deleteData($id)
    {
        Db::table('Admin')->where('id',$id)->delete(); 
        return ture;
    }

    public function editData($id, $data)
    {
        // 更新数据表中的数据
        db('Admin')->where('id',1)->update(['name' => 'thinkphp']);

        // 更新某个字段的值
        db('Admin')->where('id',1)->setField('name','thinkphp');
        //setField 方法，仅用于更新某一个字段
        // 自增 score 字段
        db('Admin')->where('id', 1)->setInc('score');
        //setInc 方法，参数1：是要自增的字段名，参数2[可省略]，默认为1，是每次自增的数目，特别书用于网站点击量啥的
        // 自减 score 字段
        db('Admin')->where('id', 1)->setDec('score');
        //setDec 方法，参数1：是要自减的字段名，参数2[可省略]，默认为1，是每次自减的数目，特别适用于商品库存啥的
    }

    public function getData($name = NULL)
    {
        $test = Db::name('Admin')->select();
        return $test;
    }

    public function getDataByTag($map)
    {
        foreach ($map as $key => $value) {
        	$data = db('Admin')->where('A_Number', (int)$value)->select();
        }
        return $data;
    }
}