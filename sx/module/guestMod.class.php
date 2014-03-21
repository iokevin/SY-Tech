<?php

class guestMod extends commonMod{
	public function index(){
		$id=intval($_GET[0]);
		if(!empty($id)){
			$condition['pid'] = $this->get_pid();
			$list = $this->model->table('channel')->where($condition)->select();
			$ulist = $this->model->table('channel')->where("id = ".$condition['pid'])->find();
			$info = $this->model->table('channel_data')->where("cid = $id")->find();
			$cname = $this->model->table('channel')->where("id = $id")->find();
			$tpl_list = str_replace("/","_",$cname['tpl_list']);

		$this->assign('cname',$cname['name']);
		$this->assign('uname',$ulist['name']);
		$this->assign('list',$list);
		$this->assign('info',$info);
		$this->display($tpl_list);
	}else{
		$this->error("参数传递错误！");
	}
	}

	public function add(){
		if($_POST['do']){
			$data['username'] = in($_POST['username']);
			$data['email'] = in($_POST['email']);
			$data['phone'] = in($_POST['phone']);
			$data['city'] = in($_POST['city']);
			$data['content'] = text_in($_POST['content']);

			if($this->model->table('guestbook')->data($data)->insert()){
				$this->success("留言成功！",__URL__."/index-26");
			}else{
				$this->error("留言失败！");
			}
		}
	}

	//获取父ID
	private function get_pid(){
		$id = intval($_GET[0]);
		$tem = $this->model->table('channel')->where("id = ".$id)->find();
		return $tem['pid'];
	}
}