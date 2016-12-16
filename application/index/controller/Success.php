<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Auth;
use
class Success extends Auth
{
	public function success()
    {
    	return $this->fetch();
    }

}

