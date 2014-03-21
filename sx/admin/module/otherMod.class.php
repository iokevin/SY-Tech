<?php

class otherMod extends commonMod{
	public function sql(){
		if($_GET['save']=='yes'){
			$this->dbbak();
		}
		$data = $this->traverse();

		$this->assign('data',$data);
		$this->assign('path','data/dbbak/');
		$this->display();
	}

	private function dbbak(){
		$dbhost   = $this->config['DB_HOST'];
		$dbuser   = $this->config['DB_USER'];
		$dbpw	  = $this->config['DB_PWD'];
		$dbname	  = $this->config['DB_NAME'];
		$dbcharset= $this->config['DB_CHARSET'];
		$dbdir	  = 'data/dbbak/';
		$db = new Dbbak($dbhost,$dbuser,$dbpw,$dbname,$dbcharset,$dbdir);

		if($db->exportSql('')){
			$this->success('备份成功',__URL__.'/sql');
		}else{
			$this->error('备份失败');
		}
	}

	public function recover(){
		$name = in($_GET['name']);
		if(empty($name)){
			$this->error('参数错误');
		}

		$dbhost   = $this->config['DB_HOST'];
		$dbuser   = $this->config['DB_USER'];
		$dbpw	  = $this->config['DB_PWD'];
		$dbname	  = $this->config['DB_NAME'];
		$dbcharset= $this->config['DB_CHARSET'];
		$dbdir	  = 'data/dbbak/';
		$db = new Dbbak($dbhost,$dbuser,$dbpw,$dbname,$dbcharset,$dbdir);

		if($db->importSql($dbdir.$name)){
			$this->success('恢复备份成功',__URL__.'/sql');
		}else{
			$this->error('恢复备份失败');
		}

	}

	public function del(){
		$path = 'data/dbbak/';
		$name = in($_GET['name']);
		if(empty($name)){
			$this->error('参数错误');
		}
		if(@unlink($path.$name)){
			$this->success('删除成功备份！',__URL__.'/sql');
		}else{
			$this->error('删除备份失败');
		}
	}

	private function traverse(){
		$dir = 'data/dbbak';
		$files = array(); 
		$path = opendir($dir);
		while(($file = readdir($path)) !== false) {
			if($file == '.' || $file == '..') {
                continue;
        }else{
			$files[] = $file;
		}
		}
		return $files;
	}
}