<?php

class bannerMod  extends commonMod{
	public function index(){
		$condition['is_show'] = 1;
		$info = $this->model->table('adm_banner',true)->where($condition)->select();

		$this->assign('info',$info);
		$this->display();

		if($_POST['do']){
			$data['pic']  = in($_POST['upload']);
		if(empty($data['pic'])){
			$this->error("未能正确上传！");
		}

		if($this->model->table('adm_banner',true)->data($data)->where($condition)->insert())
			$this->success("提交成功",$url = null,$waitSecond = 1);
		else
			$this->error('提交失败');
		}
	}

	public function edit(){
		if($_POST['do']){
		$this->model->table('adm_banner',true)->where('is_show=1')->delete(); //删除现有图
		$url=$_POST['url'];
        $pic=$_POST['pic'];
        for ($i = 0; $i < count($url); $i++) {
            $data['url'] = $url[$i];
            $data['pic'] = $pic[$i];
            $this->model->table('adm_banner',true)->data($data)->insert();
        }      
		$this->success('修改成功！');
	}
	}

	public function del(){
		$id = intval($_GET[0]);
		if(empty($id)){
			$this->error('参数错误');
		}
		$condition['id'] = $id;
		if($this->model->table('adm_banner',true)->where($condition)->delete())
			$this->success('删除成功');
		else
			$this->error('删除失败');
	}
}