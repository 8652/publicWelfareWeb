<?php
namespace app\index\controller;     //命名空间，也说明了文件所在的文件夹
use think\Controller;   // 引用数据库操作类
use app\common\model\activity;
use think\Db;   // 引用数据库操作类
use think\Request;
use think\Session;

// Index既是类名，也是文件名，说明这个文件的名字为Index.php。
class ActivityController extends Controller
{
    public function index()
    {
    	$activity = new Activity; 
        $data = $activity->getData();
        $session = new Session();
        $user = $session->get('name');
        $this->assign('user', $user);
        // 向V层传数据
        $this->assign('activitys', $data);
        return $this->fetch();
    }

    public function indexv()
    {
        $activity = new Activity; 
        $data = $activity->getData();
        $session = new Session();
        $user = $session->get('name');
        $this->assign('user', $user);
        // 向V层传数据
        $this->assign('activitys', $data);
        return $this->fetch();
    }

    public function indexs()
    {
        $activity = new Activity; 
        $data = $activity->getData();
        $session = new Session();
        $user = $session->get('name');
        $this->assign('user', $user);
        // 向V层传数据
        $this->assign('activitys', $data);
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
        $activity = new Activity;
        
        $error = "";
        //赋值

        if(empty($postData['ddl'])) {
            $error = "请输入yyyy-mm-dd格式的日期！";
        } else if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $postData['ddl'], $parts))
        {
            //检测是否为日期
            if(checkdate($parts[2],$parts[3],$parts[1]))
                $error = "";
            else
                $error = "请输入yyyy-mm-dd格式的日期！";
        }

        if(empty($postData['theme'])) {
            $error = "活动主题不能为空！";
        } else if(empty($postData['namet'])) {
            $error = "活动名称不能为空！";
        } else if(empty($postData['purpose'])) {
            $error = "活动目的不能为空！";
        } else if(empty($postData['meaning'])) {
            $error = "活动意义不能为空！";
        } else if(empty($postData['object'])) {
            $error = "参与对象不能为空！";
        } else if(empty($postData['ddl'])) {
            $error = "活动时间不能为空！";
        } else if(empty($postData['place'])) {
            $error = "活动地点不能为空！";
        } else if(empty($postData['prepare'])) {
            $error = "具体流程不能为空！";
        } else if(empty($postData['organizer'])) {
            $error = "主办单位不能为空！";
        } else if(empty($postData['budget'])) {
            $error = "经费预算不能为空！";
        } else if(empty($postData['warning'])) {
            $error = "注意事项不能为空！";
        }
        if($error != "") {
            return $this->error($error, url('activity/add'), 1);
        }
        
        $data = [
            "A_Number1" => (int)1,
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
        
        $popId = $activity->getId();
        $data["A_Number1"] = $popId;
        $activity->addData($data);

        return $this->success('新建成功', url('../activity'));
        
    }

    public function delete($id)
    {
    	$activity = new Activity;
        $activity->deleteData($id);
        $this->redirect('../activity');
    }

    public function edit($id)
    {
    	$activity = Db::name('Activity')->where('A_Number1', $id)->select()[0];
        /*
        $data = [
            "A_Number1" => (int)1,
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
        $this->assign('theme', $activity['A_Theme']);
        $this->assign('namet', $activity['A_Namet']);
        $this->assign('meaning', $activity['A_Meaning']);
        $this->assign('purpose', $activity['A_Purpose']);
        $this->assign('object', $activity['A_Object']);
        $this->assign('ddl', $activity['A_Time']);
        $this->assign('place', $activity['A_Place']);
        $this->assign('organizer', $activity['A_Organizer']);
        $this->assign('prepare', $activity['A_Prepare']);
        $this->assign('warning', $activity['A_Pay']);
        $this->assign('budget', $activity['A_Budget']);
        return $this->fetch();
    }


    public  function editNew($id)
    {
        //$this->redirect('News/category', ['cate_id' => 2]);
        // 接收post信息
        $request = new Request;
        $postData = $request->post();

        // 实例化volunteer空对象
        $activity = new Activity;
        
        $error = "";
        //赋值

        if(empty($postData['ddl'])) {
            $error = "请输入yyyy-mm-dd格式的日期！";
        } else  if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $postData['ddl'], $parts))
        {
            //检测是否为日期
            if(checkdate($parts[2],$parts[3],$parts[1]))
                $error = "";
            else
                $error = "请输入yyyy-mm-dd格式的日期！";
        }
        else $error = "请输入yyyy-mm-dd格式的日期！";
        if(empty($postData['theme'])) {
            $error = "活动主题不能为空！";
        } else if(empty($postData['namet'])) {
            $error = "活动名称不能为空！";
        } else if(empty($postData['purpose'])) {
            $error = "活动目的不能为空！";
        } else if(empty($postData['meaning'])) {
            $error = "活动意义不能为空！";
        } else if(empty($postData['object'])) {
            $error = "参与对象不能为空！";
        } else if(empty($postData['ddl'])) {
            $error = "活动时间不能为空！";
        } else if(empty($postData['place'])) {
            $error = "活动地点不能为空！";
        } else if(empty($postData['prepare'])) {
            $error = "具体流程不能为空！";
        } else if(empty($postData['organizer'])) {
            $error = "主办单位不能为空！";
        } else if(empty($postData['budget'])) {
            $error = "经费预算不能为空！";
        } else if(empty($postData['warning'])) {
            $error = "注意事项不能为空！";
        }
        if($error != "") {
            return $this->error($error, url('/index/activity/edit/id/'.$id), 1);
        }
        
        $data = [
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
        ];
        
        $activity->editData($id, $data);

        return $this->success('修改成功', url('../activity'));
    }

    public function showv($id)
    {
        $activity = Db::name('Activity')->where('A_Number1', $id)->select()[0];

        $this->assign('id', $id);
        $this->assign('theme', $activity['A_Theme']);
        $this->assign('namet', $activity['A_Namet']);
        $this->assign('meaning', $activity['A_Meaning']);
        $this->assign('purpose', $activity['A_Purpose']);
        $this->assign('object', $activity['A_Object']);
        $this->assign('ddl', $activity['A_Time']);
        $this->assign('place', $activity['A_Place']);
        $this->assign('organizer', $activity['A_Organizer']);
        $this->assign('prepare', $activity['A_Prepare']);
        $this->assign('warning', $activity['A_Pay']);
        $this->assign('budget', $activity['A_Budget']);
        return $this->fetch();
    }

    public function registerv($id) 
    {
        //$this->redirect('News/category', ['cate_id' => 2]);
        // 接收post信息
        $request = new Request;
        $postData = $request->post();
        $session = new Session();

        // 实例化volunteer空对象
        $activity = new Activity;
        
        $error = "";
        //赋值

        if (empty($postData['telephone'])) {
            $error = "联系电话不能为空！";
        } else if (empty($postData['useful'])) {
            $error = "空闲时间不能为空！";
        }

        if($error != "") {
            return $this->error($error, url('/index/activity/showv/id/'.$id));
        }

        $R_id = 0;
        $Rid = Db::table('registervolu')->order('R_Number desc')->select();
        if(empty($id)) {
            $R_id = 1;
        } else {
            $R_id = ((int)$Rid[0]['R_Number'])+1;
        }
        $data = [
            "A_Number1" => $id,
            "V_Number" => $session->get('volunteerId'),
            "V_Telephone" => $postData['telephone'],
            "V_Useful" => $postData['useful'],
            "R_Number" => $R_id,
            "V_Check" => (int)0,
        ];
        
        $record = Db::table('registervolu')->where('V_Number', $session->get('volunteerId'))->select();
        if(!empty($record)) {
            return $this->error('请不要重复报名！', url('/index/activity/indexv'));
        }

        $id = Db::table('registervolu')->insert($data);
        //insertGetId 方法添加成功，返回插入数据的自增id值
        return $this->success('报名成功', url('/index/activity/indexv'));
    }


    public function shows($id)
    {
        $activity = Db::name('Activity')->where('A_Number1', $id)->select()[0];

        $this->assign('id', $id);
        $this->assign('theme', $activity['A_Theme']);
        $this->assign('namet', $activity['A_Namet']);
        $this->assign('meaning', $activity['A_Meaning']);
        $this->assign('purpose', $activity['A_Purpose']);
        $this->assign('object', $activity['A_Object']);
        $this->assign('ddl', $activity['A_Time']);
        $this->assign('place', $activity['A_Place']);
        $this->assign('organizer', $activity['A_Organizer']);
        $this->assign('prepare', $activity['A_Prepare']);
        $this->assign('warning', $activity['A_Pay']);
        $this->assign('budget', $activity['A_Budget']);
        return $this->fetch();
    }

    public function registers($id) 
    {
        //$this->redirect('News/category', ['cate_id' => 2]);
        // 接收post信息
        $request = new Request;
        $postData = $request->post();
        $session = new Session();

        // 实例化volunteer空对象
        $activity = new Activity;
        
        $error = "";
        //赋值

        if (empty($postData['telephone'])) {
            $error = "联系电话不能为空！";
        } else if (!is_numeric($postData['money'])) {
            $error = "资助金额不能为空！";
        }

        if($error != "") {
            return $this->error($error, url('/index/activity/shows/id/'.$id));
        }

        $R_id = 0;
        $Rid = Db::table('registerspon')->order('R_Number desc')->select();
        if(empty($id)) {
            $R_id = 1;
        } else {
            $R_id = ((int)$Rid[0]['R_Number'])+1;
        }

        $data = [
            "A_Number1" => $id,
            "S_Number" => $session->get('sponsorId'),
            "S_Telephone" => $postData['telephone'],
            "S_Money" => $postData['money'],
            "R_Number" =>  $R_id,
            "S_Check" => (int)0,
        ];
        
        $record = Db::table('registerspon')->where('S_Number', $session->get('sponsorId'))->select();
        if(!empty($record)) {
            return $this->error('您已经资助过了', url('/index/activity/indexs'));
        }

        $id = Db::table('registerspon')->insert($data);
        //insertGetId 方法添加成功，返回插入数据的自增id值
        return $this->success('资助成功', url('/index/activity/indexs'));
    }

    public function managevolu($id) {
        $registers = Db::table('registervolu')->where('A_Number1', $id)->select();
        $this->assign('registers', $registers);
        return $this->fetch();
    }

    public function managespon($id) {
        $registers = Db::table('registerspon')->where('A_Number1', $id)->select();
        $this->assign('registers', $registers);
        return $this->fetch();
    }    

    public function registervolu($id) {
        $register = Db::table('registervolu')->where('R_Number', $id)->select()[0];
        $volunteer = DB::table('volunteer')->where('V_Number', $register['V_Number'])->select()[0];
        $session=new Session;
        $session->set('tempUser', $register['V_Number']);
        $this->assign('id', $register['R_Number']);
        $this->assign('name', $volunteer['V_Name']);
        $this->assign('telephone', $register['V_Telephone']);
        $this->assign('useful', $register['V_Useful']);
        $this->assign('check', $register['V_Check']);
        $this->assign('attendance', $volunteer['V_Attendance']);
        $this->assign('pass', $volunteer['V_Pass']);
        return $this->fetch();
    }

    public function registerspon($id) {
        $register = Db::table('registerspon')->where('R_Number', $id)->select()[0];
        $sponsor = DB::table('sponsor')->where('S_Number', $register['S_Number'])->select()[0];

        $this->assign('id', $register['R_Number']);
        $this->assign('units', $sponsor['S_Units']);
        $this->assign('name', $sponsor['S_Name']);
        $this->assign('telephone', $register['S_Telephone']);
        $this->assign('money', $register['S_Money']);
        $this->assign('check', $register['S_Check']);
        return $this->fetch();
    }

    public function checkv($id) {
        $request = new Request;
        $postData = $request->post();
        $session = new Session();
        $volunteerId = $session->get('tempUser');

        $error = "";
        if ($postData['check']!= '是' and $postData['check']!='否') {
            $error = "请输入正确的合格与否！";
        }
        if(!is_numeric($postData['attendance'])&&$postData['attendance']!='0') {
            $error = "请输入大于等于0的出勤次数！";
        } else if(!is_numeric($postData['pass'])&&$postData['pass']!='0') {
            $error = "请输入大于等于0的合格次数！";
        } 
        if($error != "") {
            return $this->error($error, url('/index/activity/registervolu/id/'.$id), 1);
        }
        if($postData['check'] == '是') {
            db('registervolu')->where('R_Number',$id)->update(['V_Check' => (int)1]);
        } else if ($postData['check'] == '否') {
            db('registervolu')->where('R_Number',$id)->update(['V_Check' => (int)0]);
        }

        
        $register = Db::table('registervolu')->where('R_Number', $id)->select()[0];
        $volunteer = DB::table('volunteer')->where('V_Number', $register['V_Number'])->select()[0];

        db('volunteer')->where('V_Number',$volunteerId)->update(['V_Attendance' => $postData['attendance']]);
        db('volunteer')->where('V_Number',$volunteerId)->update(['V_Pass' => $postData['pass']]);

        /////skr
        $session->set('tempUser', null);
        return $this->success('修改成功', url('/index/activity/managevolu/id/' .$register['A_Number1']));
    }

    public function checks($id) {
        $request = new Request;
        $postData = $request->post();
        $register = Db::table('registervolu')->where('R_Number', $id)->select()[0];
        
         $error = "";
        if ($postData['check']!= '是' and $postData['check']!='否') {
            $error = "请输入正确的合格与否！";
        }

        if($error != "") {
            return $this->error($error, url('/index/activity/registerspon/id/'.$id), 1);
        }
        if($postData['check'] == '是') {
            db('registerspon')->where('R_Number',$id)->update(['S_Check' => (int)1]);
        } else if ($postData['check'] == '否') {
            db('registerspon')->where('R_Number',$id)->update(['S_Check' => (int)0]);
        }


        /////skr
        return $this->success('修改成功', url('/index/activity/managespon/id/' .$register['A_Number1']));
    }

    public function find()
    {
    	$test = Db::name('Activity')->select();
    }

}