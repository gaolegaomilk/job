<?php


namespace app\admin\controller;

use app\admin\controller\Auth;
use app\admin\model\User;
use app\admin\model\Company;
use app\admin\model\Position;
use app\admin\model\Personinfo;
use think\Db;
// use think\Loader;
class User extends Auth
{
	// public function u()
	// {
	// 	$obj = User::find(1);
	// 	dump($obj->profile->realname);
	// }

	public function profile()
	{
		return $this->fetch();
	}
	/**
	 * 企业回复
	 * @return [type] [description]
	 */
	public function resetTo()
	{
		$uid = $_GET['uid'];
		$user = new Company;
		$id = $user->findId($uid);
		if($id){
			$this->success('恢复成功');
		}else{
			$this->error('失败');
		}
	}
	/**
	 *	普通用户恢复 
	 ** @return [type] [description]
	 */
	public function reset()
	{
		// dump($uid);die();
		$uid = $_GET['uid'];
		$user = new User;
		$id = $user->findId($uid);
		if($id){
			$this->success('恢复成功');
		}else{
			$this->error('失败');
		}
	}
	/**
	 * 普通用户锁定
	 * @return [type] [description]
	 */
	public function suo()
	{
		$id = $_GET['uid'];
		// dump($id);die();
		$result = User::destroy($id);
		if($result){
			$this->success('成功加入黑名单');
		}else{
			$this->error('黑名单加入失败');
		}
	}
	/**
	 * [del 普通用户删除]
	 * @param  [type] $uid [description]
	 * @return [type]      [description]
	 */
	public function del($uid)
	{
		$uid = User::destroy($uid);
		// dump($uid);die();
		if($uid){
			$this->success('删除成功','__ADMIN__SITE__/admin/index/userInfo');
		}else{
			$this->error('删除失败');
		}
	}
	/**
	 * [update 普通用户更新]
	 * @return [type] [description]
	 */
	public function update()
	{
		
		$id = $_POST['id'];
		$obj = new User();
		$data = $obj->edit($id);
		if($data){
			$this->success('保存成功');
		}else{
			$this->error('更新失败');
		}
	}
	/**
	 * [edit 普通用户简历查询]
	 * @return [type] [description]
	 */
	public function edit()
	{

		
		$uid = $_GET['uid'];
		$user = new User();
		$info = $user->userinfo($uid);
		if($info){
			return view('',compact('info'));
		} else {
			return $this->error('该用户还没有填写简历');
		}
		
	}
	/**
	 * 公司详情
	 * @return [type] [description]
	 */
	public function editcom()
	{
		
		$qid = $_GET['qid'];
		$info = new Company();
		$cinfo = $info->selAll($qid);
		$obj = new Position();
		$city = $obj->findCity();
		$vocation = $obj->find();
		$voca = '';
		foreach ($vocation as $value) {
			if($cinfo['category'] == $value['vid']){
				$voca .= $value['classname'];
			}
		}
		$str = '';
		foreach($city as $val){
			if($cinfo['address'] == $val['sid']){
				$str .= $val['classname'];
			}
		}
		
		// dump($str);die();
		if($cinfo){
			return view('',compact('cinfo','str','voca'));
		}else{
			return $this->error('该用户还没有填写企业信息');
		}
		
	}

	/**
	 * [delcom 删除公司信息]
	 * @param  [type] $qid [description]
	 * @return [type]      [description]
	 */
	public function delcom($qid)
	{


		$result = Company::destroy($qid);
		if($result){
			$this->success('删除成功','__ADMIN__SITE__/admin/index/identify');
		}else{
			$this->error('删除失败');
		}
	}
	/**
	 * [bupdate 更新企业信息]
	 * @return [type] [description]
	 */
	public function bupdate()
	{

		$id = $_REQUEST['id'];
		$result = Company::destroy($id);
		if($result){
			$this->success('成功加入黑名单');
		}else{
			$this->error('黑名单加入失败');
		}
		// $obj = new Company();
		// $data = $obj->edit($id);
		// if($data){
		// 	$this->success('保存成功');
		// }else{
		// 	$this->error('更新失败');
		// }
	}

	public function login()
	{
		return view();
	}




	public function fff()
	{
		$pro = User::alias('a')
		->join('Personinfo b','a.uid = b.user_id')
		->select();
		//->field('a.id,name,email');
		// $pro = $pro->id();
		dump($pro);
		die();
	}

	// public function aaa()
	// {
	// 	$result  = Db::query('select * from job_user join job_personinfo on job_user.uid = job_personinfo.user_id where job_user.uid = 73');
	// 	dump($result);
	// }
}