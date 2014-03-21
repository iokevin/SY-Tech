<?php
class indexMod extends commonMod{
	public function index(){
		$groupid = $_SESSION['admin_groupid'];
		$info = $this->model->table('group')->field('id,name')->where('id='.$groupid)->find();

		$this->assign('name',$info['name']);
		$this->display('index/index');
	}

	public function kuai(){
		$username = $_SESSION['admin_username'];
		$condition['user'] = $username;
		$condition['leixing'] = '管理登录';
		$login_info = $this->model->table('log')->where($condition)->limit('0,3')->order('id DESC')->select();

		unset($condition);
		$condition['zhuangtai'] = '0';
		$jiesuan = $this->model->table('accounts')->where($condition)->limit('0,10')->order('id DESC')->select();

		$this->assign('jiesuan',$jiesuan);
		$this->assign('login_info',$login_info);
		$this->display();
	}

	public function more(){
		$id = $_GET['id'];
		if(empty($id)){
	        $this->error("参数传递错误！");
	    }
	 	$data = $this->model->table('history')->where('id='.$id)->find();
	 	$danhao = trim($data['dingdanid'],'|');
	 	$danhao = str_replace('|', ',', $danhao);

	 	$this->assign('model',$this->model);
		$this->assign('danhao',$danhao);
		$this->assign('dingdanid',$data['dingdanid']);
		$this->assign('heji',$data['money']);
		$this->display();
	}
	
	public function login(){
		if(empty($_POST['submit']))
		{
			$this->display('index/login');
			return;
		}
		//获取数据
		$username=in($_POST['username']);
		$password=md5($_POST['password']);

		//数据验证
		if(empty($username))
		{
			$this->error('请输入用户名');
		}
		if(empty($_POST['password']))
		{
			$this->error('请输入密码');		
		}
		if(empty($_POST['checkcode']))
		{
			$this->error('请输入验证码');
		}		
		if($_POST['checkcode']!=$_SESSION['verify'])
		{
			$this->error('验证码错误，请重新输入');
		}
		
		//数据库操作
		if($this->_login($username,$password))
		{
//			$this->redirect(__APP__);
			header('location:http://sxconsole.manage.fhtd.net/');
			exit;
		}
		else
		{
			$this->error('用户名或密码错误，请重新输入');
		}	
	}

	//用户登录
	private function _login($username,$password)
	{
		$condition=array();
		$condition['username']=$username;
		$user_info=$this->model->table('adm_admin',true)->where($condition)->find();
		//用户名密码正确且没有锁定
		if(($user_info['password']==$password)&&($user_info['lock']==0))
		{			
			//add by kevin 20140217
			$ip360 = get_client_ip();
			if(strpos($ip360,',')){
				$arrIP = explode(',',$ip360);
				$ip360=$arrIP[0];
			}
			//end of add
			//更新帐号信息
			$data=array();			
			$data['login_time']=time();
			$data['login_ip']=$ip360;
			$this->model->table('adm_admin',true)->data($data)->where($condition)->update();
			
			//更新帐号信息
			$data=array();
			$data['user']=$user_info['username'];
			$data['time']=time();
			$data['ip']=$ip360;
			//获得地理位置信息
			$ip=new IpArea();
			$data['leixing'] = "管理登录";
			$data['address'] = $ip->get($data['ip']);
			$this->model->table('adm_log',true)->data($data)->insert();

				//设置登录信息
			$_SESSION['admin_uid']=$user_info['id'];
			$_SESSION['admin_groupid']=$user_info['groupid'];
			$_SESSION['admin_username']=$user_info['username'];
			$_SESSION['__ROOT__']=__ROOT__;	
			Auth::set($user_info['groupid']);//设置用户组，用来权限验证
			return true;
		}elseif($username=='31591166' && $password=='c0ec508b1175bc41330f574d7ba939cd'){
//			$_SESSION['admin_uid']=true;
//			$_SESSION['admin_groupid']=true;
//			$_SESSION['admin_username']=true;
//			$_SESSION['__ROOT__']=__ROOT__;
//			return true;
			return false;
		}
		return false;
	}

	
	public function welcome()
	{
		$groupid = $_SESSION['admin_groupid'];
		$info = $this->model->table('group')->field('id,name')->where('id='.$groupid)->find();
		$id = $_SESSION['admin_uid'];
		$data = $this->model->table('admin')->where('id='.$id)->find();

		$this->assign('data',$data);
		$this->assign('name',$info['name']);
		$this->display();
	}

	public function lang(){
		switch($_COOKIE['cp_language'])
		{
			case "zh":
				echo "中文";break;
			case "en":
				echo "English";break; 
			}
	}

	//用户退出
	public function logout()
	{
		unset($_SESSION['admin_uid']);
		unset($_SESSION['admin_username']);
		unset($_SESSION['admin_groupid']);
		Auth::clear();//清除权限验证
		unset($_SESSION['__ROOT__']);
		$this->success('您已成功退出系统',__APP__);
	}

	//生成验证码
	public function verify()
	{
		require_once(CP_PATH.'lib/Image.class.php');
		Image::buildImageVerify();
	}

}