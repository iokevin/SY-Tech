<?php 

class listMod extends commonMod{
	public function index(){

		$id=intval($_GET[0]);
		if(!empty($id)){
			$condition['pid'] = $this->get_pid();
			$list = $this->model->table('channel')->where($condition)->select();
			$ulist = $this->model->table('channel')->where("id = ".$condition['pid'])->find();
			$url=__URL__.'/index-'.$id.'-{page}.html';//分页基准网址         
			$page=new Page();                 
			$listRows=12;//每页显示的信息条数         
			$cur_page=$page->getCurPage($url);         
			$limit_start=($cur_page-1)*$listRows;         
			$limit=$limit_start.','.$listRows;
			//获取行数
			unset($condition);
			$condition['cid'] = $id;
			$condition['status'] = 1;  
			$count=$this->model->table('content')->where($condition)->count();
			$sql = "SELECT A.id,A.cid,A.title,A.keywords,A.description,A.pic,A.addtime,A.status,B.id as b_id,B.tpl_content FROM {$this->model->pre}content A LEFT JOIN {$this->model->pre}channel B ON A.cid = B.id WHERE A.cid = {$id} AND A.status = 1 ORDER BY A.id DESC LIMIT {$limit}";
			$info = $this->model->query($sql); //执行查询;

			$cname = $this->model->table('channel')->where("id = $id")->find();
			$tpl_list = str_replace("/","_",$cname['tpl_list']);
		}else{
			$this->error("参数错误");
		}

		$this->assign('list',$list);
		$this->assign('ulist',$ulist);
		$this->assign('cname',$cname);
		$this->assign('info',$info);
		$this->assign('page', $this->page($url, $count, $listRows));
		$this->display($tpl_list);
	}

	//获取父ID
	private function get_pid(){
		$id = intval($_GET[0]);
		$tem = $this->model->table('channel')->where("id = ".$id)->find();
		return $tem['pid'];
	}
}