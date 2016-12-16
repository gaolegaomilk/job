<?php

namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Validate;
use app\index\Model\User;
use app\index\Model\Company;
use  think\Session;
use app\index\Model\Business;
use app\index\Model\Position;
use app\index\Model\Vocation;
use app\index\Model\Category;
use app\index\Model\Personinfo;
use app\index\Model\City;

class Auth extends Controller
{
	//普通用户的用户注册
	public function reg()
	{
		return $this->fetch();
	}
	
	//对注册普通用户名的验证
	public function authCheck()
	{
		$user = Db::name('user')->where('email',$_POST['email'])->find();
		if ($user)
		{
			echo json_encode(array('status'=>1, 'msg'=> '', 'data'=>[]));
		} else {
			echo json_encode(array('status'=>0, 'msg'=> '', 'data'=>[]));
		}
	}
	//对注册提交的数据进行处理
	public function doRegister()
	{

		$user = new User;
		$username = $_REQUEST['email'];
		$password= md5($_REQUEST['password']);
		$repassword= md5($_REQUEST['repassword']);
		$ip = $_SERVER['REMOTE_ADDR'];
		$ip = ip2long($ip);
		// $time = time();
		//$user_type = $_REQUEST['user_type'];
	    $code=$_REQUEST['Code'];
	    if (empty($username)) {
	    	//echo '<script>alert("用户名不能为空");parent.location.href="http://www.goodjob.com/index/user/reg";</script>';
	    	$this->error('用户名不能为空','user/reg');
	    }

	    if (empty($password)) {
	     	// echo '<script>alert("密码不能为空");parent.location.href="http://www.goodjob.com/index/user/reg";</script>';
	     	$this->error('密码不能为空','user/reg');
	    }

	    if (($password != $repassword)) {
	    	 //echo '<script>alert("两次输入的密码不一致");parent.location.href="http://www.goodjob.com/index/user/reg";</script>';
	    	$this->error('两次输入的密码不一致','user/reg');
	    }
		if(captcha_check($code)){
		 	$user->data([
			"email"=> "$username",
			"password" => "$password",
			"ip" => "$ip"
			]);
			$result = $user->save();

			if ($result) {
				//echo '<script>alert("注册成功");parent.location.href="http://www.goodjob.com/index/index";</script>';
				$this->success('注册成功','user/login');
			}		 	
		} else {
			//echo '<script>alert("注册失败");parent.location.href="http://www.goodjob.com/index/user/reg";</script>';
				$this->error('注册失败','user/reg');
		}
	} 

	//对注册企业用户的判断
	public function register()
	{
		return $this->fetch();
	}
	public function authCompany()
	{
		$company = Db::name('company')->where('email',$_POST['email'])->find();
		if ($company)
		{
			echo json_encode(array('status'=>1, 'msg'=> '', 'data'=>[]));
		} else {
			echo json_encode(array('status'=>0, 'msg'=> '', 'data'=>[]));
		}
	}

	public function doCompany()
	{
		$company = new Company;

		$username = $_REQUEST['email'];
		$password= md5($_REQUEST['password']);
		$repassword= md5($_REQUEST['repassword']);
		$ip = $_SERVER['REMOTE_ADDR'];
		$ip = ip2long($ip);
	    $code=$_REQUEST['Code'];	    
	    if (empty($username)) {
	    	 //echo '<script>alert("用户名不能为空");parent.location.href="http://www.goodjob.com/index/user/reg";</script>';
	    	$this->error('用户名不能为空','user/register');
	    }

	    if (empty($password)) {
	     	 //echo '<script>alert("密码不能为空");parent.location.href="http://www.goodjob.com/index/user/reg";</script>';
	     	$this->error('密码不能为空','user/register');
	    }

	    if (($password != $repassword)) {
	    	 // echo '<script>alert("两次输入的密码不一致");parent.location.href="http://www.goodjob.com/index/user/reg";</script>';
	    	$this->error('两次输入的密码不一致','user/register');
	    }
	  
		if(captcha_check($code)){
		 	$company->data([
			"email"=> "$username",
			"password" => "$password",
			"ip" => "$ip"
			]);
			$result = $company->save();
			if ($result) {
				$this->success('注册成功','index/index');
			}		 	
		} else {
			$this->error('注册失败','user/register');
		}
	} 

	//对个人用户的登录
	public function login()
	{
		return $this->fetch();
	}
	public function doLogin()
	{
		
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$Code = $_POST['Code'];
		$personinfo = Db::name('user')->where('email', $email)->select();
		 if(empty($personinfo)){
	 		$this->error('用户名不存在', 'User/login');
		 } else {
		 	$id = $personinfo[0]['uid'];
			$name = Db::name('personinfo')->where('user_id',$id)->find()['realname'];
		 	if ($_POST['email'] == $personinfo[0]['email']) {

		 		if ($password == $personinfo[0]['password']) {
		 			if (captcha_check($Code)) {

		 				Session('user', [
		 				'email' => $_POST['email'],
		 				'password' => $_POST['password'],
		 				'uid' => $personinfo[0]['uid'],
		 				'user_type' => $personinfo[0]['user_type'],
		 				'name' => $name
		 				] );
		 				$find = Db::name('user')->where('uid',73)->find();
		 				if($find['web'] == 1 || Session::get('user')['user_type'] == 2){
		 					$this->success('登陆成功', 'Index/index');
		 				} else {
		 					Session(null);
		 					$this->error('亲 ， 服务器正在维护当中', 'Index/index' );
		 				}
		 			}else {
		 				$this->error('请输入验证码','http://www.goodjob.com/index/user/login');
		 			}	
		 		} else {
		 			
		 			$this->error('密码错误','http://www.goodjob.com/index/user/login');
		 		}
		 	} else {
		 		
		 		$this->error('用户名不存在','http://www.goodjob.com/index/user/login');
		 	}
		}
	}

	//企业用户的登录
	public function log()
	{
		return $this->fetch();
	}

	public function doLog()
	{	
		$find = Db::name('user')->where('uid',73)->find();
		if($find['web'] == 0 && Session::get('user')['user_type'] != 2){
			$this->error('亲 服务器正在维护当中', 'Index/index');
		} else {
			$email = $_POST['email'];
			$password = md5($_POST['password']);
			$Code = $_POST['Code'];

			//对企业用户的判断用户名是否是唯一的
			$personinfo = Db::name('company')->where('email',$email)->select();

			 if(empty($personinfo)){
		 		
		 		$this->success('用户名不存在','User/log');
			 } else {
			 	if ($_POST['email'] == $personinfo[0]['email']) {
			 		
			 		if ($password == $personinfo[0]['password']) {
			 			Session('user', [
			 				'email' => $_POST['email'],
			 				'password' => $_POST['password'],
			 				'uid' => $personinfo[0]['qid'],
			 				'user_type' => $personinfo[0]['user_type']
			 				] );

			 			$find = Db::name('user')->where('uid', 73)->find();
			 			if ($find['web'] == 1 || Session::get('user')['user_type'] == 2) {
			 				$this->success('登录成功' , 'Index/index');
			 			} else {
			 				Sessio(null);
			 				$this->error('亲 服务器正在维护当中', 'Index/index');
			 			}
			 			//企业用户登录成功跳转首页
			 		} else {
			 		
			 			$this->success('密码错误', 'user/log');
			 		}
			 	} else {
			 		
			 		$this->success('用户名不存在','user/log');
			 	}
			}
		}
	}

	//对个人退出登录的设置
	public function loginOut ()
	{
		session(null);
		$this->success('退出成功', 'index/index');
	}
	//对企业登录退出的设置
	public function logOut ()
	{
		session(null);
		$this->success('退出成功', 'index/index');
	}

	public function out()
	{
		session(null);
		$this->success('退出成功', 'index/index');
	}

	/**
	 * 对企业模板的渲染，并填写公司资料
	 */
	function info()
	{
		$city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
		$this->assign('city', $city);
        $this->assign('vocation', $vocation);
		return $this->fetch();
	}


	/**
	 * 对填写公司资料的内容进行判断
	 */
	public function doInfo()
	{
		//对post提交过来的数据进行处理
		$name = $_POST['name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$history = $_POST['history'];
		$category = $_POST['category'];
		$contactor = $_POST['contactor'];	

		if (empty($name)) {
			echo '<script>alert("企业名字不能为空");parent.location.href="http://www.goodjob.com/index/user/info";</script>';
		}

		if (empty($address)) {
			echo '<script>alert("地址不能为空");parent.location.href="http://www.goodjob.com/index/user/info";</script>';
		}

		if (empty($phone)) {
			echo '<script>alert("联系人不能为空");parent.location.href="http://www.goodjob.com/index/user/info";</script>';
		}

		if (empty($history)) {
			echo '<script>alert("内容不能为空");parent.location.href="http://www.goodjob.com/index/user/info";</script>';
		}

		if (empty($contactor)) {
			echo '<script>alert("企业人不能为空");parent.location.href="http://www.goodjob.com/index/user/info";</script>';
		}

		if (empty($category)) {
			echo '<script>alert("行业不能为空");parent.location.href="http://www.goodjob.com/index/user/info";</script>';
		}

		//对公司信息表的数据查出来如果有就跳转，没有就跳转
		
		
		$uid = Session::get('user')['uid'];
		$resumecom = Db::name('Business')->where('uid',$uid)->select();
			if ($resumecom) {
				echo '<script>alert("企业信息已经填写过");parent.location.href="http://www.goodjob.com/index/user/gui";</script>';
			}else {
				$Bus = new Business;
				$Bus->data([
				'name' => "$name",
				'address' => "$address",
				'contactor' => "$contactor",
				'phone' => "$phone",
				'uid' => "$uid",
				'history'=> "$history",
				'category'=> "$category"
					]);
				$result = $Bus->save();
				if ($result) {
				$this->success('提交完成', 'http://www.goodjob.com/index/user/resumecom');
				}else {
					$this->error('提交失败','http://www.goodjob.com/index/user/gui');
				}						
			}	
	}	

	/**
	 * 对个人中心的设置
	 */
	public function profile()
	{
		return $this->fetch();
	}
	/**
	 * 对个人简历模板的渲染
	 */
	public function resume()
	{
		return $this->fetch();
	}

	//对收藏职位的遍历
	public function collect()
	{
		return $this->fetch();
	}
	/**
	 * 对账户设置的模板进行渲染
	 */
	public function count()
	{
		return $this->fetch();

	}
	/**
	 * 对个人账户密码的修改
	 */
	public function doCount()
	{
		$user = new User();
    	$uid = Session::get('user')['uid'];
    	$password1 = Db::name('user')->where('uid',$uid)->find();
    	
    	$password2 = md5($_POST['password']);
    	
    	$pwd = md5($_POST['repassword']);

    	if (empty($password2)) {
    		echo '<script>alert("请输入原密码");parent.location.href="http://www.goodjob.com/index/user/password";</script>';
    	}

    	if (empty($pwd)) {
    		echo '<script>alert("请输入新密码");parent.location.href="http://www.goodjob.com/index/user/password";</script>';
    	}

    	if ($password1['password'] != $password2) {
    		echo '<script>alert("你输入的密码不正确");parent.location.href="http://www.goodjob.com/index/user/password";</script>';
    	} else {
    		$user->password = $pwd;
    		$result = $user->save([
    			'password' =>$pwd 
    			],['uid'=> $uid]);
    		
    		if ($result) {
    			echo '<script>alert("修改完成");parent.location.href="http://www.goodjob.com/index/user/profile";</script>';
    		} else {
    			echo '<script>alert("修改失败");parent.location.href="http://www.goodjob.com/index/user/password";</script>';
    		}
    	}
	}
	/**
	 * 对企业中心的遍历
	 */
	public function resumecom()
	{
		$uid = Session::get('user')['uid'];
		$resumecom = Db::name('Business')->where('uid',$uid)->find();
		// dump($resumecom['picture']);
		// dump($resumecom);die();
		if($resumecom){
			$vocation = Db::name('vocation')->select();
			$city = Db::name('city')->select();
			$this->assign('resumecom',$resumecom);
			$this->assign('vocation', $vocation);
			$this->assign('city', $city);
			return $this->fetch();
			
		}else{
			$this->error('您还没有填写简历','http://www.goodjob.com/index/user/info');
		}
	}
	//修改企业信息
	public function upcompany()
	{
		$uid = Session::get('user')['uid'];
	
		$result = Db::name('business')->where('uid',$uid)->find();

		
		$city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        $this->assign('result',$result);
		$this->assign('city', $city);
        $this->assign('vocation', $vocation);
		return $this->fetch();
	}
	//对数据进行提交处理如果用户没有填写资料则不能修改
	public function updateCompany()
	{
		$uid = Session::get('user')['uid'];
		$Bus = new Business;
		//对提交过来的数据进行处理

		$username = $_POST['name'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$contactor = $_POST['contactor'];
		$history = $_POST['history'];
		$category = $_POST['category'];

		$resumecom = Db::name('Business')->where('uid',$uid)->select();
		// dump($resumecom );die();
		if ($resumecom) {
			//form 提交过来的数据更新
			$updateCompany = $Bus->save([
			'name' => $username,
			'address' => $address,
			'phone' => $phone,
			'contactor'=> $contactor,
			'history' => $history,
			'category' => $category
			],['uid' => $uid]);
			
			if ($updateCompany)	{
				
				// echo '<script>alert("修改成功");parent.location.href="http://www.goodjob.com/index/user/resumecom";</script>';
				$this->success('修改完成', 'index/user/resumecom');
			}	
		} else {
			$this->error('请先填写企业资料','http://www.goodjob.com/index/user/info');
		}
	}

	//填写规则
	public function gui()
	{
		return $this->fetch();
	}
	/**
	 * 公司发布招聘的信息
	 */
	public function posinfo()
	{	
		// $uid = Session::get('user')['uid'];
		$voc = Db::name('vocation')->select();
		$category = Db::name('category')->select();
		$city = Db::name('city')->select();
		$this->assign('category',$category);
	 	$this->assign('voc',$voc);
	 	$this->assign('city',$city);
		return $this->fetch();
	}
	
	/**
	 * 对招聘信息的处理
	 */
	public function doPosinfo()
	{
		$post = new Position;
		$post->cid = $_POST['cid'];
		$post->vid = $_POST['vid'];
		$post->sid = $_POST['sid'];
		$post->uid = Session::get('user')['uid'];
		$post->person_num = $_POST['person_num'];
		$post->work_year = $_POST['work_year'];
		$post->qualication = $_POST['qualication'];
		$post->work_duty = $_POST['work_duty'];
		$post->position = $_POST['position'];
		$post->over_time = strtotime("+5 day");

		$result = $post->save();
		if ($result) {
			$this->success('发布成功','http://www.goodjob.com/index/user/gui');
		} else {
			$this->error('发布失败','http://www.goodjob.com/index/user/posinfo');
		}
	}
	//个人简历
	public function upresume()
	{
		return $this->fetch();
	}

	//简历信息处理
	public function doResume() 
	{
		$user_id = Session::get('user')['uid'];
		$person = new Personinfo();
		$personinfo = Db::name('personinfo')->where('user_id',$user_id)->find();

		if ($personinfo) {
			echo '<script>alert("简历已经填写过");parent.location.href="http://www.goodjob.com/index/user/profile";</script>';
		} else {

			if (empty($_POST['realname'])) {
				echo '<script>alert("用户名不能为空");parent.location.href="http://www.goodjob.com/index/user/resume";</script>';
			} 

			if (empty($_POST['e_mail'])) {
				echo '<script>alert("邮箱不能为空");parent.location.href="http://www.goodjob.com/index/user/resume";</script>';
			}

			if (empty($_POST['work_year'])) {
				echo '<script>alert("年限不能为空");parent.location.href="http://www.goodjob.com/index/user/resume";</script>';
			}

			if(empty($_POST['language'])) {
				echo '<script>alert("语言不能为空");parent.location.href="http://www.goodjob.com/index/user/resume";</script>';
			}

			if(empty($_POST['person_num'])) {
				echo '<script>alert("身份证号不能为空");parent.location.href="http://www.goodjob.com/index/user/resume";</script>';
			}

			if(empty($_POST['ed_ground'])) {
				echo '<script>alert("教育背景不能为空");parent.location.href="http://www.goodjob.com/index/user/resume";</script>';
			}

			if (empty($_POST['tel'])) {
				echo '<script>alert("手机号不能为空");parent.location.href="http://www.goodjob.com/index/user/resume";</script>';
			}

			$person->user_id = $user_id;
			$person->realname = $_POST['realname'];
			$person->sex = $_POST['sex'];
			$person->e_mail = $_POST['e_mail'];
			$person->birthday = $_POST['birthday'];
			$person->tel = $_POST['tel'];
			$person->work_year = $_POST['work_year'];
			$person->language = $_POST['language'];
			$person->person_num = $_POST['person_num'];
			$person->ed_ground = $_POST['ed_ground'];
			$person->experience = $_POST['experience'];
			$person->age = $_POST['age'];
			//保存
			$result = $person->save();
			if ($result) {
				// $this->redirect('index/user/profile');
				$this->success('填写成功','index/user/picture');
			} else {
				// $this->redirect('index/user/resume');
				$this->error('填写失败','index/user/profile');
			}
		}		
	}

	/**
	 * 对简历的修改
	 */
	public function updateResume()
	{
		$uid = Session::get('user')['uid'];
		$person = new Personinfo();
		$person->user_id = $uid;
		$person->realname = $_POST['realname'];
		$person->sex = $_POST['sex'];
		$person->e_mail = $_POST['e_mail'];
		$person->birthday = $_POST['birthday'];
		$person->tel = $_POST['tel'];
		$person->work_year = $_POST['work_year'];
		$person->language = $_POST['language'];
		$person->person_num = $_POST['person_num'];
		$person->ed_ground = $_POST['ed_ground'];
		$person->experience = $_POST['experience'];
		$person->age = $_POST['age'];

		//首先查出是否填写过，只有填写过，才能先修改
		$update= Db::name('personinfo')->where('user_id',$uid)->select();
		if ($update) {
			$updateResume = $person->save([
			'user_id' => $uid,
			'realname' =>$realname = $_POST['realname'],
			'sex' =>$sex = $_POST['sex'],
			'e_mail'=>$e_mail = $_POST['e_mail'],
			'birthday'=>$birthday = $_POST['birthday'],
			'tel' =>$tel = $_POST['tel'],
			'work_year'=>$work_year = $_POST['work_year'],
			'language'=> $language = $_POST['language'],
			'person_num'=> $person_num = $_POST['person_num'],
			'ed_ground' => $ed_ground = $_POST['ed_ground'],
			'experience' => $experience = $_POST['experience'],
			'age' => $age = $_POST['age']
			],['user_id' => $uid]);

			if ($updateResume) {
				// echo '<script>alert("修改成功");parent.location.href="http://www.goodjob.com/index/user/profile";</script>';
				$this->success('修改成功', 'index/user/find');
			} else {
				// echo '<script>alert("修改失败");parent.location.href="http://www.goodjob.com/index/user/resume";</script>';
				$this->error('修改失败','index/user/resume');
			}
	    } else {
	    		echo '<script>alert("请先填写简历");parent.location.href="http://www.goodjob.com/index/user/resume";</script>';
        }
    }

    /**
     * 对企业用户账号密码的修改
     */
    public function password()
    {
    	return $this->fetch();
    }

    public function doPassword()
    {
    	$user = new Company();
    	$uid = Session::get('user')['uid'];
    	$password1 = Db::name('company')->where('qid',$uid)->find();
    	// dump($password1);
    	$password2 = md5($_POST['password']);
    	$pwd = md5($_POST['repassword']);

    	if (empty($password2)) {
    		echo '<script>alert("请输入原密码");parent.location.href="http://www.goodjob.com/index/user/password";</script>';
    	}

    	if (empty($pwd)) {
    		echo '<script>alert("请输入新密码");parent.location.href="http://www.goodjob.com/index/user/password";</script>';
    	}

    	if ($password1['password'] != $password2) {
    		echo '<script>alert("你输入的密码不正确");parent.location.href="http://www.goodjob.com/index/user/password";</script>';
    	} else {
    		$user->password = $pwd;
    		$result = $user->save([
    			'password' =>$pwd 
    			],['qid'=> $uid]);
    		
    		if ($result) {
    			echo '<script>alert("修改完成");parent.location.href="http://www.goodjob.com/index/user/password";</script>';
    		} else {
    			echo '<script>alert("修改失败");parent.location.href="http://www.goodjob.com/index/user/password";</script>';
    		}
    	}
    }

    /**
     * 企业对用户简历的遍历
     */
    public function coume ()
    {
    	$id = Session::get('user')['uid'];

    	$business = Db::name('business')->select();
    	$company = Db::name('company')->select();
    	$personinfo = Db::name('personinfo')->select();
    	
    	if (empty($personinfo)) {
    		echo '<script>alert("暂时没有简历");parent.location.href="http://www.goodjob.com/index/user/gui";</script>';
    	} else {
	    	$this->assign('business', $business);
	    	$this->assign('personinfo', $personinfo);
	    	$this->assign('company',$company);
	    	$this->assign('id', $id);
    	}
    	
    	return $this->fetch();
    }

    /**
     * 用户提交申请后,企业查看简历
     */
    public function qualication ()
    {
    	$personinfo = Db::name('personinfo')->select();
    	$this->assign('personinfo', $personinfo);
    	return $this->fetch();
    }
    /**
     * 对用户中心简历的遍历
     */
    public function find()
    {	
    	$uid = Session::get('user')['uid'];
    	$personinfo = Db::name('personinfo')->select();
    	if (empty($personinfo)) {
    			echo '<script>alert("暂时没有简历");parent.location.href="http://www.goodjob.com/index/user/profile";</script>';
    	} else {
    		$this->assign('personinfo', $personinfo);
    		$this->assign('uid', $uid);
    	}
    	return $this->fetch();
    }

    /**
     * 修改用户图像
     */
    public function picture()
    {
    	return $this->fetch();
    }
    /**
     * 对用户的图像进行上传
     */
    public function upload()
    {
    	$uid = Session::get('user')['uid'];
    	$per = new personinfo();
		$file = request()->file('image');
		// 移动到框架应用根目录/public/uploads/ 目录下
		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

		if($info){
			$path = $info->getSaveName();

			$result = $per->save([
			'picture' => "$path"
			],['user_id' => $uid]);
			$this->success('上传成功','index/user/find');
		}else{
			$this->error('上传失败','index/user/picture');
	    }   
    }

    /**
     * 对企业的图像进行上传	
     */
    public function custome()
    {
     	return $this->fetch();
    }

     public function uploader()
    {
    	$uid = Session::get('user')['uid'];
    	$bus = new Business();

		$file = request()->file('image');
		// 移动到框架应用根目录/public/uploads/ 目录下
		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

		if($info){
			$path = $info->getSaveName();
			$result = $bus->save([
			'picture' => "$path"
			],['uid' => $uid]);
			$this->success('上传成功','index/user/resumecom');
		}else{
			$this->error('上传失败','index/user/gui');
	    }   
    }

    /**
     * 对企业发表的职位进行遍历
     */
    public function position()
    {
    	$uid = Session::get('user')['uid'];
    	$position = Db::name('position')->where('uid',$uid)->paginate(10);
    	
    	// dump($position);
    	// dump($uid);die();
    	if (empty($position)) {
    		$this->success('暂时没有发表职位');
    	} else {
    		$this->assign('position', $position);
    	}
    	return $this->fetch();
    }

      /**
     * 企业发布的职位详情的查看
     */
      public function request()
      {
      	$city = Db::name('city')->select();
      	$vocation = Db::name('vocation')->select();
      	$Position = Db::name('position')->select();
      	$category = Db::name('category')->select();
      	$this->assign('Position',$Position);
      	$this->assign('city', $city);
      	$this->assign('category', $category);
      	$this->assign('vocation', $vocation);
      	return $this->fetch();
      }

      /**
       * 	对找回密码的设置
       */
      public function hui()
      {
      	return $this->fetch();
      }


}
