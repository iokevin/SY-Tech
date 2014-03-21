<?php

class leftMod extends commonMod{
	public function index(){
		$condition['user'] = $_SESSION['username'];
		$data = $this->model->table('log')->where($condition)->limit("0,5")->order('time desc')->select();
		return $data;
	}
}