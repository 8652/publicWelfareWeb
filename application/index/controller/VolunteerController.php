<?php
namespace app\index\controller;     //命名空间，也说明了文件所在的文件夹
use think\Controller;   // 引用数据库操作类
use app\common\model\volunteer;
use think\Request;     
use think\Db;   // 引用数据库操作类
use think\Session;

// 既是类名，也是文件名，说明这个文件的名字为Index.php。
class VolunteerController extends Controller
{
    public function index()
    {
        // 显示登录表单
        $session = new Session();
        $user = $session->get('name');
        $this->assign('user', $user);
        return $this->fetch();
    }

    public function manage()
    {
        $volunteer = new Volunteer; 
        $data = $volunteer->getData();
        $session = new Session();
        $user = $session->get('name');
        // 向V层传数据
        $this->assign('user', $user);
        $this->assign('volunteers', $data);
        return $this->fetch();
    }




    public function signUp()
    {
        // 接收post信息
        $request = new Request;
        $postData = $request->post();
        $session = new Session;

        if ($postData['password'] != $postData['repassword']) {
            return $this->error('两次输入的密码不一致', url('../volunteerSignUp'), 1);
        }
        $error = "";

        if(empty($postData['bothday'])) {
            $error = "请输入yyyy-mm-dd格式的日期！";
        } else    if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $postData['bothday'], $parts))
        {
            //检测是否为日期
            if(checkdate($parts[2],$parts[3],$parts[1]))
                $error = "";
            else
                $error = "请输入yyyy-mm-dd格式的日期！";
        }

        if(empty($postData['password'])) {
            $error = "密码不能为空！";
        } else if(empty($postData['name'])) {
            $error = "姓名不能为空！";
        } else if(empty($postData['sex'])) {
            $error = "性别不能为空！";
        } else if(empty($postData['bothday'])) {
            $error = "出生日期不能为空！";
        } else if(empty($postData['address'])) {
            $error = "地址不能为空！";
        } else if(empty($postData['phone'])) {
            $error = "电话号码格式不正确！";
        } else if(empty($postData['email'])) {
            $error = "邮件地址格式不正确！";
        } else if(empty($postData['zipcode'])) {
            $error = "邮编格式不正确！";
        }

        if ($postData['sex']!= '男' and $postData['sex']!='女') {
            $error = "请输入正确的性别格式！";
        }
        if($error != "") {
            return $this->error($error, url('../volunteerSignUp'), 1);
        }
        $data=array(
            "V_Number" => '1000',
            "V_Password" => $postData['password'],
            "V_Name" => $postData['name'],
            "V_Sex" => $postData['sex'],
            "V_BornDate" => $postData['bothday'],
            "V_Address" => $postData['address'],
            "V_Telephone" => $postData['phone'],
            "V_Email" => $postData['email'],
            "V_Code" => (int)$postData['zipcode'],
            "V_Level" => 0,
            "A_Number" => 0,
            "V_Attendance" => 0,
            "V_Pass" => 1,
        );
        if($postData['sex'] == '男') {
            $data["V_Sex"] = (int)1;
        } else if ($postData['sex'] == '女') {
            $data["V_Sex"] = (int)0;
        }
        $User = new volunteer(); 
        $popId = $User->getId();
        $data["V_Number"] = $popId;
        $User->addData($data);
        $session->set('volunteerId', $data['V_Number']);
        $session->set('name', $data['V_Name']);
        return $this->success('注册成功', url('/index/activity/indexv'));

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

        // 实例化volunteer空对象
        $volunteer = new Volunteer;
        
        $error = "";
        //赋值

        if(empty($postData['V_BornDate'])) {
            $error = "请输入yyyy-mm-dd格式的日期！";
        } else    if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $postData['V_BornDate'], $parts))
        {
            //检测是否为日期
            if(checkdate($parts[2],$parts[3],$parts[1]))
                $error = "";
            else
                $error = "请输入yyyy-mm-dd格式的日期！";
        }
        if(empty($postData['V_Name'])) {
            $error = "姓名不能为空！";
        } else if(empty($postData['V_Password'])) {
            $error = "登陆密码不能为空！";
        } else if(empty($postData['V_Sex'])) {
            $error = "性别不能为空！";
        } else if(empty($postData['V_BornDate'])) {
            $error = "出生日期不能为空！";
        } else if(empty($postData['V_Address'])) {
            $error = "住址不能为空！";
        } else if(empty($postData['V_Telephone'])) {
            $error = "联系电话不能为空！";
        } else if(empty($postData['V_Email'])) {
            $error = "电子邮箱不能为空！";
        } else if(empty($postData['V_Code'])) {
            $error = "邮政编码不能为空！";
        } else if(!is_numeric($postData['A_Number']) && $postData['A_Number']!='0') {
            $error = "参与活动数目需要大于等于0！";
        } else if(!is_numeric($postData['V_Attendance']) && $postData['V_Attendance']!='0') {
            $error = "出席活动数目需要大于等于0！";
        }

        if ($postData['V_Sex']!= '男' and $postData['V_Sex']!='女') {
            $error = "请输入正确的性别格式！";
        }
        if($error != "") {
            return $this->error($error, url('/index/volunteer/add'), 1);
        }
        
        $data = [
            "V_Name" => $postData['V_Name'],
            "V_Password" => $postData['V_Password'],
            "V_Sex" => $postData['V_Sex'],
            "V_BornDate" => $postData['V_BornDate'],
            "V_Telephone" => $postData['V_Telephone'],
            "V_Address" => $postData['V_Address'],
            "V_Email" => $postData['V_Email'],
            "V_Code" => $postData['V_Code'],
            "A_Number" => $postData['A_Number'],
            "V_Attendance" => $postData['V_Attendance'],
            "V_Level" => (int)0,
        ];

        if($postData['V_Sex'] == '男') {
            $data["V_Sex"] = (int)1;
        } else if ($postData['V_Sex'] == '女') {
            $data["V_Sex"] = (int)0;
        }
        
        $popId = $volunteer->getId();
        $data["V_Number"] = $popId;
        $res = $volunteer->addData($data);
        return $this->success('添加成功', url('../showVolunteer'));
    }

    public function delete($id)
    {
    	$volunteer = new Volunteer;
        $volunteer->deleteData($id);
        $this->redirect('../showVolunteer');
    }

    public function edit($id)
    {
    	$volunteer = Db::name('Volunteer')->where('V_Number', $id)->select()[0];
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
        $this->assign('V_Name', $volunteer['V_Name']);
        $this->assign('V_Password', $volunteer['V_Password']);
        $this->assign('V_Sex', $volunteer['V_Sex']);
        $this->assign('V_BornDate', $volunteer['V_BornDate']);
        $this->assign('V_Address', $volunteer['V_Address']);
        $this->assign('V_Telephone', $volunteer['V_Telephone']);
        $this->assign('V_Email', $volunteer['V_Email']);
        $this->assign('V_Code', $volunteer['V_Code']);
        $this->assign('A_Number', $volunteer['A_Number']);
        $this->assign('V_Attendance', $volunteer['V_Attendance']);
        return $this->fetch();
    }

    public  function editNew($id)
    {
        //$this->redirect('News/category', ['cate_id' => 2]);
        // 接收post信息
        $request = new Request;
        $postData = $request->post();

        // 实例化volunteer空对象
        $volunteer = new Volunteer;
        
        $error = "";
        //赋值


        if(empty($postData['V_BornDate'])) {
            $error = "请输入yyyy-mm-dd格式的日期！";
        } else    if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $postData['V_BornDate'], $parts))
        {
            //检测是否为日期
            if(checkdate($parts[2],$parts[3],$parts[1]))
                $error = "";
            else
                $error = "请输入yyyy-mm-dd格式的日期！";
        }
        if(empty($postData['V_Name'])) {
            $error = "姓名不能为空！";
        } else if(empty($postData['V_Password'])) {
            $error = "登陆密码不能为空！";
        } else if(empty($postData['V_Sex'])) {
            $error = "性别不能为空！";
        } else if(empty($postData['V_BornDate'])) {
            $error = "出生日期不能为空！";
        } else if(empty($postData['V_Address'])) {
            $error = "住址不能为空！";
        } else if(empty($postData['V_Telephone'])) {
            $error = "联系电话不能为空！";
        } else if(empty($postData['V_Email'])) {
            $error = "电子邮箱不能为空！";
        } else if(empty($postData['V_Code'])) {
            $error = "邮政编码不能为空！";
        } else if(!is_numeric($postData['A_Number']) && $postData['A_Number']!='0') {
            $error = "参与活动数目不能为空！";
        } else if(!is_numeric($postData['V_Attendance'])&& $postData['V_Attendance']!='0') {
            $error = "出席活动数目不能为空！";
        }

        if ($postData['V_Sex']!= '男' and $postData['V_Sex']!='女') {
            $error = "请输入正确的性别格式！";
        }

        if($error != "") {
            return $this->error($error, url('/index/volunteer/edit/id/'.$id), 1);
        }
        
        $data = [
            "V_Name" => $postData['V_Name'],
            "V_Password" => $postData['V_Password'],
            "V_Sex" => $postData['V_Sex'],
            "V_BornDate" => $postData['V_BornDate'],
            "V_Telephone" => $postData['V_Telephone'],
            "V_Address" => $postData['V_Address'],
            "V_Email" => $postData['V_Email'],
            "V_Code" => $postData['V_Code'],
            "A_Number" => $postData['A_Number'],
            "V_Attendance" => $postData['V_Attendance'],
        ];

        if($postData['V_Sex'] == '男') {
            $data["V_Sex"] = (int)1;
        } else if ($postData['V_Sex'] == '女') {
            $data["V_Sex"] = (int)0;
        }
        
        $popId = $volunteer->getId();
        $data["V_Number"] = $popId;
        $res = $volunteer->editData($id, $data);
        return $this->success('修改成功', url('../showVolunteer'));
    }

    public function find()
    {
    	$test = Db::name('volunteernteer')->select();

        return $test;
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

    public function makeSignUp()
    {
        //$test = Db::name('volunteernteer')->select();
        //dump($test); //获取数据表数据
    }

    public function makeMessage()
    {
        //$test = Db::name('volunteernteer')->select();
        //dump($test); //获取数据表数据
    }
}