<?php

class sellwebMod extends commonMod{
	public function index(){
		$id=intval($_GET[0]);
		if(!empty($id)){
			$condition['pid'] = $this->get_pid();

			$list = $this->model->table('channel')->where($condition)->select();
			//顶级栏目信息
			$ulist = $this->model->table('channel')->where("id = ".$condition['pid'])->find();
			$info = $this->model->table('channel_data')->where("cid = $id")->find();
			//当前栏目信息
			$cname = $this->model->table('channel')->where("id = $id")->find();
			$tpl_list = str_replace("/","_",$cname['tpl_list']);

		$this->assign('cname',$cname);
		$this->assign('ulist',$ulist);
		$this->assign('list',$list);
		$this->assign('info',$info);
		$this->display();
	}else{
		$this->error("参数传递错误！");
	}
	}

	//获取父ID
	private function get_pid(){
		$id = intval($_GET[0]);
		$tem = $this->model->table('channel')->where("id = ".$id)->find();
		return $tem['pid'];
	}
}