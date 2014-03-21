<?php

class photoMod extends commonMod{
	public function index(){
        $url = __URL__ . '/index-{page}.html'; //分页基准网址
        $page = new Page();
        $listRows = 20; //每页显示记录
        $cur_page = $page->getCurPage($url);
        $limit_start = ($cur_page - 1) * $listRows;
        $limit = $limit_start . ',' . $listRows;

        $mid = $this->model_id();
        $count = $this->model->table('content')->where($condition)->count(); //总记录数

        $sql = "SELECT A.id,A.cid,A.title,A.addtime,B.id as bid,B.name FROM {$this->model->pre}content A LEFT JOIN {$this->model->pre}channel B ON A.cid = B.id WHERE A.mid={$mid} ORDER BY A.id DESC LIMIT {$limit}";
        $list = $this->model->query($sql);

        $this->assign('list',$list);
        $this->assign('page', $this->page($url, $count, $listRows));
		$this->display();
	}

	public function add(){
		if(empty($_POST['do'])){
			$cat = $this->getCat(); //获取格式化后的分类树
            $this->assign('mid', $this->model_id()); //模型ID
            $this->assign('cat', $cat); //分类
			$this->display();
			return;
		}
		$data = array();
		$data['cid'] = intval($_POST['cid']);
		$data['title'] =in($_POST['title']);
		$data['keywords'] = in($_POST['keywords']);
		$data['description'] = in($_POST['description']);
        $data['pic'] = in($_POST['pic']);
        $data['pics'] = in($_POST['pics']);
		$data['content'] = html_in($_POST['content']);
		$data['addtime'] = time();
		$data['edittime'] = time();
		$data['status'] = intval($_POST['status']);

        $data['mid'] = intval($_POST['mid']);

		// 验证数据
        if (empty($data['title'])) {
           $this->error("标题不能为空");
        }
        if (empty($data['cid'])) {
            $this->error("请选择栏目");
        }
        // if (empty($_POST['content'])) {
        //     $this->error("内容不能为空");
        // }

        // 数据库操作
        if($this->model->table('content')->data($data)->insert()){
            $this->success("发布图集成功",__APP__.'/article');
        }else{
            $this->error("发布图集失败");
        }
		$this->display();
	}

    public function edit(){
        if(empty($_POST['do'])){
        $id = intval($_GET[0]);
        if(empty($id)){
            $this->error("参数传递错误！");
        }

        $condition['id'] = $id;
        $info = $this->model->table('content')->where($condition)->find(); //获取当前分类信息
        $cat = $this->getCat(); //获取格式化后的分类树
        $this->assign('cat', $cat); //分类
        $this->assign('mid', $this->model_id()); //模型ID
        $this->assign('info', $info); //图集信息

        $this->display();
        return;
        }

        $data = array();
        $data['id'] = intval($_POST['id']);
        $data['cid'] = intval($_POST['cid']);
        $data['title'] =in($_POST['title']);
        $data['keywords'] = in($_POST['keywords']);
        $data['description'] = in($_POST['description']);
        $data['pic'] = in($_POST['pic']);
        $data['pics'] = in($_POST['pics']);
        $data['content'] = html_in($_POST['content']);
        $data['edittime'] = time();
        $data['status'] = intval($_POST['status']);

        $data['mid'] = intval($_POST['mid']);

        // 验证数据
        if (empty($data['title'])) {
           $this->error("标题不能为空");
        }
        if (empty($data['cid'])) {
            $this->error("请选择栏目");
        }
        // if (empty($_POST['content'])) {
        //     $this->error("内容不能为空");
        // }

        // 数据库操作
        $condition['id'] = $data['id'];
        if($this->model->table('content')->data($data)->where($condition)->update()){
            $this->success("修改图集成功",__URL__);
        }else{
            $this->error("修改图集失败");
        }
    }

    public function del(){
        $id = intval($_GET[0]);
        if(empty($id)){
            $this->error("参数传递错误！");
        }
        $condition['id'] = $id;
        if($this->model->table('content')->where($condition)->delete()){
            $this->success("删除图集成功",__URL__);
        }else{
            $this->error("删除图集失败");
        }
    }

    public function dels(){
        $ids = $_POST['ids'];
        if(empty($ids)){
            $this->error("参数传递错误！");
        }
        foreach($ids as $id){
            $this->model->table('content')->where("id=$id")->delete();
        }
        $this->success("删除成功",__URL__);
    }

    // 获取分类树，$id，分类id,$id=0，获取所有分类结构树
    public function getCat($id = 0)
    {
        require (CP_PATH . 'lib/Category.class.php'); //导入Category.class.php无限分类
        // 查询分类信息
        $data = $this->model->field('id,pid,name,mid')->table('channel')->select();
        // array('id','pid','name','cname'),字段映射，格式化后的分类名次问cname
        $cat = new Category(array('id', 'pid', 'name', 'cname')); //初始化无限分类
        return $cat->getTree($data, $id); //获取分类数据树结构
    }

    public function model_id()
    {
        $conditionmod['mark'] = "photo";
        $model = $this->model->table('adm_model',true)->where($conditionmod)->find();
        return $model['id'];
    }
}