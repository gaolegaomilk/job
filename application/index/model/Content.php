<?php


namespace app\index\model;
use think\Model;
use think\Db;
class Content extends Model
{
	protected $autoWriteTimestamp = 'timestamp';
	public function sel()
	{
		return Db::name('content')->limit(5)->select();
	}

	public function findinfo($tid)
	{
		return Db::name('content')->where('tid',$tid)->find();
	}

	/**
	 * 热门招聘
	 */
	
	public function hot()
	{
		return Db::name('position')->where('hot',1)->select();
	}

	public function length()
	{
		return Db::name('position')->where('length', 1)->select();
	}
}