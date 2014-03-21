<?php

class adminMod extends commonMod{
	public function index(){
		if($_POST['do']){
			$data['username'] = in($_POST['username']);
			$password = in($_POST['password']);
			$data['password'] = md5($password);
			$data['xingming'] = in($_POST['xingming']);
			$data['groupid'] = intval($_POST['groupid']);
			$data['lock'] = 0;
			if($this->model->table('admin')->data($data)->insert()){
				$this->success("添加管理账户 ".$data['username']." 成功",__URL__);
			}else{
				$this->error("添加管理账户 ".$data['username']." 失败");
			}
		}
		//$data = $this->model->table('admin')->select();
		$sql = "SELECT *,A.id as aid FROM {$this->model->pre}admin A LEFT JOIN {$this->model->pre}group B ON A.groupid=B.id ORDER BY A.id ASC";
		$data = $this->model->query($sql);
		$qx = $this->model->table('group')->select();

		$this->assign('qx',$qx);
		$this->assign('data',$data);
		$this->display();
	}

	public function edit(){
	    if($_POST['do']){
	    	$id = intval($_POST['id']);
			$data['username'] = in($_POST['username']);
			$password = in($_POST['password']);
			if(!empty($password)){
			$data['password'] = md5($password);
			}
			$data['xingming'] = in($_POST['xingming']);
			$data['groupid'] = intval($_POST['groupid']);
			$data['lock'] = intval($_POST['lock']);
			if($this->model->table('admin')->data($data)->where("id=".$id)->update()){
				$this->success("修改管理账户 ".$data['username']." 成功",__URL__.'/edit-'.$id);
			}else{
				$this->error("修改管理账户 ".$data['username']." 失败");
			}
		}
		$id = intval($_GET[0]);
	    if(empty($id)){
	        $this->error("参数传递错误！");
	    }

	    $info = $this->model->table('admin')->where("id=".$id)->find();
	    $sql = "SELECT *,A.id as aid FROM {$this->model->pre}admin A LEFT JOIN {$this->model->pre}group B ON A.groupid=B.id ORDER BY A.id ASC";
		$data = $this->model->query($sql);
		$qx = $this->model->table('group')->select();

		$this->assign('info',$info);
		$this->assign('qx',$qx);
		$this->assign('data',$data);
		$this->display();

	}

	public function log(){
		$url = __URL__ . "/log?action=".$_GET['action']."&page={page}"; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;
        if($_GET['action']=='admin'){
        	$condition['leixing'] = '管理登录';
        }elseif($_GET['action']=='user'){
        	$condition['leixing'] = '用户登录';
		}
        $data = $this->model->table('log')->where($condition)->limit($limit)->order('id desc')->select();
        $count = $this->model->table('log')->where($condition)->count();

        $this->assign('data',$data);
        $this->assign('page', $this->page($url, $count, $listRows));
		$this->display();
	}

	public function dellog(){
		$week = 24*7*60*60; //一星期
		$time = time()-$week;
		if($this->model->table('log')->where("time<".$time)->delete()){
			$this->success('删除一周前登录记录成功',__URL__.'/log');
		}else{
			$this->error('删除登录记录失败');
		}
	}
	public function reset(){
		$data['power_value'] = -1;
		if($_GET['action']=='reset'){
		if($this->model->table('group')->data($data)->where('id=1')->update()){
			$this->success('重置成功');
		}else{
			$this->error('重置失败');
		}
	}
		$this->display();
	}

	public function group(){
		if($_POST['do']){
			$name = in($_POST['name']);
			$pow = in($_POST['power']);
			if(empty($name)){
				$this->error('请填写权限组名');
			}
		$custom_auth = implode(',', $pow);
		$count = $this->model->table('resource')->count();
		$arr1 = range(1,$count);
		$arr2 = array(81,82,83,84,85,86,87,88,89,162,163,164,165,166,11,12,13,15,2,3,4,5,6,7,137,139,140,141,142,175,178,178);
		$arr3 = array_diff($arr1,$arr2);
		$common_auth = implode(',',$arr3);
		$auth = $common_auth.','.$custom_auth;
		$data['name'] = $name;
		$data['power_value'] = $auth;
		if($this->model->table('group')->data($data)->insert()){
			$this->success('添加权限管理组成功',__URL__.'/group?action=manage');
		}else{
			$this->error('添加权限管理组失败');
		}
		}
		if($_GET['action'] == 'manage'){
			$group = $this->model->table('group')->where('power_value!=-1')->select();
			$this->assign('group',$group);
		}
		if($_GET['action'] == 'del'){
			$id = $_GET['id'];
			if(empty($id)){
	        	$this->error("参数传递错误！");
	    	}
	    	if($id == 1){
	    		$this->error("非法操作");
	    	}
	    	$condition['id'] = $id;
	    	$group_info = $this->model->table('group')->where($condition)->find();
	    	$name = $group_info['name'];
	    	if($this->model->table('group')->where($condition)->delete()){
	        	$this->success("删除权限组『 {$name} 』成功",__URL__.'/group?action=manage');
	    	}else{
	        	$this->error("删除权限组『 {$name} 』失败");
	    }
		}
		$this->display();

	}

	public function del(){
	    $id = intval($_GET[0]);
	    if(empty($id)){
	        $this->error("参数传递错误！");
	    }
	    $condition['id'] = $id;
	    if($this->model->table('admin')->where($condition)->delete()){
	        $this->success("删除管理员成功",__URL__);
	    }else{
	        $this->error("删除管理员失败");
	    }
    }
}