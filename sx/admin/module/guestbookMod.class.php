<?php

class guestbookMod extends commonMod{
	public function index(){
		$url = __URL__ . '/index-{page}.html'; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        $count = $this->model->table('guestbook')->where($condition)->count(); //总记录数

        $info = $this->model->table('guestbook')->where("1 = 1")->limit($limit)->select();

        $this->assign('info',$info);
        $this->assign('page', $this->page($url, $count, $listRows));
		$this->display();
	}

	public function see(){
		$id = intval($_GET[0]);
		if(empty($id)){
			$this->error("参数传递错误！");
		}
		$info = $this->model->table('guestbook')->where("id = ".$id)->find();

		$this->assign('info',$info);
		$this->display();
	}

	public function del(){
        $id = intval($_GET[0]);
        if(empty($id)){
            $this->error("参数传递错误！");
        }
        $condition['id'] = $id;
        if($this->model->table('guestbook')->where($condition)->delete()){
            $this->success("删除留言成功",__URL__);
        }else{
            $this->error("删除留言失败");
        }
    }

    public function dels(){
        $ids = $_POST['ids'];
        if(empty($ids)){
            $this->error("参数传递错误！");
        }
        foreach($ids as $id){
            $this->model->table('guestbook')->where("id=$id")->delete();
        }
        $this->success("删除成功",__URL__);
    }
}