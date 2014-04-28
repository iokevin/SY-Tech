<?php
class indexMod extends commonMod{
	public function index(){
		
		$this->display();
	}

	public function login(){
		if(empty($_POST['do']))
		{
			$this->display();
			return;
		}
		//获取数据
		$username=in($_POST['username']);
		$password=substr(md5($_POST['password']),8,16);

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
			header('location:http://sx.fhtd.net/');
			exit;
		}
		else
		{
			$this->error('用户名密码错误或正等待审核...');
		}	
	}


	//用户登录
	private function _login($username,$password)
	{
		$condition=array();
		$condition['username']=$username;
		$user_info=$this->model->table('adm_user',true)->where($condition)->find();
		//用户名密码正确且没有锁定
		if(($user_info['password']==$password) && ($user_info['jh']==0 || $user_info['jh']==2 || $user_info['jh']==3))
		{			
			//更新帐号信息
			$data=array();
			$data['user']=$user_info['username'];
			$data['time']=time();
			$data['ip']=get_client_ip();
			//add by kevin 20140217
			if(strpos($data['ip'],',')){
				$arrIP = explode(',',$data['ip']);
				$data['ip']=$arrIP[0];
			}
			//end of add
			//获得地理位置信息
			$ip=new IpArea();
			$data['leixing'] = "用户登录";
			$data['address'] = $ip->get($data['ip']);
			$this->model->table('adm_log',true)->data($data)->insert();
			
			//设置登录信息
			$_SESSION['uid']=$user_info['id'];
			$_SESSION['username']=$user_info['username'];
			$_SESSION['__ROOT__']=__ROOT__;
			//20140428
			$_SESSION['sxlevel']=$user_info['jh'];
			//////////
			return true;
		}
		return false;
	}

	//用户退出
	public function logout()
	{
		unset($_SESSION['uid']);
		unset($_SESSION['username']);
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