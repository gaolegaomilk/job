<?php

namespace app\admin\controller;

use app\admin\controller\Auth;
use app\admin\model\Position;
use app\admin\model\User;
use app\admin\model\Content;
use think\Request;
use think\Db;
class Position extends Auth

{

	public function delete()
	{
		$tid = $_GET['tid'];

		$ok = new Content;
		$result = $ok->del($tid);
		if($result){
			$this->success('删除成功');
		}else{	
			$this->error('删除失败');
		}
	}
	/**
	 * 查看消息详情
	 * @return [type] [description]
	 */
	public function details()
	{
		$tid = $_GET['tid'];
		$obj = new Content;
		// dump($obj);die();
		$result = $obj->sel($tid);
		return view('', compact('result'));
	}
	/**
	 * 检测发布的信息
	 * @return [type] [description]
	 */
	public function addContent()
	{
		
		$data = ['title' => $_POST['title'],
			'content' => $_POST['content'],
			'create_time' => time()];
		$result = Db::name('content')->insert($data);
	
		if($data){
			$this->success('发送成功','Index/message');
		}else{
			$this->error('发送失败');
		}	
	}
	/**
	 * 显示公告
	 * @return [type] [description]
	 */
	public function content()
	{
		$obj = new Content;
		// dump($obj);die();
		$result = $obj->news();
		return view('', compact('result'));
	}
	/**
	 * 长期招聘
	 * @return [type] [description]
	 */
	public function length()
	{
		$obj = new Position;
		$pid = $_POST['pid'];
		if($_POST['button'] =='取消'){
			$result = $obj->save(['length' => 0],['pid' => $pid]);
			if($result){
				echo json_encode(array('status'=>'1','msg'=>'长期招聘'));
			}else{
				echo json_encode(array('status'=>'0','msg'=>'失败'));

			}
		}else if($_POST['button'] =='长期招聘'){
			$result = $obj->save(['length' => 1],['pid' => $pid]);
			if($result){
				echo json_encode(array('status'=>'1','msg'=>'取消'));
			}else{
				echo json_encode(array('status'=>'0','msg'=>'失败'));
			}
		}else{
			echo json_encode(array('status'=>0,'msg'=>'操作失败'));
		}
	}
	/**
	 * 热门招聘
	 * @return [type] [description]
	 */
	public function hot()
	{
		 //dump($_POST);die;
		$obj = new Position();
		// $pid = $_GET['pid'];
		$pid = $_POST['pid'];
		if($_POST['button'] =='取消'){
			$result = $obj->save(['hot' => 0],['pid' => $pid]);

			if($result){
				echo json_encode(array('status'=>'1','msg'=>'热门职位'));
			}else{
				echo json_encode(array('status'=>'0','msg'=>'失败'));

			}
		}else if($_POST['button'] =='热门职位'){
			$result = $obj->save(['hot' => 1],['pid' => $pid]);
			if($result){
				echo json_encode(array('status'=>'1','msg'=>'取消'));
			}else{
				echo json_encode(array('status'=>'0','msg'=>'失败'));

			}
		}else{
			echo json_encode(array('status'=>0,'msg'=>'操作失败'));
		}

		// $result = $obj->save(['hot' => 0],['pid' => $pid]);
		// if($result){
		// 	$this->success('保存成功');
		// }else{
		// 	$this->error('失败');
		// }
	}

	public function position()
	{
		$posit = Position::get();
		$vo = $posit->sel();
		$result = $posit->find();
		return view('', compact('vo','result'));
	}
	/**
	 * 招聘信息
	 * @return [type] [description]
	 */
	public function option()
	{
		$name = $_POST['username'];
		$like = Position::get();
		$result = $like->findLike($name);
		$find = $like->find();
		$findCate = $like->findCate();
		$findPosi = $like->sel();
		$city = $like->findCity();
		$info = User::get();
		$findBus = $info->findBus();
		return view('',compact('result','find','findCate','findPosi','city','findBus'));
	}
	/**
	 * 删除行业职位
	 * @param  [type] $vid [description]
	 * @return [type]      [description]
	 */
	public function del($vid)
	{
		//Position::destroy($vid);
		$res = input('param.vid');
		$s=new Position;
		$res1= $s->del($res);
		 //dump($res1);//die();
		if($res1){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
	/**
	 * [checkData description]添加职位信息
	 * @param  Request $Request [description]
	 * @return [type]           [description]
	 */
	public function add()
	{
		$cate = Position::get();
		$category = $cate->findCate();
		$result = $cate->find();
		return view('', compact('category','result'));
	}
	/**
	 * [checkData description]检测传递职位信息
	 * @param  Request $Request [description]
	 * @return [type]           [description]
	 */
	public function checkData()
	{
		
		$data['classname'] = $_POST['classname'];
		$data['time'] = time();
		$result = Db::name('vocation')->insert($data);
		dump($result);
		if($result){
			$this->success('职位添加成功','Position/position');
		}else{
			$this->error('添加失败');
		}
	}

	/**
	 * 修改行业信息
	 * @param  [type] $vid [description]
	 * @return [type]      [description]
	 */
	public function edit()
	{	
		$vid = $_GET['vid'];
		
		$obj = new Position();
		$result = $obj->findOne($vid);
		return view('',compact('result'));
	}
	/**
	 * 输出招聘信息详情
	 * 
	 * @return [type] [description]
	 */
	public function info()
	{
		$msg = new Position;
		$find = $msg->getAll();
		$findCate = $msg->findCate();
		$findPosi = $msg->sel();
		
		$city = $msg->findCity();
		$info = new User();
		$findBus = $info->findBus();

		// dump($info);die();
		// dump($find);
		// dump($city);
		// // dump($findCate);dump($findPosi);dump($findBus);
		// die();
	
		return view('', compact('find','findCate','findPosi','findBus','city'));

	}
	/**
	 * 更新行业数据
	 * @return [type] [description]
	 */
	public function update($vid)
	{

		$obj = Position::get();
		$result = $obj->vupdate($vid);
		if($result){
			$this->success('修改成功','position');
		}else{
			$this->error('修改失败');
		}
	}

}