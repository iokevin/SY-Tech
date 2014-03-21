<?php
class registerMod extends commonMod{
	public function index(){
		if(!$_POST['do']){
			$this->display();
			return;
		}

		$data['username'] = in($_POST['username']);
		$data['password'] = substr(md5($_POST['password']),8,16);
		$data['xingming'] = in($_POST['xingming']);
		$data['xingbie']  = in($_POST['xingbie']);
		$data['dianhua']  = in($_POST['dianhua']);
		$data['qq']		  = in($_POST['qq']);
		$data['dizhi']	  = in($_POST['dizhi']);
		$data['yinhang']  = text_in($_POST['yinhang']);
		$data['qita']	  = text_in($_POST['qita']);

		$data['dengji']   = 20;
		$data['jh']		  = 1;

		if($_POST['checkcode']!=$_SESSION['verify'])
		{
			$this->error('验证码错误，请重新输入');
		}
		$msg=Check::rule(
			 	array(check::must($data['username']),'用户名不能为空'),
			 	array(check::must($data['password']),'密码不能为空'),
			 	array(check::must($data['dianhua']),'手机号不能为空'),
			 	array(check::must($data['qq']),'QQ号不能为空'),
			 	array(check::mobile($data['dianhua']),'你好，为了以后发货过程中能及时联系上你，电话和QQ是一定要正确填写，谢谢合作'),
			 	array(check::qq($data['qq']),'你好，为了以后发货过程中能及时联系上你，电话和QQ是一定要正确填写，谢谢合作'),
			 	array(check::must($data['dizhi']),'地址不能为空')
			 	);
		if($msg !== true){
				$this->error($msg);
		}
		$condition['username'] = $data['username'];
		$user_data = $this->model->table('user')->where($condition)->find();
		if($user_data){
			$this->error('用户名已被注册');
		}
		if($this->model->table('user')->data($data)->insert()){
			$this->success('恭喜你,注册成功 请等待管理员审核',__APP__."/index/login");
		}else{
			$this->error('注册失败');
		}


		
	}

	//生成验证码
	public function verify()
	{
		require_once(CP_PATH.'lib/Image.class.php');
		Image::buildImageVerify();
	}
}