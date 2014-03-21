<?php

class myMod extends commonMod{
	public function index(){

		if($_POST['do']){
			$data['name'] = in($_POST['name']);
			$data['email'] = in($_POST['email']);
			$data['qq'] = in($_POST['qq']);
			$data['wangwang'] = in($_POST['wangwang']);
			$data['phone'] = in($_POST['phone']);
			$data['fax'] = in($_POST['fax']);

			if($this->model->table('adm_my',true)->where("id = 1")->data($data)->update()){
					$this->success("个人信息更新成功",__URL__.'/index');
				}else{
					$this->error('信息更新失败');
				}

		}
		$info = $this->model->table('adm_my',true)->where("id = 1")->find();

		$this->assign('info',$info);
		$this->display();
	}

	public function xedit(){
		if($_POST['pc_hash'] == 'qXrUFG'){
			$oldpassword = in($_POST['oldpassword']);
			$password = in($_POST['password']);
			$password2 = in($_POST['password2']);
			$data['password'] = md5($password);
			if($password != $password2){
				$this->error('两次密码输入不一样');
			}
			$info = $this->model->table('adm_admin',true)->where("id = 1")->find();
			if(md5($oldpassword) == $info['password']){
				if($this->model->table('adm_admin',true)->where("id = 1")->data($data)->update()){
					$this->success("密码更新成功");
				}else{
					$this->error('更改密码失败');
				}

			}


		}
		$this->display();
	}
}