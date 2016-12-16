<?php


namespace app\admin\controller;
//use think\Controller;
use app\admin\controller\Auth;
use app\admin\model\User;
use app\admin\model\Company;
use app\admin\model\Position;
use app\admin\model\Content;
use think\Session;
use think\Db;
use think\Connection;
//use think\Tpl;
//use think\View;
class Index extends Auth

{
	// public function _initialize()
	// {
	// 	$user = new User();
	//     $name = $user->profile();
	// 	$this->assign('name', $name);
	// }
	// 
	
	public function zhu()
	{
		$a00 = db('personinfo')->where('age', 'between','1, 18')->count();
		$a90 = db('personinfo')->where('age', 'between','18, 27')->count();
		$a80 = db('personinfo')->where('age', 'between','28, 37')->count();
		$a70 = db('personinfo')->where('age', 'between','38, 47')->count();
		$nuth = db('personinfo')->where('age', '>','47')->count();
		// dump($a00, $a90);die;
		$cbeijing = db('business')->where('address','1')->count();
		$ctianjin = db('business')->where('address','2')->count();
		$cbaoding = db('business')->where('address','3')->count();
		$cqinhuangdao = db('business')->where('address','4')->count();
		$ctangshan = db('business')->where('address','5')->count();
		// dump($ctangshan);die;
		$czhangjiakou = db('business')->where('address','6')->count();
		// dump($czhangjiakou);die;
		$cchengde = db('business')->where('address','7')->count();
		$ccangzhou = db('business')->where('address','8')->count();

		//$result = Db::name('user')->select();
		return view('',compact('a90','a80','a70','nuth','cbeijing','ctianjin','cbaoding','czhangjiakou','ccangzhou','ctangshan','cchengde','cqinhuangdao','a00'));
	}
	/**
	 * 职位列表
	 * @return [type] [description]
	 */
	public function posi()
	{
		$obj = new Position();
		$result = $obj->sel();
		// dump($result);die;
		return view('', compact('result'));
	}
	public function web()
	{
		
		$obj = new User;
		if($_POST['button'] == '开启'){
			// $result = $obj->save(['web'=>1],['uid'=>73]);
			// 
			$result = Db::name('user')->where('uid', 73)->update(['web'=>1]);
			// dump($result);die();
			if($result){
				echo json_encode(array('status'=>1,'msg'=>'关闭'));
			}else{
				echo json_encode(array('status'=>0,'msg'=>'失败'));
			}
		}else if($_POST['button'] == '关闭'){

			//$result = Db::name('user')->where('uid', 73)->setField('web',0);
			$result = $obj->save(['web'=>0],['uid'=>73]);

			// dump($result);die;
			if($result){
				echo json_encode(array('status'=>1,'msg'=>'开启'));
			}else{
				echo json_encode(array('status'=>0,'msg'=>'失败'));
			}
		}else{
			echo json_encode(array('status'=>0,'msg'=>'操作错误'));
		}
		
	}
	/**
	 * 后台首页
	 * @return [type] [description]
	 */
	public function index()
	{
		//dump(Session::get('user'));die;
		return View();
	}
	/**
	 * 企业详情展示
	 * @return [type] [description]
	 */
	public function identify()
	{
		$com = new User;
		 
		$binfo = $com->editcom();
		// $page = $binfo->rendor
		//dump($binfo);
		return view('',compact('binfo'));
	}
	/**
	 * 消息显示
	 * @return [type] [description]
	 */
	public function message()
	{
		$posi = new Content();
		$result = $posi->news();
		return view('',compact('result'));
	}
	/**
	 * 用户详情展示
	 * @return [type] [description]
	 */
	public function userinfo()
	{
		$user = new User;
		$arr = $user->sel();
		return view('',compact('arr'));
	}
	/**
	 * 站点展示
	 * @return [type] [description]
	 */
	public function webset()
	{
		$result = Db::name('user')->where('uid',73)->find();
		//dump($result);die();
		//
		$a90 = db('personinfo')->where('age', 'between','18, 27')->count();
		$a80 = db('personinfo')->where('age', 'between','28, 37')->count();
		$a70 = db('personinfo')->where('age', 'between','38, 47')->count();
		$nuth = db('personinfo')->where('age', 'not between','18, 47')->count();

		$cbeijing = db('business')->where('address','1')->count();
		$ctianjin = db('business')->where('address','2')->count();
		$cbaoding = db('business')->where('address','3')->count();
		$cnuth = db('business')->where('address','not in','1,2,3')->count();
		return view('',compact('result','a90','a80','a70','nuth','cbeijing','ctianjin','cbaoding','czhangjiakou','cnuth'));
	}


	public function vocation()
	{
		$voca = new Vocation();
		$vo = $voca->sel();
		dump($vo);die();
		return view();
	}

	/**
	 * 黑名单
	 * @return [type] [description]
	 */
	public function blacklist()
	{
		 $result = new Company();
		 $result = $result->sel();
		 $userObj = new User();
		 $res = $userObj->findSel();

		//$result = Company::onlyTrashed()->select();
		// foreach ($result as  $value) {
		// 	dump($value);die();
		// }
		 // dump($result);die();
		return view('',compact('result','res'));
	}
}