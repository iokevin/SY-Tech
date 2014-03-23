<?php
class manageMod extends commonMod{
	public function index(){
		$userid = $_SESSION['uid'];

		$url = __URL__ . '/index?keyword='.$_GET['keyword'].'&amp;action='.$_GET[action].'&amp;do=yes&amp;page={page}'; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;
        
        if($_GET['do']){
        	$keyword = in($_GET['keyword']);
        	$action = in($_GET['action']);
        	// wf 未发货
        	// yf 已发货
        	// qs 签收
        	// th 退货
        	if(!empty($keyword)){
        		$keyword = " AND (shouhuoren like '%".$keyword."%' or wuliudanhao like '%".$keyword."%')";
        	}else{
        		$keyword = "";
        	}
        	if(!empty($action)){
        		switch ($action) {
        			case 'wf':
        				$action = ' AND isfahuo=0 ';
        				break;
        			case 'yf':
        				$action = ' AND isfahuo=1 ';
        				break;
        			case 'th':
        				$action = ' AND isfahuo=2 ';
        				break;
        			case 'qs':
        				$action = ' AND isfahuo=3 ';
        				break;
        			case 'kjs':
        				$action = ' AND isjiesuan=0 AND yingli<>0 AND jiesuanid=0 AND isfahuo>=1';
        				break;
        			case 'yjs':
        				$action = ' AND isjiesuan=1 AND yingli<>0 AND jiesuanid<>0 AND isfahuo>=1';
        				break;
        			default:
        				$action = '';
        				break;
        		}
        	}else{
        		$action = '';
        	}
        	$where = "userid=$userid $keyword $action";
        }else{
        	$where = "userid=$userid";
        }
       
		$data = $this->model->table('order')->where($where)->limit($limit)->order("id DESC")->select();
		$count = $this->model->table('order')->where($where)->count();

		$post = explode(',', $this->config['post']);
		$postapi = explode(',', $this->config['postapi']);
		$this->assign('post',$post);
		$this->assign('postapi',$postapi);
		$this->assign('data',$data);
		$this->assign('page', $this->page($url, $count, $listRows));
		$this->display();
	}

	public function add(){
		if($_POST['do']){
			$data['shouhuoren'] = in($_POST['shouhuoren']);
			$data['address'] = in($_POST['address']);
			$data['chanpin'] = in($_POST['chanpin']);
			$data['dianhua'] = cp_encode(in($_POST['dianhua']),'Nan');
			$data['canbao'] = in($_POST['canbao']);
			$data['duanxin'] = in($_POST['duanxin']);
			$data['daishoukuan'] = in($_POST['daishoukuan']);
			//$data['zhifufangshi'] = in($_POST['zhifufangshi']);
			$data['wuliu'] = in($_POST['wuliu']);
			$data['alicod'] = in($_POST['codlc']);
			$data['beizhu'] = text_in($_POST['beizhu']);
			$data['userid'] = $_SESSION['uid'];

			$msg=Check::rule(
			 	array(check::must($data['shouhuoren']),'收货人不能为空'),
			 	array(check::must($data['address']),'收货地址不能为空')
			 	);
			if($msg && strlen($msg)>1){
				$this->error($msg);
			}
			
			$condition['id'] = $data['userid'];
			if($user = $this->model->table('user')->where($condition)->find()){
		    	
		    	if($user['jh']==4){
		    		$this->error("服务器忙，请稍后再试");
		    	}
		    }else{
		    	$this->error("系统错误，请重试！");
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
		//$data = $get_content . '<br/>' . $powered;
		$data = "<iframe src='".$get_content."' width='580' height='380'><br/>'".$powered;
		
		$this->assign('data',$data);
		$this->display();
	}
	
	public function show(){
		$id = $_GET['id'];
		if(empty($id)){
			$this->error('参数错误');
		}
		$condition['id'] = $id;
		$condition['userid'] = $_SESSION['uid'];
		$data = $this->model->table('order')->where($condition)->find();
		$data['dianhua'] = cp_decode($data['dianhua'],'Nan');

		$this->assign('model',$this->model);
		$this->assign('data',$data);
		$this->display();
	}

}