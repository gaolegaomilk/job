<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
use app\index\model\Category;
use think\Db;
use app\index\model\City;
use app\index\model\Vocation;
use app\index\model\Position;
use think\db\Query;
use think\Session;
use app\index\model\Business;
use app\index\model\Content;
class Index extends Controller
{ 
      /**
       * 对页面板块类型的遍历  招聘类型，行业 工作地区 职位
       */
    public function index()
    {
		
		$obj = new Content;
        $con = $obj->sel();
        $hot = $obj->hot();
        $len = $obj->length();
        // dump($len);die;
        // dump($len);die();
        $this->assign('con',$con);
        $this->assign('hot',$hot);
        $this->assign('len',$len);
		
        $arr = [];
        $category= Db::name('category')->select();
        $city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        //查询出所有公司发布的职位，从职位表查取职位去除次重复
        $select = Db::name('position')->paginate(6);
        $page = $select->render();
        // dump($select);die();
        foreach ($select as $sel) {
            $unique = $sel['position'];
            $arr[] = $unique;    
        }
        //PHP内置函数去除重复
        $array_uniqued = (array_unique($arr));
      
        $this->assign('array_uniqued', $array_uniqued);
        $this->assign('category',$category);
        $this->assign('city', $city);
        $this->assign('vocation', $vocation);
        $this->assign('select', $select);
        $this->assign('page', $page);
        // $list = Db::name('position')->where()->paginate(10);
        //去除重复的查询
    	return $this->fetch();
    }

    public function jobs()
    {
        return $this->fetch();
    }

    public function social()
    {
        //对地区和行业的查询
        $category= Db::name('category')->select();
        $city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        //职位表的内容
        $select = Db::name('position')->select();
        //公司的资料
        $business = Db::name('business')->select();
        //dump($select);
        foreach ($select as $sel) {
            $unique = $sel['position'];
            $arr[] = $unique;    
        }
        //PHP内置函数去除重复
        // $array_uniqued = (array_unique($arr));
        // $this->assign('array_uniqued', $array_uniqued);
        $this->assign('category',$category);
        $this->assign('city', $city);
        $this->assign('vocation', $vocation);
        $this->assign('business', $business);
        $this->assign('select', $select);
        //$this->assign('page', $page);

        return $this->fetch();
    }

    public function school()
    {
         //对地区和行业的查询
        $category= Db::name('category')->select();
        $city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        //公司的资料
        $business = Db::name('business')->select();
        $select = Db::name('position')->select();
        foreach ($select as $sel) {
            $unique = $sel['position'];
            $arr[] = $unique;    
        }
        //PHP内置函数去除重复
        //$array_uniqued = (array_unique($arr));
       // $this->assign('array_uniqued', $array_uniqued);
        $this->assign('category',$category);
        $this->assign('city', $city);
        $this->assign('vocation', $vocation);
        $this->assign('business', $business);
        $this->assign('select',$select);
        return $this->fetch();
    }

    public function newstudent()
    {
         //对地区和行业的查询
        $category= Db::name('category')->select();
        $city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        $business = Db::name('business')->select();
        $select = Db::name('position')->select();
        foreach ($select as $sel) {
            $unique = $sel['position'];
            $arr[] = $unique;    
        }
        //PHP内置函数去除重复
        // $array_uniqued = (array_unique($arr));
        // $this->assign('array_uniqued', $array_uniqued);
        $this->assign('category',$category);
        $this->assign('city', $city);
        $this->assign('vocation', $vocation);
        $this->assign('business', $business);
        $this->assign('select', $select);
        return $this->fetch();
    }

    public function about()
    {
        return $this->fetch();
    }

    public function contact()
    {
        return $this->fetch();
    }

    public function details()
    {
        //对提交的申请
        $arr = [];
        $category= Db::name('category')->select();
        $city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        $select = Db::name('position')->select();

        foreach ($select as $sel) {
            $unique = $sel['position'];
            $arr[] = $unique;    
        }
        //PHP内置函数去除重复
        //$array_uniqued = (array_unique($arr));
        $this->assign('category',$category);
        $this->assign('city', $city);
        $this->assign('vocation', $vocation);
        $this->assign('select', $select);
       //$this->assign('array_uniqued', $array_uniqued);
       //提交信息
      
        return $this->fetch();
    }

      /**
     * 招聘动态详情
     * @return [type] [description]
     */
    public function news_detail()
    {
        $obj = new Content;
        $con = $obj->sel();
        $this->assign('con',$con);

        $tid = $_GET['tid'];
        $obj = new Content();
        $info = $obj->findinfo($tid);
        
        $this->assign('info',$info);
        //dump($info);die;
        return $this->fetch();
        // return view('', compact('info'));
    }
     /** 
      * 对首页社会招聘类的遍历
      */
     public function content()
    {
        $arr = [];
        $category= Db::name('category')->select();
        $city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        $select = Db::name('position')->select();

        foreach ($select as $sel) {
            $unique = $sel['position'];
            $arr[] = $unique;    
        }
        //PHP内置函数去除重复
        //$array_uniqued = (array_unique($arr));
        $this->assign('category',$category);
        $this->assign('city', $city);
        $this->assign('vocation', $vocation);
        $this->assign('select', $select);
        //$this->assign('array_uniqued', $array_uniqued);
        //对内容的要求遍历出来
        return $this->fetch();
    }

        //对校园招聘的遍历
    public function class()
    { 
        $arr = [];
        $category= Db::name('category')->select();
        $city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        $select = Db::name('position')->select();

        foreach ($select as $sel) {
            $unique = $sel['position'];
            $arr[] = $unique;    
        }
        //PHP内置函数去除重复
        $array_uniqued = (array_unique($arr));
        // dump($array_uniqued);
        // dump($select);
        $this->assign('category',$category);
        $this->assign('city', $city);
        $this->assign('vocation', $vocation);
        $this->assign('select', $select);
        $this->assign('array_uniqued', $array_uniqued);
        //对内容的要求遍历出来
        return $this->fetch();

    }
       //对实习生的招聘
    public function new()
    {
        $arr = [];
        $category= Db::name('category')->select();
        $city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        $select = Db::name('position')->select();

        foreach ($select as $sel) {
            $unique = $sel['position'];
            $arr[] = $unique;    
        }
        //PHP内置函数去除重复
        $array_uniqued = (array_unique($arr));
        // dump($array_uniqued);
        // dump($select);
        $this->assign('category',$category);
        $this->assign('city', $city);
        $this->assign('vocation', $vocation);
        $this->assign('select', $select);
        $this->assign('array_uniqued', $array_uniqued);
        //对内容的要求遍历出来
        return $this->fetch();
    }

    //搜索
    public function search()
    {
       
        $arr = [];
        $arr1 = [];
        $cite= [];
        $voc = [];
        $category= Db::name('category')->select();
        $city = Db::name('city')->select();
        $vocation = Db::name('vocation')->select();
        $select = Db::name('position')->select();

        foreach ($city as $city1) {
            $cite2 = $city1['sid'];
            $cite[] = $cite2;  
        }

        $cite = join(',',$cite);
        //对行业
         foreach ($vocation as $vocation1) {
            $vocation2 = $vocation1['vid'];
            $voc[]= $vocation2;
        }
        $voc = join(',',$voc);

        foreach ($select as $sel) {
            $unique = $sel['position'];
            $arr[] = $unique;  
            $unique1 = $sel['pid'];  

        }
        $pos = join(',',$arr1);
       
        //PHP内置函数去除重复
        // $array_uniqued = (array_unique($arr));
        // dump($array_uniqued);die();
        $this->assign('category',$category);
        $this->assign('city', $city);
        $this->assign('vocation', $vocation);
        $this->assign('select', $select);
        // $this->assign('array_uniqued', $array_uniqued);

        $sid = $_POST['sid'];
        $cid = $_POST['cid'];
        $vid = $_POST['vid'];
        $search = $_POST['search'];
        //对地区的判断
        if ($sid == 0) {
            //把$cite 作为条件查询
            $sid = $cite;
        } 
        //对板块
        if ($cid ==0) {
            $cid = '1,2,3';
        }
        //对行业
        if ($vid == 0) {
            $vid = $voc;
        }
        //判断内容是否为空
        if ($search == ''){
            $search = '%';
        } else {
            $search = '%'.$search.'%';
        }

       $data = Db::name('position')
                    ->where('sid', 'in', $sid)
                    ->where('cid', 'in', $cid)
                    ->where('vid', 'in', $vid)->where('position','like',$search)
                    ->paginate(30);;
        $page = $data->render();

        $this->assign('data', $data); 
        $this->assign('page', $page);
        return $this->fetch();
    }

    public function add()
    {
        //查出企业信息表中有没有用户信息

        $uid = Session::get('user')['uid'];

        $bid = $_GET['id'];
        $bus = new Business();
        $bus->user_id = $bid;
         if (empty($uid)) {
            $this->error('请先登录','index/index');
        } else {

            //对企业进行查询是否用户已经对本公司提交过申请
            $info = Db::name('business')->where('uid',$bid)->select();
            $person = Db::name('personinfo')->where('user_id', $uid)->select();
            if (empty($person)){
               $this->success('你还没有填写简历','index/index');
            } 
            if ($info[0]['user_id'] == $uid) {
                $this->success('你已经申请过,7天后可以申请');
            } else {
                 $add = $bus->save(['user_id' => $uid],['uid'=> $bid]); 
                 if ($add) {
                     $this->success('申请成功','index/index');
                   }else {
                     $this->error('申请失败', 'index/user/login');
                   }
            } 
        }
    }
}


