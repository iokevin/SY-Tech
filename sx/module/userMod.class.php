<?php
class userMod extends commonMod{
	public function index(){
		$id = $_SESSION['uid'];
		if(!$_POST['do']){
		$data = $this->model->table('user')->where('id='.$id)->find();

		$this->assign('data',$data);
		$this->display();
		return;
	}
		$password 		  = $_POST['password'];
		$data['xingming'] = in($_POST['xingming']);
		$data['xingbie']  = in($_POST['xingbie']);
		$data['dianhua']  = text_in($_POST['dianhua']);
		$data['qq']		  = in($_POST['qq']);
		$data['dizhi']	  = in($_POST['dizhi']);
		$data['yinhang']  = text_in($_POST['yinhang']);

		if(!empty($password)){
			$data['password'] = substr(md5($password),8,16);
		}
		$msg=Check::rule(
			 	array(check::must($data['dianhua']),'电话不能为空'),
			 	array(check::must($data['dizhi']),'地址不能为空')
			 	);
			if($msg != true){
				$this->error($msg);
			}
		if($this->model->table('user')->data($data)->where('id='.$id)->update()){
			$this->success('用户资料更新成功',__URL__);
		}else{
			$this->error('用户资料更新失败',__URL__);
		}
	}

	public function log(){
		$condition['user'] = $_SESSION['username'];

		$url = __URL__ . '/log-{page}'; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;
        $count = $this->model->table('log')->where($condition)->count(); //总记录数

      	$data = $this->model->table('log')->where($condition)->limit($limit)->order('time desc')->select();

      	$this->assign('data',$data);
        $this->assign('page', $this->page($url, $count, $listRows));
		$this->display();
	}
}