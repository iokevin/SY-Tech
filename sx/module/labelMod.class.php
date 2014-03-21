<?php

class labelMod extends commonMod{
	public function webset(){
		return $this->model->table('set')->where("id = 1")->find();
	}
	
	public function banner(){
		return $this->model->table('adm_banner',true)->where("1 = 1")->select();
	}
}