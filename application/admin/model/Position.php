<?php

namespace app\admin\model;

use think\Model;
use think\Db;
use traits\model\SoftDelete;
class Position extends Model

{
	use SoftDelete;
	protected  $autoWriteTimestamp = 'timestamp';
	protected $update = [];

	
	/**
	 * 模糊查询职位
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public function findLike($name)
	{
		return Db::name('position')->order('pid')->where('position','like',"%$name%")->where('pid'>0)->paginate(10);
	}
	/**
	 * 职位
	 * @return [type] [description]
	 */
	public function sel()
	{
		return Db::name('position')->paginate(10);
	}
	/**
	 * 行业信息
	 * @return [type] [description]
	 */
	public function find()
	{
		return Db::name('vocation')->paginate(10);
	}

	/**
	 * 行业信息
	 * @return [type] [description]
	 */
	public function getAll()
	{
		return Db::name('vocation')->select();
	}
	/**
	 * 大板块
	 * @return [type] [description]
	 */
	public function findCate()
	{
		return Db::name('category')->select();
	}
	/**
	 * 所有招聘信息
	 * @return [type] [description]
	 */
	public function findWork()
	{
		// $selObj = $this->sel();
		// $findObj = $this->find();
		return Db::name('work_info')->select();
	}
	/**
	 * 查询所有所有城市
	 * @return [type] [description]
	 */
	public function findCity()
	{
		return Db::name('city')->select();
	}
	public function findGet($vid)

	{
		return Db::name('vocation')
					->where('vid',$vid)
					->update([
						'classname' => input('param.username'),
						'vid' => input('param.vid')
					]);
	}
	/**
	 * 删除行业
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function del($data)
	{
		return Db::name('vocation')->where('vid',$data)->delete();
	}
	/**
	 * 查询出所有行业信息
	 * @param  [type] $vid [description]
	 * @return [type]      [description]
	 */
	public function findOne($vid)
	{
		return Db::name('vocation')->where('vid',1)->find();
	}
	/**
	 * 更新行业信息
	 * @return [type] [description]
	 */
	public function vupdate($vid)

	{
		return Db::name('vocation')->where('vid',$vid)->update([
			'classname'=>input('post.classname'),
			'time'=>time()
			]);
	}
}