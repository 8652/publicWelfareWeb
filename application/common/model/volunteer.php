<?php
//namespace说明了该文件位于application\common\model 文件夹中
namespace app\common\model;
use think\Model;    //  导入think\Model类
use think\Db;   // 引用数据库操作类


class volunteer extends Model
{

    protected $_validate = array (  
    array('V_Number', 'require', '编号不能为空！', 1, '', 3),  
    array('V_Password', 'require', '密码不能为空！', 1, '', 3),  
    array('V_Name', 'require', '姓名不能为空！', 1, '', 1),  
    array('V_Sex', 'require', '性别不能为空！', 1, '', 3),  
    array('V_BornDate', 'require', '出生日期不能为空！', 1, '', 3),  
    array('V_Address', 'require', '地址不能为空！', 1, '', 1),  
    array('V_Telephone', 'number', '电话号码格式不正确！', 1, '', 1),  
    array('V_Email', 'email', '邮件地址格式不正确！', 1, '', 1),  
    array('V_Code', 'number', '邮编格式不正确！', 1, '', 1),
    );
    /**
     * 添加数据
     * @param    array    $data    数据
     * @return   integer           新增数据的id
    */

    public function getId() {
        $sql = "SELECT * FROM `volunteer` ORDER BY `V_Number`  DESC";
        $id = Db::table('Volunteer')->order('V_Number desc')->select();
        if(empty($id)) {
            return 1;
        }
        return ((int)$id[0]['V_Number'])+1;
    }

    public function addData($data)
    {
        $id = Db::table('Volunteer')->insertGetId($data);
        //insertGetId 方法添加成功，返回插入数据的自增id值
        return $id;
    }

    /**
     * 删除数据
     * @param    integer    $data    删除数据的id
     * @return   bool                操作成功
    */
    public function deleteData($id)
    {
        Db::table('Volunteer')->where('V_Number',$id)->delete(); 
        return "成功删除";
    }

    /**
     * 修改数据
     * @param    integer    $id      修改数据的id
     * @param    array      $data    修改的数据数组
     * @return   bool                操作成功
    */
    public function editData($id, $data)
    {
        foreach ($data as $key => $value) {
            if($key != 'V_Number') {
                db('Volunteer')->where('V_Number', $id)->update([$key => $value]);
            }
        }
        return "修改成功";

        /**
         * 更新数据表中的数据
         * db('user')->where('id',1)->update(['name' => 'thinkphp']);
         *  更新某个字段的值
         * db('user')->where('id',1)->setField('name','thinkphp');
         * setField 方法，仅用于更新某一个字段
         *  自增 score 字段
         * db('user')->where('id', 1)->setInc('score');
         * setInc 方法，参数1：是要自增的字段名，参数2[可省略]，默认为1，是每次自增的数目，特别书用于网站点击量啥的
         *  自减 score 字段
         * db('user')->where('id', 1)->setDec('score');
         * setDec 方法，参数1：是要自减的字段名，参数2[可省略]，默认为1，是每次自减的数目，特别适用于商品库存啥的
         */
    }

    /**
     * 修改数据
     * @param    null    $name      
     * @return    array   $test    数据数组
    */
    public function getData($name = NULL)
    {
        $test = Db::name('volunteer')->select();
        return $test;
    }

    public function getDataByTag($map)
    {
        foreach ($map as $key => $value) {
            $data = db('Volunteer')->where($key, $value)->select();
        }
        return $data;
    }
}