<?php
namespace app\index\controller;
use app\index\controller\Auth;
use think\Db;
use app\index\controller;
use think\Session;
class User extends Auth
{

	


	public function checkPassword()
	{
		// dump($_POST);
		$qid = Session::get('user')['uid'];
		// dump($qid);
		if($qid){
			$result = Db::name('company')->where('qid',$qid)->find();
			$password = $result['password'];
			// dump($password);
			// dump(md5($_POST['password']));die;
			if(md5($_POST['password']) == $password){
					echo json_encode(array('status'=>1,'msg'=>'密码输入成功'));
			}
			// dump($result);die;
			
		}else{
			echo json_encode(array('status'=>0,'msg'=>'密码输入错误'));
		}
	}
   

}