<?php


namespace app\index\controller;

use app\index\controller\Auth;
use app\index\model\Content;
class Content extends Auth

{

	public function show()
	{
		$obj = new Content;
		$result = $obj->sel();
		return view();
	}
}