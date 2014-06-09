<?php

class manageMod extends commonMod{
	public function index(){
		$url = __URL__ . "/index?keyword=$_GET[keyword]&amp;kehu=$_GET[kehu]&amp;f=$_GET[f]&amp;w=$_GET[w]&amp;itime=$_GET[itime]&amp;atime=$_GET[atime]&amp;do=yes&amp;page={page}"; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        if($_GET['do']){
        	$keyword = in($_GET['keyword']);
        	$kehu    = in($_GET['kehu']);
        	if(!empty($kehu)){
        		$condition['username'] = $kehu;
        	$kehu_data = $this->model->table('user')->where($condition)->find();
        	$kehuid = !empty($kehu_data) ? " AND userid=$kehu_data[id] " : "";
        }else{
        	$kehuid = "";
        }
        if(!empty($keyword)){
        	$keyword_case = " AND (shouhuoren like '%".$keyword."%' OR wuliudanhao like '%".$keyword."%' OR address like '%".$keyword."%' OR chanpin like '%".$keyword."%' OR beizhu like '%".$keyword."%') ";
        }else{
        	$keyword_case = "";
        }
        // if(empty($keyword) && empty($kehu)){
        // 	$where = "";
        // }else{
        // 	$where = "WHERE $kehuid $keyword_case";
        // }
    
    //------
    	$f = in($_GET['f']);
    	$w = in($_GET['w']);
    	if(!empty($f)){
    		if($f == 9){
    			$fwhere = " AND isfahuo = 0 ";
    		}elseif($f == 30){
    			$fwhere = " AND isfahuo = 3 AND isjiesuan = 0 ";
    		}elseif($f == 20){
    			$fwhere = " AND isfahuo = 2 AND isjiesuan = 0 ";
    		}else{
    		$fwhere = " AND isfahuo = $f ";
    		}
    	}else{
    		$fwhere = "";
    	}
    	if(!empty($w)){
    		$wwhere = " AND wuliu = '$w' ";
    	}else{
    		$wwhere = "";
    	}
    }

    //-----
    	$itime = in($_GET['itime']);
    	$atime = in($_GET['atime']);
    	if(!empty($itime)){
    		$itime = strtotime($itime);
    		$itime = " AND UNIX_TIMESTAMP(fahuotime)>$itime";
    	}else{
    		$iwhere = "";
    	}
    	if(!empty($atime)){
    		$atime = strtotime($atime);
    		$atime = " AND UNIX_TIMESTAMP(fahuotime)<$atime";
    	}else{
    		$awhere = "";
    	}
    	// if(empty($f) && empty($w)){
     //    	$where = "";
     //    }else{
     //    	$where = "WHERE $fwhere $wwhere";
     //    }

    $where = "WHERE '1=1' $kehuid $keyword_case $fwhere $wwhere $itime $atime";
    //-------
        if($_POST['su']){
        	$d =intval($_POST['d']);
        	$condition['id'] = $d;
        	if($this->model->table('order')->where($condition)->count()){
        		$this->redirect(__APP__.'/manage/edit-'.$d);
        	}else{
        		$this->error('参数传递错误！');
        	}
    	}

		$sql = "SELECT *,A.id as aid FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where} ORDER BY A.id DESC LIMIT {$limit}";
		$sql_count = "SELECT count(*) as num FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where}";
        $data = $this->model->query($sql);
        $num = $this->model->query($sql_count);
        $count = $num[0]['num'];

   		$post = explode(',', $this->config['post']);
   		$postapi = explode(',', $this->config['postapi']);
   		$this->assign('successcolor', $this->config['successdd']);
   		$this->assign('errorcolor', $this->config['errordd']);
		$this->assign('post',$post);
		$this->assign('postapi',$postapi);
		$this->assign('count',$count);
		$this->assign('page', $this->page($url, $count, $listRows));
		$this->assign('data',$data);
		$this->display();
	}
	
		//订单对账20140531
		public function order(){
		$url = __URL__ . "/order?keyword=$_GET[keyword]&amp;kehu=$_GET[kehu]&amp;f=$_GET[f]&amp;w=$_GET[w]&amp;m=$_GET[m]&amp;s=$_GET[s]&amp;do=yes&amp;page={page}"; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        if($_GET['do']){
        	$keyword = in($_GET['keyword']);
        	$kehu    = in($_GET['kehu']);
        	if(!empty($kehu)){
        		$condition['username'] = $kehu;
        		$kehu_data = $this->model->table('user')->where($condition)->find();
        		$kehuid = !empty($kehu_data) ? " AND userid=$kehu_data[id] " : "";
        	}else{
        		$kehuid = "";
        	}
        if(!empty($keyword)){
        	$keyword_case = " AND (shouhuoren like '%".$keyword."%' OR wuliudanhao like '%".$keyword."%' OR address like '%".$keyword."%' OR chanpin like '%".$keyword."%' OR beizhu like '%".$keyword."%') ";
        }else{
        	$keyword_case = "";
        }
        // if(empty($keyword) && empty($kehu)){
        // 	$where = "";
        // }else{
        // 	$where = "WHERE $kehuid $keyword_case";
        // }
    
    //------
    	$f = in($_GET['f']);
    	$w = in($_GET['w']);
    	if(!empty($f)){
			if($f == 31){
    			$fwhere = " AND isfahuo = 3 AND isjiesuan = 1 ";
    		}elseif($f == 21){
    			$fwhere = " AND isfahuo = 2 AND isjiesuan = 1 ";
    		}else{
    			$fwhere = " AND (isfahuo = 2 OR isfahuo = 3) AND isjiesuan = 1 ";
    		}
    	}else{
    		$fwhere = " AND (isfahuo = 2 OR isfahuo = 3) AND isjiesuan = 1 ";
    	}
    	if(!empty($w)){
    		$wwhere = " AND wuliu = '$w' ";
    	}else{
    		$wwhere = "";
    	}
    	$m = in($_GET['m']);
    	if(!empty($m)){
    		if($m == 1){
    			$mwhere = " AND daishoukuan >= 1000 ";
    		}else{
    			$mwhere = " AND daishoukuan < 1000 ";
    		}
    		
    	}else{
    		$mwhere = "";
    	}
    	$s = in($_GET['s']);
    	if(!empty($s)){
    		$swhere = " AND status = $s ";
    		
    	}else{
    		$swhere = "";
    	}
    }else{
    	$fwhere = " AND (isfahuo = 2 OR isfahuo = 3) AND isjiesuan = 1 ";
    }

    $where = "WHERE '1=1' $kehuid $keyword_case $fwhere $wwhere $mwhere $swhere";
    //-------

		$sql = "SELECT *,A.id as aid FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where} ORDER BY A.id DESC LIMIT {$limit}";
		$sql_count = "SELECT count(*) as num FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where}";
		$sql_sum = "SELECT sum(yinghuikuan) as allSum FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where}";
        $data = $this->model->query($sql);
        $num = $this->model->query($sql_count);
        $aSum = $this->model->query($sql_sum);
        $count = $num[0]['num'];
        $allSum = $aSum[0]['allSum'];

   		$post = explode(',', $this->config['post']);
   		$postapi = explode(',', $this->config['postapi']);
   		$this->assign('successcolor', $this->config['successdd']);
   		$this->assign('errorcolor', $this->config['errordd']);
		$this->assign('post',$post);
		$this->assign('postapi',$postapi);
		$this->assign('count',$count);
		$this->assign('allSum',$allSum);
		$this->assign('page', $this->page($url, $count, $listRows));
		$this->assign('data',$data);
		$this->display();
	}

	///////////////

	public function dayin(){
		$id = intval($_GET['id']);
		$kd = in($_GET['kd']);

		$data = $this->model->table('order')->where("id=".$id)->find();
		$data['dianhua'] = cp_decode($data['dianhua'],'Nan');
		$this->assign('data',$data);
		if(empty($id) or empty($kd)){
			$this->error('参数错误');
		}
		switch ($kd) {
			case 'shunfeng':
				$this->display('kuaidi/shunfeng');
				break;
			case 'ems':
				$this->display('kuaidi/ems');
				break;
			default:
				# code...
				break;
		}
	}

	public function add(){
		if($_POST['do']){
			$username 	 = in($_POST['username']);
		    $data['shouhuoren']  = in($_POST['shouhuoren']);
		    $data['address'] 	 = in($_POST['address']);
		    $data['chanpin'] 	 = text_in($_POST['chanpin']);
		    $data['dianhua'] 	 = cp_encode(in($_POST['dianhua']),'Nan');
		    $data['youbian'] 	 = in($_POST['youbian']);
		    $data['wuliudanhao'] = in($_POST['wuliudanhao']);
		    $data['wuliu'] 		 = in($_POST['wuliu']);
		    $data['daishoukuan'] = in($_POST['daishoukuan']);
		    $data['pifajia'] 	 = in($_POST['pifajia']);
		    $data['youfei'] 	 = in($_POST['youfei']);
		    $data['dsshouxufei'] = in($_POST['dsshouxufei']);
		    $data['qitafei'] 	 = in($_POST['qitafei']);
		    $data['canbao'] 	 = in($_POST['canbao']);
		    $data['duanxin'] 	 = in($_POST['duanxin']);
		    $data['isfahuo'] 	 = in($_POST['isfahuo']);
		    $data['fahuotime'] 	 = in($_POST['fahuotime']);
		    $data['isjiesuan'] 	 = in($_POST['isjiesuan']);
		    $data['yingli'] 	 = in($_POST['yingli']);
		    $data['beizhu'] 	 = text_in($_POST['beizhu']);
		    $data['alicod'] 	 = in($_POST['codlc']);

		    //查询username
		    $condition['username'] = $username;
		    if($user = $this->model->table('user')->where($condition)->find()){
		    	//echo $model->sql;
		    	if($user['jh']==3 || $user['jh']==4){
		    		$this->error("此用户不能下订单");
		    	}
		    	$data['userid'] = $user['id'];
		    }else{
		    	$this->error("订单主人 不存在！");
		    }
		    $msg=Check::rule(
			 	array(check::must($data['shouhuoren']),'收货人不能为空'),
			 	array(check::must($data['address']),'收货地址不能为空'),
			 	array(check::must($data['chanpin']),'产品详情不能为空')
			 	);
			if($msg != true){
				$this->error($msg);
			}

			if($this->model->table('order')->data($data)->insert()){
				$this->success("添加订单成功",__URL__);
			}else{
				$this->error("添加订单失败");
			}
		}

		$post = explode(',', $this->config['post']);
		$this->assign('post',$post);

		$this->display();
	}

	public function edit(){
	    if($_POST['do']){
	    	$id 				 = intval($_POST['id']);
	    	//是否结算
	    	$order = $this->model->table('order')->where("id=".$id)->find();
	    	if($order['isjiesuan'] == 1){
	    		$this->error('已经结算的订单不能修改');
	    	}
			$username 	 = in($_POST['username']);
		    $data['shouhuoren']  = in($_POST['shouhuoren']);
		    $data['address'] 	 = in($_POST['address']);
		    $data['chanpin'] 	 = text_in($_POST['chanpin']);
		    $data['dianhua'] 	 = cp_encode(in($_POST['dianhua']),'Nan');
		    $data['youbian'] 	 = in($_POST['youbian']);
		    $data['wuliudanhao'] = in($_POST['wuliudanhao']);
		    $data['wuliu'] 		 = in($_POST['wuliu']);
		    $data['daishoukuan'] = in($_POST['daishoukuan']);
		    $data['pifajia'] 	 = in($_POST['pifajia']);
		    $data['youfei'] 	 = in($_POST['youfei']);
		    $data['dsshouxufei'] = in($_POST['dsshouxufei']);
		    $data['qitafei'] 	 = in($_POST['qitafei']);
		    $data['canbao'] 	 = in($_POST['canbao']);
		    $data['duanxin'] 	 = in($_POST['duanxin']);
		    $data['isfahuo'] 	 = in($_POST['isfahuo']);
		    $data['fahuotime'] 	 = in($_POST['fahuotime']);
		    $data['isjiesuan'] 	 = in($_POST['isjiesuan']);
		    $data['yingli']	 	 = in($_POST['yingli']);
		    $data['beizhu'] 	 = text_in($_POST['beizhu']);
		    
		    //20140605 加应回款字段
		    if($id>=10046){
		    if($data['wuliu']=='EMS快递'){
		    	$data['yinghuikuan']=$data['daishoukuan']-$data['daishoukuan']*0.02;
		    }elseif ($data['wuliu']=='顺丰快递'){
//		    	if($data['daishoukuan']>0 && $data['daishoukuan']<=500){
//		    		$data['yinghuikuan']=$data['daishoukuan']-1;
//		    	}elseif ($data['daishoukuan']>500 && $data['daishoukuan']<1000){
//		    		$data['yinghuikuan']=$data['daishoukuan']-2;
//		    	}elseif($data['daishoukuan']>=1000){
		    	$data['yinghuikuan']=$data['daishoukuan']-$data['daishoukuan']*0.03;
//		    	}else{
//		    		$data['yinghuikuan']=0;
//		    	}
		    }else{
		    	$data['yinghuikuan']=0;
		    }
		    }
		    /////////////////////////

		    // $yingli = $data['yingli'];
		    // //自动计算盈利
		    // if($data['youfei'] != '0.00' && $data['isfahuo'] > 1 && ($yingli == '0.00' || $yingli == '' || $yingli == '0')){
		    // 	//其他费用
		    // 	if($data['duanxin'] == 1){$duanxin = 1;}else{$duanxin = 0;}
		    // 	if($data['wuliu'] == 'EMS快递'){$wuliu = 15;}else{$wuliu = 0;}
				
		    // 	//代收手续费
		    // 	$data['dsshouxufei'] = $data['daishoukuan']*0.05;
		    // 	//退货
		    // 	if($data['isfahuo'] == 2){
		    // 		$data['qitafei'] = 3+$duanxin;
		    // 		$result = -$data['youfei']*2-$data['qitafei'];
		    // 		$data['yingli'] = $result;
		    // 	}elseif($data['isfahuo'] == 3){	//成功
		    // 		//【EMS快递】【是参保】【成功】
		    // 		if($data['wuliu'] == 'EMS快递' && $data['canbao'] == '1'){
		    // 			$canbao = $data['daishoukuan']*0.01;
		    // 		}
		    // 		$data['qitafei'] = 3+($data['daishoukuan']*0.01+$duanxin+$wuliu+$canbao);
		    // 		$result = $data['daishoukuan']-$data['pifajia']-$data['youfei']-$data['dsshouxufei']-$data['qitafei'];
		    // 		$data['yingli'] = $result;
		    // 	}
		    // }

		    //查询username
		    $condition['username'] = $username;
		    if($user = $this->model->table('user')->where($condition)->find()){
		    	//echo $model->sql;
		    	$data['userid'] = $user['id'];
		    }else{
		    	$this->error("订单主人 不存在！");
		    }

		    $msg=Check::rule(
			 	array(check::must($data['shouhuoren']),'收货人不能为空'),
			 	array(check::must($data['address']),'收货地址不能为空'),
			 	array(check::must($data['chanpin']),'产品详情不能为空')
			 	);
			if($msg !== true){
				$this->error($msg);
			}
			unset($condition);
			$condition['id'] = $id;
			if($this->model->table('order')->data($data)->where($condition)->update()){
				//$this->success("修改订单成功",__URL__.'/edit-'.$id);
				$this->alert("修改订单成功");
			}else{
				$this->error("修改订单失败");
			}
		}
		$id = intval($_GET[0]);
	    if(empty($id)){
	        $this->error("参数传递错误！");
	    }

	    $condition['id'] = $id;
	    $data = $this->model->table('order')->where($condition)->find();
	    unset($condition);
	    $condition['id'] = $data['userid'];
	    $user= $this->model->table('user')->where($condition)->find();
	    $data['username'] = $user['username'];
	    $data['dianhua'] = cp_decode($data['dianhua'],'Nan');
		$post = explode(',', $this->config['post']);
		$this->assign('model',$this->model);
		$this->assign('post',$post);
		$this->assign('data',$data);
		$this->assign('uservip',$user['jh']);
		$this->display();
	}
	
	//订单对账20140531
		public function orderEdit(){
	    if($_POST['do']){
	    	$id 				 = intval($_POST['id']);
		    $data['status'] 	 = in($_POST['status']);
		    $data['desc'] 	 = text_in($_POST['desc']);
		    
			$condition['id'] = $id;
			if($this->model->table('order')->data($data)->where($condition)->update()){
				//$this->success("修改订单成功",__URL__.'/edit-'.$id);
				$this->alert("修改成功");
			}else{
				$this->error("修改失败");
			}
		}
		$id = intval($_GET[0]);
	    if(empty($id)){
	        $this->error("参数传递错误！");
	    }

	    $condition['id'] = $id;
	    $data = $this->model->table('order')->where($condition)->find();
	    unset($condition);
	    $condition['id'] = $data['userid'];
	    $user= $this->model->table('user')->where($condition)->find();
	    $data['username'] = $user['username'];
		$this->assign('model',$this->model);
		$this->assign('data',$data);
		$this->assign('uservip',$user['jh']);
		$this->display();
	}

	////////////////////

	public function ajax_Calculate(){
		$data['daishoukuan'] = in($_POST['daishoukuan']);
		$data['pifajia'] 	 = in($_POST['pifajia']);
		$data['youfei'] 	 = in($_POST['youfei']);
		$data['duanxin'] 	 = in($_POST['duanxin']);
		$data['isfahuo'] 	 = in($_POST['isfahuo']);
		$data['wuliu'] 		 = in($_POST['wuliu']);
		$data['canbao']		 = in($_POST['canbao']);

		//自动计算盈利
		    if($data['youfei'] != '0.00' && $data['isfahuo'] > 1){
		    	//其他费用
		    	if($data['duanxin'] == 1){$duanxin = 1;}else{$duanxin = 0;}
		    	if($data['wuliu'] == 'EMS快递'){$wuliu = 15;}else{$wuliu = 0;}

		    	//代收手续费
		    	$data['dsshouxufei'] = $data['daishoukuan']*0.05;
		    	//退货
		    	if($data['isfahuo'] == 2){
		    		
		    		$data['qitafei'] = 3+$duanxin;
		    		$result = -$data['youfei']*2-$data['qitafei'];
		    		$data['yingli'] = $result;
		    	}elseif($data['isfahuo'] == 3){	//成功
		    		//【EMS快递】【是参保】【成功】
		    		if($data['wuliu'] == 'EMS快递' && $data['canbao'] == '1'){
		    			$canbao = $data['daishoukuan']*0.01;
		    		}
		    		$data['qitafei'] = 3+($data['daishoukuan']*0.01+$duanxin+$wuliu+$canbao);
		    		$result = $data['daishoukuan']-$data['pifajia']-$data['youfei']-$data['dsshouxufei']-$data['qitafei'];
		    		$data['yingli'] = $result;
		    	}
		    	//echo  "{yingli:$data[yingli],dsshouxufei:$data[dsshouxufei],qitafei:$data[qitafei]}";
		    	echo json_encode(array('yingli'=>$data['yingli'],'dsshouxufei'=>$data['dsshouxufei'],'qitafei'=>$data['qitafei']));
		    }
	}
	
	public function ajax_VipCalculate(){
		$data['daishoukuan'] = in($_POST['daishoukuan']);
		$data['pifajia'] 	 = in($_POST['pifajia']);
		$data['youfei'] 	 = in($_POST['youfei']);
		$data['duanxin'] 	 = in($_POST['duanxin']);
		$data['isfahuo'] 	 = in($_POST['isfahuo']);
		$data['wuliu'] 		 = in($_POST['wuliu']);
		$data['canbao']		 = in($_POST['canbao']);

		//自动计算盈利
		    if($data['youfei'] != '0.00' && $data['isfahuo'] > 1){
		    	//其他费用
		    	if($data['duanxin'] == 1){$duanxin = 1;}else{$duanxin = 0;}
		    	if($data['wuliu'] == 'EMS快递'){$wuliu = 15;}else{$wuliu = 0;}

		    	//代收手续费
		    	$data['dsshouxufei'] = $data['daishoukuan']*0.04;
		    	//退货
		    	if($data['isfahuo'] == 2){
		    		
		    		$data['qitafei'] = 3+$duanxin;
		    		$result = -$data['youfei']*2-$data['qitafei'];
		    		$data['yingli'] = $result;
		    	}elseif($data['isfahuo'] == 3){	//成功
		    		//【EMS快递】【是参保】【成功】
		    		if($data['wuliu'] == 'EMS快递' && $data['canbao'] == '1'){
		    			$canbao = $data['daishoukuan']*0.01;
		    		}
		    		$data['qitafei'] = 3+($data['daishoukuan']*0.01+$duanxin+$wuliu+$canbao);
		    		$result = $data['daishoukuan']-$data['pifajia']-$data['youfei']-$data['dsshouxufei']-$data['qitafei'];
		    		$data['yingli'] = $result;
		    	}
		    	//echo  "{yingli:$data[yingli],dsshouxufei:$data[dsshouxufei],qitafei:$data[qitafei]}";
		    	echo json_encode(array('yingli'=>$data['yingli'],'dsshouxufei'=>$data['dsshouxufei'],'qitafei'=>$data['qitafei']));
		    }
	}

	public function today(){
		$url = __URL__ . "/today?username=$_GET[username]&amp;i=$_GET[i]&amp;a=$_GET[a]&amp;time=$_GET[time]&amp;do=yes&amp;page={page}"; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        $count = $this->model->table('order')->where($condition)->count(); //总记录数

        if($_GET['do']){
        	$i = intval($_GET['i']);
        	$a = intval($_GET['a']);
        	$username = in($_GET['username']);
        	$time = in($_GET['time']);
        	$i = !empty($i) ? " AND A.id>='$i'" : "";
        	$a = !empty($a) ? " AND A.id<='$a'" : "";
        	$username = !empty($username) ? $username = " AND username = '$username'" : "";
        	$start = "$time 00:00:00";
        	$end = "$time 23:59:59";
        	$time = !empty($time) ? $time = " AND addtime>='$start' AND addtime<='$end'" : "";

        	$where = " Where '1=1' $i $a $username $time ";
        }else{
        	$start = date('Y-m-d 00:00:00');
        	$where = "WHERE addtime>='".$start."'";
        }

        $sql = "SELECT *,A.id as aid,A.dianhua as tel FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where} ORDER BY A.id DESC LIMIT {$limit}";
        $data = $this->model->query($sql);

        $this->assign('page', $this->page($url, $count, $listRows));
        $this->assign('data',$data);
		$this->display();
	}

	public function stdput(){
		$url = __URL__ . "/stdput?username=$_GET[username]&amp;f=$_GET[f]&amp;w=$_GET[w]&amp;do=yes&amp;itime=$_GET[itime]&amp;atime=$_GET[atime]&amp;duanxin=$_GET[duanxin]&amp;page={page}"; //分页基准网址
        $page = new Page();
        $listRows = 200; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        if($_GET['do']){
        	$username = in($_GET['username']);
        	$f = in($_GET['f']);
        	$w = in($_GET['w']);
        	$duanxin = intval($_GET['duanxin']);

        	if(!empty($f)){
    			if($f == 9){
    				$f = " AND isfahuo = 0 ";
    			}else{
    				$f = " AND isfahuo = $f ";
    		}
    	}else{
    		$f = "";
    	}
        	
        	$w = !empty($w) ? " AND wuliu='$w' " : "";

        	if(!empty($duanxin)){
        		if($duanxin == 2){
        			$duanxin = " AND duanxin = 0 ";
        		}else{
        			$duanxin = "AND duanxin = 1 ";
        		}
        	}else{
        		$duanxin = "";
        	}

        	//-----
    	$itime = in($_GET['itime']);
    	$atime = in($_GET['atime']);
    	if(!empty($itime)){
    		$itime = strtotime($itime);
    		$itime = " AND UNIX_TIMESTAMP(fahuotime)>$itime";
    	}else{
    		$iwhere = "";
    	}
    	if(!empty($atime)){
    		$atime = strtotime($atime);
    		$atime = " AND UNIX_TIMESTAMP(fahuotime)<$atime";
    	}else{
    		$awhere = "";
    	}

        	$username = !empty($username) ? " AND username='$username' " : "";

        	$where = "WHERE '1=1' $username $f $w $duanxin $itime $atime";
        }else{
        	$where = "WHERE 1=1";
        }
        $sql = "SELECT *,A.id as aid,A.dianhua as adianhua FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where} ORDER BY A.id DESC LIMIT {$limit}";
        $data = $this->model->query($sql);
        $sql_count = "SELECT count(*) as num FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where}";
        $num = $this->model->query($sql_count);
        $count = $num[0]['num'];

        $post = explode(',', $this->config['post']);
		$this->assign('post',$post);
		$this->assign('count',$count);
        $this->assign('page', $this->page($url, $count, $listRows));
        $this->assign('data',$data);
        $this->display();
	}

	public function sets(){
		if($_POST['do']){
			$danhao = $_POST['danhao'];
			$sets = intval($_POST['sets']);
			$danhao_arr = explode("\r\n", $danhao);
			$danhao_arr = array_filter($danhao_arr);
			$stdout = "";
			foreach($danhao_arr as $dh)
			{
				//退货 2
 				//成功 3
				if($sets == 1){
					// $data['isfahuo'] = 3;
					// $condition['wuliudanhao'] = $dh;
					// $condition['jiesuanid'] = 0;
					// $result = $this->model->table('order')->data($data)->where($condition)->update();
					$where = "WHERE wuliudanhao='$dh' AND jiesuanid=0";
					$sql = "UPDATE {$this->model->pre}order SET `isfahuo` = '3' {$where}";
					$result = $this->model->query($sql);
					$ok = mysql_affected_rows();
					if($ok){
						$stdout .= $dh." 设置为已签收 <font color=green>成功</font><br />";
					}else{
						$stdout .= $dh." 设置为已签收 <font color=red>失败</font> 可能是因为此单号不存在或者此单号已经结账了和订单状态为已签收<br />";
					}
				}elseif($sets == 2){
					// $data['isfahuo'] = 2;
					// $condition['wuliudanhao'] = $dh;
					// $condition['jiesuanid'] = 0;
					// $result = $this->model->table('order')->data($data)->where($condition)->update();
					$where = "WHERE wuliudanhao='$dh' AND jiesuanid=0";
					$sql = "UPDATE {$this->model->pre}order SET `isfahuo` = '2' {$where}";
					$result = $this->model->query($sql);
					$ok = mysql_affected_rows();
					if($ok){
						$stdout .= $dh." 设置为退货 <font color=green>成功</font><br />";
					}else{
						$stdout .= $dh." 设置为退货 <font color=red>失败</font> 可能是因为此单号不存在或者此单号已经结账了和订单状态为退货<br />";
					}
				}else{
					return;
				}
	        	
	    	}
	    	
		}
		$this->assign('stdout',$stdout);
		$this->display();
	}
	
	//订单对帐20140531
		public function orderSets(){
		if($_POST['do']){
			$danhao = $_POST['danhao'];
			$orderSets = intval($_POST['orderSets']);
			$danhao_arr = explode("\r\n", $danhao);
			$danhao_arr = array_filter($danhao_arr);
			$stdout = "";
			foreach($danhao_arr as $dh)
			{
				//退货 2
 				//成功 3
				if($orderSets == 1){

					$where = "WHERE wuliudanhao='$dh' AND jiesuanid<>0";
					$sql = "UPDATE {$this->model->pre}order SET `status` = '2' {$where}";
					$result = $this->model->query($sql);
					$ok = mysql_affected_rows();
					if($ok){
						$stdout .= $dh." 设置为已回款 <font color=green>成功</font><br />";
					}else{
						$stdout .= $dh." 设置为已回款 <font color=red>失败</font> 可能是因为此单号不存在或者此单号已经是已回款了.<br />";
					}
				}else{
					return;
				}
	        	
	    	}
	    	
		}
		$this->assign('stdout',$stdout);
		$this->display();
	}
	/////////////////////

	public function excel(){
		$url = __URL__ . "/excel?username=$_GET[username]&amp;f=$_GET[f]&amp;w=$_GET[w]&amp;i=$_GET[i]&amp;a=$_GET[a]&amp;itime=$_GET[itime]&amp;atime=$_GET[atime]&amp;do=yes&amp;page={page}"; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

		if($_GET['do']){
			$f = in($_GET['f']);
			$w = in($_GET['w']);
			$username = in($_GET['username']);

			//------
	    	$f = in($_GET['f']);
	    	$w = in($_GET['w']);
		    	if(!empty($f)){
		    		if($f == 9){
    			$fwhere = " AND isfahuo = 0 ";
    				}else{
		    		$fwhere = " AND isfahuo = $f ";
		    		}
		    	}else{
		    		$fwhere = "";
		    	}
		    	if(!empty($w)){
		    		$wwhere = " AND wuliu = '$w' ";
		    	}else{
		    		$wwhere = "";
		    	}
		    //-----
		    $i = intval($_GET['i']);
		    $a = intval($_GET['a']);
		    $i = !empty($i) ? " AND A.id>='$i'" : "";
        	$a = !empty($a) ? " AND A.id<='$a'" : "";

        	//-----
        	$itime = in($_GET['itime']);
    		$atime = in($_GET['atime']);
        	if(!empty($itime)){
    		$itime = strtotime($itime);
    		$itime = " AND UNIX_TIMESTAMP(fahuotime)>$itime";
    	}else{
    		$itime = "";
    	}
    	if(!empty($atime)){
    		$atime = strtotime($atime);
    		$atime = " AND UNIX_TIMESTAMP(fahuotime)<$atime";
    	}else{
    		$atime = "";
    	}

			$username = !empty($username) ? " AND username='$username'" : "";

			$where = "WHERE '1=1' $fwhere $wwhere $i $a $itime $atime $username";
			}else{
				$where = "";
			}

		if($_GET['save']){
			$f = in($_GET['f']);
			$w = in($_GET['w']);
			$username = in($_GET['username']);

			//------
	    	$f = in($_GET['f']);
	    	$w = in($_GET['w']);
		    	if(!empty($f)){
		    		if($f == 9){
    			$fwhere = " AND isfahuo = 0 ";
    				}else{
		    		$fwhere = " AND isfahuo = $f ";
		    		}
		    	}else{
		    		$fwhere = "";
		    	}
		    	if(!empty($w)){
		    		$wwhere = " AND wuliu = '$w' ";
		    	}else{
		    		$wwhere = "";
		    	}

		    //-----
		    $i = intval($_GET['i']);
		    $a = intval($_GET['a']);
		    $i = !empty($i) ? " AND A.id>='$i'" : "";
        	$a = !empty($a) ? " AND A.id<='$a'" : "";
        	
		    //-----
        	$itime = in($_GET['itime']);
    		$atime = in($_GET['atime']);
        	if(!empty($itime)){
    		$itime = strtotime($itime);
    		$itime = " AND UNIX_TIMESTAMP(fahuotime)>$itime";
	    	}else{
	    		$itime = "";
	    	}
	    	if(!empty($atime)){
	    		$atime = strtotime($atime);
	    		$atime = " AND UNIX_TIMESTAMP(fahuotime)<$atime";
	    	}else{
	    		$atime = "";
	    	}

			$username = !empty($username) ? " AND username='$username'" : "";

			$where = "WHERE '1=1' $fwhere $wwhere $i $a $itime $atime $username";
			
			$sql = "SELECT *,A.id as aid,A.dianhua as tel FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where} ORDER BY A.id DESC";
			$stdData = $this->model->query($sql);

			$xlsData = array();
			$n = 1;
		foreach ($stdData as $k=>$vo) {
		
			$xlsData[$k]['aid'] = $n;
			$xlsData[$k]['fahuotime'] = $vo['fahuotime'];
				// $xlsData[$k]['username'] = $vo['username'];
				// $xlsData[$k]['chanpin'] = $vo['chanpin'];		
			$xlsData[$k]['shouhuoren'] = $vo['shouhuoren'];
			$xlsData[$k]['address'] = $vo['address'];
			$xlsData[$k]['tel'] = cp_decode($vo['tel'],'Nan');
			$xlsData[$k]['wuliu'] = $vo['wuliu'];
			$xlsData[$k]['wuliudanhao'] = $vo['wuliudanhao'];
			$xlsData[$k]['daishoukuan'] = $vo['daishoukuan'];
				// $xlsData[$k]['pifajia'] = $vo['pifajia'];
			$xlsData[$k]['youfei'] = $vo['youfei'];

			// switch ($vo['isfahuo'])
			// {
	  //           case '0':
	  //           $vo['isfahuo'] = "未发货";
	  //         break;
	  //           case '1':
	  //           $vo['isfahuo'] = "已发货";
	  //         break;
	  //           case '2':
	  //           $vo['isfahuo'] = "退货";
	  //         break;
	  //           case '3':
	  //           $vo['isfahuo'] = "成功";
	  //         break;
	  //           default:
	  //           $vo['isfahuo'] = "未发货";
	  //         break;
   //      	}
			// $xlsData[$k]['isfahuo'] = $vo['isfahuo'];
			$n++;
			}
			$title = array(1=>array ("编号",'发货时间','收件人姓名','收件人地址','联系电话','快递','快递单号','代收货款','邮费'));
			$xls = new Excel('UTF-8', true, 'Excel报表');
			$xls->addArray($title);
			$xls->addArray($xlsData);
			$xls_name = date('Y-m-d_His');
			$xls->generateXML($xls_name);
			return;
		}
		$sql = "SELECT *,A.id as aid,A.dianhua as tel FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where} ORDER BY A.id DESC LIMIT {$limit}";
		$data = $this->model->query($sql);
		$sql_count = "SELECT count(*) as num FROM {$this->model->pre}order A LEFT JOIN {$this->model->pre}user B ON A.userid = B.id {$where}";
        $num = $this->model->query($sql_count);
        $count = $num[0]['num'];

        $post = explode(',', $this->config['post']);
        $this->assign('post',$post);
		$this->assign('data',$data);
		$this->assign('page', $this->page($url, $count, $listRows));
		$this->display();
	}

	public function kuaidi100(){
		$typeCom = in($_GET["com"]);//快递公司
		$typeNu = in($_GET["nu"]);  //快递单号

		$AppKey='47a97da5d9920829';//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
		//$url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=2&muti=1&order=asc';
		$url = 'http://www.kuaidi100.com/applyurl?key='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu;
		//请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
		$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';
		//优先使用curl模式发送数据
		if (function_exists('curl_init') == 1){
		  $curl = curl_init();
		  curl_setopt ($curl, CURLOPT_URL, $url);
		  curl_setopt ($curl, CURLOPT_HEADER,0);
		  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
		  $get_content = curl_exec($curl);
		  curl_close ($curl);
		}else{
		  include(CP_PATH."lib/snoopy.php");
		  $snoopy = new snoopy();
		  $snoopy->referer = 'http://www.google.com/';//伪装来源
		  $snoopy->fetch($url);
		  $get_content = $snoopy->results;
		}
		$data = "<iframe src='".$get_content."' width='580' height='380'><br/>'".$powered;

		$this->assign('data',$data);
		$this->display();
	}

    public function del(){
	    $id = intval($_GET[0]);
	    if(empty($id)){
	        $this->error("参数传递错误！");
	    }
	    $condition['id'] = $id;
	    if($this->model->table('order')->where($condition)->delete()){
	        $this->success("删除订单成功",__URL__);
	    }else{
	        $this->error("删除订单失败");
	    }
    }

    public function dels(){
	    $ids = $_POST['ids'];
	    if(empty($ids)){
	        $this->error("参数传递错误！");
	    }
	    foreach($ids as $id){
	        $this->model->table('order')->where("id=$id")->delete();
	    }
	    $this->success("删除成功",__URL__);
    }
}