<?php

class applyMod extends commonMod{
	public function index(){
		if($_GET['name']){
			$name = in($_GET['name']);
		if(empty($name)){
			return;
		}
		$user_info = $this->model->table('user')->where("username='$name'")->find();
		if(!$user_info){
			$this->error('查无此人');
		}
		$uid = $user_info['id'];
		$where = "WHERE userid=".$uid." AND isjiesuan=0 AND yingli<>0 AND jiesuanid=0 AND isfahuo>=1";
		$sql = "SELECT * FROM {$this->model->pre}order {$where} ORDER BY id ASC";
			$data = $this->model->query($sql);
			if(is_array($data)){
			foreach ($data as $vo) {
				$bianhao .= $vo['id']."|";
				$summoney += $vo['yingli'];
				}
			}else{
				$this->error("提现条件不满足，不能提现");
			}
			$minmoney = $this->config['minmoney'];
			if($summoney < $minmoney){
				$this->error("你申请的结算金额低于".$minmoney."元，不能进行结账操作。");
			}
			$this->assign('user',$user_info['username']);
			$this->assign('uid',$uid);
			$this->assign('data',$data);
			$this->assign('bianhao',$bianhao);
			$this->assign('summoney',$summoney);
		}
		if($_POST['do']){
			$uid = intval($_POST['uid']);
			$name = in($_POST['name']);
			$user_info = $this->model->table('user')->where('id='.$uid)->find();
			$liuyan = $user_info['yinhang'];
			$where = "WHERE userid=".$uid." AND isjiesuan=0 AND yingli<>0 AND jiesuanid=0 AND isfahuo>=1";
		$sql = "SELECT * FROM {$this->model->pre}order {$where} ORDER BY id ASC";
			$data = $this->model->query($sql);
			if(is_array($data)){
			foreach ($data as $vo) {
				$bianhao .= $vo['id']."|";
				$summoney += $vo['yingli'];
				}
			}else{
				$this->error("提现条件不满足，不能提现");
			}
			$minmoney = $this->config['minmoney'];
			if($summoney < $minmoney){
				$this->error("你申请的结算金额低于".$minmoney."元，不能进行结账操作。");
			}

			//history
			$data2['userid'] = $uid;
			$data2['money'] = $summoney;
			$data2['dingdanid'] = $bianhao;
			$data2['beizhu'] = "结算的订单编号|$bianhao<br>结算合计：$summoney";
			$data2['time'] = time();
			$history = $this->model->table('history')->data($data2)->insert();

			//accounts
			$user_info = $this->model->table('user')->where('id='.$uid)->find();
			$data1['liuyan'] = $liuyan."<br>结算金额:{$summoney}元<br>结算ID号是:<a href='more?id=$history'>$history</a>";
			$data1['username'] = $user_info['username'];
			$data1['leixing'] = 1;
			$data1['zhuangtai'] = 1;
			$data1['time'] = time();
			$accounts = $this->model->table('accounts')->data($data1)->insert();

			$sql2 = "UPDATE {$this->model->pre}order SET jiesuanid='$history',isjiesuan=1 WHERE userid=".$uid." AND isjiesuan=0 AND yingli<>0 AND jiesuanid=0 AND isfahuo>=1";
			$jiesuan = $this->model->query($sql2);
			if($accounts && $history && $jiesuan){
				$this->success("用户{$name}结算成功");
			}else{
				$this->error("用户{$name}结算失败，请重新尝试！");
			}
		}

		$this->display();
	}

	public function shenqing(){
		//处理
		if($_GET['action'] == 'chuli'){
			$id = intval($_GET['id']);
	    if(empty($id)){
	        $this->error("参数传递错误！");
	    }
	    $chuli['zhuangtai'] = 1;
	    if($this->model->table('accounts')->data($chuli)->where('id='.$id)->update()){
	    	$this->success('处理成功',__URL__.'/shenqing');
	    }else{
	    	$this->error('处理失败');
	    }
		}
		//详细
		if($_GET['action'] == 'xxi'){
			$id = intval($_GET['id']);
			if(empty($id)){
	        $this->error("参数传递错误！");
	    }
	    $xxi = $this->model->table('accounts')->where('id='.$id)->find();
	    $this->assign('xxi',$xxi);
		}
		//修改
		if($_POST['do']){
    	$data1['liuyan'] = text_in($_POST['liuyan']);
    	$data1['huifu'] = text_in($_POST['huifu']);
    	$data1['zhuangtai'] = intval($_POST['zhuangtai']);
    	$id = intval($_POST['id']);
    	if($this->model->table('accounts')->data($data1)->where('id='.$id)->update()){
    		$this->success('成功修改结算申请',__URL__.'/shenqing?id='.$id.'&action=xxi');
    	}else{
    		$this->error('修改结算申请失败');
	    }
	    }

		$url = __URL__ . "/shenqing-{page}"; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

		$sql = "SELECT *,A.id as aid FROM {$this->model->pre}accounts A LEFT JOIN {$this->model->pre}user B ON A.username=B.username  ORDER BY A.id DESC LIMIT {$limit}";
		$data = $this->model->query($sql);
		$sql_count = "SELECT count(*) as num FROM {$this->model->pre}accounts A LEFT JOIN {$this->model->pre}user B ON A.username=B.username";
		$num = $this->model->query($sql_count);
		$count = $num[0]['num'];

		$this->assign('data',$data);
		$this->assign('page', $this->page($url, $count, $listRows));
		$this->display();
	}

	public function history(){
		$url = __URL__ . "/history?page={page}&name=".$_GET['name']; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

		if($_GET['name']){
			$uid = intval($_GET['name']);
			$where = "WHERE userid=$uid";
		}
		$sql = "SELECT *,A.id as aid FROM {$this->model->pre}history A LEFT JOIN {$this->model->pre}user B ON A.userid=B.id {$where} ORDER BY A.id DESC LIMIT {$limit}";
		$data = $this->model->query($sql);
		$sql_count = "SELECT count(*) as num FROM {$this->model->pre}history A LEFT JOIN {$this->model->pre}user B ON A.userid=B.id {$where}";
		$num = $this->model->query($sql_count);
		$count = $num[0]['num'];

		$this->assign('data',$data);
		$this->assign('page', $this->page($url, $count, $listRows));
		$this->display();
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

	public function del(){
	    $id = intval($_GET[0]);
	    if(empty($id)){
	        $this->error("参数传递错误！");
	    }
	    $condition['id'] = $id;
	    if($this->model->table('accounts')->where($condition)->delete()){
	        $this->success("删除结账申请成功",__URL__.'/shenqing');
	    }else{
	        $this->error("删除结账申请失败");
	    }
    }
}