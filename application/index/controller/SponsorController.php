<?php
namespace app\index\controller;     //命名空间，也说明了文件所在的文件夹
use think\Controller;   // 引用数据库操作类
use app\common\model\sponsor;
use think\Request;     
use think\Db;   // 引用数据库操作类
use think\Session;

// Index既是类名，也是文件名，说明这个文件的名字为Index.php。
class SponsorController extends Controller
{
    public function index()
    {
        $session = new Session();
        $user = $session->get('name');
        $this->assign('user', $user);
    	return $this->fetch();
    }

    public function manage()
    {
        $sponsor = new Sponsor; 
        $data = $sponsor->getData();
        $session = new Session();
        $user = $session->get('name');
        // 向V层传数据
        $this->assign('user', $user);
        $this->assign('sponsors', $data);
        return $this->fetch();
    }

     public function signUp()
    {
        // 接收post信息
        $request = new Request;
        $postData = $request->post();
        $session = new Session();

        if ($postData['password'] != $postData['repassword']) {
            return $this->error('两次输入的密码不一致', url('../sponsorSignUp'), 1);
        }
        $error = "";
        if(empty($postData['password'])) {
            $error = "密码不能为空！";
        } else if(empty($postData['name'])) {
            $error = "单位名称不能为空！";
        } else if(empty($postData['sponsor'])) {
            $error = "负责人不能为空！";
        } else if(empty($postData['address'])) {
            $error = "地址不能为空！";
        } else if(empty($postData['phone'])) {
            $error = "电话号码格式不正确！";
        } else if(empty($postData['email'])) {
            $error = "邮件地址格式不正确！";
        } else if(empty($postData['zipcode'])) {
            $error = "邮编格式不正确！";
        }
        if($error != "") {
            return $this->error($error, url('../sponsorSignUp'), 1);
        }
        $data=array(
            "S_Number" => '1000',
            "S_Password" => $postData['password'],
            "S_Units" => $postData['name'],
            "S_Name" => $postData['sponsor'],
            "S_Address" => $postData['address'],
            "S_Telephone" => $postData['phone'],
            "S_Email" => $postData['email'],
            "S_Code" => (int)$postData['zipcode'],
            "A_Number" => 0,
            "R_Number" => 0,
        );
        $User = new Sponsor(); 
        $popId = $User->getId();
        $data["S_Number"] = $popId;
        $User->addData($data);
        $session->set('sponsorId', $data['S_Number']);
        $session->set('name', $data['S_Name']);

        return $this->success('注册成功', url('/index/activity/indexs'));

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

        // 实例化sponsor空对象
        $sponsor = new Sponsor;
        
        $error = "";
        //赋值


        if(empty($postData['S_Units'])) {
            $error = "单位名称不能为空！";
        } else if(empty($postData['S_Password'])) {
            $error = "登陆密码不能为空！";
        } else if(empty($postData['S_Name'])) {
            $error = "负责人不能为空！";
        }else if(empty($postData['S_Address'])) {
            $error = "地址不能为空！";
        } else if(empty($postData['S_Telephone'])) {
            $error = "联系电话不能为空！";
        } else if(empty($postData['S_Email'])) {
            $error = "电子邮箱不能为空！";
        } else if(empty($postData['S_Code'])) {
            $error = "邮政编码不能为空！";
        } else if(empty($postData['A_Number'])) {
            $error = "赞助活动数目不能为空！";
        } else if(empty($postData['R_Number'])) {
            $error = "赞助对象数目不能为空！";
        }
        if($error != "") {
            return $this->error($error, url('/index/sponsor/add/id/'.$id), 1);
        }

         $data = [
            "S_Units" => $postData['S_Units'],
            "S_Password" => $postData['S_Password'],
            "S_Name" => $postData['S_Name'],
            "S_Telephone" => $postData['S_Telephone'],
            "S_Address" => $postData['S_Address'],
            "S_Email" => $postData['S_Email'],
            "S_Code" => $postData['S_Code'],
            "A_Number" => $postData['A_Number'],
            "R_Number" => $postData['R_Number'],
        ];
        
        $popId = $sponsor->getId();
        $data["S_Number"] = $popId;
        $res = $sponsor->addData($data);
        return $this->success('修改成功', url('../showSponsor'));
    }

    public function delete($id)
    {
        $sponsor = new Sponsor;
        $sponsor->deleteData($id);
        $this->redirect('../showSponsor');
    }

    public function edit($id)
    {
    	$sponsor = Db::name('Sponsor')->where('S_Number', $id)->select()[0];

        $this->assign('id', $id);
        $this->assign('S_Units', $sponsor['S_Units']);
        $this->assign('S_Password', $sponsor['S_Password']);
        $this->assign('S_Name', $sponsor['S_Name']);
        $this->assign('S_Address', $sponsor['S_Address']);
        $this->assign('S_Telephone', $sponsor['S_Telephone']);
        $this->assign('S_Email', $sponsor['S_Email']);
        $this->assign('S_Code', $sponsor['S_Code']);
        $this->assign('A_Number', $sponsor['A_Number']);
        $this->assign('R_Number', $sponsor['R_Number']);
        return $this->fetch();
    }

    public  function editNew($id)
    {
        //$this->redirect('News/category', ['cate_id' => 2]);
        // 接收post信息
        $request = new Request;
        $postData = $request->post();

        // 实例化sponsor空对象
        $sponsor = new Sponsor;
        
        $error = "";
        //赋值


         if(empty($postData['S_Units'])) {
            $error = "单位名称不能为空！";
        } else if(empty($postData['S_Password'])) {
            $error = "登陆密码不能为空！";
        } else if(empty($postData['S_Name'])) {
            $error = "负责人不能为空！";
        }else if(empty($postData['S_Address'])) {
            $error = "地址不能为空！";
        } else if(empty($postData['S_Telephone'])) {
            $error = "联系电话不能为空！";
        } else if(empty($postData['S_Email'])) {
            $error = "电子邮箱不能为空！";
        } else if(empty($postData['S_Code'])) {
            $error = "邮政编码不能为空！";
        } else if(empty($postData['A_Number'])) {
            $error = "赞助活动数目不能为空！";
        } else if(empty($postData['R_Number'])) {
            $error = "赞助对象数目不能为空！";
        }
        if($error != "") {
            return $this->error($error, url('/index/sponsor/edit/id/'.$id), 1);
        }

         $data = [
            "S_Units" => $postData['S_Units'],
            "S_Password" => $postData['S_Password'],
            "S_Name" => $postData['S_Name'],
            "S_Telephone" => $postData['S_Telephone'],
            "S_Address" => $postData['S_Address'],
            "S_Email" => $postData['S_Email'],
            "S_Code" => $postData['S_Code'],
            "A_Number" => $postData['A_Number'],
            "R_Number" => $postData['R_Number'],
        ];
        
        $popId = $sponsor->getId();
        $data["S_Number"] = $popId;
        $res = $sponsor->editData($id,$data);
        return $this->success('修改成功', url('../showSponsor'));
    }

    public function find()
    {
    	$test = Db::name('Sponsor')->select();
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