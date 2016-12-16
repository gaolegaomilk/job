<?php

namespace app\admin\model;

use think\Model;
use think\Db;
use traits\model\SoftDelete;


class Content extends Model
{
	use SoftDelete;
	protected  $autoWriteTimestamp = 'timestamp';
	protected $update = [];
	/**
	 * 显示所有信息
	 * @return [type] [description]
	 */
	public function news()
	{
		return Db::name('content')->paginate(2);
	}


	public function sel($tid)
	{

		return Db::name('content')->where('tid',$tid)->find();
	}

	public function del($tid)
	{
		return Db::name('content')->where('tid',$tid)->delete();
	}
}