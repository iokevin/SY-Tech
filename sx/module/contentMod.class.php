<?php

class contentMod extends commonMod{
	public function index(){
		$id = intval($_GET[0]);
		if(empty($id)){
			$this->error("参数传递错误！");
		}
		//取得栏目信息
		$pid = $this->get_pid();
		$tem= $this->model->table('channel')->where("id = ".$pid)->find();
		$l_info_1 = $this->model->table('channel')->where("pid = ".$tem['pid'])->select();
		$condition['id'] = $id;
		$info = $this->model->table('content')->where($condition)->find();
		$cname = $this->model->table('channel')->where("id = $pid")->find();
		$ulist = $this->model->table('channel')->where("id = ".$tem['pid'])->find();
		$tpl_content = str_replace("/","_",$cname['tpl_content']);
		
		$this->assign('ulist',$ulist);
		$this->assign('cname',$cname);
		$this->assign('list_1',$l_info_1);
		$this->assign('info',$info);
		$this->display($tpl_content);
	}

	//获取父ID
	private function get_pid(){
		$id = intval($_GET[0]);
		$tem = $this->model->table('content')->where("id = ".$id)->find();
		return $tem['cid'];
	}
}