<?php

class scrapMod extends commonMod{
	//获取碎片列表
    public function index()
    {
    	$url = __URL__ . '/index-{page}.html'; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;
        $count = $this->model->table('scrap')->where($condition)->count(); //总记录数

        $info =  $this->model->table('scrap')->order('id asc')->limit($limit)->select();

        $this->assign('info',$info);
        $this->assign('page', $this->page($url, $count, $listRows));
        $this->display();
    }

    //获取碎片内容
    public function info()
    {
        return $this->model->table('scrap')->where('id='.$id)->find();
    }

    //添加碎片内容
    public function add()
    {
    	if($_POST['do']){
    		$data = array();
    		$data['title'] = in($_POST['title']);
    		$data['sign'] = in($_POST['sign']);
    		$data['content'] = html_in($_POST['content']);

    		if(empty($data['sign'])){
    			$this->error("标识不能为空");
    		}
    		if($this->model->table('scrap')->data($data)->insert())
    		{
            	$this->success('添加碎片成功！',__URL__);
            } else {
            	$this->error('添加碎片失败！');
        }
    }
        $this->display();
    }

    //编辑碎片内容
    public function edit()
    {
    if($_POST['do']){
        $data = array();
        $condition['id'] = intval($_POST['id']);
    	$data['title'] = in($_POST['title']);
    	$data['sign'] = in($_POST['sign']);
    	$data['content'] = html_in($_POST['content']);

    	if(empty($data['sign'])){
    			$this->error("标识不能为空");
    		}
        if($this->model->table('scrap')->data($data)->where($condition)->update())
        {
        	$this->success('修改碎片成功！',__URL__);
        } else {
            $this->error('修改碎片失败！');
        }
    }
    $id = intval($_GET[0]);
    		if(empty($id)){
    			$this->error('参数传递错误！');
    		}
    unset($condition);
    $condition['id']=$id;
    $info = $this->model->table('scrap')->where($condition)->find();
    $this->assign('info',$info);
    $this->display();
    }

    //删除碎片内容
    public function del(){
        $id = intval($_GET[0]);
        if(empty($id)){
            $this->error("参数传递错误！");
        }
        $condition['id'] = $id;
        if($this->model->table('scrap')->where($condition)->delete()){
            $this->success("删除碎片成功",__URL__);
        }else{
            $this->error("删除碎片失败");
        }
    }

    public function dels(){
        $ids = $_POST['ids'];
        if(empty($ids)){
            $this->error("参数传递错误！");
        }
        foreach($ids as $id){
            $this->model->table('scrap')->where("id=$id")->delete();
        }
        $this->success("批量删除碎片成功",__URL__);
    }
}