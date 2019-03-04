<?php
namespace app\index\controller;     //命名空间，也说明了文件所在的文件夹
use think\Controller;   // 引用数据库操作类
use app\common\model\training;
use think\Db;   // 引用数据库操作类
use think\Session;
use think\Request;

// Index既是类名，也是文件名，说明这个文件的名字为Index.php。
class TrainingController extends Controller
{
    public function index()
    {
    	$training = new Training; 
        $data = $training->getData();
        $session = new Session();
        $user = $session->get('name');
        // 向V层传数据
        $this->assign('trainings', $data);
        $this->assign('user', $user);
        return $this->fetch();
    }


    public function indexv()
    {
        $training = new Training; 
        $data = $training->getData();
        $session = new Session();
        $user = $session->get('name');
        // 向V层传数据
        $this->assign('trainings', $data);
        $this->assign('user', $user);

        return $this->fetch();
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
    //增删改查之
    public function add()
    {
        return $this->fetch();
    }

    public function addNew() {
        //$this->redirect('News/category', ['cate_id' => 2]);
        // 接收post信息
        $request = new Request;
        $postData = $request->post();

        // 实例化volunteer空对象
        $training = new Training;
        
        $error = "";
        //赋值


        if(empty($postData['T_Object'])) {
            $error = "服务对象不能为空！";
        } else if(empty($postData['T_Volunteers'])) {
            $error = "社区志愿者不能为空！";
        } else if(empty($postData['T_Organization'])) {
            $error = "社区志愿者组织不能为空！";
        } else if(empty($postData['T_Purpose'])) {
            $error = "培训目的不能为空！";
        } else if(empty($postData['T_Content'])) {
            $error = "培训内容不能为空！";
        } else if(!is_numeric($postData['T_Size'])) {
            $error = "请填写大于0的培训规模数！";
        } else if(empty($postData['T_Way'])) {
            $error = "培训方式不能为空！";
        }
        if($error != "") {
            return $this->error($error, url('training/add'), 1);
        }
        
        $data = [
            "T_Number" => (int)1,
            "T_Object" => $postData['T_Object'],
            "T_Volunteers" => $postData['T_Volunteers'],
            "T_Organization" => $postData['T_Organization'],
            "T_Purpose" => $postData['T_Purpose'],
            "T_Content" => $postData['T_Content'],
            "T_Size" => $postData['T_Size'],
            "T_Way" => $postData['T_Way'],
        ];
        
        $popId = $training->getId();
        $data["T_Number"] = $popId;
        $training->addData($data);

        return $this->success('新建成功', url('../training'));
    }


    public function delete($id)
    {
        $training = new Training;
        $training->deleteData($id);
        $this->redirect('../training');
    }


    public function edit($id)
    {
        $training = Db::name('Training')->where('T_Number', $id)->select()[0];
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
        $this->assign('T_Object', $training['T_Object']);
        $this->assign('T_Volunteers', $training['T_Volunteers']);
        $this->assign('T_Organization', $training['T_Organization']);
        $this->assign('T_Purpose', $training['T_Purpose']);
        $this->assign('T_Content', $training['T_Content']);
        $this->assign('T_Size', $training['T_Size']);
        $this->assign('T_Way', $training['T_Way']);
        return $this->fetch();
    }

    public  function editNew($id)
    {
        //$this->redirect('News/category', ['cate_id' => 2]);
        // 接收post信息
        $request = new Request;
        $postData = $request->post();

        // 实例化volunteer空对象
        $training = new Training;
        
        $error = "";
        //赋值


        if(empty($postData['T_Object'])) {
            $error = "服务对象不能为空！";
        } else if(empty($postData['T_Volunteers'])) {
            $error = "社区志愿者不能为空！";
        } else if(empty($postData['T_Organization'])) {
            $error = "社区志愿者组织不能为空！";
        } else if(empty($postData['T_Purpose'])) {
            $error = "培训目的不能为空！";
        } else if(empty($postData['T_Content'])) {
            $error = "培训内容不能为空！";
        } else if(!is_numeric($postData['T_Size'])) {
            $error = "请填写大于0的培训规模数！";
        } else if(empty($postData['T_Way'])) {
            $error = "培训方式不能为空！";
        }
        if($error != "") {
            return $this->error($error, url('/index/training/edit/id/'.$id), 1);
        }
        
        $data = [
            "T_Number" => (int)1,
            "T_Object" => $postData['T_Object'],
            "T_Volunteers" => $postData['T_Volunteers'],
            "T_Organization" => $postData['T_Organization'],
            "T_Purpose" => $postData['T_Purpose'],
            "T_Content" => $postData['T_Content'],
            "T_Size" => $postData['T_Size'],
            "T_Way" => $postData['T_Way'],
        ];
        
        $popId = $training->getId();
        $data["T_Number"] = $popId;
        $training->editData($id, $data);

        return $this->success('修改成功', url('../training'));
    }

    public function showv($id)
    {
        $training = Db::name('Training')->where('T_Number', $id)->select()[0];

        $this->assign('id', $id);
        $this->assign('T_Object', $training['T_Object']);
        $this->assign('T_Volunteers', $training['T_Volunteers']);
        $this->assign('T_Organization', $training['T_Organization']);
        $this->assign('T_Purpose', $training['T_Purpose']);
        $this->assign('T_Content', $training['T_Content']);
        $this->assign('T_Size', $training['T_Size']);
        $this->assign('T_Way', $training['T_Way']);
        return $this->fetch();
    }


    public function register($id) {
        $session = new Session;
        $volunteerId = $session->get('volunteerId');

        // 接收post信息
        $request = new Request;
        $postData = $request->post();
        
        $error = "";
        //赋值
        if(empty($postData['telephone'])) {
            $error = "联系电话不能为空！";
        } else if(empty($postData['useful'])) {
            $error = "空闲时间不能为空！";
        }

        if($error != "") {
            return $this->error($error, url('/index/training/showv/id/'.$id), 1);
        }
              
        db('volunteer')->where('V_Number',$volunteerId)->update(['A_Number' => (int)1]);
        return $this->success('培训成功', url('/index/training/indexv'));

    }
    public function find()
    {
    	$test = Db::name('Training')->select();
    }
}