<?php
namespace app\index\controller;     //命名空间，也说明了文件所在的文件夹
use think\Controller;   // 引用数据库操作类
use app\common\model\recipient;
use think\Db;   // 引用数据库操作类
use think\Session;
use think\Request;

// Index既是类名，也是文件名，说明这个文件的名字为Index.php。
class RecipientController extends Controller
{
    public function index()
    {
    	$recipient = new Recipient; 
        $test = $recipient->getData();
    }

    public function manage()
    {
        $recipient = new Recipient; 
        $data = $recipient->getData();
        $session = new Session();
        $user = $session->get('name');
        // 向V层传数据
        $this->assign('user', $user);
        $this->assign('recipients', $data);
        return $this->fetch();
    }

    //增删改查之
    public function add()
    {
        return $this->fetch();
    }

    public function addNew()
    {

        //$this->redirect('News/category', ['cate_id' => 2]);
        // 接收post信息
        $request = new Request;
        $postData = $request->post();

        // 实例化recipient空对象
        $recipient = new Recipient;
        
        $error = "";
        //赋值
        if(empty($postData['R_BornDate'])) {
            $error = "请输入yyyy-mm-dd格式的日期！";
        } else   if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $postData['R_BornDate'], $parts))
        {
            //检测是否为日期
            if(checkdate($parts[2],$parts[3],$parts[1]))
                $error = "";
            else
                $error = "请输入yyyy-mm-dd格式的日期！";
        }
        else $error = "请输入yyyy-mm-dd格式的日期！";

        if(empty($postData['R_Name'])) {
            $error = "姓名不能为空！";
        }else if(empty($postData['R_Sex'])) {
            $error = "性别不能为空！";
        } else if(empty($postData['R_BornDate'])) {
            $error = "出生日期不能为空！";
        } else if(empty($postData['R_Address'])) {
            $error = "住址不能为空！";
        } else if(empty($postData['R_Telephone'])) {
            $error = "联系电话不能为空！";
        } else if(empty($postData['R_Email'])) {
            $error = "电子邮箱不能为空！";
        } else if(empty($postData['R_Code'])) {
            $error = "邮政编码不能为空！";
        } else if(empty($postData['R_Situation'])) {
            $error = "家庭情况不能为空！";
        } else if(!is_numeric($postData['S_Number'])&&$postData['S_Number']!='0') {
            $error = "赞助商编号格式错误！";
        }
        if ($postData['R_Sex']!= '男' and $postData['R_Sex']!='女') {
            $error = "请输入正确的性别格式！";
        }
        if($error != "") {
            return $this->error($error, url('/index/recipient/add'));
        }
        
        $data = [
            "R_Name" => $postData['R_Name'],
            "R_Sex" => $postData['R_Sex'],
            "R_BornDate" => $postData['R_BornDate'],
            "R_Telephone" => $postData['R_Telephone'],
            "R_Address" => $postData['R_Address'],
            "R_Email" => $postData['R_Email'],
            "R_Code" => $postData['R_Code'],
            "S_Number" => $postData['S_Number'],
            "R_Situation" => $postData['R_Situation'],
        ];

        if($postData['R_Sex'] == '男') {
            $data["R_Sex"] = (int)1;
        } else if ($postData['R_Sex'] == '女') {
            $data["R_Sex"] = (int)0;
        }
        
        $popId = $recipient->getId();
        $data["R_Number"] = $popId;
        $res = $recipient->addData($data);
        return $this->success('修改成功', url('../showRecipient'));
    }

    public function delete($id)
    {
        $recipient = new Recipient;
        $recipient->deleteData($id);
        $this->redirect('../showRecipient');
    }

    public function edit($id)
    {
        $recipient = Db::name('Recipient')->where('R_Number', $id)->select()[0];
        /*
        $data = [
            "T_Number" => (int)1,
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
        ];
        */
        $this->assign('id', $id);
        $this->assign('R_Name', $recipient['R_Name']);
        $this->assign('R_Sex', $recipient['R_Sex']);
        $this->assign('R_BornDate', $recipient['R_BornDate']);
        $this->assign('R_Address', $recipient['R_Address']);
        $this->assign('R_Telephone', $recipient['R_Telephone']);
        $this->assign('R_Email', $recipient['R_Email']);
        $this->assign('R_Code', $recipient['R_Code']);
        $this->assign('R_Situation', $recipient['R_Situation']);
        $this->assign('S_Number', $recipient['S_Number']);
        return $this->fetch();
    }


    public  function editNew($id)
    {
        //$this->redirect('News/category', ['cate_id' => 2]);
        // 接收post信息
        $request = new Request;
        $postData = $request->post();

        // 实例化recipient空对象
        $recipient = new Recipient;
        
        $error = "";
        //赋值

        if(empty($postData['R_BornDate'])) {
            $error = "请输入yyyy-mm-dd格式的日期！";
        } else   if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $postData['R_BornDate'], $parts))
        {
            //检测是否为日期
            if(checkdate($parts[2],$parts[3],$parts[1]))
                $error = "";
            else
                $error = "请输入yyyy-mm-dd格式的日期！";
        }
        else $error = "请输入yyyy-mm-dd格式的日期！";
         if(empty($postData['R_Name'])) {
            $error = "姓名不能为空！";
        }else if(empty($postData['R_Sex'])) {
            $error = "性别不能为空！";
        } else if(empty($postData['R_BornDate'])) {
            $error = "出生日期不能为空！";
        } else if(empty($postData['R_Address'])) {
            $error = "住址不能为空！";
        } else if(empty($postData['R_Telephone'])) {
            $error = "联系电话不能为空！";
        } else if(empty($postData['R_Email'])) {
            $error = "电子邮箱不能为空！";
        } else if(empty($postData['R_Code'])) {
            $error = "邮政编码不能为空！";
        } else if(empty($postData['R_Situation'])) {
            $error = "家庭情况不能为空！";
        } else if(!is_numeric($postData['S_Number'])&&$postData['S_Number']!='0') {
            $error = "赞助商编号格式错误！";
        }
        if ($postData['R_Sex']!= '男' and $postData['R_Sex']!='女') {
            $error = "请输入正确的性别格式！";
        }
        if($error != "") {
            return $this->error($error, url('/index/recipient/edit/id/'.$id), 1);
        }

        $data = [
            "R_Name" => $postData['R_Name'],
            "R_Sex" => $postData['R_Sex'],
            "R_BornDate" => $postData['R_BornDate'],
            "R_Telephone" => $postData['R_Telephone'],
            "R_Address" => $postData['R_Address'],
            "R_Email" => $postData['R_Email'],
            "R_Code" => $postData['R_Code'],
            "S_Number" => $postData['S_Number'],
            "R_Situation" => $postData['R_Situation'],
        ];
        
        if($postData['R_Sex'] == '男') {
            $data["R_Sex"] = (int)1;
        } else if ($postData['R_Sex'] == '女') {
            $data["R_Sex"] = (int)0;
        }
        $popId = $recipient->getId();
        $data["R_Number"] = $popId;
        $res = $recipient->editData($id, $data);
        return $this->success('修改成功', url('../showRecipient'));
    }

    public function find()
    {
    	$test = Db::name('Recipient')->select();
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