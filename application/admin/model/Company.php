<?php 

namespace app\admin\model;

use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Company extends Model
{
	use SoftDelete;
	protected static $deleteTime = 'delete_time';
	protected  $autoWriteTimestamp = 'timestamp';
	public function sel()
	{
		return Db::name('company')->where('delete_time', 'neq', 'Null')->select();
	}
	/**
	 * [selAll 查询所有企业用户信息]
	 * @return [type] [description]
	 */
	public function selAll($qid)
	{
		return  Db::table('job_business')->where('uid',$qid)->find();
	}

	public function edit($id)
	{
		
		return Db::table('job_business')
					->where('uid',$id)
					->update(['name'=>input('post.name'),
							'address'=>input('post.address'),
							'phone'=>input('post.phone'),
							'contactor'=>input('post.contactor'),
							'category'=>input('post.category'),
							'history'=>input('post.history')
						]);
	}

	/**
	 * 锁定用户
	 * @return [type] [description]
	 */
	public function banUser($uid)
	{
		// $result = Db::name('user')->where('uid',$uid)->find();
		// // dump($result);die();
		// return $result['ban'];
		// if($result['ban'] == 1){
		// 	Db::name('user')->where('uid',$uid)->update(['ban']);
		// }
	}
	/**
	 * 企业用户恢复
	 * @param  [type] $uid [description]
	 * @return [type]      [description]
	 */
	public function findId($uid)
	{
		return Db::name('company')->where('qid',$uid)->setField('delete_time', null);
	}


	// public function profile()
	// {
	// 	return $this->hasOne('Business')->field();
	// }
}
