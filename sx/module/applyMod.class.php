<?php

class applyMod extends commonMod{
	public function index(){

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
}
