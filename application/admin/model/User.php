<?php 

namespace app\admin\model;
use think\Model;
use think\Db;
use think\Request;
use traits\model\SoftDelete;
use think\Session;
class User extends Model

{
	use SoftDelete;
	protected static $deleteTime = 'delete_time';
	protected  $autoWriteTimestamp = 'timestamp';


	// public function num()
	// {
	// 	//$result = Db::name('user')->where('sex','<','27')->select();
	// 	return db('personinfo')->where('age', 'between','18, 27')->count();
	// 	return db('personinfo')->where('age', 'between','28, 37')->count();
	// 	return db('personinfo')->where('age', 'between','38, 47')->count();
	// }
		/**
	 * 查询所有没被删除的用户
	 * @return [type] [description]
	 */
	public function sel()
	{
		return Db::table('job_user')->where('delete_time','Null')->paginate(10);
	}
	public function findSel()
	{
		return Db::name('user')->where('delete_time','neq','Null')->select();
	}

	/**
	 * [profile 超管]
	 * @return [type] [description]
	 */
	public function personinfo()
	{
		//return Db::name('personinfo')->where('user_id', 1)->select();
		return $this->hasOne('PersonInfo','user_id','uid');
		
	}
	
	public function userinfo($uid)
	{
		
		return Db::table('job_personinfo')
					->where('user_id',$uid)
					->select();
	}
	/**
	 * [edit 获取普通修改后的信息]
	 * @param  [type] $id [用户id]
	 * @return [type]     [description]
	 */
	public function edit($id)
	{
		
		// return Db::table('job_personinfo')
		// 			->where('user_id',$id)
		// 			->update(['realname'=>input('post.username'),
		// 					'sex'=>input('post.sex'),
		// 					'birthday'=>input('post.birthday'),
		// 					'e_mail'=>input('post.email'),
		// 					'tel'=>input('post.tel'),
		// 					'ed_ground'=>input('post.ed_ground'),
		// 					'language'=>input('post.language'),
		// 					'work_year'=>input('post.work_year')
		// 				]);
	}

	/**
	 * [editcom 查询企业信息]
	 * @return [type] [description]
	 */
	public function editcom()
	{
		return Db::table('job_company')->where('delete_time','Null')->paginate(10);
	}

	public function getUser($username)
	{
		return Db::name('user')->where('email',$username)->find();
	}
	/**
	 * [findBus description]
	 * @return [type] [description]
	 */
	public function findBus()

	{
		return Db::name('business')->select();	
	}
	/**
	 * 普通用户恢复
	 * @param  [type] $uid [description]
	 * @return [type]      [description]
	 */
	public function findId($uid)
	{
		return Db::name('user')->where('uid',$uid)->setField('delete_time', null);
		
	}
	// /**
	//  * 企业回复
	//  * @param  [type] $uid [description]
	//  * @return [type]      [description]
	//  */
	// public function findTo($uid)
	// {
	// 	$result = Db::name('company')->where('qid',$uid)->setField('delete_time', '');
	// 	dump($result);
	// }
	

	public function missage()
	{
		$user_id = Session::get('uid');
		Db::name('user join personinfo')->where('uid',$user_id)->find();
	}
}