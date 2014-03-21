<?php

class linkMod extends commonMod{
	public function index(){
		$url=__URL__.'?1-{page}.html';//分页基准网址         
		$page=new Page();                 
		$listRows=20;//每页显示的信息条数         
		$cur_page=$page->getCurPage($url);         
		$limit_start=($cur_page-1)*$listRows;         
		$limit=$limit_start.','.$listRows; 
		//获取行数         
		$count=$this->model->table('adm_link',true)->where($condition)->count(); 

		$info = $this->model->table('adm_link',true)->where("1 = 1")->limit($limit)->order('adddate desc')->select();

		$this->assign('info',$info);
		$this->assign('page',$page->show($url,$count,$listRows)); 
		$this->display();
	}

	public function add(){
		if($_POST['do']){
			$data['name'] = in($_POST['name']);
			$data['url'] = in($_POST['url']);
			$data['info'] = in($_POST['info']);
			$data['pic'] = in($_POST['upload']);

		//验证数据
		if(empty($data['name']))
		{
			$this->error('链接名不能为空');
		}

		//数据库操作		
		if($this->model->table('adm_link',true)->data($data)->insert())
			$this->success('添加成功',__URL__.'/index');
		else
			$this->error('添加失败');


	}

		$this->display();
	}	

	public function edit(){
		$id = intval($_GET[0]);
		$condition['id'] = $id;
		$info = $this->model->table('adm_link',true)->where($condition)->find();

		if($_POST['do']){
			$id = intval($_POST['id']);
			$data['name'] = in($_POST['name']);
			$data['url'] = in($_POST['url']);
			$data['info'] = in($_POST['info']);
			$data['pic'] = in($_POST['upload']);

		//验证数据
		if(empty($data['name']))
		{
			$this->error('链接名不能为空');
		}

		//数据库操作		
		if($this->model->table('adm_link',true)->data($data)->where("id = $id")->update())
			$this->success('修改成功',__URL__.'/index');
		else
			$this->error('修改失败');

	}

		$this->assign('info',$info);
		$this->display();
	}

	public function del(){
        $id = intval($_GET[0]);
        if(empty($id)){
            $this->error("参数传递错误！");
        }
        $condition['id'] = $id;
        if($this->model->table('adm_link',true)->where($condition)->delete()){
            $this->success("删除链接成功",__URL__.'/index');
        }else{
            $this->error("删除链接失败");
        }
    }

	public function dels(){
		$ids = $_POST['ids'];
		if(empty($ids)){
			$this->error("参数错误");
		}
		foreach($ids as $id){
			$this->model->table('adm_link',true)->where("id=$id")->delete();
		}
		$this->success("删除成功",__URL__."/index");
	}
}