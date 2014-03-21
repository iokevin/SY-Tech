<?php

class userMod extends commonMod{
	public function index(){
		$url = __URL__ . "/index?user=$_GET[user]&amp;do=yes&amp;page={page}"; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        if($_GET['do']){
        	$user = in($_GET['user']);
        	if(!empty($user)){
        		$where = "WHERE username like '%$user%' OR xingming like '%$user%'";
        	}else{
        		$where = "";
        	}
        	
        }
        // $sql = "SELECT *,A.id as aid FROM {$this->model->pre}user A LEFT JOIN {$this->model->pre}order B ON A.id = B.userid {$where} ORDER BY A.id DESC LIMIT {$limit}";
        // $data = $this->model->query($sql);
        // $sql_count = "SELECT count(*) as num FROM {$this->model->pre}user A LEFT JOIN {$this->model->pre}order B ON A.id = B.userid {$where}";
        // $num = $this->model->query($sql_count);
        // $count = $num[0]['num'];
        $sql = "SELECT * FROM {$this->model->pre}user {$where} ORDER BY id DESC LIMIT {$limit}";
        $data = $this->model->query($sql);
        $sql_count = "SELECT count(*) as num FROM {$this->model->pre}user {$where}";
        $num = $this->model->query($sql_count);
        $count = $num[0]['num'];

        $lv = explode(',', $this->config['lv']);
		$this->assign('lv',$lv);
        $this->assign('data',$data);
		$this->assign('page', $this->page($url, $count, $listRows));
		$this->assign('model',$this->model);
		$this->display();
	}

    public function edit(){
        if($_POST['do']){
            $id = in($_POST['id']);
            $data['username'] = in($_POST['username']);
            $data['xingming'] = in($_POST['xingming']);
            $password = in(trim($_POST['password']));
            if(!empty($password)){
            $data['password'] = substr(md5($password),8,16);
            }
            $data['xingbie'] = intval($_POST['xingbie']);
            $data['dianhua'] = in($_POST['dianhua']);
            $data['qq'] = in($_POST['qq']);
            $data['dizhi'] = in($_POST['dizhi']);
            $data['yinhang'] = text_in($_POST['yinhang']);
            $data['qita'] = text_in($_POST['qita']);
            $data['dengji'] = in($_POST['dengji']);
            $data['jh'] = in($_POST['jh']);

            $msg=Check::rule(
                array(check::must($data['username']),'用户名不能为空')
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

        $id = intval($_GET[0]);
        if(empty($id)){
            $this->error("参数传递错误！");
        }
        $condition['id'] = $id;
        $data = $this->model->table('user')->where($condition)->find();

        $lv = explode(',', $this->config['lv']);
        $this->assign('lv',$lv);
        $this->assign('data',$data);
        $this->display();
    }

    public function add(){
        if($_POST['do']){
            $data['username'] = in($_POST['username']);
            $data['xingming'] = in($_POST['xingming']);
            $password = in(trim($_POST['password']));
            if(!empty($password)){
            $data['password'] = substr(md5($password),8,16);
            }
            $data['xingbie'] = intval($_POST['xingbie']);
            $data['dianhua'] = in($_POST['dianhua']);
            $data['qq'] = in($_POST['qq']);
            $data['dizhi'] = in($_POST['dizhi']);
            $data['yinhang'] = text_in($_POST['yinhang']);
            $data['qita'] = text_in($_POST['qita']);
            $data['dengji'] = in($_POST['dengji']);
            $data['jh'] = in($_POST['jh']);

            $msg=Check::rule(
                array(check::must($data['username']),'用户名不能为空')
                );
            if($msg != true){
                $this->error($msg);
            }
        if($this->model->table('user')->data($data)->insert()){
            $this->success('用户资料添加成功',__URL__);
        }else{
            $this->error('用户资料添加失败',__URL__);
        }
    }
        $lv = explode(',', $this->config['lv']);
        $this->assign('lv',$lv);
        $this->display();
    }

    public function verify(){
        $url = __URL__ . "/verify?user=$_GET[user]&amp;do=yes&amp;page={page}"; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        if($_GET['do']){
            $user = in($_GET['user']);
            if(!empty($user)){
                $where = "WHERE jh='1' AND (username like '%$user%' OR xingming like '%$user%')";
            }else{
                $where = "WHERE jh='1'";
            }
            
        }else{
            $where = "WHERE jh='1'";
        }
        // $sql = "SELECT *,A.id as aid FROM {$this->model->pre}user A LEFT JOIN {$this->model->pre}order B ON A.id = B.userid {$where} ORDER BY A.id DESC LIMIT {$limit}";
        // $data = $this->model->query($sql);
        // $sql_count = "SELECT count(*) as num FROM {$this->model->pre}user A LEFT JOIN {$this->model->pre}order B ON A.id = B.userid {$where}";
        // $num = $this->model->query($sql_count);
        // $count = $num[0]['num'];
        $sql = "SELECT * FROM {$this->model->pre}user {$where} ORDER BY id DESC LIMIT {$limit}";
        $data = $this->model->query($sql);
        $sql_count = "SELECT count(*) as num FROM {$this->model->pre}user {$where}";
        $num = $this->model->query($sql_count);
        $count = $num[0]['num'];

        $lv = explode(',', $this->config['lv']);
        $this->assign('lv',$lv);
        $this->assign('data',$data);
        $this->assign('page', $this->page($url, $count, $listRows));
        $this->assign('model',$this->model);
        $this->display();
    }

    public function viewdd(){
        $id = in($_GET['id']);
        if(empty($id)){
            $this->error('参数错误');
        }
        $data = $this->model->table('order')->where("userid=".$id)->select();

        $this->assign('data',$data);
        $this->display();
    }

	public function del(){
	    $id = intval($_GET[0]);
	    if(empty($id)){
	        $this->error("参数传递错误！");
	    }
	    $condition['id'] = $id;
	    if($this->model->table('user')->where($condition)->delete()){
	        $this->success("删除用户成功",__URL__);
	    }else{
	        $this->error("删除用户失败");
	    }
    }
}