<?php

class accountsMod extends commonMod{
	public function index(){
		if($_POST['do']){
			
			//是否黑名单
			$conditionIP['id'] = $_SESSION['uid'];
			if($user = $this->model->table('user')->where($conditionIP)->find()){
		    	
		    	if($user['jh']==4){
		    		$this->error("系统错误或提现条件不满足，请符合条件后或稍后再提交！");
		    	}
		    }else{
		    	$this->error("系统错误，请重试！");
		    }
			///////////////
			
			$liuyan = text_in($_POST['liuyan']);
			$where = "WHERE userid=".$_SESSION['uid']." AND isjiesuan=0 AND yingli<>0 AND jiesuanid=0 AND isfahuo>=1";
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
			unset($where);
			$now = date('Ymd',time());
			$where = "WHERE userid=".$_SESSION['uid']." AND FROM_UNIXTIME(time,'%Y%m%d')=".$now;
			$sql1 = "SELECT count(*) AS recnums FROM {$this->model->pre}history {$where}";
			$recnums= $this->model->query($sql1);
			if($recnums[0]['recnums']>0){
				$this->error('每个会员一天只能提现一次，请明天再来');
			}
			//history
			$data2['userid'] = $_SESSION['uid'];
			$data2['money'] = $summoney;
			$data2['dingdanid'] = $bianhao;
			$data2['beizhu'] = "结算的订单编号|$bianhao<br>结算合计：$summoney";
			$data2['time'] = time();
			$history = $this->model->table('history')->data($data2)->insert();

			//accounts
			$user_info = $this->model->table('user')->where('id='.$_SESSION['uid'])->find();
			$data1['liuyan'] = $liuyan."<br>结算金额:{$summoney}元<br>结算ID号是:<a href='".url('apply/more')."?id=$history'>$history</a>";
			$data1['username'] = $user_info['username'];
			$data1['leixing'] = 1;
			$data1['time'] = time();
			$accounts = $this->model->table('accounts')->data($data1)->insert();

			$sql2 = "UPDATE {$this->model->pre}order SET jiesuanid='$history',isjiesuan=1 WHERE userid=".$_SESSION['uid']." AND isjiesuan=0 AND yingli<>0 AND jiesuanid=0 AND isfahuo>=1";
			$jiesuan = $this->model->query($sql2);
			if($accounts && $history && $jiesuan){
				$this->success('你的申请已经提交成功，请等待管理员处理');
			}else{
				$this->error('你的申请未能成功提交，请重新尝试！');
			}
		}
		
		unset($where);
		$where = "WHERE userid=".$_SESSION['uid']." AND isjiesuan=0 AND yingli<>0 AND jiesuanid=0 AND isfahuo>=1";
		$sql = "SELECT * FROM {$this->model->pre}order {$where} ORDER BY id ASC";
		$data = $this->model->query($sql);

		unset($condition);
		$condition['id'] = $_SESSION['uid'];
		$yinhang = $this->model->table('user')->where($condition)->find();

		$this->assign('yinhang',$yinhang);
		$this->assign('data',$data);
		$this->assign('model',$model);
		$this->display();
	}

	public function log(){
		$uid = $_SESSION['uid'];
		$url = __URL__ . "/log-{page}"; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        $where = " WHERE B.id=$uid ";
        $sql = "SELECT *,A.id as aid FROM {$this->model->pre}accounts A LEFT JOIN {$this->model->pre}user B ON A.username=B.username {$where} ORDER BY A.id DESC LIMIT {$limit}";
		$data = $this->model->query($sql);
		$sql_count = "SELECT count(*) as num FROM {$this->model->pre}accounts A LEFT JOIN {$this->model->pre}user B ON A.username=B.username {$where}";
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
	 	$data = $this->model->table('history')->where("id=$id AND userid=$_SESSION[uid]")->find();
	 	$danhao = trim($data['dingdanid'],'|');
	 	$danhao = str_replace('|', ',', $danhao);

	 	$this->assign('model',$this->model);
		$this->assign('danhao',$danhao);
		$this->assign('dingdanid',$data['dingdanid']);
		$this->assign('heji',$data['money']);
		$this->display();
	}
}